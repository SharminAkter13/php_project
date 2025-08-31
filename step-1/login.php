<?php
session_start();
require 'config.php';
$errors = [];

if (isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check if both email and password are provided.
    if (empty($email) || empty($password)) {
        $errors[] = "Please enter both email and password.";
    }

    // If there are no errors, proceed with authentication.
    if (empty($errors)) {
        // Prepare the SQL statement to prevent SQL injection.
        // It selects the user's ID, password, and role name.
        $stmt = $dms->prepare("
            SELECT u.id, u.password, r.name as role_name, u.first_name, u.last_name
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.email = ?
        ");
        
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            // Verify if a user was found and the password matches.
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $user['role_name'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

                // Use a switch statement to redirect to home.php with the correct page ID.
                switch ($user['role_name']) {
                    case 'admin':
                        header("Location: home.php?page=0");
                        break;
                    case 'beneficiary':
                        header("Location: home.php?page=15");
                        break;
                    case 'campaign_manager':
                        header("Location: home.php?page=11");
                        break;
                    case 'donor':
                        header("Location: index.php");
                        break;
                    case 'volunteer':
                        header("Location: home.php?page=25");
                        break;
                    default:
                        // Default redirection if the role is not recognized.
                        header("Location: home.php");
                        break;
                }
                exit;
            } else {
                // Handle invalid credentials.
                $errors[] = "Invalid email or password.";
            }
        } else {
            $errors[] = "Database query failed.";
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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
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
                    <div class="col-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
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
            <p class="mb-1">
                <a href="forgot-password.php">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="index.php" class="text-center">Register a new membership</a>
            </p>
        </div>
        </div>
    </div>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>