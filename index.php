<?php
session_start();
if(!isset($_SESSION['role'])){
    $_SESSION['role'] = 'guest';

}
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
//     header("Location: login.php");
//     exit();
// }



include('includes/db.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Job Board</title>
    <?php include('headlink.php');?>
</head>

<body class="bg-light">
    <?php include('header.php');?>

    <!-- Toast Notification -->
    <?php 
        $previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'No previous page';
        $login_page="http://localhost/job-board-main/login.php";

        if ($previous_page==$login_page && isset($_SESSION['name'])): 
            $message = "Welcome back, " . $_SESSION['name'] . "!";
            $message_type = 'success'; // Success toast
        // ?>
           
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-white bg-<?php echo $message_type; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <!-- <h1 class="text-center mb-4">Find Your Dream Job</h1> -->
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
            include('includes/db.php');
            $sql = "SELECT jobs.*, users.name AS employer_name 
                    FROM jobs 
                    JOIN users ON jobs.employer_id = users.id";
            $result = $conn->query($sql);
            $disabled = ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employer') ? "disabled" : "";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-6 mb-4 animate__animated animate__fadeInUp'>";
                    echo "<div class='card shadow-sm'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
                    echo "<p class='card-text'>" . $row['description'] . "</p>";
                    echo "<p class='card-text'><strong>Posted by:</strong> " . $row['employer_name'] . "</p>";
                    echo "<a href='view_job.php?job_id=" . $row['id']
                        . "' class='btn btn-success m-3 animate__animated animate__pulse animate__infinite'>View Details</a>";
                    echo "<a href='apply_job.php?job_id=" . $row['id']
                        . "' class='btn btn-success animate__animated animate__pulse animate__infinite $disabled'>Apply Now</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12 text-center'>";
                echo "<p>No jobs posted yet.</p>";
                echo "</div>"
                ;
            } ?>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function searchJobs() {
        const query = $('#search').val();
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
    
        // Initialize toast if a message exists
        <?php if ($message): ?>
            var toast = new bootstrap.Toast(document.querySelector('.toast'));
            toast.show();
        <?php endif; ?>

    </script>
</body>

</html>