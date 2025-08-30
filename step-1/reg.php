<?php
session_start();
require 'config.php'; // contains $dms = new mysqli(...);

// Fetch roles for dropdown (excluding admin)
$roles = $dms->query("SELECT * FROM roles WHERE id != 1");

// Dynamically get donor role id
$donor_query = $dms->prepare("SELECT id FROM roles WHERE name = 'donor' LIMIT 1");
$donor_query->execute();
$donor_query->bind_result($default_role_id);
$donor_query->fetch();
$donor_query->close();

if (isset($_POST['submit'])) {
    // Sanitize input
    $first_name        = trim($_POST['first_name'] ?? '');
    $last_name         = trim($_POST['last_name'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $password          = $_POST['password'] ?? '';
    $confirm_password  = $_POST['confirm_password'] ?? '';
    $requested_role_id = trim($_POST['role_id'] ?? '');

    $errors = [];

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || empty($requested_role_id)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Check if email already exists
    $stmt = $dms->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "Email is already registered.";
    }
    $stmt->close();

    // If no errors, insert user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $dms->prepare("INSERT INTO users (first_name, last_name, email, password, role_id, requested_role_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $first_name, $last_name, $email, $hashed_password, $default_role_id, $requested_role_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful. Please login. Your role will be approved by an administrator.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!-- HTML below remains mostly unchanged -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DonorHub | Register</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <style>
    .register-box { width: 500px; }
    .terms-register { display: flex; align-items: center; justify-content: space-between; }
    .terms-register .icheck-primary { margin-bottom: 0; }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-info">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Donor</b>Hub</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Create your account</p>

      <?php
      if (!empty($errors)) {
          echo '<div class="alert alert-danger">';
          foreach ($errors as $error) {
              echo "<div>$error</div>";
          }
          echo '</div>';
      }
      ?>

      <form action="" method="post">
        <div class="row">
          <div class="col-md-6 mb-3">
            <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
          </div>
          <div class="col-md-6 mb-3">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
          </div>
        </div>
        <div class="mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email Address" required>
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
        </div>
        <div class="mb-3">
          <label for="role_id" class="form-label">Apply for Role</label>
          <select name="role_id" id="role_id" class="form-control" required>
            <option value="">Select Role</option>
            <?php while ($row = $roles->fetch_assoc()): ?>
              <option value="<?= $row['id'] ?>"><?= ucfirst($row['name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3 terms-register row">
          <div class="icheck-primary col-6">
            <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
            <label for="agreeTerms">
              I agree to the <a href="#">terms</a>
            </label>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <button type="submit" name="submit" class="btn btn-primary" style="width: 150px;">Register</button>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign up using Google+
        </a>
      </div>

      <a href="login.php" class="text-center d-block mt-2">I already have a membership</a>
    </div>
  </div>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
