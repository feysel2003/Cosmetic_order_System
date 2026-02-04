<?php
// brand/update-cosmotic.php
ob_start();
include('partials-front/brand-menu.php');

// 1) Ensure brand is logged in
if (!isset($_SESSION['brand_id'])) {
    header('Location: ' . SITEURL . 'customer-login.php');
    exit();
}
$brand_id = (int) $_SESSION['brand_id'];

// 2) Fetch existing cosmetic, ensure it belongs to this brand
if (!isset($_GET['id'])) {
    header('Location: ' . SITEURL . 'brand-manage-cosmetic.php');
    exit();
}
$id = (int) $_GET['id'];

$sql    = "SELECT * FROM tbl_comotic 
           WHERE id = $id 
             AND brand_id = $brand_id";
$res    = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) !== 1) {
    // Not found or not owned by this brand
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access.</div>";
    header('Location: ' . SITEURL . 'brand-manage-cosmetic.php');
    exit();
}

$row = mysqli_fetch_assoc($res);
$title           = $row['title'];
$description     = $row['description'];
$price           = $row['price'];
$current_image   = $row['image_name'];
$current_cat     = $row['catagory_id'];
//$featured        = $row['featured'];
//$active          = $row['active'];
?>

<div class="main-content">
  <div class="wraper">
    <h1>Update Cosmetic</h1>
    <br><br>

    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title:</td>
          <td><input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td>
            <textarea name="description" cols="30" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
          </td>
        </tr>
        <tr>
          <td>Price:</td>
          <td><input type="number" name="price" value="<?php echo $price; ?>" step="0.01"></td>
        </tr>
        <tr>
          <td>Current Image:</td>
          <td>
            <?php if (empty($current_image)): ?>
              <div class="error">Image Not Available.</div>
            <?php else: ?>
              <img src="<?php echo SITEURL; ?>image/cosmotic/<?php echo $current_image; ?>"
                   alt="<?php echo htmlspecialchars($title); ?>" width="150px">
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td>Select New Image:</td>
          <td><input type="file" name="image"></td>
        </tr>
        <tr>
          <td>Category:</td>
          <td>
            <select name="catagory">
              <?php
              $catRes = mysqli_query($conn, "SELECT * FROM tbl_catagory WHERE active='Yes'");
              while ($catRow = mysqli_fetch_assoc($catRes)) {
                  $sel = ($catRow['id'] == $current_cat) ? "selected" : "";
                  echo "<option value='{$catRow['id']}' $sel>{$catRow['title']}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
       <!-- <tr>
          <td>Featured:</td>
          <td>
            <input type="radio" name="featured" value="Yes" <?php if($featured=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="featured" value="No"  <?php if($featured=="No")  echo "checked"; ?>> No
          </td>
        </tr>
        <tr>
          <td>Active:</td>
          <td>
            <input type="radio" name="active" value="Yes" <?php if($active=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="active" value="No"  <?php if($active=="No")  echo "checked"; ?>> No
          </td>
        </tr>-->
        <tr>
          <td>
            <input type="hidden" name="id"            value="<?php echo $id; ?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="submit" name="submit" value="Update Cosmetic" class="btn-secondary">
          </td>
        </tr>
      </table>
    </form>

    <?php
    // 3) Handle the form submission
    if (isset($_POST['submit'])) {
        // sanitize inputs
        $title       = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price       = (float) $_POST['price'];
        $catagory    = (int)   $_POST['catagory'];
        //$featured    = $_POST['featured'];
        //$active      = $_POST['active'];

        // handle image upload
        $image_name = $_POST['current_image'];
        if (!empty($_FILES['image']['name'])) {
            $tmp       = $_FILES['image']['tmp_name'];
            $origName  = $_FILES['image']['name'];
            $ext       = pathinfo($origName, PATHINFO_EXTENSION);
            $image_name= "Cosmetic-".rand(1000,9999).".".$ext;
            if (!move_uploaded_file($tmp, "../image/cosmotic/".$image_name)) {
                $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                header('Location: '.SITEURL.'brand-manage-cosmetic.php');
                exit();
            }
            // remove old image
            if (!empty($_POST['current_image'])) {
                @unlink("../image/cosmotic/".$_POST['current_image']);
            }
        }

        // 4) Update, scoping to this brand_id
        $updateSQL = "
          UPDATE tbl_comotic SET
              title       = '$title',
              description = '$description',
              price       = $price,
              image_name  = '$image_name',
              catagory_id = $catagory,
              featured    = '$featured',
              active      = '$active'
          WHERE id = $id
            AND brand_id = $brand_id
        ";
        if (mysqli_query($conn, $updateSQL)) {
            $_SESSION['update'] = "<div class='success'>Cosmetic updated successfully.</div>";
        } else {
            $_SESSION['update'] = "<div class='error'>Failed to update cosmetic.</div>";
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
