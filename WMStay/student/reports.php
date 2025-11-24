<?php
session_start();
if (!isset($_SESSION['student_id'])) { header("Location: ../login.php"); exit; }
require "../includes/db_connect.php";

$student_id = $_SESSION['student_id'];

$reports = $conn->query("
    SELECT mr.*, r.room_number 
    FROM maintenance_reports mr
    LEFT JOIN rooms r ON mr.room_id = r.id
    WHERE student_id = $student_id
    ORDER BY mr.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report & Maintenance</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app">
    <div class="sidebar">
        <h2 class="brand">WMSTAY</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="bookings.php">My Bookings</a>
        <a href="payments.php">My Payments</a>
        <a href="reports.php" class="active">Report / Maintenance</a>
        <a href="profile.php">Profile</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="main">

        <h1>Submit a Report</h1>

        <form class="card" method="POST" action="submit_report.php">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" required></textarea>
            </div>
            <button class="btn primary">Submit</button>
        </form>

        <h2>My Reports</h2>
        <table class="table">
            <thead><tr><th>Title</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                <?php while($r = $reports->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['title'] ?></td>
                    <td><?= ucfirst($r['status']) ?></td>
                    <td><?= $r['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
