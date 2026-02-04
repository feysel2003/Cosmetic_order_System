<?php include('partials-front/menu.php'); ?>

<?php
// check whether catagory_id is passed or not
if (isset($_GET['catagory_id'])) {
    // category id is set and get the id
    $catagory_id = (int)$_GET['catagory_id'];
    // get the category title based on category id
    $sql = "SELECT title FROM tbl_catagory WHERE id = $catagory_id";
    // execute the query
    $res = mysqli_query($conn, $sql);
    // get the value from database
    $row = mysqli_fetch_assoc($res);
    // get the title
    $catagory_title = $row['title'];
} else {
    // Category Not Passed
    // redirect to home page
    header('location:' . SITEURL);
    exit();
}
?>

<!-- cosmotic sEARCH Section Starts Here -->
<section class="cosmotic-search text-center">
    <div class="container">
        <h2>Cosmotics on <a href="#" class="text-white">"<?php echo htmlspecialchars($catagory_title); ?>"</a></h2>
    </div>
</section>
<!-- cosmotic sEARCH Section Ends Here -->

<!-- cosmotic MEnu Section Starts Here -->
<section class="cosmotic-menu">
    <div class="container">
        <h2 class="text-center">Cosmotics Menu</h2>

        <div class="cosmotic-grid">
        <?php 
        // create sql query to get cosmotic based on selected category, now joining brand
        $sql2 = "
          SELECT c.*, b.brand_id, b.brand_name
          FROM tbl_comotic AS c
          LEFT JOIN brand AS b
            ON c.brand_id = b.brand_id
          WHERE c.catagory_id = $catagory_id
            AND c.active = 'Yes'
        ";
        // execute the query
        $res2 = mysqli_query($conn, $sql2);
        // count the row
        $count = mysqli_num_rows($res2);

        if ($count > 0) {
            // cosmotic is available
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $id           = $row2['id'];
                $title        = $row2['title'];
                $price        = $row2['price'];
                $description  = $row2['description'];
                $image_name   = $row2['image_name'];
                $brand_id     = $row2['brand_id'];
                $brand_name   = $row2['brand_name'] ?? 'Unknown';
        ?>
            <div class="cosmotic-menu-box">
                <div class="cosmotic-menu-img">
                    <?php 
                    // check whether the image is available or not 
                    if ($image_name == "") {
                        // image not available
                        echo "<div class='error'> Image Not available. </div>";
                    } else {
                        // image Available
                    ?>
                    <img src="<?php echo SITEURL; ?>image/cosmotic/<?php echo $image_name; ?>"
                         alt="<?php echo htmlspecialchars($title); ?>"
                         class="img-responsive img-curve">
                    <?php } ?>
                </div>

                <div class="cosmotic-menu-desc">
                    <h4><?php echo htmlspecialchars($title); ?></h4>
                    <!-- display the brand name -->
                    <p class="cosmotic-brand">Brand: <?php echo htmlspecialchars($brand_name); ?></p>
                    <p class="cosmotic-price">ETB. <?php echo number_format($price, 2); ?></p>
                    <p class="cosmotic-detail">
                        <?php echo htmlspecialchars($description); ?>
                    </p>
                    <br>

                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <a href="<?php 
                            echo SITEURL; 
                        ?>order.php?cosmotic_id=<?php echo $id; ?>&brand_id=<?php echo $brand_id; ?>"
                           class="btn btn-primary">Order Now</a>
                    <?php else: ?>
                        <a href="<?php echo SITEURL; ?>customer-login.php" class="btn btn-primary">Login to Order</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php
            }
        } else {
            // cosmotic is not available
            echo "<div class='error'> Cosmotic Not available At the Moment.</div>";
        }
        ?>     
        </div> 

        <div class="clearfix"></div>
    </div>
</section>
<!-- cosmotic Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
