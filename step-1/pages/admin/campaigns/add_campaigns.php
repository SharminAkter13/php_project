<?php
include('config.php'); // Must have $dms = mysqli_connect(...) inside

$message = "";

// Fetch events for the dropdown
$events = [];
$eventQuery = "SELECT id, name FROM events"; 
$result = mysqli_query($dms, $eventQuery);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $goal_amount = (float)$_POST['goal_amount'];
    $start_date = $_POST['start_date'];
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $event_id = (int)$_POST['event_id'];

    // Handle file upload
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = $target_dir . basename($_FILES["image"]["name"]);
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
            $message = "❌ Error uploading file.";
        }
    }

    if (empty($message)) {
        $query = "INSERT INTO campaigns 
                  (name, descriptions, goal_amount, start_date, end_date, event_id, image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($dms, $query);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "ssdssis",
                $name,
                $description,
                $goal_amount,
                $start_date,
                $end_date,
                $event_id,
                $image_path
            );

            if (mysqli_stmt_execute($stmt)) {
                $message = "✅ Campaign added successfully!";
            } else {
                $message = "❌ Error executing statement: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "❌ SQL Prepare failed: " . mysqli_error($dms);
        }
    }
}

mysqli_close($dms);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Campaign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
        }
        .fw-bold {
            font-weight: 700 !important;
        }
    </style>
</head>
<body>

<div class="container-fluid mt-4 p-5">
     <div class="row">
         <div class="col-md-9 offset-md-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold"><i class="bi bi-megaphone"></i> Add New Campaign</h4>
            </div>

            <!-- Display Message -->
            <?php if (!empty($message)): ?>
                <div class="alert <?= strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success' ?>" role="alert">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- Add Campaign Form -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-12">
                            <label for="campaignName" class="form-label">Campaign Name</label>
                            <input type="text" class="form-control" id="campaignName" name="name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="campaignDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="campaignDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="goalAmount" class="form-label">Goal Amount ($)</label>
                            <input type="number" step="0.01" class="form-control" id="goalAmount" name="goal_amount" required>
                        </div>
                        <div class="col-md-6">
                            <label for="eventID" class="form-label">Event</label>
                            <select id="eventID" name="event_id" class="form-control">
                                <option value="">-- Select Event --</option>
                                <?php foreach ($events as $event): ?>
                                    <option value="<?= htmlspecialchars($event['id']) ?>"><?= htmlspecialchars($event['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="end_date">
                        </div>
                        <div class="col-md-12">
                            <label for="campaignImage" class="form-label">Campaign Image</label>
                            <input class="form-control" type="file" id="campaignImage" name="image">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Add Campaign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
