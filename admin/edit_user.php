<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php") ?>

<?php 

if (!$session->is_signed_in()) {
    
    redirect("login.php"); // redirect to login page

}
?>

<?php

  if (empty($_GET['id'])) {
    
    redirect("users.php");

  }

  $user = User::find_by_id($_GET['id']);

  // UPDATED SUCCESSFULLY
  if (isset($_POST['update'])) {

      // check if we have an object and update the fields
      if ($user) {
            
          // assigning values to object property
          $user->username = $_POST['username'];
          $user->first_name = $_POST['first_name'];;
          $user->last_name = $_POST['last_name'];
          $user->password = $_POST['password'];

          if (empty($_FILES['user_image'])) {

            $user->save();
            redirect("users.php"); // redirect to users
            $session->message("The user has been updated"); // updates then redirects and display the user has been deleted on the user page

          } else {
            // image upload
            $user->set_file($_FILES['user_image']);
            $user->upload_photo();
            $user->save();
            $session->message("The user {$user->username} has been updated"); // set the message to appear


            // redirect("edit_user.php?id={$user->id}");
            redirect("users.php"); // redirect to users
          }

      }
  }
?>

<?php

// $users = user::find_all();


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
                            Edit
                            <small>Users</small>
                        </h1>

                        <!-- Image container -->
                        <div class="col-md-6 user_image_box">
                          
                            <a href="#" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $user->image_path_and_placeholder(); ?>" width="500" height="500" alt=""></a>
                        </div>

                        <!-- FORM FOR WHOLE EDIT PAGE -->
                        <form action="" method="post" enctype="multipart/form-data">

                        
                        <div class="col-md-6">

                          <!-- IMAGE-->
                           <div class="form-group">

                                <input type="file" name="user_image">
                                
                            </div>

                           <!-- FIRST NAME-->
                           <div class="form-group">

                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">

                           </div>

                          <!-- LAST NAME-->
                           <div class="form-group">

                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">

                           </div>

                             
                           <!-- USERNAME-->
                           <div class="form-group">

                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">

                           </div>

                           <!-- PASSWORD-->
                           <div class="form-group">

                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">

                           </div>

                           <!-- BUTTON-->
                           <div class="form-group">

                                <a id="user-id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>

                                <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">

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