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
    <style>
        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffc107;
        }
    </style>
</head>

<body class="bg-light">
    <?php include('header.php');
    $upcapital = "Update";
    $upsmall = "update";

    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Your Profile</h2>
                        <!-- Profile Photo -->
                        <div class="text-center mb-4">
                            <?php if (!empty($profile['profile_photo'])): ?>
                                <img src="<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile Photo"
                                    class="profile-photo">
                            <?php else: ?>
                                <img src="images/default-profile.png" alt="Default Profile Photo" class="profile-photo">
                            <?php endif; ?>
                        </div>
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
                            <div class="alert alert-info"><?php $upsmall = "create";
                            $upcapital = "Create"; ?>No profile details
                                found.</div>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                            <a href="<?php echo $upsmall ?>_profile.php" class="btn btn-primary"><?php echo $upcapital ?>
                                Profile</a>
                            <?php
                            if ($_SESSION['role'] == 'job_seeker') { ?>
                                <a href=" dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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