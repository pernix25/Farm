<?php

header("Content-Type: application/json");
require "../db.php";

// validates that request is a post method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// parse json and validate data
$num_doses = $_POST['number_doses'];
$sick_cows = $_POST['sick_cow_numbers'];
$administration_date = $_POST['administration_date'];
if (isset($_POST['medications'])) {
    $medications = $_POST['medications'];
} else {
    echo json_encode(["success" => false, "message" => "No medications were selected"]);
    exit;
}
if (!$num_doses) {
    echo json_encode(["success" => false, "message" => "Missing number of doses"]);
    exit;
}
if (empty($sick_cows)) {
    echo json_encode(["success" => false, "message" => "Missing sick cow numbers"]);
    exit;
}
if (!$administration_date) {
    echo json_encode(["success" => false, "message" => "Missing admninistration date"]);
    exit;
}

// start a sql transaciton (queries are temperary until commited)
$conn->begin_transaction();
$cow_count = 0; // keeps track of cows added into the database
$medication_count = 0; // keeps track of medicaitons added into the database

// prepare sql statements
// get cow id
$stmt_cow_id = $conn->prepare("
    SELECT cow_id
    FROM cow_numbers
    WHERE cow_number = ?");
// insert cow event
$stmt_cow_events = $conn->prepare("
    INSERT INTO cow_events (cow_id, event_date, state_id) VALUES (?, ?, ?)
");
// get medicaiton id
$stmt_medication_id = $conn->prepare("
SELECT medication_id
FROM medications
WHERE medication_name = ?");
// insert doctoring data
$stmt_doctoring = $conn->prepare("
INSERT INTO doctoring (doeses, event_id, medication_id) VALUES (?, ?, ?)
");

try {
    for($i=0; $i < count($sick_cows); $i++) {
        $number = (int)$sick_cows[$i];
        $stmt_cow_id->bind_param("i", $number);
        $stmt_cow_id->execute();
        $cow_id_result = $stmt_cow_id->get_result();

        if($cow_id_result->num_rows === 0) {
            throw new Exception("Cow number not found");
        }

        $cow_id = $cow_id_result->fetch_assoc()['cow_id'];
        $event_code = 6; //  this is event code for treating cows with medication

        $stmt_cow_events->bind_param("isi", $cow_id, $administration_date, $event_code);
        $stmt_cow_events->execute();
        $event_id = $conn->insert_id;

        $medication_count = 0; // reset medication count
        for ($j=0; $j < count($medications); $j++) {
            $medication_name = $medications[$j];

            $stmt_medication_id->bind_param("s", $medication_name);
            $stmt_medication_id->execute();
            $medication_result = $stmt_medication_id->get_result(); 
            
            // validate medicaiton name
            if ($medication_result->num_rows === 0) {
                throw new Exception("Medication not found");
            }

            $medication_id = $medication_result->fetch_assoc()['medication_id'];

            $stmt_doctoring->bind_param("iii", $num_doses, $event_id, $medication_id);
            $stmt_doctoring->execute();

            $medication_count++;
        }
        $cow_count++;
        
    }

    // if no erros -> commit changes to database
    $conn->commit();
    echo json_encode(["success" => true, "cow_count" => $cow_count, "medication_count" => $medication_count]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
}

// close database connection
$conn->close();
