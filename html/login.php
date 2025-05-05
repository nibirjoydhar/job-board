<?php
session_start();
include('includes/db.php');

$message = ''; // Variable to store the message
$message_type = ''; // Variable to store the message type (success/error)

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists and is not an admin
    $sql = "SELECT * FROM users WHERE email = '$email' AND role != 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if the email is verified
        if ($user['is_verified'] == 0) {
            $message = "Please verify your email before logging in.";
            $message_type = 'danger'; // Error toast
        } else {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['status'] = $user['status'];

                // Check if the account is active
                if ($_SESSION['status'] == 'active') {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $email;
                    
                    // Check if the user has a premium account
                    $premium_check = "SELECT * FROM card_details WHERE user_id = '" . $user['id'] . "' LIMIT 1";
                    $premium_result = $conn->query($premium_check);
                    $_SESSION['is_premium'] = ($premium_result->num_rows > 0) ? 1 : 0;
                    
                    echo "<script>
                        localStorage.setItem('toastMessage', 'Welcome, " . $user['name'] . "!');
                        window.location.href = 'index.php';
                    </script>";
                    exit;
                } else {
                    $message = "Your account is inactive. Please contact support.";
                    $message_type = 'danger'; // Error toast
                    header("Refresh: 2; url=deactive.php");
                }
            } else {
                $message = "Invalid credentials. Please check your email and password.";
                $message_type = 'danger'; // Error toast
            }
        }
    } else {
        $message = "No user found with this email. Please register.";
        $message_type = 'danger'; // Error toast
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('headlink.php'); ?>
    <title>Login</title>
</head>
<body class="bg-light">
    <?php include('header.php'); ?>
    
    <!-- Toast Notification for Errors -->
    <?php if ($message): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let toastHTML = `
                <div class="toast show position-fixed top-0 end-0 p-3" style="z-index: 1050;" role="alert">
                    <div class="toast-header bg-<?php echo $message_type; ?> text-white">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body"><?php echo $message; ?></div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', toastHTML);
                setTimeout(() => { document.querySelector('.toast').remove(); }, 3000);
            });
        </script>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login</h2>
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php">Don't have an account? Register</a><br>
                            <a href="forgot_password.php">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
