<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $hall = $_POST['hall_ticket'];
  $email = $_POST['email'];
  $pass = md5($_POST['password']);
  $role = 'student';

  $stmt = $conn->prepare("INSERT INTO users (name, hall_ticket, email, password, role) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $hall, $email, $pass, $role);

  if ($stmt->execute()) {
    $success = "Registered successfully. You can now login.";
  } else {
    $error = "Error: " . $stmt->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="card-title text-center mb-4">Student Registration</h4>
          <?php
          if (isset($success)) echo "<div class='alert alert-success'>$success</div>";
          if (isset($error)) echo "<div class='alert alert-danger'>$error</div>";
          ?>
          <form method="POST">
            <div class="mb-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Hall Ticket Number</label>
              <input type="text" name="hall_ticket" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
          </form>
          <div class="mt-3 text-center">
            <a href="login.php">Already registered? Login here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
