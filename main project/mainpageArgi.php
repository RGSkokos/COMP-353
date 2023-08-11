<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_flush(); // Flush output buffer
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
    elseif ($requestData['action'] === 'addStudent') {
        $data2 = $requestData['data'];
        
        // Process the data
        $medicareID = $data2['medicareID'];
        $firstName = $data2['firstName'];
        $lastname = $data2['lastname'];
        $dOB = $data2['dOB'];
        $MedicareExpiryDate = $data2['MedicareExpiryDate'];
        $phone= $data2['phone'];
        $address = $data2['address'];
        $city = $data2['city'];
        $province = $data2['province'];
        $postalCode = $data2['postalCode'];
        $email = $data2['email'];
        $fID = $data2['fID'];
        $occupation = $data2['occupation'];
        

        // Create a response message
        $message = "Medicare ID: $medicareID\nFirst Name: $firstName\nLast Name: $lastname\nDate of Birth: $dOB\nMedicare Expiry Date: $MedicareExpiryDate\nPhone: $phone\nAddress: $address\nCity: $city\nProvince: $province\nPostal Code: $postalCode\nEmail: $email\n fID: $fID\nData has been processed.";

        // Insert data into the database
        // Uncomment and adapt the following lines to match your database setup

        $sql = "INSERT INTO People (medicareID, firstName, lastname, dOB, MedicareExpiryDate, phone, address, city, province, postalCode, email)
                VALUES ('$medicareID', '$firstName', '$lastname', '$dOB', '$MedicareExpiryDate', '$phone', '$address', '$city', '$province', '$postalCode', '$email');";

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
    elseif($requestData['action'] === 'addEmployee') {
        $data3 = $requestData['data'];
        
        // Process the data
        $medicareID = $data3['medicareID'];
        $firstName = $data3['firstName'];
        $lastname = $data3['lastname'];
        $dOB = $data3['dOB'];
        $MedicareExpiryDate = $data3['MedicareExpiryDate'];
        $phone= $data3['phone'];
        $address = $data3['address'];
        $city = $data3['city'];
        $province = $data3['province'];
        $postalCode = $data3['postalCode'];
        $email = $data3['email'];
        $fID = $data3['fID'];
        $jobTitle = $data3['jobTitle'];
        $occupation = $data3['occupation'];
        

        // Create a response message
        $message = "Medicare ID: $medicareID\nFirst Name: $firstName\nLast Name: $lastname\nDate of Birth: $dOB\nMedicare Expiry Date: $MedicareExpiryDate\nPhone: $phone\nAddress: $address\nCity: $city\nProvince: $province\nPostal Code: $postalCode\nEmail: $email\n fID: $fID\nData has been processed.";

        // Insert data into the database
        // Uncomment and adapt the following lines to match your database setup

        $sql = "INSERT INTO People (medicareID, firstName, lastname, dOB, MedicareExpiryDate, phone, address, city, province, postalCode, email)
                VALUES ('$medicareID', '$firstName', '$lastname', '$dOB', '$MedicareExpiryDate', '$phone', '$address', '$city', '$province', '$postalCode', '$email');";

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
    elseif ($requestData['action'] === 'addEmployeeSchedule') {
        $data4 = $requestData['data'];
        
        // Process the data 
        $fID = $data4['fID'];
        $medicareID = $data4['medicareID'];
        $date= $data4['date'];
        $startTime = $data4['startTime'];
        $endTime = $data4['endTime'];

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
    elseif ($requestData['action'] === 'addInfection') {
        $data5 = $requestData['data'];

        // Process the data
        $medicareID = $data5['medicareID'];
        $vID = $data5['vID'];
        $date = $data5['date'];

        // Create a response message
        $message = "Medicare ID: $medicareID\nInfection Name: $vID\nInfection Date: $date\nData has been processed.";
        //find vID based on name inputted from options
        //$vID = "Select v.vID from Viruses v where v.type = '$infectionName';";
        // Insert data into the database
        $sql = "INSERT INTO infections (vID, medicareID,date)
                VALUES ('$vID','$medicareID','$date');";

            if ($conn->query($sql) === TRUE) {
                $response = array('message' => 'Data inserted successfully');
            } else {
                $response = array('message' => 'Error inserting data: ' . $conn->error);
            }


            // Send a response back to the client
        header('Content-Type: application/json');
        echo json_encode(array('message' => $message));
    }
    // Check if the action is "addVaccination"
    elseif ($requestData['action'] === 'addVaccination') {
        $data6 = $requestData['data'];

        // Process the data
        $medicareID = $data6['medicareID'];
        $vID = $data6['vID'];
        $date = $data6['date'];
        $numDose = $data6['numDose'];

        // Create a response message
        $message = "Medicare ID: $medicareID\nVaccine: $vID\nVaccination Date: $date\nNumber of Doses: $numDose\nData has been processed.";
        //find vID based on name inputted from options
        //$vID = "Select v.vID from Vaccines v where v.vaccineName = '$vaccineName';";
        // Insert data into the database
        $sql = "INSERT INTO vaccinations (vID, medicareID,date,numDose)
                VALUES ('$vID','$medicareID','$date','$numDose');";

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
        $response = array('message' => 'Missing action');
        // Send an error response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
$conn->close();

?>