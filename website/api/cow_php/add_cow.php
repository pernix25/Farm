<?php
require "db.php";
header("Content-Type: application/json");

// validates that request is a post method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// Collect POST data
$cowTypeDesc = $_POST['cowType'];
$cowNumbers = $_POST['cow_numbers'];
$birthDate = $_POST['birthDate'];

// validate post data
if ($cowTypeDesc === '' || empty($cowNumbers)) {
    echo json_encode(["success" => false, "error" => "Missing cow type or numbers"]);
    exit;
}

// Get cow_type_id
$stmtType = $conn->prepare("SELECT type_id FROM cow_types WHERE type_desc = ?");
$stmtType->bind_param("s", $cowTypeDesc);
$stmtType->execute();
$typeResult = $stmtType->get_result();

if($typeResult->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "Invalid cow type"]);
    exit;
}

$cow_type_id = $typeResult->fetch_assoc()['type_id'];

// Insert cow
$stmtCow = $conn->prepare("INSERT INTO cows (cow_type_id) VALUES (?)");
$stmtCow->bind_param("i", $cow_type_id);
$stmtCow->execute();
$cow_id = $conn->insert_id;

// Insert cow numbers
$stmtNumber = $conn->prepare("INSERT INTO cow_numbers (cow_id, cow_number) VALUES (?, ?)");
$count = 0;
foreach($cowNumbers as $num) {
    if($num === '') continue; // skip empty
    $stmtNumber->bind_param("ii", $cow_id, $num);
    if($stmtNumber->execute()) $count++;
}

// Return success JSON
echo json_encode(["success" => true, "count" => $count]);
$conn->close();
