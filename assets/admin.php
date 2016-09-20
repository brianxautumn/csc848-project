<?php

/**
 * Admin related API
 * Use these functions for the admin tabs
 */

function validate_img_upload(){
    
    return true;
}

function generate_admin_tabs(){
    //$active_tab == get_active_admin_tab();
    $tabs = get_available_admin_tabs();
    $active_tab = get_admin_tab();
    echo "<div class=\"accordion\">";
    foreach ($tabs as $tab){
    //commandes
        $active = '';
        if ($tab["tab"] == $active_tab) $active = 'active';
        $title = $tab["title"];
        $link = HOME_URI ."/admin/" . $tab["tab"];
        $icon = $tab["icon"];
        
        
        echo " <div class=\"accordion-group\">";
        echo "<div class=\"accordion-heading\">";          
        echo "<a class=\"admin_tab btn-default $active\" href=\"$link\">";        
        echo "<span class=\"glyphicon $icon\"></span>";            
        echo "&nbsp;&nbsp; $title";
        echo "</a>";
        echo "</div>";
        echo "</div>";
                        
    }
    
    echo "</div>";
  
    
}

function get_admin_tab(){
    global $super_seater;
    return $super_seater->get_admin_tab();
}

function load_restaurant_info_tab(){
    include template_path("admin-restaurant-basic-info.php");
}

function load_dashboard_tab($type = "user"){
    include template_path("admin-dashboard-user.php");
}

function load_restaurant_dashboard_tab(){
    include template_path("admin-dashboard-restaurant.php");
}

function load_system_admin_dashboard_tab(){
    include template_path("admin-dashboard-system.php");
}


function load_restaurant_gallery_tab(){
    include template_path("admin-restaurant-gallery.php");
}

function load_restaurant_hours_tab(){
    include template_path("admin-restaurant-hours-tab.php");
}

function load_restaurant_tables_tab(){
    include template_path("admin-restaurant-tables-tab.php");
}

function load_restaurant_employees_tab(){
    include template_path("admin-restaurant-employees-tab.php");
}

function load_reservations_tab(){
    include template_path("admin-reservations-tab.php");
}

function load_host_dashboard_tab(){
    include template_path("admin-host-dashboard-tab.php");
}

function print_time_selector($id , $default = "00:00") {
    $start = "00:00";
    $end = "23:30";
    
    $tStart = strtotime($start);
    $tEnd = strtotime($end);
    $time = $tStart;
    $selected_time = strtotime($default);

    echo "<select  class=\"form-control form-primary\" name=\"$id\"id=\"$id\">" ;
    
    while ($time <= $tEnd) {
        $selected = "";
        if ($selected_time == $time) $selected = "selected";
        echo "<option $selected>" . date("g:i  A", $time) . "</option>";
        $time = strtotime('+30 minutes', $time);
    }

    echo "</select>";
}


function print_capacity_selector($id, $default = null) {
    $print_id = $id + 1;
    echo "<tr>";
    $checked = "";
    if ($default["active"] == true) $checked = "checked";
    $table_enabled = "table_" . $id . "_enabled";
    echo "<td class=\"\"><input  type=\"checkbox\" class=\"\" name=\"$table_enabled\" id=\"$table_enabled\" $checked></td>";
    echo " <td>";
    $table_count = "table_" . $id . "_count";
    echo "<select  class=\"form-control form-primary\" name=\"$table_count\"id=\"$table_count\">" ;
    for($i = 1; $i <= 20 ; $i++){
        $selected = "";
        if ($i == $default["count"]) $selected = "selected";
        echo "<option $selected>$i</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "<td>";
    $table_capacity = "table_" . $id . "_capacity";
    echo "<select  class=\"form-control form-primary\" name=\"$table_capacity\"id=\"$table_capacity\">" ;
    for($i = 1; $i <= 20 ; $i++){
         $selected = "";
        if ($i == $default["capacity"]) $selected = "selected";
        echo "<option $selected>$i</option>";
    }
    
    echo "</select>";
    echo "</td>";
                                    
    echo "</tr>";
}