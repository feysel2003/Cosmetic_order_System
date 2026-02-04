<?php 
//include constants php
include("config/constants.php");

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
// get id and image 
$id=$_GET['id'];
$image_name = $_GET['image_name'];

// remove the image if available 
//check whether the image is available or not and delete only if available 
if($image_name != ""){
    //it has image and need to remove from folder
    $path = "../image/cosmotic/".$image_name;
    //remove file image from folder
    $remove= unlink($path);

    //check whether the image is remove or not 
    if($remove==false){
        $_SESSION['upload'] = "<div class='error'> Failed to Remove Image File.</div>";
        //redirect to manage cosmotic
        header('location'.SITEURL.'admin/manage-cosmotic.php');
        //stop the proccess
        die();

    }
}
// delete cosmotic from database
$sql = "DELETE FROM tbl_comotic WHERE id=$id";
// execute the query
$res = mysqli_query($conn, $sql);

//check whether the query execute or not and set the session message respectively
if($res==true)
{
    // cosmotic deleted
    $_SESSION['delete'] = "<div class='success'> Cosmotic Delete Successfully.</div>";
    header('location:'.SITEURL.'admin/manage-cosmotic.php');
}
else{
    //Failed to Delete cosmotic
    $_SESSION['delete'] = "<div class='error'> Failed To Delete Cosmotic.</div>";
    header('location:'.SITEURL.'admin/manage-cosmotic.php');

}


}
else{
    // Redirect to Manage Cosmotic Page
    $_SESSION['unauthorize']="<div class='error'>Unauthorized Access.<?div>";
    header('location:'.SITEURL.'admin/manage-cosmotic.php');
}
?>