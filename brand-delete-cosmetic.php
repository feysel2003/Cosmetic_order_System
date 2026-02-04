<?php
// brand/delete-cosmetic.php

include('admin/config/constants.php');

// 1) Ensure brand is logged in
if (!isset($_SESSION['brand_id'])) {
    $_SESSION['unauthorize'] = "<div class='error'>Please login first.</div>";
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}
$brand_id = (int) $_SESSION['brand_id'];

// 2) Check that we have both id & image_name in the URL
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id         = (int) $_GET['id'];
    $image_name = $_GET['image_name'];

    // 3) Verify the cosmetic belongs to this brand
    $checkSql = "
      SELECT image_name 
      FROM tbl_comotic 
      WHERE id = $id 
        AND brand_id = $brand_id
    ";
    $checkRes = mysqli_query($conn, $checkSql);
    if (!$checkRes || mysqli_num_rows($checkRes) !== 1) {
        // either it doesn't exist, or it isn't owned by this brand
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized action.</div>";
        header('Location: ' . SITEURL . 'brand-manage-cosmetic.php');
        exit();
    }

    // 4) Remove the image file if it exists
    if (!empty($image_name)) {
        $path   = "../image/cosmotic/" . $image_name;
        if (file_exists($path)) {
            if (!unlink($path)) {
                $_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
                header('Location: ' . SITEURL . 'brand-manage-cosmetic.php');
                exit();
            }
        }
    }

    // 5) Delete the database record (scoped to this brand)
    $delSql = "
      DELETE 
      FROM tbl_comotic 
      WHERE id = $id 
        AND brand_id = $brand_id
    ";
    $delRes = mysqli_query($conn, $delSql);
    if ($delRes && mysqli_affected_rows($conn) === 1) {
        $_SESSION['delete'] = "<div class='success'>Cosmetic deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete cosmetic.</div>";
    }
    header('Location: ' . SITEURL . 'brand-manage-cosmetic.php');
    exit();
} else {
    // Missing parameters
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access.</div>";
    header('Location: ' . SITEURL . 'brand-manage-cosmetic.php');
    exit();
}
?>
