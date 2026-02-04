<?php
// brand/manage-cosmotic.php
include('partials-front/brand-menu.php');

if (!isset($_SESSION['brand_id'])) {
    // not a brand-user? kick them out
    //$_SESSION['unauthorize'] = "<div class='alert alert-warning'>Please login first.</div>";
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}

$brand_id = (int) $_SESSION['brand_id'];

// Fetch brand status for conditional logic
$brand_sql = "SELECT active, feature FROM brand WHERE brand_id = $brand_id";
$brand_res = mysqli_query($conn, $brand_sql);
$brand_data = mysqli_fetch_assoc($brand_res);
$brand_active = $brand_data['active'] ?? 'No';
$brand_feature = $brand_data['feature'] ?? 'No';
?>

<div class="main-content">
  <div class="wraper">
    <h1>Manage Your Cosmetics</h1>

    <?php
      foreach (['add','delete','upload','unauthorize','update'] as $msg_key) {
        if (isset($_SESSION[$msg_key])) {
          $message_content = strtolower($_SESSION[$msg_key]);
          $alert_class = 'alert-info';

          if ($msg_key == 'add' || $msg_key == 'update') {
              if (strpos($message_content, 'fail') !== false || strpos($message_content, 'error') !== false) {
                 $alert_class = 'alert-danger';
              } else {
                 $alert_class = 'alert-success';
              }
          } elseif ($msg_key == 'delete') {
               $alert_class = 'alert-success';
               if (strpos($message_content, 'fail') !== false || strpos($message_content, 'error') !== false) {
                 $alert_class = 'alert-danger';
               }
          } elseif ($msg_key == 'upload') {
              if (strpos($message_content, 'fail') !== false || strpos($message_content, 'error') !== false) {
                  $alert_class = 'alert-danger';
              } else {
                  $alert_class = 'alert-success';
              }
          } elseif ($msg_key == 'unauthorize') {
              $alert_class = 'alert-warning';
          }

          $inner_message = preg_replace('/<div class[^>]*>(.*?)<\/div>/i', '$1', $_SESSION[$msg_key]);
          echo "<div class='alert " . $alert_class . "'>" . $inner_message . "</div>";
          unset($_SESSION[$msg_key]);
        }
      }
    ?>

    <div class="add-button-link">
      <?php if ($brand_active === 'Yes'): ?>
        <a href="<?php echo SITEURL;?>brand-add-cometic.php" class="btn btn-primary">
          Add New Cosmetic
        </a>
      <?php else: ?>
        <div class="alert alert-warning">Your account is not active. You can't add new cosmetics.</div>
      <?php endif; ?>
    </div>

    <div class="table-responsive">
      <table class="tbl-full">
        <thead>
          <tr>
            <th>S.N.</th>
            <th>Title</th>
            <th>Price</th>
            <th>Image</th>
           <!-- <th>feature</th>
            <th>Active</th>-->
            <th>Actions</th>
            <th>Contact</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $sql = "
            SELECT *
            FROM tbl_comotic
            WHERE brand_id = $brand_id
            ORDER BY id DESC
          ";
          $res = mysqli_query($conn, $sql);

          if ($res && mysqli_num_rows($res) > 0) {
            $sn = 1;
            while ($row = mysqli_fetch_assoc($res)) {
              $id         = $row['id'];
              $title      = $row['title'];
              $price      = $row['price'];
              $image_name = $row['image_name'];
             // $feature   = $row['feature'];
             // $active     = $row['active'];
        ?>
          <tr>
            <td><?php echo $sn++; ?></td>
            <td data-label="Title"><?php echo htmlspecialchars($title); ?></td>
            <td data-label="Price">ETB <?php echo number_format($price, 2); ?></td>
            <td data-label="Image">
              <?php if (empty($image_name)): ?>
                <div class="error">No Image.</div>
              <?php else: ?>
                <img src="<?php echo SITEURL;?>image/cosmotic/<?php echo htmlspecialchars($image_name);?>" alt="<?php echo htmlspecialchars($title); ?>">
              <?php endif; ?>
            </td>
            <!--<td data-label="feature"><?php echo htmlspecialchars($feature); ?></td>
            <td data-label="Active"><?php echo htmlspecialchars($active); ?></td>--> 
            <td data-label="Actions">
              <a href="<?php echo SITEURL;?>brand-update-cosmetic.php?id=<?php echo $id;?>" class="btn btn-secondary">Update</a>
              <a href="<?php echo SITEURL;?>brand-delete-cosmetic.php?id=<?php echo $id;?>&image_name=<?php echo urlencode($image_name);?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this cosmetic?');">Delete</a>
            </td>
            <td data-label="Contact">
              <a href="<?php echo SITEURL;?>brand-contact-admin.php?brand_id=<?php echo $brand_id; ?>" class="btn btn-secondary">Contact Admin</a>
            </td>
          </tr>
        <?php
            }
          } else {
            echo "<tr><td colspan='8' class='error text-center'>You haven't added any cosmetics yet.</td></tr>";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('partials-front/brand-footer.php'); ?>
