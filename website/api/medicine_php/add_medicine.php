<?php

require "../db.php";
header("Content-Type: application/json");

// checks connection errors
if ($conn->connect_error) {
    echo json_encode(["success"=>false, "error"=>"DB connection failed: ".$conn->connect_error]);
    exit;
}


// validates that request is a post method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// collect post data
$medication_name = $_POST['add_medication_name'];
$doses = (int)($_POST['doeses_per_bottle'] ?? 0);

// validate form data
if ($medication_name === '') {
    echo json_encode(["success" => false, "error" => "Missing medication name"]);
    exit;
}

// sql
$stmt = $conn->prepare("INSERT INTO medications (medication_name, doses_per_bottle) VALUES (?, ?)");
$stmt->bind_param("si", $medication_name, $doses);
$stmt->execute();

// Return success JSON
echo json_encode(["success" => true]);
$conn->close();