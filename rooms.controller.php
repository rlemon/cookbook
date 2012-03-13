<?php

class Rooms extends Controller {
	public function __construct() {
		parent::__construct();
		Session::init();
		if(!Session::get('logged_in')) {
			redirect('auth/login');
		}
	}
	
	public function index() {
		$this->view->load('rooms/index');
	}
	
	public function create() {
		$errors = array();
		
		if( isset( $_POST['create'] ) ) {
			$title = cleanInput($_POST['title']);
			$description = cleanInput($_POST['description']);
			$owner_id = Session::get('id');
			$logo_href = '';
			if( isset($_FILES['logo']) ) {
				$target_path = 'uploads/' . basename( $_FILES['logo']['name']); 
				if(!move_uploaded_file($_FILES['logo']['tmp_name'], $target_path)) {
					$errors[] = array('title' => 'Server Error', 'text' => 'Unable to upload logo image. ' . $target_path);
				} else {
					$logo_href = $target_path;
				}
			}
			
			if(!$this->model->roomtitle_exists($title)) {
				if(!$this->model->create_room($title, $description, $owner_id, $logo_href)) {
					$errors[] = array('title' => 'Server Error', 'text' => 'Unable to create new room.' . $title . $description . $owner_id . $logo_href);
				} else {
					redirect('rooms/index'); // redirect to new room once exists
				}
			} else {
				$errors[] = array('title' => 'Invalid Input', 'text' => 'Room title exists!');
			}
			
		}
		
		if( !empty($errors) ) {
			$data['errors'] = $errors;
		}
		
		$this->view->load('rooms/create_new_room', $data);
	}

}
