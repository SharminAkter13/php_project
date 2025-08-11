<?php
// // --- DB connection ---
// $mysqli = new mysqli('localhost', 'root', '', 'donation_system');
// if ($mysqli->connect_errno) {
//     die("Failed to connect to MySQL: " . $mysqli->connect_error);
// }

// // --- Handle form submit (Add/Edit) ---
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $pledge_id = $_POST['pledge_id'] ?? '';
//     $donor_id = $_POST['donor_id'];
//     $campaign_id = $_POST['campaign_id'];
//     $pledge_amount = $_POST['pledge_amount'];
//     $pledge_date = $_POST['pledge_date'];
//     $expected_date = $_POST['expected_date'];
//     $status = $_POST['status'];
//     $fulfilled_amount = $_POST['fulfilled_amount'] ?? 0;
//     $notes = $_POST['notes'] ?? '';

//     if ($pledge_id) {
//         // Update existing pledge
//         $stmt = $mysqli->prepare("UPDATE pledges SET donor_id=?, campaign_id=?, pledge_amount=?, pledge_date=?, expected_date=?, status=?, fulfilled_amount=?, notes=? WHERE pledge_id=?");
//         $stmt->bind_param("iiddssddi", $donor_id, $campaign_id, $pledge_amount, $pledge_date, $expected_date, $status, $fulfilled_amount, $notes, $pledge_id);
//         $stmt->execute();
//         $stmt->close();
//     } else {
//         // Insert new pledge
//         $stmt = $mysqli->prepare("INSERT INTO pledges (donor_id, campaign_id, pledge_amount, pledge_date, expected_date, status, fulfilled_amount, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
//         $stmt->bind_param("iiddssds", $donor_id, $campaign_id, $pledge_amount, $pledge_date, $expected_date, $status, $fulfilled_amount, $notes);
//         $stmt->execute();
//         $stmt->close();
//     }
//     header("Location: manage_pledges.php");
//     exit;
// }

// // --- Fetch all pledges ---
// $query = "SELECT p.pledge_id, d.donor_name, c.campaign_name, p.pledge_amount, p.pledge_date, p.expected_date, p.status, p.fulfilled_amount, p.notes, p.donor_id, p.campaign_id
//           FROM pledges p
//           JOIN donors d ON p.donor_id = d.donor_id
//           JOIN campaigns c ON p.campaign_id = c.campaign_id
//           ORDER BY p.pledge_date DESC";
// $result = $mysqli->query($query);

// // --- Fetch donors and campaigns for dropdowns ---
// $donors = $mysqli->query("SELECT donor_id, donor_name FROM donors ORDER BY donor_name");
// $campaigns = $mysqli->query("SELECT campaign_id, campaign_name FROM campaigns ORDER BY campaign_name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Pledges</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container my-4">
    <h1 class="mb-4">Pledge Management</h1>

    <!-- Button trigger modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#pledgeModal" id="addPledgeBtn">
      + Add Pledge
    </button>

    <!-- Pledges Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Donor</th>
            <th>Campaign</th>
            <th>Pledge Amount</th>
            <th>Pledge Date</th>
            <th>Expected Date</th>
            <th>Status</th>
            <th>Fulfilled Amount</th>
            <th>Notes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-pledge='<?php echo json_encode($row); ?>'>
              <td><?= htmlspecialchars($row['donor_name']) ?></td>
              <td><?= htmlspecialchars($row['campaign_name']) ?></td>
              <td>$<?= number_format($row['pledge_amount'], 2) ?></td>
              <td><?= htmlspecialchars($row['pledge_date']) ?></td>
              <td><?= htmlspecialchars($row['expected_date']) ?></td>
              <td>
                <?php
                  $status = $row['status'];
                  $badgeClass = match($status) {
                    'Pending' => 'warning text-dark',
                    'Completed' => 'success',
                    'Cancelled' => 'danger',
                    default => 'secondary',
                  };
                ?>
                <span class="badge bg-<?= $badgeClass ?>"><?= $status ?></span>
              </td>
              <td>$<?= number_format($row['fulfilled_amount'], 2) ?></td>
              <td><?= nl2br(htmlspecialchars($row['notes'])) ?></td>
              <td>
                <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                <a href="delete_pledge.php?id=<?= $row['pledge_id'] ?>" onclick="return confirm('Are you sure to delete this pledge?');" class="btn btn-sm btn-danger">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pledge Modal -->
  <div class="modal fade" id="pledgeModal" tabindex="-1" aria-labelledby="pledgeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="pledgeForm" class="modal-content" method="POST" action="manage_pledges.php">
        <div class="modal-header">
          <h5 class="modal-title" id="pledgeModalLabel">Add Pledge</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="pledge_id" id="pledge_id" />

          <div class="mb-3">
            <label for="donor_id" class="form-label">Donor</label>
            <select name="donor_id" id="donor_id" class="form-select" required>
              <option value="" disabled selected>Select Donor</option>
              <?php while ($donor = $donors->fetch_assoc()): ?>
                <option value="<?= $donor['donor_id'] ?>"><?= htmlspecialchars($donor['donor_name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="campaign_id" class="form-label">Campaign</label>
            <select name="campaign_id" id="campaign_id" class="form-select" required>
              <option value="" disabled selected>Select Campaign</option>
              <?php while ($campaign = $campaigns->fetch_assoc()): ?>
                <option value="<?= $campaign['campaign_id'] ?>"><?= htmlspecialchars($campaign['campaign_name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="pledge_amount" class="form-label">Pledge Amount ($)</label>
            <input type="number" step="0.01" min="0" class="form-control" id="pledge_amount" name="pledge_amount" required />
          </div>

          <div class="mb-3">
            <label for="pledge_date" class="form-label">Pledge Date</label>
            <input type="date" class="form-control" id="pledge_date" name="pledge_date" required />
          </div>

          <div class="mb-3">
            <label for="expected_date" class="form-label">Expected Fulfillment Date</label>
            <input type="date" class="form-control" id="expected_date" name="expected_date" required />
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
              <option value="Pending" selected>Pending</option>
              <option value="Completed">Completed</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="fulfilled_amount" class="form-label">Fulfilled Amount ($)</label>
            <input type="number" step="0.01" min="0" class="form-control" id="fulfilled_amount" name="fulfilled_amount" value="0" />
          </div>

          <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Pledge</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const pledgeModal = new bootstrap.Modal(document.getElementById('pledgeModal'));
    const pledgeForm = document.getElementById('pledgeForm');
    const pledgeModalLabel = document.getElementById('pledgeModalLabel');

    // Add Pledge button resets form
    document.getElementById('addPledgeBtn').addEventListener('click', () => {
      pledgeModalLabel.textContent = 'Add Pledge';
      pledgeForm.reset();
      document.getElementById('pledge_id').value = '';
    });

    // Edit buttons fill form
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        const row = e.target.closest('tr');
        const pledge = JSON.parse(row.getAttribute('data-pledge'));

        pledgeModalLabel.textContent = 'Edit Pledge';

        document.getElementById('pledge_id').value = pledge.pledge_id;
        document.getElementById('donor_id').value = pledge.donor_id;
        document.getElementById('campaign_id').value = pledge.campaign_id;
        document.getElementById('pledge_amount').value = pledge.pledge_amount;
        document.getElementById('pledge_date').value = pledge.pledge_date;
        document.getElementById('expected_date').value = pledge.expected_date;
        document.getElementById('status').value = pledge.status;
        document.getElementById('fulfilled_amount').value = pledge.fulfilled_amount;
        document.getElementById('notes').value = pledge.notes;

        pledgeModal.show();
      });
    });
  </script>
</body>
</html>
