<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php');

if (isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);

    // Delete the job from the database
    $sql = "DELETE FROM jobs WHERE id = $job_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
