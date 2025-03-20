<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('includes/db.php');

$message = ''; // Variable to store the message
$message_type = ''; // Variable to store the message type (success/error)

if (isset($_POST['register'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE users.email='" . $email . "'";
    $result = $conn->query($sql);

    if ($result->num_rows != 0) {
        // If email is already used
        $message = "Registration Failed. This email is already in use. Use a different email or login here.";
        $message_type = 'danger'; // Error toast
    } else {
        // If registration is successful
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful. Redirecting to login page...";
            $message_type = 'success'; // Success toast
            header("Refresh: 3; url=login.php");
        } else {
            $message = "Error: " . $conn->error;
            $message_type = 'danger'; // Error toast
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <?php include('headlink.php');?>

</head>

<body class="bg-light">
<?php include('header.php');?>

    <!-- Toast Notification -->
    <?php if ($message): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-white bg-<?php echo $message_type; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <select name="role" class="form-select" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="job_seeker">Job Seeker</option>
                                    <option value="employer">Employer</option>
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
