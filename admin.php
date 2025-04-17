<?php
session_start();
include "db.php";
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Total students
$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];

// Total attendance records
$total_records = $conn->query("SELECT COUNT(*) as count FROM attendance")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        <p>Total Students: <?php echo $total_students; ?></p>
        <p>Total Attendance Records: <?php echo $total_records; ?></p>

        <ul>
            <li><a href="mark_attendance.php">Mark Attendance</a></li>
            <li><a href="view_attendence.php">View Attendance</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
<style>
    /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body background and typography */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

/* Dashboard container */
.dashboard-container {
    width: 90%;
    max-width: 600px;
    background-color: #ffffff;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Heading */
.dashboard-container h2 {
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 30px;
}

/* Stats section */
.stats {
    margin-bottom: 30px;
}

.stats p {
    font-size: 18px;
    color: #34495e;
    margin: 10px 0;
}

/* Navigation menu */
ul {
    list-style: none;
    padding: 0;
}

li {
    margin: 15px 0;
}

/* Links */
a {
    text-decoration: none;
    color: #007bff;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.3s ease;
}

a:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Responsive tweak */
@media (max-width: 500px) {
    .dashboard-container {s
        padding: 30px 20px;
    }

    .dashboard-container h2 {
        font-size: 24px;
    }

    .stats p,
    a {
        font-size: 16px;
    }
}

</style>