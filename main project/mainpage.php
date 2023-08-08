<?php
require_once('phpFunctions.php');

// Database connection setup
$servername = "ycc353.encs.concordia.ca";
$username = "ycc353_1";
$password = "SoenComp";
$dbname = "ycc353_1";


// Listening for posts and checking if the submit button was pressed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the submit button was pressed for create facility
    if (isset($_POST['SubmitCreateFacility'])) {
        if (valueExists('Facilities', 'fID', $_POST['fID'])) { // Check if facility ID already exists in db
            echo "Facility ID already exists.";
        } elseif (!isset($_POST['fID']) || !isset($_POST['type']) || !isset($_POST['description']) || !isset($_POST['facilityName']) || !isset($_POST['address']) || !isset($_POST['city']) || !isset($_POST['province']) || !isset($_POST['postalCode']) || !isset($_POST['phoneNumber']) || !isset($_POST['webAddr']) || !isset($_POST['capacity'])) { // Check if all fields are set
            echo "Please fill in all fields.";
        } else { // otherwise set the values from the form and call the createFacility function
            CreateFacility(
                $_POST['fID'], $_POST['type'], $_POST['description'],
                $_POST['facilityName'], $_POST['address'], $_POST['city'],
                $_POST['province'], $_POST['postalCode'], $_POST['phoneNumber'],
                $_POST['webAddr'], $_POST['capacity']
            );
        }
    }
    // Check if the submit button was pressed for add Student
    elseif (isset($_POST['SubmitAddStudent'])) {
        // check if student already exists
        if (valueExists('Students', 'medicareID', $_POST['medicareID'])) {
            echo "Student already exists.";
        } elseif (!isset($_POST['medicareID']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['dOB']) || !isset($_POST['MedicareExpiryDate']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['city']) || !isset($_POST['province']) || !isset($_POST['postalCode']) || !isset($_POST['email'])) {
            echo "Please fill in all fields.";
        } else {
            CreateStudent(
                $_POST['medicareID'], $_POST['firstName'], $_POST['lastName'],
                $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'],
                $_POST['address'], $_POST['city'], $_POST['province'],
                $_POST['postalCode'], $_POST['email'], $_POST['fID'], $_POST['occupation'] // fID isn't in HTML form yet
            );
        }
    }
    // Check if the submit button was pressed for add Employee
    elseif (isset($_POST['SubmitAddEmployee'])) {
        if (valueExists('Employees', 'medicareID', $_POST['medicareID'])) {
            echo "Employee already exists.";
        } elseif (!isset($_POST['medicareID']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['dOB']) || !isset($_POST['MedicareExpiryDate']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['city']) || !isset($_POST['province']) || !isset($_POST['postalCode']) || !isset($_POST['email']) || !isset($_POST['JobTitle'])) {
            echo "Please fill in all fields.";
        } else {
            CreateEmployee(
                $_POST['medicareID'], $_POST['firstName'], $_POST['lastName'],
                $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'],
                $_POST['address'], $_POST['city'], $_POST['province'],
                $_POST['postalCode'], $_POST['email'], $_POST['fID'], $_POST['JobTitle'], $_POST['occupation'] // fID isn't in HTML form yet
            );
        }
    }
    //Check if the submit button was pressed for new Infection
    elseif (isset($_POST['SubmitNewInfection'])) {
        if (!isset($_POST['medicareID']) || !isset($_POST['infectionName']) || !isset($_POST['infectionDate'])) {
            echo "Please fill in all fields.";
        } else {
            CreateInfection($_POST['medicareID'], $_POST['infectionName'], $_POST['infectionDate']);
        }
    }
    //Check if the submit button was pressed for new vaccination
    elseif (isset($_POST['SubmitNewVaccination'])) {
        if (!isset($_POST['medicareID']) || !isset($_POST['vaccineName']) || !isset($_POST['vaccinationDate'])) {
            echo "Please fill in all fields.";
        } else {
            CreateVaccination($_POST['vaccineName'], $_POST['medicareID'], $_POST['vaccinationDate']);
        }
    }
    //Check if the delete button was pressed for delete facility
    elseif (isset($_POST['deletefacilitiesButton'])) {
        //get fID from the dropdown in html that connects to javascript
        try {
            DeleteFacility($_POST['fID']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //Check if the delete button was pressed for delete employee
    elseif (isset($_POST['deleteEmployeesButton'])) {
        //it needs to get the medicareID from the form somehow
        try {
            DeleteEmployee($_POST['medicareID']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['deleteStudentButton'])) {
        //it needs to get the medicareID from the form somehow
        try {
            DeleteStudent($_POST['medicareID']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['deleteInfectionButton'])) {
        //it needs to get the medicareID from the form somehow
        try {
            DeleteInfection($_POST['virusName'], $_POST['medicareID'], $_POST['infectionName']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['deleteVaccinationButton'])) {
        //it needs to get the medicareID from the form somehow
        try {
            DeleteVaccination($_POST['virusName'], $_POST['medicareID'], $_POST['numDose']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //Check if the edit button was pressed for edit facility
    elseif (isset($_POST['editFacilityButton'])) {
        //it needs to get the medicareID from the form somehow
        try{
        EditFacility($_POST['fID'], $_POST['type'], $_POST['description'], $_POST['facilityName'], $_POST['address'], $_POST['city'], $_POST['province'], $_POST['postalCode'], $_POST['phoneNumber'], $_POST['webAddr'], $_POST['capacity']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //Check if the edit button was pressed for edit employee
    elseif (isset($_POST['editEmployeeButton'])) {
        //it needs to get the medicareID from the form somehow
        try{
            EditEmployee($_POST['medicareID'], $_POST['firstName'], $_POST['lastName'], $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['province'], $_POST['postalCode'], $_POST['email'], $_POST['JobTitle']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //Check if the edit button was pressed for edit student
    elseif (isset($_POST['editStudentButton'])) {
        //it needs to get the medicareID from the form somehow
        try{
            EditStudent($_POST['medicareID'], $_POST['firstName'], $_POST['lastName'], $_POST['dOB'], $_POST['MedicareExpiryDate'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['province'], $_POST['postalCode'], $_POST['email']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //Check if the edit button was pressed for edit infection
    elseif (isset($_POST['editInfectionButton'])) {
        //it needs to get the medicareID from the form somehow
        try{
        EditInfections($_POST['medicareID'], $_POST['infectionName'], $_POST['date']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //Check if the edit button was pressed for edit vaccination
    elseif (isset($_POST['editVaccinationButton'])) {
        //it needs to get the medicareID from the form somehow
        try{
            EditVaccinations($_POST['medicareID'], $_POST['vaccineName'], $_POST['numDose'], $_POST['date']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //get all the facilities
    elseif (isset($_POST['getFacilitiesButton'])) {
        $FacilitiesArray = GetFacilities();
    }
    //get all the employees
    elseif (isset($_POST['getEmployeesButton'])) {
        $EmployeesArray = GetEmployees();
    }
    //get all the students
    elseif (isset($_POST['getStudentsButton'])) {
        $StudentsArray = GetStudents();
    }
    //get all the infections
    elseif (isset($_POST['getInfectionsButton'])) {
        $InfectionsArray = GetInfections();
    }
    //get all the vaccinations
    elseif (isset($_POST['getVaccinationsButton'])) {
        $VaccinationsArray = GetVaccinations();
    }

}
?>
