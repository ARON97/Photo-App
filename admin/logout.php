<?php require_once("includes/header.php"); ?>

<?php

$session->logout(); // logout function in session
redirect("login.php"); // redirect the user back to login


?>