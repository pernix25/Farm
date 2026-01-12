<?php

require "db.php";
header("Content-Type: application/json");

// validates that request is a post method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// collect post data
$cow_number = (int)$_POST['note_cow_number'];
$cow_state_id = ((int)$_POST['note_types']) ?? 8;
$note_text = $_POST['add_note'] ?? Null;
$note_date = $_POST['note_date'];

// validate post data
if (!$cow_number) {
    echo json_encode(["success" => false, "message" => "Invalid cow number"]);
    exit;
}
if (!$cow_state_id) {
    echo json_encode(["success" => false, "message" => "Invalid cow status"]);
    exit;
}
if (!$note_date) {
    echo json_encode(["success" => false, "message" => "Invalid date"]);
    exit;
}

// get cow id
$stmt_cow_id = $conn->prepare("SELECT cow_id FROM cow_numbers WHERE cow_number = ?");
$stmt_cow_id->bind_param("i", $cow_number);
$stmt_cow_id->execute();
$cow_id_result = $stmt_cow_id->get_result();

if($cow_id_result->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "Invalid cow number"]);
    exit;
}

$cow_id = $cow_id_result->fetch_assoc()['cow_id'];

// insert data into notes table
$stmt_insert_note = $conn->prepare("INSERT INTO notes 
                                    (cow_id, cow_state, note_date, note_text)
                                     VALUES (?, ?, ?, ?)");
$stmt_insert_note->bind_param("iiss", $cow_id, $cow_state_id, $note_date, $note_text);
$stmt_insert_note->execute();

// Return success JSON
echo json_encode(["success" => true]);
$conn->close();