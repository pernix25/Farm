<?php
header("Content-Type: application/json");
require "db.php";

// query that selects all medicaiton names from medicaiton table
$sqlMedicines = "
    SELECT medication_name
    FROM medications
";

// execute query
$resultMedicines = $conn->query($sqlMedicines);

// if no resuts -> throw error
if (!$resultMedicines) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit;
}

// iterate over query results by row appending data to medicaitons -> {medicaiton_name : name}
$medications = [];
while ($row = $resultMedicines->fetch_assoc()) {
    $medications[] = $row;
}

// encodes data into json to be parsed by javascript file
echo json_encode([
    "medications" => $medications
]);

// end database connection
$conn->close();
