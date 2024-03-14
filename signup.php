<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Employee data'); // Changed the database name to match

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $name = $_POST["name"]; // Changed to 'name' from 'employee_name'

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO users (password, name) VALUES ('$hashedPassword', '$name')"; // Changed to 'name'

    if ($conn->query($sql) === TRUE) {
        $_SESSION["name"] = $name; // Changed to 'name'

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Error creating account: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Signup</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<div class="signup-container">
    <h2>Employee Signup</h2>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="name">Employee Name:</label> 
        <input type="text" id="name" name="name" required><br><br> 
        <input type="submit" value="Signup">
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p><br><br>
</div>
</body>
</html>
