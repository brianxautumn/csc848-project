<?php
/**
 * This is the main boostrap file for loading content.
 */

/** the application's file directory */
define('ABSPATH', dirname(__FILE__) . '/');


//Define the Home URL FIX THIS LATER FOR PERMALINKS
define('SERVER' , filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL));
//define('HOME_URI' , "http://". filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL) . "/~" . get_current_user() . "/" . basename(ABSPATH));
//define('ROOT' , "/~" . get_current_user() . "/" . basename(ABSPATH) . "/");

if (basename(ABSPATH) == "public_html") {
    //in this case, the site resides inside public html
    define('HOME_URI', "http://" . filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL) . "/~" . get_current_user());
    define('ROOT', "/~" . get_current_user() . "/");
} else {
    //in this case it can be in any subfolder of public_html
    define('HOME_URI', "http://" . filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL) . "/~" . get_current_user() . "/" . basename(ABSPATH));
    define('ROOT', "/~" . get_current_user() . "/" . basename(ABSPATH) . "/");
}



error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

if ( file_exists( ABSPATH . 'config.php') ) {

	/** Load the configuration file */
	require_once( ABSPATH . 'config.php' );

} else{
    
    /** tell users that there is no configuration file */
    echo "Sorry configuration file isn't found :(";
}