<?php
// Database connection setup
$servername = "ycc353.encs.concordia.ca";
$username = "ycc353_1";
$password = "SoenComp";
$dbname = "ycc353_1";
// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Read JSON data from the request
$requestData = json_decode(file_get_contents('php://input'), true);
if (isset($requestData['action'])) {
    if ($requestData['action'] === 'deleteFacility') {
        $data = $requestData['data'];
        $fID = $data['id'];
        //Response message
        $message = "fID: $fID\nData has been processed.";
        //Delete data from the database
        $sql = "DELETE FROM Facilities WHERE fID = $fID;";
        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
        // Send a response back to the client
        header('Content-Type: application/json');
        echo json_encode(array('message' => $message));
    }

    elseif($requestData['action'] === 'deleteStudent') {
        $data = $requestData['data'];
        $medicareID = $data['medicareID'];
        //Response message
        $message = "medicareID: $medicareID\nData has been processed.";
        //Delete data from the database
        $sql = "DELETE FROM Students WHERE medicareID = $medicareID;";
        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
        $sql2 = "DELETE FROM People WHERE medicareID = $medicareID;";
        if ($conn->query($sql2) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
        // Send a response back to the client
        header('Content-Type: application/json');
        echo json_encode(array('message' => $message));
    }
    elseif($requestData['action'] === 'deleteEmployee'){
        $data = $requestData['data'];
        $medicareID = $data['medicareID'];
        //Response message
        $message = "medicareID: $medicareID\nData has been processed.";
        //Delete data from the database
        $sql = "DELETE FROM Employee WHERE medicareID = $medicareID;";
        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
        $sql2 = "DELETE FROM People WHERE medicareID = $medicareID;";
        if ($conn->query($sql2) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
        // Send a response back to the client
        header('Content-Type: application/json');
        echo json_encode(array('message' => $message));
    }
    elseif($requestData['action'] === 'deleteSchedule'){
    try{
        $data = $requestData['data'];
        $medicareID = $data['medicareID'];
        $date = $data['date'];

        //Response message
        $message = "medicareID: $medicareID\nData has been processed.";
        //Delete data from the database
        $sql = "DELETE FROM schedule WHERE date = '$date' AND medicareID = $medicareID;";
        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
    } catch (Exception $e) {
        $response = array('message' => $e->getMessage());
    }
        // Send a response back to the client
        header('Content-Type: application/json');
        error_log(json_encode($response));
        echo json_encode($response);


    }
    elseif($requestData['action'] === 'deleteInfection'){
        try{
        $data = $requestData['data'];
        $medicareID = $data['medicareID'];
        $infectionName = $data['infectionName'];
        $infectionDate = $data['infectionDate'];
        //Response message
        $message = "medicareID: $medicareID\nData has been processed.";
        //Delete data from the database
        $sql = "DELETE infections
        FROM infections
        JOIN Viruses ON infections.vID = Viruses.vID
        WHERE Viruses.type = '$infectionName'
        AND medicareID = '$medicareID'
        AND infections.infectionDate = '$infectionDate';";
        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
    }catch (Exception $e) {
        $response = array('message' => $e->getMessage());
    }

        // Send a response back to the client
        header('Content-Type: application/json');
        error_log(json_encode($response));
        echo json_encode($response);
    }
    elseif($requestData['action'] === 'deleteVaccination'){
        try{
        $data = $requestData['data'];
        $medicareID = $data['medicareID'];
        $vaccineName = $data['vaccineName'];
        $vaccinationDate = $data['vaccinationDate'];
        //Response message
        $message = "medicareID: $medicareID\nData has been processed.";
        //Delete data from the database
        $sql = "DELETE FROM vaccinations WHERE medicareID = '$medicareID' AND date = '$vaccinationDate';";
        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
    }catch(Exception $e) {
        $response = array('message' => $e->getMessage());
    }
        // Send a response back to the client
        header('Content-Type: application/json');
        error_log(json_encode($response));
        echo json_encode($response);
    }
}
?>
