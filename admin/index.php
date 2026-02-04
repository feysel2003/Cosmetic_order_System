<?php include('partial/menu.php'); ?>  

<div class="wraper">
  <h1 class="text-center">DASHBOARD</h1>

  <br><br>
  <?php 
  if(isset($_SESSION['login'])) {
      echo $_SESSION['login'];
      unset($_SESSION['login']);
  }
  ?>
  <br><br>

  <div class="dashboard-grid">

    <!-- Total Customers -->
    <div class="col-4">
      <?php
      $sql5 = "SELECT * FROM tbl_customer";
      $res5 = mysqli_query($conn, $sql5);
      $count5 = mysqli_num_rows($res5);
      ?>
      <h1><?php echo $count5; ?></h1>
      <br>Customers
    </div>

    <!-- Total Brands -->
    <div class="col-4">
      <?php
      $sql6 = "SELECT * FROM brand";
      $res6 = mysqli_query($conn, $sql6);
      $count6 = mysqli_num_rows($res6);
      ?>
      <h1><?php echo $count6; ?></h1>
      <br>Brands
    </div>

    <!-- Categories Count -->
    <div class="col-4">
      <?php 
      $sql = "SELECT * FROM tbl_catagory";
      $res = mysqli_query($conn, $sql);
      $count = mysqli_num_rows($res);
      ?>
      <h1><?php echo $count; ?></h1>
      <br>Categories
    </div>

    <!-- Cosmetics Count -->
    <div class="col-4">
      <?php 
      $sql2 = "SELECT * FROM tbl_comotic";
      $res2 = mysqli_query($conn, $sql2);
      $count2 = mysqli_num_rows($res2);
      ?>
      <h1><?php echo $count2; ?></h1>
      <br>Cosmetics
    </div>

    <!-- Total Orders -->
    <div class="col-4">
      <?php 
      $sql3 = "SELECT * FROM tbl_order";
      $res3 = mysqli_query($conn, $sql3);
      $count3 = mysqli_num_rows($res3);
      ?>
      <h1><?php echo $count3; ?></h1>
      <br>Total Orders
    </div>

    <!-- Revenue Generated -->
    <div class="col-4 Revenue">
      <?php
      $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
      $res4 = mysqli_query($conn, $sql4);
      $row4 = mysqli_fetch_assoc($res4);
      $total_revenue = $row4['Total'] ?? 0;
      ?>
      <h1>ETB. <?php echo number_format($total_revenue, 2); ?></h1>
      <br>Revenue Generated
    </div>
  </div>
</div>

<?php include('partial/footer.php'); ?>
