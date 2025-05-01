<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit();
}

$subject = $_SESSION['subject'];
$students = $conn->query("SELECT * FROM users WHERE role='student'");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Attendance - <?php echo $subject; ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-center mb-4">Attendance Overview for <?php echo $subject; ?></h2>
  <div class="row">
    <?php while ($stu = $students->fetch_assoc()):
      $sid = $stu['id'];
      $total = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE student_id=$sid AND subject='$subject'")->fetch_assoc()['total'];
      $present = $conn->query("SELECT COUNT(*) AS present FROM attendance WHERE student_id=$sid AND status='Present' AND subject='$subject'")->fetch_assoc()['present'];
      $percent = ($total > 0) ? round(($present / $total) * 100) : 0;
    ?>
    <div class="col-md-6 mb-4">
      <div class="card shadow p-3">
        <h5><?php echo $stu['name']; ?> (<?php echo $stu['hall_ticket']; ?>)</h5>
        <canvas id="chart_<?php echo $sid; ?>" height="120"></canvas>
        <p class="mt-2">Present: <?php echo $present; ?> / <?php echo $total; ?> (<?php echo $percent; ?>%)</p>
      </div>
    </div>
    <script>
      const ctx<?php echo $sid; ?> = document.getElementById("chart_<?php echo $sid; ?>").getContext("2d");
      new Chart(ctx<?php echo $sid; ?>, {
        type: 'bar',
        data: {
          labels: ['Present', 'Absent'],
          datasets: [{
            label: 'Attendance',
            data: [<?php echo $present; ?>, <?php echo ($total - $present); ?>],
            backgroundColor: ['#28a745', '#dc3545']
          }]
        },
        options: {
          plugins: {
            legend: { display: false },
            title: { display: true, text: 'Attendance Chart' }
          },
          scales: {
            y: { beginAtZero: true, max: <?php echo $total ?: 1; ?> }
          }
        }
      });
    </script>
    <?php endwhile; ?>
  </div>
  <div class="text-center mt-3">
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>
</div>
</body>
</html>
