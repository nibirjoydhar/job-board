<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Fetch new jobs posted since the last check
$last_checked = isset($_SESSION['last_checked']) ? $_SESSION['last_checked'] : date('Y-m-d H:i:s');
$sql = "SELECT jobs.*, users.name AS employer_name 
        FROM jobs 
        JOIN users ON jobs.employer_id = users.id 
        WHERE jobs.created_at > '$last_checked'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='mb-3'>";
        echo "<h6>" . $row['title'] . "</h6>";
        echo "<p><strong>Employer:</strong> " . $row['employer_name'] . "</p>";
        echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
        echo "<p><strong>Salary:</strong> " . $row['salary'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No new jobs found.</p>";
}
?>