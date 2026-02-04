
<?php 
//from menu
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Cosmotic Order System </title>
    <link rel="stylesheet" href="../css/admins.css">
<style>

body {
    background: linear-gradient(to bottom right, #f8cdda, #ffffff);
    font-family: Arial, sans-serif;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

h1 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 10px;
}

.subheading {
    text-align: center;
    color: #666;
    margin-bottom: 20px;
}

form.text-center {
    text-align: center;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-bottom: 1px solid #ccc;
    font-size: 16px;
    transition: border-bottom 0.3s ease;
}

input[type="text"]:focus, input[type="password"]:focus {
    border-bottom: 1px solid #f8cdda;
    outline: none;
}

.btn-primary {
    background-color: #f8cdda;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #e0a8c4;
}

.success {
    color: green;
    text-align: center;
    margin-bottom: 20px;
}

.error {
    color: red;
    text-align: center;
    margin-bottom: 20px;
}

p.text-center {
    text-align: center;
    font-size: 14px;
    color: #666;
}

a {
    color: #f8cdda;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>

</head>
<body>
    <div class="login-container">
    <div class="login">
    <h1>Admin Login</h1>
      <p class="subheading">Please login to access the admin panel</p>

        <br><br>
<?php 
if(isset($_SESSION['login'])){
    echo $_SESSION['login'];
    unset($_SESSION['login']);//removing desplay message
}

if(isset( $_SESSION['no-login-message']))
{
    echo  $_SESSION['no-login-message'];
    unset( $_SESSION['no-login-message']);
}

?>
<br><br>

        <form action="" method="POST" class="text-center">
            User Name: <br>
            <input type="text" name="username" placeholder="Enter username">
<br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter password"> 
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
        <p class="text-center"> Created By - <a href="www.groupOnestudent.com">Students@Wcu </a> </p>


    </div>

    </div>

</body>
</html>

<?php 
// check wether the submit button is clicked or not
 if(isset($_POST['submit'])){
    // proccess for Login 
    // Get the Data from the form
   //$username=$_POST['username'];
   //$password=md5($_POST['password']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $row_password =md5($_POST['password']);
   $password = mysqli_real_escape_string($conn, $row_password);
    
    //  sql to check wether the user with username and password exit or not 
     $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password = '$password' ";
     // execute the query 
     $res = mysqli_query($conn,$sql);
     // count rows to check whether the user exist or not 
     $count = mysqli_num_rows($res);

     if($count==1){
        //user available and login success
        $_SESSION['login']='<div class="success">Login Successfully.</div>';
        $_SESSION['user'] = $username; // To check whether the user logged in ot not and logout unset it

        //rdirect to home page 
        header('location:'.SITEURL.'admin/');

     }
     else{
        //user not available and login session 
        //user available and login session 
        $_SESSION['login']='<div class="error text-center"> Login Is Failed .</div>';
        // Redirect to Home page 
        header('location:'.SITEURL.'admin/login.php');


     }

 }
?>