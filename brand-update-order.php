<?php
// brand/update-order.php
ob_start();
include('partials-front/brand-menu.php');

// 1) Ensure brand is logged in
if (!isset($_SESSION['brand_id'])) {
    //$_SESSION['unauthorize'] = "<div class='error'>Please log in first.</div>";
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}
$brand_id = (int) $_SESSION['brand_id'];
?>

<div class="main-content">
  <div class="wraper">
    <h1>Update Order</h1>
    <br><br>

    <?php
    // 2) Ensure we have an order ID in the URL
    if (!isset($_GET['id'])) {
        header('Location: ' . SITEURL . 'brand-manage-order.php');
        exit();
    }
    $id = (int) $_GET['id'];

    // 3) Fetch the order, scoped to this brand
    $sql  = "SELECT * FROM tbl_order WHERE id = $id AND brand_id = $brand_id";
    $res  = mysqli_query($conn, $sql);
    if (!$res || mysqli_num_rows($res) !== 1) {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access.</div>";
        header('Location: ' . SITEURL . 'brand/manage-order.php');
        exit();
    }
    $row = mysqli_fetch_assoc($res);

    // Pull fields for form
    $cosmetic         = $row['cosmotic'];
    $price            = $row['price'];
    $quantity         = $row['quantity'];
    $status           = $row['status'];
    $customer_name    = $row['customer_name'];
    $customer_contact = $row['customer_contact'];
    $customer_email   = $row['customer_email'];
    $customer_address = $row['customer_address'];
    ?>

    <form action="" method="POST">
      <table class="tbl-30">
        <tr>
          <td>Cosmetic Name:</td>
          <td><b><?php echo htmlspecialchars($cosmetic); ?></b></td>
        </tr>
        <tr>
          <td>Price:</td>
          <td><b>ETB <?php echo number_format($price,2); ?></b></td>
        </tr>
        <tr>
          <td>Quantity:</td>
          <td><input type="number" name="quantity" value="<?php echo (int)$quantity; ?>" required></td>
        </tr>
        <tr>
          <td>Status:</td>
          <td>
            <select name="status">
              <option <?php if($status=="Ordered") echo "selected"; ?> value="Ordered">Ordered</option>
              <option <?php if($status=="On Delivery") echo "selected"; ?> value="On Delivery">On Delivery</option>
              <option <?php if($status=="Delivered") echo "selected"; ?> value="Delivered">Delivered</option>
              <option <?php if($status=="Canceled") echo "selected"; ?> value="Canceled">Canceled</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Customer Name:</td>
          <td><input type="text" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>" required></td>
        </tr>
        <tr>
          <td>Contact:</td>
          <td><input type="text" name="customer_contact" value="<?php echo htmlspecialchars($customer_contact); ?>" required></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input type="email" name="customer_email" value="<?php echo htmlspecialchars($customer_email); ?>" required></td>
        </tr>
        <tr>
          <td>Address:</td>
          <td><input type="text" name="customer_address" value="<?php echo htmlspecialchars($customer_address); ?>" required></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="hidden" name="id"    value="<?php echo $id; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="submit" name="submit" value="Update Order" class="btn-secondary">
          </td>
        </tr>
      </table>
    </form>

    <?php
    // 4) Handle the form submission
    if (isset($_POST['submit'])) {
        $id               = (int) $_POST['id'];
        $price            = (float) $_POST['price'];
        $quantity         = (int)   $_POST['quantity'];
        $total            = $price * $quantity;
        $status           = mysqli_real_escape_string($conn, $_POST['status']);
        $customer_name    = mysqli_real_escape_string($conn, $_POST['customer_name']);
        $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
        $customer_email   = mysqli_real_escape_string($conn, $_POST['customer_email']);
        $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);

        // 5) Update query scoped to this brand too
        $sql2 = "
          UPDATE tbl_order SET
            quantity         = $quantity,
            total            = $total,
            status           = '$status',
            customer_name    = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email   = '$customer_email',
            customer_address = '$customer_address'
          WHERE id = $id
            AND brand_id = $brand_id
        ";
        $res2 = mysqli_query($conn, $sql2);

        if ($res2 && mysqli_affected_rows($conn) === 1) {
            $_SESSION['update'] = "<div class='success'>Order updated successfully.</div>";
        } else {
            $_SESSION['update'] = "<div class='error'>Failed to update order.</div>";
        }
        header('Location: ' . SITEURL . 'brand-manage-order.php');
        exit();
    }
    ?>

  </div>
</div>

<?php
include('partials-front/brand-footer.php');
ob_end_flush();
?>
