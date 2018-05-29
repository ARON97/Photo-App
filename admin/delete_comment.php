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
        redirect("comments.php");

    }

    $comment = Comment::find_by_id($_GET['id']);

    // if the photo is present delete the photo
    if ($comment) {

        $comment->delete();
        $session->message("The comment with id {$comment->id} has been deleted");
        redirect("comments.php"); // refresh after deleting photo

    } else {

        redirect("comments.php");
    }


?>