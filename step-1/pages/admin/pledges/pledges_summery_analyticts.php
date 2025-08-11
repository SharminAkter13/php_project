<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pledge Tracking Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .card-header {
            font-weight: bold;
        }
        .status-badge {
            font-weight: bold;
        }
        .status-fulfilled { background-color: #28a745; color: white; }
        .status-partially { background-color: #ffc107; color: black; }
        .status-overdue { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <h1 class="mb-4">Pledge Tracking Dashboard</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Pledged Amount</h5>
                    <h2 class="card-text">$150,000</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Fulfilled Amount</h5>
                    <h2 class="card-text">$95,000</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Outstanding Pledges</h5>
                    <h2 class="card-text">$55,000</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Number of Active Pledges</h5>
                    <h2 class="card-text">42</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Pledge List</span>
            <input type="text" class="form-control w-25" placeholder="Search pledges..." id="pledgeSearch">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="pledgeTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Donor</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-pledge-id="1">
                            <td>#1001</td>
                            <td>John Doe</td>
                            <td>$5,000</td>
                            <td><span class="badge status-fulfilled">Fulfilled</span></td>
                            <td><button class="btn btn-sm btn-primary view-details" data-bs-toggle="modal" data-bs-target="#pledgeDetailModal">View Details</button></td>
                        </tr>
                        <tr data-pledge-id="2">
                            <td>#1002</td>
                            <td>Jane Smith</td>
                            <td>$10,000</td>
                            <td><span class="badge status-partially">Partially Fulfilled</span></td>
                            <td><button class="btn btn-sm btn-primary view-details" data-bs-toggle="modal" data-bs-target="#pledgeDetailModal">View Details</button></td>
                        </tr>
                        <tr data-pledge-id="3">
                            <td>#1003</td>
                            <td>Acme Corp</td>
                            <td>$25,000</td>
                            <td><span class="badge status-overdue">Overdue</span></td>
                            <td><button class="btn btn-sm btn-primary view-details" data-bs-toggle="modal" data-bs-target="#pledgeDetailModal">View Details</button></td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pledgeDetailModal" tabindex="-1" aria-labelledby="pledgeDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pledgeDetailModalLabel">Pledge Details: <span id="pledgeId"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Donor Information</h6>
                            <p><strong>Name:</strong> <span id="donorName"></span></p>
                            <p><strong>Email:</strong> <span id="donorEmail"></span></p>
                            <p><strong>Phone:</strong> <span id="donorPhone"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Pledge Details</h6>
                            <p><strong>Amount:</strong> <span id="pledgeAmount"></span></p>
                            <p><strong>Status:</strong> <span class="badge" id="pledgeStatus"></span></p>
                            <p><strong>Date Pledged:</strong> <span id="pledgeDate"></span></p>
                            <p><strong>Outstanding Balance:</strong> <span id="outstandingBalance"></span></p>
                        </div>
                    </div>
                    <hr>
                    <h6>Transaction History</h6>
                    <ul class="list-group" id="transactionHistory">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Payment of $2,000 via Credit Card</span>
                            <span class="text-muted">on 2023-01-15</span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Record Payment</button>
                    <button type="button" class="btn btn-danger">Send Reminder</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pledgeDetailModal = document.getElementById('pledgeDetailModal');
        pledgeDetailModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs- attribute
            const pledgeId = button.closest('tr').getAttribute('data-pledge-id');
            
            // In a real application, you'd fetch data for the specific pledgeId from your database
            // For this example, we'll use placeholder data
            const pledgeData = {
                '1': {
                    donorName: 'John Doe', donorEmail: 'john@example.com', donorPhone: '555-1234',
                    amount: '$5,000', status: 'Fulfilled', statusClass: 'status-fulfilled',
                    date: '2023-01-01', outstanding: '$0',
                    transactions: ['Payment of $5,000 via Check on 2023-01-15']
                },
                '2': {
                    donorName: 'Jane Smith', donorEmail: 'jane@example.com', donorPhone: '555-5678',
                    amount: '$10,000', status: 'Partially Fulfilled', statusClass: 'status-partially',
                    date: '2023-02-10', outstanding: '$5,000',
                    transactions: ['Payment of $5,000 via Credit Card on 2023-02-20']
                },
                '3': {
                    donorName: 'Acme Corp', donorEmail: 'acme@example.com', donorPhone: '555-9012',
                    amount: '$25,000', status: 'Overdue', statusClass: 'status-overdue',
                    date: '2023-03-05', outstanding: '$25,000',
                    transactions: []
                }
            };
            
            const data = pledgeData[pledgeId];
            
            // Update the modal's content
            document.getElementById('pledgeId').textContent = '#' + pledgeId;
            document.getElementById('donorName').textContent = data.donorName;
            document.getElementById('donorEmail').textContent = data.donorEmail;
            document.getElementById('donorPhone').textContent = data.donorPhone;
            document.getElementById('pledgeAmount').textContent = data.amount;
            document.getElementById('pledgeStatus').textContent = data.status;
            document.getElementById('pledgeStatus').className = `badge ${data.statusClass}`;
            document.getElementById('pledgeDate').textContent = data.date;
            document.getElementById('outstandingBalance').textContent = data.outstanding;
            
            const transactionList = document.getElementById('transactionHistory');
            transactionList.innerHTML = '';
            if (data.transactions.length > 0) {
                data.transactions.forEach(transaction => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = transaction;
                    transactionList.appendChild(li);
                });
            } else {
                transactionList.innerHTML = '<li class="list-group-item text-muted">No transactions recorded.</li>';
            }
        });
    });
</script>

</body>
</html>