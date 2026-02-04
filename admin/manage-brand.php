<?php
// admin/manage-brand.php
include('partial/menu.php');

// … authentication & session checks …

// Fetch all brands
$sql = "SELECT brand_id, brand_name, brand_email, feature, active 
        FROM brand";
$res = mysqli_query($conn, $sql);
?>

<div class="main-content">
  <div class="wrapper">
    <h1>Manage Brands</h1>
    <br>
    <?php if(isset($_SESSION['msg'])) {
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    } ?>
    <table class="tbl-full">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Contact</th>   
        <th>Actions</th>
      </tr>

      <?php while($row = mysqli_fetch_assoc($res)): ?>
      <tr>
        <td><?php echo $row['brand_id']; ?></td>
        <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
        <td><?php echo htmlspecialchars($row['brand_email']); ?></td>
        <td><?php echo $row['feature']; ?></td>
        <td><?php echo $row['active']; ?></td>

        <!-- Contact button -->
        <td>
          <a href="mailto:<?php echo $row['brand_email']; ?>?subject=Regarding%20Your%20Cosmetic%20Store" 
             class="btn-primary">
            Contact
          </a>
        </td>

        <td>
          <!-- Toggle feature -->
          <a href="update-brand-status.php?
             id=<?php echo $row['brand_id']; ?>&
             col=feature&
             val=<?php echo $row['feature']=='Yes'? 'No':'Yes'; ?>"
             class="btn-secondary">
            <?php echo $row['feature']=='Yes'? 'Unfeature':'Feature'; ?>
          </a>
          <!-- Toggle active -->
          <a href="update-brand-status.php?
             id=<?php echo $row['brand_id']; ?>&
             col=active&
             val=<?php echo $row['active']=='Yes'? 'No':'Yes'; ?>"
             class="btn-primary">
            <?php echo $row['active']=='Yes'? 'Deactivate':'Activate'; ?>
          </a>
        </td>
      </tr>
      <?php endwhile; ?>

    </table>
  </div>
</div>

<?php include('partial/footer.php'); ?>
