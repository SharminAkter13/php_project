<?php
// Include the database connection file
// Assumes config.php has the database connection details in a variable named $dms
include('config.php');


if (isset($_POST["btnDelete"])) {
 $u_id = $_POST["txtId"];

 $conn->query("delete from users where id='$u_id'");
 echo "Deleted";
}
?><!-- Content Wrapper. Contains page content -->




<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
  <div class="container-fluid">
   <div class="row mb-2">
    <div class="col-sm-6">
     <h1>Manage users</h1>
    </div>
    <div class="col-sm-6">
     <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Blank Page</li>
     </ol>
    </div>
   </div>
  </div><!-- /.container-fluid -->
 </section>

 <!-- Main content -->
 <section class="content">

  <!-- Default box -->
  <div class="card">
   <div class="card-header">
    <h3 class="card-title">Manage Users</h3>

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
    <div class="card">
     <!-- /.card-header -->
     <div class="card-body">
      <table class="table table-hover table-striped table-bordered">
       <thead class="bg-primary text-white">
        <tr>
         <th>#ID</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Action</th>
        </tr>
       </thead>
       <tbody>
        <?php
        $users = $dms->query("select * from users");
        while (list($id, $fname, $lname, $email) = $users->fetch_row()) {
         echo "<tr> 
     <td>$id</td>
     <td>$fname</td>
     <td>$lname</td>
     <td>$email</td>
     <td class='d-flex justify-content-center align-items-center'>
     
     <form action='home.php?page=2' method='post' class='me-2' data-bs-toggle='tooltip' data-bs-placement='top' title='Delete User'>
      <input type='hidden' name='txtId' value='$id' />
      <button type='submit' name='btnDelete' class='btn btn-danger btn-sm'>
       <i class='fas fa-trash-alt'></i>
      </button>
     </form> &nbsp;  &nbsp;
     <form action='home.php?page=3' method='post' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit User'>
      <input type='hidden' name='id' value='$id' />
      <button type='submit' name='btnEdit' class='btn btn-warning btn-sm'>
       <i class='fas fa-edit'></i>
      </button>
     </form>
     </td>
    </tr>";
        }
        ?>
       </tbody>
      </table>
     </div>
     <!-- /.card-body -->
     <div class="card-footer clearfix">
      <ul class="pagination pagination-sm m-0 float-right">
       <li class="page-item"><a class="page-link" href="#">«</a></li>
       <li class="page-item"><a class="page-link" href="#">1</a></li>
       <li class="page-item"><a class="page-link" href="#">2</a></li>
       <li class="page-item"><a class="page-link" href="#">3</a></li>
       <li class="page-item"><a class="page-link" href="#">»</a></li>
      </ul>
     </div>
    </div>
   </div>

   <!-- /.card-footer-->
  </div>
  <!-- /.card -->

 </section>
 <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Initialize Tooltips -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
