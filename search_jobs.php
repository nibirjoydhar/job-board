<?php
include('includes/db.php');

$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';
$location = isset($_GET['location']) ? $conn->real_escape_string($_GET['location']) : '';
$salary = isset($_GET['salary']) ? $conn->real_escape_string($_GET['salary']) : '';

$sql = "SELECT jobs.*, users.name AS employer_name 
        FROM jobs 
        JOIN users ON jobs.employer_id = users.id 
        WHERE (jobs.title LIKE '%$query%' 
        OR jobs.location LIKE '%$query%' 
        OR jobs.salary LIKE '%$query%')";

if (!empty($location)) {
    $sql .= " AND jobs.location = '$location'";
}

if (!empty($salary)) {
    $sql .= " AND jobs.salary >= '$salary'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-6 mb-4'>";
        echo "<div class='card shadow-sm'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
        echo "<p class='card-text'>" . $row['description'] . "</p>";
        echo "<p class='card-text'><strong>Location:</strong> " . $row['location'] . "</p>";
        echo "<p class='card-text'><strong>Salary:</strong> " . $row['salary'] . "</p>";
        echo "<p class='card-text'><strong>Posted by:</strong> " . $row['employer_name'] . "</p>";
        echo "<a href='apply_job.php?job_id=" . $row['id'] . "' class='btn btn-success'>Apply Now</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<div class='col-12 text-center'>";
    echo "<p>No jobs found.</p>";
    echo "</div>";
}
?>