<?php
include('partials-front/menu.php');

if (!isset($_SESSION['customer_id'])) {
    header('Location: customer-login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

$sql = "SELECT * FROM tbl_order WHERE customer_id = $customer_id ORDER BY order_date DESC";
$res = mysqli_query($conn, $sql);
?>

<div class="myorder-form-container">
    <h2>My Orders</h2>

    <?php if (mysqli_num_rows($res) > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><?php echo $row['cosmotic']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>ETB <?php echo $row['total']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="error">You have not placed any orders yet.</div>
    <?php endif; ?>
</div>

<?php include('partials-front/footer.php'); ?>
