
<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $hall_ticket = $_POST['hall_ticket'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Check if hall ticket already exists
    $check = $conn->query("SELECT * FROM students WHERE hall_ticket='$hall_ticket'");
if ($check) {
    if ($check->num_rows > 0) {
        echo "Hall ticket number already registered.";
    } else {
        $sql = "INSERT INTO students (name, hall_ticket, email, password) VALUES ('$name', '$hall_ticket', '$email', '$password')";
        if ($conn->query($sql)) {
            echo "Student registered successfully! <a href='login.php'>Login</a>";
        } else {
            echo "Error: {$conn->error}";
        }
    }
} else {
    echo "Error in SELECT query: {$conn->error}";
    }
}

?>

<h2>Student Registration</h2>
<form method="POST">
    Name: <input type="text" name="name" required><br>
    Hall Ticket: <input type="text" name="hall_ticket" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>
<a href="login.php">Already have an account? Login</a>
<style>
    /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f2f4f7;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* Registration form container */
form {
    background-color: white;
    padding: 35px 40px;
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    max-width: 450px;
    width: 100%;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
    font-size: 28px;
}

/* Labels and inputs */
form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
}

/* Submit button */
form input[type="submit"] {
    width: 100%;
    background-color: #28a745;
    color: white;
    padding: 12px;
    font-size: 17px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #218838;
}

/* Link to login */
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #007bff;
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #0056b3;
}

/* Success/Error message styling */
.success, .error {
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}

.success {
    color: green;
}

.error {
    color: red;
}

/* Responsive */
@media (max-width: 500px) {
    form {
        padding: 25px;
    }

    h2 {
        font-size: 24px;
    }
}

</style>