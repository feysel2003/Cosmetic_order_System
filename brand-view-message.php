<?php
// brand/brand-view-messages.php
include('partials-front/brand-menu.php');

if (!isset($_SESSION['brand_id'])) {
    $_SESSION['unauthorize'] = "<div class='error'>Please login first.</div>";
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}
$brand_id = (int) $_SESSION['brand_id'];
?>

<div class="main-content">
  <div class="wraper">
    <h1>My Messages</h1>
    <br>

    <div class="table-responsive">
      <table class="tbl-full">
        <thead>
          <tr>
            <th>S.N.</th>
            <th>Subject</th>
            <th>Your Message</th>
            <th>Admin Reply</th>
            <th>Date</th>
            <th>Contact Admin</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $sql = "
            SELECT * FROM tbl_brand_messages
            WHERE brand_id = $brand_id
            ORDER BY created_at DESC
          ";
          $res = mysqli_query($conn, $sql);

          if ($res && mysqli_num_rows($res) > 0) {
              $sn = 1;
              while ($row = mysqli_fetch_assoc($res)) {
                  echo "<tr>";
                  echo "<td>" . $sn++ . "</td>";
                  echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                  echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                  echo "<td>" . (!empty($row['reply']) ? nl2br(htmlspecialchars($row['reply'])) : "<span class='text-muted'>No reply yet</span>") . "</td>";
                  echo "<td>" . date('Y-m-d H:i', strtotime($row['created_at'])) . "</td>";
                  echo "<td><a href='" . SITEURL . "brand-contact-admin.php?brand_id=" . $brand_id . "' class='btn btn-secondary'>Contact Admin</a></td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5' class='error text-center'>No messages found.</td></tr>";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('partials-front/brand-footer.php'); ?>
