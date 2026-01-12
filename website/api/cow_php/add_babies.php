<?php
header("Content-Type: application/json");
require "db.php";

// validates that request is a post method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// parses json into php variables
$mamaCowNumber = $_POST['mamaCowNumber'];
$numbers = $_POST['baby_cow_numbers'];
$types = $_POST['babyCowTypes'];

// validates that data is not empty
if (!$mamaCowNumber || empty($numbers) || empty($types)) {
    echo json_encode(["success" => false, "message" => "Missing data"]);
    exit;
}

// validates that data is complete
if (count($numbers) !== count($types)) {
    echo json_encode(["success" => false, "message" => "Mismatched numbers and types"]);
    exit;
}

// prepare sql statemtn to get mama cow ID from database
$stmtMama = $conn->prepare("
    SELECT cow_id
    FROM cow_numbers
    WHERE cow_number = ?
");

// bind mama cow number (int) to sql satement and execute
$stmtMama->bind_param("i", $mamaCowNumber);
$stmtMama->execute();

// get results from sql statement and store row result in mama variable
$resultMama = $stmtMama->get_result();
$mama = $resultMama->fetch_assoc();

// validate mama
if (!$mama) {
    echo json_encode(["success" => false, "message" => "Mama cow not found"]);
    exit;
}

// get mama cow id number
$mama_cow_id = $mama['cow_id'];

// start a sql transaciton (queries are temperary until commited)
$conn->begin_transaction();
$addedCount = 0; // keeps track of cows added into the database

try {
    // iterate over baby cow numbers (should be 1 number per baby cow)
    for ($i = 0; $i < count($numbers); $i++) {
        $number = (int)$numbers[$i];
        $type = $types[$i];

        // get cow type
        $stmtType = $conn->prepare("
            SELECT type_id FROM cow_types WHERE type_desc = ?
        ");
        $stmtType->bind_param("s", $type);
        $stmtType->execute();
        $typeResult = $stmtType->get_result();
        $typeRow = $typeResult->fetch_assoc();

        // throw error if cow type can not be found
        if (!$typeRow) {
            throw new Exception("Cow number not found: $number");
        }

        $type_id = $typeRow['type_id'];

        // insert baby cow
        $stmtCow = $conn->prepare("
            INSERT INTO cows (cow_type_id) VALUES (?)
        ");
        $stmtCow->bind_param("i", $type_id);
        $stmtCow->execute();
        $cow_id = $conn->insert_id;

        // insert cow number
        $stmtNum = $conn->prepare("
            INSERT INTO cow_numbers (cow_id, cow_number) VALUES (?, ?)
        ");
        $stmtNum->bind_param("ii", $cow_id, $number);
        $stmtNum->execute();

        // link baby to mama
        $stmtRelate = $conn->prepare("
            INSERT INTO babies (child_cow_id, parent_cow_id)
            VALUES (?, ?)
        ");
        $stmtRelate->bind_param("ii", $cow_id, $mama_cow_id);
        $stmtRelate->execute();

        $addedCount++;
    }

    // if no erros -> commit changes to database
    $conn->commit();
    echo json_encode(["success" => true, "count" => $addedCount]);

} catch (Exception $e) {
    // error occured -> roll back (undo changes from this transaciton)
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Database error"]);
}

// close database connection
$conn->close();
