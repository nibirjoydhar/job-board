<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

$user_id = $_SESSION['user_id'];

// Fetch profile details
$sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
} else {
    $profile = null;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Your Profile</h2>
                        <?php if ($profile): ?>
                        <div class="mb-3">
                            <h4>Skills</h4>
                            <p><?php echo htmlspecialchars($profile['skills']); ?></p>
                        </div>
                        <div class="mb-3">
                            <h4>Experience</h4>
                            <p><?php echo htmlspecialchars($profile['experience']); ?></p>
                        </div>
                        <?php if (!empty($profile['resume'])): ?>
                        <div class="mb-3">
                            <h4>Resume</h4>
                            <a href="<?php echo htmlspecialchars($profile['resume']); ?>" target="_blank">Download
                                Resume</a>
                        </div>
                        <?php endif; ?>
                        <?php else: ?>
                        <div class="alert alert-info">No profile details found.</div>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                            <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
                            <?php
                            if ($_SESSION['role'] == 'job_seeker') { ?>
                            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                            <?php
                            } else if ($_SESSION['role'] == 'employer') { ?>
                            <a href="employer_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                            <?php
                            } else if ($_SESSION['role'] == 'admin') { ?>
                            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>