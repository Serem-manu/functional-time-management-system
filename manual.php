<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manual.css">
    <title>Manual Register</title>
    <style>
        
  </style>
</head>
<body>
    <div class="manual-register">
        <h2>Employee Manual Register (Admin)</h2>
        <table id="employeeTable">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        window.onload = fetchEmployees;
        const employeeStatus = {};

        function fetchEmployees() {
            fetch('database.php?action=getEmployees')
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        const employeeTable = document.getElementById("employeeTable").getElementsByTagName('tbody')[0];
                        data.employees.forEach(employee => {
                            const row = employeeTable.insertRow();
                            const nameCell = row.insertCell(0);
                            const checkInCell = row.insertCell(1);
                            const checkOutCell = row.insertCell(2);

                            nameCell.textContent = employee.name;
                            const checkInButton = document.createElement("button");
                            checkInButton.textContent = "Check-In";
                            checkInButton.onclick = () => checkIn(employee.name, checkInButton, checkOutCell.firstChild);
                            checkInCell.appendChild(checkInButton);

                            const checkOutButton = document.createElement("button");
                            checkOutButton.textContent = "Check-Out";
                            checkOutButton.disabled = true;
                            checkOutButton.onclick = () => checkOut(employee.name, checkOutButton, checkInCell.firstChild);
                            checkOutCell.appendChild(checkOutButton);

                            employeeStatus[employee.name] = {
                                checkedIn: false,
                                checkInButton: checkInButton,
                                checkOutButton: checkOutButton
                            };
                        });
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error(error));
        }

        function checkIn(employeeName, checkInButton, checkOutButton) {
            if (!employeeStatus[employeeName].checkedIn) {
                const checkInTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
                storeCheckInTime(employeeName, checkInTime);
                employeeStatus[employeeName].checkedIn = true;
                checkInButton.disabled = true;
                checkOutButton.disabled = false;
            }
        }

        function checkOut(employeeName, checkOutButton, checkInButton) {
            if (employeeStatus[employeeName].checkedIn) {
                const checkOutTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
                storeCheckOutTime(employeeName, checkOutTime);
                employeeStatus[employeeName].checkedIn = false;
                checkOutButton.disabled = true;
                checkInButton.disabled = false;
            }
        }

        function storeCheckInTime(employeeName, checkInTime) {
            const formData = new FormData();
            formData.append('action', 'storeCheckInTime');
            formData.append('employeeName', employeeName);
            formData.append('checkInTime', checkInTime);

            fetch('database.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error(error));
        }

        function storeCheckOutTime(employeeName, checkOutTime) {
            const formData = new FormData();
            formData.append('action', 'storeCheckOutTime');
            formData.append('employeeName', employeeName);
            formData.append('checkOutTime', checkOutTime);

            fetch('database.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error(error));
        }
    </script>
</body>
</html>