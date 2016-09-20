<?php

/**
 * Here is the master configuration file. 
 * 
 * All of the MySQL settings go here, as well as other random global stuff.
 * 
 * DO NOT PUT THE MYSQL LOGIN CREDENTIALS IN ANY OTHER FOLDER !!!!!!!
 */


/**
 * Master MySql configureation settings
 */

/** MySql database name */
define('DB_NAME', 'student_f15g15'); //I think its this, but I might be wrong

/** MySQL database username */
define('DB_USER', 'f15g15');

/** MySQL password */
define('DB_PASSWORD', 'GroupOneFive');

/** MySQL host */
define('DB_HOST', 'localhost');



/**
 * Define Authentication keys here eventually!
 */

//key or something



/** Make an absolute path **/
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');


/**
 * Now move on to the settings file
 */
require_once(ABSPATH . 'settings.php');