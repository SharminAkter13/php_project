<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Campaign Reports Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container-fluid mt-3 p-5">
    <div class="row">
        <div class="col-md-9 mx-auto">
            <h1 class="mb-4">Campaign Reports Dashboard</h1>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Campaigns</h5>
                    <h2 class="card-text" id="totalCampaigns">12</h2>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Active Campaigns</h5>
                    <h2 class="card-text" id="activeCampaigns">7</h2>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Funds Raised</h5>
                    <h2 class="card-text" id="fundsRaised">$43,800</h2>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Donors</h5>
                    <h2 class="card-text" id="totalDonors">214</h2>
                </div>
                </div>
            </div>
            </div>

            <!-- Filter Section -->
            <div class="row mb-3">
            <div class="col-md-4">
                <label for="filterStatus" class="form-label">Filter by Status</label>
                <select id="filterStatus" class="form-select">
                <option value="all" selected>All</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="filterDate" class="form-label">Filter by Date</label>
                <input type="month" id="filterDate" class="form-control" />
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button id="clearFilters" class="btn btn-outline-secondary w-100">Clear Filters</button>
            </div>
            </div>

            <!-- Campaigns Table -->
            <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Campaign Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Funds Raised</th>
                    <th>Donors</th>
                </tr>
                </thead>
                <tbody id="campaignTableBody">
                <tr>
                    <td>Education for All</td>
                    <td>2025-01-10</td>
                    <td>2025-04-10</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>$12,500</td>
                    <td>70</td>
                </tr>
                <tr>
                    <td>Clean Water Project</td>
                    <td>2024-08-01</td>
                    <td>2024-12-01</td>
                    <td><span class="badge bg-secondary">Completed</span></td>
                    <td>$18,300</td>
                    <td>95</td>
                </tr>
                <tr>
                    <td>Health Awareness</td>
                    <td>2025-05-15</td>
                    <td>2025-08-15</td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                    <td>$0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Food for Hunger</td>
                    <td>2025-02-20</td>
                    <td>2025-05-20</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>$13,000</td>
                    <td>49</td>
                </tr>
                <!-- Add more rows as needed -->
                </tbody>
            </table>
            </div>
        </div>
    </div>
  </div>

  <script>
    const filterStatus = document.getElementById('filterStatus');
    const filterDate = document.getElementById('filterDate');
    const clearFilters = document.getElementById('clearFilters');
    const tableBody = document.getElementById('campaignTableBody');

    function filterTable() {
      const status = filterStatus.value;
      const date = filterDate.value; // format: YYYY-MM

      for (let row of tableBody.rows) {
        let rowStatus = row.cells[3].innerText.toLowerCase();
        let rowStartDate = row.cells[1].innerText; // YYYY-MM-DD
        let show = true;

        if (status !== 'all' && rowStatus !== status) {
          show = false;
        }

        if (date) {
          // Compare only YYYY-MM
          if (!rowStartDate.startsWith(date)) {
            show = false;
          }
        }

        row.style.display = show ? '' : 'none';
      }
    }

    filterStatus.addEventListener('change', filterTable);
    filterDate.addEventListener('change', filterTable);
    clearFilters.addEventListener('click', () => {
      filterStatus.value = 'all';
      filterDate.value = '';
      filterTable();
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
