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

// destroy the session
session_destroy(); // unsets $_SESSION['user']
// redirect into the login page
header('location:'.SITEURL.'admin/login.php');
?>