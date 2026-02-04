<?php include('partials-front/menu.php'); ?>

<!-- cosmotic sEARCH Section Starts Here -->
<section class="cosmotic-search text-center">
    <div class="container">
        
        <form action="<?php echo SITEURL; ?>cosmotic-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for cosmotic.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- cosmotic sEARCH Section Ends Here -->

<?php 
if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}

if (isset($_SESSION['login-msg'])) {
    echo $_SESSION['login-msg'];
    unset($_SESSION['login-msg']);
}
?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore cosmotics</h2>

        <div class="category-grid"> <!-- Grid wrapper added -->

            <?php 
            // create sql query to display category from database
            $sql = "SELECT * FROM tbl_catagory WHERE active='Yes' AND featured='Yes' LIMIT 6";
            // execute the query
            $res = mysqli_query($conn, $sql);
            // count rows to check whether the category is available or not
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                // categories Available
                while ($row = mysqli_fetch_assoc($res)) {
                    // get the value like id, title, image_name
                    $id         = $row['id'];
                    $title      = $row['title'];
                    $image_name = $row['image_name'];
            ?>
            <a href="<?php echo SITEURL; ?>category-cosmotic.php?catagory_id=<?php echo $id; ?>">
                <div class="box-3">
                    <?php 
                    // check whether image is available or not 
                    if ($image_name == "") {
                        // display message
                        echo "<div class='error'>Image Not Available.</div>";
                    } else {
                        // image available
                    ?>
                    <img src="<?php echo SITEURL; ?>image/catagory/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                    <?php } ?>
                    <h3 class="float-text text-white"><?php echo htmlspecialchars($title); ?></h3>
                </div>
            </a>
            <?php
                }
            } else {
                // categories is not available
                echo "<div class='error'>Category Not Added.</div>";
            }
            ?>

        </div> <!-- End of grid wrapper -->

    </div>
</section>

<!-- Categories Section Ends Here -->

<!-- cosmotic MEnu Section Starts Here -->
<section class="cosmotic-menu">
    <div class="container">
        <h2 class="text-center">Cosmotic Menu</h2>

        <div class="cosmotic-grid">
        <?php 
        // getting cosmotic from database that are active and featured
        // now join brand to get its name and id
        $sql2 = "
          SELECT c.*, b.brand_id, b.brand_name
          FROM tbl_comotic AS c
          LEFT JOIN brand AS b
            ON c.brand_id = b.brand_id
          WHERE c.active = 'Yes'
            AND c.featured = 'Yes'
          LIMIT 6
        ";
        // execute the query
        $res2   = mysqli_query($conn, $sql2);
        // count rows
        $count2 = mysqli_num_rows($res2);

        // check whether cosmotic available or not 
        if ($count2 > 0) {
            // cosmotic available
            while ($row = mysqli_fetch_assoc($res2)) {
                // Get the value from database 
                $id          = $row['id'];
                $title       = $row['title'];
                $price       = $row['price'];
                $description = $row['description'];
                $image_name  = $row['image_name'];
                $brand_id    = $row['brand_id'];
                $brand_name  = $row['brand_name'] ?? 'Unknown';
        ?>
        <div class="cosmotic-menu-box">
            <div class="cosmotic-menu-img">
                <?php
                // check whether image available or not 
                if ($image_name == "") {
                    // image not available
                    echo "<div class='error'>Image Not Available.</div>"; 
                } else {
                    // Image available 
                ?>
                <img src="<?php echo SITEURL; ?>image/cosmotic/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                <?php } ?>
            </div>

            <div class="cosmotic-menu-desc">
                <h4><?php echo htmlspecialchars($title); ?></h4>
                <!-- display the brand name -->
                <p class="cosmotic-brand">Brand: <?php echo htmlspecialchars($brand_name); ?></p>
                <p class="cosmotic-price">ETB. <?php echo number_format($price, 2); ?></p>
                <p class="cosmotic-detail"><?php echo htmlspecialchars($description); ?></p>
                <br>

                <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="<?php echo SITEURL; ?>order.php?cosmotic_id=<?php echo $id; ?>&brand_id=<?php echo $brand_id; ?>" class="btn btn-primary">Order Now</a>
                <?php else: ?>
                    <a href="<?php echo SITEURL; ?>customer-login.php" class="btn btn-primary">Login to Order</a>
                <?php endif; ?>
            </div>
        </div>
        <?php
            }
        } else {
            // cosmotic not available 
            echo "<div class='error'>Cosmetic Not Available.</div>";
        }
        ?>
        </div>

        <div class="clearfix"></div>

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>cosmotics.php">See All cosmotics</a>
        </p>
    </div>
</section>
<!-- cosmotic Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
