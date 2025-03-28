<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('headlink.php'); ?>
    <title>Account Deactivated</title>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f8f9fa;
    }

    .card {
        max-width: 400px;
        width: 100%;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card img {
        max-width: 100px;
        margin: 20px auto;
    }
    </style>
</head>

<body>
    <div class="card p-4">
        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" alt="Warning Icon">
        <h3 class="text-danger">Account Deactivated</h3>
        <p>Your account has been deactivated by the administrator. You are unable to log in at this time.</p>
        <p>If you believe this is a mistake, please contact support.</p>
        <a href="mailto:nibirjoydhar@gmail.com" class="btn btn-primary">Contact Support</a>
        <a href="index.php" class="btn btn-secondary mt-2">Back to Home</a>
    </div>
</body>

</html>