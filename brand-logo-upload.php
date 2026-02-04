<?php
session_start();
include('config.php');

// Check if brand is logged in
if(!isset($_SESSION['brand_id'])) {
    header('location: brand-login.php');
    exit();
}

$brand_id = $_SESSION['brand_id'];

if(isset($_POST['submit'])) {
    if(isset($_FILES['brand_logo']) && $_FILES['brand_logo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $file_name = $_FILES['brand_logo']['name'];
        $file_tmp = $_FILES['brand_logo']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(in_array($file_ext, $allowed)) {
            $new_filename = "brand_" . $brand_id . "_" . time() . "." . $file_ext;
            move_uploaded_file($file_tmp, "uploads/" . $new_filename);

            // Update database
            $query = "UPDATE brand SET brand_logo = '$new_filename' WHERE brand_id = $brand_id";
            if(mysqli_query($conn, $query)) {
                echo "Logo uploaded successfully!";
                header('refresh:2;url=brand-dashboard.php');
                exit();
            } else {
                echo "Error uploading logo.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, GIF allowed.";
        }
    } else {
        echo "No file selected.";
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="brand_logo" accept="image/*" required><br><br>
    <input type="submit" name="submit" value="Upload Logo" class="btn">
</form>
