<!DOCTYPE html>
<html>
    <head>
       
        <meta name="viewport" content="width=device-width" />
        <title></title>
        
        
        <link type="text/css" rel="stylesheet" href="<?php echo ROOT . TEMPLATES . "/css/bootstrap.min.css"?>" >
        <link type="text/css" rel="stylesheet" href="<?php echo ROOT . TEMPLATES .'/css/style.css'?>" >
        <link type="text/css" rel="stylesheet" href="<?php echo ROOT . TEMPLATES .'/css/jquery-ui.css'?>" >
        <link rel="shortcut icon" href="<?php echo ROOT . TEMPLATES .'/img/favicon.ico'?>" type="image/x-icon" />
        <!-- This way sucks, fix this later ^^^^ -->
        

        
    </head>
    <body>
        <div class="page-wrapper">
            <div id="class-banner">
                Disclamer: Website is a class project at SFSU.
                <a href="" id="kill-banner"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            
        
            
            <div id="header">
                <div id="header_content">
                    <div class="container">
                        <div class="header_align">
                        <a href="<?php print_home_url(); ?>"><img src="<?php load_template_image("logo.jpg"); ?>" id="logo"></a>
                      
                        
                        
                        
                        <ul class="nav navbar-nav navbar-right">
                        <?php if(is_logged_in()) { ?>
                        
                            <li><a href="<?php print_login_url(); ?>">Account</a></li>
                            <li><a href="<?php print_logout_url(); ?>">Logout</a></li>
                        
                        <?php }else {?>
                            
                            
                            <li><a href="<?php print_login_url(); ?>">Login</a></li>
                            <li><a href="<?php print_register_url(); ?>">Register</a></li>
                        
                        <?php } ?>
                        </ul><!-- /.nav -->
                        
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(!is_admin()) load_search_form(); ?>

        