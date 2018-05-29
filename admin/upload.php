<?php include("includes/header.php"); ?>
<?php 

if (!$session->is_signed_in()) {
    
    redirect("login.php"); // redirect to login page

}
?>

<?php 

$message = ""; // declaring the variable so that the undeclared error is not produced
if (isset($_FILES['file'])) {

    $photo = new Photo();
    $photo->title = $_POST['title'];
    $photo->set_file($_FILES['file']);

    // check to see if its saved
    if ($photo->save()) {
        
        $message = "Photo uploaded successfully";

    } else {

        $message = join("<br>", $photo->errors);          
    }
    
}

?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <?php include("includes/top_nav.php"); ?>

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php include("includes/side_nav.php"); ?>


    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            
            <div class="col-lg-12">

                <h1 class="page-header">Upload</h1>
                        
                    <div class="row">

                        <div class="col-md-6">

                            <!-- display the message --> 
                            <?php echo $message ?>

                            <form action="upload.php" method="post" enctype="multipart/form-data">
                            
                                <!-- Title -->
                                <div class="form-group">

                                    <input type="text" name="title" class="form-control">

                                </div>

                                <!-- File Upload -->
                                <div class="form-group">

                                    <input type="file" name="file">
                                
                                </div>

                                <input type="submit" name="submit" value="Upload">

                            </form> <!-- End of form -->

                        </div> <!-- End of class="col-md-6" -->

                    </div><!-- End of row -->

                    <div class="row">
                        <!-- div with 12 columns -->
                        <div class="col-lg-12">

                            <form action="upload.php" class="dropzone"></form>

                        </div>
                    </div>

                </div>
            </div>
        <!-- /.row -->
        </div>
    <!-- /.container-fluid -->
    </div>
<!-- /#page-wrapper -->
<?php include("includes/footer.php"); ?>