<?php
session_start();
header('Content-Type: application/json');
sleep(1);
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}
// echo "got it";
include('includes/db.php');
$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM profiles join users on profiles.user_id=users.id WHERE user_id = '$user_id'";
$profile_result = $conn->query($profile_sql);
$profile_complete = false;

if (($profile_result->num_rows) > 0) {
    $profile = $profile_result->fetch_assoc();

    if (!empty($profile['full_name']) && !empty($profile['email']) && !empty($profile['phone']) && !empty($profile['cv'])) {
        $profile_complete = true;
    }
}

if (!isset($_REQUEST['job_id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid job ID."]);
    exit();
}

$job_id = $conn->real_escape_string($_GET['job_id']);

if (!$profile_complete) {
    echo json_encode(["status" => "warning", "message" => "Please complete your profile before applying."]);
    exit();
}

$check_sql = "SELECT * FROM applications WHERE job_id = '$job_id' AND user_id = '$user_id'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    echo json_encode(["status" => "warning", "message" => "You have already applied for this job."]);
    exit();
}

$sql = "INSERT INTO applications (job_id, user_id, cv) VALUES ('$job_id', '$user_id', '" . $profile['cv'] . "')";
if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Application submitted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
}
exit();