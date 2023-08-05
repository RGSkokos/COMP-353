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
                } else { // otherwise set the values from the form and call the createFacility function
                    createFacility($_POST['fID'], $_POST['type'], $_POST['description'],
                    $_POST['facilityName'], $_POST['address'], $_POST['city'],
                    $_POST['province'], $_POST['postalCode'], $_POST['phoneNumber'],
                    $_POST['webAddr'], $_POST['capacity']);
                }
            }
            // Check if the submit button was pressed for add Student
            elseif(isset($_POST['SubmitAddStudent'])) {
                if(valueExists($_POST['medicareID'], 'medicareID', 'Students')) {
                echo "Student already exists.";
                } else {
                    addStudent($_POST['medicareID'], $_POST['firstName'], $_POST['lastName'],
                    $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'],
                    $_POST['address'], $_POST['city'], $_POST['province'],
                    $_POST['postalCode'], $_POST['email'], $_POST['fID']);
                }
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