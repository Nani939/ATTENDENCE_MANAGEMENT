<?php
session_start();
include "db.php";

// Redirect if already logged in
if (isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
} elseif (isset($_SESSION['student'])) {
    header("Location: student_dashboard.php");
    exit();
}

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'] ?? '';
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($role === "admin") {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? OR email = ?");
    } elseif ($role === "student") {
        $stmt = $conn->prepare("SELECT * FROM students WHERE hall_ticket = ? OR email = ?");
    } else {
        $login_error = "Invalid role selected.";
        $stmt = false;
    }

    if ($stmt) {
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $password_match = ($role === "admin") ?
                password_verify($password, $user['password']) :
                ($user['password'] === md5($password)); // Use md5 if students are stored like that

            if ($password_match) {
                if ($role === "admin") {
                    $_SESSION['admin'] = $user['username'];
                    header("Location: admin.php");
                } else {
                    $_SESSION['student'] = $user['id']; // Store student id in session
                    header("Location: student_dashboard.php");
                }
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = ucfirst($role) . " not found.";
        }

        $stmt->close();
    } else {
        $login_error = "SQL Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Login</h2>

<?php if ($login_error): ?>
    <p style="color:red;"><?php echo $login_error; ?></p>
<?php endif; ?>

<form method="POST">
    Role:
    <select name="role" required>
        <option value="admin">Admin</option>
        <option value="student">Student</option>
    </select><br><br>

    Username / Hall Ticket / Email:<br>
    <input type="text" name="login" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

<a href="register_admin.php">Register New Admin</a><br>
<a href="register_student.php">Register New Student</a>

</body>
</html>
