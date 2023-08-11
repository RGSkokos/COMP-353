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



// Check connection and request data
if ($conn->connect_error) {
    $response = array('message' => 'Connection failed: ' . $conn->connect_error);
    sendResponse($response);
} elseif (!isset($requestData['action'])) {
    $response = array('message' => 'Action not specified');
    sendResponse($response);
} else {
    if ($requestData['action'] === 'getFacilities') {
        $query = "SELECT * FROM Facilities;";
        processQuery($conn, $query);
    } elseif ($requestData['action'] === 'getStudents') {
        $query = "SELECT
        p.medicareID as medicareID,
        p.firstName as firstName,
        p.lastname as lastName,
        p.dOB as dOB,
        p.MedicareExpiryDate as MedicareExpiryDate,
        p.phone as phone,
        p.address as address,
        p.city as city,
        p.province as province,
        p.postalCode as postalCode,
        p.email as email, 
        f.facilityName as facilityName
         FROM People p, Students s, Facilities f, attends a 
                WHERE p.medicareID = s.medicareID
                AND f.fID = a.fID
                AND a.medicareID = s.medicareID;";
        processQuery($conn, $query);
    } elseif ($requestData['action'] === 'getEmployees'){
        $query = "SELECT * FROM People p, Employee e, Facilities f, attends a
        WHERE p.medicareID = e.medicareID
        AND f.fID = a.fID
        AND a.medicareID = e.medicareID;";  
        processQuery($conn, $query);
    } 
    elseif ($requestData['action'] === 'getEmployeeSchedules'){
        $query = "SELECT 
        p.medicareID,
        p.firstName AS firstName,
        p.lastname AS lastName,
        p.dOB,
        p.MedicareExpiryDate,
        p.phone,
        p.address,
        p.city,
        p.province,
        p.postalCode,
        p.email,
        f.facilityName as facilityName,
        e.jobTitle,
        s.date,
        s.startTime,
        s.endTime
         
        FROM People p, schedule s, Facilities f, Employee e
        WHERE p.medicareID = s.medicareID
            AND f.fID = s.fID
            AND e.medicareID = p.medicareID;"; 
        processQuery($conn, $query);
    } 
    elseif ($requestData['action'] === 'getInfections'){
        $query = "SELECT
        p.medicareID,
        p.firstName,
        p.lastname as lastName,
        v.type as virusName,
        v.vID as vID,
        i.date as infectionDate
         FROM People p, infections i, Viruses v
                WHERE p.medicareID = i.medicareID
                AND v.vID = i.vID;
        "; 
        processQuery($conn, $query);
    } 

    elseif ($requestData['action'] === 'getVaccinations'){
        $query = "SELECT
        p.medicareID,
        p.firstName,
        p.lastname as lastName,
        v.vaccineName as vaccineName,
        vac.date,
        vac.numDose as numDose,
        v.vID as vID
         FROM People p, Vaccines v, vaccinations vac
                WHERE p.medicareID = vac.medicareID
                AND v.vID = vac.vID
        "; 
        processQuery($conn, $query);
    } 
    elseif ($requestData['action'] === 'getVaccines'){
        $query = "SELECT * FROM Vaccines;"; 
        processQuery($conn, $query);
    }
    elseif ($requestData['action'] === 'getViruses'){
        $query = "SELECT * FROM Viruses;"; 
        processQuery($conn, $query);
    }
    elseif ($requestData['action'] === 'getFacilityEmails'){ 
        $facilityID = $requestData['facilityID'];
        $query = "SELECT
        em.subject as subject,
        em.receiverEmail as receiverEmail,
        em.emailBody as emailBody,
        em.dateOfEmail as dateOfEmail,
        f.facilityName as facilityName
        FROM emailLogs em
        JOIN sent s ON em.emailID = s.emailID
        JOIN Facilities f ON s.fID = f.fID
        WHERE f.fID = ?";
        
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $facilityID);
        $stmt->execute();
        $result = $stmt->get_result();

        processEmailQuery($result);
    }
    
    else {
        $response = array('message' => 'Invalid action');
        sendResponse($response);
    }
}

// Close the database connection
$conn->close();

function processQuery($conn, $query) {
    $result = $conn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        sendResponse($data);
    } else {
        $response = array('message' => 'Error retrieving data: ' . $conn->error);
        sendResponse($response);
    }
}
function processEmailQuery($result) {
    $emails = array();
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row;
    }
    sendResponse($emails);
}

function sendResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}

?>