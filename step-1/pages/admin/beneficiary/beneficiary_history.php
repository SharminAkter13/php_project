


<!-- Add Users -->

<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users Interface</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Add Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    
    <!-- Beneficiary Header -->
    <div class="beneficiary-header">
        <h1>Welcome, Beneficiary!</h1>
        <p>Here you can track the campaigns supporting you and request funds.</p>
    </div>

    <div class="container">
        <div class="row">
            <!-- Campaign Details -->
            <div class="col-md-8">
                <h2 class="text-center">Campaigns Supporting You</h2>

                <!-- Campaign Card -->
                <div class="campaign-card">
                    <h3>Clean Water Initiative</h3>
                    <p><strong>Goal:</strong> $100,000</p>
                    <p><strong>Amount Raised:</strong> $30,000</p>
                    <p><strong>Amount Allocated to You:</strong> $10,000</p>
                    <p><strong>Campaign Description:</strong></p>
                    <p>This campaign focuses on providing clean drinking water to rural areas. A portion of the raised funds are allocated to beneficiaries like you who are in need of water-related support.</p>
                    <h4>Progress</h4>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                    </div>
                    <button class="request-btn btn-block" data-toggle="modal" data-target="#fundRequestModal" data-campaign="Clean Water Initiative">Request Funds</button>
                </div>

                <!-- Campaign Card -->
                <div class="campaign-card">
                    <h3>Education Fund for Underprivileged Children</h3>
                    <p><strong>Goal:</strong> $50,000</p>
                    <p><strong>Amount Raised:</strong> $20,000</p>
                    <p><strong>Amount Allocated to You:</strong> $5,000</p>
                    <p><strong>Campaign Description:</strong></p>
                    <p>This initiative provides educational resources and scholarships to children from low-income families. Funds are allocated to beneficiaries like you to improve access to education.</p>
                    <h4>Progress</h4>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                    </div>
                    <button class="request-btn btn-block" data-toggle="modal" data-target="#fundRequestModal" data-campaign="Education Fund for Underprivileged Children">Request Funds</button>
                </div>
            </div>

            <!-- Request Form (Sidebar) -->
            <div class="col-md-4">
                <div class="campaign-card">
                    <h3>Request Funds</h3>
                    <p>Use the form below to request funds for the campaigns you are supporting.</p>
                    <div class="request-form-container">
                        <form id="fundRequestForm">
                            <div class="form-group">
                                <label for="requestedAmount">Requested Amount ($)</label>
                                <input type="number" class="form-control" id="requestedAmount" placeholder="Enter amount" required>
                            </div>
                            <div class="form-group">
                                <label for="reason">Reason for Request</label>
                                <textarea class="form-control" id="reason" rows="4" placeholder="Explain why you need the funds" required></textarea>
                            </div>
                            <button type="submit" class="request-btn btn-block">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 DonorHub. All Rights Reserved.</p>
        <p>For support, visit our <a href="#">Help Center</a>.</p>
    </div>

    <!-- Modal for Fund Request -->
    <div class="modal fade" id="fundRequestModal" tabindex="-1" role="dialog" aria-labelledby="fundRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fundRequestModalLabel">Request Funds</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You're about to request funds for the <strong id="modalCampaignName"></strong> campaign. Please fill in the details below:</p>
                    <form id="modalFundRequestForm">
                        <div class="form-group">
                            <label for="modalRequestedAmount">Requested Amount ($)</label>
                            <input type="number" class="form-control" id="modalRequestedAmount" placeholder="Amount" required>
                        </div>
                        <div class="form-group">
                            <label for="modalReason">Reason for Request</label>
                            <textarea class="form-control" id="modalReason" rows="4" placeholder="Reason" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- ./Add users -->
