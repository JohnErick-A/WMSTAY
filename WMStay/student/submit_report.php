<?php
session_start();
if (!isset($_SESSION['student_id'])) { header("Location: ../login.php"); exit; }

require "../includes/db_connect.php";

$title = $_POST['title'];
$description = $_POST['description'];
$student_id = $_SESSION['student_id'];

$stmt = $conn->prepare("INSERT INTO maintenance_reports (student_id, title, description, status) VALUES (?, ?, ?, 'pending')");
$stmt->bind_param("iss", $student_id, $title, $description);
$stmt->execute();

echo "<script>alert('Report submitted');window.location='reports.php';</script>";
