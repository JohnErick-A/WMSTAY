<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
require "../includes/db_connect.php";

// Pending payments
$pending = $conn->query("
    SELECT p.*, s.full_name
    FROM payments p
    LEFT JOIN students s ON p.student_id = s.id
    WHERE p.status='pending'
    ORDER BY p.created_at ASC
");

// All payments
$all = $conn->query("
    SELECT p.*, s.full_name
    FROM payments p
    LEFT JOIN students s ON p.student_id = s.id
    ORDER BY p.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Payments - WMSTAY</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="app">
    <div class="sidebar">
        <h2 class="brand">WMSTAY Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="bookings.php">Bookings</a>
        <a href="payments.php" class="active">Payments</a>
        <a href="rooms.php">Rooms</a>
        <a href="reports.php">Reports</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="main">

        <h1>Manage Payments</h1>

        <!-- PENDING PAYMENTS -->
        <div class="card">
            <h2>Pending Payments</h2>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $pending->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['full_name']) ?></td>
                            <td><?= $p['amount'] ?></td>
                            <td><?= $p['payment_type'] ?></td>
                            <td><?= ucfirst($p['status']) ?></td>
                            <td><?= $p['created_at'] ?></td>
                            <td>
                                <a class="btn small primary"
                                   href="update_payment.php?id=<?= $p['id'] ?>&action=paid">
                                   Mark as Paid
                                </a>
                                <a class="btn small danger"
                                   href="update_payment.php?id=<?= $p['id'] ?>&action=rejected">
                                   Reject
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ALL PAYMENTS -->
        <div class="card">
            <h2>All Payments</h2>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $all->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['full_name']) ?></td>
                            <td><?= $p['amount'] ?></td>
                            <td><?= $p['payment_type'] ?></td>
                            <td><?= ucfirst($p['status']) ?></td>
                            <td><?= $p['created_at'] ?></td>
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