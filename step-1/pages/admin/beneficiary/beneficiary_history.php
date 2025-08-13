<!-- beneficiary_history.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="container-fluid mt-4 p-5">
     <div class="row">
        <div class="col-md-9 offset-md-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold"><i class="bi bi-clock-history"></i> Beneficiary History</h4>
                <button class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Beneficiary</button>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Beneficiaries</h6>
                            <h3 class="fw-bold text-primary">150</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Active</h6>
                            <h3 class="fw-bold text-success">120</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Inactive</h6>
                            <h3 class="fw-bold text-danger">30</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Donations Given</h6>
                            <h3 class="fw-bold text-warning">$12,500</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Search by name or ID">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option value="">Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" placeholder="From Date">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- History Table -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle ">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Beneficiary Name</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Last Donation Date</th>
                                    <th>Total Donations</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>+880 1234 567890</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2025-08-01</td>
                                    <td>$500</td>
                                    <td>Regular monthly support</td>
                                    <td >
                                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                  
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>+880 9876 543210</td>
                                    <td><span class="badge bg-danger">Inactive</span></td>
                                    <td>2025-07-15</td>
                                    <td>$250</td>
                                    <td>Support stopped</td>
                                    <td>
                                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <!-- More rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
