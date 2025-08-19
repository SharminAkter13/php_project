<!-- header  -->
<?php
include("include/admin/header.php")
?>
<!-- /.header -->


<!-- Navbar  -->
<?php
include("include/admin/nav.php")
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php
include("include/admin/sidebar.php")
?>
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
<?php
    include("placeholder.php");
?>

  </div>
  <!-- /.card -->

</section>
</div>
<!-- /.content-wrapper -->

<!-- ./Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 p-5">
          <h1 class="m-0">Dashboard </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
<?php
include('config.php'); // your db connection

// Fetch totals (adjust table/column names as per your DB)
$totalUsers = $dms->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$totalVolunteers = $dms->query("
    SELECT COUNT(*) as c 
    FROM users u
    JOIN roles r ON u.role_id = r.id
    WHERE r.name = 'volunteer'
")->fetch_assoc()['c'];
$totalBeneficiaries = $dms->query("SELECT COUNT(*) as c FROM beneficiaries")->fetch_assoc()['c'];
$totalCampaigns = $dms->query("SELECT COUNT(*) as c FROM campaigns")->fetch_assoc()['c'];
$totalEvents = $dms->query("SELECT COUNT(*) as c FROM events")->fetch_assoc()['c'];
$totalDonations = $dms->query("SELECT SUM(amount) as s FROM donations")->fetch_assoc()['s'] ?? 0;
$totalPledges = $dms->query("SELECT SUM(pledge_amount) as s FROM pledges")->fetch_assoc()['s'] ?? 0;
function getTotal($dms, $sql) {
    $res = $dms->query($sql);
    if ($res) {
        return $res->fetch_assoc()['c'] ?? 0;
    } else {
        echo "SQL Error: " . $dms->error;
        return 0;
    }
}

$totalUsers = getTotal($dms, "SELECT COUNT(*) as c FROM users");
$totalVolunteers = getTotal($dms, "SELECT COUNT(*) as c FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name = 'volunteer'");
$totalBeneficiaries = getTotal($dms, "SELECT COUNT(*) as c FROM beneficiaries");
$totalCampaigns = getTotal($dms, "SELECT COUNT(*) as c FROM campaigns");
$totalEvents = getTotal($dms, "SELECT COUNT(*) as c FROM events");
$totalDonations = $dms->query("SELECT SUM(amount) as s FROM donations")->fetch_assoc()['s'] ?? 0;
$totalPledges = $dms->query("SELECT SUM(pledge_amount) as s FROM pledges")->fetch_assoc()['s'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donation Management - Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <style>
    body { background-color:#f8f9fa; }
    .card { border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    .dashboard-header { margin-bottom:30px; }
    table th, table td { vertical-align: middle; }
  </style>
</head>
<body>
<div class="container-fluid p-4">

  <div class="dashboard-header text-center mb-4">
    <h2 class="fw-bold">Donation Management - Admin Dashboard</h2>
    <p class="text-muted">Overview of Users, Volunteers, Beneficiaries, Campaigns, Events, Donations & Pledges</p>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4">
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-people fs-2 text-primary"></i><h6>Users</h6><h4><?= $totalUsers ?></h4></div></div>
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-person-heart fs-2 text-success"></i><h6>Volunteers</h6><h4><?= $totalVolunteers ?></h4></div></div>
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-hand-thumbs-up fs-2 text-warning"></i><h6>Beneficiaries</h6><h4><?= $totalBeneficiaries ?></h4></div></div>
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-megaphone fs-2 text-info"></i><h6>Campaigns</h6><h4><?= $totalCampaigns ?></h4></div></div>
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-calendar-event fs-2 text-danger"></i><h6>Events</h6><h4><?= $totalEvents ?></h4></div></div>
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-cash-coin fs-2 text-success"></i><h6>Donations</h6><h4>$<?= $totalDonations ?></h4></div></div>
    <div class="col-md-2 col-6"><div class="card text-center p-3 bg-light"><i class="bi bi-journal-check fs-2 text-dark"></i><h6>Pledges</h6><h4>$<?= $totalPledges ?></h4></div></div>
  </div>

  <!-- Charts -->
  <div class="row mt-4 g-4">
    <div class="col-md-6"><div class="card p-3"><h6>Donations Overview</h6><canvas id="donationChart"></canvas></div></div>
    <div class="col-md-6"><div class="card p-3"><h6>Campaign Status</h6><canvas id="campaignChart"></canvas></div></div>
    <div class="col-md-6"><div class="card p-3"><h6>Events Participation</h6><canvas id="eventChart"></canvas></div></div>
    <div class="col-md-6"><div class="card p-3"><h6>Beneficiaries Served</h6><canvas id="beneficiaryChart"></canvas></div></div>
    <div class="col-md-6"><div class="card p-3"><h6>Pledges vs Donations</h6><canvas id="pledgeChart"></canvas></div></div>
  </div>

  <!-- Overview Table -->
  <div class="row mt-5">
    <div class="col-12">
      <div class="card p-3">
        <h5 class="mb-3">System Overview</h5>
        <table class="table table-bordered table-striped text-center">
          <thead class="table-dark">
            <tr>
              <th>Users</th>
              <th>Volunteers</th>
              <th>Beneficiaries</th>
              <th>Campaigns</th>
              <th>Events</th>
              <th>Donations ($)</th>
              <th>Pledges ($)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $totalUsers ?></td>
              <td><?= $totalVolunteers ?></td>
              <td><?= $totalBeneficiaries ?></td>
              <td><?= $totalCampaigns ?></td>
              <td><?= $totalEvents ?></td>
              <td><?= $totalDonations ?></td>
              <td><?= $totalPledges ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
  // Donations line chart
  new Chart(document.getElementById('donationChart'), {
    type:'line',
    data:{labels:['Jan','Feb','Mar','Apr','May','Jun'],datasets:[{label:'Donations ($)',data:<?= json_encode($donationData) ?>,borderColor:'blue',backgroundColor:'rgba(54,162,235,0.2)',fill:true,tension:0.3}]}
  });

  // Campaign status
  new Chart(document.getElementById('campaignChart'), {
    type:'doughnut',
    data:{labels:['Active','Completed','Upcoming'],datasets:[{data:[<?= $campaignStatus['active'] ?>,<?= $campaignStatus['completed'] ?>,<?= $campaignStatus['upcoming'] ?>],backgroundColor:['#0d6efd','#198754','#ffc107']}]}
  });

  // Event participation
  new Chart(document.getElementById('eventChart'), {
    type:'bar',
    data:{labels:['Event 1','Event 2','Event 3','Event 4'],datasets:[{label:'Participants',data:<?= json_encode($eventParticipation) ?>,backgroundColor:'rgba(255,99,132,0.7)'}]}
  });

  // Beneficiaries served
  new Chart(document.getElementById('beneficiaryChart'), {
    type:'bar',
    data:{labels:['Campaign 1','Campaign 2','Campaign 3','Campaign 4'],datasets:[{label:'Beneficiaries',data:<?= json_encode($beneficiariesServed) ?>,backgroundColor:'rgba(75,192,192,0.7)'}]}
  });

  // Pledges vs Donations
  new Chart(document.getElementById('pledgeChart'), {
    type:'pie',
    data:{labels:['Pledges','Donations'],datasets:[{data:[<?= $pledgeVsDonation['pledges'] ?>,<?= $pledgeVsDonation['donations'] ?>],backgroundColor:['#6c757d','#28a745']}]}
  });
</script>

</body>
</html>
<!-- Main Footer -->
<?php
include("include/admin/footer.php");
?>

<!-- Main Footer -->