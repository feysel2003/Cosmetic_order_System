<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'miftafeysel1@gmail.com'; // ✅ Your Gmail
        $mail->Password   = 'fkxl ndul guxa nfcr';   // ✅ Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($email, $full_name);
        $mail->addAddress('miftafeysel1@gmail.com'); // ✅ Your recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br("From: $full_name ($email)<br><br>" . $message);

        $mail->send();
        echo "<h3>✅ Message sent successfully.</h3>";
    } catch (Exception $e) {
        echo "<h3>❌ Message could not be sent. Error: {$mail->ErrorInfo}</h3>";
    }
}
?>
