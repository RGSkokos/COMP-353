#test
<?php
    // Database connection setup
    $servername = "ycc353.encs.concordia.ca";
    $username = "ycc353_1";
    $password = "SoenComp";
    $dbname = "ycc353_1";

        // Listening for posts and checking if the submit button was pressed
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            // Check if the submit button was pressed for create facility
            if(isset($_POST['SubmitCreateFacility'])) {
                if(valueExists('Facilities', 'fID', $_POST['fID'])) { // Check if facility ID already exists in db
                echo "Facility ID already exists.";
                } elseif (!isset($_POST['fID']) || !isset($_POST['type']) || !isset($_POST['description']) || !isset($_POST['facilityName']) || !isset($_POST['address']) || !isset($_POST['city']) || !isset($_POST['province']) || !isset($_POST['postalCode']) || !isset($_POST['phoneNumber']) || !isset($_POST['webAddr']) || !isset($_POST['capacity'])) { // Check if all fields are set
                    echo "Please fill in all fields.";
                } else { // otherwise set the values from the form and call the createFacility function
                    createFacility($_POST['fID'], $_POST['type'], $_POST['description'],
                    $_POST['facilityName'], $_POST['address'], $_POST['city'],
                    $_POST['province'], $_POST['postalCode'], $_POST['phoneNumber'],
                    $_POST['webAddr'], $_POST['capacity']);
                }
            }
            // Check if the submit button was pressed for add Student
            elseif(isset($_POST['SubmitAddStudent'])) {
                if(valueExists('Students', 'medicareID', $_POST['medicareID'])) {
                echo "Student already exists.";
                } elseif(!isset($_POST['medicareID']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['dOB']) || !isset($_POST['MedicareExpiryDate']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['city']) || !isset($_POST['province']) || !isset($_POST['postalCode']) || !isset($_POST['email']) || ) {
                    echo "Please fill in all fields.";
                } else {
                    addStudent($_POST['medicareID'], $_POST['firstName'], $_POST['lastName'],
                    $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'],
                    $_POST['address'], $_POST['city'], $_POST['province'],
                    $_POST['postalCode'], $_POST['email']);
                }
            }
            // Check if the submit button was pressed for add Employee
            elseif(isset($_POST['SubmitAddEmployee'])){
                if(valueExists('Employees', 'medicareID', $_POST['medicareID'])) {
                echo "Employee already exists.";
                } elseif(!isset($_POST['medicareID']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['dOB']) || !isset($_POST['MedicareExpiryDate']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['city']) || !isset($_POST['province']) || !isset($_POST['postalCode']) || !isset($_POST['email']) || !isset($_POST['JobTitle'])) {
                    echo "Please fill in all fields.";
                } else {
                    addEmployee($_POST['medicareID'], $_POST['firstName'], $_POST['lastName'],
                    $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'],
                    $_POST['address'], $_POST['city'], $_POST['province'],
                    $_POST['postalCode'], $_POST['email'], $_POST['JobTitle']);
                }
            }
            //Check if the submit button was pressed for new Infection
            elseif(isset($_POST['SubmitNewInfection'])){
                if(!isset($_POST['medicareID']) || !isset($_POST['infectionName'])) || !isset($_POST['infectionDate']) {
                    echo "Please fill in all fields.";
                } else {
                    newInfection($_POST['medicareID'], $_POST['infectionName'], $_POST['infectionDate']);
                }
            }
            //Check if the submit button was pressed for new vaccination
            elseif(isset($_POST['SubmitNewVaccination'])){
                if(!isset($_POST['medicareID']) || !isset($_POST['vaccineName'])) || !isset($_POST['vaccinationDate']) {
                    echo "Please fill in all fields.";
                } else {
                    newVaccination($_POST['medicareID'], $_POST['vaccineName'], $_POST['vaccinationDate']);
                }
        }
        // Create a new facility
        function createFacility($fID, $type, $description, $facilityName, $address,
        $city, $province, $postalCode, $phoneNumber, $webAddr,
        $capacity) {
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
        function addStudent($medicareID, $firstName, $lastName, $dOB, $MedicareExpiryDate,
        $phone, $address, $city, $province, $postalCode, $email, $fID) {
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
        $sql = "INSERT INTO Students (medicareID) VALUES ('$medicareID')";
        $conn->query($sql);

        // Insert into People table
        $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate,
            phone, address, city, province, postalCode, email) VALUES ('$medicareID',
            '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate',
            '$phone', '$address', '$city', '$province', '$postalCode', '$email')";
        $conn->query($sql);

        $sql = "INSERT INTO attends (fID, medicareID, startDate, endDate) 
                VALUES ('$fID', '$medicareID', '$startDate', NULL)";
        $conn->query($sql);
        $conn->close();
    }

     // Create a new employee
        function addEmployee($medicareID, $firstName, $lastName, $dOB, $MedicareExpiryDate,
        $phone, $address, $city, $province, $postalCode, $email, $fID, $jobTitle) {
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

        $sql = "INSERT INTO Employee (medicareID, jobTitle) VALUES ('$medicareID', '$jobTitle')";
        $conn->query($sql);

        // Insert into People table
        $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate,
            phone, address, city, province, postalCode, email, jobTitle) VALUES ('$medicareID',
            '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate',
            '$phone', '$address', '$city', '$province', '$postalCode', '$email', '$jobTitle')";
        $conn->query($sql);

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
    function newInfection($medicareID, $infectionName, $infectionDate){
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
        if($infectionName == "COVID-19"){
            // Check if teacher
            $sqlJobCheck = "SELECT jobTitle FROM Employee WHERE medicareID = '$medicareID'";
            $jobTitle = $conn->query($sqlTeacherCheck);
            // if $jobTitle contains substring "Teacher"
            if(strpos($jobTitle, "Teacher") !== false){
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
                $txt = $subject." $firstName $lastName, a teacher in your school, tested positive for COVID-19 on $infectionDate.";
                //add to emailLogs
                $sqlEmailLog = "INSERT INTO emailLogs (dateOfEmail, facilityName, receiverEmail, emailBody) VALUES ('$today', '$fID', '$presidentEmail', '$txt')";
                // how do you add to sent without knowing the emailID?
                

                //clear shedule for 2 weeks
                $sqlClearSchedule = // NOT SURE HOW TO DO THIS
            }
        }
    }
    
    // New Vaccination
    function newVaccination($vaccineName, $medicareID,$numDose, $vaccinationDate){
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
        // also numdose, shouldn't it be automatic? Check if there's a medicare id with an already existing vID and do numDose + 1
        $sql = "INSERT INTO vaccinations (vID, medicareID, numDose, date) VALUES (($sqlVirus), $medicareID, $numDose, '$vaccinationDate')";
        $conn->query($sql);
    }


    // Get facilities
    function getFacilities() {
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
    function getStudents() {
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
    function getFacilityName($fID) {
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
    function valueExists($table, $column, $value) {
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
?>
    // Edit and delete for facilities, students, employees.
    // Get and POST Vaccines and Infections