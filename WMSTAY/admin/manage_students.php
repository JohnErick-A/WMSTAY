<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_admin()) { header('Location: /WMSTAY/index.php'); exit; }
$title = "Manage Students";
if (isset($_GET['delete'])) { $id = (int)$_GET['delete']; $pdo->prepare("DELETE FROM students WHERE student_id = ?")->execute([$id]); header('Location: manage_students.php'); exit; }
$students = $pdo->query("SELECT * FROM students ORDER BY last_name")->fetchAll(PDO::FETCH_ASSOC); include '../includes/header.php';
?>
<div class="card"><h3>Students</h3><table class="table"><thead><tr><th>#</th><th>Student No</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead><tbody><?php foreach($students as $s): ?><tr><td><?= $s['student_id'] ?></td><td><?= htmlspecialchars($s['student_number']) ?></td><td><?= htmlspecialchars($s['first_name'].' '.$s['last_name']) ?></td><td><?= htmlspecialchars($s['email']) ?></td><td><a class="btn small" href="manage_students.php?delete=<?= $s['student_id'] ?>" onclick="return confirm('Delete student?')">Delete</a></td></tr><?php endforeach; ?></tbody></table></div>
<?php echo '</section></main></div></body></html>'; ?>