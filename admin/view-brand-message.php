<?php
// admin/view-brand-messages.php
include('partial/menu.php');

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $del_sql = "DELETE FROM tbl_brand_messages WHERE id = $delete_id";
    if (mysqli_query($conn, $del_sql)) {
        $_SESSION['reply'] = "<div class='success'>Message deleted successfully.</div>";
    } else {
        $_SESSION['reply'] = "<div class='error'>Failed to delete message.</div>";
    }
    header('Location: view-brand-message.php');
    exit();
}

// Fetch incoming brand contact messages
$sql = "
  SELECT ca.*, b.brand_name AS brand_name
  FROM tbl_brand_messages ca
  JOIN brand b ON ca.brand_id = b.brand_id
  ORDER BY ca.created_at DESC
";
$res = mysqli_query($conn, $sql);

// Fetch all admin replies
$reply_sql = "
  SELECT bm.*, b.brand_name
  FROM tbl_brand_messages bm
  JOIN brand b ON bm.brand_id = b.brand_id
  ORDER BY bm.created_at DESC
";
$reply_res = mysqli_query($conn, $reply_sql);
?>

<div class="main-content">
  <div class="wrapper">
    <h1>Brand Messages</h1>
    <br>

    <?php
    if (isset($_SESSION['reply'])) {
        echo $_SESSION['reply'];
        unset($_SESSION['reply']);
    }
    ?>

    <!-- Incoming Messages Table -->
    <h3>Incoming Messages from Brands</h3>
    <div class="table-responsive">
      <table class="tbl-full">
        <thead>
          <tr>
            <th>S.N.</th>
            <th>Brand</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Sent At</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (mysqli_num_rows($res) > 0) {
            $sn = 1;
            while ($row = mysqli_fetch_assoc($res)) {
              ?>
              <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                  <a href="reply-brand-message.php?id=<?php echo $row['id']; ?>" class="btn-secondary">Reply</a>
                  <a href="view-brand-message.php?delete_id=<?php echo $row['id']; ?>" 
                     class="btn-danger" 
                     onclick="return confirm('Are you sure you want to delete this message?');">
                     Delete
                  </a>
                </td>
              </tr>
              <?php
            }
          } else {
            echo "<tr><td colspan='7' class='error text-center'>No messages found.</td></tr>";
          }
        ?>
        </tbody>
      </table>
    </div>

    <br><br>

    <!-- Sent Replies Table -->
    <h3>Sent Replies to Brands</h3>
    <div class="table-responsive">
      <table class="tbl-full">
        <thead>
          <tr>
            <th>S.N.</th>
            <th>Brand</th>
            <th>Reply Message</th>
            <th>Sent At</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (mysqli_num_rows($reply_res) > 0) {
            $sn = 1;
            while ($reply_row = mysqli_fetch_assoc($reply_res)) {
              ?>
              <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo htmlspecialchars($reply_row['brand_name']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($reply_row['reply'])); ?></td>
                <td><?php echo $reply_row['created_at']; ?></td>
              </tr>
              <?php
            }
          } else {
            echo "<tr><td colspan='4' class='error text-center'>No replies found.</td></tr>";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('partial/footer.php'); ?>
