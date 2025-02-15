<?php
session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-light">
    <?php include('header.php'); ?>
    <!-- <div class="hero-section text-center mb-5">
        <img src="images/hero.jpg" alt="Job Board Hero Image" class="img-fluid rounded">
        <div class="hero-text">
            <h1 class="display-4">Find Your Dream Job</h1>
            <p class="lead">Join thousands of job seekers and employers on our platform.</p>
        </div>
        </div> -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Find Your Dream Job</h1>
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
            $disabled = ($_SESSION['role'] != 'job_seeker') ? "disabled" : "";
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo "<div class='col-md-6 mb-4 animate__animated animate__fadeInUp'>";
                echo "<div class='card shadow-sm'>";
                    echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
                        echo "<p class='card-text'>" . $row['description'] . "</p>";
                        echo "<p class='card-text'><strong>Location:</strong> " . $row['location'] . "</p>";
                        echo "<p class='card-text'><strong>Salary:</strong> " . $row['salary'] . "</p>";
                        echo "<p class='card-text'><strong>Posted by:</strong> " . $row['employer_name'] . "</p>";
                        echo "<a href='apply_job.php?job_id=" . $row[' id']
                            . "' class='btn btn-success animate__animated animate__pulse animate__infinite $disabled'>Apply Now</a>"
                            ; echo "</div>" ; echo "</div>" ; echo "</div>" ; } } else {
                            echo "<div class='col-12 text-center'>" ; echo "<p>No jobs posted yet.</p>" ; echo "</div>"
                            ; } ?>
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
    </script>
</body>

</html>