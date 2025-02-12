<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php');

// Handle job approval or deletion
if (isset($_POST['action'])) {
    $job_id = $conn->real_escape_string($_POST['job_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $sql = "UPDATE jobs SET approved = 1 WHERE id = '$job_id'";
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM jobs WHERE id = '$job_id'";
    }

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Action completed successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Fetch all jobs
$sql = "SELECT jobs.*, users.name AS employer_name 
        FROM jobs 
        JOIN users ON jobs.employer_id = users.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Job Listings</h1>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Job Listings</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Employer</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['employer_name'] . "</td>";
                                        echo "<td>" . $row['location'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                        echo "<form method='POST' action='manage_jobs.php' style='display:inline;'>";
                                        echo "<input type='hidden' name='job_id' value='" . $row['id'] . "'>";
                                        echo "<button type='submit' name='action' value='approve' class='btn btn-success btn-sm'>Approve</button>";
                                        echo "<button type='submit' name='action' value='delete' class='btn btn-danger btn-sm ms-2'>Delete</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No jobs found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>