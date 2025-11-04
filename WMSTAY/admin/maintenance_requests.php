<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_admin()) { header('Location: /WMSTAY/index.php'); exit; }
$title = "Maintenance Requests";
if (isset($_GET['close'])) { $id = (int)$_GET['close']; $pdo->prepare("UPDATE maintenance_requests SET status = 'completed', resolved_date = NOW() WHERE request_id = ?")->execute([$id]); header('Location: maintenance_requests.php'); exit; }
$requests = $pdo->query("SELECT m.*, s.first_name, s.last_name, r.room_number FROM maintenance_requests m LEFT JOIN students s ON s.student_id = m.student_id LEFT JOIN rooms r ON r.room_id = m.room_id ORDER BY m.request_date DESC")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/header.php';
?>
<div class="card"><h3>Maintenance Requests</h3><table class="table"><thead><tr><th>#</th><th>Student</th><th>Room</th><th>Description</th><th>Status</th><th>Action</th></tr></thead><tbody><?php foreach($requests as $req): ?><tr><td><?= $req['request_id'] ?></td><td><?= htmlspecialchars($req['first_name'].' '.$req['last_name']) ?></td><td><?= htmlspecialchars($req['room_number']) ?></td><td><?= htmlspecialchars($req['description']) ?></td><td><?= htmlspecialchars($req['status']) ?></td><td><?php if($req['status'] !== 'completed'): ?><a class="btn small" href="maintenance_requests.php?close=<?= $req['request_id'] ?>">Mark Completed</a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div>
<?php echo '</section></main></div></body></html>'; ?>