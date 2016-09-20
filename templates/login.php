<?php
$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

if($http_post){
    $user = sign_on();
}

?>


<div class="main-content">
    <div class="padded_content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4 ">

                    <form class="form-horizontal front_end_form" action='' method="POST">
                        <fieldset>
                            <div id="legend">
                                <legend class="">Login</legend>
                            </div>

                            <div class="control-group">
                                <!-- E-mail -->
                                <label class="control-label" for="email">E-mail</label>
                                <div class="controls">
                                    <input type="text" id="user_email" name="user_email" placeholder="" class="input-xlarge" value="<?php echo htmlspecialchars($user_email); ?>">
                                    <p class="help-block">Please provide your E-mail</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <!-- Password-->
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <input type="password" id="user_password" name="user_password" placeholder="" class="input-xlarge">
                                    <p class="help-block">Enter Password</p>
                                </div>
                            </div>



                            <div class="control-group">
                                <!-- Button -->
                                <div class="controls">
                                    <button class="btn btn-success">Login</button>
                                </div>
                                <?php if ($user == "error") echo "<label class=\"error\">invalid login credentials</label>"; ?>
                            </div>
                        </fieldset>
                        <br>
                        Not a user? <a href="<?php print_register_url(); ?>">Register Now</a>!
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>