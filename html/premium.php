<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $cardholder_name = $_POST['cardholder_name'];

    // Simulating payment processing (In a real system, integrate a payment gateway like Stripe)
    if (!empty($card_number) && !empty($expiry_date) && !empty($cvv) && !empty($cardholder_name)) {
        $_SESSION['is_premium'] = 1; // Mark user as premium
        // After inserting card details, update the `is_premium` field for the user
        $update_premium_status = "UPDATE users SET is_premium = 1 WHERE id = '$user_id'";
        $conn->query($update_premium_status);

        header("Location: profile.php?status=success");
        exit();
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Pro Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header text-center bg-primary text-white">
                <h4>Become a Pro Member</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Cardholder Name</label>
                        <input type="text" name="cardholder_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" name="card_number" class="form-control" maxlength="16" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="month" name="expiry_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CVV</label>
                            <input type="text" name="cvv" class="form-control" maxlength="3" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Upgrade to Pro</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>