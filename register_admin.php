<?php
include "db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? OR email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or Email already taken.";
    } else {
        // Insert new admin with email
        $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            // Optional: Flash message using session
            $_SESSION['success'] = "Admin added successfully! Please log in.";
            header("Location: login.php");
            exit();
         } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<h2>Add New Admin</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Add Admin">
</form>
<a href="admin.php">Back to Dashboard</a>

<style>
    /* General Reset *//* Reset & base setup */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #eef2f7;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Form container */
form {
    background-color: #fff;
    padding: 35px 45px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    max-width: 450px;
    width: 100%;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 26px;
    color: #333;
}

/* Input fields */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    background-color: #fdfdfd;
}

input[type="submit"] {
    width: 100%;
    background-color: #0066cc;
    color: #fff;
    border: none;
    padding: 12px;
    margin-top: 15px;
    font-size: 17px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #004d99;
}

/* Dashboard link */
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

a:hover {
    color: #0056b3;
}

/* Responsive */
@media (max-width: 500px) {
    form {
        padding: 25px;
    }

    h2 {
        font-size: 22px;
    }
}
</style>