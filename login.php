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
    $name = $_POST["name"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Store user information in the session
            $_SESSION["employee_name"] = $row["employee_name"];
            header("Location:dashboard.php");
            exit();
        } else {
            $error = "Invalid name or password";
        }
    } else {
        $error = "Invalid name or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Employee Login</h2>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="checkbox" id="togglePassword" onclick="togglePasswordVisibility()"> Show Password<br><br>
            <input type="submit" value="Login"><br><br>
            <a href="adminlog.php">Admin Login</a><br><br>
            <a href="signup.php">Don't have an account<br>Signup</a>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleBtn = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleBtn.textContent = "Hide Password";
            } else {
                passwordInput.type = "password";
                toggleBtn.textContent = "Show Password";
           }
        }
    </script>
</body>
</html>