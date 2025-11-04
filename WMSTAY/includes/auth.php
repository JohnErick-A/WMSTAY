<?php
session_start();
function is_logged_in() { return isset($_SESSION['user']); }
function require_login() { if (!is_logged_in()) { header('Location: /WMSTAY/index.php'); exit; } }
function is_admin() { return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'; }
function is_student() { return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student'; }
?>