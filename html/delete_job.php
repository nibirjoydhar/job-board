<?php
session_start();
include('includes/db.php');

// Check if the user is logged in and is an employer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Check if job_id is provided
if (isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];

    // Ensure the job belongs to the logged-in employer
    $employer_id = $_SESSION['user_id'];
    $sql = "DELETE FROM jobs WHERE id = '$job_id' AND employer_id = '$employer_id'";

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Job deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is missing']);
}
?>
