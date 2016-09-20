<?php
/**
 * API FOR LOADING THE PAGE
 * 
 */


/**
 * Load the correct database class file.
 *
 *
 * @global $ssdb global db object
 */
function require_ss_db() {
	global $ssdb;

	require_once( ABSPATH . ASSETS . '/ss-db.php' );
	if ( file_exists( SS_CONTENT_DIR . '/db.php' ) )
		require_once( SS_CONTENT_DIR . '/db.php' );

	if ( isset( $ssdb ) )
		return;
        
	$ssdb = new ssdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
}

/**
 * Sets the database table specifiers for database table columns.
 *
 * @access private
 * @since 3.0.0
 */
function ss_set_ssdb_vars() {
	global $ssdb;
	if ( !empty( $ssdb->error ) )
		dead_db();

	$ssdb->field_types = array( 
            /*PUT FIELDS HERE */
        );

	
}

/**
 * Used to check if a user is a system admin, and allowed to be on this page
 *
 * @return bool true if is a system admin
 */
function is_system_admin() {
	if ( isset( $GLOBALS['current_screen'] ) )
		return $GLOBALS['current_screen']->in_systemAdmin();
	elseif ( defined( 'SS_SYSTEM_ADMIN' ) )
		return WS_SYSTEM_ADMIN;

	return false;
}

/**
 * Whether the current request is for a restaurant owner admin screen 
 *
 * @return bool True if inside restaurant owner admin page
 */
function is_restaurant_admin() {
	if ( isset( $GLOBALS['current_screen'] ) )
		return $GLOBALS['current_screen']->in_admin( 'restaurant' );
	elseif ( defined( 'SS_RESTAURANT_ADMIN' ) )
		return WP_RESTAURANT_ADMIN;

	return false;
}

/**
 * Whether the current request is for a user admin screen 
 *
 * @return bool True if inside user admin page
 */
function is_user_admin() {
	if ( isset( $GLOBALS['current_screen'] ) )
		return $GLOBALS['current_screen']->in_admin( 'user' );
	elseif ( defined( 'WP_USER_ADMIN' ) )
		return WP_USER_ADMIN;

	return false;
}

/**
 * Whether the current request is for a host admin screen 
 *
 * @return bool True if inside a host admin page
 */
function is_host_admin() {
	if ( isset( $GLOBALS['current_screen'] ) )
		return $GLOBALS['current_screen']->in_admin( 'host' );
	elseif ( defined( 'SS_HOST_ADMIN' ) )
		return SS_HOST_ADMIN;

	return false;
}