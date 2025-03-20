<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "error";
    exit();
}

include('includes/db.php');

if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $sql = "DELETE FROM users WHERE id = $user_id";
    if ($conn->query($sql)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
