
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manual.css">
    <title>Manual Register</title>
</head>
<body>

<div class="manual-register">
    <h2>Employee Manual Register (Admin)</h2>

    <label for="employeeName">Employee Name:</label>
    <input type="text" id="employeeName" placeholder="Enter Employee Name">

    <button onclick="checkIn()">Check-In</button>
    <button onclick="checkOut()">Check-Out</button>

    <div id="registerLogs">
        <!-- <h3>Register Logs</h3> -->
        <ul id="logsList"></ul>
    </div>
</div>

<script>
function checkIn() {
    const employeeName = document.getElementById("employeeName").value.trim();
    if (employeeName) {
        const checkInTime = new Date().toLocaleString();
        storeCheckInTime(employeeName, checkInTime);
    } else {
        alert("Please enter employee name");
    }
}

function checkOut() {
    const employeeName = document.getElementById("employeeName").value.trim();
    if (employeeName) {
        const checkOutTime = new Date().toLocaleString();
        storeCheckOutTime(employeeName, checkOutTime);
    } else {
        alert("Please enter employee name");
    }
}

function storeCheckInTime(employeeName, checkInTime) {
    fetch('database.php', {
        method: 'POST',
        body: 'action=storeCheckInTime&employeeName=' + encodeURIComponent(employeeName) + '&checkInTime=' + checkInTime
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            addLogEntry(`${employeeName} checked in at ${checkInTime}`);
        } else {
            alert("Checked in sucessfully");
        }
    })
    .catch(error => console.error(error));
}

function storeCheckOutTime(employeeName, checkOutTime) {
    fetch('config.php', {
        method: 'POST',
        body: 'action=storeCheckOutTime&employeeName=' + encodeURIComponent(employeeName) + '&checkOutTime=' + checkOutTime
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            addLogEntry(`${employeeName} checked out at ${checkOutTime}`);
        } else {
            alert("Checked out sucessfully");
        }
    })
    .catch(error => console.error(error));
}

function addLogEntry(log) {
    const logsList = document.getElementById("logsList");
    const li = document.createElement("li");
    li.textContent = log;
    logsList.appendChild(li);
}
</script>
</body>
</html>

