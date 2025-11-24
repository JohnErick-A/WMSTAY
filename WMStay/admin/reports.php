<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
require "../includes/db_connect.php";

$reports = $conn->query("
    SELECT mr.*, s.full_name, r.room_number
    FROM maintenance_reports mr
    LEFT JOIN students s ON mr.student_id = s.id
    LEFT JOIN rooms r ON mr.room_id = r.id
    ORDER BY mr.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Reports - WMSTAY</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="app">
    <div class="sidebar">
        <h2 class="brand">WMSTAY Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="bookings.php">Bookings</a>
        <a href="payments.php">Payments</a>
        <a href="rooms.php">Rooms</a>
        <a href="reports.php" class="active">Reports</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="main">
        <h1>Reports & Maintenance</h1>

        <div class="card">
            <h2>All Reports</h2>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Room</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($r = $reports->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['full_name']) ?></td>
                            <td><?= htmlspecialchars($r['room_number']) ?></td>
                            <td><?= htmlspecialchars($r['title']) ?></td>
                            <td><?= ucfirst($r['status']) ?></td>
                            <td><?= $r['created_at'] ?></td>
                            <td><?= $r['updated_at'] ?></td>
                            <td>
                                <a class="btn small"
                                   href="update_report.php?id=<?= $r['id'] ?>&status=pending">
                                   Pending
                                </a>
                                <a class="btn small primary"
                                   href="update_report.php?id=<?= $r['id'] ?>&status=in-progress">
                                   In-Progress
                                </a>
                                <a class="btn small success"
                                   href="update_report.php?id=<?= $r['id'] ?>&status=resolved">
                                   Resolved
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
</body>
</html>
