<?php
session_start();
include "db.php";
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $date = $_POST['date'];
    foreach ($_POST['status'] as $student_id => $status) {
        $conn->query("INSERT INTO attendance (student_id, date, status) VALUES ($student_id, '$date', '$status')");
    }
    echo "<p class='success-msg'>Attendance marked successfully!</p>";
}
?>

<form method="POST">
    <label>Select Date:</label>
    <input type="date" name="date" required><br><br>

    <label><input type="checkbox" id="select_all"> Select All</label><br><br>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM students");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>
                        <label><input type='checkbox' name='status[{$row['id']}]' value='Present'> Present</label>
                        <label><input type='checkbox' name='status[{$row['id']}]' value='Absent'> Absent</label>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table><br>

    <input type="submit" value="Submit Attendance">
</form>
<a href="admin.php">Back to Admin Panel</a>

<script>
    // Script to handle Select All checkbox
    document.getElementById("select_all").addEventListener("change", function() {
        let checkboxes = document.querySelectorAll("input[type='checkbox']");
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById("select_all").checked;
        });
    });
</script>


<style>
  /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
}

/* Form Container */
form {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    width: 100%;
    margin-top: 20px;
}

/* Heading */
form h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

label {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
    display: block;
}

/* Date picker styling */
input[type="date"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ccc;
}

table th {
    background-color: #007bff;
    color: white;
}

table td {
    font-size: 16px;
}

/* Checkboxes for Present/Absent */
input[type="checkbox"] {
    margin: 0 10px;
    cursor: pointer;
}

/* Select All Checkbox */
#select_all {
    margin-right: 10px;
}

/* Submit Button Styling */
input[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Success message styling */
.success-msg {
    color: green;
    font-size: 18px;
    text-align: center;
    margin-top: 20px;
}

/* For mobile responsiveness */
@media (max-width: 600px) {
    form {
        padding: 20px;
    }

    form h2 {
        font-size: 24px;
    }

    input[type="date"],
    input[type="submit"] {
        font-size: 14px;
    }

    table th, table td {
        font-size: 14px;
    }
}
a {
    margin-top: 25px;
    text-decoration: none;
    background-color: #007bff;
    color: white;
    padding: 10px 18px;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    display: inline-block;
    text-align: center;
}

a:hover {
    background-color: #0056b3;
}

</style>
