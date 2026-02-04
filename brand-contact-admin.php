<?php
// brand/brand-contact-admin.php
ob_start();
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
    <h1>Contact Admin</h1>
    <br><br>

    <?php
      if (isset($_SESSION['contact'])) {
        echo $_SESSION['contact'];
        unset($_SESSION['contact']);
      }
    ?>

    <form action="" method="post">
      <table class="tbl-30">
        <tr>
          <td>Subject:</td>
          <td><input type="text" name="subject" placeholder="Enter subject" required></td>
        </tr>
        <tr>
          <td>Message:</td>
          <td><textarea name="message" cols="30" rows="6" placeholder="Write your message..." required></textarea></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="Send Message" class="btn-secondary">
          </td>
        </tr>
      </table>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        $sql = "INSERT INTO tbl_brand_messages (brand_id, subject, message, reply, created_at) 
                VALUES ($brand_id, '$subject', '$message', '', NOW())";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['contact'] = "<div class='success'>Your message has been sent to the admin.</div>";
        } else {
            $_SESSION['contact'] = "<div class='error'>Failed to send your message.</div>";
        }
        header('Location: '.SITEURL.'brand-contact-admin.php');
        exit();
    }
    ?>
  </div>
</div>

<?php
include('partials-front/brand-footer.php');
ob_end_flush();
?>
