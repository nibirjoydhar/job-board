<?php
$host = 'localhost';
$db = 'job_board';
$user = 'root';
$pass = ''; // Add password if set

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>