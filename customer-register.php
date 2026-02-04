<?php include('partials-front/menu.php'); ?>

<div class="customer-form-container">
    <h2>Register Account</h2>

    <?php
    if (isset($_SESSION['register-msg'])) {
        echo $_SESSION['register-msg'];
        unset($_SESSION['register-msg']);
    }
    ?>

    <form action="" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="submit" value="Register">
    </form>

    <div class="form-footer">
        Already have an account? <a href="customer-login.php">Login here</a>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM tbl_customer WHERE email='$email'";
    $check_res = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['register-msg'] = "<div class='login-error'>Email already registered.</div>";
    } else {
        $sql = "INSERT INTO tbl_customer SET full_name='$full_name', email='$email', password='$password'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['register-msg'] = "<div class='login-success'>Registration successful. Please login.</div>";
            header('Location:'.SITEURL.'customer-login.php');
            exit();
        } else {
            $_SESSION['register-msg'] = "<div class='login-error'>Failed to register.</div>";
        }
    }
}
?>

<?php include('partials-front/footer.php'); ?>
