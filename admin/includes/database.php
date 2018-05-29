<?php 

require_once("new_config.php");

/**
* 
*/
class Database
{
	public $connection;
	
	function __construct()
	{
		$this->open_db_connection(); // automatically sets up DB connection
	}

	public function open_db_connection() {


		// $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		// if an error is produced
		if ($this->connection->connect_errno) {
			die("Database connection failed" . $this->connect_errno);
		}

	}

	// query method
	public function query($sql) {

		$result = $this->connection->query($sql);
		$this->confirm_query($result); // to confirm the query

		return $result;
	}

	// eliminates some code
	private function confirm_query($result) {
		// check the result
		if (!$result) {
			die("Query failed " . $this->connection->error);
		}

	}

	// escape the strings - db class helper method, also called sanitzation or clean up method
	public function escape_string($string) {

		$escaped_string = $this->connection->real_escape_string($string);

		return $escaped_string;
	}

	public  function the_insert_id() {

		return $this->connection->insert_id;
		// mysqli_insert_id($this->connection);

	}


}

$database = new Database();
?>