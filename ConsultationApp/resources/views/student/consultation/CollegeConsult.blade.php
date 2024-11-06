@extends('layouts.app')

@section('title', 'Consultation Form')

@section('content')
<link rel="stylesheet" href="{{ asset('css/collegeconsult.css') }}">

<!-- Success Modal -->
<div class="modal" id="successModal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p id="modalMessage">Consultation request successfully submitted!</p>
    </div>
</div>

<form id="consultationForm">
    @csrf
    <label for="name">NAME:</label>
    <input type="text" name="name" required>

    <label for="course">COURSE/GRADE LEVEL/SECTION:</label>
    <select name="course" required>
        <option value="BSIT/1STYEAR/101">BSIT/1STYEAR/101</option>
        <option value="BSIT/2NDYEAR/201">BSIT/2NDYEAR/201</option>
        <option value="BSIT/3RDYEAR/301">BSIT/3RDYEAR/301</option>
        <option value="BSIT/4THYEAR/401">BSIT/4THYEAR/401</option>
    </select>

    <label for="purpose">PURPOSE OF CONSULTATION:</label>
    <select name="purpose" required>
        <option value="transfer">TRANSFER</option>
        <option value="return_class">RETURN TO CLASS - ACADEMIC</option>
        <option value="graduating">GRADUATING STUDENTS</option>
        <option value="personal">PERSONAL</option>
    </select>

    <label for="consultant">SELECT CONSULTANT:</label>
    <select name="consultant" required>
        <option value="department_head">DEPARTMENT HEAD</option>
        <option value="admin_consultant">ADMIN CONSULTANT</option>
    </select>

    <label for="meeting_mode">SELECT MEETING MODE:</label>
    <select name="meeting_mode" id="meeting_mode" required onchange="toggleOnlineOptions()">
        <option value="face_to_face">FACE TO FACE</option>
        <option value="online">ONLINE</option>
    </select>

    <div id="onlineOptions" style="display:none;">
        <label for="online_platform">IF ONLINE, CHOOSE VIA MEETING PREFERENCE:</label>
        <select name="online_platform">
            <option value="google_meet">GOOGLE MEET</option>
            <option value="messenger">MESSENGER</option>
        </select>
    </div>

    <label for="schedule_date">SELECT DATE:</label>
    <input type="date" name="schedule_date" required>

    <label for="schedule_time">SELECT TIME:</label>
    <input type="time" name="schedule_time" required>

    <button type="submit">CONFIRM APPOINTMENT</button>
</form>

<script>
    document.getElementById("consultationForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);
        fetch("{{ route('consultation.submit') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("modalMessage").innerText = data.message; // Set modal message
                document.getElementById("successModal").style.display = "block"; // Show success modal

                // Automatically close the modal after 3.5 seconds
                setTimeout(() => {
                    closeModal();
                    document.getElementById("consultationForm").reset(); // Clear the form fields
                }, 3500);
            }
        })
        .catch(error => console.error("Error:", error));
    });

    function closeModal() {
        document.getElementById("successModal").style.display = "none";
    }

    function toggleOnlineOptions() {
        var mode = document.getElementById("meeting_mode").value;
        document.getElementById("onlineOptions").style.display = mode === "online" ? "block" : "none";
    }
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
        position: relative;
    }

    .close {
        position: absolute;
        top: 8px;
        right: 8px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
    }
</style>
@endsection
