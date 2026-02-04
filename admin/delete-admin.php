<?php 
//Start session
session_start();
//cerate constant to store repeated value
define('SITEURL','http://localhost/Ourproject/');
 define("LOCALHOST","localhost");
 define('DB_USERNAME','root');
 define('DB_PASSWORD','');
 define('DB_NAME','cosmotic-oreder');
$conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
$db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error()); 
// get the ID of the admin to the deleted
$id=$_GET['id'];
// create sql query to Delete the admin 
$sql="DELETE FROM tbl_admin WHERE id=$id";
//check the query excuting successfully or not
$res=mysqli_query($conn,$sql);
if($res==true){
//echo "Admin Deleted";
//create session variable to display message 
$_SESSION['delete'] = "<div class='success'>Admin Delete Successfully</div>";
//redirect to Manage admin page
header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
//echo "Failed to Admin";
$_SESSION['delete'] = "<div class='error'>Faild to Delete Admin Try Again Later</div>";
header('location:'.SITEURL.'admin/manage-admin.php');


}
?>