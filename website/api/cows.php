<?php
header("Content-Type: application/json");
require "db.php";

$sqlCounts = "
    SELECT 
        ct.type_desc,
        COUNT(c.cow_id) AS total
    FROM cows c
    JOIN cow_types ct ON c.cow_type_id = ct.type_id
    GROUP BY ct.type_desc
";

$resultCounts = $conn->query($sqlCounts);
$typeCounts = [];

while ($row = $resultCounts->fetch_assoc()) {
    $typeCounts[$row['type_desc']] = (int)$row['total'];
}

// Individual cow details with numbers
$sqlCows = "
    SELECT 
        c.cow_id,
        ct.type_desc,
        GROUP_CONCAT(cn.cow_number ORDER BY cn.cow_number SEPARATOR ', ') AS numbers
    FROM cows c
    JOIN cow_types ct ON c.cow_type_id = ct.type_id
    LEFT JOIN cow_numbers cn ON c.cow_id = cn.cow_id
    GROUP BY c.cow_id
";

$resultCows = $conn->query($sqlCows);
$cows = [];
while ($row = $resultCows->fetch_assoc()) {
    $cows[] = $row;
}

echo json_encode([
    "cow_types" => $typeCounts,
    "cows" => $cows
]);
$conn->close();
