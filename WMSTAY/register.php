<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';
$title = "Register";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number = trim($_POST['student_number']);
    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $chk = $pdo->prepare("SELECT COUNT(*) FROM students WHERE student_number = ? OR email = ?");
    $chk->execute([$student_number, $email]);
    if ($chk->fetchColumn() > 0) { $error = "Student number or email already exists."; }
    else { $ins = $pdo->prepare("INSERT INTO students (student_number,password_hash,first_name,last_name,email) VALUES (?,?,?,?,?)"); $ins->execute([$student_number,$hash,$first,$last,$email]); header('Location: index.php'); exit; }
}
include 'includes/header.php';
?>
<div class="auth-panel">
  <form method="post" class="card auth-card">
    <h2 class="mb">Student Registration</h2>
    <?php if(!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="form-group"><label>Student Number</label><input name="student_number" required></div>
    <div class="form-group"><label>First Name</label><input name="first_name" required></div>
    <div class="form-group"><label>Last Name</label><input name="last_name" required></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <div class="form-actions"><button class="btn primary">Register</button> <a class="btn ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php echo '</section></main></div></body></html>'; ?>