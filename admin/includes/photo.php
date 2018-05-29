<?php

class Photo extends Db_object {

	// CLASS PROPERTIES
	protected static $db_table = "photos";
	protected static $db_table_fields = array('id' ,'title' ,'caption', 'description', 'filename', 'alternate_text', 'type', 'size', 'date_time');
	public $id;
	public $title;
	public $caption;
	public $description;
	public $filename;
	public $alternate_text;
	public $type;
	public $size;
	public $date_time;

	public $tmp_path; // path used to move images to permenant path

	public $upload_directory = "images";

	// SET FILE METHOD. this is passing $_FILES['upload_file'] as an argument
	public function set_file($file) {

		// error checking - check if the file is empty or it is not a file or it is not an array
		if (empty($file) || !$file || !is_array($file)) {
			// is_array used to check weather a variable is an array or not

			$this->errors[] = "There was no file uploaded";
			return false;

		} elseif ($file['error'] != 0) {

			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;

		} else {

			// basename returns filename component of path. Only returns the file name with type
			$this->filename = basename($file['name']); 
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
			$this->date_time = date('Y-m-d H:i:s', filemtime($this->tmp_path));
		}	
	}

	// DYNAMIC IMAGE PATH - not breaking any links related to our pictures
	public function picture_path() {

		return $this->upload_directory.DS.$this->filename;
	}

	// SAVE METHOD
	public function save() {

		// check if the id is present else create a new one
		if ($this->id) {
			
			$this->update(); // method in the Db_objects

		} else {
			// if the error is not empty return false
			if (!empty($this->errors)) {
				
				return false;
			}
			// check if the file or tmp path is empty
			if (empty($this->filename) || empty($this->tmp_path)) {

				$this->errors[] = "The file is not available";
				return false;

			}

			// TARGET PATH
			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;



			// check if the file exists or the target path
			if (file_exists($target_path)) {
					
				$this->errors[] = "The file {$this->filename} already exists";
				return false;
			}

			// move_uploaded_file - moving the file to a destination
			if (move_uploaded_file($this->tmp_path, $target_path)) {
				// if it was able to be created
				if ($this->create()) {
						
					unset($this->tmp_path);
					return true;

				}

			} else {

				$this->errors[] = "The file directory does not have permissions";
				return false;
			}

		}

	}

	// Delete method from the Database and server
	public function delete_photo() {

		// if the delete method (delete() - method in db_object) is able to delete 
		if ($this->delete()) {
			
			// delete the file
			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->picture_path();

			// unlink - predifined function in PHP to delete the photo
			return unlink($target_path) ? true : false;
		} else {

			return false;
			
		}
	}

	// retrieves data from the server and displays it
	public static function display_sidebar_data($photo_id) {

		$photo = Photo::find_by_id($photo_id); // finding the record (photo id)

		$output	= "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}' ></a> ";
		// using the photo variables to display the object properties
		$output	.= "<p>{$photo->filename}</p>";
		$output	.= "<p>{$photo->type}</p>";
		$output	.= "<p>{$photo->size}</p>";

		echo $output;
	}


	
} // END OF CLASS




?>
