<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Signup - WMSTAY</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="auth-wrapper">
  <div class="auth-card">
    <h2>Student Registration</h2>
    <form action="signup.php" method="POST">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="full_name" required>
      </div>

      <div class="form-group">
        <label>School Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>

      <div class="form-group">
        <label>Department</label>
        <select name="department" required>
          <option value="">Select department</option>
          <option>College of Agriculture</option>
          <option>College of Architecture</option>
          <option>College of Asian & Islamic Studies</option>
          <option>College of Computing Studies</option>
          <option>College of Criminal Justice Education</option>
          <option>College of Engineering</option>
          <option>College of Forestry & Environmental Studies</option>
          <option>College of Home Economics</option>
          <option>College of Law</option>
          <option>College of Liberal Arts</option>
          <option>College of Medicine</option>
          <option>College of Nursing</option>
          <option>College of Public Administration & Development Studies</option>
          <option>College of Science and Mathematics</option>
          <option>College of Social Work & Community Development</option>
          <option>College of Sports Science & Physical Education (CSSPE)</option>
          <option>College of Teacher Education</option>
        </select>
      </div>

      <div class="form-group">
        <label>Program</label>
        <select name="program" required>
          <option value="">Select program</option>
          <option>Bachelor of Science in Agriculture (BSA)</option>
          <option>Bachelor of Science in Agricultural Business</option>
          <option>Bachelor of Agricultural Technology (BAT)</option>
          <option>Bachelor of Science in Architecture (BSArch)</option>
          <option>Bachelor of Science in Asian Studies</option>
          <option>Bachelor of Science in Islamic Studies</option>
          <option>Bachelor of Science in Computer Science</option>
          <option>Bachelor of Science in Information Technology (BSIT)</option>
          <option>Bachelor of Science in Application Development</option>
          <option>Bachelor of Science in Networking</option>
          <option>Bachelor of Science in Information System (BSIS)</option>
          <option>Bachelor of Science in Criminology</option>
          <option>Bachelor of Science in Civil Engineering</option>
          <option>Bachelor of Science in Electrical Engineering</option>
          <option>Bachelor of Science in Mechanical Engineering</option>
          <option>Bachelor of Science in Geodetic Engineering</option>
          <option>Bachelor of Science in Sanitary Health Engineering</option>
          <option>Bachelor of Science in Forestry (BSF)</option>
          <option>Bachelor of Science in Environmental Science</option>
          <option>Bachelor of Science in Nutrition and Dietetics (BSND)</option>
          <option>Bachelor of Science in Food Technology (BSFT)</option>
          <option>Bachelor of Science in Home Economics (BSHE)</option>
          <option>Juris Doctor (JD)</option>
          <option>Bachelor of Science in Accountancy (BSA)</option>
          <option>Bachelor of Science in Economics</option>
          <option>Bachelor of Science in Psychology</option>
          <option>Bachelor of Arts in English</option>
          <option>Bachelor of Arts in Political Science</option>
          <option>Bachelor of Arts in Mass Communication</option>
          <option>Bachelor of Science in Nursing (BSN)</option>
          <option>Bachelor of Science in Biology</option>
          <option>Bachelor of Science in Chemistry</option>
          <option>Bachelor of Science in Mathematics</option>
          <option>Bachelor of Science in Physics</option>
          <option>Bachelor of Science in Statistics</option>
          <option>Bachelor of Science in Social Work (BSSW)</option>
          <option>Bachelor of Science in Community Development (BSCD)</option>
          <option>Bachelor of Physical Education (BPE)</option>
          <option>Bachelor of Elementary Education (BEED)</option>
          <option>Bachelor of Secondary Education (BSED)</option>
          <option>Bachelor of Early Childhood Education (BECED)</option>
        </select>
      </div>

      <div class="form-group">
        <label>Gender</label>
        <select name="gender" required>
          <option value="">Select gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Prefer not to say</option>
        </select>
      </div>

      <div class="form-group">
        <label>Contact Number</label>
        <input type="text" name="contact" required>
      </div>

      <div class="form-group">
        <label>Address</label>
        <textarea name="address" required></textarea>
      </div>

      <button class="btn primary" type="submit" name="signup">Create Account</button>
    </form>

    <p class="muted">Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

<?php
// Backend in same file for simplicity:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    require __DIR__ . '/includes/db_connect.php';

    $full      = trim($_POST['full_name']);
    $email     = strtolower(trim($_POST['email']));
    $pass      = $_POST['password'];
    $confirm   = $_POST['confirm_password'];
    $department= $_POST['department'];
    $program   = $_POST['program'];
    $gender    = $_POST['gender'];
    $contact   = $_POST['contact'];
    $address   = $_POST['address'];

    if ($pass !== $confirm) {
        echo "<script>alert('Passwords do not match');window.location='signup.php';</script>";
        exit;
    }

    // Generate student_number from email EH202201447@wmsu.edu.ph -> 2022-01447
    $emailUpper = strtoupper($email);
    if (preg_match('/^[A-Z]{2}([0-9]{4})([0-9]{5})/', $emailUpper, $m)) {
        $yearCode = $m[1];
        $seq      = $m[2];
        $student_number = $yearCode . '-' . $seq;
    } else {
        $student_number = 'WMSU' . rand(1000000, 9999999);
    }

    $hashed = password_hash($pass, PASSWORD_BCRYPT);

    // Split full name
    $parts = explode(' ', $full, 2);
    $full_name = $full; // store whole as one

    $stmt = $conn->prepare(
        "INSERT INTO students (student_number, email, password_hash, full_name, department, program, gender, contact, address)
         VALUES (?,?,?,?,?,?,?,?,?)"
    );
    $stmt->bind_param(
        'sssssssss',
        $student_number, $email, $hashed, $full_name,
        $department, $program, $gender, $contact, $address
    );

    if ($stmt->execute()) {
        echo "<script>alert('Account created! Your Student ID is $student_number');window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed (maybe email already exists)');window.location='signup.php';</script>";
    }
}
?>
</body>
</html>