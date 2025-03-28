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

$profile = ($result->num_rows > 0) ? $result->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('headlink.php');?>
    <title>Profile</title>

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
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Your Profile</h2>
                        <div class="text-center mb-4">
                            <?php if (!empty($profile['profile_photo'])): ?>
                                <img src="<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile Photo" class="profile-photo">
                            <?php else: ?>
                                <img src="images/default-profile.png" alt="Default Profile Photo" class="profile-photo">
                            <?php endif; ?>
                        </div>
                        <?php if ($profile): ?>
                            <table class="table table-striped">
                                <tr><th>Full Name</th><td><?php echo htmlspecialchars($profile['full_name']); ?></td></tr>
                                <tr><th>Bio</th><td><?php echo htmlspecialchars($profile['bio']); ?></td></tr>
                                <tr><th>Phone</th><td><?php echo htmlspecialchars($profile['phone']); ?></td></tr>
                                <tr><th>Address</th><td><?php echo htmlspecialchars($profile['address']); ?></td></tr>
                                <tr><th>LinkedIn</th><td><a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank">Profile</a></td></tr>
                                <tr><th>GitHub</th><td><a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank">Profile</a></td></tr>
                                <tr><th>Website</th><td><a href="<?php echo htmlspecialchars($profile['website']); ?>" target="_blank">Visit</a></td></tr>
                                <tr><th>Skills</th><td><?php echo htmlspecialchars($profile['skills']); ?></td></tr>
                                <tr><th>Experience</th><td><?php echo htmlspecialchars($profile['experience']); ?></td></tr>
                                <?php if (!empty($profile['cv'])): ?>
                                    <tr><th>CV</th><td><a href="<?php echo htmlspecialchars($profile['cv']); ?>" target="_blank">Download CV</a></td></tr>
                                <?php endif; ?>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info">No profile details found.</div>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                            <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
                            <a href="<?php 
                                switch ($_SESSION['role']) {
                                    case 'job_seeker': echo 'dashboard.php'; break;
                                    case 'employer': echo 'employer_dashboard.php'; break;
                                    case 'admin': echo 'admin_dashboard.php'; break;
                                }
                            ?>" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
