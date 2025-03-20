<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

if (isset($_GET['job_id'])) {
    $job_id = $conn->real_escape_string($_GET['job_id']);
    $employer_id = $_SESSION['user_id'];

    // Verify the job belongs to the employer
    $check_sql = "SELECT * FROM jobs WHERE id = '$job_id' AND employer_id = '$employer_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows === 0) {
        echo "<div class='alert alert-danger'>You do not have permission to view this job's applications.</div>";
        exit();
    }

    // Handle application status update
    if (isset($_POST['update_status'])) {
        $application_id = $conn->real_escape_string($_POST['application_id']);
        $status = $conn->real_escape_string($_POST['status']);

        $update_sql = "UPDATE applications SET status = '$status' WHERE id = '$application_id'";
        if ($conn->query($update_sql)) {
            echo "<div class='alert alert-success'>Status updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating status: " . $conn->error . "</div>";
        }
    }

    // Fetch applications with full profile details
    $sql = "SELECT applications.*, users.email, profiles.full_name, profiles.profile_photo, profiles.bio, profiles.phone, profiles.address, 
                   profiles.linkedin, profiles.github, profiles.website, profiles.skills, profiles.experience, profiles.cv 
            FROM applications
            JOIN users ON applications.user_id = users.id
            LEFT JOIN profiles ON users.id = profiles.user_id
            WHERE applications.job_id = '$job_id'";

    $result = $conn->query($sql);
} else {
    echo "<div class='alert alert-danger'>Invalid job ID.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Applications</title>
    <?php include('headlink.php'); ?>
</head>

<body class="bg-light">
<?php include('header.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Applications for Job</h1>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Applicants</h2>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='mb-4 border p-3 rounded'>";
                                
                                // Profile Photo
                                if (!empty($row['profile_photo'])) {
                                    echo "<img src='" . $row['profile_photo'] . "' alt='Profile Photo' class='img-thumbnail mb-3' width='100'>";
                                }

                                echo "<h5><strong>Name:</strong> " . ($row['full_name'] ? $row['full_name'] : "Not provided") . "</h5>";
                                echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                                echo "<p><strong>Phone:</strong> " . ($row['phone'] ? $row['phone'] : "Not provided") . "</p>";
                                echo "<p><strong>Address:</strong> " . ($row['address'] ? $row['address'] : "Not provided") . "</p>";
                                echo "<p><strong>Bio:</strong> " . ($row['bio'] ? $row['bio'] : "No bio available") . "</p>";

                                // Links
                                if (!empty($row['linkedin'])) {
                                    echo "<p><strong>LinkedIn:</strong> <a href='" . $row['linkedin'] . "' target='_blank'>" . $row['linkedin'] . "</a></p>";
                                }
                                if (!empty($row['github'])) {
                                    echo "<p><strong>GitHub:</strong> <a href='" . $row['github'] . "' target='_blank'>" . $row['github'] . "</a></p>";
                                }
                                if (!empty($row['website'])) {
                                    echo "<p><strong>Website:</strong> <a href='" . $row['website'] . "' target='_blank'>" . $row['website'] . "</a></p>";
                                }

                                // Skills & Experience
                                echo "<p><strong>Skills:</strong> " . ($row['skills'] ? $row['skills'] : "Not provided") . "</p>";
                                echo "<p><strong>Experience:</strong> " . ($row['experience'] ? $row['experience'] . " years" : "Not provided") . "</p>";

                                // CV (Resume)
                                if (!empty($row['cv'])) {
                                    echo "<p><strong>CV:</strong> <a href='" . $row['cv'] . "' target='_blank'>Download CV</a></p>";
                                } else {
                                    echo "<p><strong>CV:</strong> Not provided</p>";
                                }

                                echo "<p><strong>Applied At:</strong> " . $row['applied_at'] . "</p>";

                                // Status update form
                                echo "<form method='POST' action='view_applications.php?job_id=$job_id'>";
                                echo "<input type='hidden' name='application_id' value='" . $row['id'] . "'>";
                                echo "<select name='status' class='form-select'>";
                                echo "<option value='Pending'" . ($row['status'] === 'Pending' ? ' selected' : '') . ">Pending</option>";
                                echo "<option value='Approved'" . ($row['status'] === 'Approved' ? ' selected' : '') . ">Approved</option>";
                                echo "<option value='Rejected'" . ($row['status'] === 'Rejected' ? ' selected' : '') . ">Rejected</option>";
                                echo "</select>";
                                echo "<button type='submit' name='update_status' class='btn btn-primary mt-2'>Update Status</button>";
                                echo "</form>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No applications found for this job.</p>";
                        }
                        ?>
                        <div class="text-center mt-3">
                            <a href="employer_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>

</body>

</html>
