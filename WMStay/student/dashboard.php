<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: /wmstay/login.php");
    exit;
}

require "../includes/db_connect.php";

$student_id = $_SESSION['student_id'];

// Student info
$student = $conn->query("SELECT * FROM students WHERE id = $student_id")->fetch_assoc();

// Latest booking
$room = $conn->query("
    SELECT b.status, r.room_number, r.room_type
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
    WHERE b.student_id = $student_id
    ORDER BY b.id DESC
    LIMIT 1
")->fetch_assoc();

// Payments
$payments = $conn->query("
    SELECT * FROM payments
    WHERE student_id = $student_id
    ORDER BY created_at DESC
");

// login success banner
$showSuccess = isset($_GET['login']) && $_GET['login'] === 'success';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard - WMSTAY</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
</head>
<body>
<div class="app">

    <div class="sidebar">
        <h2 class="brand">WMSTAY</h2>
        <a href="/wmstay/student/dashboard.php" class="active">Dashboard</a>
        <a href="/wmstay/student/bookings.php">My Bookings</a>
        <a href="/wmstay/student/payments.php">My Payments</a>
        <a href="/wmstay/student/reports.php">Report / Maintenance</a>
        <a href="/wmstay/student/profile.php">Profile</a>
        <a href="/wmstay/logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="page-header">
            <h1 class="page-title">Student Dashboard</h1>
            <button id="menuToggle" class="btn small">☰</button>
        </div>

        <?php if ($showSuccess): ?>
            <div class="alert-success">Login successful</div>
        <?php endif; ?>

        <div class="info-grid">
            <!-- My Information -->
            <div class="card">
                <div class="info-title">
                    <span class="icon">👤</span>
                    <span>My Information</span>
                </div>
                <p><b>Name:</b> <?= htmlspecialchars($student['full_name']) ?></p>
                <p><b>Email:</b> <?= htmlspecialchars($student['email']) ?></p>
                <p><b>Department:</b> <?= htmlspecialchars($student['department']) ?></p>
                <p><b>Program:</b> <?= htmlspecialchars($student['program']) ?></p>
                <p><b>Contact:</b> <?= htmlspecialchars($student['contact']) ?></p>
                <p><b>Address:</b> <?= htmlspecialchars($student['address']) ?></p>
            </div>

            <!-- My Room -->
            <div class="card">
                <div class="info-title">
                    <span class="icon">🛏️</span>
                    <span>My Room</span>
                </div>
                <?php if ($room): ?>
                    <?php if ($room['status'] === 'approved'): ?>
                        <p><b>Room:</b> <?= htmlspecialchars($room['room_number']) ?></p>
                        <p><b>Type:</b> <?= htmlspecialchars($room['room_type']) ?></p>
                        <p><b>Status:</b> Approved</p>
                    <?php elseif ($room['status'] === 'pending'): ?>
                        <p>Your room booking is <b>pending</b> approval.</p>
                    <?php elseif ($room['status'] === 'rejected'): ?>
                        <p>Your last booking was <b>rejected</b>.</p>
                        <a class="btn primary" href="/wmstay/student/bookings.php">Book Again</a>
                    <?php endif; ?>
                <?php else: ?>
                    <p>You don't have an approved room booking yet.</p>
                    <a class="btn primary" href="/wmstay/student/bookings.php">Book Now</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="card">
            <h2>Recent Payments</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p = $payments->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['amount']) ?></td>
                        <td><?= htmlspecialchars($p['payment_type']) ?></td>
                        <td><?= ucfirst($p['status']) ?></td>
                        <td><?= htmlspecialchars($p['created_at']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
</html>
