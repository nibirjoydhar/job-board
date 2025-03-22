<?php
session_start();
include('includes/db.php');

$message = ''; // Initialize message variable
$message_type = ''; // Initialize message type variable
$verification_code = '';

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];
    
    // Check if the verification code is valid
    $sql = "SELECT * FROM users WHERE verification_code = '$verification_code' AND is_verified = 0";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Update user status to verified
        $sql = "UPDATE users SET is_verified = 1 WHERE verification_code = '$verification_code'";
        if ($conn->query($sql) === TRUE) {
            $message = "Congratulations! Your email has been successfully verified. You can now log in and start using Job Board.";
            $message_type = 'success';
        } else {
            $message = "Oops! There was an error verifying your email. Please try again later.";
            $message_type = 'danger';
        }
    } else {
        $message = "The verification code is either invalid or has expired. Please check the link or request a new one.";
        $message_type = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <?php include('headlink.php'); ?>
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

    <!-- Registration Process Indicator (Loading Spinner) -->
    <div id="loading" class="d-none" style="text-align: center; padding: 20px;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Registering...</span>
        </div>
        <p>Verifying your email, please wait...</p>
    </div>

    <div id="result" class="d-none">
        <!-- Your content after verification result -->
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Display loading spinner during email verification
        window.onload = function () {
            document.getElementById("loading").classList.remove("d-none");
            document.getElementById("result").classList.add("d-none");

            // Show the toast message
            let toastElement = document.querySelector('.toast');
            if (toastElement) {
                let toast = new bootstrap.Toast(toastElement);
                toast.show();
            }

            // Redirect to login page after 3 seconds
            setTimeout(function () {
                window.location.href = "login.php";
            }, 3000); // Redirect after 3 seconds
        }
    </script>
</body>

</html>
