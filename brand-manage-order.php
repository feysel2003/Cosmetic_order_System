<?php
// brand/manage-order.php
include('partials-front/brand-menu.php');

// 1) Ensure brand is logged in
if (!isset($_SESSION['brand_id'])) {
    // Set session message using standard structure (div with classes)
    $_SESSION['unauthorize'] = "<div class='alert alert-warning'>Please login first.</div>"; // Changed to alert structure
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}
$brand_id = (int) $_SESSION['brand_id'];
?>

<div class="main-content">
  <div class="wraper">
    <h1>Manage Your Orders</h1>

    <?php
      // Display flash messages using the alert structure
      // Example for 'update' message (adapt for others if needed)
      if (isset($_SESSION['update'])) {
          // Determine if it's success or error based on content (simple check)
          // Assumes success messages contain 'success' and errors contain 'fail' or 'error'
          $message_content = strtolower($_SESSION['update']);
          if (strpos($message_content, 'fail') !== false || strpos($message_content, 'error') !== false) {
              $alert_class = 'alert-danger';
          } else {
              $alert_class = 'alert-success';
          }
          // Output the message wrapped in the correct alert div
          // We remove the inner div if it already exists in the session message for cleaner output
          $inner_message = preg_replace('/<div class[^>]*>(.*?)<\/div>/i', '$1', $_SESSION['update']);
          echo "<div class='alert " . $alert_class . "'>" . $inner_message . "</div>";
          unset($_SESSION['update']);
      }
      // Add similar logic for other potential flash messages ('add', 'delete', etc.) if they exist
      if (isset($_SESSION['unauthorize'])) { // Display the unauthorized message set earlier
        echo $_SESSION['unauthorize']; // Already formatted as an alert
        unset($_SESSION['unauthorize']);
      }
    ?>
    <br> <!-- Keep one br for spacing after messages -->

    <div class="table-responsive">
      <table class="tbl-full">
        <thead> <!-- Added thead for semantic structure -->
          <tr>
            <th>S.N.</th>
            <th>Cosmetic</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th>Payment Proof</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody> <!-- Added tbody for semantic structure -->
        <?php
        // 2) Fetch only orders for this brand
        $sql = "
          SELECT *
          FROM tbl_order
          WHERE brand_id = $brand_id
          ORDER BY id DESC
        ";
        $res = mysqli_query($conn, $sql);
        $sn = 1;

        if ($res && mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            $id               = $row['id'];
            $cosmetic         = $row['cosmotic']; // Corrected typo? Should it be 'cosmetic'? Check DB column name
            $price            = $row['price'];
            $quantity         = $row['quantity'];
            $total            = $row['total'];
            $order_date       = $row['order_date'];
            $status           = $row['status'];
            $customer_name    = $row['customer_name'];
            $customer_contact = $row['customer_contact'];
            $customer_email   = $row['customer_email'];
            $customer_address = $row['customer_address'];
            $payment_proof    = $row['payment_proof'];
        ?>
        <tr>
          <td><?php echo $sn++; ?></td>
          <td data-label="Cosmetic"><?php echo htmlspecialchars($cosmetic); ?></td>
          <td data-label="Price">ETB <?php echo number_format($price, 2); ?></td>
          <td data-label="Quantity"><?php echo (int)$quantity; ?></td>
          <td data-label="Total">ETB <?php echo number_format($total, 2); ?></td>
          <td data-label="Order Date"><?php echo htmlspecialchars($order_date); ?></td>
          <td data-label="Status">
            <?php
              // Use span with status classes based on the CSS helper comment
              $status_class = 'status-default'; // Default class
              switch ($status) {
                case 'Ordered':     $status_class = 'status-ordered'; break;
                case 'On Delivery': $status_class = 'status-on-delivery'; break;
                case 'Delivered':   $status_class = 'status-delivered'; break;
                case 'Cancelled':   // Consistent spelling - check DB value
                case 'Canceled':    $status_class = 'status-canceled'; break;
              }
              echo "<span class='status-label " . $status_class . "'>" . htmlspecialchars($status) . "</span>";
            ?>
          </td>
          <td data-label="Customer Name"><?php echo htmlspecialchars($customer_name); ?></td>
          <td data-label="Contact"><?php echo htmlspecialchars($customer_contact); ?></td>
          <td data-label="Email"><?php echo htmlspecialchars($customer_email); ?></td>
          <td data-label="Address"><?php echo htmlspecialchars($customer_address); ?></td>
          <td data-label="Payment Proof">
              <?php
              if (empty($payment_proof)) {
                  // Keep class='error' as CSS might target it, or change to simple text
                  echo "<div class='error'>No Proof Added.</div>";
              } else {
                  // Removed inline width, CSS will handle sizing
                  echo "<img src='" . SITEURL . "image/payment_proofs/" . htmlspecialchars($payment_proof) . "' alt='Payment Proof'>";
              }
              ?>
           </td>
           <td data-label="Actions">
              <!-- Added base 'btn' class -->
              <a href="<?php echo SITEURL; ?>brand-update-order.php?id=<?php echo $id; ?>"
                 class="btn btn-secondary">Update Order</a>
          </td>
        </tr>
        <?php
          }
        } else {
          // Use colspan matching the number of columns
          echo "<tr><td colspan='13' class='error text-center'>You have no orders yet.</td></tr>"; // Updated colspan and added text-center
        }
        ?>
        </tbody> <!-- Close tbody -->
      </table>
    </div> <!-- Close table-responsive -->
  </div> <!-- Close wraper -->
</div> <!-- Close main-content -->

<?php include('partials-front/brand-footer.php'); ?>