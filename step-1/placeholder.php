<?php
// Always start the session at the very top of the script.
session_start();

// Check if a user is authenticated by verifying their session role.
// This is the first line of defense against unauthorized access.
if (isset($_SESSION['user_role'])) {
    $userRole = $_SESSION['user_role'];
    
    // Check if the 'page' GET parameter is set.
    if (isset($_GET["page"])) {
        $page = (int)$_GET["page"]; // Cast to integer to prevent malicious input.

        // Use a role-based conditional structure for access control.
        if ($userRole === 'admin') {
            // The admin role has full access to all pages.
            switch ($page) {
                case 1:
                    include("pages/admin/users/add_users.php");
                    break;
                case 2:
                    include("pages/admin/users/manage_users.php");
                    break;
                case 3:
                    include("pages/admin/users/edit_users.php");
                    break;
                case 4:
                    include("pages/admin/users/view_users.php");
                    break;
                case 5:
                    include("pages/admin/events/add_events.php");
                    break;
                case 6:
                    include("pages/admin/events/manage_events.php");
                    break;
                case 7:
                    include("pages/admin/events/events_calendar.php");
                    break;
                case 8:
                    include("pages/admin/events/events_history.php");
                    break;
                case 9:
                    include("pages/admin/campaigns/add_campaigns.php");
                    break;
                case 10:
                    include("pages/admin/campaigns/manage_campaigns.php");
                    break;
                case 11:
                    include("pages/admin/campaigns/campaigns_report.php");
                    break;
                case 12:
                    include("pages/admin/campaigns/campaigns_history.php");
                    break;
                case 13:
                    include("pages/admin/beneficiary/add_beneficiary.php");
                    break;
                case 14:
                    include("pages/admin/beneficiary/manage_beneficiary.php");
                    break;
                case 15:
                    include("pages/admin/beneficiary/beneficiary_report.php");
                    break;
                case 16:
                    include("pages/admin/beneficiary/beneficiary_history.php");
                    break;
                case 17:
                    include("pages/admin/donations/add_donations.php");
                    break;
                case 18:
                    include("pages/admin/donations/manage_donations.php");
                    break;
                case 19:
                    include("pages/admin/donations/donations_report.php");
                    break;
                case 20:
                    include("pages/admin/donations/donations_history.php");
                    break;
                case 21:
                    include("pages/admin/pledges/add_pledges.php");
                    break;
                case 22:
                    include("pages/admin/pledges/manage_pledges.php");
                    break;
                case 23:
                    include("pages/admin/pledges/pledges_summery_analyticts.php");
                    break;
                case 24:
                    include("pages/admin/volunteers/add_volunteers.php");
                    break;
                case 25:
                    include("pages/admin/volunteers/manage_volunteers.php");
                    break;
                case 26:
                    include("pages/admin/volunteers/volunteers_summery_analyticts.php");
                    break;
                case 27:
                    include("pages/admin/logout/logout.php");
                    break;
                case 28:
                    include("pages/admin/profile/user_profile.php");
                    break;
                default:
                    // Show an error if an admin tries to access a non-existent page.
                    echo "<div class='alert alert-danger'>Error: Page not found.</div>";
                    break;
            }
        } elseif ($userRole === 'beneficiary') {
            // The beneficiary role has limited access.
            switch ($page) {
                case 5:
                    include("pages/admin/events/add_events.php");
                    break;
                case 6:
                    include("pages/admin/events/manage_events.php");
                    break;
                case 7:
                    include("pages/admin/events/events_calendar.php");
                    break;
                case 8:
                    include("pages/admin/events/events_history.php");
                    break;
                case 16:
                    include("pages/admin/beneficiary/beneficiary_history.php");
                    break;
                case 28:
                    include("pages/admin/profile/user_profile.php");
                    break;
                case 27:
                    include("pages/admin/logout/logout.php");
                    break;
                default:
                    echo "<div class='alert alert-danger'>You do not have permission to view this page.</div>";
                    break;
            }
        } elseif ($userRole === 'campaign_manager') {
            // The campaign manager role has access to specific management pages.
            switch ($page) {
                case 5:
                    include("pages/admin/events/add_events.php");
                    break;
                case 6:
                    include("pages/admin/events/manage_events.php");
                    break;
                case 7:
                    include("pages/admin/events/events_calendar.php");
                    break;
                case 8:
                    include("pages/admin/events/events_history.php");
                    break;
                case 9:
                    include("pages/admin/campaigns/add_campaigns.php");
                    break;
                case 10:
                    include("pages/admin/campaigns/manage_campaigns.php");
                    break;
                case 11:
                    include("pages/admin/campaigns/campaigns_report.php");
                    break;
                case 12:
                    include("pages/admin/campaigns/campaigns_history.php");
                    break;
                case 28:
                    include("pages/admin/profile/user_profile.php");
                    break;
                case 27:
                    include("pages/admin/logout/logout.php");
                    break;
                default:
                    echo "<div class='alert alert-danger'>You do not have permission to view this page.</div>";
                    break;
            }
        } elseif ($userRole === 'donor') {
            // The donor role has access to donation and pledge pages.
            switch ($page) {
                case 5:
                    include("pages/admin/events/add_events.php");
                    break;
                case 6:
                    include("pages/admin/events/manage_events.php");
                    break;
                case 7:
                    include("pages/admin/events/events_calendar.php");
                    break;
                case 8:
                    include("pages/admin/events/events_history.php");
                    break;
                case 17:
                    include("pages/admin/donations/add_donations.php");
                    break;
                case 18:
                    include("pages/admin/donations/manage_donations.php");
                    break;
                case 19:
                    include("pages/admin/donations/donations_report.php");
                    break;
                case 20:
                    include("pages/admin/donations/donations_history.php");
                    break;
                case 21:
                    include("pages/admin/pledges/add_pledges.php");
                    break;
                case 22:
                    include("pages/admin/pledges/manage_pledges.php");
                    break;
                case 28:
                    include("pages/admin/profile/user_profile.php");
                    break;
                case 27:
                    include("pages/admin/logout/logout.php");
                    break;
                default:
                    echo "<div class='alert alert-danger'>You do not have permission to view this page.</div>";
                    break;
            }
        } elseif ($userRole === 'volunteer') {
            // The volunteer role has access to pages related to their activities.
            switch ($page) {
                case 5:
                    include("pages/admin/events/add_events.php");
                    break;
                case 6:
                    include("pages/admin/events/manage_events.php");
                    break;
                case 7:
                    include("pages/admin/events/events_calendar.php");
                    break;
                case 8:
                    include("pages/admin/events/events_history.php");
                    break;
                case 24:
                    include("pages/admin/volunteers/add_volunteers.php");
                    break;
                case 25:
                    include("pages/admin/volunteers/manage_volunteers.php");
                    break;
                case 26:
                    include("pages/admin/volunteers/volunteers_summery_analyticts.php");
                    break;
                case 28:
                    include("pages/admin/profile/user_profile.php");
                    break;
                case 27:
                    include("pages/admin/logout/logout.php");
                    break;
                default:
                    echo "<div class='alert alert-danger'>You do not have permission to view this page.</div>";
                    break;
            }
        } else {
            // Fallback for an unknown or unhandled user role.
            echo "<div class='alert alert-danger'>Your user role is not recognized.</div>";
        }
    }
} else {
    // If no session role is set, the user is not authenticated.
    // Redirect them to the login page for security.
    header("Location: login.php");
    exit;
}
?>
