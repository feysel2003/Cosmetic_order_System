<?php
// Assuming this file is brand-dashboard.php or similar index page
include('partials-front/brand-menu.php');

// Check if brand is logged in
if (!isset($_SESSION['brand_id'])) {
    // Redirect to login page if not logged in
    // You might want to set a flash message here too if needed
    // $_SESSION['unauthorize'] = "<div class='alert alert-warning'>Please login to view the dashboard.</div>";
    header('location:' . SITEURL . 'customer-login.php'); // Changed to brand-login.php as per other files
    exit();
}

$brand_id = (int) $_SESSION['brand_id'];

?>

<div class="main-content">
    <div class="wraper">
        <h1>DASHBOARD</h1>

        <?php
        // Display login flash message using the alert structure
        if (isset($_SESSION['login'])) {
            // Assuming login message is always success, otherwise add logic to check content
            $alert_class = 'alert-success';
            // Remove inner div if it already exists
            $inner_message = preg_replace('/<div class[^>]*>(.*?)<\/div>/i', '$1', $_SESSION['login']);
            echo "<div class='alert " . $alert_class . "'>" . $inner_message . "</div>";
            unset($_SESSION['login']);
        }
        ?>

        <!-- Dashboard Metrics Grid -->
        <div class="dashboard-grid">

            <!-- Card 1: Total Revenue -->
            <div class="card revenue text-center">
                <?php
                // Create sql query to Get total Revenue Generated for 'Delivered' orders
                // Aggregate Function in sql
                $sql1 = "SELECT SUM(total) AS Total FROM tbl_order WHERE brand_id = $brand_id AND status='Delivered'";

                // Execute the query
                $res1 = mysqli_query($conn, $sql1);

                // Get the value
                $total_revenue = 0; // Default value
                if ($res1) {
                    $row1 = mysqli_fetch_assoc($res1);
                    $total_revenue = $row1['Total'] ?? 0; // Use null coalescing operator
                }
                ?>
                <!-- Display formatted revenue -->
                <h1>ETB. <?php echo number_format($total_revenue, 2); ?></h1>
                <!-- Description text using <p> -->
                <p>Revenue Generated</p>
            </div>

            <!-- Card 2: Brand's Cosmetics Count -->
            <div class="card cosmetics text-center">
                <?php
                // SQL query to count cosmetics for this brand
                $sql2 = "SELECT COUNT(*) AS CosmeticCount FROM tbl_comotic WHERE brand_id = $brand_id"; // More efficient count
                $res2 = mysqli_query($conn, $sql2);

                // Get the count
                $count2 = 0; // Default value
                if ($res2) {
                    $row2 = mysqli_fetch_assoc($res2);
                    $count2 = $row2['CosmeticCount'] ?? 0;
                }
                ?>
                <!-- Display cosmetic count -->
                <h1><?php echo $count2; ?></h1>
                <!-- Description text using <p> -->
                <p>Cosmetics</p>
            </div>

            <!-- Card 3: Brand's Total Orders Count -->
            <div class="card orders text-center">
                <?php
                // SQL query to count all orders for this brand
                $sql3 = "SELECT COUNT(*) AS OrderCount FROM tbl_order WHERE brand_id = $brand_id"; // More efficient count
                $res3 = mysqli_query($conn, $sql3);

                // Get the count
                $count3 = 0; // Default value
                if ($res3) {
                    $row3 = mysqli_fetch_assoc($res3);
                    $count3 = $row3['OrderCount'] ?? 0;
                }
                ?>
                <!-- Display order count -->
                <h1><?php echo $count3; ?></h1>
                <!-- Description text using <p> -->
                <p>Total Orders</p>
            </div>

           

        </div> <!-- End dashboard-grid -->

        
        <div class="clearfix"></div>

        

    </div> <!-- End wraper -->
</div> <!-- End main-content -->

<?php include('partials-front/brand-footer.php'); ?>