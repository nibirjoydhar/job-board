<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Admin Options</h2>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="manage_users.php" class="btn btn-primary w-100">Manage Users</a>
                            </li>
                            <li class="list-group-item">
                                <a href="manage_jobs.php" class="btn btn-primary w-100">Manage Job Listings</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>

</body>

</html>