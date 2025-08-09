<?php
session_start();
// require_once 'db.php'; // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_role = $_POST['user_role'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match!';
        header('Location: register.php');
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = 'Email already registered!';
        header('Location: register.php');
        exit;
    }

    // Insert user data into the database
    // $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, user_role) VALUES (:first_name, :last_name, :email, :password, :user_role)");
    // $stmt->execute([
    //     'first_name' => $first_name,
    //     'last_name' => $last_name,
    //     'email' => $email,
    //     'password' => $hashed_password,
    //     'user_role' => $user_role
    // ]);

    // Redirect to login page after successful registration
    $_SESSION['success'] = 'Registration successful. Please log in.';
    header('Location: login.php');
    exit;
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

      <form action="assets/reg.php" method="post">
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
