<?php
include('config.php');


$errors = [];
$success = false;

// Fetch donors and campaigns for dropdowns
$donors = $mysqli->query("SELECT donor_id, donor_name FROM donors ORDER BY donor_name");
$campaigns = $mysqli->query("SELECT campaign_id, campaign_name FROM campaigns ORDER BY campaign_name");

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_id = $_POST['donor_id'] ?? '';
    $campaign_id = $_POST['campaign_id'] ?? '';
    $pledge_amount = $_POST['pledge_amount'] ?? '';
    $pledge_date = $_POST['pledge_date'] ?? '';
    $expected_date = $_POST['expected_date'] ?? '';
    $status = $_POST['status'] ?? 'Pending';
    $notes = $_POST['notes'] ?? '';

    // Simple validation
    if (!$donor_id) $errors[] = "Please select a donor.";
    if (!$campaign_id) $errors[] = "Please select a campaign.";
    if (!$pledge_amount || !is_numeric($pledge_amount) || $pledge_amount <= 0) $errors[] = "Please enter a valid pledge amount.";
    if (!$pledge_date) $errors[] = "Please select a pledge date.";
    if (!$expected_date) $errors[] = "Please select an expected fulfillment date.";

    if (empty($errors)) {



      .
      
        $stmt = $mysqli->prepare("INSERT INTO pledges (donor_id, campaign_id, pledge_amount, pledge_date, expected_date, status, fulfilled_amount, notes) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
        $stmt->bind_param("iiddsss", $donor_id, $campaign_id, $pledge_amount, $pledge_date, $expected_date, $status, $notes);
        $stmt->execute();
        $stmt->close();
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add New Pledge</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container my-5">
    <h1 class="mb-4">Add New Pledge</h1>

    <?php if ($success): ?>
      <div class="alert alert-success">Pledge added successfully! <a href="manage_pledges.php">Go to Manage Pledges</a></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="add_pledge.php" novalidate>
      <div class="mb-3">
        <label for="donor_id" class="form-label">Donor</label>
        <select class="form-select" id="donor_id" name="donor_id" required>
          <option value="" disabled selected>Select a donor</option>
          <?php while ($donor = $donors->fetch_assoc()): ?>
            <option value="<?= $donor['donor_id'] ?>" <?= (isset($_POST['donor_id']) && $_POST['donor_id'] == $donor['donor_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($donor['donor_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="campaign_id" class="form-label">Campaign</label>
        <select class="form-select" id="campaign_id" name="campaign_id" required>
          <option value="" disabled selected>Select a campaign</option>
          <?php while ($campaign = $campaigns->fetch_assoc()): ?>
            <option value="<?= $campaign['campaign_id'] ?>" <?= (isset($_POST['campaign_id']) && $_POST['campaign_id'] == $campaign['campaign_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($campaign['campaign_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="pledge_amount" class="form-label">Pledge Amount ($)</label>
        <input
          type="number"
          class="form-control"
          id="pledge_amount"
          name="pledge_amount"
          min="0.01"
          step="0.01"
          required
          value="<?= htmlspecialchars($_POST['pledge_amount'] ?? '') ?>"
        />
      </div>

      <div class="mb-3">
        <label for="pledge_date" class="form-label">Pledge Date</label>
        <input
          type="date"
          class="form-control"
          id="pledge_date"
          name="pledge_date"
          required
          value="<?= htmlspecialchars($_POST['pledge_date'] ?? '') ?>"
        />
      </div>

      <div class="mb-3">
        <label for="expected_date" class="form-label">Expected Fulfillment Date</label>
        <input
          type="date"
          class="form-control"
          id="expected_date"
          name="expected_date"
          required
          value="<?= htmlspecialchars($_POST['expected_date'] ?? '') ?>"
        />
      </div>

      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
          <?php
            $statuses = ['Pending', 'Completed', 'Cancelled'];
            $selectedStatus = $_POST['status'] ?? 'Pending';
            foreach ($statuses as $st):
          ?>
            <option value="<?= $st ?>" <?= ($selectedStatus === $st) ? 'selected' : '' ?>><?= $st ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="notes" class="form-label">Notes (optional)</label>
        <textarea class="form-control" id="notes" name="notes" rows="3"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add Pledge</button>
      <a href="manage_pledges.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
