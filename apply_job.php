<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

if (isset($_GET['job_id'])) {
    $job_id = $conn->real_escape_string($_GET['job_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the user has already applied for this job
    $check_sql = "SELECT * FROM applications WHERE job_id = '$job_id' AND user_id = '$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<div class='alert alert-warning'>You have already applied for this job.</div>";
    } else {
        // Handle resume upload
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $resume_name = basename($_FILES['resume']['name']);
            $resume_tmp = $_FILES['resume']['tmp_name'];
            $resume_path = "uploads/resumes/" . $resume_name;

            // Create the uploads/resumes directory if it doesn't exist
            if (!is_dir('uploads/resumes')) {
                mkdir('uploads/resumes', 0777, true);
            }

            if (move_uploaded_file($resume_tmp, $resume_path)) {
                // Insert the application into the database with resume path
                $sql = "INSERT INTO applications (job_id, user_id, resume) VALUES ('$job_id', '$user_id', '$resume_path')";
                if ($conn->query($sql)) {
                    // Send email notification to employer
                    $employer_sql = "SELECT users.email FROM jobs JOIN users ON jobs.employer_id = users.id WHERE jobs.id = '$job_id'";
                    $employer_result = $conn->query($employer_sql);
                    $employer = $employer_result->fetch_assoc();
                    $employer_email = $employer['email'];
                
                    $subject = "New Job Application";
                    $message = "You have received a new application for your job posting. Log in to your dashboard to view the details.";
                    $headers = "From: no-reply@jobboard.com";
                
                    if (mail($employer_email, $subject, $message, $headers)) {
                        echo "<div class='alert alert-success'>Application submitted successfully! The employer has been notified.</div>";
                    } else {
                        echo "<div class='alert alert-success'>Application submitted successfully, but the employer could not be notified.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error uploading resume.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Please upload a resume.</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>Invalid job ID.</div>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Apply for Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Apply for Job</h2>
                        <form method="POST" action="apply_job.php?job_id=<?php echo $job_id; ?>"
                            enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="resume" class="form-label">Upload Resume (PDF only)</label>
                                <input type="file" name="resume" class="form-control" accept=".pdf" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Submit Application</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="index.php" class="btn btn-secondary">Back to Job Listings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>