<?php include("includes/header.php"); ?>

<?php 

if (!$session->is_signed_in()) {
    
    redirect("login.php"); // redirect to login page

}
?>

<?php

    // instantiate User
    $user = new User();

    // ADDED SUCCESSFULLY
    if (isset($_POST['create'])) {

        // check if we have an object and update the fields
        if ($user) {
            
            // assigning values to object property
            $user->username = $_POST['username'];
            $user->first_name = $_POST['first_name'];;
            $user->last_name = $_POST['last_name'];
            $user->password = $_POST['password'];

            // image upload
            $user->set_file($_FILES['user_image']);

            $user->upload_photo();
            $session->message("The user {$user->username} has been added successfully");
            $user->save();
            redirect("users.php");

        }
    }

?>


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            


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
                        <h1 class="page-header">
                            Upload
                            <small>Users</small>
                        </h1>

                        <!-- FORM FOR WHOLE EDIT PAGE -->
                        <form action="add_user.php" method="post" enctype="multipart/form-data">


                        <div class="col-md-6 col-md-offset-3">

                          <!-- IMAGE-->
                           <div class="form-group">

                                <input type="file" name="user_image">
                                
                            </div>
                            
                           <!-- USERNAME-->
                           <div class="form-group">

                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control">

                           </div>

                           <!-- FIRST NAME-->
                           <div class="form-group">

                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control">

                           </div>

                          <!-- LAST NAME-->
                           <div class="form-group">

                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" >

                           </div>

                           <!-- PASSWORD-->
                           <div class="form-group">

                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" >

                           </div>

                           <!-- BUTTON-->
                           <div class="form-group">

                                <input type="submit" name="create" class="btn btn-primary pull-right" value="Add User" >

                           </div>

                        </div>


                </form> <!-- END OF PAGE FORM -->

                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->


        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>