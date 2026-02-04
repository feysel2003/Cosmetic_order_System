<?php include('partial/menu.php'); ?>

<div class="main-contenet">
    <div class="wraper">
        <h1>Manage Cosmotic</h1>

        <table class="tbl-full">
            <br><br>
            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if (isset($_SESSION['unauthorize'])) {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            ?>
            <br><br>
            <a href="<?php echo SITEURL; ?>admin/add-cosmotic.php" class="btn-primary">Add Cosmotic</a>
            <br><br><br>

            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Brand Name</th>
                <th>Actions</th>
            </tr>

            <?php
            // Detect user role
           // $is_brand = isset($_SESSION['brand_id']);
           // $brand_id = $is_brand ? $_SESSION['brand_id'] : null;

           /* if ($is_brand) {
                // Brand user: show only their products
                $sql = "SELECT c.*, b.brand_name 
                        FROM tbl_comotic AS c
                        LEFT JOIN brand AS b ON c.brand_id = b.brand_id
                        WHERE c.brand_id = $brand_id";
            } else { */
                // Admin: show all cosmetics
                $sql = "SELECT c.*, b.brand_name 
                        FROM tbl_comotic AS c
                        LEFT JOIN brand AS b ON c.brand_id = b.brand_id";

           // }

            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_num_rows($res) > 0) {
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    $brand_name = isset($row['brand_name']) ? $row['brand_name'] : null;
                    ?>
                    <tr>
                        <td ><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>ETB <?php echo $price; ?></td>
                        <td>
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Image Not Added.</div>";
                            } else {
                                echo "<img src='" . SITEURL . "image/cosmotic/" . $image_name . "' width='150px' height='150px'>";
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td><?php echo $brand_name != "" ? $brand_name : "<span class='success'>Admin</span>"; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-cosmotic.php?id=<?php echo $id; ?>" class="btn-secondary">Update Cosmotic</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-cosmotic.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Delete Cosmotic</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='8' class='error'>Cosmotic not Added yet.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include('partial/footer.php'); ?>
