<?php

header("Content-Type: application/json");
require "../db.php";

// validates that request is a post method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// parse json into php variables
$old_tag = $_POST['OldTagNumber'];
$new_tag = $_POST['NewTagNumber'];

// validates that data is not empty
if (!$old_tag || !$new_tag) {
    echo json_encode(["success" => false, "message" => "Missing data"]);
    exit;
}

// prepare and execute sql statement
$stmt_cow_id = $conn->prepare("
    SELECT cow_id
    FROM cow_numbers
    WHERE cow_number = ?
");
$stmt_cow_id->bind_param("i", $old_tag);
$stmt_cow_id->execute();

// get results from sql statement and store row result
$query_result = $stmt_cow_id->get_result();
$row = $query_result->fetch_assoc();

// validate row result
if (!$row) {
    echo json_encode(["success" => false, "message" => "Old cow tag could not be found"]);
    exit;
}

// get old cow id
$cow_id = $row['cow_id'];

// prepare and execute sql statement
$stmt_add_new_tag = $conn->prepare("
    INSERT INTO 
    cow_numbers (cow_id, cow_number) 
    Values (?, ?)
");
$stmt_add_new_tag->bind_param("ii", $cow_id, $new_tag);
if ($stmt_add_new_tag->execute()) {
    echo json_encode(["success" => true, "message" => "Successfully added a tag to a cow"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}

$conn->close();