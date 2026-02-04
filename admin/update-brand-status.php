<?php
// admin/update-brand-status.php
include('config/constants.php');
// 1) Verify admin session...
$id  = (int) $_GET['id'];
$col = in_array($_GET['col'], ['feature','active']) ? $_GET['col'] : 'active';
$val = ($_GET['val']==='Yes') ? 'Yes' : 'No';

$sql = "UPDATE brand 
        SET $col = '$val' 
        WHERE brand_id = $id";
if(mysqli_query($conn, $sql)) {
  $_SESSION['msg'] = "<div class='success'>Updated $col to $val.</div>";
} else {
  $_SESSION['msg'] = "<div class='error'>Failed to update.</div>";
}

header('Location: manage-brand.php');
exit();
