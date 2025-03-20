<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Fetch the job details using the job id from the URL
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $sql = "SELECT * FROM jobs WHERE id = '$job_id' AND employer_id = '" . $_SESSION['user_id'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        $message = "Job not found or you're not authorized to edit this job!";
        $message_type = "danger";
        $show_toast = true;
        exit();
    }
} else {
    $message = "Job ID is missing!";
    $message_type = "danger";
    $show_toast = true;
    exit();
}

// Handle the form submission to update the job
if (isset($_POST['update_job'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $salary = $conn->real_escape_string($_POST['salary']);
    $requirements = $conn->real_escape_string($_POST['requirements']);
    $responsibilities = $conn->real_escape_string($_POST['responsibilities']);

    $update_sql = "UPDATE jobs SET title = '$title', description = '$description', location = '$location', 
                   salary = '$salary', requirements = '$requirements', responsibilities = '$responsibilities' 
                   WHERE id = '$job_id' AND employer_id = '" . $_SESSION['user_id'] . "'";

    if ($conn->query($update_sql)) {
        $message = "Job updated successfully!";
        $message_type = "success";
        $show_toast = true;
        header("Refresh: 2; url=employer_dashboard.php");
    } else {
        $message = "Error: " . $conn->error;
        $message_type = "danger";
        $show_toast = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Job</title>
    <?php include('headlink.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px;
            border-radius: 5px;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.5s ease, bottom 0.5s ease;
        }

        .toast.show {
            opacity: 1;
            bottom: 30px;
        }

        .toast.bg-success {
            background-color: #28a745;
        }

        .toast.bg-danger {
            background-color: #dc3545;
        }

        .toast .text-white {
            color: white;
        }
    </style>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Job Posting</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Edit Job: <?php echo htmlspecialchars($job['title']); ?></h2>
                        <form method="POST" action="edit_job.php?id=<?php echo $job['id']; ?>">
                            <div class="mb-3">
                                <input type="text" name="title" class="form-control" placeholder="Job Title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="description" class="form-control" placeholder="Job Description" rows="5" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($job['location']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="salary" class="form-control" placeholder="Salary" value="<?php echo htmlspecialchars($job['salary']); ?>">
                            </div>
                            <div class="mb-3">
                                <textarea name="requirements" class="form-control" placeholder="Requirements" rows="5"><?php echo htmlspecialchars($job['requirements']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <textarea name="responsibilities" class="form-control" placeholder="Responsibilities" rows="5"><?php echo htmlspecialchars($job['responsibilities']); ?></textarea>
                            </div>
                            <button type="submit" name="update_job" class="btn btn-primary w-100">Update Job</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="employer_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <?php if (isset($show_toast) && $show_toast): ?>
        <div class="toast text-white <?php echo "bg-" . $message_type; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Automatically hide the toast after 3 seconds
        document.addEventListener('DOMContentLoaded', function () {
            var toast = document.querySelector('.toast');
            if (toast) {
                setTimeout(function () {
                    var toastBootstrap = new bootstrap.Toast(toast);
                    toastBootstrap.hide();
                }, 3000);
            }
        });
    </script>
</body>

</html>
