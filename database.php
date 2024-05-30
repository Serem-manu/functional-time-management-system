<?php
session_start();


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Employee data');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'getEmployees') {
        getEmployees($conn);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); 

    $action = $_POST['action'];
    $employeeName = mysqli_real_escape_string($conn, $_POST['employeeName']);

    if ($action === 'storeCheckInTime' || $action === 'storeCheckOutTime') {
        $checkTime = $_POST[$action === 'storeCheckInTime' ? 'checkInTime' : 'checkOutTime'];

        
        $sql = "SELECT * FROM users WHERE name = '$employeeName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            if ($action === 'storeCheckInTime') {
                handleCheckIn($employeeName, $checkTime, $conn);
            } else {
                handleCheckOut($employeeName, $checkTime, $conn);
            }
        } else {
            $response = array('status' => 'error', 'message' => "Employee not found in the database.");
            echo json_encode($response);
        }
    }
}

function getEmployees($conn) {
    $sql = "SELECT name FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employees = array();
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        $response = array('status' => 'success', 'employees' => $employees);
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => "No employees found.");
        echo json_encode($response);
    }
}

function handleCheckIn($name, $checkInTime, $conn) {
    $checkInTime = mysqli_real_escape_string($conn, $checkInTime);
    $sql = "INSERT INTO employee_records (employee_name, check_in_time) VALUES ('$name', '$checkInTime')";
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => "Check-in successful for $name at $checkInTime");
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => "Error: " . $sql . "<br>" . $conn->error);
        echo json_encode($response);
    }
}

function handleCheckOut($name, $checkOutTime, $conn) {
    $checkOutTime = mysqli_real_escape_string($conn, $checkOutTime);
    $sql = "UPDATE employee_records 
            SET check_out_time = '$checkOutTime'
            WHERE employee_name = '$name'
            AND check_out_time IS NULL
            ORDER BY id DESC
            LIMIT 1";
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => "Check-out successful for $name at $checkOutTime");
        echo json_encode($response);
        calculateHoursWorked($name, $checkOutTime, $conn);
    } else {
        $response = array('status' => 'error', 'message' => "Error: " . $sql . "<br>" . $conn->error);
        echo json_encode($response);
    }
}

function calculateHoursWorked($name, $checkOutTime, $conn) {
    $sql = "SELECT check_in_time FROM employee_records WHERE employee_name = '$name' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $checkInTime = new DateTime($row['check_in_time']);
        $checkOutTime = new DateTime($checkOutTime);
        $interval = $checkInTime->diff($checkOutTime);
        $hoursWorked = $interval->format('%H:%I:%S');
        $sql = "UPDATE employee_records SET hours_worked = '$hoursWorked' WHERE employee_name = '$name' ORDER BY id DESC LIMIT 1";
        $conn->query($sql);
    }
}

$conn->close();
?>