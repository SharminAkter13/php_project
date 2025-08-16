<?php
// Include the database configuration file
include('config.php');

// Define the table names
$campaignsTable = "campaigns";
$eventsTable = "events"; // Assuming your events table is named 'events'

// --- CRUD Operations ---

// Add a new campaign
if (isset($_POST['btnSave'])) {
    $name = $_POST['campaignName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $status = $_POST['status'];
    $eventId = $_POST['eventId']; // Changed from 'events' to 'eventId' for clarity

    // Use prepared statements to prevent SQL injection
    $stmt = $dms->prepare("INSERT INTO $campaignsTable (name, start_date, end_date, status, event_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $startDate, $endDate, $status, $eventId);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Campaign added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error adding campaign: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Update an existing campaign
if (isset($_POST['btnEdit'])) {
    $id = $_POST['id'];
    $name = $_POST['campaignName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $status = $_POST['status'];
    $eventId = $_POST['eventId']; // Changed from 'events' to 'eventId' for clarity

    // Use prepared statements to prevent SQL injection
    $stmt = $dms->prepare("UPDATE $campaignsTable SET name=?, start_date=?, end_date=?, status=?, event_id=? WHERE id=?");
    $stmt->bind_param("ssssii", $name, $startDate, $endDate, $status, $eventId, $id);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Campaign updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating campaign: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Delete a campaign
if (isset($_POST['btnDelete'])) {
    $id = $_POST['txtId'];
    
    // Use prepared statements for safe deletion
    $stmt = $dms->prepare("DELETE FROM $campaignsTable WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Campaign deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting campaign: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Fetch all events for the dropdown menu
$events = [];
$event_sql = "SELECT id, name FROM $eventsTable";
$event_result = $dms->query($event_sql);
if ($event_result) {
    while ($row = $event_result->fetch_assoc()) {
        $events[] = $row;
    }
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
                                <th>Event Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="campaignTableBody">
                            <?php
                            // Check for database connection before running the query
                            if ($dms->connect_error) {
                                echo "<tr><td colspan='7' class='text-center text-danger'>Connection failed: " . $dms->connect_error . "</td></tr>";
                            } else {
                                // Fetch all campaigns with their associated event names using a JOIN
                                $sql = "SELECT c.id, c.name, c.start_date, c.end_date, c.status, e.name AS event_name, c.event_id 
                                        FROM $campaignsTable AS c
                                        LEFT JOIN $eventsTable AS e ON c.event_id = e.id";
                                $campaigns = $dms->query($sql);

                                // Added error handling to check if the query was successful
                                if (!$campaigns) {
                                    echo "<tr><td colspan='7' class='text-center text-danger'>Query failed: " . $dms->error . "</td></tr>";
                                } else if ($campaigns->num_rows > 0) {
                                    while ($row = $campaigns->fetch_assoc()) {
                                        // Helper: Create badge HTML based on status
                                        $statusMap = ['Active' => 'success', 'Inactive' => 'danger'];
                                        $badgeClass = $statusMap[$row['status']] ?? 'primary';
                                        $statusBadge = "<span class='badge bg-{$badgeClass}'>{$row['status']}</span>";
                                        
                                        $eventName = $row['event_name'] ?? 'N/A';

                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['name']}</td>
                                                <td>{$row['start_date']}</td>
                                                <td>{$row['end_date']}</td>
                                                <td>{$statusBadge}</td>
                                                <td>{$eventName}</td>
                                                <td class='d-flex justify-content-center align-items-center'>
                                                    <!-- View Button -->
                                                    <button type='button' class='btn btn-info btn-sm view-btn me-2' data-bs-toggle='modal' data-bs-target='#viewCampaignModal'
                                                        data-id='{$row['id']}'
                                                        data-name='{$row['name']}'
                                                        data-start='{$row['start_date']}'
                                                        data-end='{$row['end_date']}'
                                                        data-status='{$row['status']}'
                                                        data-event-name='{$eventName}'
                                                        title='View Campaign'>
                                                        <i class='fas fa-eye'></i>
                                                    </button>
                                                    <button type='button' class='btn btn-warning btn-sm edit-btn me-2' data-bs-toggle='modal' data-bs-target='#campaignModal'
                                                        data-id='{$row['id']}'
                                                        data-name='{$row['name']}'
                                                        data-start='{$row['start_date']}'
                                                        data-end='{$row['end_date']}'
                                                        data-status='{$row['status']}'
                                                        data-event-id='{$row['event_id']}'
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
                                    echo "<tr><td colspan='7' class='text-center'>No campaigns found.</td></tr>";
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
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="eventId" class="form-label">Event</label>
                    <select class="form-select" id="eventId" name="eventId" required>
                        <option value="" disabled selected>Select an event</option>
                        <?php foreach ($events as $event) : ?>
                            <option value="<?= htmlspecialchars($event['id']) ?>">
                                <?= htmlspecialchars($event['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveCampaignBtn" name="btnSave">Save Campaign</button>
            </div>
        </form>
    </div>
</div>

<!-- View Campaign Modal -->
<div class="modal fade" id="viewCampaignModal" tabindex="-1" aria-labelledby="viewCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCampaignModalLabel">Campaign Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>ID:</strong> <span id="viewId"></span>
                </div>
                <div class="mb-3">
                    <strong>Campaign Name:</strong> <span id="viewName"></span>
                </div>
                <div class="mb-3">
                    <strong>Start Date:</strong> <span id="viewStart"></span>
                </div>
                <div class="mb-3">
                    <strong>End Date:</strong> <span id="viewEnd"></span>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> <span id="viewStatus"></span>
                </div>
                <div class="mb-3">
                    <strong>Event Name:</strong> <span id="viewEventName"></span>
                </div>
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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

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
                document.getElementById('eventId').value = button.getAttribute('data-event-id');
            } else {
                modalTitle.textContent = 'Add Campaign';
                saveButton.textContent = 'Save Campaign';
                saveButton.name = 'btnSave';
                campaignForm.reset();
                campaignIdInput.value = '';
                document.getElementById('eventId').value = ''; // Reset the dropdown
            }
        });
    }

    // New JavaScript for the View Modal
    const viewCampaignModal = document.getElementById('viewCampaignModal');
    if (viewCampaignModal) {
        viewCampaignModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            // Populate view modal with data from the button's data attributes
            document.getElementById('viewId').textContent = button.getAttribute('data-id');
            document.getElementById('viewName').textContent = button.getAttribute('data-name');
            document.getElementById('viewStart').textContent = button.getAttribute('data-start');
            document.getElementById('viewEnd').textContent = button.getAttribute('data-end');
            
            // Recreate the status badge for the view modal
            const status = button.getAttribute('data-status');
            const statusBadgeSpan = document.createElement('span');
            statusBadgeSpan.textContent = status;
            statusBadgeSpan.classList.add('badge');
            if (status === 'Active') {
                statusBadgeSpan.classList.add('bg-success');
            } else if (status === 'Inactive') {
                statusBadgeSpan.classList.add('bg-danger');
            } else {
                statusBadgeSpan.classList.add('bg-primary');
            }
            document.getElementById('viewStatus').innerHTML = ''; // Clear previous content
            document.getElementById('viewStatus').appendChild(statusBadgeSpan);

            document.getElementById('viewEventName').textContent = button.getAttribute('data-event-name');
        });
    }

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
