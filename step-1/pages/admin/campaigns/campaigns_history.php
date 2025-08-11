<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Campaign History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container-fluid p-5 my-4">
    <div class="row">
        <div class="col-md-9 offset-md-3">
            <h1 class="mb-4">Campaign History</h1>

            <!-- Search and Filter -->
            <div class="row mb-3 g-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by campaign name..." />
            </div>
            <div class="col-md-4">
                <input type="month" id="filterMonth" class="form-control" />
            </div>
            <div class="col-md-2">
                <button id="clearFilters" class="btn btn-outline-secondary w-100">Clear</button>
            </div>
       

    <!-- Campaign History Table -->
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
                <tbody id="campaignHistoryBody">
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
                    <td>2023-05-15</td>
                    <td>2023-08-15</td>
                    <td><span class="badge bg-secondary">Completed</span></td>
                    <td>$9,100</td>
                    <td>40</td>
                </tr>
                <tr>
                    <td>Food for Hunger</td>
                    <td>2022-02-20</td>
                    <td>2022-05-20</td>
                    <td><span class="badge bg-secondary">Completed</span></td>
                    <td>$15,200</td>
                    <td>80</td>
                </tr>
                <!-- More rows -->
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>

  <script>
    const searchInput = document.getElementById('searchInput');
    const filterMonth = document.getElementById('filterMonth');
    const clearFilters = document.getElementById('clearFilters');
    const tbody = document.getElementById('campaignHistoryBody');

    function filterTable() {
      const searchText = searchInput.value.toLowerCase();
      const monthFilter = filterMonth.value; // "YYYY-MM"

      for (let row of tbody.rows) {
        const campaignName = row.cells[0].textContent.toLowerCase();
        const startDate = row.cells[1].textContent;

        let show = true;

        if (searchText && !campaignName.includes(searchText)) {
          show = false;
        }

        if (monthFilter && !startDate.startsWith(monthFilter)) {
          show = false;
        }

        row.style.display = show ? '' : 'none';
      }
    }

    searchInput.addEventListener('input', filterTable);
    filterMonth.addEventListener('change', filterTable);
    clearFilters.addEventListener('click', () => {
      searchInput.value = '';
      filterMonth.value = '';
      filterTable();
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
