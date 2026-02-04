<?php  
ob_start(); // Start output buffering
?>

<?php include('partials-front/menu.php'); 

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['login-msg'] = "<div class='error text-center'>You must log in to place an order.</div>";
    header('location:' . SITEURL . 'customer-login.php');
    exit();
}

// 1) Fetch selected cosmetic + brand + brand payment accounts
if (isset($_GET['cosmotic_id'])) {
    $cosmotic_id = (int)$_GET['cosmotic_id'];
    $sql = "
      SELECT c.*, b.brand_id, b.brand_name,
             b.cbe_account, b.telebirr_account, b.awash_account
      FROM tbl_comotic AS c
      LEFT JOIN brand AS b
        ON c.brand_id = b.brand_id
      WHERE c.id = $cosmotic_id
        AND c.active = 'Yes'
    ";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) !== 1) {
        header('location:' . SITEURL);
        exit();
    }
    $row = mysqli_fetch_assoc($res);
    // cosmetic fields
    $title         = $row['title'];
    $price         = $row['price'];
    $description   = $row['description'];
    $image_name    = $row['image_name'];
    // brand fields
    $brand_id         = $row['brand_id'];
    $brand_name       = $row['brand_name'];
    $cbe_account      = $row['cbe_account'];
    $telebirr_account = $row['telebirr_account'];
    $awash_account    = $row['awash_account'];
} else {
    header('location:' . SITEURL);
    exit();
}
?>

<!-- cosmotic sEARCH Section Starts Here -->
<section class="cosmotic-search">
    <div class="container">    
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order" enctype="multipart/form-data">
            <fieldset>
                <legend>Selected Cosmetic</legend>

                <div class="cosmotic-menu-img">
                <?php 
                    // display cosmetic image
                    if (empty($image_name)) {
                        echo "<div class='error'> Image Not Available.</div>";
                    } else {
                        ?>
                        <img src="<?php echo SITEURL; ?>image/cosmotic/<?php echo $image_name; ?>" 
                             alt="<?php echo htmlspecialchars($title); ?>" 
                             class="img-responsive img-curve">
                        <?php
                    }
                ?>
                </div>

                <div class="cosmotic-menu-desc">
                    <h3><?php echo htmlspecialchars($title); ?></h3>
                    <input type="hidden" name="cosmotic" value="<?php echo htmlspecialchars($title); ?>">
                    <input type="hidden" name="price"    value="<?php echo $price; ?>">
                    <input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>">

                    <p class="cosmotic-price">ETB. <?php echo number_format($price,2); ?></p>

                    <div class="order-label">Quantity</div>
                    <input type="number" name="quantity" class="input-responsive" value="1" required>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Feysl Mifta" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. +251 919234567" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@Feysel.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
            </fieldset>

            <fieldset>
                <legend>Payment Details</legend>
                <p>Please transfer to one of the following <?php echo htmlspecialchars($brand_name); ?> accounts:</p>
                <ul>
                  <?php if ($cbe_account): ?>
                    <li>CBE: <?php echo htmlspecialchars($cbe_account); ?></li>
                  <?php endif; ?>
                  <?php if ($telebirr_account): ?>
                    <li>Telebirr: <?php echo htmlspecialchars($telebirr_account); ?></li>
                  <?php endif; ?>
                  <?php if ($awash_account): ?>
                    <li>Awash: <?php echo htmlspecialchars($awash_account); ?></li>
                  <?php endif; ?>
                </ul>
                <div class="order-label">Upload Payment Proof</div>
                <input type="file" name="payment_proof" class="input-responsive" accept="image/*" required>
            </fieldset>

            <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
        </form>

        <?php
        // handle form submission
        if (isset($_POST['submit'])) {
            $customer_id      = $_SESSION['customer_id'];
            $cosmotic         = mysqli_real_escape_string($conn, $_POST['cosmotic']);
            $price            = (float)$_POST['price'];
            $quantity         = (int)$_POST['quantity'];
            $total            = $price * $quantity;
            $order_date       = date("Y-m-d H:i:s");
            $status           = "Ordered";
            $customer_name    = mysqli_real_escape_string($conn, $_POST['full-name']);
            $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
            $customer_email   = mysqli_real_escape_string($conn, $_POST['email']);
            $customer_address = mysqli_real_escape_string($conn, $_POST['address']);
            $brand_id         = (int)$_POST['brand_id'];

            // handle payment proof upload
            $proof_name = "";

if (!empty($_FILES['payment_proof']['name'])) {
    $orig       = $_FILES['payment_proof']['name'];
    $tmp        = $_FILES['payment_proof']['tmp_name'];
    $ext        = pathinfo($orig, PATHINFO_EXTENSION);
    $proof_name = "proof-" . time() . rand(100, 999) . "." . $ext;
    $dest       = "image/payment_proofs/" . $proof_name;

    // Check for file upload error
    if ($_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
        $error_code = $_FILES['payment_proof']['error'];
        $error_msg = match ($error_code) {
            1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
            2 => "The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.",
            3 => "The uploaded file was only partially uploaded.",
            4 => "No file was uploaded.",
            6 => "Missing a temporary folder.",
            7 => "Failed to write file to disk.",
            8 => "A PHP extension stopped the file upload.",
            default => "Unknown upload error.",
        };
        echo "<div class='error text-center'>Upload failed: $error_msg (Error code: $error_code)</div>";
        // Prevent further processing
        exit();
    }

    // Check if tmp file exists and move it
    if (!is_uploaded_file($tmp)) {
        echo "<div class='error text-center'>The temporary file is missing or invalid.</div>";
        exit();
    }

    if (!move_uploaded_file($tmp, $dest)) {
        echo "<div class='error text-center'>Failed to move uploaded file. Check folder permissions.</div>";
        exit();
    }
}


            // save the order in database
            $sql2 = "
              INSERT INTO tbl_order
                (cosmotic, price, quantity, total, order_date,
                 status, customer_name, customer_id, customer_contact,
                 customer_email, customer_address, brand_id, payment_proof)
              VALUES
                ('$cosmotic',$price,$quantity,$total,'$order_date',
                 '$status','$customer_name',$customer_id,'$customer_contact',
                 '$customer_email','$customer_address',$brand_id,'$proof_name')
            ";
            if (mysqli_query($conn, $sql2)) {
                $_SESSION['order'] = "<div class='success text-center'>Ordered Successfully.</div>";
            } else {
                $_SESSION['order'] = "<div class='error text-center'>Failed to order.</div>";
            }
            header('location:'.SITEURL);
            exit();
        }
        ?>

    </div>
</section>
<!-- cosmotic sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
<?php ob_end_flush(); ?>  
