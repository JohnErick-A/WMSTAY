<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_student()) { header('Location: /WMSTAY_final/index.php'); exit; }
$title = "Profile";
$studentId = $_SESSION['user']['id']; $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?"); $stmt->execute([$studentId]); $student = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') { $first = $_POST['first_name']; $last = $_POST['last_name']; $contact = $_POST['contact_no']; $pdo->prepare("UPDATE students SET first_name=?, last_name=?, contact_no=? WHERE student_id=?")->execute([$first,$last,$contact,$studentId]); header('Location: profile.php'); exit; }
include '../includes/header.php';
?>
<div class="card"><h3>Your Profile</h3><form method="post" class="form"><div class="form-group"><label>Student Number</label><input value="<?= htmlspecialchars($student['student_number']) ?>" disabled></div><div class="form-group"><label>First</label><input name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>"></div><div class="form-group"><label>Last</label><input name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>"></div><div class="form-group"><label>Contact</label><input name="contact_no" value="<?= htmlspecialchars($student['contact_no']) ?>"></div><div class="form-actions"><button class="btn primary">Save</button></div></form></div>
<?php echo '</section></main></div></body></html>'; ?>