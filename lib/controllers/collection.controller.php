<?php
/*
 *      collection.controller
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
class Collection extends Controller {
	
	public function __construct() {
		parent::__construct();
		Session::init();
		if(!Session::get('logged_in')) {
			redirect('auth/login');
		}
	}
	
	public function index() {
		$this->view->load('collection/index');
	}
	
	public function my_recipes() {
		$this->view->load('collection/index');
	}
	
	public function new_recipe() {
		$data = array();
		include( 'lib/libraries/upload.class.php' );
		if( isset( $_POST['save'] ) ) {
			$data['errors'] = array();
			// validate form
			$author_id = Session::get('id');
			$owner_id = $author_id;
			$name = cleaninput($_POST['name']);
			if( empty( $name ) ) {
				$data['errors'][] = array( 'title' => 'Invalid Input', 'text' => '`Name` cannot be blank' );
			}
			$description = cleaninput($_POST['description']);
			if( empty( $description ) ) {
				$data['errors'][] = array( 'title' => 'Invalid Input', 'text' => '`Description` cannot be blank' );
			}
			$is_private = isset( $_POST['is_private'] ) && $_POST['is_private'] == '1' ? 1 : 0;

			$picture = '';
			if( isset( $_FILES['picture'] ) ) {
				$ihandle = new upload($_FILES['picture']);
				if( $ihandle->uploaded ) {
					$ihandle->file_new_name_body = md5( $_FILES['picture']['name'] ); // needs salt? picture names will append incremental numerics if exist.
					$ihandle->image_resize = true;
					$ihandle->image_x = 260;
					$ihandle->image_y = 180;
					$ihandle->file_max_size = 1024 * 1024; // 1MB
					$ihandle->image_ratio_crop = true;
					$handle->allowed = array('image/png','image/jpeg','image/gif');
					$ihandle->process('uploads/');
					if( $ihandle->processed ) {
						$picture = $ihandle->file_dst_pathname;
					} else {
						$data['errors'][] = array( 'title' => 'Upload Error', 'text' => $ihandle->error );
					}
				}
			}
			
			$prep_directions = cleaninput($_POST['prep-directions']);
			$cook_directions = cleaninput($_POST['cook-directions']);
			$post_directions = cleaninput($_POST['post-directions']);
			
			$prep_time_hours = isset($_POST'prep-hours']) && is_numeric($_POST['prep-hours']) ? $_POST['prep-hours'] : 0;
			$prep_time_minutes = isset($_POST'prep-minutes']) && is_numeric($_POST['prep-minutes']) ? $_POST['prep-minutes'] : 0;
			$cook_time_hours = isset($_POST'cook-hours']) && is_numeric($_POST['cook-hours']) ? $_POST['cook-hours'] : 0;
			$cook_time_minutes = isset($_POST'cook-minutes']) && is_numeric($_POST['cook-minutes']) ? $_POST['cook-minutes'] : 0;
			
			
			// ingredients
			// tags
		}
		$data['scripts'] = array( '/assets/js/recipe.js' );
		$this->view->load('collection/recipe', $data);
	}
}
