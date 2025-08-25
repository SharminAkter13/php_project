<?php
// Fix: This must be the very first thing in your file, with no leading spaces or blank lines.
session_start();
ob_start();

require_once("include/admin/header.php");
?>
<!-- /.header -->

<!-- Navbar -->
<?php
require_once("include/admin/nav.php");
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php
require_once("include/admin/sidebar.php");
?>
<!-- Main content -->
<section class="content p-5 m-5">

    <!-- Default box -->
    <div class="card">
        <?php
        // Note: You should remove the session_start() and ob_start() calls from placeholder.php now.
        include("placeholder.php");
        ?>
    </div>
    <!-- /.card -->

</section>
</div>
<!-- /.content-wrapper -->

<!-- ./Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 p-5">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<!-- Main Footer -->
<?php
require_once("include/admin/footer.php");
?>