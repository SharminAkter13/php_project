   <?php
   if(isset($_GET["page"])){
       $page=$_GET["page"];
	   
	   if($page=="add_users"){
           
           include("pages/admin/users/add_users.php"); 
		   
        }else if($page=="manage_users"){
            
            include("pages/admin/users/manage_users.php");
            
        }else if($page=="edit_users"){
            include("pages/admin/users/edit_users.php");
            
        }else if($page=="view_users"){
            
            include("pages/admin/users/view_users.php");
            
        }else if($page=="add_events"){
            
            include("pages/admin/events/add_events.php");
            
        }else if($page=="manage_events"){
            
            include("pages/admin/events/manage_events.php");
            
        }else if($page=="events_calendar"){
            
            include("pages/admin/events/events_calendar.php");
            
        }else if($page=="events_history"){
            
            include("pages/admin/events/events_history.php");
            
        }else if($page=="add_campaigns"){
            
            include("pages/admin/campaigns/add_campaigns.php");
            
        }else if($page=="manage_campaigns"){
            
            include("pages/admin/campaigns/manage_campaigns.php");
            
        }else if($page=="campaigns_report"){
            
            include("pages/admin/campaigns/campaigns_report.php");
            
        }else if($page=="campaigns_history"){
            
            include("pages/admin/campaigns/campaigns_history.php");
            
        }else if($page=="add_beneficiary"){
            
            include("pages/admin/beneficiary/add_beneficiary.php");
            
        }else if($page=="manage_beneficiary"){
            
            include("pages/admin/beneficiary/manage_beneficiary.php");
            
        }else if($page=="beneficiary_report"){
            
            include("pages/admin/beneficiary/beneficiary_report.php");
            
        }else if($page=="beneficiary_history"){
            
            include("pages/admin/beneficiary/beneficiary_history.php");
            
        }else if($page=="add_donations"){
            
            include("pages/admin/donations/add_donations.php");
            
        }else if($page=="manage_donations"){
            
            include("pages/admin/donations/manage_donations.php");
            
        }else if($page=="donations_report"){
            
            include("pages/admin/donations/donations_report.php");
            
        }else if($page=="donations_history"){
            
            include("pages/admin/donations/donations_history.php");
            
        }else if($page=="add_pledges"){
            
            include("pages/admin/pledges/add_pledges.php");
            
        }else if($page=="manage_pledges"){
            
            include("pages/admin/pledges/manage_pledges.php");
            
        }else if($page=="pledges_summery"){
            
            include("pages/admin/pledges/pledges_summery_analyticts.php");
            
        }else if($page=="add_volunteers"){
            
            include("pages/admin/volunteers/add_volunteers.php");
            
        }else if($page=="anage_volunteers"){
            
            include("pages/admin/volunteers/manage_volunteers.php");
            
        }else if($page=="volunteers_summery"){
            
            include("pages/admin/volunteers/volunteers_summery_analyticts.php");
            
        }else if($page=="logout"){
            
            include("pages/admin/logout/logout.php");
            
        }
    }
?>