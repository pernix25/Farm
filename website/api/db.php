<?php
$host = "localhost";
$user = "root";          // your MySQL username
$password = "";          // your MySQL password
$dbname = "cowFarm";     // your database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
