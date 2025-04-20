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
    <?php include('headlink.php'); ?>
    <title>Job Board</title>
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
            padding-top: 30px;
            /* Added padding only at top */
            padding-bottom: 15px;
            /* Added padding only at bottom */
        }

        .card-footer {
            text-align: center;
            padding: 10px;
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        @media (max-width: 576px) {
            .hero-text h1 {
                font-size: 1.8rem;
            }

            .hero-text p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div>
        <?php include('header.php'); ?>

        <!-- Toast Notification -->
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

        <div class="container mt-5">
            <div class="hero-section position-relative text-center mb-5">
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                <img src="images/hero.jpg" alt="Job Board Hero Image" class="img-fluid rounded">
                <div class="hero-text position-absolute top-50 start-50 translate-middle text-white">
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
    </div>
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
                <div id="custom-toast" class="toast align-items-center text-white ${type} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
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

        document.addEventListener("DOMContentLoaded", function() {
            let message=localStorage.getItem('toastMessage');
            if(message) {
                let toastHTML=`
                <div class="toast show position-fixed bottom-0 end-0 p-3" style="z-index: 1050;" role="alert">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>`;

                document.body.insertAdjacentHTML('beforeend', toastHTML);

                setTimeout(() => {document.querySelector('.toast').remove();}, 3000);
                localStorage.removeItem('toastMessage');
            }
        });

    </script>

</body>

</html>