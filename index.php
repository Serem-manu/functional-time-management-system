<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./checkin/login.css">
  <title>Time Management System</title>
</head>
<body>

<?php
// Include configuration file
include 'config.php';

// Error message (initially empty)
$errorMessage = "";

// Check if login form is submitted
if (isset($_POST['submit'])) {
  $employeeId = mysqli_real_escape_string($conn, $_POST['employeeId']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Validate credentials using database query
  $sql = "SELECT * FROM users WHERE employee_id = '$employeeId' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  // Check if a user record is found
  if (mysqli_num_rows($result) > 0) {
    // Login successful - redirect to a different page (replace with your desired location)
    header("Location: successful_login.html");
    exit;
  } else {
    $errorMessage = "Invalid login credentials!";
  }
}

?>

<div class="login-container" id="loginContainer">
  <h2>Login</h2>
  <?php if ($errorMessage): ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
  <?php endif; ?>
  <label for="employeeId">Employee ID:</label>
  <input type="text" id="employeeId" name="employeeId" placeholder="Enter Employee ID">
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" placeholder="Enter Password">
  <input type="checkbox" onclick="myFunction()">Show Password
  <button type="submit" name="submit">Login</button>
  <a href="https://serem-manu.github.io/time-management-system/checkin/signup.html"><p>signup</p></a>
  <a href="https://serem-manu.github.io/time-management-system/checkin/adminlog.html"><p>adminLogin</p></a>
</div>

<script src="./checkin/login.js"></script>  </body>
</html>
