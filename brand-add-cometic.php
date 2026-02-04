<?php
// brand/add-cosmetic.php
ob_start();
include('partials-front/brand-menu.php');

// 1) Ensure brand is logged in
if (!isset($_SESSION['brand_id'])) {
    $_SESSION['unauthorize'] = "<div class='error'>Please login first.</div>";
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}
$brand_id = (int) $_SESSION['brand_id'];

// 2) Check brand's active status
$check_sql = "SELECT active FROM brand WHERE brand_id = $brand_id LIMIT 1";
$check_res = mysqli_query($conn, $check_sql);
$brand_active = 'No'; // default to No

if ($check_res && mysqli_num_rows($check_res) === 1) {
    $brand_data = mysqli_fetch_assoc($check_res);
    $brand_active = $brand_data['active'];
}
?>

<div class="main-content">
  <div class="wraper">
    <h1>Add Cosmetic</h1>
    <br><br>

    <?php
      if (isset($_SESSION['upload'])) {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
      }
      if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
      }

      // 3) Block form if brand is not active
      if ($brand_active !== 'Yes') {
          echo "<div class='alert alert-warning'>Your account is currently inactive. You cannot add new products. Please contact the admin for assistance.</div>";
      } else {
    ?>

    <form action="" method="post" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title:</td>
          <td><input type="text" name="title" placeholder="Title of the cosmetic" required></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><textarea name="description" cols="30" rows="5" placeholder="Description" required></textarea></td>
        </tr>
        <tr>
          <td>Price:</td>
          <td><input type="number" name="price" step="0.01" placeholder="Price" required></td>
        </tr>
        <tr>
          <td>Select Image:</td>
          <td><input type="file" name="image"></td>
        </tr>
        <tr>
          <td>Category:</td>
          <td>
            <select name="catagory" required>
              <?php
                $catRes = mysqli_query($conn, "SELECT * FROM tbl_catagory WHERE active='Yes'");
                if (mysqli_num_rows($catRes) > 0) {
                  while ($catRow = mysqli_fetch_assoc($catRes)) {
                    echo "<option value='{$catRow['id']}'>{$catRow['title']}</option>";
                  }
                } else {
                  echo "<option value='0'>No Category Found</option>";
                }
              ?>
            </select>
          </td>
        </tr>
       <!-- <tr>
          <td>Featured:</td>
          <td>
            <input type="radio" name="featured" value="Yes"> Yes
            <input type="radio" name="featured" value="No" checked> No
          </td>
        </tr>
        <tr>
          <td>Active:</td>
          <td>
            <input type="radio" name="active" value="Yes" checked> Yes
            <input type="radio" name="active" value="No"> No
          </td>
        </tr>
        <tr> -->
          <td colspan="2">
            <input type="submit" name="submit" value="Add Cosmetic" class="btn-secondary">
          </td>
        </tr>
      </table>
    </form>

    <?php } // End if brand is active ?>

    <?php
    // 4) Handle form submission
    if ($brand_active === 'Yes' && isset($_POST['submit'])) {
        $title       = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price       = (float) $_POST['price'];
        $catagory    = (int)   $_POST['catagory'];
        $featured    = isset($_POST['featured']) ? $_POST['featured'] : 'No';
        $active      = isset($_POST['active'])   ? $_POST['active']   : 'No';

        // 5) Handle image upload
        $image_name = "";
        if (!empty($_FILES['image']['name'])) {
            $origName  = $_FILES['image']['name'];
            $tmpPath   = $_FILES['image']['tmp_name'];
            $ext       = pathinfo($origName, PATHINFO_EXTENSION);
            $image_name= "cosmetic-" . rand(1000,9999) . "." . $ext;
            $dest      = "image/cosmotic/" . $image_name;
            if (!move_uploaded_file($tmpPath, $dest)) {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                header('Location: '.SITEURL.'brand-add-cometic.php');
                exit();
            }
        }

        // 6) Insert into database, including brand_id
        $sql = "
          INSERT INTO tbl_comotic
            (title, description, price, image_name, catagory_id, featured, active, brand_id)
          VALUES
            ('$title', '$description', $price, '$image_name', $catagory, '$featured', '$active', $brand_id)
        ";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['add'] = "<div class='success'>Cosmetic added successfully.</div>";
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to add cosmetic.</div>";
        }
        header('Location: '.SITEURL.'brand-manage-cosmetic.php');
        exit();
    }
    ?>

  </div>
</div>

<?php
include('partials-front/brand-footer.php');
ob_end_flush();
?>
