<?php require("init.php");

$user 	= new User();

// check if image name is set
if (isset($_POST['image_name'])) {
	
	$user->ajax_save_user_image($_POST['image_name'], $_POST['user_id']); // catching POST supper globals
}

// Detect the photo id
if (isset($_POST['photo_id'])) {
	
	Photo::display_sidebar_data($_POST['photo_id']); // calling the static method from the photo class and passing in the photo id
}


?>