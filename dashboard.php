<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="text-center mb-4">
    <h2>Welcome to the Dashboard</h2>
    <p>Logged in as <strong><?php echo ucfirst($role); ?></strong></p>
  </div>
  <div class="d-flex justify-content-center gap-3">
    <?php if ($role == 'admin'): ?>
      <a href="mark_attendance.php" class="btn btn-primary">Mark Attendance</a>
      <a href="view_attendance.php" class="btn btn-info">View Student Attendance</a>
    <?php else: ?>
      <a href="student_attendance.php" class="btn btn-success">View My Attendance</a>
    <?php endif; ?>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>
</body>
</html>
