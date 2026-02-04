
<?php 
ob_start(); // Start output buffering
include('partials-front/menu.php');
?>

<!-- Contact Section Starts Here -->
<section class="contact text-center">
    <h2 class="text-center contact-text">Contact Us</h2>
    <p class="text-center contact-text">If you have any questions about our cosmetics products or services, feel free to get in touch with us!</p>

    <?php
    // Display success/failure message if set
    if (isset($_SESSION['contact-msg'])) {
        echo $_SESSION['contact-msg'];
        unset($_SESSION['contact-msg']);
    }
    ?>

    <form action="" method="POST" class="contact-form">
        <fieldset>
            <legend>Contact Us</legend>

            <div class="contact-label">Full Name.</div>
            <input type="text" name="full_name" placeholder="Your Full Name" class="input-responsive" required><br>

            <div class="contact-label">Email.</div>
            <input type="email" name="email" placeholder="Your Email Address" class="input-responsive" required><br>

            <div class="contact-label">Related Brand or Issue</div>
            <select name="brand_id" class="input-responsive">
                <option value="">-- Select Brand or Issue --</option>
                <?php
                $brand_sql = "SELECT brand_id, brand_name FROM brand ORDER BY brand_name";
                $brand_res = mysqli_query($conn, $brand_sql);
                while ($brand = mysqli_fetch_assoc($brand_res)) {
                    echo "<option value='" . $brand['brand_id'] . "'>" . htmlspecialchars($brand['brand_name']) . "</option>";
                }
                ?>
                <option value="0">Other Issue</option>
            </select><br>

            <div class="contact-label">Subject.</div>
            <input type="text" name="subject" placeholder="Subject" class="input-responsive" required><br>

            <div class="contact-label">Message.</div>
            <textarea name="message" rows="5" placeholder="Your Message..." class="input-responsive" required></textarea><br>

            <input type="submit" name="submit" value="Send Message" class="btn btn-primary">
        </fieldset>
    </form>
</section>
<!-- Contact Section Ends Here -->

<?php
// Contact Form Handling
if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $brand_id = isset($_POST['brand_id']) && $_POST['brand_id'] !== '' ? (int)$_POST['brand_id'] : null;
    $date = date("Y-m-d H:i:s");

    // Prepare brand_id value for SQL (use NULL if not set or "Other Issue")
    $brand_value_sql = is_null($brand_id) ? "NULL" : $brand_id;

    // Insert into contact table
    $sql = "INSERT INTO tbl_contact SET
        full_name = '$full_name',
        email = '$email',
        brand_id = $brand_value_sql,
        subject = '$subject',
        message = '$message',
        date = '$date'";

    $res = mysqli_query($conn, $sql);

    // Check success
    if ($res == true) {
        // Email notification to admin
        $admin_email = "miftafeysel1@gmail.com"; 
        $email_subject = "New Contact Message from $full_name";
        $email_body = "
            You have received a new message from your website contact form.

            Full Name: $full_name
            Email: $email
            Subject: $subject
            Message: $message
        ";

         // 2. Headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        mail($admin_email, $email_subject, $email_body, $headers);

// 3. Send email
        $_SESSION['contact-msg'] = "<div class='success'>Thank you, $full_name. Your message has been received!</div>";
    } else {
        $_SESSION['contact-msg'] = "<div class='error'>Something went wrong. Please try again later.</div>";
    }

    // Redirect to avoid resubmission

    header("Location: " . SITEURL . "contact.php");
    exit();
}
?>
    
<?php include('partials-front/footer.php'); ?>
<?php ob_end_flush(); ?>
