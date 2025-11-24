<?php
session_start();
if (!isset($_SESSION['student_id'])) { header("Location: ../login.php"); exit; }
require "../includes/db_connect.php";

$student_id = $_SESSION['student_id'];
$room_id = $_GET['id'];

$conn->query("INSERT INTO bookings (student_id, room_id, status) VALUES ($student_id, $room_id, 'pending')");

echo "<script>alert('Room booked! Waiting for admin approval.');window.location='bookings.php';</script>";
