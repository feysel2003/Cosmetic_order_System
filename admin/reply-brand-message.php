<?php
// admin/reply-brand-message.php
include('partial/menu.php');

if (!isset($_GET['id'])) {
    header('Location: view-brand-messages.php');
    exit();
}

$message_id = (int) $_GET['id'];

// Fetch message details
$sql = "
  SELECT ca.*, b.brand_email, b.brand_name AS brand_name
  FROM tbl_brand_messages ca
  JOIN brand b ON ca.brand_id = b.brand_id
  WHERE ca.id = $message_id
  LIMIT 1
";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    $_SESSION['reply'] = "<div class='error'>Message not found.</div>";
    header('Location: view-brand-messages.php');
    exit();
}

// Optional: mark as read
mysqli_query($conn, "UPDATE tbl_brand_messages SET status='Read' WHERE id=$message_id");
?>

<div class="main-content">
  <div class="wrapper">
    <h1>Reply to Brand</h1>
    <p><strong>Brand:</strong> <?php echo htmlspecialchars($row['brand_name']); ?> (<em><?php echo $row['brand_email']; ?></em>)</p>
    <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
    <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
    <br>

    <form action="" method="post">
      <table class="tbl-30">
        <tr>
          <td>Your Reply:</td>
          <td><textarea name="reply_message" rows="5" cols="30" required></textarea></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="send_reply" value="Send Reply" class="btn-primary">
          </td>
        </tr>
      </table>
    </form>

    <?php
    if (isset($_POST['send_reply'])) {
        $reply = mysqli_real_escape_string($conn, $_POST['reply_message']);
        $brand_id = (int) $row['brand_id'];
        $subject = mysqli_real_escape_string($conn, $row['subject']);
        $original_message = mysqli_real_escape_string($conn, $row['message']);

        // 1. Update status in original message table
        mysqli_query($conn, "UPDATE tbl_brand_messages SET status='Replied' WHERE id=$message_id");

        // 2. Insert into tbl_brand_messages so the brand can see it
        $insert_sql = "
            INSERT INTO tbl_brand_messages (brand_id, subject, message, reply, created_at)
            VALUES ($brand_id, '$subject', '$original_message', '$reply', NOW())
        ";
        if (mysqli_query($conn, $insert_sql)) {
            $_SESSION['reply'] = "<div class='success'>Reply sent and saved successfully.</div>";
        } else {
            $_SESSION['reply'] = "<div class='error'>Failed to save reply message.</div>";
        }

        header('Location: view-brand-message.php');
        exit();
    }
    ?>
  </div>
</div>

<?php include('partial/footer.php'); ?>
