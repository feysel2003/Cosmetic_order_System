<?php include('partials-front/menu.php'); ?>
<?php
session_start();

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM brand WHERE brand_email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['brand_password'])) {
            $_SESSION['brand_id'] = $row['brand_id'];
            $_SESSION['brand_name'] = $row['brand_name'];
            echo "Login successful!";
            // Redirect to brand dashboard or home
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Brand not found!";
    }
}
?>

<form method="POST" action="">
    <input type="email" name="email" placeholder="Brand Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" name="submit" value="Login">
</form>
<?php include('partials-front/footer.php'); ?>