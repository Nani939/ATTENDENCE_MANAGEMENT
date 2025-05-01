<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit();
}

$subject = $_SESSION['subject'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $date = $_POST['date'];
  $today = date('Y-m-d');

  if ($date != $today) {
    $error = "You can only mark attendance for today's date: $today.";
  } else {
    foreach ($_POST['status'] as $student_id => $status) {
      $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status, subject) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("isss", $student_id, $date, $status, $subject);
      $stmt->execute();
    }
    $success = "Attendance marked successfully for subject: $subject.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mark Attendance</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-center mb-4">Mark Attendance (<?php echo $subject; ?>)</h2>

  <?php
    if (isset($success)) echo "<div class='alert alert-success'>$success</div>";
    if (isset($error)) echo "<div class='alert alert-danger'>$error</div>";
  ?>

  <form method="POST" class="card p-4 shadow">
    <div class="mb-3">
      <label>Today's Date</label>
      <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly required>
    </div>

    <div class="mb-3">
      <label><strong>Student List</strong></label>
      <?php
      $students = $conn->query("SELECT * FROM users WHERE role='student'");
      while ($row = $students->fetch_assoc()) {
        echo "<div class='mb-2'>{$row['name']} ({$row['hall_ticket']})
          <select name='status[{$row['id']}]' class='form-select w-50 d-inline-block ms-2'>
            <option value='Present'>Present</option>
            <option value='Absent'>Absent</option>
          </select></div>";
      }
      ?>
    </div>

    <button type="submit" class="btn btn-primary">Submit Attendance</button>
    <a href="dashboard.php" class="btn btn-secondary ms-2">Back</a>
  </form>
</div>
</body>
</html>
