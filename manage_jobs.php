<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php');

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
    <?php include('headlink.php');?>

</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Job Listings</h1>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Job Listings</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Employer</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="jobTable">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr id='job-{$row['id']}'>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['employer_name'] . "</td>";
                                        echo "<td>" . $row['location'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-danger btn-sm delete-job-admin' data-id='" . $row['id'] . "'>Delete</button>";
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
    <?php include('footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {

            $(".delete-job-admin").click(function () {
                var jobId = $(this).data("id");
                var confirmation = confirm("Are you sure you want to delete this job?");
                
                if (confirmation) {
                    $.ajax({
                        url: "delete_job_admin.php",
                        type: "POST",
                        data: { job_id: jobId },
                        success: function (response) {
                            if (response == "success") {
                                $("#job-" + jobId).fadeOut(500, function () { $(this).remove(); });
                            } else {
                                alert("Failed to delete job. Try again.");
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
