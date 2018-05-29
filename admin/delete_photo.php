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
        redirect("photos.php");

    }

    $photo = Photo::find_by_id($_GET['id']);

    // if the photo is present delete the photo
    if ($photo) {

        $photo->delete_photo();
        $session->message("The photo {$photo->filename} has been deleted successfully");
        redirect("photos.php"); // refresh after deleting photo

    } else {

        redirect("photos.php");
    }


?>