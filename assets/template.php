<?php

/**
 * Super Seater Template API use these functions to print data onto the templates
 */

function print_title(){
    global $restaurant;
    echo get_restaurant_name();

}

function print_restaurant_url(){
    global $restaurant;

    if(isset($restaurant->ID)) echo HOME_URI . "/?restaurant_id=" .$restaurant->ID;
    
}

function print_id(){
    global $restaurant;
    if(isset($restaurant->ID)) echo $restaurant->ID;
}

function print_home_url(){
    echo HOME_URI;
}

function get_home_url(){
    return HOME_URI;
}

function print_login_url(){
    echo HOME_URI . "/login";
}

function print_logout_url(){
    echo HOME_URI . "/logout";
}

function print_register_url(){
    echo HOME_URI . "/register";
}

function print_register_restaurant_url(){
    echo HOME_URI . "/restaurant-register";
}

function print_admin_url(){
    echo HOME_URI . "/admin";
}

function print_restaurant_hours(){
    global $restaurant;
    $day_names = array("Sunday" , "Monday" , "Tuesday", "Wednesday", "Thursday", "Friday" , "Saturday");
    $schedule = get_restaurant_schedule();
    //var_dump($schedule[0]);
    echo "<table class=\"restaurant_hours\">";
    
    for($day = 0; $day < 7; $day++){
       echo "<tr>";
       echo "<th>$day_names[$day]</th>";
       if($schedule[$day]["active"]){
           $start_time = date("g:i  A", strtotime($schedule[$day]["start_time"])) ; 
           $end_time = date("g:i  A", strtotime($schedule[$day]["end_time"])) ;
           
           echo "<td>$start_time</td><td>$end_time</td>";
       }else{
           echo "<td colspan=\"2\">Closed</td>";
       }
       
       echo "</tr>";  
    }
    
    
    echo "</table>";
    
}