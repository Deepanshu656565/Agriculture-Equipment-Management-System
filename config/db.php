<?php
// config/db.php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'agri_rental';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('DB Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>