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
    

    <script>
        document.getElementById("checkInBtn").addEventListener("click", function() {
            if (confirm("Are you sure you want to check in?")) {
                sendActionToServer('checkIn');
            }
        });

        document.getElementById("checkOutBtn").addEventListener("click", function() {
            if (confirm("Are you sure you want to check out?")) {
                sendActionToServer('checkOut');
            }
        });

        function sendActionToServer(action) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "functions.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
  if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                
                    if (action === 'checkIn') {
                        document.getElementById('checkInBtn').disabled = true;
                        document.getElementById('checkOutBtn').disabled = false;
                    } else if (action === 'checkOut') {
                        document.getElementById('checkOutBtn').disabled = true;
                        document.getElementById('checkInBtn').disabled = false;
                    }
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            } else {
                alert('Error occurred while processing the request.');
            }
        }
    };
    xhr.send("action=" + action);
}


    </script>
</body>
</html>
