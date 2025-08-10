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
            
            include("pages/admin/events/edit_events.php");
            
        }else if($page==8){
            
            include("pages/admin/events/view_events.php");
            
        }else if($page==9){
            
            include("pages/admin/campaigns/add_campaigns.php");
            
        }else if($page==10){
            
            include("pages/admin/campaigns/manage_campaigns.php");
            
        }else if($page==11){
            
            include("pages/admin/campaigns/edit_campaigns.php");
            
        }else if($page==12){
            
            include("pages/admin/campaigns/view_campaigns.php");
            
        }else if($page==13){
            
            include("pages/admin/beneficiary/add_beneficiary.php");
            
        }else if($page==14){
            
            include("pages/admin/beneficiary/manage_beneficiary.php");
            
        }else if($page==15){
            
            include("pages/admin/beneficiary/edit_beneficiary.php");
            
        }else if($page==16){
            
            include("pages/admin/beneficiary/view_beneficiary.php");
            
        }else if($page==17){
            
            include("pages/admin/donations/add_donations.php");
            
        }else if($page==18){
            
            include("pages/admin/donations/manage_donations.php");
            
        }else if($page==19){
            
            include("pages/admin/donations/edit_donations.php");
            
        }else if($page==20){
            
            include("pages/admin/donations/view_donations.php");
            
        }
    }
?>