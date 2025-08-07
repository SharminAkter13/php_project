<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
        <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"> DonorHub</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/dist/img/avatar2.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block" id="username">Sharmin Akter</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Section -->
                <li class="nav-item">
                    <a href="home.php" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- User Management Section for Admin -->
                <li class="nav-item" id="admin-users">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./add_users.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./manage_user.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Donor Dashboard Sections -->
                <li class="nav-item" id="donor-donations">
                    <a href="./donations.php" class="nav-link">
                        <i class="nav-icon fas fa-heart"></i>
                        <p>Donations</p>
                    </a>
                </li>

                <!-- Volunteer Dashboard Sections -->
                <li class="nav-item" id="volunteer-events">
                    <a href="./events.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Events</p>
                    </a>
                </li>

                <!-- Campaign Manager Dashboard Sections -->
                <li class="nav-item" id="campaign-manager-campaigns">
                    <a href="./campaigns.php" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Campaigns</p>
                    </a>
                </li>

                <!-- Beneficiary Dashboard Sections -->
                <li class="nav-item" id="beneficiary-campaigns">
                    <a href="beneficiary" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-heart"></i>
                        <p>Beneficiary Campaigns</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script>
    // // Get user role from session or backend (this is just a mockup)
    // var userRole = 'Admin';  // Example role, should be fetched from the session or API

    // // Show/hide sections based on role
    // if (userRole === 'Admin') {
    //     document.getElementById('admin-users').style.display = 'block';
    // } else if (userRole === 'Donor') {
    //     document.getElementById('donor-donations').style.display = 'block';
    // } else if (userRole === 'Volunteer') {
    //     document.getElementById('volunteer-events').style.display = 'block';
    // } else if (userRole === 'Campaign Manager') {
    //     document.getElementById('campaign-manager-campaigns').style.display = 'block';
    // } else if (userRole === 'Beneficiary') {
    //     document.getElementById('beneficiary-campaigns').style.display = 'block';
    // }
</script>
