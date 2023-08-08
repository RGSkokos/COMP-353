<?php
// Create a new facility
function CreateFacility(
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
        die("Connection failed: CreateFacility" . $conn->connect_error);
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
        echo " Inserted into facilities successfully";
    } else {
        echo "Error: Insert into facilities failed" . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Create a new student
function CreateStudent(
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
    $occupation
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
    $occupation = $conn->real_escape_string($occupation);


    // Get today's date
    $startDate = date('YYYY-MM-DD');
    // string to date
    $MedicareExpiryDate = date('YYYY-MM-DD', strtotime($MedicareExpiryDate));

    // check if student is already in people table
    $sql = "SELECT count(*) FROM People WHERE medicareID = '$medicareID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Student already exists in People table. Adding to Student table only";
        $sql = "INSERT INTO Students (medicareID) VALUES ('$medicareID')";
        if ($conn->query($sql) === TRUE) {
            echo "Inserted into students successfully";
          } else {
            echo "Error: Insert into students failed " . $sql . "<br>" . $conn->error;
          };
    } else {

        // Insert into People table
        $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate,
            phone, address, city, province, postalCode, email) VALUES ('$medicareID',
            '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate',
            '$phone', '$address', '$city', '$province', '$postalCode', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Inserted into people table successfully";
          } else {
            echo "Error: Insert into people table failed" . $sql . "<br>" . $conn->error;
          };
    } // no occupation in inserting into attends table
    $sql = "INSERT INTO attends (fID, medicareID, startDate, endDate, occupation) 
                VALUES ('$fID', '$medicareID', '$startDate', NULL, '$occupation')";
    if ($conn->query($sql) === TRUE) {
        echo "Inserted into attends successfully";
      } else {
        echo "Error: Insert into attends failed" . $sql . "<br>" . $conn->error;
      };
    $conn->close();
}

// Create a new employee
function CreateEmployee(
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
    $jobTitle,
    $occupation
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
    $startDate = date('YYYY-MM-DD');
    //string to date
    $MedicareExpiryDate = date('YYYY-MM-DD', strtotime($MedicareExpiryDate));

    //check if employee is already in people table
    $sql = "SELECT count(*) FROM People WHERE medicareID = '$medicareID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Employee already exists in People table. Adding to Employee table only.";
        $sql = "INSERT INTO Employee (medicareID, jobTitle) VALUES ('$medicareID', '$jobTitle')";
        if ($conn->query($sql) === TRUE) {
            echo "Inserted into employee table successfully";
          } else {
            echo "Error: Insert into employee table failed " . $sql . "<br>" . $conn->error;
          };
    } else {
        echo "Employee does not exist in People table. Adding to People and Employee tables.";
        // Insert into People table
        $sql = "INSERT INTO People (medicareID, firstName, lastName, dOB, MedicareExpiryDate,
            phone, address, city, province, postalCode, email, jobTitle) VALUES ('$medicareID',
            '$firstName', '$lastName', '$dOB', '$MedicareExpiryDate',
            '$phone', '$address', '$city', '$province', '$postalCode', '$email', '$jobTitle')";
        if ($conn->query($sql) === TRUE) {
            echo "Inserted into people successfully";
          } else {
            echo "Error: Insert into people failed" . $sql . "<br>" . $conn->error;
          };
    } // no occupation in inserting into attends, no fID in HTML either
    $sql = "INSERT INTO attends (fID, medicareID, startDate, endDate, occupation)
                VALUES ('$fID', '$medicareID', '$startDate', NULL, '$occupation')";
    if ($conn->query($sql) === TRUE) {
        echo "Inserted into attends successfully";
      } else {
        echo "Error: Insert into attends failed" . $sql . "<br>" . $conn->error;
      };

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
        die("Connection failed: CreateInfection" . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $infectionName = $conn->real_escape_string($infectionName);
    $infectionDate = $conn->real_escape_string($infectionDate);

    // Get today's date
    $today = date('YYYY-MM-DD');
    // string to date
    $infectionDate = date('YYYY-MM-DD', strtotime($infectionDate));

    // Select virus name
    $sqlVirus = "SELECT vID FROM Viruses WHERE type = '$infectionName'";
    $vID = $conn->query($sqlVirus);

    // Add infection to table
    $infectionDate = date('YYYY-MM-DD', strtotime($infectionDate));
    $sql = "INSERT INTO infections (vID, medicareID, date) VALUES (($vID), '$medicareID', '$infectionDate')";
    if ($conn->query($sql) === TRUE) {
        echo "Inserted into Infection successfully";
      } else {
        echo "Error: Insert into Infection failed " . $sql . "<br>" . $conn->error;
      };

    //Check if COVID-19
    if ($infectionName == "COVID-19") {
        // Check if teacher
        $sqlJobCheck = "SELECT jobTitle FROM Employee WHERE medicareID = '$medicareID'";
        $jobTitle = $conn->query($sqlJobCheck);
        // if $jobTitle contains substring "Teacher"
        if (strpos($jobTitle, "Teacher") !== false) { //!== false from https://www.php.net/manual/en/function.strpos.php
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
            $subject = "Warning";
            $txt = "$firstName $lastName, a teacher in your school, tested positive for COVID-19 on $infectionDate.";
            //add to emailLogs
            $sqlEmailLog = "INSERT INTO emailLogs (dateOfEmail, facilityName, receiverEmail, emailSubject, emailBody) VALUES ('$today', '$fID', '$presidentEmail', '$subject', '$txt')";
            if ($conn->query($sqlEmailLog) === TRUE) {
                echo "Inserted into emailLogs successfully";
              } else {
                echo "Error: Insert into emailLogs failed" . $sql . "<br>" . $conn->error;
              };
            // get the autoincremented id from the insert
            $emailID = $conn->insert_id;
            // add to sent
            $sqlSent = "INSERT INTO sent (emailID, fID, medicareID) VALUES ('$emailID', '$fID', '$medicareID')";
            if ($conn->query($sqlSent) === TRUE) {
                echo "Inserted into sent successfully";
              } else {
                echo "Error: Insert into sent failed" . $sql . "<br>" . $conn->error;
              }


            //clear shedule for 2 weeks
            $sql = "DELETE FROM schedule WHERE medicareID = '$medicareID' AND date >= '$infectionDate' AND date <= '$infectionDate' + INTERVAL 14 DAY";
            if ($conn->query($sql) === TRUE) {
                echo "Schedule cleared successfully";
              } else {
                echo "Error: Schedule clear failed" . $sql . "<br>" . $conn->error;
              }

        }
    }
}

// New Vaccination
function CreateVaccination(
    $vaccineName,
    $medicareID,
    // $numDose,
    $vaccinationDate
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: CreateVaccination" . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $vaccineName = $conn->real_escape_string($vaccineName);
    $medicareID = $conn->real_escape_string($medicareID);
    // $numDose = $conn->real_escape_string($numDose);
    $vaccinationDate = $conn->real_escape_string($vaccinationDate);

    // Get today's date
    $today = date('YYYY-MM-DD');
    //to str to date
    $vaccinationDate = date('YYYY-MM-DD', strtotime($vaccinationDate));

    // Select virus name
    $sqlVirus = "SELECT vID FROM Vaccines WHERE vaccineName = '$vaccineName'";
    $vID = $conn->query($sqlVirus);

    // find count of numDose for the medicareID
    $sqlCountDoses = "SELECT COUNT(*) FROM vaccinations WHERE medicareID = '$medicareID'";
    $numDose = $conn->query($sqlCountDoses);
    $numDose = $sqlCountDoses + 1;
    
    //Add vaccinations to table
    $sql = "INSERT INTO vaccinations (vID, medicareID, numDose, date) VALUES (($vID), '$medicareID', '$numDose', '$vaccinationDate')";
    if ($conn->query($sql) === TRUE) {
        echo "Inserted into Vaccinations successfully";
      } else {
        echo "Error: Insert into Vaccinations failed" . $sql . "<br>" . $conn->error;
      };

    //close connection
    $conn->close();
}

// Function to delete a facility
function DeleteFacility($fID)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $fID = $conn->real_escape_string($fID);
    $sql = "DELETE FROM Facilities WHERE fID = '$fID'";
    if ($conn->query($sql) === TRUE) {
        echo "Facility deleted successfully";
      } else {
        echo "Error deleting facility" . $conn->error;
      }
    $conn->close();
}

// Function to delete an employee
function DeleteEmployee($medicareID)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $medicareID = $conn->real_escape_string($medicareID);

    // set employee end date to today in attends table
    $today = date('YYYY-MM-DD');
    $sql = "UPDATE attends SET endDate = '$today' WHERE medicareID = '$medicareID' AND endDate = 'NULL'";
    if ($conn->query($sql) === TRUE) {
        echo "attends updated successfully";
      } else {
        echo "Error updating record: attends " . $conn->error;
      }

    $conn->close();
}

//Function to delete a student
function DeleteStudent($medicareID)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // set student end date to today in attends table
    $today = date('YYYY-MM-DD');
    $sql = "UPDATE attends SET endDate = '$today' WHERE medicareID = '$medicareID' AND endDate = 'NULL'";
    if ($conn->query($sql) === TRUE) {
        echo "attends updated successfully";
      } else {
        echo "Error updating record: attends" . $conn->error;
      }

    $conn->close();
}
//Function to delete infections
function DeleteInfection($virusName, $medicareID, $infectionDate)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    //get vID from Viruses
    $sql = "SELECT vID FROM Viruses WHERE type = '$virusName'";
    $vID = $conn->query($sql);

    $sql = "DELETE FROM Infections WHERE vID = '$vID' AND medicareID = '$medicareID' AND infectionDate = '$infectionDate'";
    if ($conn->query($sql) === TRUE) {
        echo "infections updated successfully";
      } else {
        echo "Error updating record: infections" . $conn->error;
      }

    $conn->close();
}

function DeleteVaccination($virusName, $medicareID, $numDose)
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: DeleteVaccination" . $conn->connect_error);
    }

    //get vID from Vaccines table
    $sql = "SELECT vID FROM Vaccines WHERE virusName = '$virusName'";
    $vID = $conn->query($sql);
    //Delete vaccination from Vaccinations table where vID, medicareID, and numDose
    $sql = "DELETE FROM Vaccinations WHERE vID = '$vID' AND medicareID = '$medicareID'";    
    if ($conn->query($sql) === TRUE) {
        echo "Vaccination deleted successfully";
      } else {
        echo "Error deleting record: Vaccinations" . $conn->error;
      }
}

// Function to edit a facility
function EditFacility(
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
        die("Connection failed: EditFacility" . $conn->connect_error);
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

    $sql = "UPDATE Facilities SET type = '$type', description = '$description', facilityName = '$facilityName', address = '$address', city = '$city', province = '$province', postalCode = '$postalCode', phoneNumber = '$phoneNumber', webAddr = '$webAddr', capacity = '$capacity' WHERE fID = '$fID'";
    if ($conn->query($sql) === TRUE) {
        echo "Facilities updated successfully";
      } else {
        echo "Error updating record: Facilities" . $conn->error;
      }
    $conn->close();
}

function EditEmployee(
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
    $jobTitle
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: EditEmployee" . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $dOB = $conn->real_escape_string($dOB);
    $MedicareExpiryDate = $conn->real_escape_string($MedicareExpiryDate);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $city = $conn->real_escape_string($city);
    $province = $conn->real_escape_string($province);
    $postalCode = $conn->real_escape_string($postalCode);
    $email = $conn->real_escape_string($email);
    $jobTitle = $conn->real_escape_string($jobTitle);    

    // string to date
    $dOB = date('YYYY-MM-DD', strtotime($dOB));
    $MedicareExpiryDate = date('YYYY-MM-DD', strtotime($MedicareExpiryDate));
    
    // set changed job title in employee table 
    $sql = "UPDATE Employee SET jobTitle = '$jobTitle'";
    if ($conn->query($sql) === TRUE) {
        echo "Employee updated successfully";
      } else {
        echo "Error updating record: Employee" . $conn->error;
      }

    // set changes in people table
    $sql = "UPDATE People SET firstName = '$firstName', lastName = '$lastName', dOB = '$dOB', MedicareExpiryDate = '$MedicareExpiryDate', phone = '$phone', address = '$address', city = '$city', province = '$province', postalCode = '$postalCode', email = '$email' WHERE medicareID = '$medicareID'";
    if ($conn->query($sql) === TRUE) {
        echo "People updated successfully";
      } else {
        echo "Error updating record: People" . $conn->error;
      }

    $conn->close();
}

Function EditStudent(
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
    $email
    )
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: EditStudent" . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $dOB = $conn->real_escape_string($dOB);
    $MedicareExpiryDate = $conn->real_escape_string($MedicareExpiryDate);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $city = $conn->real_escape_string($city);
    $province = $conn->real_escape_string($province);
    $postalCode = $conn->real_escape_string($postalCode);
    $email = $conn->real_escape_string($email);

    // string to date
    $dOB = date('YYYY-MM-DD', strtotime($dOB));
    $MedicareExpiryDate = date('YYYY-MM-DD', strtotime($MedicareExpiryDate));

    // set changes in people table
    $sql = "UPDATE People SET firstName = '$firstName', lastName = '$lastName', dOB = '$dOB', MedicareExpiryDate = '$MedicareExpiryDate', phone = '$phone', address = '$address', city = '$city', province = '$province', postalCode = '$postalCode', email = '$email' WHERE medicareID = '$medicareID'";
    if ($conn->query($sql) === TRUE) {
        echo "People updated successfully";
      } else {
        echo "Error updating record: People" . $conn->error;
      }

    $conn->close();
}

//  function to edit vaccinations
function EditVaccinations(
    $medicareID,
    $vaccineName,
    $numDose,
    $date
) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: EditVaccinations" . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $vaccineName = $conn->real_escape_string($vaccineName);
    $numDose = $conn->real_escape_string($numDose);
    $date = $conn->real_escape_string($date);

    // string to date
    $date = date('YYYY-MM-DD', strtotime($date));

    //get vID from vaccineName
    $vID = "SELECT vID FROM Vaccines WHERE vaccineName = '$vaccineName'";

    // set changes in vaccinations table with the same medicareID and numDose
    $sql = "UPDATE vaccinations SET vID = '$vID', date = '$date' WHERE medicareID = '$medicareID' AND numDose = '$numDose'";
    if ($conn->query($sql) === TRUE) {
        echo "Vaccinations updated successfully";
      } else {
        echo "Error updating record: Vaccinations" . $conn->error;
      }

    $conn->close();
}

//function to edit infection table date
function EditInfections(
    $medicareID,
    $infectionName,
    $date
){
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: EditInfections" . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $medicareID = $conn->real_escape_string($medicareID);
    $infectionName = $conn->real_escape_string($infectionName);
    $date = $conn->real_escape_string($date);

    // string to date
    $date = date('YYYY-MM-DD', strtotime($date));

    //get vID from infectionName
    $vID = "SELECT vID FROM Infections WHERE infectionName = '$infectionName'";

    // set changes in people table
    $sql = "UPDATE Infections SET date = '$date' WHERE medicareID = '$medicareID' AND vID = '$vID',";
    if ($conn->query($sql) === TRUE) {
        echo "Infections updated successfully";
      } else {
        echo "Error updating record: Infections" . $conn->error;
      }

    $conn->close();
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
// get employees
function getEmployees()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    $employees = array();
    $sql = "SELECT p.firstName as First Name, p.lastName as Last Name
        FROM People p, Employees e WHERE p.medicareID = e.medicareID";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    $conn->close();
    return $employees;
}

function getVaccinations()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    $vaccines = array();
    $sql = "SELECT * FROM vaccinations";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $vaccines[] = $row;
    }
    $conn->close();
    return $vaccines;
}

function getInfections()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    $infections = array();
    $sql = "SELECT * FROM infections";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $infections[] = $row;
    }
    $conn->close();
    return $infections;
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
?>