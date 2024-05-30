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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $name = $_POST["name"]; 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (password, name) VALUES ('$hashedPassword', '$name')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["name"] = $name; 

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
        <label for="name">Employee Name:</label> 
        <input type="text" id="name" name="name" required><br><br> 
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Signup">
    </form>
</div>
</body>
</html>
