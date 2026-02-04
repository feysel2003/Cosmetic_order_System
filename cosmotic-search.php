<?php include('partials-front/menu.php'); ?>

<!-- cosmotic sEARCH Section Starts Here -->
<section class="cosmotic-search text-center">
    <div class="container">
        <?php
         // get the search keyword
         $search = mysqli_real_escape_string($conn, $_POST['search']);
        ?>
        <h2>Cosmetics on Your Search <a href="#" class="text-white">"<?php echo htmlspecialchars($search); ?>"</a></h2>
    </div>
</section>
<!-- cosmotic sEARCH Section Ends Here -->

<!-- cosmotic MEnu Section Starts Here -->
<section class="cosmotic-menu">
    <div class="container">
        <h2 class="text-center">Cosmetic Menu</h2>

        <div class="cosmotic-grid">
        <?php
        // sql query to get cosmetics based on search keyword, now joining brand
        $sql = "
          SELECT c.*, b.brand_id, b.brand_name
          FROM tbl_comotic AS c
          LEFT JOIN brand AS b
            ON c.brand_id = b.brand_id
          WHERE (c.title LIKE '%$search%' OR c.description LIKE '%$search%')
            AND c.active = 'Yes'
        ";
        // execute the query
        $res = mysqli_query($conn, $sql);
        // count rows
        $count = mysqli_num_rows($res);

        // check whether cosmetic available or not 
        if ($count > 0) {
            // cosmetic Available
            while ($row = mysqli_fetch_assoc($res)) {
                // get all value 
                $id           = $row['id'];
                $title        = $row['title'];
                $price        = $row['price'];
                $description  = $row['description'];
                $image_name   = $row['image_name'];
                $brand_id     = $row['brand_id'];
                $brand_name   = $row['brand_name'] ?? 'Unknown';
        ?>
        <div class="cosmotic-menu-box">
            <div class="cosmotic-menu-img">
                <?php
                // check whether image name is available or not 
                if ($image_name == "") {
                    // image not available
                    echo "<div class='error'> Image Not Available.</div>";
                } else {
                    // image available
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
            // cosmetic not available
            echo "<div class='error'> Cosmetic Not Found.</div>";
        }
        ?>
        </div>

        <div class="clearfix"></div>
    </div>
</section>
<!-- cosmotic Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
