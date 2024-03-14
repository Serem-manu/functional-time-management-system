<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Employee data');

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $employeeName = $_SESSION["name"];

    switch ($action) {
        case 'checkIn':
            handleCheckIn($employeeName, $conn);
            break;
        case 'checkOut':
            handleCheckOut($employeeName, $conn);
            break;
    }
}

function handleCheckIn($name, $conn) {
    $checkInTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO employee_records (employee_name, check_in_time) VALUES ('$name', '$checkInTime')";

    if ($conn->query($sql) === TRUE) {
        echo "Check-in successful for $name at $checkInTime";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function handleCheckOut($name, $conn) {
    $checkOutTime = date('Y-m-d H:i:s');
    $sql = "UPDATE employee_records SET check_out_time = '$checkOutTime' WHERE employee_name = '$name' AND check_out_time IS NULL ORDER BY id DESC LIMIT 1";

    if ($conn->query($sql) === TRUE) {
        echo "Check-out successful for $name at $checkOutTime";
        calculateHoursWorked($name, $conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function calculateHoursWorked($name, $conn) {
    $sql = "SELECT check_in_time, check_out_time FROM employee_records WHERE employee_name = '$name' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $checkInTime = new DateTime($row['check_in_time']);
        $checkOutTime = new DateTime($row['check_out_time']);
        $hoursWorked = $checkOutTime->diff($checkInTime)->format('%H:%I:%S');

        $sql = "UPDATE employee_records SET hours_worked = '$hoursWorked' WHERE employee_name = '$name' ORDER BY id DESC LIMIT 1";
        $conn->query($sql);
    }
}

$conn->close();