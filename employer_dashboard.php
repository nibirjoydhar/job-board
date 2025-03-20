<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Fetch employer profile
$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
$profile_result = $conn->query($profile_sql);

// Fetch job postings by the employer
$job_postings_sql = "SELECT * FROM jobs WHERE employer_id = '$user_id'";
$job_postings_result = $conn->query($job_postings_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Employer Dashboard</title>
    <?php include('headlink.php');?>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Employer Dashboard</h1>
        <div class="row">
            <!-- Left Column (Profile Info) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Your Profile</h2>
                        <?php
                        if ($profile_result->num_rows > 0) {
                            $profile = $profile_result->fetch_assoc();
                            echo "<p><strong>Email:</strong> " . $_SESSION['email'] . "</p>";
                            echo "<p><strong>Phone:</strong> " . $profile['phone'] . "</p>";
                            echo "<p><strong>Address:</strong> " . $profile['address'] . "</p>";
                            echo "<p><strong>Website:</strong> <a href='" . $profile['website'] . "' target='_blank'>" . $profile['website'] . "</a></p>";
                            echo "<p><strong>Description:</strong> " . $profile['bio'] . "</p>";
                        } else {
                            echo "<p>No profile found.</p>";
                        }
                        ?>
                        <div class="text-center mt-3">
                            <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
                            <a href="post_job.php" class="btn btn-primary m-4">Post a Job</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Job Postings) -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Your Job Postings</h2>
                        <hr>
                        <?php
                        if ($job_postings_result->num_rows > 0) {
                            while ($row = $job_postings_result->fetch_assoc()) {
                                // Count applications for this job
                                $job_id = $row['id'];
                                $count_sql = "SELECT COUNT(*) AS total_applications FROM applications WHERE job_id = '$job_id'";
                                $count_result = $conn->query($count_sql);
                                $applications_count = $count_result->fetch_assoc()['total_applications'];

                                echo "<div class='mb-4' id='job-" . $job_id . "'>";
                                echo "<h5>" . $row['title'] . "</h5>";
                                echo "<p>" . $row['description'] . "</p>";
                                echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                                echo "<p><strong>Salary:</strong> " . $row['salary'] . "</p>";
                                echo "<p><strong>Posted At:</strong> " . $row['created_at'] . "</p>";
                                echo "<p><strong>Applicants:</strong> " . $applications_count . " Applied</p>";  // Show application count

                                // Buttons
                                echo "<a href='view_applications.php?job_id=" . $job_id . "' class='btn btn-info'>View Applicants</a> ";
                                echo "<a href='edit_job.php?id=" . $job_id . "' class='btn btn-warning'>Edit</a> ";
                                echo "<button class='btn btn-danger delete-job' data-id='" . $job_id . "'>Delete</button>";
                                echo "</div><hr>";
                            }
                        } else {
                            echo "<p>No job postings yet. <a href='post_job.php'>Post a job now</a>.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('footer.php'); ?>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle the delete button click
            $(".delete-job").on("click", function() {
                var jobId = $(this).data('id');  // Get the job ID from data attribute
                var confirmation = confirm("Are you sure you want to delete this job?");
                
                if (confirmation) {
                    // Make AJAX request to delete the job
                    $.ajax({
                        url: 'delete_job.php',  // The PHP script that deletes the job
                        type: 'POST',
                        data: { job_id: jobId },  // Send the job_id to the backend
                        dataType: 'json',  // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message);  // Show success message
                                // Optionally, remove the job element from the page
                                $("#job-" + jobId).remove();
                            } else {
                                alert(response.message);  // Show error message
                            }
                        },
                        error: function() {
                            alert('Error deleting the job. Please try again.');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
