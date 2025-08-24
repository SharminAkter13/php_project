   <?php
   if(isset($_GET["page"])){
       $page=$_GET["page"];
	   
	   if($page==1){
           
           include("pages/admin/users/add_users.php"); 
		   
        }else if($page==2){
            
            include("pages/admin/users/manage_users.php");
            
        }else if($page==3){
            include("pages/admin/users/edit_users.php");
            
        }else if($page==4){
            
            include("pages/admin/users/view_users.php");
            
        }else if($page==5){
            
            include("pages/admin/events/add_events.php");
            
        }else if($page==6){
            
            include("pages/admin/events/manage_events.php");
            
        }else if($page==7){
            
            include("pages/admin/events/events_calendar.php");
            
        }else if($page==8){
            
            include("pages/admin/events/events_history.php");
            
        }else if($page==9){
            
            include("pages/admin/campaigns/add_campaigns.php");
            
        }else if($page==10){
            
            include("pages/admin/campaigns/manage_campaigns.php");
            
        }else if($page==11){
            
            include("pages/admin/campaigns/campaigns_report.php");
            
        }else if($page==12){
            
            include("pages/admin/campaigns/campaigns_history.php");
            
        }else if($page==13){
            
            include("pages/admin/beneficiary/add_beneficiary.php");
            
        }else if($page==14){
            
            include("pages/admin/beneficiary/manage_beneficiary.php");
            
        }else if($page==15){
            
            include("pages/admin/beneficiary/beneficiary_report.php");
            
        }else if($page==16){
            
            include("pages/admin/beneficiary/beneficiary_history.php");
            
        }else if($page==17){
            
            include("pages/admin/donations/add_donations.php");
            
        }else if($page==18){
            
            include("pages/admin/donations/manage_donations.php");
            
        }else if($page==19){
            
            include("pages/admin/donations/donations_report.php");
            
        }else if($page==20){
            
            include("pages/admin/donations/donations_history.php");
            
        }else if($page==21){
            
            include("pages/admin/pledges/add_pledges.php");
            
        }else if($page==22){
            
            include("pages/admin/pledges/manage_pledges.php");
            
        }else if($page==23){
            
            include("pages/admin/pledges/pledges_summery_analyticts.php");
            
        }else if($page==24){
            
            include("pages/admin/volunteers/add_volunteers.php");
            
        }else if($page==25){
            
            include("pages/admin/volunteers/manage_volunteers.php");
            
        }else if($page==26){
            
            include("pages/admin/volunteers/volunteers_summery_analyticts.php");
            
        }else if($page==27){
            
            include("pages/admin/logout/logout.php");
            
        }else if($page==28){
            
            include("pages/admin/profile/user_profile.php");
  
        }else if($page==29){
            
            include("pages/admin/profile/update_profile.php");
  
        }
    }
?>