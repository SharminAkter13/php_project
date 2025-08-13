<?php
session_start();
require 'config.php'; // Your PDO or MySQLi connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data safely
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $role_name  = trim($_POST['role'] ?? '');
    $terms      = isset($_POST['terms']) ? 1 : 0;

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role_name)) {
        $_SESSION['error'] = 'All fields are required!';
        header('Location: reg.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format!';
        header('Location: reg.php');
        exit;
    }

    if (!$terms) {
        $_SESSION['error'] = 'You must accept the terms!';
        header('Location: reg.php');
        exit;
    }

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Email already exists!';
            header('Location: reg.php');
            exit;
        }

        // Look up role_id from roles table
        $stmt = $pdo->prepare("SELECT id FROM roles WHERE name = :name LIMIT 1");
        $stmt->execute(['name' => $role_name]);
        $role = $stmt->fetch();

        if (!$role) {
            $_SESSION['error'] = 'Invalid role selected!';
            header('Location: reg.php');
            exit;
        }
        $role_id = $role['id'];

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password, role_id, terms_accepted)
            VALUES (:first_name, :last_name, :email, :password, :role_id, :terms)
        ");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'password'   => $hashed_password,
            'role_id'    => $role_id,
            'terms'      => $terms
        ]);

        $_SESSION['success'] = 'Registration successful!';
        header('Location: login.php');
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        header('Location: reg.php');
        exit;
    }
}
?>

<!-- HTML part -->




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DonorHub | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <style>
    .register-box {
      width: 500px; /* Increased width */
    }
    .terms-register {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .terms-register .icheck-primary {
      margin-bottom: 0;
    }
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

      <form action="login.php" method="post">
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
          <select class="form-control" name="user_role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="donor">Donor</option>
            <option value="staff">Volunteer</option>
            <option value="staff">Campaign Manager</option>
            <option value="staff">Beneficiary</option>
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
                <button type="submit" class="btn btn-primary" style="width: 150px;">Register</button>
            </div>
        </div>

      </form>

      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.php" class="text-center d-block mt-2">I already have a membership</a>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
