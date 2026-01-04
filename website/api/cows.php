<?php
header("Content-Type: application/json");
require "db.php";

// query that counts the total number of cow types in database
$sqlCounts = "
    SELECT 
        ct.type_desc,
        COUNT(c.cow_id) AS total
    FROM cows c
    JOIN cow_types ct ON c.cow_type_id = ct.type_id
    GROUP BY ct.type_desc
";

// executes query
$resultCounts = $conn->query($sqlCounts);
$typeCounts = [];

// iterate result rows appending them to typeCounts -> {type_desc : total}
while ($row = $resultCounts->fetch_assoc()) {
    $typeCounts[$row['type_desc']] = (int)$row['total'];
}

// query for individual cow details with numbers
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

// executes query
$resultCows = $conn->query($sqlCows);
$cows = [];

// iterates over result rows appending data to cows -> {cow_id : 1, type_desc : Heifer, numbers : 15, 155}
while ($row = $resultCows->fetch_assoc()) {
    $cows[] = $row;
}

// encode results into json for parsing in javascript file
echo json_encode([
    "cow_types" => $typeCounts,
    "cows" => $cows
]);
$conn->close();
