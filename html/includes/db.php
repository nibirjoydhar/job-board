<?php
// require __DIR__ . '/../vendor/autoload.php';  // Adjust the path to vendor/autoload.php
// require("/../vendor/autoload.php");
use Dotenv\Dotenv;

// Check if .env file exists before loading
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} else {
    error_log(".env file is missing!", 0);
}

$host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'localhost';
$user = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? 'root';
// $pass = getenv('DB_PASS') ?: $_ENV['DB_PASS'] ?? '';
$pass ='12345';
$dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'job_board';
$port = getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '3306';

// Debugging output (Remove this in production)
error_log("Connecting to DB: $host, User: $user, DB: $dbname", 0);

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
