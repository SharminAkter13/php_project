<?php
include 'config.php';

// --- GET LOGGED IN USER INFO ---
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;
$logged_in_donor_id = null;

if ($user_role === 'donor') {
    $stmt = $dms->prepare("SELECT id FROM donors WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $donor_row = $result->fetch_assoc();
    $logged_in_donor_id = $donor_row['id'] ?? null;
    $stmt->close();
}

// --- FETCH CAMPAIGNS for filter ---
$campaigns = $dms->query("SELECT id, name FROM campaigns ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

// Handle AJAX request to fetch filtered data
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    $start_date = $_GET['start_date'] ?? null;
    $end_date = $_GET['end_date'] ?? null;
    $campaign_id = $_GET['campaign_id'] ?? 'all';

    $params = [];
    $types = "";
    $whereClauses = [];

    if ($user_role === 'donor' && $logged_in_donor_id) {
        $whereClauses[] = "d.donor_id = ?";
        $types .= "i";
        $params[] = $logged_in_donor_id;
    }

    if ($start_date) {
        $whereClauses[] = "t.date >= ?";
        $types .= "s";
        $params[] = $start_date;
    }
    if ($end_date) {
        $whereClauses[] = "t.date <= ?";
        $types .= "s";
        $params[] = $end_date;
    }
    if ($campaign_id !== 'all') {
        $whereClauses[] = "c.id = ?";
        $types .= "i";
        $params[] = intval($campaign_id);
    }

    $whereSql = "";
    if ($whereClauses) {
        $whereSql = "WHERE " . implode(" AND ", $whereClauses);
    }

    // Group donations by campaign, sum amount
    $sql = "
        SELECT 
            c.id as campaign_id,
            c.name as campaign_name,
            SUM(t.amount) as total_amount
        FROM transactions t
        JOIN donations d ON t.id = d.id
        JOIN campaigns c ON t.campaign_id = c.id
        $whereSql
        GROUP BY c.id, c.name
        ORDER BY total_amount DESC
    ";

    $stmt = $dms->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Calculate total donations in filtered set
    $totalDonations = 0;
    foreach ($data as $row) {
        $totalDonations += floatval($row['total_amount']);
    }

    // Return JSON
    header('Content-Type: application/json');
    echo json_encode([
        'data' => $data,
        'totalDonations' => $totalDonations
    ]);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Transactions Overview with Filters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h2 class="mb-4 text-center">Transactions Overview</h2>

        <!-- Filters -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" />
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" />
            </div>
            <div class="col-md-4">
                <label for="campaign_id" class="form-label">Campaign</label>
                <select id="campaign_id" name="campaign_id" class="form-select">
                    <option value="all" selected>All Campaigns</option>
                    <?php foreach ($campaigns as $camp): ?>
                        <option value="<?= $camp['id'] ?>"><?= htmlspecialchars($camp['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Summary -->
        <div class="mb-3">
            <h5>Total Donations: $<span id="totalDonations">0.00</span></h5>
        </div>

        <!-- Chart -->
        <canvas id="transactionsChart" height="120"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('transactionsChart').getContext('2d');
    let chart = null;

    // Initialize empty chart
    function initChart(labels = [], data = []) {
        if (chart) {
            chart.destroy();
        }
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Donation Amount ($)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: ctx => '$' + ctx.parsed.y.toFixed(2)
                        }
                    }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Campaign' },
                        ticks: { maxRotation: 90, minRotation: 45, autoSkip: false }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Amount ($)' }
                    }
                }
            }
        });
    }

    // Fetch data from server with filters
    async function fetchData() {
        const formData = new FormData(document.getElementById('filterForm'));
        const params = new URLSearchParams(formData);
        params.append('ajax', '1');

        const response = await fetch(`?${params.toString()}`);
        const json = await response.json();

        // Update summary total
        document.getElementById('totalDonations').textContent = json.totalDonations.toFixed(2);

        // Prepare chart data
        const labels = json.data.map(item => item.campaign_name);
        const data = json.data.map(item => parseFloat(item.total_amount));

        initChart(labels, data);
    }

    // Initial fetch
    fetchData();

    // Update chart on filter change (with debounce)
    let debounceTimer = null;
    document.getElementById('filterForm').addEventListener('change', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchData, 300);
    });
});
</script>

</body>
</html>
