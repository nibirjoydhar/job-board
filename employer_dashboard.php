<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

$employer_id = $_SESSION['user_id'];
$sql = "SELECT jobs.*, COUNT(applications.id) AS application_count 
        FROM jobs 
        LEFT JOIN applications ON jobs.id = applications.job_id 
        WHERE jobs.employer_id = '$employer_id' 
        GROUP BY jobs.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Employer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Employer Dashboard</h1>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Your Job Postings</h2>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='mb-4'>";
                                echo "<h5>" . $row['title'] . "</h5>";
                                echo "<p>" . $row['description'] . "</p>";
                                echo "<p><strong>Applications:</strong> " . $row['application_count'] . "</p>";
                                echo "<a href='view_applications.php?job_id=" . $row['id'] . "' class='btn btn-primary'>View Applications</a>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No job postings found.</p>";
                        }
                        ?>
                        <div class="text-center mt-3">
                            <a href="post_job.php" class="btn btn-success">Post a New Job</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11"></div>
        <div class="col-md-1">
            <a href='logout.php' class='btn btn-danger'>Logout</a>
        </div>
    </div>

</body>

</html>