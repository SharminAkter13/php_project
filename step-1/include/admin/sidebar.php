<?php
// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userRole = $_SESSION['user_role'] ?? '';
?>

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

                <!-- Dashboard Section (Always visible) -->
                <li class="nav-item">
                    <a href="home.php?page=0" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <?php
                // Use a switch statement to display menu items based on the user's role
                switch ($userRole) {
                    case 'admin':
                ?>
                        <!-- User Management Section for Admin -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Users
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=1" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=2" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=4" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>View Users</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Campaigns Section for Admin -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>
                                    Campaigns
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=9" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Campaign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=10" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Campaigns</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=11" class="nav-link">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Campaign Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=12" class="nav-link">
                                        <i class="far fa-clock nav-icon"></i>
                                        <p>Campaign History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Beneficiary Section for Admin -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-hands-helping"></i>
                                <p>
                                    Beneficiaries
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=13" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Beneficiary</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=14" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Beneficiaries</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=15" class="nav-link">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Beneficiary Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=16" class="nav-link">
                                        <i class="far fa-clock nav-icon"></i>
                                        <p>Beneficiary History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                <?php
                        // No break here, as some sections might be common to multiple roles
                        // Fall-through to shared sections
                    case 'campaign_manager':
                ?>
                        <!-- Campaigns Section (shared with admin) -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>
                                    Campaigns
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=9" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Campaign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=10" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Campaigns</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=11" class="nav-link">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Campaign Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=12" class="nav-link">
                                        <i class="far fa-clock nav-icon"></i>
                                        <p>Campaign History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                <?php
                        break;
                    case 'donor':
                ?>
                        <!-- Donations Section for Donor -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-donate"></i>
                                <p>
                                    Donations
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=17" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Donation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=18" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Donations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=19" class="nav-link">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Donation Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=20" class="nav-link">
                                        <i class="far fa-clock nav-icon"></i>
                                        <p>Donation History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Pledges Section for Donor -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>
                                    Pledges
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=21" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Pledge</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=22" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Pledges</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                <?php
                        break;
                    case 'volunteer':
                ?>
                        <!-- Volunteer Section -->
                         
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-hands-helping"></i>
                                <p>
                                    Volunteers
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php?page=24" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Volunteer</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=25" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Volunteers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="home.php?page=26" class="nav-link">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Volunteers Summery</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                <?php
                        break;
                }
                ?>
                <!-- Shared Sections (Events & Profile) -->
                <?php if (in_array($userRole, ['admin', 'beneficiary', 'campaign_manager', 'donor', 'volunteer'])): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Events
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="home.php?page=5" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Event</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="home.php?page=6" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Events</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="home.php?page=7" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Events Calendar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="home.php?page=8" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Events History</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="home.php?page=28" class="nav-link">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="home.php?page=27" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>
