<?php include('admin/config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive cosmotic-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetics Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome (for burger icon and dark mode toggle) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body id="body">
    <!-- Navbar Section Starts Here -->
    <section class="navbar">

        <div class="logo" style="display: flex; align-items: center; gap: 10px;">
            <a href="<?php echo SITEURL; ?>" title="Cosmetic Order System">
                <div class="logo-image">
                    <img src="logo2.jpg" alt="Cosmetic Logo" class="img-responsive logo-image" style="height:100px; width:100px;">
                </div>
            </a>
            <span style="font-size: 22px; font-weight: bold; color: #d63384; display:inline;" class="system">Cosmetic Order System</span>
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

                    <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a></li>
                    <li><a href="<?php echo SITEURL; ?>cosmotics.php">Cosmotics</a></li>
                    <li><a href="<?php echo SITEURL; ?>about-us.php">About Us</a></li>

                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <li><a href="my-order.php">My Orders</a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo SITEURL; ?>contact.php">Contact</a></li>

                    <?php
                        if (isset($_SESSION['customer_id'])) {
                            echo "<li><a href='" . SITEURL . "logout.php'>Logout</a></li>";
                        } else {
                            echo "<li><a href='" . SITEURL . "customer-login.php'>Login</a></li>";
                            
                        }
                    ?>
                </ul>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

    </section>
    <!-- Navbar Section Ends Here -->

    
    
