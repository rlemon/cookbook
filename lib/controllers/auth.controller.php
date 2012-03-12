<?php
/*
 *      auth.controller
 *      
 *      Copyright 2012 Robert Lemon <rob.lemon@gmail.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 *      
 *      
 */
class Auth extends Controller {
	
	public function __construct() {
		parent::__construct();
		Session::init();
	}
	
	public function login() {
		$this->view->load('auth/openid_login');
	}
	
	public function logout() {
		if( $this->model->logout_user(Session::get('id')) ) {
			redirect('auth/login');
		} else {
			echo "error";
		}
	}
	
	public function register() {
		$data = array();
		if( isset($_POST['register']) ) {
			$openid = $_POST['identity'];
			$username = cleanInput($_POST['username']);
			$email = cleanInput($_POST['email']);
			$fullname = cleanInput($_POST['fullname']);
			$gender = cleanInput($_POST['gender']);
			$country = cleanInput($_POST['country']);
			$postcode = cleanInput($_POST['postcode']);
			$language = cleanInput($_POST['language']);
			$timezone = cleanInput($_POST['timezone']);
			$errors = array();
			if( is_numeric($_POST['dob-year']) ) {
				$dob = $_POST['dob-month'] . '/' . $_POST['dob-day'] . '/' . $_POST['dob-year'];
			} else {
				$errors[] = array('title' => 'Invalid Input', 'text' => 'Year must be numeric');
				$data['errors'] = $errors;
				$this->view->load('auth/register', $data);
				return;
			}
			$identity = $this->model->create_userprofile($username, $email, $fullname, $dob, $gender, $postcode, $country, $language, $timezone);
			if( !$identity ) {
				$errors[] = array('title' => 'Error', 'text' => 'Could not generate user profile');
				$data['errors'] = $errors;
				$this->view->load('auth/register', $data);
				return;
			}
			if( $this->model->register_openid($identity, $openid) ) {
				if( $this->model->login_user($identity) ) {
					redirect('dashboard');
				}
				$errors[] = array('title' => 'Error', 'text' => 'Could not login user' );
			} else {
				$errors[] = array('title' => 'Error', 'text' => 'Could not register openid' );
			}
		}
		if( !empty($errors) ) {
			$data['errors'] = $errors;
		}
		$this->view->load('auth/register', $data);
	}
	
	public function openid() {
		$openid = new LightOpenID($_SERVER['SERVER_NAME']);
		if(!$openid->mode) {
			if(isset($_POST['google'])) {
				$openid->identity = 'https://www.google.com/accounts/o8/id';
				$openid->required = array('namePerson/friendly', 'contact/email');
				$openid->optional = array('namePerson', 'birthDate', 'person/gender', 'contact/postalCode/home', 'contact/country/home', 'pref/language', 'pref/timezone');
				header('Location: ' . $openid->authUrl());
			}
		} else if( $openid->mode === 'cancel' ) {
			echo 'User has canceled authentication!';
		} else {
			if( $openid->validate() ) {
				$data = $openid->getAttributes();
				/* check for first login, if no record exists create one and force user to input remaining data. 
				 * If a login does exist create the session and redirect the user to their dashboard. */
				$identity = $this->model->check_openid( $openid->identity );
				if( !$identity ) {
					redirect('auth/register/' . urlencode_array($data) . '&identity=' . urlencode($openid->identity) );
				} else {
					if( !$this->model->login_user($identity['identity']) ) {
						die("could not login user");
					} else {
						redirect('dashboard');
					}
				}
				
			} else {
				echo "Login with '{$openid->identity}' failed";
			}
		}
	}
	
}
