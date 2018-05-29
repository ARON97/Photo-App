<?php


/**
* 
*/
class User extends Db_object
{
	
	// PROPERTIES
	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	public $upload_directory = "images";
	public $image_placeholder = "http://place-hold.it/400*400&text=image";


	

	// SAVE METHOD
	public function upload_photo() { 
		// if the error is not empty return false
		if (!empty($this->errors)) {
			
			return false;
		}
		// check if the file or tmp path is empty
		if (empty($this->user_image) || empty($this->tmp_path)) {

			$this->errors[] = "The file is not available";
			return false;

		}

		// TARGET PATH
		$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

		// check if the file exists or the target path
		if (file_exists($target_path)) {
				
			$this->errors[] = "The file {$this->user_image} already exists";
			return false;
		}

		// move_uploaded_file - moving the file to a destination
		if (move_uploaded_file($this->tmp_path, $target_path)) {	

				unset($this->tmp_path);
				return true;

		} else {

			$this->errors[] = "The file directory does not have permissions";
			return false;
		}

	}


	public function image_path_and_placeholder() {

		// if the user image is empty then return image placeholder else return upload directory and user image
		return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;

	}
	public static function verify_user($username, $password) {

		global $database;

		// sanitize or clean up username and password
		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		// saving the query into the variable
		$sql = "SELECT * FROM " . self::$db_table . " WHERE "; //
		$sql .= "username = '{$username}'" ; 	// breaking down the statement using .=
		$sql .= " AND password = '{$password}' "; // 
		$sql .= " LIMIT 1";

		$the_result_array = self::find_by_query($sql);
		// tenary syntax
		return !empty($the_result_array) ? array_shift($the_result_array) : false;
	}

	// method to update the user image only
	public function ajax_save_user_image($user_image, $user_id) {

		global $database;

		$user_image 	= $database->escape_string($user_image);
		$user_id 		= $database->escape_string($user_id);
		
		$this->user_image 	= $user_image;
		$this->id			= $user_id;

		$sql 	= "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
		$sql 	.= " WHERE id = {$this->id}";
		$update_image = $database->query($sql);

		echo $this->image_path_and_placeholder();

	}

	// Delete method from the Database and server
	public function delete_photo() {

		// if the delete method (delete() - method in db_object) is able to delete 
		if ($this->delete()) {
			
			// delete the file
			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

			// unlink - predifined function in PHP to delete the photo
			return unlink($target_path) ? true : false;
		} else {

			return false;
			
		}
	}

} // end of user class

?>