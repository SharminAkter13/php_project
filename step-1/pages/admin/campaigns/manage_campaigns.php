<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Campaigns</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container-fluid my-4 py-5 ">
      <div class="row">
        <div class="col-md-9 offset-md-3">
            <h1 class="mb-4">Manage Campaigns</h1>

            <!-- Add Campaign Button -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#campaignModal" id="addCampaignBtn">
            + Add New Campaign
            </button>

            <!-- Campaigns Table -->
            <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Campaign Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Funds Raised</th>
                    <th>Donors</th>
                    <th>Actions</th>
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
                    <td>
                    <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Clean Water Project</td>
                    <td>2024-08-01</td>
                    <td>2024-12-01</td>
                    <td><span class="badge bg-secondary">Completed</span></td>
                    <td>$18,300</td>
                    <td>95</td>
                    <td>
                    <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                    </td>
                </tr>
                <!-- More rows here -->
                </tbody>
            </table>
            </div>
        </div>
    </div>
  </div>

  <!-- Add/Edit Campaign Modal -->
  <div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="campaignForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="campaignModalLabel">Add Campaign</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="campaignIndex" />

          <div class="mb-3">
            <label for="campaignName" class="form-label">Campaign Name</label>
            <input type="text" class="form-control" id="campaignName" required />
          </div>

          <div class="mb-3">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDate" required />
          </div>

          <div class="mb-3">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" required />
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" required>
              <option value="" disabled selected>Select status</option>
              <option value="Active">Active</option>
              <option value="Completed">Completed</option>
              <option value="Pending">Pending</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="fundsRaised" class="form-label">Funds Raised ($)</label>
            <input type="number" class="form-control" id="fundsRaised" min="0" step="0.01" value="0" required />
          </div>

          <div class="mb-3">
            <label for="donors" class="form-label">Number of Donors</label>
            <input type="number" class="form-control" id="donors" min="0" value="0" required />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Campaign</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const campaignForm = document.getElementById('campaignForm');
    const campaignTableBody = document.getElementById('campaignTableBody');
    const campaignModal = new bootstrap.Modal(document.getElementById('campaignModal'));
    const campaignModalLabel = document.getElementById('campaignModalLabel');
    const addCampaignBtn = document.getElementById('addCampaignBtn');

    // Helper: Create badge HTML based on status
    function getStatusBadge(status) {
      const statusMap = {
        'Active': 'success',
        'Completed': 'secondary',
        'Pending': 'warning'
      };
      const badgeClass = statusMap[status] || 'primary';
      return `<span class="badge bg-${badgeClass}">${status}</span>`;
    }

    // Reset form
    function resetForm() {
      campaignForm.reset();
      document.getElementById('campaignIndex').value = '';
      campaignModalLabel.textContent = 'Add Campaign';
    }

    // Add Campaign button click
    addCampaignBtn.addEventListener('click', () => {
      resetForm();
    });

    // Submit form to add/edit campaign
    campaignForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const index = document.getElementById('campaignIndex').value;
      const name = document.getElementById('campaignName').value.trim();
      const startDate = document.getElementById('startDate').value;
      const endDate = document.getElementById('endDate').value;
      const status = document.getElementById('status').value;
      const fundsRaised = parseFloat(document.getElementById('fundsRaised').value).toFixed(2);
      const donors = parseInt(document.getElementById('donors').value);

      if (index === '') {
        // Add new row
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
          <td>${name}</td>
          <td>${startDate}</td>
          <td>${endDate}</td>
          <td>${getStatusBadge(status)}</td>
          <td>$${fundsRaised}</td>
          <td>${donors}</td>
          <td>
            <button class="btn btn-sm btn-warning edit-btn">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn">Delete</button>
          </td>
        `;
        campaignTableBody.appendChild(newRow);
      } else {
        // Edit existing row
        const row = campaignTableBody.rows[index];
        row.cells[0].textContent = name;
        row.cells[1].textContent = startDate;
        row.cells[2].textContent = endDate;
        row.cells[3].innerHTML = getStatusBadge(status);
        row.cells[4].textContent = `$${fundsRaised}`;
        row.cells[5].textContent = donors;
      }

      campaignModal.hide();
    });

    // Delegate Edit and Delete buttons
    campaignTableBody.addEventListener('click', (e) => {
      if (e.target.classList.contains('edit-btn')) {
        const row = e.target.closest('tr');
        const index = [...campaignTableBody.rows].indexOf(row);

        // Populate modal with current values
        document.getElementById('campaignIndex').value = index;
        document.getElementById('campaignName').value = row.cells[0].textContent;
        document.getElementById('startDate').value = row.cells[1].textContent;
        document.getElementById('endDate').value = row.cells[2].textContent;
        document.getElementById('status').value = row.cells[3].textContent.trim();
        document.getElementById('fundsRaised').value = parseFloat(row.cells[4].textContent.replace('$','')).toFixed(2);
        document.getElementById('donors').value = row.cells[5].textContent;

        campaignModalLabel.textContent = 'Edit Campaign';
        campaignModal.show();

      } else if (e.target.classList.contains('delete-btn')) {
        if (confirm('Are you sure you want to delete this campaign?')) {
          const row = e.target.closest('tr');
          row.remove();
        }
      }
    });
  </script>
</body>
</html>
