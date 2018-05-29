<?php


class Db_object {

	public $errors = array(); // custom array for custom errors

	// Properties Associative Array
	public $upload_errors_array = array(

		// predefined PHP error keys
		UPLOAD_ERR_OK				=> "There is no error",
		UPLOAD_ERR_INI_SIZE			=> "The uploaded file exceeds the upload_max_filesize directory",
		UPLOAD_ERR_FORM_SIZE		=> "The uploaded file exceeds the MAX_FILE_SIZE directory",
		UPLOAD_ERR_PARTIAL			=> "The uploaded file was partially uploaded.",
		UPLOAD_ERR_NO_FILE			=> "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR		=> "Missing a temporary folder.",
		UPLOAD_ERR_CANT_WRITE		=> "Failed to write to disk.",
		UPLOAD_ERR_EXTENSION		=> "A PHP extension stopped the file upload."


	);

	public static function find_all() {

		// we cant use self:: so we replace it with static
		return static::find_by_query("SELECT * FROM " . static::$db_table . " "); 

	}

	public static function find_by_id($id) {
		global $database;

		$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
		
		return !empty($the_result_array) ? array_shift($the_result_array) : false;
	}

	// method whereby any function can call the query
	public static function find_by_query($sql) {

		global $database;

		$result_set = $database->query($sql);
		$the_object_array = array(); // an empty array that will be filled with records from the while loop

		// fetch from the users table
		while ($row = mysqli_fetch_array($result_set)) {
			$the_object_array[] = static::instantiation($row);
		}
		return $the_object_array;
	}

	// METHOD TO INSTANTIATE objects
	public static function instantiation($the_record) {

		$calling_class = get_called_class();

		$the_object = new $calling_class;

		// looping through the db records and assigns them
		foreach ($the_record as $the_attribute => $value) {
			
			// if the object has an attribute
			if ($the_object->has_the_attribute($the_attribute)) {

				$the_object->$the_attribute = $value;

			}
		}

        return $the_object;
	}


	private function has_the_attribute($the_attribute) {

		$object_properties = get_object_vars($this); // returns all the properties of this class
		// check if the key exist in the property
		return array_key_exists($the_attribute, $object_properties);

	}

	protected function properties() {

		$properties = array();

		// looping through the objects
		foreach (static::$db_table_fields as $db_field) {
			// check to see if the property exists if it does we assign the property to $properties = array();
			if (property_exists($this, $db_field)) {

				$properties[$db_field] = $this->$db_field;

			}
		}

		return $properties;
	}

	// escape method
	protected function clean_properties() {
		global $database;

		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			
			// escape and assign to the array
			$clean_properties[$key] = $database->escape_string($value);

		}

		return $clean_properties;

	}

	public function save() {

		return isset($this->id) ? $this->update() : $this->create(); // if the id exists update the user else create a new one

	}

	public function create() {

		global $database;

		$properties = $this->clean_properties(); // returns all the object properties

		$sql = "INSERT INTO " . static::$db_table . "(" . implode(",",array_keys($properties)) . ")"; // the first parameter seperates the keys using ","
		$sql .= "VALUES ('". implode("','",array_values($properties)) ."')";
		

		if ($database->query($sql)) {

			$this->id = $database->the_insert_id();
			return true;
			
		} else {

			return false;
		}

	} // end of create method

	public function update() {
		global $database;

		$properties = $this->clean_properties(); // returns all the object properties and escaping them

		$properties_pairs = array();// creating another array

		// pulling out the keys and values
		foreach ($properties as $key => $value) {
			$properties_pairs[] = "{$key}='{$value}'";
		}

		$sql = "UPDATE " . static::$db_table . " SET ";
		$sql .= implode(", ", $properties_pairs);
		$sql .= " WHERE id= " . $database->escape_string($this->id);

		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;

	} // end of update method

	public function delete() {
		global $database;

		$sql = "DELETE FROM " . static::$db_table . " ";
		$sql .= "WHERE id=" . $database->escape_string($this->id);
		$sql .= " LIMIT 1";

		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;

	}

	// method to count records in database
	public static function count_all() {

		global $database;

		$sql = "SELECT count(*) FROM " . static::$db_table;
		$result_set = $database->query($sql);
		$row = mysqli_fetch_array($result_set);

		return array_shift($row);
		 
	}

}




?>