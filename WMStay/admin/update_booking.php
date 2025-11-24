<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
require "../includes/db_connect.php";

if (!isset($_GET['id'], $_GET['action'])) {
    header("Location: bookings.php");
    exit;
}

$id = (int)$_GET['id'];
$action = $_GET['action'];

$status = 'pending';
if ($action === 'approve') {
    $status = 'approved';
} elseif ($action === 'reject') {
    $status = 'rejected';
}

// Get room id for capacity handling (simple: mark room not available if approved)
$booking = $conn->query("SELECT * FROM bookings WHERE id=$id")->fetch_assoc();
if (!$booking) {
    header("Location: bookings.php");
    exit;
}

$room_id = (int)$booking['room_id'];

$stmt = $conn->prepare("UPDATE bookings SET status=?, updated_at=NOW() WHERE id=?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

if ($status === 'approved') {
    // Simple behaviour: mark room as not available
    $conn->query("UPDATE rooms SET status='not available' WHERE id=$room_id");
}

echo "<script>alert('Booking updated to $status');window.location='bookings.php';</script>";
