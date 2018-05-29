<?php

/**
*  Session class - checks if the user is logged in
*/
class Session
{

	// PROPERTIES
	private $signed_in = false;
	public  $user_id;
	public $message;
	public $count;

	
	function __construct()
	{
		// automatically starting
		session_start(); 
		$this->check_the_login();
		$this->check_message(); // makes sure that there is no messages 
		$this->visitor_count();
	}

	// Tracking page view - counts the views
	public function visitor_count() {

		// check if session is set
		if (isset($_SESSION['count'])) {
			
			return $this->count = $_SESSION['count']++; // return session count +1 when visted or refreshed
			// $_SESSION - object property
		} else {

			return $_SESSION['count'] = 1;
		}
	}

	// function to output messages (Sets or Gets the message)
	public function message($msg="") {

		// checking to if its not empty
		if (!empty($msg)) {
			
			$_SESSION['message'] = $msg;

		} else {

			return $this->message;
		}
	}

	// check message method
	private function check_message() {

		// checking if the message session is set
		if (isset($_SESSION['message'])) {
			// if its set we assign the value to the msg property
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']); // unset when refreshing the page
		} else {

			$this->message = ""; // when its not set
		}
	}

	// GETTER
	public function is_signed_in() {

		return $this->signed_in;
	}

	public function login($user) {

		if ($user) {
			
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->signed_in = true; // the user is signed in
		}
	}

	public function logout() {

		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->signed_in = false;

	}

	// send properties
	private function check_the_login() {

		// if the user is active
		if (isset($_SESSION['user_id'])) {
			$this->user_id = $_SESSION['user_id']; // apply this
			$this->signed_in = true;
		} else {

			unset($this->user_id);
			$this->signed_in = false;
		}

	}
}

$session = new Session();
$message = $session->message(); // setting the message


?>