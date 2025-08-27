<?php
// Include the database configuration file
include('config.php');

// --- START: Security Enhancement ---
// Use a prepared statement to prevent SQL Injection on deletion.
if (isset($_POST["btnDelete"])) {
    $u_id = $_POST["txtId"] ?? null;

    if ($u_id) {
        // Prepare the statement with a placeholder (?)
        $stmt = $dms->prepare("DELETE FROM donations WHERE id = ?");

        // Check if the statement was prepared successfully
        if ($stmt === false) {
            echo "<div class='alert alert-danger'>Error preparing statement: " . $dms->error . "</div>";
        } else {
            // Bind the parameter and execute
            $stmt->bind_param("i", $u_id); // 'i' for integer type
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Donation deleted successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Error deleting donation: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    } else {
        echo "<div class='alert alert-danger'>No donation ID provided</div>";
    }
}
// --- END: Security Enhancement ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Donations</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .content-wrapper {
            padding: 20px;
        }
        .card-header .card-title {
            float: none;
        }
        .card-tools {
            float: right;
        }
    </style>
</head>
<body>
<!-- Content Wrapper. Contains page content -->
<div class="container-fluid p-5">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Donations</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Donations</li>
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
                <h3 class="card-title">Manage Donations</h3>
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
                <table class="table table-hover table table-light table-striped">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>#ID</th>
                            <!-- Changed table header to be more generic -->
                            <th>Pledge / Campaign Name</th>
                            <th>Donor Name</th>
                            <th>Fund Name</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check for database connection before running the query
                        if ($dms->connect_error) {
                            echo "<tr><td colspan='8' class='text-center text-danger'>Connection failed: " . $dms->connect_error . "</td></tr>";
                        } else {
                            // --- START: Logic to include both pledges and campaigns ---
                            // Use COALESCE to get the first non-null name from either pledges or campaigns
                            // Assuming 'donations' table has 'pledge_id' and 'campaign_id' columns
                            $sql = "SELECT d.id, d.name AS donor_name, d.amount, d.date,
                                    COALESCE(p.name, c.name) AS pledge_campaign_name,
                                    f.name AS fund_name,
                                    pm.type AS payment_method
                                    FROM donations d
                                    LEFT JOIN pledges p ON d.pledge_id = p.id
                                    LEFT JOIN campaigns c ON d.campaign_id = c.id
                                    LEFT JOIN funds f ON d.fund_id = f.id
                                    LEFT JOIN payment_methods pm ON d.payment_id = pm.id";
                            // --- END: Logic to include both pledges and campaigns ---

                            $donations = $dms->query($sql);

                            if (!$donations) {
                                echo "<tr><td colspan='8' class='text-center text-danger'>Query failed: " . $dms->error . "</td></tr>";
                            } else if ($donations->num_rows > 0) {
                                while ($row = $donations->fetch_assoc()) {
                                    // Use the new column name for display and data attributes
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>" . htmlspecialchars($row['pledge_campaign_name'] ?? 'N/A') . "</td>
                                            <td>" . htmlspecialchars($row['donor_name'] ?? 'N/A') . "</td>
                                            <td>" . htmlspecialchars($row['fund_name'] ?? 'N/A') . "</td>
                                            <td>" . htmlspecialchars($row['payment_method'] ?? 'N/A') . "</td>
                                            <td>" . htmlspecialchars($row['amount'] ?? 'N/A') . "</td>
                                            <td>" . htmlspecialchars($row['date'] ?? 'N/A') . "</td>
                                            <td class='d-flex justify-content-center align-items-center'>
                                                <button type='button' class='btn btn-info btn-sm me-2' data-bs-toggle='modal' data-bs-target='#donationViewModal'
                                                    data-id='{$row['id']}'
                                                    data-pname='" . htmlspecialchars($row['pledge_campaign_name'] ?? '') . "'
                                                    data-donor='" . htmlspecialchars($row['donor_name'] ?? '') . "'
                                                    data-fund='" . htmlspecialchars($row['fund_name'] ?? '') . "'
                                                    data-payment='" . htmlspecialchars($row['payment_method'] ?? '') . "'
                                                    data-amount='{$row['amount']}'
                                                    data-date='{$row['date']}'
                                                    title='View donation'>
                                                    <i class='fas fa-eye'></i>
                                                </button>

                                                <!-- Delete Button - now opens confirmation modal -->
                                                <button type='button' class='btn btn-danger btn-sm me-2' data-bs-toggle='modal' data-bs-target='#deleteConfirmModal' data-id='{$row['id']}' title='Delete donation'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                
                                                <!-- This form is now submitted by the modal's JS -->
                                                <form id='deleteForm-{$row['id']}' action='home.php?page=18' method='post' class='me-2' style='display:none;'>
                                                    <input type='hidden' name='txtId' value='{$row['id']}'>
                                                    <button type='submit' name='btnDelete'></button>
                                                </form>

                                                <form action='home.php?page=3' method='post' data-bs-toggle='tooltip' title='Edit donation'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <button type='submit' name='btnEdit' class='btn btn-warning btn-sm'>
                                                        <i class='fas fa-edit'></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No donations found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
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

<!-- View donation Modal -->
<div class="modal fade" id="donationViewModal" tabindex="-1" aria-labelledby="donationViewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Changed modal title to be more generic -->
                <h5 class="modal-title" id="donationViewModalLabel">Donation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="view-id"></span></p>
                <!-- Changed label from 'Pledge Name' to 'Pledge/Campaign Name' -->
                <p><strong>Pledge/Campaign Name:</strong> <span id="view-pname"></span></p>
                <p><strong>Donor Name:</strong> <span id="view-donor"></span></p>
                <p><strong>Fund Name:</strong> <span id="view-fund"></span></p>
                <p><strong>Payment Method:</strong> <span id="view-payment"></span></p>
                <p><strong>Amount:</strong> <span id="view-amount"></span></p>
                <p><strong>Date:</strong> <span id="view-date"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
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
                Are you sure you want to delete this donation? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
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

    // View Modal
    var donationViewModal = document.getElementById('donationViewModal');
    if (donationViewModal) {
        donationViewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            document.getElementById('view-id').textContent = button.getAttribute('data-id');
            // This is now getting the pledge/campaign name
            document.getElementById('view-pname').textContent = button.getAttribute('data-pname');
            document.getElementById('view-donor').textContent = button.getAttribute('data-donor');
            document.getElementById('view-fund').textContent = button.getAttribute('data-fund');
            document.getElementById('view-payment').textContent = button.getAttribute('data-payment');
            document.getElementById('view-amount').textContent = button.getAttribute('data-amount');
            document.getElementById('view-date').textContent = button.getAttribute('data-date');
        });
    }

    // Delete Confirmation Modal
    var deleteConfirmModal = document.getElementById('deleteConfirmModal');
    if (deleteConfirmModal) {
        let donationIdToDelete = null;

        // When the modal is shown, get the donation ID from the button that triggered it
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            donationIdToDelete = button.getAttribute('data-id');
        });

        // When the 'Delete' button inside the modal is clicked, submit the correct form
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (donationIdToDelete) {
                const form = document.getElementById(`deleteForm-${donationIdToDelete}`);
                if (form) {
                    form.submit();
                }
            }
        });
    }
});
</script>

</body>
</html>
