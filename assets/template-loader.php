<?php

/**
 * This file assembles all the parts of the template based on the url that the user is on!
 */


//This is just for testing, get rid of this later

/**
 * 
 * Okay first we have to decide what page we are on, then decide which template to use
 */

load_html_header();
load_top_bar();

if (is_front_page()){
    
    load_front_page_template();
    //Load the front page template
}else if (is_register()){

    load_register_page_template();
    
}else if (is_restaurant_register()){

    load_register_restaurant_template();
    
} else if (is_login()){

    load_login_template();

}else if (is_admin()){
    
    load_admin_page_template();

}else if (is_search()){
    
    load_search_page_template();
    
}  else if (is_restaurant()){
    
    load_restaurant_page_template();
    
}  else if (is_reservation()){
    
     load_reservation_template();
}



load_html_footer();
 