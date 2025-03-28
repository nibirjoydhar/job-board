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
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $email;
                    header("Refresh: 0; url=index.php"); // Redirect after login
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
                        <h2 class="card-title text-center mb-4">Login</h2>
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>
                            <button type="submit" name="login"
                                class="btn btn-primary w-100 animate__animated animate__bounceIn">Login</button>
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

    <!-- Toast JavaScript (Bootstrap 5) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize toast if a message exists
        <?php if ($message): ?>
            var toast = new bootstrap.Toast(document.querySelector('.toast'));
            toast.show();
        <?php endif; ?>
    </script>

</body>

</html>