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


        <!-- Campaign Header -->
        <div class="campaign-header">
            <h1>Campaign for Clean Water</h1>
            <p>Help us provide clean drinking water to communities in need.</p>
        </div>

        <div class="container campaign-container">
            <div class="row">
                <!-- Campaign Details -->
                <div class="col-md-8">
                    <div class="campaign-card">
                        <h3>Campaign Details</h3>
                        <p><strong>Goal:</strong> $100,000</p>
                        <p><strong>Total Raised:</strong> $30,000</p>
                        <p><strong>Start Date:</strong> January 1, 2025</p>
                        <p><strong>End Date:</strong> December 31, 2025</p>
                        <p><strong>About the Campaign:</strong></p>
                        <p>Our mission is to provide clean, accessible drinking water to communities in rural areas. By donating, you will help us fund water purification systems, wells, and sanitation projects that will impact thousands of lives.</p>
                        <h4>Progress</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                        </div>
                    </div>

                    <!-- Donation Form -->
                    <div class="campaign-card">
                        <h3>Make a Donation</h3>
                        <p>Contribute to our campaign and help us reach our goal!</p>
                        <div class="donation-form-container">
                            <form id="donationForm">
                                <div class="form-group">
                                    <label for="donationAmount">Donation Amount ($)</label>
                                    <input type="number" class="form-control" id="donationAmount" placeholder="Enter amount" required>
                                </div>
                                <button type="submit" class="donation-btn btn-block">Donate Now</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Donors List -->
                <div class="col-md-4">
                    <div class="campaign-card">
                        <h3>Recent Donors</h3>
                        <ul id="donorList" class="list-group">
                            <li class="list-group-item">John Doe - $500</li>
                            <li class="list-group-item">Jane Smith - $200</li>
                            <li class="list-group-item">Samuel Lee - $100</li>
                            <li class="list-group-item">Maria Garcia - $50</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- ./Add users -->
<!-- Main Footer -->