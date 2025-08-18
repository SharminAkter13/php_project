<?php
include('config.php');

// Fetch total donations per event
$sql = "
SELECT e.id, e.name, IFNULL(SUM(d.amount), 0) AS total_donations
FROM events e
LEFT JOIN donations d ON d.campaign_id = e.id
GROUP BY e.id
ORDER BY total_donations DESC
";
$result = $dms->query($sql);

$events = [];
$event_names = [];
$donation_totals = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
        $event_names[] = $row['name'];
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
<title>Event Donation Pyramid</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { padding-top: 60px; }
.sidebar {
    width: 220px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    background-color: #343a40;
    color: white;
    padding-top: 1rem;
}
.content {
    margin-left: 240px;
    padding: 2rem;
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3 class="text-center">Menu</h3>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="home.php" class="nav-link text-white">Home</a></li>
        <li class="nav-item"><a href="events_calendar.php" class="nav-link text-white">Events Calendar</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-white">Event Pyramid</a></li>
    </ul>
</div>

<!-- Main content -->
<div class="content">
    <h1 class="mb-4">Event Donation Pyramid</h1>
    <div class="card">
        <div class="card-header bg-info text-white">Donations per Event</div>
        <div class="card-body">
            <canvas id="pyramidChart" height="400"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('pyramidChart').getContext('2d');
const pyramidChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($event_names) ?>,
        datasets: [{
            label: 'Total Donations ($)',
            data: <?= json_encode($donation_totals) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y', // horizontal bar chart
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
        },
        scales: {
            x: { beginAtZero: true },
            y: { ticks: { autoSkip: false } }
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
