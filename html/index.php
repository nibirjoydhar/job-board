<?php
session_start();
ini_set('display_errors', 1); // Display errors on the page
ini_set('display_startup_errors', 1); // Display startup errors
error_reporting(E_ALL); // Report all types of errors

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'guest';
}

include('includes/db.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Job Board</title>
    <?php include('headlink.php'); ?>
    <style>
        .job-description {
            text-align: justify;
            text-justify: inter-word;
            display: block;
            width: 100%;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex-grow: 1;
            padding-top: 15px;
            /* Added padding only at top */
            padding-bottom: 15px;
            /* Added padding only at bottom */
        }

        .card-footer {
            text-align: center;
            padding: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 10px; /* Add padding for smaller screens */
            }
            .hero-section img {
                width: 100%; /* Make image responsive */
                height: auto;
            }
            .hero-text {
                padding: 10px;
            }
            .job-listings .col-md-6 {
                width: 100%; /* Full width for mobile */
            }
        }
    </style>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

    <div class="container mt-5">
        <div class="hero-section text-center mb-5">
            <img src="images/hero.jpg" alt="Job Board Hero Image" class="img-fluid rounded">
            <div class="hero-text">
                <h1 class="display-4">Find Your Dream Job</h1>
                <p class="lead">Join thousands of job seekers and employers on our platform.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="input-group mb-3">
                    <input type="text" id="search" class="form-control"
                        placeholder="Search by keyword, location, or salary">
                    <button class="btn btn-primary" onclick="searchJobs()">Search</button>
                </div>
            </div>
        </div>

        <div class="row" id="job-listings">
            <?php
            $sql = "SELECT jobs.*, users.name AS employer_name FROM jobs JOIN users ON jobs.employer_id = users.id";
            $result = $conn->query($sql);
            $disabled = ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employer') ? "disabled" : "";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-6 mb-4 d-flex'>";
                    echo "<div class='card shadow-sm h-100'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
                    echo "<p class='card-text job-description'>" . $row['description'] . "</p>";
                    echo "<p class='card-text'><strong>Posted by:</strong> " . $row['employer_name'] . "</p>";
                    echo "</div>"; // Close card-body
                    echo "<div class='card-footer'>";
                    echo "<a href='view_job.php?job_id=" . $row['id'] . "' class='btn btn-success m-1'>View Details</a>";
                    echo "<button class='apply-btn btn btn-success m-1 animate__animated animate__pulse animate__infinite' data-job-id='" . $row['id'] . "'>Apply Now</button>";
                    echo "</div>"; // Close card-footer
                    echo "</div></div>";
                }
            } else {
                echo "<div class='col-12 text-center'><p>No jobs posted yet.</p></div>";
            }
            ?>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            function searchJobs() {
                const query=$('#search').val();
                $.ajax({
                    url: 'search_jobs.php',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        $('#job-listings').html(response);
                    }
                });
            }

        });
        $(document).on("click", ".apply-btn", function() {
            var button=$(this);
            var jobId=button.data("job-id");

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
                    var toastType=response.status==="success"? "bg-success":
                        response.status==="warning"? "bg-warning":"bg-danger";
                    showToast(response.message, toastType);
                },
                error: function() {
                    showToast("Something went wrong!", "bg-danger");
                },
                complete: function() {
                    // Restore button state after request completes
                    button.prop("disabled", false);
                    button.html("Apply Now");
                }
            });

            function showToast(message, type) {
                var toastContainer=$(".toast-container");

                // Remove any existing toast before adding a new one
                toastContainer.html('');

                var toastHTML=`
                <div id="custom-toast" class="toast align-items-center text-white <span class="math-inline">\{type\} border\-0" role\="alert" aria\-live\="assertive" aria\-atomic\="true" data\-bs\-autohide\="true"\>
<div class\="d\-flex"\>
<div class\="toast\-body"\></span>{message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>`;

                toastContainer.html(toastHTML);

                var toastElement=document.getElementById("custom-toast");
                var toastInstance=new bootstrap.Toast(toastElement);
                toastInstance.show();

                setTimeout(function() {
                    $(toastElement).toast('hide'); // Bootstrap method to hide toast
                }, 3000);
            }
        });
    </script>

</body>

</html>