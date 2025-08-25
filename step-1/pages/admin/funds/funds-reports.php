<?php
// Include the database connection script
include 'config.php';

// Set the content type header to application/json
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'An unknown error occurred.',
    'data' => []
];

try {
    // Query 1: Get the total sum of all collected amounts
    $totalFundsQuery = "SELECT SUM(collected_amount) AS total_funds FROM funds";
    $totalFundsResult = $connection->query($totalFundsQuery);
    $totalFundsRow = $totalFundsResult->fetch_assoc();
    $totalFunds = $totalFundsRow['total_funds'] ?? 0;

    // Query 2: Get the total count of campaigns
    $totalCampaignsQuery = "SELECT COUNT(*) AS total_campaigns FROM funds";
    $totalCampaignsResult = $connection->query($totalCampaignsQuery);
    $totalCampaignsRow = $totalCampaignsResult->fetch_assoc();
    $totalCampaigns = $totalCampaignsRow['total_campaigns'] ?? 0;

    // Query 3: Get counts of funds by status (e.g., 'Active', 'Inactive')
    $statusQuery = "SELECT status, COUNT(*) AS count FROM funds GROUP BY status";
    $statusResult = $connection->query($statusQuery);
    $statusData = [];
    while ($row = $statusResult->fetch_assoc()) {
        $statusData[] = $row;
    }

    // Query 4: Get data for each individual fund for a bar chart
    $fundDetailsQuery = "SELECT name, collected_amount FROM funds ORDER BY collected_amount DESC";
    $fundDetailsResult = $connection->query($fundDetailsQuery);
    $fundDetailsData = [];
    while ($row = $fundDetailsResult->fetch_assoc()) {
        $fundDetailsData[] = $row;
    }

    // Prepare the final response data
    $response['success'] = true;
    $response['message'] = 'Data fetched successfully.';
    $response['data'] = [
        'totalFunds' => $totalFunds,
        'totalCampaigns' => $totalCampaigns,
        'statusData' => $statusData,
        'fundDetailsData' => $fundDetailsData
    ];

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Close the database connection
$connection->close();

// Send the JSON response back to the client
echo json_encode($response);
?>
