<!-- header  -->
<?php
include("include/header.php")
?>
<!-- /.header -->


<!-- Navbar  -->
<?php
include("include/nav.php")
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php
include("include/sidebar.php")
?>

<!-- ./Main Sidebar Container -->


<!-- Add Users -->

<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users Interface</h1>
          </div>
<h1 class="h4">Add User</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="row g-3">
  <div class="col-md-4"><label class="form-label">First name</label><input name="first_name" class="form-control" required></div>
  <div class="col-md-4"><label class="form-label">Last name</label><input name="last_name" class="form-control" required></div>
  <div class="col-md-4"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
  <div class="col-md-4"><label class="form-label">Password</label><input name="password" type="password" class="form-control" required></div>
  <div class="col-md-4">
    <label class="form-label">Role</label>
    <select name="role_id" class="form-select">
      <?php while($r = $roles->fetch_assoc()): ?>
        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-12"><button class="btn btn-success">Create User</button></div>
</form>        </div>
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
         
        </div>
        <!-- /.card-body -->
       
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- ./Add users -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<?php
include("include/footer.php");
?>

<!-- Main Footer -->