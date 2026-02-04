<?php include('admin/config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Dashboard - Cosmetic Order System</title>

    <!-- Link to shared CSS file -->
    <link rel="stylesheet" href="css/brands.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body id="body">

<section class="navbar">
    <div class="logo" style="display: flex; align-items: center; gap: 10px;">
        <a href="<?php echo SITEURL; ?>brand-dashboard.php" title="Brand Panel">
            <div class="logo-image">
                <img src="logo2.jpg" alt="Cosmetic Logo" class="img-responsive logo-image" style="height:100px; width:100px; border-radius: 50%;">
            </div>
        </a>
        <span style="font-size: 22px; font-weight: bold; color: #d63384; display:inline;" class="system">Brand Dashboard</span>
    </div>

    <div class="wraper">
        <!-- Burger Icon -->
        <div class="burger-box">
            <div class="burger" onclick="toggleMenu()">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </div>

        <div class="menu text-right" id="nav-menu">
            <ul>
                <div class="dark-mode-toggle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                    <i class="fas fa-moon"></i>
                </div>

                <li><a href="<?php echo SITEURL; ?>brand-index.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>brand-manage-cosmetic.php">Manage Products</a></li>
                <li><a href="<?php echo SITEURL; ?>brand-manage-order.php">View Orders</a></li>
                <li><a href="<?php echo SITEURL; ?>brand-contact-admin.php">Contact admin</a></li>

                <li><a href="<?php echo SITEURL; ?>brand-view-message.php">View Contacts</a></li>
                
                <?php if (isset($_SESSION['brand_id'])): ?>
                    <li><a href="<?php echo SITEURL; ?>brand-logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITEURL; ?>customer-login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</section>
