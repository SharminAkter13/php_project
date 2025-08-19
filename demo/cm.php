<?php
// === FILE: campaign_dashboard.php ===
// This file requires a 'config.php' file that establishes a database connection
// and stores the connection object in a variable named $dms.
//
// Prerequisites for this dashboard:
// 1. A 'uploads' directory in the same folder as this file, with write permissions.
// 2. The 'campaigns' table must have a 'file_path' column (e.g., VARCHAR(255))
//    to store the path to the uploaded file. You can add this column with the
//    following SQL query:
//    ALTER TABLE campaigns ADD COLUMN file_path VARCHAR(255) NULL;

// === Database Connection ===
include('config.php');

// Initialize a message variable for success/error alerts
$message = '';

// --- File Upload Logic ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['campaign_file'])) {
    $campaign_id = $_POST['campaign_id'];
    $file = $_FILES['campaign_file'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $message = "File upload failed with error code: " . $file['error'];
    } else {
        // Sanitize the filename to prevent directory traversal attacks
        $filename = basename($file['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $filename;

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, file already exists. Please rename your file and try again.";
        } else if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Update the database with the new file path
            $sql_update = "UPDATE campaigns SET file_path = ? WHERE id = ?";
            $stmt = $dms->prepare($sql_update);
            $stmt->bind_param("si", $target_file, $campaign_id);

            if ($stmt->execute()) {
                $message = "The file " . htmlspecialchars($filename) . " has been uploaded and the database has been updated.";
            } else {
                $message = "File uploaded, but database update failed: " . $stmt->error;
                // You may want to delete the uploaded file here to prevent inconsistency
                unlink($target_file);
            }
            $stmt->close();
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}

// --- Fetch Campaign Data ---
// SQL query to fetch campaign details, joining with the events table
// to get the event name instead of just the ID.
$sql_fetch = "
SELECT 
    c.id, 
    c.name, 
    c.descriptions, 
    c.goal_amount, 
    c.start_date, 
    c.end_date, 
    c.status, 
    c.file,
    e.name AS event_name
FROM 
    campaigns c
INNER JOIN 
    events e ON c.event_id = e.id
ORDER BY 
    c.start_date DESC
";
$result = $dms->query($sql_fetch);

$campaigns = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $campaigns[] = $row;
    }
} else {
    $message = "Error fetching campaign data: " . $dms->error;
}

// Close the database connection
$dms->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="p-4">

<div class="container">
    <div class="mb-5 text-center text-md-start">
        <h1 class="fw-bold text-dark">Campaign Dashboard</h1>
        <p class="lead text-muted mt-2">Manage and view all your fundraising campaigns.</p>
    </div>

    <!-- Alert for upload messages -->
    <?php if ($message): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Campaign Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white rounded-4 p-4 pb-0 d-flex justify-content-between align-items-center">
            <h3 class="card-title fw-bold text-dark mb-0">Campaign Details</h3>
            <!-- Button to trigger the upload modal -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-upload me-2"></i>Upload File
            </button>
        </div>
        <div class="card-body p-4 table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Campaign Name</th>
                        <th scope="col">Event</th>
                        <th scope="col">Goal Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($campaigns)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No campaigns found.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($campaigns as $campaign): ?>
                    <tr>
                        <td><?= htmlspecialchars($campaign['name']) ?></td>
                        <td><?= htmlspecialchars($campaign['event_name']) ?></td>
                        <td>$<?= number_format($campaign['goal_amount'], 2) ?></td>
                        <td><span class="badge rounded-pill bg-<?= $campaign['status'] === 'Active' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($campaign['status']) ?></span></td>
                        <td><?= htmlspecialchars($campaign['start_date']) ?></td>
                        <td><?= htmlspecialchars($campaign['end_date']) ?></td>
                        <td>
                            <?php if ($campaign['file_path']): ?>
                                <a href="<?= htmlspecialchars($campaign['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-file-alt"></i> View
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No file</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload a File for a Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="campaign_select" class="form-label">Select Campaign</label>
                        <select class="form-select" id="campaign_select" name="campaign_id" required>
                            <option selected disabled value="">Choose...</option>
                            <?php foreach ($campaigns as $campaign): ?>
                                <option value="<?= htmlspecialchars($campaign['id']) ?>"><?= htmlspecialchars($campaign['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file_input" class="form-label">Choose File</label>
                        <input class="form-control" type="file" id="file_input" name="campaign_file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
