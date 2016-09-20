<?php
    $current_status = get_restaurant_status();
    $link = HOME_URI ."/admin/basic-info";
    $reservation_enabled = get_restaurant_reservation_enabled();
    $basic_info_link = get_home_url() . "/admin/basic-info";
    
?>

<div class="col-md-12">
                <div class="admin-heading"><h1>Dashboard</h1></div>
            </div>




<div class="tbl">
      <div class="col-md-6">
       <div class="wdgt wdgt-soft">
           <div class="wdgt-header">Welcome, <?php echo get_restaurant_name(); ?> !</div>
        <div class="wdgt-body" style="padding-bottom:10px;">
        <p>
            This is your administration dashboard. From Here you can control many aspects of your business. On this main panel, you can see basic help and information here, and to your right you will see your alerts and notifications.
        </p>
        
        <p>
            If you are a new user, begin by visiting your <a href="<?php echo get_home_url() . "/admin/basic-info"; ?>">Basic Info</a> Tab to fill out basic information about your restaurant. You must fill this out completely to have your account activated. Once you have filled out all the details you will see your account is pending review in your notifications. You will then see a notification to let you know your account is live once a moderator has approved it.
        </p>
         
         <p>
            To enable users to make reservations at your restaurant, visit the <a href="<?php echo get_home_url() . "/admin/hours"; ?>">Business Hours</a> Tab to set your operating hours. Then Visit the <a href="<?php echo get_home_url() . "/admin/tables"; ?>">Manage Tables</a> Tab to add available tables and capacity, then enable the reservation system. Once active, you will see a notification on your dashboard.
        </p>
         
        <p>
            You can add, and remove employee accounts from the <a href="<?php echo get_home_url() . "/admin/employees"; ?>">Manage Employees</a> Tab. Employees have a host interface which allows them to see the day's reservations, and confirm their arrival.
        </p>
        
        
        <p>
            Add up to 4 more pictures from the <a href="<?php echo get_home_url() . "/admin/gallery"; ?>">Manage Gallery</a> Tab. These will display on your Restaurant's public page.
        </p>
        
        <p>
            Visit <a href="<?php echo get_home_url() . "/admin/settings"; ?>">Settings</a> for account management. From here you can change your password, or delete your account. If you delete your account, your restaurant, and all associate employee accounts will also be removed.
        </p>
        
        </div>
       </div>
      </div>
            <div class="col-md-6">
       <div class="wdgt">
        <div class="wdgt-header">Notifications</div>
        <div class="wdgt-body">
            <?php
    
          if($current_status == 'ready'){
              ?>
             <div class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign"></span> <strong>Your restaurant is pending to be approved!</strong>  </div>
         <?php
               }
          ?>
             
             <?php
             if($current_status == 'active' || $current_status == 'pending' ||  $current_status == 'pending-denied' ){
              ?>
             <a href="<?php print_restaurant_url(); ?>"><div class="alert alert-success"><span class="glyphicon glyphicon glyphicon-eye-open"></span> <strong>Your Restaurant is Live!</strong>  </div></a>
         <?php
               }
          ?>
             
             <?php
             if($current_status == 'active'  ){
              ?>
             <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> <strong>Listing is up to date! No pending changes.</strong>  </div>
         <?php
               }
          ?>
             
             
              <?php
             if($current_status == 'pending' || $current_status == 'pending-denied'){
              ?>
             <a href="<?php echo $basic_info_link; ?>"><div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> <strong>You have pending changes.</strong>  </div></a>
         <?php
               }
          ?>
             
             <?php
             if($current_status == 'pending-denied' || $current_status == 'ready-denied'){
              ?>
             <a href="<?php echo $basic_info_link; ?>"><div class="alert alert-danger"><span class="glyphicon glyphicon-ban-circle"></span> <strong>Your data was not approved. Please review Basic Info resubmit.</strong>  </div></a>
         <?php
               }
          ?>
             
             
             
           <?php
     
          if($current_status == 'new'){
              ?>
             <div class="alert alert-success"><span class="glyphicon glyphicon-thumbs-up"></span> <strong>Welcome to your new account!</strong>  </div>
         <?php
               }
          ?>
             
             
              <?php
            
          if($current_status == 'new' || $current_status == 'ready' || $current_status == 'ready-denied'){
              ?>
             <div class="alert alert-danger"><span class="glyphicon glyphicon-eye-close"></span> <strong>Your Account is not yet Live</strong>  </div>
         <?php
               }
          ?>
            
            
            
            <?php
            
          if($current_status == 'new'){
              ?>
            <a href="<?php echo $link; ?>"> <div class="alert alert-info"><span class="glyphicon glyphicon-remove"></span> <strong>Fill Out Basic Info Tab to be Approved</strong>  </div></a>
         <?php
               }
          ?>
            
            
         <?php
          $link_tables = HOME_URI ."/admin/tables";
          if($reservation_enabled){
              ?>
            <a href="<?php echo $link_tables; ?>"><div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> <strong>Reservations Enabled!</strong>  </div></a>
         <?php
               }else{
          ?>
             <a href="<?php echo $link_tables; ?>"> <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong>Reservations Not Enabled</strong>  </div></a>
             <?php
               }
               ?>
               
               
        </div>
       </div>
      </div>
     </div>