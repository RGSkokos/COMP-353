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

// Check if the action key exists
if (isset($requestData['action'])) {
    // Check if the action is "addFacility"
    if ($requestData['action'] === 'addFacility') {
        $data = $requestData['data'];
    
    // Process the data
    $fID = $data['id'];
    $name = $data['name'];
    $type = $data['type'];
    $description = $data['description'];
    $address = $data['address'];
    $city = $data['city'];
    $province = $data['province'];
    $postalCode = $data['postalCode'];
    $phoneNumber = $data['phoneNumber'];
    $webAddr = $data['webAddr'];
    $capacity = $data['capacity'];

    // Create a response message
    $message = "ID: $fID\nName: $name\nType: $type\nDescription: $description\nAddress: $address\nCity: $city\nProvince: $province\nPostal Code: $postalCode\nPhone Number: $phoneNumber\nWeb Address: $webAddr\nCapacity: $capacity\nData has been processed.";

    // Insert data into the database
    // Uncomment and adapt the following lines to match your database setup

    $sql = "INSERT INTO Facilities (fID, type, description, facilityName, address, city, province, postalCode, phoneNumber, webAddr, capacity)
            VALUES ($fID, '$type', '$description', '$name', '$address', '$city', '$province', '$postalCode', '$phoneNumber', '$webAddr', $capacity);";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }


    // Send a response back to the client
    header('Content-Type: application/json');
    echo json_encode(array('message' => $message));
}



// Check if the action is "addStudent"
if ($requestData['action'] === 'addStudent') {
    $data = $requestData['data'];
    
    // Process the data
    $medicareID = $data['medicareID'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $dOB = $data['dOB'];
    $MedicareExpiryDate = $data['MedicareExpiryDate'];
    $phone= $data['phone'];
    $address = $data['address'];
    $city = $data['city'];
    $province = $data['province'];
    $postalCode = $data['postalCode'];
    $email = $data['email'];
    $fID = $data['fID'];
    $occupation = $data['occupation'];
    

    // Create a response message
    $message = "Medicare ID: $medicareID\nFirst Name: $firstName\nLast Name: $lastName\nDate of Birth: $dOB\nMedicare Expiry Date: $MedicareExpiryDate\nPhone: $phone\nAddress: $address\nCity: $city\nProvince: $province\nPostal Code: $postalCode\nEmail: $email\n fID: $fID\nData has been processed.";

    // Insert data into the database
    // Uncomment and adapt the following lines to match your database setup

    $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate, phone, address, city, province, postalCode, email)
            VALUES ('$medicareID', '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate', '$phone', '$address', '$city', '$province', '$postalCode', '$email');";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }

    
    $sql2 = "INSERT INTO Students (medicareID)
            VALUES ('$medicareID');";

    if ($conn->query($sql2) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }

    $startDate = date('Y-m-d');

    $sql3 = "INSERT INTO attends (fID, medicareID, startDate, occupation)
            VALUES ('$fID', '$medicareID', '$startDate', '$occupation');";
   
    if ($conn->query($sql3) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
        
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }



    // Send a response back to the client
    header('Content-Type: application/json');
    echo json_encode(array('message' => $message));
}

// Check if the action is "addEmployee"
if ($requestData['action'] === 'addEmployee') {
    $data = $requestData['data'];
    
    // Process the data
    $medicareID = $data['medicareID'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $dOB = $data['dOB'];
    $MedicareExpiryDate = $data['MedicareExpiryDate'];
    $phone= $data['phone'];
    $address = $data['address'];
    $city = $data['city'];
    $province = $data['province'];
    $postalCode = $data['postalCode'];
    $email = $data['email'];
    $fID = $data['fID'];
    $jobTitle = $data['jobTitle'];
    $occupation = $data['occupation'];
    

    // Create a response message
    $message = "Medicare ID: $medicareID\nFirst Name: $firstName\nLast Name: $lastName\nDate of Birth: $dOB\nMedicare Expiry Date: $MedicareExpiryDate\nPhone: $phone\nAddress: $address\nCity: $city\nProvince: $province\nPostal Code: $postalCode\nEmail: $email\n fID: $fID\nData has been processed.";

    // Insert data into the database
    // Uncomment and adapt the following lines to match your database setup

    $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate, phone, address, city, province, postalCode, email)
            VALUES ('$medicareID', '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate', '$phone', '$address', '$city', '$province', '$postalCode', '$email');";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }

    
    $sql2 = "INSERT INTO Employee (medicareID, jobTitle)
            VALUES ('$medicareID', '$jobTitle');";

    if ($conn->query($sql2) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }

    $startDate = date('Y-m-d');

    $sql3 = "INSERT INTO attends (fID, medicareID, startDate, occupation)
            VALUES ('$fID', '$medicareID', '$startDate', '$occupation');";
   
    if ($conn->query($sql3) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
        
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }



    // Send a response back to the client
    header('Content-Type: application/json');
    echo json_encode(array('message' => $message));
}

// Check if the action is "addEmployeeSchedule"
if ($requestData['action'] === 'addEmployeeSchedule') {
    $data = $requestData['data'];
    
    // Process the data 
    $fID = $data['fID'];
    $medicareID = $data['medicareID'];
    $date= $data['date'];
    $startTime = $data['startTime'];
    $endTime = $data['endTime'];

    // Create a response message
    $message = "Medicare ID: $medicareID\nDate: $date\nfID: $fID\nStart Time: $startTime\nEnd Time: $endTime\nData has been processed.";

    // Insert data into the database
    $sql = "INSERT INTO schedule (fID,medicareID, date, startTime, endTime)
            VALUES ('$fID','$medicareID','$date', '$startTime', '$endTime');";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Data inserted successfully');
    } else {
        $response = array('message' => 'Error inserting data: ' . $conn->error);
    }

    // Send a response back to the client
    header('Content-Type: application/json');
    echo json_encode(array('message' => $message));
}
// Check if the action is "addInfection"
if ($requestData['action'] === 'addInfection') {
    $data = $requestData['data'];

    // Process the data
    $medicareID = $data['medicareID'];
    $infectionName = $data['infectionName'];
    $infectionDate = $data['infectionDate'];

    // Create a response message
    $message = "Medicare ID: $medicareID\nInfection Name: $infectionName\nInfection Date: $infectionDate\nData has been processed.";
    //find vID based on name inputted from options
    $vID = "Select v.vID from Viruses v where v.type = '$infectionName';";
    // Insert data into the database
    $sql = "INSERT INTO Infections (vID, medicareID,infectionDate)
            VALUES ('$vID','$medicareID','$infectionDate');";

        if ($conn->query($sql) === TRUE) {
            $response = array('message' => 'Data inserted successfully');
        } else {
            $response = array('message' => 'Error inserting data: ' . $conn->error);
        }
         // Send a response back to the client
    header('Content-Type: application/json');
    echo json_encode(array('message' => $message));
}
else {
    $response = array('message' => 'Missing or invalid action');
    // Send an error response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
}
}
?>