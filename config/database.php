<?php
// Konfigurasi Database
$host = "nextcloud-db";
$username = "root";
$password = "dhenhari";
$database = "lkpkota";

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $username, $password, $database);

// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
