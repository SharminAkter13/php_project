<?php
// Start the session to access session variables and ensure a user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include the database configuration file
include('config.php');

// Define the title of the page for the browser and for the report header
$pageTitle = "Donations Overview Report";

// Initialize error message variable
$error_message = '';

// === SQL Queries to Fetch Report Data ===

// 1. Total Donations Summary
$totalDonationsQuery = "SELECT
    SUM(CASE WHEN t.currency_type = 'Cash' THEN t.amount ELSE 0 END) AS totalCashDonations,
    SUM(CASE WHEN t.currency_type = 'Item' THEN t.amount ELSE 0 END) AS totalItemDonations
FROM donations d
JOIN transactions t ON d.transaction_id = t.id";

$totalDonationsResult = mysqli_query($dms, $totalDonationsQuery);
$donationTotals = ['totalCashDonations' => 0, 'totalItemDonations' => 0];
if ($totalDonationsResult) {
    $donationTotals = mysqli_fetch_assoc($totalDonationsResult);
} else {
    $error_message = "Error fetching donations summary: " . mysqli_error($dms);
}

// 2. Campaign Summary (Total amount raised per campaign)
$campaignSummaryQuery = "SELECT
    c.name,
    SUM(t.amount) AS total_amount_raised,
    COUNT(d.id) AS total_donations
FROM campaigns c
LEFT JOIN donations d ON c.id = d.campaign_id
LEFT JOIN transactions t ON d.transaction_id = t.id
GROUP BY c.id
ORDER BY total_amount_raised DESC";

$campaignSummaryResult = mysqli_query($dms, $campaignSummaryQuery);
$campaigns = [];
if ($campaignSummaryResult) {
    while ($row = mysqli_fetch_assoc($campaignSummaryResult)) {
        $campaigns[] = $row;
    }
} else {
    $error_message .= "<br>Error fetching campaign summary: " . mysqli_error($dms);
}

// 3. Top Donors (Total amount donated per donor)
$topDonorsQuery = "SELECT
    d.name,
    d.email,
    SUM(t.amount) AS total_donated
FROM donors d
JOIN donations don ON d.id = don.donor_id
JOIN transactions t ON don.transaction_id = t.id
GROUP BY d.id
ORDER BY total_donated DESC
LIMIT 10";

$topDonorsResult = mysqli_query($dms, $topDonorsQuery);
$topDonors = [];
if ($topDonorsResult) {
    while ($row = mysqli_fetch_assoc($topDonorsResult)) {
        $topDonors[] = $row;
    }
} else {
    $error_message .= "<br>Error fetching top donors: " . mysqli_error($dms);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .report-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .report-header {
            border-bottom: 2px solid #343a40;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .report-section {
            margin-bottom: 40px;
        }
        .report-section h4 {
            border-left: 4px solid #007bff;
            padding-left: 10px;
            margin-bottom: 20px;
        }
        .print-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .no-print {
                display: none !important;
            }
            .report-container {
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="container my-5 report-container">
    <div class="report-header">
        <h2><i class="fas fa-chart-bar me-2"></i><?= htmlspecialchars($pageTitle) ?></h2>
        <button class="btn btn-primary no-print" onclick="window.print()"><i class="fas fa-print me-2"></i>Print Report</button>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <strong>Database Error:</strong> <?= $error_message ?>
        </div>
    <?php endif; ?>

    <div class="report-section">
        <h4><i class="fas fa-hand-holding-usd me-2"></i>Overall Donation Summary</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Cash Donations</h5>
                                <h1 class="card-text fw-bold">$<?= number_format($donationTotals['totalCashDonations'] ?? 0, 2) ?></h1>
                            </div>
                            <i class="fas fa-dollar-sign fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Item Donations (Value)</h5>
                                <h1 class="card-text fw-bold">$<?= number_format($donationTotals['totalItemDonations'] ?? 0, 2) ?></h1>
                            </div>
                            <i class="fas fa-box-open fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="report-section">
        <h4><i class="fas fa-bullhorn me-2"></i>Campaigns Overview</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Campaign Name</th>
                    <th>Total Donations</th>
                    <th>Total Amount Raised</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $campaign): ?>
                    <tr>
                        <td><?= htmlspecialchars($campaign['name']) ?></td>
                        <td><?= htmlspecialchars($campaign['total_donations'] ?? 0) ?></td>
                        <td>$<?= number_format($campaign['total_amount_raised'] ?? 0, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="report-section">
        <h4><i class="fas fa-user-circle me-2"></i>Top 10 Donors</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Donor Name</th>
                    <th>Email</th>
                    <th>Total Donated</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topDonors as $donor): ?>
                    <tr>
                        <td><?= htmlspecialchars($donor['name']) ?></td>
                        <td><?= htmlspecialchars($donor['email']) ?></td>
                        <td>$<?= number_format($donor['total_donated'] ?? 0, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>