<?php
session_start();
include "db.php";
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$students = $conn->query("SELECT * FROM students");
?>

<h2>All Students Attendance</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>Hall Ticket</th>
        <th>Name</th>
        <th>Total Classes</th>
        <th>Present</th>
        <th>Percentage</th>
    </tr>

    <?php
    while ($row = $students->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $htno = $row['hall_ticket'];

        $total = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE student_id=$id")->fetch_assoc()['total'];
        $present = $conn->query("SELECT COUNT(*) as present FROM attendance WHERE student_id=$id AND status='Present'")->fetch_assoc()['present'];
        $percent = ($total > 0) ? round(($present / $total) * 100) : 0;

        echo "<tr>
                <td>$htno</td>
                <td>$name</td>
                <td>$total</td>
                <td>$present</td>
                <td>$percent%</td>
              </tr>";
    }
    ?>
</table>


<a href="admin.php">Back to Admin Panel</a>
<style>
/* Reset default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f2f4f7;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Heading */
h2 {
    color: #333;
    margin-bottom: 30px;
    font-size: 28px;
}

/* Table styling */
table {
    width: 90%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

table th, table td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #007bff;
    color: white;
    font-weight: 600;
}

table tr:hover {
    background-color: #f1f1f1;
}

table td {
    font-size: 16px;
    color: #444;
}

/* Back link */
a {
    margin-top: 25px;
    text-decoration: none;
    background-color: #007bff;
    color: white;
    padding: 10px 18px;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #0056b3;
}

/* Responsive design */
@media (max-width: 768px) {
    table, table th, table td {
        font-size: 14px;
    }

    h2 {
        font-size: 24px;
    }

    a {
        font-size: 14px;
        padding: 8px 14px;
    }
}

</style>
