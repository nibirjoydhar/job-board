<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Fetch employer profile
$user_id = $_SESSION['user_id'];

// Fetch profile details
$sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$profile = ($result->num_rows > 0) ? $result->fetch_assoc() : null;

// Fetch job postings by the employer
$job_postings_sql = "SELECT * FROM jobs WHERE employer_id = '$user_id'";
$job_postings_result = $conn->query($job_postings_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <?php include('headlink.php'); ?>
    <title>Employer Dashboard</title>
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
        <h1 class="text-center mb-4">Employer Dashboard</h1>
        <a href="post_job.php" class="btn btn-primary">Post a new job</a>
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
                        <div class="text-center mt-3">
                            <a href="post_job.php" class="btn btn-primary">Post a new job</a>
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
   
    <script>
        $(document).ready(function() {
            // Handle the delete button click
            $(".delete-job").on("click", function() {
                var jobId=$(this).data('id'); // Get the job ID from data attribute
                var confirmation=confirm("Are you sure you want to delete this job?");

                if(confirmation) {
                    // Make AJAX request to delete the job
                    $.ajax({
                        url: 'delete_job.php', // The PHP script that deletes the job
                        type: 'POST',
                        data: {
                            job_id: jobId
                        }, // Send the job_id to the backend
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if(response.status==='success') {
                                alert(response.message); // Show success message
                                // Optionally, remove the job element from the page
                                $("#job-"+jobId).remove();
                            } else {
                                alert(response.message); // Show error message
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