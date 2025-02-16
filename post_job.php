<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

if (isset($_POST['post_job'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $salary = $conn->real_escape_string($_POST['salary']);
    $employer_id = $_SESSION['user_id'];

    $sql = "INSERT INTO jobs (employer_id, title, description, location, salary) 
            VALUES ('$employer_id', '$title', '$description', '$location', '$salary')";

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Job posted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Post a Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Post a Job</h2>
                        <form method="POST" action="post_job.php">
                            <div class="mb-3">
                                <input type="text" name="title" class="form-control" placeholder="Job Title" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="description" class="form-control" placeholder="Job Description" rows="5"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="location" class="form-control" placeholder="Location" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="salary" class="form-control" placeholder="Salary">
                            </div>
                            <button type="submit" name="post_job" class="btn btn-primary w-100">Post Job</button>
                        </form>
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