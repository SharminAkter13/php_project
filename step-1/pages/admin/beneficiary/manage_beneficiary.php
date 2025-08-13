<?php
// Database connection
include('config.php');

// Fetch all beneficiaries from the DB
$result = mysqli_query($dms, "SELECT * FROM beneficiaries");

$beneficiaries = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $beneficiaries[] = $row;
    }
}

// Delete action
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    mysqli_query($dms, "DELETE FROM beneficiaries WHERE id=$deleteId");
    echo "<div class='alert alert-success text-center'>Beneficiary ID $deleteId deleted successfully!</div>";
}
?>





<!-- Beneficiaries Management -->

<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Beneficiaries Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Beneficiaries</li>
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
                <h3 class="card-title">Manage Beneficiaries</h3>

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
                <div class="container my-5">
                    <div class="table-wrapper">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4><i class="fas fa-users me-2"></i>Manage Beneficiaries</h4>
                            <input type="text" id="searchBox" class="form-control w-25" placeholder="Search...">
                        </div>

                        <table class="table table-hover " id="beneficiaryTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Needs</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($beneficiaries as $b): ?>
                                    <tr>
                                        <td><?= $b['id'] ?></td>
                                        <td><?= $b['name'] ?></td>
                                        <td><?= $b['email'] ?></td>
                                        <td><?= $b['phone'] ?></td>
                                        <td><?= $b['address'] ?></td>
                                        <td><?= $b['required_support'] ?></td>
                                        <td>
                                            <a href="edit_beneficiary.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <a href="?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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



<style>
    body {
        background-color: #f8f9fa;
    }

    .table-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    content-wrapper {
        margin-right: 250px;
        padding: 20px;
    }
</style>

<!-- FontAwesome & Bootstrap JS -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Search Filter Script -->
<script>
    document.getElementById("searchBox").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#beneficiaryTable tbody tr");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>