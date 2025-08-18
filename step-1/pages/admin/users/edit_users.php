<?php
include('config.php');

$edit_id = $_POST['id'] ?? null;
$user = null;

// Fetch user data if id is passed
if ($edit_id) {
    $result = $dms->query("SELECT * FROM users WHERE id='$edit_id'");
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

// Handle update form submission
if (isset($_POST["btnUpdate"])) {
    $u_id   = $_POST["txtId"];
    $fname  = $_POST["txtFname"];
    $lname  = $_POST["txtLname"];
    $email  = $_POST["txtEmail"];

    $update = $dms->query("UPDATE users SET fname='$fname', lname='$lname', email='$email' WHERE id='$u_id'");
    
    if ($update) {
        echo "<div class='alert alert-success'>User updated successfully</div>";
        echo "<script>setTimeout(function(){ window.location='home.php?page=2'; }, 1000);</script>";
    } else {
        echo "<div class='alert alert-danger'>Error updating user</div>";
    }
}
?>


<!-- Add Users -->

<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users Interface</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Add Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">


      <!-- Default box -->
      <div class="card">
        <div class="card-header ">
          <h3 class="card-title">Add Users</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
         

<div class="container-fluid p-5 ">
    <div class="row">

        <!-- Main content -->
        <main class="col-md-9 py-4">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white">
                    <h3 class="mb-0">Edit User</h3>
                </div>
                <div class="card-body">
                    <?php if ($user): ?>
                    <form method="post" action="">
                        <input type="hidden" name="txtId" value="<?= $user['id'] ?? '' ?>">

                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="txtFname" class="form-control" 
                                   value="<?= $user['fname'] ?? '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="txtLname" class="form-control" 
                                   value="<?= $user['lname'] ?? '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="txtEmail" class="form-control" 
                                   value="<?= $user['email'] ?? '' ?>" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="home.php?page=2" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="btnUpdate" class="btn btn-success">Update User</button>
                        </div>
                    </form>
                    <?php else: ?>
                        <div class="alert alert-danger">No user found.</div>
                        <a href="home.php?page=2" class="btn btn-secondary">Back</a>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>
        </div>
        <!-- /.card-body -->
       
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- ./Add users -->

