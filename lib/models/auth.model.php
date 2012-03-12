<?php
/*
 *      auth.model
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
class Auth_Model extends Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function username_exists($username) {
		$sth = $this->db->prepare("SELECT * FROM user_profiles WHERE username = :username");
		$sth->execute(array(
			':username' => $username
		));
		return count( $sth->fetchAll() ) > 0;
	}
	
	public function check_openid($openid) {
		$sth = $this->db->prepare("SELECT * FROM user_openids WHERE openid = :openid");
		$sth->execute(array(
			':openid' => $openid
		));
		$res = $sth->fetchAll();
		if( count($res) > 0 ) {
			return $res[0];
		}
		return false;
	}
	
	public function login_user($identity) {
		$sth = $this->db->prepare("SELECT * FROM user_profiles WHERE id = :identity");
		$sth->execute(array(
			':identity' => $identity
		));
		$res = $sth->fetchAll();
		if( count($res) > 0 ) {
			foreach( $res[0] as $k => $v ) {
				Session::set($k, $v);
			}
			Session::set('logged_in', 1);
			return true;
		}
		return false;
	}
	
	public function logout_user($id) {
		$sth = $this->db->prepare("UPDATE user_profiles SET last_active = :last_active WHERE id = :id");
		$res = $sth->execute(array(
			':last_active' => date('r'),
			':id' => $id
		));
		if( $res ) {
			Session::destroy();
			return true;
		}
		return false;
	}
	
	public function create_userprofile($username, $email, $fullname = "", $dob = "", $gender = "", $postcode = "", $country = "", $language = "", $timezone = "") {
		$sth = $this->db->prepare("INSERT INTO user_profiles (username, email, fullname, dob, gender, postcode, country, language, timezone, creation_date, last_active) VALUES (:username, :email, :fullname, :dob, :gender, :postcode, :country, :language, :timezone, :creation_date, :last_active)");
		$res = $sth->execute(array(
			':username' => $username,
			':email' => $email,
			':fullname' => $fullname,
			':dob' => $dob,
			':gender' => $gender,
			':postcode' => $postcode,
			':country' => $country,
			':language' => $language,
			':timezone' => $timezone,
			':creation_date' => date('r'),
			':last_active' => date('r')
		));
		if( $res ) {
			return $this->db->lastInsertId();
		}
		return false;
	}

	public function register_openid($identity, $openid) {
		$sth = $this->db->prepare("INSERT INTO user_openids (identity, openid) VALUES (:identity, :openid)");
		$res = $sth->execute(array(
			':identity' => $identity,
			':openid' => $openid
		));
		return $res;
	}
}
