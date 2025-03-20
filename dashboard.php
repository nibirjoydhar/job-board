<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Fetch job seeker profile
$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
$profile_result = $conn->query($profile_sql);

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
    <?php include('headlink.php');?>
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
                        <h2 class="card-title">Your Profile</h2>
                        <?php
                        if ($profile_result->num_rows > 0) {
                            $profile = $profile_result->fetch_assoc();
                            echo "<p><strong>Full Name:</strong> " . $profile['full_name'] . "</p>";
                            echo "<p><strong>Email:</strong> " . $_SESSION['email'] . "</p>";
                            echo "<p><strong>Phone:</strong> " . $profile['phone'] . "</p>";
                            echo "<p><strong>Address:</strong> " . $profile['address'] . "</p>";
                            echo "<p><strong>LinkedIn:</strong> <a href='" . $profile['linkedin'] . "' target='_blank'>" . $profile['linkedin'] . "</a></p>";
                            echo "<p><strong>GitHub:</strong> <a href='" . $profile['github'] . "' target='_blank'>" . $profile['github'] . "</a></p>";
                            echo "<p><strong>Website:</strong> <a href='" . $profile['website'] . "' target='_blank'>" . $profile['website'] . "</a></p>";
                            echo "<p><strong>Skills:</strong> " . $profile['skills'] . "</p>";
                            echo "<p><strong>Experience:</strong> " . $profile['experience'] . "</p>";
                            if (!empty($profile['cv'])) {
                                echo "<p><strong>Resume:</strong> <a href='" . $profile['cv'] . "' target='_blank'>Download Resume</a></p>";
                            } else {
                                echo "<p><strong>Resume:</strong> Not provided</p>";
                            }
                        } else {
                            echo "<p>No profile found.</p>";
                        }
                        ?>
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
