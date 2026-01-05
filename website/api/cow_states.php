<?php

header("Content-Type: application/json");
require "db.php";

$query = "SELECT * FROM cow_states";

// execute query
$result = $conn->query($query);

// if no resuts -> throw error
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit;
}

// iterate over query results by row appending data to states -> {state_id: int, state_desc: varchar}
$states = [];
while ($row = $result->fetch_assoc()) {
    $states[] = $row;
}

// encodes data into json to be parsed by javascript file
echo json_encode([
    "cow_states" => $states
]);

// end database connection
$conn->close();
