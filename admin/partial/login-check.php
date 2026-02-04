<?php
// Authorizathion or access control

// check whether the user loged in or not
if(isset($_SESSION['user']))
{
    //user is not logged in

    //Redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login To Access Admin Panel.</div>";
    header('location:'.SITEURL.'admin/login.php');
}
?>