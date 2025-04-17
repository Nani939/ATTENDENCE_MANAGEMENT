<?php
session_start();
include "db.php";

if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['student'];

$name = $conn->query("SELECT name FROM students WHERE id=$id")->fetch_assoc()['name'];
$total = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE student_id=$id")->fetch_assoc()['total'];
$present = $conn->query("SELECT COUNT(*) as present FROM attendance WHERE student_id=$id AND status='Present'")->fetch_assoc()['present'];

$percent = ($total > 0) ? round(($present / $total) * 100) : 0;
?>

<h2>Welcome, <?php echo $name; ?></h2>
<p>Total Classes: <?php echo $total; ?></p>
<p>Present: <?php echo $present; ?></p>
<p>Attendance %: <?php echo $percent; ?>%</p>

<canvas id="myChart" width="200" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var ctx = document.getElementById("myChart").getContext("2d");
  var chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: ['Present', 'Absent'],
          datasets: [{
              data: [<?php echo $present; ?>, <?php echo $total - $present; ?>],
              backgroundColor: ['green', 'red']
          }]
      }
  });
</script>

<a href="logout.php">Logout</a>
<style>
    /* Reset styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f8;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
    min-height: 100vh;
    color: #333;
}

h2 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #2c3e50;
}

p {
    font-size: 18px;
    margin: 8px 0;
    color: #34495e;
}

canvas {
    margin: 30px 0;
    max-width: 300px;
}

/* Logout Button */
a {
    display: inline-block;
    margin-top: 25px;
    padding: 10px 20px;
    background-color: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #c0392b;
}

/* Responsive */
@media (max-width: 500px) {
    body {
        padding: 20px;
    }

    h2 {
        font-size: 22px;
    }

    p {
        font-size: 16px;
    }

    canvas {
        max-width: 100%;
    }
}

</style>
