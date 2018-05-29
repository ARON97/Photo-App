<?php require_once("includes/header.php"); ?>

<?php

// when the user is redirected
if ($session->is_signed_in()) {
	redirect("index.php");
}

if (isset($_POST['submit'])) {
	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	// Method to check database user
	$user_found = User::verify_user($username, $password);

	if ($user_found) {
		
		$session->login($user_found);
		redirect("index.php");
	} else {
		$the_message = "Your password or username is incorrect";
	}
} else {

	$the_message = "";
	$username = "";
	$password = "";
}

?>

<div class="col-md-4 col-md-offset-3">
	
	<!-- MSG to be displayed -->
	<h4 class="bg-danger"><?php echo $the_message; ?></h4>
	<!-- username -->
	<form id="login-id" action="" method="post">

	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo htmlentities($username); ?>">
	</div>

	<!-- password -->
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo htmlentities($password); ?>"> 	<!-- HTML entities - provides cleaning of data -->
	</div>

	<!-- submit button -->
	<div class="form-group">
		<input type="submit" name="submit" value="Submit" class="btn btn-primary">
	</div>
	</form>

</div>