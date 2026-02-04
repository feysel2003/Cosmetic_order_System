<?php include('partials-front/menu.php'); ?>

<div class="customer-form-container">
    <h2>Login</h2>

    <?php 
    if (isset($_SESSION['login-msg'])) {
        echo $_SESSION['login-msg'];
        unset($_SESSION['login-msg']);
    }
    ?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="user_type" required style="margin-top: 10px;">
            <option value="">-- Select Login Type --</option>
            <option value="customer">Customer</option>
            <option value="brand">Brand</option>
        </select> 

        <input type="submit" name="login" value="Login">
    </form>

    <div class="form-footer">
        Don't have an account? 
        <a href="customer-register.php">Register as Customer</a> | 
        <a href="brand-register.php">Register as Brand</a>
    </div>
</div>

<?php 
if (isset($_POST['login'])) {
   

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_input = $_POST['password'];
    $user_type = $_POST['user_type'];

    if ($user_type == 'customer') {
        $sql = "SELECT * FROM tbl_customer WHERE email='$email'";
    } elseif ($user_type == 'brand') {
        $sql = "SELECT * FROM brand WHERE brand_email='$email'";
    } else {
        $_SESSION['login-msg'] = "<div class='login-error'>Please select a login type.</div>";
        header('Location:'.SITEURL.'customer-login.php');
        exit();
    }

    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $hashed_password = $row['password'];

        if (password_verify($password_input, $hashed_password)) {
            if ($user_type == 'customer') {
                $_SESSION['customer_id'] = $row['id'];
                $_SESSION['customer_name'] = $row['full_name'];
                $_SESSION['login-success-msg'] = "<div class='login-success'>Login Successful. Welcome, {$row['full_name']}!</div>";
                header('Location:'.SITEURL.'index.php');
            } elseif ($user_type == 'brand') {
                $_SESSION['brand_id'] = $row['brand_id'];
                $_SESSION['brand_name'] = $row['brand_name'];
                $_SESSION['login-success-msg'] = "<div class='login-success'>Login Successful. Welcome, {$row['brand_name']}!</div>";
                header('Location:'.SITEURL.'brand-index.php');
            }
        } else {
            $_SESSION['login-msg'] = "<div class='login-error'>Invalid email or password.</div>";
            header('Location:'.SITEURL.'customer-login.php');
        }
    } else {
        $_SESSION['login-msg'] = "<div class='login-error'>Account not found. Please register.</div>";
        header('Location:'.SITEURL.'customer-login.php');
    }
}
?>

<?php include('partials-front/footer.php'); ?>
