<?php
// Create a new facility
function createFacility(
    $fID,
    $type,
    $description,
    $facilityName,
    $address,
    $city,
    $province,
    $postalCode,
    $phoneNumber,
    $webAddr,
    $capacity
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $fID = $conn->real_escape_string($fID);
    $type = $conn->real_escape_string($type);
    $description = $conn->real_escape_string($description);
    $facilityName = $conn->real_escape_string($facilityName);
    $address = $conn->real_escape_string($address);
    $city = $conn->real_escape_string($city);
    $province = $conn->real_escape_string($province);
    $postalCode = $conn->real_escape_string($postalCode);
    $phoneNumber = $conn->real_escape_string($phoneNumber);
    $webAddr = $conn->real_escape_string($webAddr);
    $capacity = $conn->real_escape_string($capacity);

    $sql = "INSERT INTO Facilities (fID, type, description, facilityName,
        address, city, province, postalCode, phoneNumber, webAddr, capacity) VALUES (
        '$fID', '$type', '$description', '$facilityName', '$address',
        '$city', '$province', '$postalCode', '$phoneNumber', '$webAddr',
        '$capacity')";

    if ($conn->query($sql) === TRUE) {
        echo "Facility added successfully.";
    } else {
        echo "Error adding facility: " . $conn->error;
    }

    $conn->close();
}

// Create a new student
function addStudent(
    $medicareID,
    $firstName,
    $lastName,
    $dOB,
    $MedicareExpiryDate,
    $phone,
    $address,
    $city,
    $province,
    $postalCode,
    $email,
    $fID //No fID in the HTML? *BUG*
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $fID = $conn->real_escape_string($fID);
    $dOB = $conn->real_escape_string($dOB);
    $MedicareExpiryDate = $conn->real_escape_string($MedicareExpiryDate);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $city = $conn->real_escape_string($city);
    $province = $conn->real_escape_string($province);
    $postalCode = $conn->real_escape_string($postalCode);
    $email = $conn->real_escape_string($email);


    // Get today's date
    $startDate = date('Y-m-d');
    // check if student is already in people table
    $sql = "SELECT * FROM People WHERE medicareID = '$medicareID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Student already exists in People table. Adding to Student table only";
        $sql = "INSERT INTO Students (medicareID) VALUES ('$medicareID')";
        $conn->query($sql);
    } else {

        // Insert into People table
        $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate,
            phone, address, city, province, postalCode, email) VALUES ('$medicareID',
            '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate',
            '$phone', '$address', '$city', '$province', '$postalCode', '$email')";
        $conn->query($sql);
    } // no occupation in inserting into attends, no fID in HTML either
    $sql = "INSERT INTO attends (fID, medicareID, startDate, endDate) 
                VALUES ('$fID', '$medicareID', '$startDate', NULL)";
    $conn->query($sql);
    $conn->close();
}

// Create a new employee
function addEmployee(
    $medicareID,
    $firstName,
    $lastName,
    $dOB,
    $MedicareExpiryDate,
    $phone,
    $address,
    $city,
    $province,
    $postalCode,
    $email,
    $fID,
    //No fID in the HTML? *BUG*
    $jobTitle
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $medicareID = $conn->real_escape_string($medicareID);
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $fID = $conn->real_escape_string($fID);
    $dOB = $conn->real_escape_string($dOB);
    $MedicareExpiryDate = $conn->real_escape_string($MedicareExpiryDate);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $city = $conn->real_escape_string($city);
    $province = $conn->real_escape_string($province);
    $postalCode = $conn->real_escape_string($postalCode);
    $email = $conn->real_escape_string($email);
    $jobTitle = $conn->real_escape_string($jobTitle);

    // Get today's date
    $startDate = date('Y-m-d');

    //check if employee is already in people table
    $sql = "SELECT * FROM People WHERE medicareID = '$medicareID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Employee already exists in People table. Adding to Employee table only.";
        $sql = "INSERT INTO Employee (medicareID, jobTitle) VALUES ('$medicareID', '$jobTitle')";
        $conn->query($sql);
    } else {
        echo "Employee does not exist in People table. Adding to People and Employee tables.";
        // Insert into People table
        $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate,
            phone, address, city, province, postalCode, email, jobTitle) VALUES ('$medicareID',
            '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate',
            '$phone', '$address', '$city', '$province', '$postalCode', '$email', '$jobTitle')";
        $conn->query($sql);
    } // no occupation in inserting into attends, no fID in HTML either
    $sql = "INSERT INTO attends (fID, medicareID, startDate, endDate)
                VALUES ('$fID', '$medicareID', '$startDate', NULL)";
    $conn->query($sql);

    $conn->close();
}

// Add infection
// If a teacher contracts COVID-19, the system should promptly
// void their assignments for two weeks and send an email to 
// the school principal with the subject "Warning" and the content
// "Roger Brian, a teacher in your school, tested positive for COVID-19 on January 24, 2023."
function CreateInfection(
    $medicareID,
    $infectionName,
    $infectionDate
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $infectionName = $conn->real_escape_string($infectionName);
    $infectionDate = $conn->real_escape_string($infectionDate);

    // Get today's date
    $today = date('Y-m-d');

    // Select virus name
    $sqlVirus = "SELECT vID FROM Viruses WHERE type = '$infectionName'";
    $vID = $conn->query($sqlVirus);

    // Add infection to table
    /* NOT SURE IF DATE WORKS LIKE THIS */
    $sql = "INSERT INTO infections (vID, medicareID, date) VALUES (($vID), '$medicareID', '$infectionDate')";
    $conn->query($sql);

    //Check if COVID-19
    if ($infectionName == "COVID-19") {
        // Check if teacher
        $sqlJobCheck = "SELECT jobTitle FROM Employee WHERE medicareID = '$medicareID'";
        $jobTitle = $conn->query($sqlJobCheck);
        // if $jobTitle contains substring "Teacher"
        if (strpos($jobTitle, "Teacher") !== false) {
            // find fID of teacher and president with the same fID
            $sqlFID = "SELECT fID FROM attends WHERE medicareID = '$medicareID'";
            $fID = $conn->query($sqlFID);
            $sqlPresident = "SELECT medicareID FROM attends WHERE fID = '$fID' AND occupation = 'President'";
            $presidentID = $conn->query($sqlPresident);
            // Get president's email
            $sqlEmail = "SELECT email FROM People WHERE medicareID = '$presidentID'";
            $presidentEmail = $conn->query($sqlEmail);
            // find employee first name and last name
            $sqlFirstName = "SELECT firstName FROM People WHERE medicareID = '$medicareID'";
            $firstName = $conn->query($sqlFirstName);
            $sqlLastName = "SELECT lastName FROM People WHERE medicareID = '$medicareID'";
            $lastName = $conn->query($sqlLastName);
            // compose email
            $to = $presidentEmail;
            $subject = "Warning"; // no where to put subject in emailLogs so I'll just concatenate it in the body
            $txt = "$firstName $lastName, a teacher in your school, tested positive for COVID-19 on $infectionDate.";
            //add to emailLogs
            $sqlEmailLog = "INSERT INTO emailLogs (dateOfEmail, facilityName, receiverEmail, emailSubject, emailBody) VALUES ('$today', '$fID', '$presidentEmail', '$subject', '$txt')";
            // get the autoincremented id from the insert
            $emailID = $conn->insert_id;
            // add to sent
            $sqlSent = "INSERT INTO sent (emailID, fID, medicareID) VALUES ('$emailID', '$fID', '$medicareID')";

            //clear shedule for 2 weeks
            //$sqlClearSchedule = // NOT SURE HOW TO DO THIS
        }
    }
}

// New Vaccination
function CreateVaccination(
    $vaccineName,
    $medicareID,
    $numDose,
    $vaccinationDate
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $vaccineName = $conn->real_escape_string($vaccineName);
    $medicareID = $conn->real_escape_string($medicareID);
    $numDose = $conn->real_escape_string($numDose);
    $vaccinationDate = $conn->real_escape_string($vaccinationDate);

    // Get today's date
    $today = date('Y-m-d');

    // Select virus name
    $sqlVirus = "SELECT vID FROM Vaccines WHERE vaccineName = '$vaccineName'";
    $vID = $conn->query($sqlVirus);

    // Add vaccination to table
    /* NOT SURE IF DATE WORKS LIKE THIS */
    // numDose here isn't like numDose in the database; here it's how many doses in one vaccination
    // steps: count how many previous vaccinations of the same type the person has, add numDose to that number, and insert that number into database 
    $sqlCountDoses = "SELECT COUNT(*) FROM vaccinations WHERE medicareID = '$medicareID' AND vID = '$vID'";
    $numDosetemp = $conn->query($sqlCountDoses);
    $numDose = $numDose + $numDosetemp;
    $sql = "INSERT INTO vaccinations (vID, medicareID, numDose, date) VALUES (($sqlVirus), $medicareID, $numDose, '$vaccinationDate')";
    $conn->query($sql);
}


// Get facilities
function getFacilities()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $facilities = array();
    $sql = "SELECT * FROM Facilities";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $facilities[] = $row;
    }
    $conn->close();
    return $facilities;
}

// Get students
function getStudents()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $students = array();
    $sql = "SELECT p.firstName as First Name, p.lastName as Last Name
        FROM People p, Students s WHERE p.medicareID = s.medicareID";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $conn->close();
    return $students;
}

// Get facility name by ID
function getFacilityName($fID)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $fID = $conn->real_escape_string($fID);
    $sql = "SELECT facilityName FROM Facilities WHERE id = '$fID'";
    $result = $conn->query($sql);
    $facilityName = "";
    if ($row = $result->fetch_assoc()) {
        $facilityName = $row['facilityName'];
    }
    $conn->close();
    return $facilityName;
}

// Function to determine if value already exists in table
function valueExists($table, $column, $value)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $value = $conn->real_escape_string($value);
    $sql = "SELECT * FROM $table WHERE $column = '$value'";
    $result = $conn->query($sql);
    $conn->close();
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}

//function 
?>