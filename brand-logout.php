<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to homepage or login page
$redirect_to = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'customer-login.php';
header("Location: " . $redirect_to);
exit();
?>