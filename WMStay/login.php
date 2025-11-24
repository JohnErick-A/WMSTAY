<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>WMSTAY Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head> 
<body>
<div class="auth-wrapper">
  <div class="auth-card">
    <h2>Login</h2>
    <form action="/wmstay/includes/auth.php" method="POST">
      <div class="form-group">
        <label>School Email / Student No. / Admin Username</label>
        <input type="text" name="login_id" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <button class="btn primary" type="submit" name="login">Login</button>
    </form>
    <p class="muted">
      Student? <a href="signup.php">Create a new account</a>
    </p>
  </div>
</div>
</body>
</html>