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

    // Verify that the job belongs to the employer
    $check_sql = "SELECT * FROM jobs WHERE id = '$job_id' AND employer_id = '$employer_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows === 0) {
        echo "<div class='alert alert-danger'>You do not have permission to view this job's applications.</div>";
        exit();
    }

    // Handle status update
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

    // Fetch applications for the job
    $sql = "SELECT applications.*, users.name AS applicant_name 
            FROM applications 
            JOIN users ON applications.user_id = users.id 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Applications for Job</h1>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Applicants</h2>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='mb-4'>";
                                echo "<p><strong>Applicant:</strong> " . $row['applicant_name'] . "</p>";
                                echo "<p><strong>Applied At:</strong> " . $row['applied_at'] . "</p>";
                                if (!empty($row['resume'])) {
                                    echo "<p><strong>Resume:</strong> <a href='" . $row['resume'] . "' target='_blank'>Download Resume</a></p>";
                                } else {
                                    echo "<p><strong>Resume:</strong> Not provided</p>";
                                }
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
</body>

</html>