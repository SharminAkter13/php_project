<?php
// Database connection
include('config.php');

// Initialize data arrays and variables
$beneficiaries = [];
$total_beneficiaries = 0;
$active_beneficiaries = 0;
$inactive_beneficiaries = 0;
$total_donations = 0;

// Assume a table structure with these columns to populate the page
// Fetch all beneficiaries from the DB
$result = mysqli_query($dms, "SELECT id, name, email, phone, required_support, created_at FROM beneficiaries ORDER BY created_at DESC");

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $beneficiaries[] = $row;
    }
}

// // Calculate summary statistics
// $total_beneficiaries = count($beneficiaries);
// foreach ($beneficiaries as $b) {
//     if ($b['status'] === 'Active') {
//         $active_beneficiaries++;
//     } else {
//         $inactive_beneficiaries++;
//     }
//     $total_donations += $b['total_donations'];
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary History</title>
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
                <h4 class="fw-bold"><i class="bi bi-clock-history"></i> Beneficiary History</h4>
                <a href="home.php?page=13" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Beneficiary</a>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Beneficiaries</h6>
                            <h3 class="fw-bold text-primary"><?= $total_beneficiaries ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Active</h6>
                            <h3 class="fw-bold text-success"><?= $active_beneficiaries ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Inactive</h6>
                            <h3 class="fw-bold text-danger"><?= $inactive_beneficiaries ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Donations Given</h6>
                            <h3 class="fw-bold text-warning">$<?= number_format($total_donations, 2) ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form class="row g-3" action="" method="get">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="Search by name or ID">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="from_date" placeholder="From Date">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- History Table -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Beneficiary Name</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Last Donation Date</th>
                                    <th>Total Donations</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($beneficiaries)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No beneficiaries found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($beneficiaries as $index => $b): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($b['id']) ?></td>
                                            <td><?= htmlspecialchars($b['name']) ?></td>
                                            <td><?= htmlspecialchars($b['contact']) ?></td>
                                            <td>
                                                <?php
                                                $badge_class = ($b['status'] === 'Active') ? 'bg-success' : 'bg-danger';
                                                echo '<span class="badge ' . $badge_class . '">' . htmlspecialchars($b['status']) . '</span>';
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($b['last_donation_date']) ?></td>
                                            <td>$<?= number_format($b['total_donations'], 2) ?></td>
                                            <td><?= htmlspecialchars($b['notes']) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
