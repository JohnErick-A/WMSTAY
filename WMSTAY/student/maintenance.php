<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_student()) { header('Location: /WMSTAY_final/index.php'); exit; }
$title = "Submit Maintenance Request";
$studentId = $_SESSION['user']['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') { $room_id = $_POST['room_id'] ?: null; $desc = $_POST['description']; $ins = $pdo->prepare("INSERT INTO maintenance_requests (student_id, room_id, description, status) VALUES (?,?,?, 'pending')"); $ins->execute([$studentId, $room_id, $desc]); $msg = "Request submitted."; }
$roomsStmt = $pdo->prepare("SELECT r.room_id, r.room_number FROM rooms r JOIN room_assignments ra ON ra.room_id = r.room_id WHERE ra.student_id = ? AND ra.active = 1"); $roomsStmt->execute([$studentId]); $rooms = $roomsStmt->fetchAll(PDO::FETCH_ASSOC);
include '../includes/header.php';
?>
<div class="card"><h3>New Maintenance Request</h3><?php if(!empty($msg)): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="post"><div class="form-group"><label>Room (if applicable)</label><select name="room_id"><option value="">-- select --</option><?php foreach($rooms as $r): ?><option value="<?= $r['room_id'] ?>"><?= htmlspecialchars($r['room_number']) ?></option><?php endforeach; ?></select></div><div class="form-group"><label>Description</label><textarea name="description" required></textarea></div><div class="form-actions"><button class="btn primary">Submit Request</button></div></form></div>
<?php echo '</section></main></div></body></html>'; ?>