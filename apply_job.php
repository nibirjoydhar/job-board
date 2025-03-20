<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
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
if ($profile_result->num_rows > 0) {
    $profile = $profile_result->fetch_assoc();
}

if (isset($_GET['job_id'])) {
    $job_id = $conn->real_escape_string($_GET['job_id']);
    $user_id = $_SESSION['user_id'];
    // echo "Job id: " . $job_id . "<br>";
    // echo "User id: " . $user_id . "<br>";

    // Check if the user has already applied for this job
    $check_sql = "SELECT * FROM applications WHERE job_id = '$job_id' AND user_id = '$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<div class='alert alert-warning'>You have already applied for this job.</div>";
        header("Refresh: 2; url=index.php");

    } 
    else {
        // Handle resume upload

        if (!empty($profile['cv'])) {
            $sql = "INSERT INTO applications (job_id, user_id, cv) VALUES ('$job_id', '$user_id', '" . $profile['cv'] . "')";
            // echo $sql;
            if ($conn->query($sql)) {
                echo "<div class='alert alert-success'>Application submitted successfully!</div>";
                header("Refresh: 2; url=index.php");

            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        } else {

            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $cv_dir = 'uploads/cvs/';
                $cvName = time() . "_" . basename($_FILES["cv"]["name"]);
                $cvPath = $cv_dir . $cvName;
                $cvType = strtolower(pathinfo($cvPath, PATHINFO_EXTENSION));
                if ($cvType != "pdf") {
                    echo "<div class='alert alert-danger'>Only PDF files are allowed for CV upload!</div>";
                } elseif (move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath)) {

                    $sql = "INSERT INTO applications (job_id, user_id, cv) VALUES ('$job_id', '$user_id', '$cvPath')";
                    if ($conn->query($sql)) {
                        echo "<div class='alert alert-success'>Application submitted successfully!</div>";
                        header("Refresh: 2; url=index.php");
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>CV upload failed!</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Please upload a resume.</div>";
            }
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
    <?php include('headlink.php');?>
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
                                <label for="cv" class="form-label">Upload Resume (PDF only)</label>
                                <input type="file" name="cv" class="form-control" accept="application/pdf" required>
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