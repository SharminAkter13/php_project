<?php
// add_campaign.php
// Include your database connection if needed
// include('db_connect.php');
?>
<?php
// include 'db_connect.php'; // your DB connection

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $title = $_POST['campaign_title'];
//     $desc = $_POST['campaign_desc'];
//     $target = $_POST['target_amount'];
//     $start = $_POST['start_date'];
//     $end = $_POST['end_date'];
    
//     // Handle Image Upload
//     $imagePath = null;
//     if (!empty($_FILES['campaign_image']['name'])) {
//         $uploadDir = 'uploads/campaigns/';
//         if (!is_dir($uploadDir)) {
//             mkdir($uploadDir, 0777, true);
//         }
//         $imageName = time() . '_' . basename($_FILES['campaign_image']['name']);
//         $targetPath = $uploadDir . $imageName;
        
//         if (move_uploaded_file($_FILES['campaign_image']['tmp_name'], $targetPath)) {
//             $imagePath = $targetPath;
//         }
//     }
    
//     // Save to DB
//     $sql = "INSERT INTO campaigns (title, description, target_amount, start_date, end_date, image_path) 
//             VALUES (?, ?, ?, ?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ssisss", $title, $desc, $target, $start, $end, $imagePath);
    
//     if ($stmt->execute()) {
//         echo "<script>alert('Campaign added successfully!'); window.location='campaign_list.php';</script>";
//     } else {
//         echo "<script>alert('Error adding campaign.'); history.back();</script>";
//     }
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Campaign - Donation Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content-wrapper {
            margin-left: 250px; /* Adjust for sidebar width */
            padding: 20px;
        }
        .card {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Sidebar (optional) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="width: 250px; height: 100vh; position: fixed;">
    <div class="container-fluid flex-column">
        <a class="navbar-brand" href="#">DonorHub</a>
        <ul class="navbar-nav flex-column mt-3 w-100">
            <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="beneficiaries.php" class="nav-link"><i class="bi bi-people me-2"></i> Beneficiaries</a></li>
            <li class="nav-item"><a href="campaigns.php" class="nav-link active"><i class="bi bi-megaphone me-2"></i> Campaigns</a></li>
            <li class="nav-item"><a href="reports.php" class="nav-link"><i class="bi bi-bar-chart me-2"></i> Reports</a></li>
        </ul>
    </div>
</nav>

<!-- Main content -->
<div class="content-wrapper">
    <div class="container-fluid">
        <h2 class="mb-4"><i class="bi bi-megaphone"></i> Add New Campaign</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="save_campaign.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Campaign Name</label>
                            <input type="text" name="campaign_name" class="form-control" placeholder="Enter campaign name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Campaign Type</label>
                            <select name="campaign_type" class="form-select" required>
                                <option value="">Select type</option>
                                <option value="Fundraising">Fundraising</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Emergency Relief">Emergency Relief</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Describe the campaign..." required></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Goal Amount (USD)</label>
                        <input type="number" name="goal_amount" step="0.01" class="form-control" placeholder="Enter target amount" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Campaign Image</label>
                        <input type="file" name="campaign_image" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save Campaign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
