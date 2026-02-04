<?php 
session_start();


// Check if brand is logged in
if(!isset($_SESSION['brand_id'])){
    header('location: brand-login.php');
    exit();
}

$brand_id = $_SESSION['brand_id'];
?>

<?php include('admin/partial/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage My Cosmetics</h1>

        <br><br>

        <?php 
        if(isset($_SESSION['add'])){ echo $_SESSION['add']; unset($_SESSION['add']); }
        if(isset($_SESSION['delete'])){ echo $_SESSION['delete']; unset($_SESSION['delete']); }
        if(isset($_SESSION['upload'])){ echo $_SESSION['upload']; unset($_SESSION['upload']); }
        if(isset($_SESSION['unauthorize'])){ echo $_SESSION['unauthorize']; unset($_SESSION['unauthorize']); }
        if(isset($_SESSION['update'])){ echo $_SESSION['update']; unset($_SESSION['update']); }
        ?>

        <br><br>

        <a href="add-brand-cosmotic.php" class="btn-primary">Add New Cosmetic</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php 
            // Only select cosmetics where brand_id matches
            $sql = "SELECT * FROM tbl_comotic WHERE brand_id = $brand_id";
            $res = mysqli_query($conn, $sql);

            $sn=1; // Serial Number

            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo htmlspecialchars($title); ?></td>
                <td>ETB <?php echo number_format($price, 2); ?></td>
                <td>
                    <?php 
                    if($image_name == ""){
                        echo "<div class='error'>No Image</div>";
                    } else {
                        ?>
                        <img src="<?php echo SITEURL; ?>image/cosmotic/<?php echo $image_name; ?>" width="100px">
                        <?php
                    }
                    ?>
                </td>
                <td><?php echo $featured; ?></td>
                <td><?php echo $active; ?></td>
                <td>
                    <a href="update-brand-cosmotic.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                    <a href="delete-brand-cosmotic.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>

            <?php
                }
            } else {
                echo "<tr><td colspan='7' class='error'>No cosmetics added yet.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include('admin/partial/footer.php'); ?>
