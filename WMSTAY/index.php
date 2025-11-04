<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';
$title = "Login";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrUser = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM staff WHERE username = ? OR email = ? LIMIT 1");
    $stmt->execute([$emailOrUser, $emailOrUser]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($staff && password_verify($password, $staff['password_hash'])) {
        $_SESSION['user'] = ['id' => $staff['staff_id'],'role' => 'admin','name' => $staff['first_name'] . ' ' . $staff['last_name']];
        header('Location: admin/dashboard.php'); exit;
    }
    $stmt2 = $pdo->prepare("SELECT * FROM students WHERE student_number = ? OR email = ? LIMIT 1");
    $stmt2->execute([$emailOrUser, $emailOrUser]);
    $student = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($student && password_verify($password, $student['password_hash'])) {
        $_SESSION['user'] = ['id' => $student['student_id'],'role' => 'student','name' => $student['first_name'] . ' ' . $student['last_name']];
        header('Location: student/dashboard.php'); exit;
    }
    $error = "Invalid credentials.";
}
include 'includes/header.php';
?>
<div class="auth-panel">
  <form method="post" class="card auth-card">
    <h2 class="mb">WMSTAY Login</h2>
    <?php if(!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="form-group"><label>Email or Student Number / Username</label><input type="text" name="email" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <div class="form-actions">
      <button class="btn primary" type="submit">Login</button>
      <a class="btn ghost" href="register.php">Register</a>
    </div>
  </form>
</div>
<?php echo '</section></main></div></body></html>'; ?>