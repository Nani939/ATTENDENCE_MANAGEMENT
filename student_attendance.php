<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'student') {
  header("Location: login.php");
  exit();
}

$id = $_SESSION['user_id'];

// Overview per subject
$overview = $conn->query("SELECT subject, COUNT(*) AS total, SUM(status='Present') AS present 
                          FROM attendance 
                          WHERE student_id=$id 
                          GROUP BY subject");

// Attendance history
$history = $conn->query("SELECT * FROM attendance 
                         WHERE student_id=$id 
                         ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Attendance</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-center mb-4">My Attendance Overview</h2>

  <div class="row mb-4">
    <?php while ($row = $overview->fetch_assoc()): 
      $sub = $row['subject'];
      $present = $row['present'];
      $total = $row['total'];
      $absent = $total - $present;
      $percent = ($total > 0) ? round(($present / $total) * 100) : 0;
    ?>
    <div class="col-md-6 mb-3">
      <div class="card shadow p-3">
        <h5><?php echo $sub; ?> (<?php echo $percent; ?>%)</h5>
        <canvas id="chart_<?php echo $sub; ?>" height="120"></canvas>
        <script>
          new Chart(document.getElementById("chart_<?php echo $sub; ?>").getContext("2d"), {
            type: 'doughnut',
            data: {
              labels: ['Present', 'Absent'],
              datasets: [{
                data: [<?php echo $present; ?>, <?php echo $absent; ?>],
                backgroundColor: ['#198754', '#dc3545']
              }]
            },
            options: {
              plugins: {
                title: {
                  display: true,
                  text: 'Attendance - <?php echo $sub; ?>'
                }
              }
            }
          });
        </script>
        <p class="mt-2">Present: <?php echo $present; ?> / <?php echo $total; ?></p>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

  <h4 class="text-center">Attendance History</h4>
  <table class="table table-bordered table-striped mt-3">
    <thead class="table-secondary">
      <tr>
        <th>Date</th>
        <th>Subject</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $history->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['subject']; ?></td>
        <td>
          <span class="badge bg-<?php echo $row['status'] == 'Present' ? 'success' : 'danger'; ?>">
            <?php echo $row['status']; ?>
          </span>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="text-center">
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>
</div>
</body>
</html>
