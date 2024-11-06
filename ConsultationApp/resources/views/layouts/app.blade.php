<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Consultation Management System')</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css">
</head>
<body>
    <!-- Header -->
<header class="header">
    <div class="container">
        <h1 class="logo">Consultation Management</h1>
        <nav class="nav">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('college.consultation') }}">College Consultation</a></li>
                <li><a href="{{ route('highschool.consultation') }}">High School Consultation</a></li>
                <li><a href="{{ route('admin.calendar') }}">Admin Calendar</a></li>
                <li><a href="{{ route('dp.calendar') }}">Department Head Calendar</a></li>
                <li><a href="{{ route('student.calendar') }}">Student Calendar</a></li>

                <!-- Approval Links -->
                <li><a href="{{ route('dpHead.approval', ['id' => 1]) }}">Department Head Approval</a></li>
                <li><a href="{{ route('adminCtation.approval', ['id' => 1]) }}">Admin Consultant Approval</a></li>


                <!-- History Links for Admin, Department Head, and Student -->
                <li><a href="{{ route('admin.history') }}">Admin Consultation History</a></li>
                <li><a href="{{ route('dp.history') }}">Department Head History</a></li>
                <li><a href="{{ route('student.history') }}">Student Consultation History</a></li>
            </ul>
        </nav>
    </div>
</header>


    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Consultation Management System. All rights reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    @yield('scripts')
</body>
</html>
