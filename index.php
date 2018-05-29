<?php include("includes/header.php"); ?>

<?php 

// Pagination Variables
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 12; // items to display per page

$items_total_count = Photo::count_all(); // counts all the records

// end of Pagination Variables

$paginate = new Paginate($page, $items_per_page, $items_total_count);

// custom sql with variables to find specific photos regarding pagination class
$sql = "SELECT * FROM photos ";
$sql .= "LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";
$photos = Photo::find_by_query($sql);

// $photos = Photo::find_all();


?>

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-12">

            <div class="thumbnails row">

                <?php foreach ($photos as $photo): ?>  

                    <div class="col-xs-6 col-md-3">
                            
                        <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                                
                            <img class="home_page_photo img-responsive " src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                        </a>

                    </div>

                <?php endforeach; ?>
         
            </div>

            <!-- Pagination -->
            <div class="row">
                
                <ul class="pagination">

                    <?php 

                        // check for navigation
                        if ($paginate->page_total() > 1) {
                            
                            // test if paginate has next
                            if ($paginate->has_previous()) {
                                
                                echo "<li class='next'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                            }

                            // Paginate indication and looping
                            for ($i=1; $i <= $paginate->page_total(); $i++) { 
                                
                                // check the active link
                                if ($i == $paginate->current_page) {
                                    
                                    echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                                } else {
                                    // when its not active
                                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";

                                }
                            }

                            if ($paginate->has_next()) {
                                
                                echo "<li class='previous'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                            }
                        }

                    ?>
   
                </ul>

            </div>

        </div>




            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4">
 -->
            
                 <?php /*include("includes/sidebar.php");*/ ?>

    </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>
