<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Fetch job seeker profile
$user_id = $_SESSION['user_id'];

// Fetch profile details
$sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$profile = ($result->num_rows > 0) ? $result->fetch_assoc() : null;

// Fetch applied jobs
$applied_jobs_sql = "SELECT jobs.*, applications.applied_at 
                     FROM applications 
                     JOIN jobs ON applications.job_id = jobs.id 
                     WHERE applications.user_id = '$user_id'";
$applied_jobs_result = $conn->query($applied_jobs_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Job Seeker Dashboard</title>
    <?php include('headlink.php'); ?>
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
        <h1 class="text-center mb-4">Job Seeker Dashboard</h1>
        <div class="row">
            <!-- Left Column (Profile Info) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Your Profile</h2>
                        <div class="text-center mb-4">
                            <?php if (!empty($profile['profile_photo'])): ?>
                                <img src="<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile Photo"
                                    class="profile-photo">
                            <?php else: ?>
                                <img src="images/default-profile.png" alt="Default Profile Photo" class="profile-photo">
                            <?php endif; ?>
                        </div>
                        <?php if ($profile): ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>Full Name</th>
                                    <td><?php echo htmlspecialchars($profile['full_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Bio</th>
                                    <td><?php echo htmlspecialchars($profile['bio']); ?></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td><?php echo htmlspecialchars($profile['phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo htmlspecialchars($profile['address']); ?></td>
                                </tr>
                                <tr>
                                    <th>LinkedIn</th>
                                    <td><a href="<?php echo htmlspecialchars($profile['linkedin']); ?>"
                                            target="_blank">Profile</a></td>
                                </tr>
                                <tr>
                                    <th>GitHub</th>
                                    <td><a href="<?php echo htmlspecialchars($profile['github']); ?>"
                                            target="_blank">Profile</a></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td><a href="<?php echo htmlspecialchars($profile['website']); ?>"
                                            target="_blank">Visit</a></td>
                                </tr>
                                <tr>
                                    <th>Skills</th>
                                    <td><?php echo htmlspecialchars($profile['skills']); ?></td>
                                </tr>
                                <tr>
                                    <th>Experience</th>
                                    <td><?php echo htmlspecialchars($profile['experience']); ?></td>
                                </tr>
                                <?php if (!empty($profile['cv'])): ?>
                                    <tr>
                                        <th>CV</th>
                                        <td><a href="<?php echo htmlspecialchars($profile['cv']); ?>" target="_blank">Download
                                                CV</a></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info">No profile details found.</div>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                            <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Applied Jobs) -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Applied Jobs</h2>
                        <hr>
                        <?php
                        if ($applied_jobs_result->num_rows > 0) {
                            while ($row = $applied_jobs_result->fetch_assoc()) {
                                echo "<div class='mb-4'>";
                                echo "<h5>" . $row['title'] . "</h5>";
                                echo "<p>" . $row['description'] . "</p>";
                                echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                                echo "<p><strong>Salary:</strong> " . $row['salary'] . "</p>";
                                echo "<p><strong>Applied At:</strong> " . $row['applied_at'] . "</p>";
                                echo "</div><hr>";
                            }
                        } else {
                            echo "<p>No jobs applied yet.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>