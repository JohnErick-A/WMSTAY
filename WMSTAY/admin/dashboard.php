<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_admin()) { header('Location: /WMSTAY/index.php'); exit; }
$title = "Admin Dashboard";
include '../includes/header.php';
$total_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$total_rooms = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$occupied = $pdo->query("SELECT COUNT(*) FROM room_assignments WHERE active = 1")->fetchColumn();
$payments = $pdo->query("SELECT p.*, s.first_name, s.last_name FROM payments p LEFT JOIN students s ON s.student_id = p.student_id ORDER BY p.payment_date DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="grid">
  <div class="card stat"><h3>Total Students</h3><p class="stat-number"><?= $total_students ?></p></div>
  <div class="card stat"><h3>Total Rooms</h3><p class="stat-number"><?= $total_rooms ?></p></div>
  <div class="card stat"><h3>Current Occupants</h3><p class="stat-number"><?= $occupied ?></p></div>
</div>
<div class="card"><h3>Recent Payments</h3><table class="table"><thead><tr><th>#</th><th>Student</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody><?php foreach($payments as $p): ?><tr><td><?= $p['payment_id'] ?></td><td><?= htmlspecialchars($p['first_name'].' '.$p['last_name']) ?></td><td><?= number_format($p['amount'],2) ?></td><td><?= htmlspecialchars($p['payment_status']) ?></td><td><?= $p['payment_date'] ?></td></tr><?php endforeach; ?></tbody></table></div>
<?php echo '</section></main></div></body></html>'; ?>