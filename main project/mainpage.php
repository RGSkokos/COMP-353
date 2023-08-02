<?php
    // Database connection setup
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database";

    // Create a new facility
    function createFacility($name) {
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        $name = $conn->real_escape_string($name);
        $sql = "INSERT INTO facilities (name) VALUES ('$name')";
        $conn->query($sql);
        $conn->close();
    }

    // Create a new student
    function createStudent($name, $facilityId) {
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        $name = $conn->real_escape_string($name);
        $facilityId = $conn->real_escape_string($facilityId);
        $sql = "INSERT INTO students (name, facility_id) VALUES ('$name', '$facilityId')";
        $conn->query($sql);
        $conn->close();
    }

    // Get facilities
    function getFacilities() {
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        $facilities = array();
        $sql = "SELECT * FROM facilities";
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
        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        $conn->close();
        return $students;
    }

    // Get facility name by ID
    function getFacilityName($facilityId) {
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        $facilityId = $conn->real_escape_string($facilityId);
        $sql = "SELECT name FROM facilities WHERE id = '$facilityId'";
        $result = $conn->query($sql);
        $facilityName = "";
        if ($row = $result->fetch_assoc()) {
            $facilityName = $row['name'];
        }
        $conn->close();
        return $facilityName;
    }
?>
