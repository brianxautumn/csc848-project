<?php
$password_changed = false;
$errors = array();
if (isset($_POST["check"]) && $_POST["check"] == 'change-password') {
    $password_hash;
    if(!isset($_POST["old-password"]) || $_POST["old-password"] == ""){
        array_push($errors, "enter_old_password");      
    }else{
        $password_hash = hash("md5", $_POST['old-password']);
        
        if($password_hash != get_user_password()){
           array_push($errors, "incorrect_password");   
        }
    }
    
    if(!isset($_POST["new-password"]) || $_POST["new-password"] == ""){
        array_push($errors, "enter_new_password");      
    }
    
    
    if(empty($errors)){
        change_password(hash("md5", $_POST['new-password']));
        $password_changed= true;
    }else{
       var_dump($errors); 
    }
    
    
}else if(isset($_POST["check"]) && $_POST["check"] == 'delete-account'){
    delete_account();
}



?>

<div class="col-md-12">
    <div class="admin-heading"><h1>Manage Your Account</h1></div>
</div>  

<div class="content">

    <div class="tbl">
        <div class="col-md-12">
            <?php
          if($password_changed){
              ?>
               <div class="alert alert-success alert-border alert-soft"><span class="glyphicon glyphicon-ok"></span> <strong>Password Updated</strong>  </div>
         <?php
               }
          ?>

            <div class="wdgt">
                <div class="wdgt-header">Change Password</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="check" value="change-password">

                        
                        <div class="form-group">
                            <label>Enter Current Password</label>
                            <input type="password" name="old-password" placeholder="old password" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Enter New Password</label>
                            <input type="password" name="new-password" placeholder="new password" class="form-control"/>
                        </div>
                        <button class="btn btn-primary" type="submit" >Change Password</button>
                    </form>
                        
                  
                </div>
            </div>
            
            
            <div class="wdgt">
                <div class="wdgt-header">Delete Account</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="check" value="delete-account">
                        <p>WARNING!!! </p>
                        <?php
                        if(get_user_type() == "restaurant_owner"){
                        ?>
                        <p>Are you sure you want to delete your account? You cannot undo this. You will also delete all restaurant and employee data.</p>
                        <?php
                        }else{
                        ?>
                        <p>Are you sure you want to delete your account? You cannot undo this.</p>
                        <?php
                        }
                        ?>
                        <button class="btn btn-danger" type="submit" ><span class="glyphicon glyphicon-warning-sign"></span>   Delete Account</button>
                    </form>
                        
                  
                </div>
            </div>

        </div>

    </div>

</div>