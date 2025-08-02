<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DonorHub | Forgot Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap + AdminLTE -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <style>
    .login-box {
      max-width: 450px;
    }

    

    .card {
      border-radius: 1rem;
      box-shadow: 0 0 15px rgba(0, 123, 255, 0.15);
    }

    .btn-primary {
      border-radius: 10px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .form-control {
      border-radius: 10px;
    }

    .input-group-text {
      border-radius: 0 10px 10px 0;
    }

    .login-box-msg {
      font-size: 1rem;
      font-weight: 500;
      color: #555;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1 login-logo"><b>Donor</b>Hub</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Forgot your password? Enter your email to reset it.</p>

      <form action="recover-password.html" method="post">
        <div class="input-group mb-4">
          <input type="email" class="form-control" placeholder="Enter your email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request New Password</button>
          </div>
        </div>
      </form>

      <p class="mt-4 text-center">
        <a href="login.php">← Back to Login</a>
      </p>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
