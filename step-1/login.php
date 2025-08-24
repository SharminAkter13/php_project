<?php
// Start the session at the very beginning of the file.
session_start();

// Include the database connection file.
require 'config.php'; 

// Initialize an array to store any validation or login errors.
$errors = [];

// Check if the form was submitted.
if (isset($_POST['submit'])) {
    // Sanitize and trim the email input.
    $email = trim($_POST['email'] ?? '');
    // Get the password input directly without trimming.
    $password = $_POST['password'] ?? '';

    // Basic validation to ensure fields are not empty.
    if (empty($email) || empty($password)) {
        $errors[] = "Please enter both email and password.";
    }

    // Proceed with database query if there are no initial errors.
    if (empty($errors)) {
        // Use a prepared statement with a JOIN to get user data and their role.
        // We select the user's ID, their hashed password, and the role name.
        $stmt = $dms->prepare("
            SELECT u.id, u.password, r.name
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.email = ?
        ");
        
        // Bind the email parameter to the prepared statement.
        $stmt->bind_param("s", $email);
        
        // Execute the query.
        $stmt->execute();
        
        // Get the result set from the query.
        $result = $stmt->get_result();
        
        // Fetch the user data as an associative array.
        $user = $result->fetch_assoc();
        
        // Close the statement to free up resources.
        $stmt->close();

        // Check if a user was found AND the provided password matches the hashed password in the database.
        if ($user && password_verify($password, $user['password'])) {
            // Login successful. Set session variables.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $email; // It's good practice to store the email as well.
            $_SESSION['user_role'] = $user['role_name']; // Store the role name for future use.

            // Redirect the user based on their role.
            switch ($user['role_name']) {
                case 'admin':
                    header("Location: home.php");
                    break;
                case 'Staff':
                    header("Location: index.php");
                    break;
                // Add more cases for other roles if needed.
                default:
                    // If the role is not recognized, redirect to a default page or show an error.
                    header("Location: home.php");
                    break;
            }
            // Terminate the script to ensure the redirection happens.
            exit;
        } else {
            // If user is not found or password verification fails.
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DonorHub | Log in </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>Donor</b>Hub</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

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
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="index.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
