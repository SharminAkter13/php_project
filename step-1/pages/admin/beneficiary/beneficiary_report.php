<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary Reports - Donation Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">



<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 offset-md-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary">Beneficiary Reports</h3>
                <button class="btn btn-success"><i class="bi bi-download"></i> Export Report</button>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Beneficiaries</h6>
                            <h4 class="fw-bold">256</h4>
                            <i class="bi bi-people text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Donations Given</h6>
                            <h4 class="fw-bold">$85,430</h4>
                            <i class="bi bi-cash-stack text-success fs-3"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Active Programs</h6>
                            <h4 class="fw-bold">12</h4>
                            <i class="bi bi-clipboard-data text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Beneficiary Name</label>
                            <input type="text" class="form-control" placeholder="Enter name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Program</label>
                            <select class="form-select">
                                <option value="">All</option>
                                <option>Education Support</option>
                                <option>Medical Aid</option>
                                <option>Food Distribution</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date Range</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-12 text-end">
                            <button class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Program</th>
                                <th>Donation Amount</th>
                                <th>Date Provided</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Rahim Uddin</td>
                                <td>Food Distribution</td>
                                <td>$100</td>
                                <td>2025-07-10</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Ayesha Begum</td>
                                <td>Medical Aid</td>
                                <td>$250</td>
                                <td>2025-07-15</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Karim Ali</td>
                                <td>Education Support</td>
                                <td>$500</td>
                                <td>2025-07-20</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
