<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('includes/db.php');

if (isset($_POST['register'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $sql = "SELECT * FROM users WHERE users.email=" . "'$email'";
    $result = $conn->query($sql);

    if ($result->num_rows != 0) {
        echo "Registration Failed.<br>This email is already in use.<br>Use different email or login here. <a href='login.php'>Login here</a>";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. <br> Redirecting to login page...";
            header("Refresh: 2; url=login.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>

<body class="bg-light">
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
</body>

</html>