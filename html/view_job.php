<?php
session_start();
include('includes/db.php');

// Fetch the job details using the job id from the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
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
    <?php include('headlink.php'); ?>
    <title>Job Details</title>
    <style>
        .card-body {
            padding: 20px; /* Padding on all sides */
        }

        .card-body p {
            text-align: justify;
            text-justify: inter-word;
        }

        .card-footer {
            text-align: center;
            padding: 15px;
        }
    </style>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

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
                        <p><strong>Posted By:</strong> <?php echo htmlspecialchars($job['employer_name']); ?></p>
                    </div>
                    <div class="card-footer">
                        <button class="apply-btn btn btn-success m-2 animate__animated animate__pulse animate__infinite"
                            data-job-id="<?php echo $job['id']; ?>">
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).on("click", ".apply-btn", function() {
        var button = $(this);
        var jobId = button.data("job-id");

        // Disable button and show loading text
        button.prop("disabled", true);
        button.html(`<span class="spinner-border spinner-border-sm"></span> Applying...`);
        $.ajax({
            url: "apply_job.php",
            type: "GET",
            data: {
                job_id: jobId
            },
            dataType: "json",
            success: function(response) {
                var toastType = response.status === "success" ? "bg-success" :
                    response.status === "warning" ? "bg-warning" : "bg-danger";
                showToast(response.message, toastType);
            },
            error: function() {
                showToast("Something went wrong!", "bg-danger");
            },
            complete: function() {
                button.prop("disabled", false);
                button.html("Apply Now");
            }
        });

        function showToast(message, type) {
            var toastContainer = $(".toast-container");
            toastContainer.html('');
            var toastHTML = `
                <div id="custom-toast" class="toast align-items-center text-white ${type} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>`;
            toastContainer.html(toastHTML);
            var toastElement = document.getElementById("custom-toast");
            var toastInstance = new bootstrap.Toast(toastElement);
            toastInstance.show();
            setTimeout(function() {
                $(toastElement).toast('hide');
            }, 3000);
        }
    });
    </script>

</body>

</html>
