<?php
include('config/constants.php');

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete message
    $sql = "DELETE FROM tbl_contact WHERE id=$id";

    $res = mysqli_query($conn, $sql);

    // Check if deletion was successful
    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Message deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete the message.</div>";
    }

    // Redirect to view-contact.php
    header("Location: " . SITEURL . "admin/view-contact.php");
    exit();
} else {
    // Redirect if ID not set
    $_SESSION['delete'] = "<div class='error'>Unauthorized access.</div>";
    header("Location: " . SITEURL . "admin/view-contact.php");
    exit();
}
