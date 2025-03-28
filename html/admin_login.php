<?php
session_start();
include('includes/db.php');

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND role = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            header("Location: admin_dashboard.php");
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid credentials',
                        text: 'The password you entered is incorrect.',
                        showConfirmButton: true
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'No admin found',
                    text: 'No admin found with this email address.',
                    showConfirmButton: true
                });
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <?php include('headlink.php'); ?>

</head>

<body class="bg-light">
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Admin Login</h2>
                        <form method="POST" action="admin_login.php">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification for Successful Login -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        <?php if ($result->num_rows === 0): ?>
            Swal.fire({
                icon: 'error',
                title: 'No admin found',
                text: 'No admin found with this email address.',
                showConfirmButton: true
            });
        <?php endif; ?>
    </script>

    <script>
        <?php if (isset($_SESSION['user_id'])): ?>
            Toastify({
                text: "Welcome, Admin!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "green",
            }).showToast();
        <?php endif; ?>
    </script>
    <?php include('footer.php'); ?>

</body>

</html>