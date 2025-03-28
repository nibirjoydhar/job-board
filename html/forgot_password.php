<?php
session_start();
include('includes/db.php');
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';
$message_type = '';

if (isset($_POST['reset'])) {
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows === 1) {
        $token = bin2hex(random_bytes(50));date_default_timezone_set('Asia/Dhaka'); // Set Bangladesh time

        date_default_timezone_set('Asia/Dhaka'); // Set Bangladesh time
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store token in the database
        $conn->query("UPDATE users SET reset_token='$token', reset_expires='$expires' WHERE email='$email'");

        // Send reset email
        $reset_link = "http://3.92.1.108:8080/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $body = "
        <p>Hello,</p>
        <p>You recently requested a password reset for your account. Click the link below to reset your password:</p>
        <p><a href='$reset_link' style='color: #007bff; text-decoration: none; font-weight: bold;'>Reset Password</a></p>
        <p>This link will expire in <strong>1 hour</strong> at <strong>$expires (Bangladesh Time)</strong>. If you did not request a password reset, please ignore this email.</p>
        <p>Thank you,<br>Job Board Team</p>
    ";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nibirjoydhar@gmail.com'; // Your email
            $mail->Password = 'hqip mshp khae drda'; // Your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Enable SMTP debugging (2 = messages only)
            // $mail->SMTPDebug = 2;

            // Recipients
            $mail->setFrom('nibirjoydhar@gmail.com', 'Job Board');
            $mail->addAddress($email); // Add recipient email

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            $message = "A password reset link has been sent to your email.";
            $message_type = 'success';
        } catch (Exception $e) {
            $message = "Failed to send email. Error: {$mail->ErrorInfo}";
            $message_type = 'danger';
        }
    } else {
        $message = "No account found with this email.";
        $message_type = 'danger';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('headlink.php'); ?>
    <title>Forgot Password</title>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Forgot Password</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="forgot_password.php">
                            <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>
                            <button type="submit" name="reset" class="btn btn-primary w-100">Send Reset Link</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>
