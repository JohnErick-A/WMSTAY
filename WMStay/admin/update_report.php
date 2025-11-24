<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
require "../includes/db_connect.php";

if (!isset($_GET['id'], $_GET['status'])) {
    header("Location: reports.php");
    exit;
}

$id = (int)$_GET['id'];
$status = $_GET['status'];

$allowed = ['pending','in-progress','resolved'];
if (!in_array($status, $allowed, true)) {
    header("Location: reports.php");
    exit;
}

$stmt = $conn->prepare("UPDATE maintenance_reports SET status=?, updated_at=NOW() WHERE id=?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

echo "<script>alert('Report updated to $status');window.location='reports.php';</script>";