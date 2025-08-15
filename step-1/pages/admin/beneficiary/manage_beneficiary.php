<?php
// Database connection
include('config.php');

// Initialize variables for messages
$success_message = '';
$error_message = '';

// Handle form submission for UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['beneficiary_id'] ?? 0);
    $name = $_POST['beneficiary_name'] ?? '';
    $email = $_POST['beneficiary_email'] ?? '';
    $phone = $_POST['beneficiary_phone'] ?? '';
    $address = $_POST['beneficiary_address'] ?? '';
    $needs = $_POST['beneficiary_needs'] ?? '';

    // Simple validation
    if ($id > 0 && !empty($name) && !empty($email)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $dms->prepare("UPDATE beneficiaries SET name=?, email=?, phone=?, address=?, required_support=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("sssssi", $name, $email, $phone, $address, $needs, $id);
            if ($stmt->execute()) {
                $success_message = "Beneficiary updated successfully!";
            } else {
                $error_message = "Error updating beneficiary: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $dms->error;
        }
    } else {
        $error_message = "Invalid data provided for update.";
    }
}

// Handle GET request for DELETE
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    // Use prepared statement for deletion
    $stmt = $dms->prepare("DELETE FROM beneficiaries WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $deleteId);
        if ($stmt->execute()) {
            $success_message = "Beneficiary ID $deleteId deleted successfully!";
        } else {
            $error_message = "Error deleting beneficiary: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all beneficiaries from the DB to display in the table
$result = mysqli_query($dms, "SELECT * FROM beneficiaries");
$beneficiaries = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $beneficiaries[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Beneficiaries - DonorHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .table-wrapper {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .content-wrapper {
            padding: 20px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Beneficiaries Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Beneficiaries</li>
                    </ol>
                </div>
            </div>
        </div>
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
                        <?php if (!empty($success_message)): ?>
                            <div class="alert alert-success text-center"><?= htmlspecialchars($success_message) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger text-center"><?= htmlspecialchars($error_message) ?></div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4><i class="fas fa-users me-2"></i>Manage Beneficiaries</h4>
                            <input type="text" id="searchBox" class="form-control w-25" placeholder="Search...">
                        </div>

                        <table class="table table-hover" id="beneficiaryTable">
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
                                        <td><?= htmlspecialchars($b['id']) ?></td>
                                        <td><?= htmlspecialchars($b['name']) ?></td>
                                        <td><?= htmlspecialchars($b['email']) ?></td>
                                        <td><?= htmlspecialchars($b['phone']) ?></td>
                                        <td><?= htmlspecialchars($b['address']) ?></td>
                                        <td ><?= htmlspecialchars($b['required_support']) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editBeneficiaryModal"
                                                data-id="<?= htmlspecialchars($b['id']) ?>"
                                                data-name="<?= htmlspecialchars($b['name']) ?>"
                                                data-email="<?= htmlspecialchars($b['email']) ?>"
                                                data-phone="<?= htmlspecialchars($b['phone']) ?>"
                                                data-address="<?= htmlspecialchars($b['address']) ?>"
                                                data-needs="<?= htmlspecialchars($b['required_support']) ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?= htmlspecialchars($b['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Edit Beneficiary Modal -->
<div class="modal fade" id="editBeneficiaryModal" tabindex="-1" aria-labelledby="editBeneficiaryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editBeneficiaryModalLabel">Edit Beneficiary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBeneficiaryForm" method="POST" action="">
                    <input type="hidden" name="beneficiary_id" id="beneficiary_id">
                    <div class="mb-3">
                        <label for="beneficiary_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="beneficiary_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="beneficiary_email" name="beneficiary_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="beneficiary_phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="beneficiary_phone" name="beneficiary_phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="beneficiary_address" class="form-label">Address</label>
                        <textarea class="form-control" id="beneficiary_address" name="beneficiary_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="beneficiary_needs" class="form-label">Needs / Support Required</label>
                        <textarea class="form-control" id="beneficiary_needs" name="beneficiary_needs" rows="3" required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Beneficiary</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & AdminLTE Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>

<!-- Custom Scripts -->
<script>
    // Search Filter Script
    document.getElementById("searchBox").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#beneficiaryTable tbody tr");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Populate modal with data from the clicked row
    const editBeneficiaryModal = document.getElementById('editBeneficiaryModal');
    editBeneficiaryModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        const button = event.relatedTarget;
        
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const email = button.getAttribute('data-email');
        const phone = button.getAttribute('data-phone');
        const address = button.getAttribute('data-address');
        const needs = button.getAttribute('data-needs');
        
        // Update the modal's form fields
        const modalForm = editBeneficiaryModal.querySelector('#editBeneficiaryForm');
        modalForm.querySelector('#beneficiary_id').value = id;
        modalForm.querySelector('#beneficiary_name').value = name;
        modalForm.querySelector('#beneficiary_email').value = email;
        modalForm.querySelector('#beneficiary_phone').value = phone;
        modalForm.querySelector('#beneficiary_address').value = address;
        modalForm.querySelector('#beneficiary_needs').value = needs;
    });
</script>

</body>
</html>
