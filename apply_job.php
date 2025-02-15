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
            $upload_dir = 'uploads/resumes/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Validate file type (only PDF allowed)
            $allowed_types = ['application/pdf'];
            $file_type = $_FILES['resume']['type'];
            if (!in_array($file_type, $allowed_types)) {
                echo "<div class='alert alert-danger'>Only PDF files are allowed.</div>";
                exit();
            }

            // Validate file size (max 5MB)
            $max_size = 5 * 1024 * 1024; // 5MB
            if ($_FILES['resume']['size'] > $max_size) {
                echo "<div class='alert alert-danger'>File size must be less than 5MB.</div>";
                exit();
            }

            // Generate a unique file name to avoid conflicts
            $file_name = uniqid() . '_' . basename($_FILES['resume']['name']);
            $file_path = $upload_dir . $file_name;

            // Move the uploaded file to the uploads directory
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $file_path)) {
                // Insert the application into the database
                $sql = "INSERT INTO applications (job_id, user_id, resume) VALUES ('$job_id', '$user_id', '$file_path')";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success'>Application submitted successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error uploading resume. Please try again.</div>";
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
                                <input type="file" name="resume" class="form-control" accept="application/pdf" required>
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