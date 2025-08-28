<?php
include 'config.php';

// --- START SESSION ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- GET LOGGED IN DONOR ---
$donor_id = null;
$donor = null;
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'donor') {
    $donor_id = $_SESSION['user_id'];
    // fetch donor details
    $sql = "SELECT id, name FROM donors WHERE id = ?";
    $stmt = $dms->prepare($sql);
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $donor = $result->fetch_assoc();
    }
}

// --- FETCH FOREIGN KEY OPTIONS ---
$campaigns = $dms->query("SELECT id, name FROM campaigns WHERE status = 'active'")->fetch_all(MYSQLI_ASSOC);
$payments  = $dms->query("SELECT id, type FROM payment_methods")->fetch_all(MYSQLI_ASSOC);
$funds     = $dms->query("SELECT id, name FROM funds")->fetch_all(MYSQLI_ASSOC);
$pledges   = $dms->query("SELECT id, name FROM pledges")->fetch_all(MYSQLI_ASSOC); // title consistent

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_id    = $_POST['donor_id'] ?? null;
    $campaign_id = $_POST['campaign_id'] ?? null;
    $payment_id  = $_POST['payment_id'] ?? null;
    $fund_id     = $_POST['fund_id'] ?? null;
    $pledge_id   = $_POST['pledge_id'] ?? null;
    $amount      = $_POST['amount'] ?? null;
    $date        = date('Y-m-d H:i:s');

    if ($donor_id && $campaign_id && $payment_id && $fund_id && $amount) {
        // allow NULL for pledge
        $sql = "INSERT INTO donations (donor_id, campaign_id, payment_id, fund_id, pledge_id, amount, donation_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dms->prepare($sql);

        // convert empty pledge to null
        $pledge_id_param = !empty($pledge_id) ? $pledge_id : null;

        $stmt->bind_param("iiiiids", $donor_id, $campaign_id, $payment_id, $fund_id, $pledge_id_param, $amount, $date);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Donation added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Please fill all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h2 class="mb-4 text-center">Add Donation</h2>
        <form method="POST">

            <!-- Donor -->
            <div class="mb-3">
                <label class="form-label">Donor Name</label>
                <input type="text" class="form-control" 
                       value="<?= htmlspecialchars($donor['name'] ?? 'Guest') ?>" readonly>
                <input type="hidden" name="donor_id" 
                       value="<?= htmlspecialchars($donor['id'] ?? '') ?>">
            </div>

            <!-- Campaign -->
            <div class="mb-3">
                <label class="form-label">Campaign</label>
                <select class="form-select" name="campaign_id" required>
                    <option value="">-- Select Campaign --</option>
                    <?php foreach ($campaigns as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Payment -->
            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select class="form-select" name="payment_id" required>
                    <option value="">-- Select Payment --</option>
                    <?php foreach ($payments as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['type']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fund -->
            <div class="mb-3">
                <label class="form-label">Fund</label>
                <select class="form-select" name="fund_id" required>
                    <option value="">-- Select Fund --</option>
                    <?php foreach ($funds as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Pledge (nullable) -->
            <div class="mb-3">
                <label class="form-label">Pledge (optional)</label>
                <select class="form-select" name="pledge_id">
                    <option value="">-- No Pledge --</option>
                    <?php foreach ($pledges as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Amount -->
            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" class="form-control" name="amount" min="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Donation</button>
        </form>
    </div>
</div>
</body>
</html>
