<?php
include 'config.php';

// --- GET LOGGED IN DONOR ---
$donor = null;
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'donor') {
    $donor_id = $_SESSION['user_id'];

    // Fetch donor details from donors table
    $stmt = $dms->prepare("SELECT id, name, contact FROM donors WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $dms->error);
    }
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $donor = [
            'id' => $row['id'],
            'name' => $row['name'],        // donor name
            'contact' => $row['contact']   // donor contact
        ];
    }
}

// --- FETCH DROPDOWN OPTIONS ---
$campaigns = $dms->query("SELECT id, name FROM campaigns WHERE status='active'")->fetch_all(MYSQLI_ASSOC);
$payments  = $dms->query("SELECT id, type FROM payment_methods")->fetch_all(MYSQLI_ASSOC);
$funds     = $dms->query("SELECT id, name FROM funds")->fetch_all(MYSQLI_ASSOC);
$pledges   = $dms->query("SELECT id, name FROM pledges")->fetch_all(MYSQLI_ASSOC);

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$donor) {
        echo "<div class='alert alert-danger'>You must be logged in as a donor to submit a donation.</div>";
    } else {
        $campaign_id = intval($_POST['campaign_id'] ?? 0);
        $payment_id  = intval($_POST['payment_id'] ?? 0);
        $fund_id     = intval($_POST['fund_id'] ?? 0);
        $pledge_id   = !empty($_POST['pledge_id']) ? intval($_POST['pledge_id']) : null;
        $amount      = floatval($_POST['amount'] ?? 0);

        if ($campaign_id && $payment_id && $fund_id && $amount > 0) {

            // --- GET PAYMENT TYPE ---
            $ptypeStmt = $dms->prepare("SELECT type FROM payment_methods WHERE id = ?");
            if (!$ptypeStmt) die("Payment prepare failed: " . $dms->error);
            $ptypeStmt->bind_param("i", $payment_id);
            $ptypeStmt->execute();
            $ptypeRes = $ptypeStmt->get_result();
            $ptypeRow = $ptypeRes->fetch_assoc();
            $payment_type = $ptypeRow['type'] ?? '';
            $ptypeStmt->close();

            // --- STATUS ---
            $status = ($payment_type === 'Cash' || $payment_type === 'Check') ? 'Verified' : 'Pending';

            $date = date('Y-m-d H:i:s');

            // --- INSERT DONATION ---
            if ($pledge_id === null) {
                $stmt = $dms->prepare("INSERT INTO donations (donor_id, name, campaign_id, payment_id, fund_id, amount, donation_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt) die("Prepare failed: " . $dms->error);
                $stmt->bind_param("isiiids", $donor['id'], $donor['name'], $campaign_id, $payment_id, $fund_id, $amount, $date, $status);
            } else {
                $stmt = $dms->prepare("INSERT INTO donations (donor_id, name, campaign_id, payment_id, fund_id, pledge_id, amount, donation_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt) die("Prepare failed: " . $dms->error);
                $stmt->bind_param("isiiiids", $donor['id'], $donor['name'], $campaign_id, $payment_id, $fund_id, $pledge_id, $amount, $date, $status);
            }

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Donation from <strong>" . htmlspecialchars($donor['name']) . "</strong> (Contact: " . htmlspecialchars($donor['contact']) . ") added successfully! Status: <strong>" . htmlspecialchars($status) . "</strong></div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Please fill all required fields correctly.</div>";
        }
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

        <?php if (!$donor): ?>
            <div class="alert alert-danger text-center">
                You must be logged in as a donor to add a donation.
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Donor Name</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($donor['name'] . ' | ' . $donor['contact']) ?>" readonly>
                    <input type="hidden" name="donor_id" value="<?= htmlspecialchars($donor['id']) ?>">
                    <input type="hidden" name="donor_name" value="<?= htmlspecialchars($donor['name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Campaign</label>
                    <select class="form-select" name="campaign_id" required>
                        <option value="">-- Select Campaign --</option>
                        <?php foreach ($campaigns as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select" name="payment_id" required>
                        <option value="">-- Select Payment --</option>
                        <?php foreach ($payments as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['type']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fund</label>
                    <select class="form-select" name="fund_id" required>
                        <option value="">-- Select Fund --</option>
                        <?php foreach ($funds as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pledge (optional)</label>
                    <select class="form-select" name="pledge_id">
                        <option value="">-- No Pledge --</option>
                        <?php foreach ($pledges as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" class="form-control" name="amount" min="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Donation</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
