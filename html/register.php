<?php
session_start();
// ini_set('display_errors', 1); // Display errors on the page
// ini_set('display_startup_errors', 1); // Display startup errors
// error_reporting(E_ALL); // Report all types of errors

include('includes/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer's autoloader

$message = ''; // Variable to store the message
$message_type = ''; // Variable to store the message type (success/error)

if (isset($_POST['register'])) {


    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Get the user role (e.g., employer, job_seeker)
    $name = $_POST['name'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = 'danger';
    } else {
        // Check if the email already exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $message = "This email is already registered.";
            $message_type = 'danger';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $verification_code = md5(uniqid(rand(), true));

            // Insert the user into the database with is_verified = 0 (not verified)
            $sql = "INSERT INTO users (email, password, role, name, verification_code, is_verified) VALUES ('$email', '$hashed_password', '$role', '$name', '$verification_code', 0)";
            if ($conn->query($sql) === TRUE) {
                // Send verification email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'nibirjoydhar@gmail.com'; // Your Gmail address
                    $mail->Password = 'hqipmshpkhaedrda'; // Your Gmail App Password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('nibirjoydhar@gmail.com', 'Job Board');
                    $mail->addAddress($email); // Add the recipient's email address

                    // Content
                    $mail->Subject = 'Verify your email address';
                    $mail->isHTML(true);  // Enable HTML email format

                    $mail->Body = '
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Verification</title>
    </head>
    <body style="font-family: Arial, sans-serif; color: #333; padding: 20px; background-color: #f4f4f4;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <h2 style="text-align: center; color: #4CAF50;">Welcome to Job Board!</h2>
            <p style="font-size: 16px; line-height: 1.6;">Hello,</p>
            <p style="font-size: 16px; line-height: 1.6;">
                Thank you for signing up for Job Board! We\'re excited to have you join our community of professionals and job seekers.
            </p>
            <p style="font-size: 16px; line-height: 1.6;">
                Before you can start exploring the features, we need to confirm your email address. Please click the button below to verify your email:
            </p>
            <p style="text-align: center;">
                <a href="http://13.52.231.122:8080/verify_email.php?code=' . $verification_code . '"
                    style="background-color: #4CAF50; color: #ffffff; padding: 10px 20px; font-size: 16px; text-decoration: none; border-radius: 5px; display: inline-block;">
                    Verify Email Address
                </a>
            </p>
            <p style="font-size: 16px; line-height: 1.6;">
                If you didn\'t sign up for Job Board, please ignore this email.
            </p>
            <p style="font-size: 16px; line-height: 1.6;">Best regards,</p>
            <p style="font-size: 16px; line-height: 1.6;">The Job Board Team</p>
        </div>
    </body>
    </html>';


                    $mail->send();
                    $message = "A verification email has been sent to your email address. Please verify.";
                    $message_type = 'success';
                } catch (Exception $e) {
                    $message = "Mailer Error: " . $mail->ErrorInfo;
                    $message_type = 'danger';
                }
            } else {
                $message = "Error: " . $conn->error;
                $message_type = 'danger';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('headlink.php'); ?>
    <title>Register</title>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <!-- Toast Notification -->
    <?php if ($message): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-white bg-<?php echo $message_type; ?> border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Register</h2>
                        <form method="POST" action="register.php">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirm_password" class="form-control"
                                    placeholder="Confirm Password" required>
                            </div>
                            <div class="mb-3">
                                <select name="role" class="form-control" required>
                                    <option value="employer">Employer</option>
                                    <option value="job_seeker">Job Seeker</option>
                                </select>
                            </div>
                            <button type="submit" name="register"
                                class="btn btn-primary w-100 animate__animated animate__bounceIn">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php">Already have an account? Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- Toast JavaScript (Bootstrap 5) -->

    <script>
        // Initialize toast if a message exists
        <?php if ($message): ?>
            var toast=new bootstrap.Toast(document.querySelector('.toast'));
            toast.show();
            <?php if($message_type=='success'){ ?>
                setTimeout(function(){ window.location.href = 'profile.php'; }, 3000);
            <?php } ?>

        <?php endif; ?>
    </script>
</body>

</html>