<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

// Get the last checked timestamp from the session
$last_checked = isset($_SESSION['last_checked']) ? $_SESSION['last_checked'] : date('Y-m-d H:i:s');

// Fetch the count of new jobs posted since the last check
$sql = "SELECT COUNT(*) AS count FROM jobs WHERE created_at > '$last_checked'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Update the last checked timestamp
$_SESSION['last_checked'] = date('Y-m-d H:i:s');

// Return the count as JSON
echo json_encode($row);
?>