<?php
$display_update_message = false;
$display_error_host_message = false;
$display_host_deleted_message = false;

$hosts = get_restaurant_hosts();

//var_dump($_POST);
if (isset($_POST["check"]) && $_POST["check"] == 'create_host') {
    
    
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_confirm_password = $_POST['user_confirm_password'];
    $restaurant_ID = get_restaurant_ID();
    $errors = register_new_user($user_name, $user_email, $user_password, $user_confirm_password, "host", null , $restaurant_ID);
    
    if(! $errors){
        $hosts = get_restaurant_hosts();
        $display_update_message = true;
    }else{
        $display_error_host_message = true;
    }
        
}else if(isset($_POST["check"]) && $_POST["check"] == 'delete_host'){

    if ($hosts) {
        foreach ($hosts as $key => $host) {
            $ID = $host->ID;
            if ($_POST["$ID"] == "on") {
                delete_user($ID);
                unset($hosts[$key]);
                $display_host_deleted_message = true;
            }
        }
    }
}   
?>

<div class="col-md-12">
    <div class="admin-heading"><h1>Manage Employees</h1></div>
</div>  

<div class="content">

    <div class="tbl">
        <div class="col-md-12">
            <?php
            if ($display_update_message) {
                ?>
                <div class="alert alert-success alert-border alert-soft"><span class="glyphicon glyphicon-ok"></span> <strong>Account Created</strong>  </div>
                <?php
            }else if($display_error_host_message){
                ?>
                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong>Account Creation Failed</strong>  </div>
                <?php
            }
            ?>

                
                <?php
            if ($display_host_deleted_message) {
                ?>
                <div class="alert alert-success alert-border alert-soft"><span class="glyphicon glyphicon-ok"></span> <strong>Account Removed</strong>  </div>
                <?php
            }
            ?>
            <div class="wdgt">
                <div class="wdgt-header">Add Host accounts for your Restaurant</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    
                    
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                    
                        
                        <input type="hidden" name="check" value="create_host">
                        
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control" placeholder="User Name" name="user_name" value="<?php echo $restaurant_phone_number; ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Email" name="user_email" value="<?php echo $restaurant_phone_number; ?>">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="password" name="user_password" value="<?php echo $restaurant_phone_number; ?>">
                        </div>

                        
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="password" name="user_confirm_password" value="<?php echo $restaurant_phone_number; ?>">
                        </div>








                        <button class="btn btn-primary" type="submit" id="update_button">Create Host</button>
                    </form>
                </div>
            </div>

                
                
                
                <div class="wdgt">
                <div class="wdgt-header">Manage Current Hosts</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    
                    
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                    
                        
                        <input type="hidden" name="check" value="delete_host">
                        <?php if($hosts) {?>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Mark For Removal</th>
                                    <th>Username</th>
                                    <th>Email</th>
    

                                </tr>
                            </thead>
                            
                            <tbody>
                                
                                <?php
                                    foreach($hosts as $host){
                                        $email = $host->user_email;
                                        $user_ID = $host->ID;
                                        $user_name = $host->user_name;
                                        echo "<tr>";
                                        echo "<td class=\"center\"><input  type=\"checkbox\" class=\"flat-checkbox\" name=\"$user_ID\"  ></td>";
                                        echo "<td>$user_name</td>";
                                        echo "<td>$email</td>";
                                        echo "</tr>";
                                    }
                                ?>
                               
                                   
                                    
                               
                                

                               


                            </tbody>
                        </table>
                        
                        <?php } else { ?>

                        <p> No hosts registered yet, start by creating a host account for your restaurant </p>

                        <?php } ?>




                        <button class="btn btn-danger" type="submit" id="delete_host_button">Delete Marked Hosts</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>