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
		redirect('collection/my_recipes');
	}
	
	public function my_recipes() {
		
		$data = array();
		$data['recipes'] = $this->model->get_recipes_small(Session::get('id'));
		
		$this->view->load('collection/my_recipes', $data);
	}
	
	public function new_recipe() {
		$data = array();
		include( 'lib/libraries/upload.class.php' );
		if( isset( $_POST['save'] ) ) {
			$data['errors'] = array();
			
			$author_id = Session::get('id');
			$owner_id = $author_id;
			
			// validate form
			$name = cleaninput($_POST['name']);
			if( empty( $name ) ) {
				$data['errors'][] = array( 'title' => 'Invalid Input', 'text' => '`Name` cannot be blank' );
			}
			
			$description = cleaninput($_POST['description']);
			if( empty( $description ) ) {
				$data['errors'][] = array( 'title' => 'Invalid Input', 'text' => '`Description` cannot be blank' );
			}
			
			$is_private = isset( $_POST['is_private'] ) && $_POST['is_private'] == '1' ? 1 : 0;


			$prep_directions = cleaninput($_POST['prep-directions']);
			$cook_directions = cleaninput($_POST['cook-directions']);
			$post_directions = cleaninput($_POST['post-directions']);
			
			// sanitized not checked.
			$prep_time_hours = isset($_POST['prep-hours']) && is_numeric($_POST['prep-hours']) ? $_POST['prep-hours'] : 0;
			$prep_time_minutes = isset($_POST['prep-minutes']) && is_numeric($_POST['prep-minutes']) ? $_POST['prep-minutes'] : 0;
			$cook_time_hours = isset($_POST['cook-hours']) && is_numeric($_POST['cook-hours']) ? $_POST['cook-hours'] : 0;
			$cook_time_minutes = isset($_POST['cook-minutes']) && is_numeric($_POST['cook-minutes']) ? $_POST['cook-minutes'] : 0;


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
			
			// nice
			list($ingredients, $amounts, $units) = array($_POST['ingredient'], $_POST['ingredient-amount'], $_POST['ingredient-unit']);
			$ingredientsArray = array();
			foreach( $ingredients as $k => $ingredient) {
				$ingredientsArray[] = array('ingredient' => $ingredient, 'amount' => $amounts[$k], 'unit' => $units[$k] );
			}
			
			$tagsArray = explode(' ', cleaninput($_POST['tags']));
			
			if( !$this->model->insert_recipe(
											$owner_id,
											$author_id,
											$name,
											$description,
											$is_private,
											$picture,
											$prep_directions,
											$cook_directions,
											$post_directions,
											$prep_time_hours,
											$prep_time_minutes,
											$cook_time_hours,
											$cook_time_minutes,
											$ingredientsArray,
											$tagsArray
										)) {
				$data['errors'][] = array( 'title' => 'Insert Error', 'text' => 'Unable to insert records to database.' );
			}
			
			if( empty($data['errors']) ) {
				redirect('collection');
			}
			
		}
		$data['scripts'] = array( '/assets/js/recipe.js' );
		$this->view->load('collection/recipe', $data);
	}
}
