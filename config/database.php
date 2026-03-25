<?php
// Konfigurasi Database
$host = "nextcloud-db";
$username = "root";
$password = "dhenhari";
$database = "lkpkota";

// Create connection with try-catch for PHP 8.1+ compatibility
try {
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection 
    if ($conn->connect_error) {
        $conn = null;
    }
}
catch (Exception $e) {
    // Silenced error for preview purposes if db isn't created yet
    $conn = null;
}
?>
