<?php
header("Content-Type: application/json");
require "db.php";

$sqlMedicines = "
    SELECT medication_name
    FROM medications
";

$resultMedicines = $conn->query($sqlMedicines);

if (!$resultMedicines) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit;
}

$medications = [];
while ($row = $resultMedicines->fetch_assoc()) {
    $medications[] = $row;
}

echo json_encode([
    "medications" => $medications
]);

$conn->close();
