<?php
session_start();
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

include('includes/db.php');

// Fetch the job details using the job id from the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    // Modify the query to join the jobs and users table to get employer name
    $sql = "SELECT jobs.*, users.name AS employer_name FROM jobs 
            JOIN users ON jobs.employer_id = users.id 
            WHERE jobs.id = '$job_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Job not found!</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>Job ID is missing!</div>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Job Details</title>
    <?php include('headlink.php');?>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($job['title']); ?></h2>
                        <p><strong>Description:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                        <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                        <p><strong>Requirements:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>
                        <p><strong>Responsibilities:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($job['responsibilities'])); ?></p>
                        <p><strong>Posted By:</strong> <?php echo htmlspecialchars($job['employer_name']); ?></p> <!-- Display employer name -->

                        <!-- Apply Now Button -->
                        <form method="POST" action="apply_job.php">
                            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                           <?php 
                                $disabled = ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employer') ? "disabled" : "";
                                echo "<a href='apply_job.php?job_id=" . $job['id']
                            . "' class='btn btn-success animate__animated animate__pulse animate__infinite $disabled'>Apply Now</a>"; ?>                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>

</body>

</html>
