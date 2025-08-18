<?php
include('config.php');

// Fetch total donations per event
$sql = "
SELECT e.name AS event_name, IFNULL(SUM(d.amount),0) AS total_donations
FROM events e
LEFT JOIN donations d ON d.campaign_id = e.id
GROUP BY e.id
ORDER BY e.name ASC
";
$result = $dms->query($sql);

$event_names = [];
$donation_totals = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $event_names[] = $row['event_name'];
        $donation_totals[] = $row['total_donations'];
    }
}

$dms->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event Donation Graph</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4">Event Donation History</h1>
    <div class="card">
        <div class="card-header bg-primary text-white">Donations per Event</div>
        <div class="card-body">
            <canvas id="donationChart" height="150"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('donationChart').getContext('2d');
const donationChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($event_names) ?>,
        datasets: [{
            label: 'Total Donations',
            data: <?= json_encode($donation_totals) ?>,
            fill: true,
            backgroundColor: 'rgba(54, 162, 235, 0.3)',
            borderColor: 'rgba(54, 162, 235, 1)',
            tension: 0.4 // smooth curves
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            tooltip: { mode: 'index', intersect: false }
        },
        interaction: {
            mode: 'nearest',
            intersect: false
        },
        scales: {
            y: { beginAtZero: true },
            x: { title: { display: true, text: 'Events' } }
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
