<?php
// include __DIR__ . '/../../../config.php';
include('config.php');

// Fetch donors
$donors = $dms->query("SELECT id, full_name FROM donors");
// Fetch campaigns
$campaigns = $dms->query("SELECT id, campaign_name FROM campaigns");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name         = trim($_POST['name']);
    $pledge_amount= floatval($_POST['pledge_amount']);
    $pledge_date  = $_POST['pledge_date'];
    $status       = $_POST['status'];
    $donor_id     = intval($_POST['donor_id']);
    $campaign_id  = intval($_POST['campaign_id']);

    $stmt = $dms->prepare("INSERT INTO donations 
        (name, pledge_amount, pledge_date, status, donor_id, campaign_id) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssii", $name, $pledge_amount, $pledge_date, $status, $donor_id, $campaign_id);
    $stmt->execute();

    header("Location: manage_pledges.php"); 
    exit;
}
?>

<!-- Page Content Wrapper -->
<div class="content-wrapper">
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add New Pledge</h1>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="post">
                        <!-- Pledge Name -->
                        <div class="mb-3">
                            <label class="form-label">Pledge Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label class="form-label">Pledge Amount</label>
                            <input type="number" step="0.01" name="pledge_amount" class="form-control" required>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label class="form-label">Pledge Date</label>
                            <input type="datetime-local" name="pledge_date" class="form-control" required>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <!-- Donor -->
                        <div class="mb-3">
                            <label class="form-label">Select Donor</label>
                            <select name="donor_id" class="form-control" required>
                                <option value="">-- Choose Donor --</option>
                                <?php while($d = $donors->fetch_assoc()): ?>
                                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Campaign -->
                        <div class="mb-3">
                            <label class="form-label">Select Campaign</label>
                            <select name="campaign_id" class="form-control" required>
                                <option value="">-- Choose Campaign --</option>
                                <?php while($c = $campaigns->fetch_assoc()): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">Save Pledge</button>
                        <a href="manage_pledges.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
