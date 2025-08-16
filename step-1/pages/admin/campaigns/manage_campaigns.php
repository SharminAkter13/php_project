<?php
// Include the database configuration file
include('config.php');

// Define the table name for campaigns
$tableName = "campaigns";

// --- CRUD Operations ---

// Add a new campaign
if (isset($_POST['btnSave'])) {
    $name = $_POST['campaignName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $status = $_POST['status'];
    $fundsRaised = $_POST['fundsRaised'];
    $donors = $_POST['donors'];

    $sql = "INSERT INTO $tableName (name, start_date, end_date, status, funds_raised, donors) VALUES ('$name', '$startDate', '$endDate', '$status', '$fundsRaised', '$donors')";
    $dms->query($sql);
    echo "<div class='alert alert-success'>Campaign added successfully.</div>";
}

// Update an existing campaign
if (isset($_POST['btnEdit'])) {
    $id = $_POST['id'];
    $name = $_POST['campaignName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $status = $_POST['status'];
    $fundsRaised = $_POST['fundsRaised'];
    $donors = $_POST['donors'];

    $sql = "UPDATE $tableName SET name='$name', start_date='$startDate', end_date='$endDate', status='$status', funds_raised='$fundsRaised', donors='$donors' WHERE id='$id'";
    $dms->query($sql);
    echo "<div class='alert alert-success'>Campaign updated successfully.</div>";
}

// Delete a campaign
if (isset($_POST['btnDelete'])) {
    $id = $_POST['txtId'];
    $sql = "DELETE FROM $tableName WHERE id='$id'";
    $dms->query($sql);
    echo "<div class='alert alert-success'>Campaign deleted successfully.</div>";
}

?>
<!DOCTYPE ahtml>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Campaigns</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body { background-color: #f4f6f9; }
        .content-wrapper { padding: 20px; }
        .card-header .card-title { float: none; }
        .card-tools { float: right; }
    </style>
</head>
<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Campaigns</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Campaigns</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Campaigns</h3>
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
                <!-- Add Campaign Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#campaignModal" id="addCampaignBtn">
                    + Add New Campaign
                </button>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#ID</th>
                                <th>Campaign Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Funds Raised</th>
                                <th>Donors</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="campaignTableBody">
                            <?php
                            // Check for database connection before running the query
                            if ($dms->connect_error) {
                                echo "<tr><td colspan='8' class='text-center text-danger'>Connection failed: " . $dms->connect_error . "</td></tr>";
                            } else {
                                // Fetch all campaigns from the database
                                $sql = "SELECT id, name, start_date, end_date, status, funds_raised, donors FROM $tableName";
                                $campaigns = $dms->query($sql);

                                // Added error handling to check if the query was successful
                                if (!$campaigns) {
                                    echo "<tr><td colspan='8' class='text-center text-danger'>Query failed: " . $dms->error . "</td></tr>";
                                } else if ($campaigns->num_rows > 0) {
                                    while ($row = $campaigns->fetch_assoc()) {
                                        // Helper: Create badge HTML based on status
                                        $statusMap = ['Active' => 'success', 'Completed' => 'secondary', 'Pending' => 'warning'];
                                        $badgeClass = $statusMap[$row['status']] ?? 'primary';
                                        $statusBadge = "<span class='badge bg-{$badgeClass}'>{$row['status']}</span>";

                                        echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['start_date']}</td>
                                            <td>{$row['end_date']}</td>
                                            <td>{$statusBadge}</td>
                                            <td>$" . number_format($row['funds_raised'], 2) . "</td>
                                            <td>{$row['donors']}</td>
                                            <td class='d-flex justify-content-center align-items-center'>
                                                <button type='button' class='btn btn-warning btn-sm edit-btn me-2' data-bs-toggle='modal' data-bs-target='#campaignModal'
                                                    data-id='{$row['id']}'
                                                    data-name='{$row['name']}'
                                                    data-start='{$row['start_date']}'
                                                    data-end='{$row['end_date']}'
                                                    data-status='{$row['status']}'
                                                    data-funds='{$row['funds_raised']}'
                                                    data-donors='{$row['donors']}'
                                                    title='Edit Campaign'>
                                                    <i class='fas fa-edit'></i>
                                                </button>
                                                <button type='button' class='btn btn-danger btn-sm delete-btn' data-bs-toggle='modal' data-bs-target='#deleteConfirmModal' data-id='{$row['id']}' title='Delete Campaign'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No campaigns found.</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
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
    </section>
</div>

<!-- Add/Edit Campaign Modal -->
<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- The form action will be handled by JavaScript to switch between 'add' and 'edit' -->
        <form id="campaignForm" class="modal-content" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="campaignModalLabel">Add Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="campaignId" name="id" />
                <div class="mb-3">
                    <label for="campaignName" class="form-label">Campaign Name</label>
                    <input type="text" class="form-control" id="campaignName" name="campaignName" required />
                </div>
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" required />
                </div>
                <div class="mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" required />
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="" disabled selected>Select status</option>
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fundsRaised" class="form-label">Funds Raised ($)</label>
                    <input type="number" class="form-control" id="fundsRaised" name="fundsRaised" min="0" step="0.01" value="0" required />
                </div>
                <div class="mb-3">
                    <label for="donors" class="form-label">Number of Donors</label>
                    <input type="number" class="form-control" id="donors" name="donors" min="0" value="0" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveCampaignBtn" name="btnSave">Save Campaign</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this campaign? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="post" action="">
                    <input type="hidden" name="txtId" id="deleteCampaignId">
                    <button type="submit" class="btn btn-danger" name="btnDelete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Initialize Tooltips & Modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle Add/Edit modal content
    const campaignModal = document.getElementById('campaignModal');
    if (campaignModal) {
        const modalTitle = document.getElementById('campaignModalLabel');
        const campaignForm = document.getElementById('campaignForm');
        const saveButton = document.getElementById('saveCampaignBtn');
        const campaignIdInput = document.getElementById('campaignId');

        campaignModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const isEdit = button.classList.contains('edit-btn');
            
            if (isEdit) {
                modalTitle.textContent = 'Edit Campaign';
                saveButton.textContent = 'Update Campaign';
                saveButton.name = 'btnEdit';

                // Populate form fields with data from the button's data attributes
                campaignIdInput.value = button.getAttribute('data-id');
                document.getElementById('campaignName').value = button.getAttribute('data-name');
                document.getElementById('startDate').value = button.getAttribute('data-start');
                document.getElementById('endDate').value = button.getAttribute('data-end');
                document.getElementById('status').value = button.getAttribute('data-status');
                document.getElementById('fundsRaised').value = button.getAttribute('data-funds');
                document.getElementById('donors').value = button.getAttribute('data-donors');
            } else {
                modalTitle.textContent = 'Add Campaign';
                saveButton.textContent = 'Save Campaign';
                saveButton.name = 'btnSave';
                campaignForm.reset();
                campaignIdInput.value = '';
            }
        });
    }

    // Handle Delete modal content
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            document.getElementById('deleteCampaignId').value = id;
        });
    }
});
</script>

</body>
</html>
