<?php include('partials-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Cosmetic</h2>

        <div class="category-grid">
            <?php
            // Display all categories that are active
            $sql= "SELECT * FROM tbl_catagory WHERE active='Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    <a href="<?php echo SITEURL; ?>category-cosmotic.php?catagory_id=<?php echo $id; ?>">
                        <div class="box-3">
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Category image not found.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>image/catagory/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                            <h3 class="float-text text-white"><?php echo htmlspecialchars($title); ?></h3>
                        </div>
                    </a>
                    <?php
                }
            } else {
                echo "<div class='error'>Category Not Found.</div>";
            }
            ?>
        </div>

    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
