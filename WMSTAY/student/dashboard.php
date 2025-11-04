<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_student()) { header('Location: /WMSTAY_final/index.php'); exit; }
$title = "Student Dashboard";
$studentId = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT ra.*, r.room_number FROM room_assignments ra LEFT JOIN rooms r ON r.room_id = ra.room_id WHERE ra.student_id = ? ORDER BY ra.date_assigned DESC");
$stmt->execute([$studentId]); $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt2 = $pdo->prepare("SELECT * FROM payments WHERE student_id = ? ORDER BY payment_date DESC"); $stmt2->execute([$studentId]); $payments = $stmt2->fetchAll(PDO::FETCH_ASSOC);
include '../includes/header.php';
?>
<div class="card"><h3>Your Room Assignments</h3><?php if(!$assignments): ?><p>No current assignments.</p><?php else: ?><ul class="list"><?php foreach($assignments as $a): ?><li>Room <?= htmlspecialchars($a['room_number']) ?> — Assigned: <?= $a['date_assigned'] ?> <?= $a['active'] ? '(Active)' : '' ?></li><?php endforeach; ?></ul><?php endif; ?></div>
<div class="card"><h3>Payment History</h3><table class="table"><thead><tr><th>#</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody><?php foreach($payments as $p): ?><tr><td><?= $p['payment_id'] ?></td><td><?= number_format($p['amount'],2) ?></td><td><?= htmlspecialchars($p['payment_status']) ?></td><td><?= $p['payment_date'] ?></td></tr><?php endforeach; ?></tbody></table></div>
<?php echo '</section></main></div></body></html>'; ?>