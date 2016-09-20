<?php
$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
$user_name = '';
$user_email = '';
$user_password = '';
$user_confirm_password = '';
$errors = array();

if ($http_post) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_confirm_password = $_POST['user_confirm_password'];
    $errors = register_new_user($user_name, $user_email, $user_password, $user_confirm_password);

}

//line 698
?>
<div class="main-content">
    <div class="padded_content">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">

                    <form class="form-horizontal front_end_form" action='' method="POST" id="registration-form">
                        <fieldset>
                            <div id="legend">
                                <legend class="">Register</legend>
                            </div>
                            <div class="control-group">
                                <!-- Username -->
                                <label class="control-label"  for="username">Username</label>
                                <div class="controls">
                                    <input type="text" id="user_name" name="user_name" placeholder="" required class="input-xlarge"  value="<?php echo htmlspecialchars($user_name); ?>">
                                    <?php
                                    if(in_array("taken_user_name",$errors)){
                                        ?>
                                    <label class="error">Taken User Name</label>
                                        <?php
                                    }
                                    ?>
                                    <p class="help-block">Username can contain any letters or numbers, without spaces</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- E-mail -->
                                <label class="control-label" for="email">E-mail</label>
                                <div class="controls">
                                    <input type="text" id="user_email" name="user_email"  class="input-xlarge" value="<?php echo htmlspecialchars($user_email); ?>">
                                    <?php
                                    if(in_array("taken_email",$errors)){
                                        ?>
                                    <label class="error">Taken Email</label>
                                        <?php
                                    }
                                    ?>
                                    <p class="help-block">Please provide your E-mail</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- Password-->
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <input type="password" id="user_password" name="user_password" placeholder="" required class="input-xlarge">
                                    <p class="help-block">Password should be at least 6 characters</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- Password -->
                                <label class="control-label"  for="password_confirm">Password (Confirm)</label>
                                <div class="controls">
                                    <input type="password" id="user_confirm_password" name="user_confirm_password" required class="input-xlarge">
                                    
                                    <p class="help-block">Please confirm password</p>
                                </div>
                            </div>
                                <div class="control-group">
                                      <div class="controls">
                                      <input type = "checkbox" name = "chkbox" value = "agree" required />&nbsp;I Agree to the <a class="btn" data-popup-open="popup-1" href="#">(Privacy Policy)</a>
                                                              
                                  
                               </div>
                            </div>
                            <div class="control-group">
                                <!-- Button -->
                                <div class="controls">
                                    <button class="btn btn-success">Register</button>
                                </div>
                            </div>
                          
                        </fieldset>
                    </form>

                </div>
                
                <div class="col-md-6 front_end_form">
                    <div id="legend">
                        <legend class="">Benefits of Registering</legend>
                    </div>
                    <p>
                        View and manage all of your reservations!
                    </p>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>



