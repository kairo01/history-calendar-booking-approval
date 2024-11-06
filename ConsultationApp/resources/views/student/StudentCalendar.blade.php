@extends('layouts.app')

@section('title', 'Student Consultation Calendar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ctcalendar.css') }}">

<h2>Your Consultation Calendar</h2>

<div class="calendar-container">
    <div class="calendar-header">
        <button onclick="changeMonth(-1)">&#10094;</button>
        <h3 id="monthYear"></h3>
        <button onclick="changeMonth(1)">&#10095;</button>
    </div>

    <button id="busyButton">Mark Busy</button>

    <!-- Busy Modal -->
    <div class="modal" id="busyModal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeBusyModal()">&times;</span>
            <h3>Mark as Busy</h3>

            <label for="busyTitle">Title:</label>
            <input type="text" id="busyTitle" required>

            <label for="busyDescription">Description:</label>
            <textarea id="busyDescription" rows="3"></textarea>

            <label for="busyDate">Select Date:</label>
            <input type="date" id="busyDate" required>

            <h4>Select Time Slots:</h4>
            <div>
                <label><input type="checkbox" value="8:00"> 8:00 AM</label><br>
                <label><input type="checkbox" value="9:00"> 9:00 AM</label><br>
                <label><input type="checkbox" value="10:00"> 10:00 AM</label><br>
                <label><input type="checkbox" value="11:00"> 11:00 AM</label><br>
                <label><input type="checkbox" value="12:00" disabled> 12:00 PM (Lunch Break)</label><br>
                <label><input type="checkbox" value="13:00" disabled> 1:00 PM (Lunch Break)</label><br>
                <label><input type="checkbox" value="14:00"> 2:00 PM</label><br>
                <label><input type="checkbox" value="15:00"> 3:00 PM</label><br>
                <label><input type="checkbox" value="16:00"> 4:00 PM</label><br>
                <label><input type="checkbox" value="17:00"> 5:00 PM</label><br>
            </div>

            <button onclick="createBusySlot()">Create</button>
        </div>
    </div>

    <div class="calendar-days" id="calendar-days"></div>
</div>

<script>
    document.getElementById("busyButton").onclick = function() {
        document.getElementById("busyModal").style.display = "block";
    }

    function closeBusyModal() {
        document.getElementById("busyModal").style.display = "none";
    }

    function createBusySlot() {
        const title = document.getElementById("busyTitle").value;
        const description = document.getElementById("busyDescription").value;
        const date = document.getElementById("busyDate").value;

        const selectedTimes = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                                    .map(checkbox => checkbox.value);
        
        fetch("{{ route('busySlot.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                consultation_id: 1, // Replace with actual consultation ID as needed
                title: title,
                description: description,
                date: date,
                busy_times: selectedTimes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeBusyModal(); // Close the modal after creating the busy slot
                renderCalendar(); // Re-render calendar to reflect changes
            }
        })
        .catch(error => console.error("Error:", error));
    }

    // Render your calendar (this part should be your existing calendar rendering logic)
    let currentDate = new Date();

    function renderCalendar() {
        const monthYearDisplay = document.getElementById('monthYear');
        const calendarDays = document.getElementById('calendar-days');

        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();

        monthYearDisplay.innerText = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });

        // Clear previous days
        calendarDays.innerHTML = '';

        // Get the first day of the month and the number of days in the month
        const firstDay = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        // Create blank days for the previous month
        for (let i = 0; i < firstDay; i++) {
            const blankDay = document.createElement('div');
            blankDay.className = 'day blank';
            calendarDays.appendChild(blankDay);
        }

        // Fill in the days of the current month
        for (let day = 1; day <= totalDays; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'day';
            dayElement.innerText = day;
            calendarDays.appendChild(dayElement);
        }
    }

    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        renderCalendar();
    }

    // Initial render
    renderCalendar();
</script>

<style>
    /* Modal styling */
    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        padding: 1em;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content {
        text-align: center;
    }

    .close {
        position: absolute;
        top: 8px;
        right: 8px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-template-rows: auto;
    }

    .day {
        border: 1px solid #e0e0e0;
        padding: 15px;
        text-align: center;
        min-height: 60px;
    }

    .blank {
        border: none; /* No border for blank days */
    }
</style>
@endsection
