<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="logs.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <table>
        <thead>
            <tr>
                <td>Employee Name</td>
                <td>Check-in Time</td>
                <td>Check-out Time</td>
                <td>Hours Worked</td>
            </tr>
        </thead>
        <tbody>
        <?php
            require_once 'config.php';

            $sql = "SELECT employee_name, check_in_time, check_out_time, hours_worked FROM employee_records";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . ($row['employee_name']? $row['employee_name'] : "no result") . "</td>";
                    echo "<td>" . $row['check_in_time'] . "</td>";
                    echo "<td>" . ($row['check_out_time'] ? $row['check_out_time'] : 'Not checked out') . "</td>";
                    echo "<td>" . ($row['hours_worked'] ? $row['hours_worked'] : '-') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>