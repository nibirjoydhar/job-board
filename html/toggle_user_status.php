<?php
session_start();
include('includes/db.php');

// Check if user_id and action are passed
if (isset($_POST['user_id']) && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Validate action
    if ($action == 'deactivate' || $action == 'activate') {
        $new_status = ($action == 'deactivate') ? 'inactive' : 'active';

        // Update status in database
        $sql = "UPDATE users SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_status, $user_id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
?>
