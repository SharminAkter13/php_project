<!-- header  -->
<?php
include("include/header.php")
?>
<!-- /.header -->


<!-- Navbar  -->
<?php
include("include/nav.php")
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php
include("include/sidebar.php")
?>

<!-- ./Main Sidebar Container -->


<!-- Add Users -->

<div class="content-wrapper" style="min-height: 2838.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Events Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Events</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    
    <div class="container event-container">
        <div class="row">
            <!-- Event List -->
            <div class="col-md-8">
                <h2>Upcoming Events</h2>
                <div class="event-card">
                    <h3>Fundraising Gala</h3>
                    <p><strong>Date:</strong> December 1, 2025</p>
                    <p><strong>Time:</strong> 6:00 PM - 9:00 PM</p>
                    <p><strong>Location:</strong> Grand Hall, 123 Event St., City</p>
                    <p><strong>Description:</strong> Join us for a night of fundraising to support our latest campaigns!</p>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#registerModal" data-event="Fundraising Gala">Register Now</button>
                </div>
                <div class="event-card">
                    <h3>Volunteer Meet & Greet</h3>
                    <p><strong>Date:</strong> January 15, 2026</p>
                    <p><strong>Time:</strong> 3:00 PM - 5:00 PM</p>
                    <p><strong>Location:</strong> Community Center, 45 Volunteer Rd., City</p>
                    <p><strong>Description:</strong> Meet other volunteers and learn about upcoming projects.</p>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#registerModal" data-event="Volunteer Meet & Greet">Register Now</button>
                </div>
                <div class="event-card">
                    <h3>Charity Run</h3>
                    <p><strong>Date:</strong> March 10, 2026</p>
                    <p><strong>Time:</strong> 8:00 AM - 12:00 PM</p>
                    <p><strong>Location:</strong> Central Park, City</p>
                    <p><strong>Description:</strong> Run to support our fundraising goals! All proceeds go to the campaigns.</p>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#registerModal" data-event="Charity Run">Register Now</button>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="col-md-4">
                <div class="event-form-container">
                    <h3>Register for an Event</h3>
                    <form id="registerForm">
                        <div class="form-group">
                            <label for="eventName">Event Name</label>
                            <input type="text" class="form-control" id="eventName" placeholder="Event Name" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 DonorHub. All Rights Reserved.</p>
        <p>For support, visit our <a href="#">Help Center</a>.</p>
    </div>

    <!-- Modal (for event registration) -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register for Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You're about to register for the <strong id="modalEventName"></strong> event. Please complete the registration below.</p>
                    <form id="eventRegisterForm">
                        <div class="form-group">
                            <label for="eventFullName">Full Name</label>
                            <input type="text" class="form-control" id="eventFullName" placeholder="Your name" required>
                        </div>
                        <div class="form-group">
                            <label for="eventEmail">Email Address</label>
                            <input type="email" class="form-control" id="eventEmail" placeholder="Your email" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Confirm Registration</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<?php
include("include/footer.php");
?>

<!-- Main Footer -->
 <style>
    .event-container {
        margin-top: 20px;
    }
    .event-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .event-card h3 {
        color: #333;
        font-size: 1.5em;
        margin-bottom: 10px;
    }
    .event-card p {
        color: #555;
        font-size: 1em;
        margin-bottom: 10px;
    }
    .event-card button {
        background-color: #FDBE33;
        color: #fff;
        font-size: 1em;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .event-card button:hover {
        background-color: #ff9800;
    }
    .event-form-container {
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }
    .event-form-container h3 {
        font-size: 1.75em;
        color: #333;
        margin-bottom: 20px;
    }
    .footer {
        font-size: 14px;
        color: #888;
    }
    .footer a {
        color: #007bff;
        text-decoration: none;
    }
    .footer a:hover {
        text-decoration: underline;
    }
</style>