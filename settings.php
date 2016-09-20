<?php

/**
 * Here we set up global settings and paths to where the classes and libraries are going to go
 */

/**
 * Stores the location of the superSeater classes, functions, and other junk.
 *
 */
define( 'ASSETS', 'assets' ); //Assets Root Location
define( 'TEMPLATES', 'templates' ); //Templaltes Root Location
define( 'COOKIEPOSTFIX', md5( ROOT ));
define( 'AUTHENTICATION_COOKIE', "AUTHENTICATION-" . COOKIEPOSTFIX);


// Include files required for initialization.
require( ABSPATH . ASSETS . '/load.php' );
require( ABSPATH . ASSETS . '/default-constants.php' );


// Load the initial constants
ss_initial_constants();



//Begin to lead basic files
require( ABSPATH . ASSETS . '/functions.php' );
require( ABSPATH . ASSETS . '/class-ss.php' );
//require( ABSPATH . ASSETS . '/plugin.php' );


// Include the database class 
require_ss_db();

// Set the database table prefix and the format specifiers for database table columns.
//ss_set_db_vars();
//Havent figured out the tables and stuff yet



// Loading files that do stuf :D, Mostly classes and some other junk
require( ABSPATH . ASSETS . '/restaurant.php' );
require( ABSPATH . ASSETS . '/query.php' );
require( ABSPATH . ASSETS . '/class-roles.php' );
require( ABSPATH . ASSETS . '/url-overwrite.php' );
require( ABSPATH . ASSETS . '/template.php' );
require( ABSPATH . ASSETS . '/session.php' );
require( ABSPATH . ASSETS . '/user.php' );
require( ABSPATH . ASSETS . '/admin.php' );
require( ABSPATH . ASSETS . '/reservation.php' );
require( ABSPATH . ASSETS . '/ajax.php' );

// Create common globals.
require( ABSPATH . ASSETS . '/vars.php' );



/**
 * Master Query Object
 * @global object $master_query
 */
$GLOBALS['master_query'] = new SuperSeater_Query();

/**
 * Holds reference to master query
 * @global object $ss_query
 */
$GLOBALS['ss_query'] = $GLOBALS['master_query'];

/**
 * Use this for fixing the URLS
 * @global object $ss_overwrite
 */
$GLOBALS['url_overwrite'] = new URL_Overwrite();

/**
 * SuperSeater Object
 * @global object $wp
 * @since 2.0.0
 */
$GLOBALS['super_seater'] = new SuperSeater();

/**
 * Super Seater User Roles
 * @global object $wp_roles
 */
$GLOBALS['ss_roles'] = new SuperSeater_Roles();





/*
 * After Template files are loaded, initialize the user type
 */
// Set up current user.
//$GLOBALS['super_seater']->init();

//Should be good to go by here!