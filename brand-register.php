<?php  
ob_start(); // Start output buffering
?>

<?php include('partials-front/menu.php'); ?> 

<div class="customer-form-container">
    <h1>Register Account</h1>

    <?php
    // Display any registration messages and then clear them
    if (isset($_SESSION['register-msg'])) {
        echo $_SESSION['register-msg'];
        unset($_SESSION['register-msg']);
    }
    ?>

    <form method="POST" action="" onsubmit="return validateForm();">
        <input type="text" name="name" placeholder="Brand Name" required><br>
        <input type="email" name="email" placeholder="Brand Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <textarea name="description" placeholder="Brand Description" class="input-responsive"></textarea><br>

        <!-- New payment-account fields -->
        <input type="text" name="cbe_account" placeholder="CBE Account Number" required><br>
        <input type="text" name="telebirr_account" placeholder="TeleBirr Account Number" required><br>
        <input type="text" name="awash_account" placeholder="Awash Account Number" required><br>

        <!-- Terms and Conditions -->
        <input type="checkbox" id="termsCheckbox">
        <label for="termsCheckbox">
            I agree to the <a href="#" onclick="showTerms(event)">Terms and Conditions</a>
        </label><br><br>

        <input type="submit" name="submit" value="Register">
    </form>

    <div class="form-footer">
        Already have an account? <a href="customer-login.php">Login here</a>
    </div>
</div>

<!-- Modal for Terms and Conditions -->
<div class="modal contact-form" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
        <button type="button" class="btn-close" onclick="hideTerms()"></button>
      </div>
      <div class="modal-body">
        <p>
            Welcome to our Cosmetic Order and Delivery System. By registering a brand account, you agree to the following terms:
        </p>
        <ul>
            <li>✅ You confirm that the brand details provided are accurate and authorized by your business.</li>
            <li>✅ You agree to comply with Ethiopian consumer protection laws and e-commerce regulations.</li>
            <li>✅ Payment information (CBE, Telebirr, Awash) is securely processed and must be valid.</li>
            <li>✅ Any misuse, fake brand claims, or fraudulent activities may result in account termination and legal action.</li>
            <li>✅ We reserve the right to update these terms to reflect changes in law or business operations.</li>
            <li>✅ You consent to store necessary data for order fulfillment and communication under Ethiopian data privacy practices.</li>
        </ul>
        <p>
            Please review and accept these terms before proceeding with your brand registration.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="hideTerms()">Close</button>
        <button type="button" class="btn btn-primary" onclick="hideTerms()">I Agree</button>
      </div>
    </div>
  </div>
</div>

<!-- Overlay -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;" onclick="hideTerms()"></div>

<script>
// Show Terms Modal
function showTerms(event) {
    event.preventDefault();
    document.getElementById('termsModal').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

// Hide Terms Modal
function hideTerms() {
    document.getElementById('termsModal').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

// Validate if Terms are checked
function validateForm() {
    var checkbox = document.getElementById('termsCheckbox');
    if (!checkbox.checked) {
        alert("You must agree to the Terms and Conditions to register.");
        return false;
    }
    return true;
}
</script>

<?php
if (isset($_POST['submit'])) {
    // Sanitize all inputs
    $name              = mysqli_real_escape_string($conn, $_POST['name']);
    $email             = mysqli_real_escape_string($conn, $_POST['email']);
    $password          = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $description       = mysqli_real_escape_string($conn, $_POST['description']);
    $cbe_account       = mysqli_real_escape_string($conn, $_POST['cbe_account']);
    $telebirr_account  = mysqli_real_escape_string($conn, $_POST['telebirr_account']);
    $awash_account     = mysqli_real_escape_string($conn, $_POST['awash_account']);

    // Check for duplicate email
    $check_sql = "SELECT * FROM brand WHERE brand_email='$email'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Email already in use
        $_SESSION['register-msg'] = "<div class='login-error'>Email already registered.</div>";
    } else {
        // Insert new brand, including payment-account columns
        $sql = "INSERT INTO brand (
                    brand_name, 
                    brand_email, 
                    password, 
                    brand_description,
                    cbe_account,
                    telebirr_account,
                    awash_account
                ) VALUES (
                    '$name', 
                    '$email', 
                    '$password', 
                    '$description',
                    '$cbe_account',
                    '$telebirr_account',
                    '$awash_account'
                )";

        if (mysqli_query($conn, $sql)) {
            // Success → redirect to login
            $_SESSION['register-msg'] = "<div class='login-success'>Registration successful. Please login.</div>";
            header('Location:'.SITEURL.'customer-login.php');
            exit();
        } else {
            // Insert failed
            $_SESSION['register-msg'] = "<div class='login-error'>Failed to register.</div>";
        }
    }
}
?>

<?php include('partials-front/footer.php'); ?>
<?php ob_end_flush(); ?> 