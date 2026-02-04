<?php 
include('partials-front/menu.php'); 
?>

<?php
// Check if brand is logged in
if (!isset($_SESSION['brand_id'])) {
    $_SESSION['login-msg'] = "<div class='login-error'>Please login as a brand.</div>";
    header('Location: customer-login.php');
    exit();
}

// Get brand ID from session
$brand_id = (int) $_SESSION['brand_id']; // Safe casting to avoid SQL error

// Fetch brand info from DB
$query = "SELECT * FROM brand WHERE brand_id = $brand_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) == 1) {
    $brand = mysqli_fetch_assoc($result);
} else {
    echo "<div class='login-error'>Unable to fetch brand information.</div>";
    include('partials-front/footer.php');
    ob_end_flush();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brand Dashboard</title>
    <link rel="stylesheet" href="your-style.css"> <!-- Your CSS file -->
</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($brand['brand_name']); ?>!</h1>

    <?php if (!empty($brand['brand_logo'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($brand['brand_logo']); ?>" alt="Brand Logo" style="width:150px; height:auto; border-radius:10px;">
    <?php endif; ?>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($brand['brand_email']); ?></p>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($brand['brand_description'])); ?></p>

    <hr>

    <a href="brand-logo-upload.php" class="btn">Upload/Update Logo</a> |
    <a href="manage-brand-cosmotic.php" class="btn">Manage Products</a> |
    <a href="view-orders.php" class="btn">View Orders</a> |
    <a href="logout.php" class="btn">Logout</a>
</div>

</body>
</html>

<?php include('partials-front/footer.php'); ?>
