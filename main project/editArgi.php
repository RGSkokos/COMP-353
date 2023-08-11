<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection setup
$servername = "ycc353.encs.concordia.ca";
$username = "ycc353_1";
$password = "SoenComp";
$dbname = "ycc353_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read JSON data from the request
$requestData = json_decode(file_get_contents('php://input'), true);

if ($requestData['action'] === 'editFacility') {
    try {
    $data = $requestData['data'];
    $fID = $data['id'];
    $facilityName = $data['facilityName'];
    $facilityType = $data['type'];
    $facilityAddress = $data['address'];
    $facilityCity = $data['city'];
    $facilityProvince = $data['province'];
    $facilityPostalCode = $data['postalCode'];
    $facilityPhone = $data['phoneNumber'];
    $facilityWebsite = $data['webAddr'];
    $facilityCapacity = $data['capacity'];
    $facilityDescri = $data['description'];

    // Update data in the database
    $sql = "UPDATE Facilities
            SET
                type = '$facilityType',
                description = '$facilityDescri',
                facilityName = '$facilityName',
                address = '$facilityAddress',
                city = '$facilityCity',
                province = '$facilityProvince',
                postalCode = '$facilityPostalCode',
                phoneNumber = '$facilityPhone',
                webAddr = '$facilityWebsite', 
                capacity = '$facilityCapacity'
            WHERE
                fID = '$fID';";
    
    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }
} catch (Exception $e) {
    $response = array('message' => $e->getMessage());
}

    // Send a response back to the client
    header('Content-Type: application/json');
    error_log(json_encode($response));
    echo json_encode($response);
}

// Check if the action is 'editStudent'
if ($requestData['action'] === 'editStudent') {
    try{
    $data = $requestData['data'];

    // Process the data
    $medicareID = $data['medicareID'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $dOB = $data['dOB'];
    $MedicareExpiryDate = $data['MedicareExpiryDate'];
    $phone = $data['phone'];
    $address = $data['address'];
    $city = $data['city'];
    $province = $data['province'];
    $postalCode = $data['postalCode'];
    $email = $data['email'];
    $fID = $data['fID'];
    $occupation = $data['occupation'];

    // Update data in the database
    $sql = "UPDATE People
            SET
                firstName = '$firstName',
                lastName = '$lastName',
                dOB = '$dOB',
                MedicareExpiryDate = '$MedicareExpiryDate',
                phone = '$phone',
                address = '$address',
                city = '$city',
                province = '$province',
                postalCode = '$postalCode',
                email = '$email'
            WHERE
                medicareID = '$medicareID';";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }

    // Update occupation and other relevant data in attends table
    $sql2 = "UPDATE attends
             SET
                fID = '$fID',
                occupation = '$occupation'
             WHERE
                medicareID = '$medicareID';";

    if ($conn->query($sql2) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }
} catch (Exception $e) {
    $response = array('message' => $e->getMessage());
}
    // Send a response back to the client
    header('Content-Type: application/json');
    error_log(json_encode($response));
    echo json_encode($response);
}

if($requestData['action'] === 'editEmployee') {
    try{
    $data = $requestData['data'];

    // Process the data
    $medicareID = $data['medicareID'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $dOB = $data['dOB'];
    $MedicareExpiryDate = $data['MedicareExpiryDate'];
    $phone = $data['phone'];
    $address = $data['address'];
    $city = $data['city'];
    $province = $data['province'];
    $postalCode = $data['postalCode'];
    $email = $data['email'];
    $fID = $data['fID'];
    $occupation = $data['occupation'];

    // Update data in the database
    $sql = "UPDATE People
            SET
                firstName = '$firstName',
                lastName = '$lastName',
                dOB = '$dOB',
                MedicareExpiryDate = '$MedicareExpiryDate',
                phone = '$phone',
                address = '$address',
                city = '$city',
                province = '$province',
                postalCode = '$postalCode',
                email = '$email'
            WHERE
                medicareID = '$medicareID';";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }

    // Update occupation and other relevant data in works table
    $sql2 = "UPDATE Employee
             SET
                fID = '$fID',
                occupation = '$occupation'
             WHERE
                medicareID = '$medicareID';";

    if ($conn->query($sql2) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }
} catch (Exception $e) {
    $response = array('message' => $e->getMessage());
}
    // Send a response back to the client
    header('Content-Type: application/json');
    error_log(json_encode($response));
    echo json_encode($response);
}
if($requestData['action'] === 'editSchedule') {
    try{
    $data = $requestData['data'];
    $medicareID = $data['scheduleMedicareID'];
    $date = $data['scheduleDate'];
    $starTime = $data['startTime'];
    $endTime = $data['endTime'];

    // Update data in the database
    $sql = "UPDATE schedule
            SET
                startTime = '$starTime',
                endTime = '$endTime'
            WHERE
                medicareID = $medicareID AND date = '$date';";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }
}catch (Exception $e) {
    $response = array('message' => $e->getMessage());
}
    // Send a response back to the client   
    header('Content-Type: application/json');
    error_log(json_encode($response));
    echo json_encode($response);
}
if($requestData['action'] === 'editInfection'){
    try{
    $data = $requestData['data'];
    $medicareID = $data['medicareID'];
    $infectionName = $data['infectionName'];
    $infectionDate = $data['infectionDate'];
    $newInfectionDate = $data['newInfectionDate'];

    // Update data in the database
    $sql = "UPDATE infections
    JOIN Viruses ON infections.vID = Viruses.vID
    SET
      date = '$newInfectionDate'
    WHERE
      medicareID = '$medicareID' AND Viruses.type = '$infectionName';";
    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }
}catch (Exception $e) {
    $response = array('message' => $e->getMessage());
}
    // Send a response back to the client
    header('Content-Type: application/json');
    error_log(json_encode($response));
    echo json_encode($response);

}
if($requestData['action'] === 'editVaccination'){
    try{
    $data = $requestData['data'];
    $medicareID = $data['medicareID'];
    $vaccineName = $data['vaccinationName'];
    $vaccineDate = $data['vaccinationDate'];
    $newVaccineDate = $data['newVaccinationDate'];

    // Update data in the database
    $sql = "UPDATE vaccinations
    JOIN Vaccines ON vaccinations.vID = Vaccines.vID
    SET
      date = '$newVaccineDate'
    WHERE
      medicareID = '$medicareID' AND Vaccines.vaccineName = '$vaccineName';";
    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data updated successfully');
    } else {
        $response = array('message' => 'Error updating data: ' . $conn->error);
    }
}
catch (Exception $e) {
    $response = array('message' => $e->getMessage());
}
    // Send a response back to the client
    header('Content-Type: application/json');
    error_log(json_encode($response));
    echo json_encode($response);

}

$conn->close();
?>






