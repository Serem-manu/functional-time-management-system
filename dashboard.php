<?php
    session_start();

    // Check if the user is logged in
    // if (!isset($_SESSION["employee_name"])) {
    //     header("Location: login.php");
    //     exit();
    // }

    $employeeName = $_SESSION["employee_name"];
    ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="signup-container">
  <h1>Employee Dashboard</h1>
    <p>Welcome, <?php echo $employeeName; ?></p>
    <div class="button">
    <div id="check-in-out">
        <button id="checkInBtn">Check In</button><br><br>
        <button id="checkOutBtn" disabled>Check Out</button><br><br>
    </div>
    </div>
    </div>
    

    <script src="script.js"></script>
</body>
</html>