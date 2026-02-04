
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


?>
<?php
//include('login-check.php');
// Authorizathion or access control

// check whether the user loged in or not
if(!isset($_SESSION['user']))
{
    //user is not logged in

    //Redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login To Access Admin Panel.</div>";
    header('location:'.SITEURL.'admin/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmotic order website - Home page  </title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    
     <div class="menu text-center">
        
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-catagory.php">Catagory</a></li>
                    <li><a href="manage-cosmotic.php">Cosmotic</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li>
                     <a href="<?php echo SITEURL; ?>admin/view-contact.php">View Contacts</a>
                    </li>
                    <li><a href="manage-brand.php">manage Brand</a></li>
                    <li><a href="view-brand-message.php">View Brand message</a></li>

                    <li><a href="logout.php">Logout</a></li>

                </ul>
        

     </div>