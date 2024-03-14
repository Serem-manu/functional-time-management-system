document.addEventListener('DOMContentLoaded', function() {
    const checkInBtn = document.getElementById('checkInBtn');
    const checkOutBtn = document.getElementById('checkOutBtn');

    let isCheckedIn = false;

    checkInBtn.addEventListener('click', function() {
        if (!isCheckedIn) {
            const confirmCheckIn = confirm('Are you sure you want to check in?');
            if (confirmCheckIn) {
                checkIn();
                isCheckedIn = true;
                checkInBtn.disabled = true;
                checkOutBtn.disabled = false;
            }
        }
    });

    checkOutBtn.addEventListener('click', function() {
        if (isCheckedIn) {
            const confirmCheckOut = confirm('Are you sure you want to check out?');
            if (confirmCheckOut) {
                checkOut();
                isCheckedIn = false;
                checkInBtn.disabled = false;
                checkOutBtn.disabled = true;
            }
        }
    });

    function checkIn() {
        // Send an AJAX request to the server to record the check-in time
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'functions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send('action=checkIn');
    }

    function checkOut() {
        // Send an AJAX request to the server to record the check-out time
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'functions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send('action=checkOut');
    }
});