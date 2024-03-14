// const employees = [
//     { id: 'E001', password: 'passE001' },
//     { id: 'E002', password: 'passE002' }
// ];

   
//     const data = [
//         { id: 1, loginTime: '2024-02-21 09:00:00', logoutTime: '2024-02-21 17:00:00' },
//         { id: 2, loginTime: '2024-02-21 10:00:00', logoutTime: '2024-02-21 18:30:00' },
//         // Add more employee data as needed
//     ];

//     const table = document.getElementById('employeeTable');
//     table.innerHTML = "<tr><th>Employee ID</th><th>Login Time</th><th>Logout Time</th><th>Hours Worked</th></tr>";

//     data.forEach(employee => {
//         const loginTime = new Date(employee.loginTime);
//         const logoutTime = new Date(employee.logoutTime);
//         const hoursWorked = ((logoutTime - loginTime) / (1000 * 60 * 60)).toFixed(2);

//         const row = table.insertRow(-1);
//         const cell1 = row.insertCell(0);
//         const cell2 = row.insertCell(1);
//         const cell3 = row.insertCell(2);
//         const cell4 = row.insertCell(3);

//         cell1.textContent = employee.id;
//         cell2.textContent = employee.loginTime;
//         cell3.textContent = employee.logoutTime;
//         cell4.textContent = hoursWorked;
//     });
function generateUserLogs() {
    const employeeTable = document.getElementById('employeeTable');
  
    // Clear any existing rows
    while (employeeTable.rows.length > 1) {
      employeeTable.deleteRow(1);
    }
  
    // Iterate through local storage keys
    for (let i = 0; i < localStorage.length; i++) {
      const key = localStorage.key(i);
  
      // Check if the key starts with 'employee-'
      if (key.startsWith('employee-')) {
        const employeeId = key.split('-')[1];
        const checkInTime = localStorage.getItem(`employee-${employeeId}-checkIn`);
        const checkOutTime = localStorage.getItem(`employee-${employeeId}-checkOut`);
  
        // Calculate the hours worked (assuming check-out time is available)
        let hoursWorked = 'N/A';
        if (checkOutTime) {
          const checkIn = new Date(checkInTime);
          const checkOut = new Date(checkOutTime);
          const hoursDiff = Math.abs(checkOut - checkIn) / 36e5; // Convert milliseconds to hours
          hoursWorked = hoursDiff.toFixed(2); // Round to 2 decimal places
        }
  
        // Create a new row in the table
        const newRow = employeeTable.insertRow();
        newRow.insertCell().textContent = employeeId;
        newRow.insertCell().textContent = checkInTime || 'N/A';
        newRow.insertCell().textContent = checkOutTime || 'N/A';
        newRow.insertCell().textContent = hoursWorked;
      }
    }
  }