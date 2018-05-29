<?php include("includes/header.php"); ?>

<?php 

if (!$session->is_signed_in()) {
    
    redirect("login.php"); // redirect to login page

}
?>

<?php

$users = User::find_all();


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

                        <h1 class="page-header">Users</h1>

                        <p class="bg-success">
                            <!-- display message -->
                            <?php echo $message; ?>
                        </p>
                        <a href="add_user.php" class="btn btn-primary">Add User</a>



                        <div class="col-md-12">
                            
                            <!-- table hover - colour changes when hovering on the table -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- looping through the users table -->
                                <?php foreach ($users as $user ) : ?>

                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td><img class="admin-photo-thumbnail" src="<?php echo $user->image_path_and_placeholder(); ?>" alt=""></td>

                                        <td><?php echo $user->first_name; ?>
                                            
                                            <!-- delete, edit, view links-->
                                            <div class="action_links">

                                                <a href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                                                <a href="edit_user.php?id=<?php echo $user->id; ?>">Edit</a>
                                                
                                            </div>

                                        </td>
                                        
                                        <td><?php echo $user->last_name; ?></td>
                                        <td><?php echo $user->username; ?></td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table> <!-- end of table -->

                        </div>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->


        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>