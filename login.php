<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM users WHERE email=? AND password=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['subject'] = $user['subject'];
    header("Location: dashboard.php");
  } else {
    $error = "Invalid login credentials.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="card-title text-center mb-4">Login</h4>
          <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <form method="POST">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <div class="mt-3 text-center">
            <a href="register.php">New student? Register here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
