<?php

/**
 * Begin initialization here! :D
 * 
 */

if(!isset($set_header)){
    $set_header = true;
    require_once (dirname(__FILE__) . '/master-load.php');
    
    
    /*
     * SET UP THE SuperSeater Object
     * NOW READY TO CONSTRUCT THE ACTUAL PAGE
     */
    ss();
    
    require( ABSPATH . ASSETS . '/template-loader.php' );
}