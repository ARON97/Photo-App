<?php include("includes/init.php"); ?>

<?php 

if (!$session->is_signed_in()) {
    
    redirect("login.php"); // redirect to login page

}
?>

<?php
   
    // if the $_GET['photo_id'] is empty
    if (empty($_GET['id'])) {
        // using the function to redirect
        redirect("users.php");

    }

    $user = User::find_by_id($_GET['id']);

    // if the photo is present delete the photo
    if ($user) {

        $session->message("The user {$user->username} has been deleted successfully"); // deletes then redirects and display the user has been deleted on the user page
        $user->delete_photo();
        redirect("users.php"); // refresh after deleting photo

    } else {

        redirect("users.php");
    }


?>