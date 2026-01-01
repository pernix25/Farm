<?php
// ==========================================
// Cows API with built-in debugging
// Place this file in your "api" folder
// ==========================================

// Show all PHP errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header
header("Content-Type: application/json");

// ----------------------
// 1️⃣ Connect to MySQL
// ----------------------
$host = "localhost";
$user = "root";        // your MySQL username
$password = "";        // your MySQL password
$dbname = "cowFarm";   // your database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "error" => "Database connection failed",
        "details" => $conn->connect_error
    ]);
    exit;
}

// ----------------------
// 2️⃣ Run SQL query
// ----------------------
$sql = "
    SELECT 
        *
    FROM cows 
    LIMIT 5;
";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode([
        "error" => "SQL query failed",
        "details" => $conn->error,
        "query" => $sql
    ]);
    exit;
}

// ----------------------
// 3️⃣ Fetch results
// ----------------------
$cows = [];
while ($row = $result->fetch_assoc()) {
    $cows[] = $row;
}

// ----------------------
// 4️⃣ Output results as JSON
// ----------------------
echo json_encode($cows, JSON_PRETTY_PRINT);

// Close connection
$conn->close();
