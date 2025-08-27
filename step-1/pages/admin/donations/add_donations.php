<?php
include 'config.php';

$message = "";

// Fetch dropdown data
function fetchData($dms, $table, $idColumn, $nameColumn) {
    $data = [];
    $sql = "SELECT $idColumn, $nameColumn FROM `$table` ORDER BY $nameColumn ASC";
    $result = $dms->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

$payments = fetchData($dms, 'payment_methods', 'id', 'type');
$funds = fetchData($dms, 'funds', 'id', 'name');
$donors = fetchData($dms, 'donors', 'id', 'name');
$pledges = fetchData($dms, 'pledges', 'id', 'name');
$campaigns = fetchData($dms, 'campaigns', 'id', 'name');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $dms->real_escape_string(trim($_POST['name']));
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
    if ($amount === false) {
        $message = "<div class='alert alert-danger'>Invalid amount</div>";
    }
    $date = $dms->real_escape_string(trim($_POST['date']));
    $payment_id = filter_var($_POST['payment_id'], FILTER_VALIDATE_INT);
    $fund_id = filter_var($_POST['fund_id'], FILTER_VALIDATE_INT);
    $donor_id = filter_var($_POST['donor_id'], FILTER_VALIDATE_INT);
    $pledge_id = empty($_POST['pledge_id']) ? NULL : filter_var($_POST['pledge_id'], FILTER_VALIDATE_INT);
    $campaign_id = empty($_POST['campaign_id']) ? NULL : filter_var($_POST['campaign_id'], FILTER_VALIDATE_INT);

    if ($amount === false || $payment_id === false || $fund_id === false || $donor_id === false) {
        $message = "<div class='alert alert-danger'>Error: Invalid input. Please check your data.</div>";
    } else {
        $sql = "INSERT INTO donations (name, amount, date, payment_id, fund_id, donor_id, pledge_id, campaign_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dms->prepare($sql);
        $types = "sdssiiii";
        $stmt->bind_param($types, $name, $amount, $date, $payment_id, $fund_id, $donor_id, $pledge_id, $campaign_id);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Donation added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

$dms->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Donation</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper p-5">
   

    <!-- Content Wrapper -->
    <div class="container-fluid p-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Donate</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">Donation</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="container-fluid">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Donation Form</h3>
                    </div>
                    <div class="card-body">
                        <?= $message ?>
                        <form method="post" action="">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Donation Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control" placeholder="e.g., 150.50" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="donor_id" class="form-label">Donor</label>
                                    <select name="donor_id" id="donor_id" class="form-control" required>
                                        <option value="">Select Donor</option>
                                        <?php foreach ($donors as $donor) : ?>
                                            <option value="<?= htmlspecialchars($donor['id']) ?>"><?= htmlspecialchars($donor['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="fund_id" class="form-label">Fund</label>
                                    <select name="fund_id" id="fund_id" class="form-control" required>
                                        <option value="">Select Fund</option>
                                        <?php foreach ($funds as $fund) : ?>
                                            <option value="<?= htmlspecialchars($fund['id']) ?>"><?= htmlspecialchars($fund['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="payment_id" class="form-label">Payment Method</label>
                                    <select name="payment_id" id="payment_id" class="form-control" required>
                                        <option value="">Select Payment</option>
                                        <?php foreach ($payments as $payment) : ?>
                                            <option value="<?= htmlspecialchars($payment['id']) ?>"><?= htmlspecialchars($payment['type']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="pledge_id" class="form-label">Pledge (Optional)</label>
                                    <select name="pledge_id" id="pledge_id" class="form-control">
                                        <option value="">None</option>
                                        <?php foreach ($pledges as $pledge) : ?>
                                            <option value="<?= htmlspecialchars($pledge['id']) ?>"><?= htmlspecialchars($pledge['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="campaign_id" class="form-label">Campaign (Optional)</label>
                                    <select name="campaign_id" id="campaign_id" class="form-control">
                                        <option value="">None</option>
                                        <?php foreach ($campaigns as $campaign) : ?>
                                            <option value="<?= htmlspecialchars($campaign['id']) ?>"><?= htmlspecialchars($campaign['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i> Add Donation</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
