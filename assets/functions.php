<?php

/** 
 * MAIN Super Seater API
 * 
 * Use the functions here instead of directly accessing global objects and stuff
 */

/**
 * Set up the superSeater query.
 *
 *
 * @param string $query_vars Default arguments.
 */
function ss( $query_vars = '' ) {
        
	global $super_seater, $ss_query, $ss_master_query;
	$super_seater->main( $query_vars );

	if ( !isset($ss_master_query) )
		$ss_master_query = $ss_query;
}


function check_connection(){
    global $ssdb;
    $ssdb->check_connection(true);
}

function template_path($template){
    return  TEMPLATES . "/" .$template;
}

function load_template_image($image){
    echo ROOT . TEMPLATES . "/img/" . $image;
}


function get_template_image($image){
    return ROOT . TEMPLATES . "/img/" . $image;
}



function load_html_header(){
    //This needs to be finished once we have all the page template parts , for now just get the index
    include template_path('html-header.php');
}

function load_html_footer(){
    //This needs to be finished once we have all the page template parts , for now just get the index
    include template_path('html-footer.php');
}

function load_front_page_template(){
    //This needs to be finished once we have all the page template parts , for now just get the index
    include template_path('index.php');
}


function load_search_page_template(){
    //This needs to be finished once we have all the page template parts , for now just get the index
    include template_path('search.php');
}

function load_search_form(){
    //This needs to be finished once we have all the page template parts , for now just get the index
    include template_path('search-form.php');
}

function load_admin_map_scripts(){
    include template_path('admin-map-scripts.php');
}

function load_restaurant_map_scripts(){
    include template_path('restaurant-map-scripts.php');
}

function load_restaurant_page_template(){
    include template_path('restaurant.php');
}

function  load_reservation_template(){
    include template_path('reservation.php');
}



function load_register_restaurant_template(){
    include template_path('restaurant-register.php');
}


function load_footer(){
    include template_path('footer.php');
}

function load_top_bar(){
    include template_path('top-bar.php');
}

function load_search_result(){
    include template_path('search-result.php');
}

function load_register_page_template(){
    include template_path('register.php');
}

function load_login_template(){
    include template_path('login.php');
}

function load_admin_page_template(){
    include template_path('admin.php');
}

function load_reservation_form(){
    include template_path('reservation-form.php');
}

function load_search_pagination(){
    include template_path('search-pagination.php');
}


function load_search_map_scripts($markers = null){
    include template_path('search-map-scripts.php');
}

function load_map_icon($number){
    $location = "map-icons/number_" . $number . ".png";
    return load_template_image($location);
}

function load_map_icon_active($number){
    $location = "map-icons-active/number_" . $number . ".png";
    return load_template_image($location);
}

function load_settings_tab(){
    include template_path("admin-settings-tab.php");
}