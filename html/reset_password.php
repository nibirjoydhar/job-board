<?php
session_start();
include('includes/db.php');
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';
$message_type = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Check if the token exists and is not expired
    date_default_timezone_set('Asia/Dhaka'); // Set Bangladesh time
    $sql = "SELECT * FROM users WHERE reset_token = '$token' AND reset_expires > NOW()";
    $result = $conn->query($sql);
    
    if ($result->num_rows === 1) {
        if (isset($_POST['reset_password'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            // Validate passwords
            if ($new_password !== $confirm_password) {
                $message = "Passwords do not match.";
                $message_type = 'danger';
            } else {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Update the password in the database and clear the reset token
                $conn->query("UPDATE users SET password='$hashed_password', reset_token=NULL, reset_expires=NULL WHERE reset_token='$token'");
                
                $message = "Your password has been successfully reset.";
                $message_type = 'success';
            }
        }
    } else {
        $message = "Invalid or expired token.";
        $message_type = 'danger';
    }
} else {
    $message = "No token provided.";
    $message_type = 'danger';
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('headlink.php'); ?>
    <title>Reset Password</title>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Reset Password</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?>">
                                <?php echo $message; 
                                    // if($message_type=='success'){
                                    //     echo "<br>Redirecting to login page.";
                                    //     header("Refresh: 2; url=login.php");
                                    // }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="reset_password.php?token=<?php echo $token; ?>">
                            <div class="mb-3">
                                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-primary w-100">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
 
</body>
</html>
