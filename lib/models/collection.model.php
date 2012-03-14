<?php
/*
 *      collection.model
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
class Collection_Model extends Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_tags_like($data) {
		$like = "";
		if( is_array($data) ) {
			foreach( $data as $k => $v ) {
				$like .= " name ilike '$k' OR";
			}
		} else {
			$like = " name ilike '$data'";
		}
		$like = rtrim($like, "OR");
		$sth = $this->db->prepare("SELECT * FROM tags WHERE $like");
		$sth->execute();
		return $sth->fetchAll();
	}
	
	public function create_and_insert_tag($tag_name, $recipe_id) {
		$sth = $this->db->prepare("INSERT INTO tags (name), tag_mappings (tag_id, recipe_id) VALUES (:tag_name), (LAST_INSERT_ID(), :recipe_id)");
		$res = $sth->execute(array(
			':tag_name' => $tag_name,
			':recipe_id' => $recipe_id
		));
		if( !$res ) {
			return false;
		}
		return true;
	}
	
	public function insert_ingredients($recipe_id, $ingredientsArray) {
		$sql = "VALUES ";
		$prep = array();
		$prep[":recipe_id"] = $recipe_id;
		foreach( $ingredientsArray as $k => $v ) {
			$sql .= "(:recipe_id,";
			foreach( $v as $i => $d ) {
				$key = ":$i$k";
				$sql .= "$key,";
				$prep[$key] = $d;
			}
			$sql = rtrim($sql, ',') . "),";
		}
		$sql = rtrim($sql, ',');
		$sth = $this->db->prepare("INSERT INTO ingredients_list (recipe_id, ingredient, amount, unit) $sql");
		$res = $sth->execute($prep);
		if( !$res ) {
			return false;
		}
		return true;
	}
	
	public function insert_tags($recipe_id, $tagsArray) {
		$values = "";
		$select = "";
		foreach( $tagsArray as $tag ) {
			$values .= "('$tag'),";
			$select .= " name = '$tag' OR";
		}
		$select = rtrim($select, "OR");
		$values = rtrim($values, ",");

		$sth = $this->db->prepare("INSERT IGNORE INTO tags (name) VALUES $values");
		if( $sth->execute() ) {
			$sth = $this->db->prepare("SELECT id FROM tags WHERE $select");
			$sth->execute();
			$res = $sth->fetchAll();
			$mapping = "";
			foreach( $res as $tag ) {
				$mapping .= "('{$tag['id']}', '$recipe_id'),";
			}
			$mapping = rtrim($mapping, ",");
			$sth = $this->db->prepare("INSERT INTO tag_mappings (tag_id, recipe_id) VALUES $mapping");
			/* The problem now is that the mapping is duplicated each time this is run */
			return true;
		}
		return false;
	}
	
	public function insert_recipe($owner_id, $author_id, $name, $description, $is_private, $picture, $prep_directions, $cook_directions, $post_directions, $prep_time_hours, $prep_time_minutes, $cook_time_hours, $cook_time_minutes, $ingredientsArray, $tagsArray) {
		// information
		$sth = $this->db->prepare("INSERT INTO recipes (owner_id, author_id, name, description, is_private, picture, prep_directions, cook_directions, post_directions, prep_time_hours, prep_time_minutes, cook_time_hours, cook_time_minutes) VALUES ( :owner_id, :author_id, :name, :description, :is_private, :picture, :prep_directions, :cook_directions, :post_directions, :prep_time_hours, :prep_time_minutes, :cook_time_hours, :cook_time_minutes)");
		$res = $sth->execute(array(
			':owner_id' => $owner_id,
			':author_id' => $author_id,
			':name' => $name,
			':description' => $description,
			':is_private' => $is_private,
			':picture' => $picture,
			':prep_directions' => $prep_directions,
			':cook_directions' => $cook_directions,
			':post_directions' => $post_directions,
			':prep_time_hours' => $prep_time_hours,
			':prep_time_minutes' => $prep_time_minutes,
			':cook_time_hours' => $cook_time_hours,
			':cook_time_minutes' => $cook_time_minutes
		));
		if( !$res ) {
			return false;
		}
		
		$recipe_id = $this->db->lastInsertId();
		
		// ingredients
		if( !$this->insert_ingredients($recipe_id, $ingredientsArray) ) {
			return false;
		}
		
		if( !$this->insert_tags($recipe_id, $tagsArray) ) {
			return false;
		}

		return true;
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
