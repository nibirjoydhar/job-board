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
    $requirements = $conn->real_escape_string($_POST['requirements']);
    $responsibilities = $conn->real_escape_string($_POST['responsibilities']);
    $employer_id = $_SESSION['user_id'];

    $sql = "INSERT INTO jobs (employer_id, title, description, location, salary, requirements, responsibilities) 
            VALUES ('$employer_id', '$title', '$description', '$location', '$salary', '$requirements', '$responsibilities')";

    if ($conn->query($sql)) {
        $message = "Job posted successfully!";
        $message_type = "success";
        header("Refresh: 2; url=employer_dashboard.php");
    } else {
        $message = "Error: " . $conn->error;
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('headlink.php'); ?>
    <title>Post a Job</title>
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
                                <textarea name="description" class="form-control" placeholder="Job Description" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="location" class="form-control" placeholder="Location" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="salary" class="form-control" placeholder="Salary" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="requirements" class="form-control" placeholder="Requirements" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <textarea name="responsibilities" class="form-control" placeholder="Responsibilities" rows="5" required></textarea>
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

    <!-- Toast Notification -->
    <?php if (isset($message) && isset($message_type)): ?>
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
