<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_restaurant_gallery(){
    global $restaurant;
    return $restaurant->get_restaurant_gallery();
}

function restaurant_confirm_changes(){
    global $restaurant;
    return $restaurant->restaurant_confirm_changes();
}

function get_restaurant_reservations(){
    global $restaurant;
    return $restaurant->get_restaurant_reservations();
}

function get_restaurant_status(){
    global $restaurant;
    return $restaurant->get_restaurant_status();
}

function get_restaurant_formatted_status(){
    global $restaurant;
    return $restaurant->get_restaurant_formatted_status();
}

function get_restaurant_distance(){
    global $restaurant;
    return $restaurant->get_restaurant_distance();
}

function load_restaurant_main_img(){
    global $restaurant;
    $user_type = get_user_type();
    
    if($user_type == "system_admin" || is_admin()){
         if($restaurant->main_img_pending){
             echo  $restaurant->get_restaurant_main_img_pending();
         }else{
             echo get_template_image("placeholder.jpg");
         }
    }else{
        if($restaurant->main_img){
             echo  $restaurant->get_restaurant_main_img();
         }else{
             echo get_template_image("placeholder.jpg");
         }
    }
}

function get_restaurant_main_img(){
    global $restaurant;  
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
         if($restaurant->main_img_pending){
             return $restaurant->get_restaurant_main_img_pending();
         }else{
             return get_template_image("placeholder.jpg");
         }
    }else{
        if($restaurant->main_img){
             return $restaurant->get_restaurant_main_img();
         }else{
             return get_template_image("placeholder.jpg");
         }
    }
    
}


function get_restaurant_schedule(){
    global $restaurant;
    return $restaurant->get_restaurant_schedule();
}

function get_restaurant_tables(){
    global $restaurant;
    return $restaurant->get_restaurant_tables();
}

function get_restaurant_place_id(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
        if($restaurant->place_id_pending != ""){
             return $restaurant->place_id_pending;
        }else{
            return false;
        }  
    }else{
      if($restaurant->place_id != ""){
             return $restaurant->place_id;
        }else{
            return false;
        }  
    }
}

function get_restaurant_formatted_location(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
        if($restaurant->formatted_location_pending != ""){
             return $restaurant->formatted_location_pending;
        }else{
            return false;
        }  
    }else{
      if($restaurant->formatted_location != ""){
             return $restaurant->formatted_location;
        }else{
            return false;
        }  
    }
    
}

function get_restaurant_lat(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
        if($restaurant->lat_pending != ""){
             return $restaurant->lat_pending;
        }else{
            return false;
        }  
    }else{
      if($restaurant->lat != ""){
             return $restaurant->lat;
        }else{
            return false;
        }  
    }
    
}

function get_restaurant_ID(){
    global $restaurant;
    return $restaurant->ID;
}

function get_restaurant_long(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
        if($restaurant->long_pending != ""){
             return $restaurant->long_pending;
        }else{
            return false;
        }  
    }else{
      if($restaurant->long != ""){
             return $restaurant->long;
        }else{
            return false;
        }  
    }
    
    
}

function get_restaurant_images(){
    global $restaurant;
    return $restaurant->get_restaurant_images();
    
}

function get_restaurant_website(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
        return $restaurant->website_pending; 
    }else{
        return $restaurant->website; 
    }
    
}

function get_restaurant_name(){
    global $restaurant;
    $user_type = get_user_type();
    
    if($user_type == "system_admin" || is_admin()){
       return $restaurant->name_pending;  
    }else{
      return $restaurant->NAME;  
    }
    
}

function get_restaurant_location(){
    global $restaurant;
    return $restaurant->location;
}

function get_restaurant_is_open(){
    global $restaurant;
    if ($restaurant->is_open == "1"){
       return true;
    }else{
        return false;
    }
    
}

function get_restaurant_reservation_enabled(){
    global $restaurant;
    if ($restaurant->reservation_enabled == "1"){
       return true;
    }else{
        return false;
    }
    
}

function get_restaurant_cuisine(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
       return $restaurant->cuisine_pending;  
    }else{
      return $restaurant->cuisine;  
    }
}

function get_restaurant_reserve_url(){
    global $restaurant;
    return HOME_URI . "?restaurant_id=" .$restaurant->ID . "#reservation_form";
}

function get_restaurant_phone_number(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
       return $restaurant->phone_number_pending;  
    }else{
      return $restaurant->phone_number;  
    }
}

function get_restaurant_description(){
    global $restaurant;
    $user_type = get_user_type();
    if($user_type == "system_admin" || is_admin()){
       return $restaurant->description_pending;  
    }else{
      return $restaurant->description;  
    }
}

function get_restaurant_hosts(){
    global $restaurant;
    return $restaurant->get_restaurant_hosts();
}

function update_restaurant_values($data , $table = "main", $keys = null){
    
    global $ssdb;
    global $restaurant;
    //$data["ID"] = $restaurant->ID; 
    switch ($table) {
        case 'main':
            $table_to_update = $ssdb->restaurants;
            break;
        case 'media':
            $table_to_update = $ssdb->media;
            break;
        case 'schedule':
            $table_to_update = $ssdb->schedule;
            break;
        case 'tables':
            $table_to_update = "tables";
            break;
        default:
            break;
    }

//var_dump($table_to_update);
    //$ssdb->update($ssdb->restaurants, $data ,  $restaurant->ID);
    $ssdb->update($table_to_update, $data ,  $restaurant->ID, $keys);
}

function get_directions_url(){
    global $restaurant;
    $lat = get_restaurant_lat();
    $long = get_restaurant_long();
    $url = "https://www.google.com/maps/dir//$lat,$long/";
    return $url;
}

function register_new_restaurant($restaurant_name, $user_id) {
    global $ssdb;
    //$data['ID'] = "\"" . rand() ."\"" ;
    $data['name_pending'] = "\"" . $restaurant_name . "\"";
    $data['user_ID'] = "\"" . $user_id . "\"";
    $ssdb->insert($ssdb->restaurants, $data);
}

function get_restaurant_by($field, $value) {
    
    $restaurant_data = Restaurant::get_data_by($field, $value);

    if (!$restaurant_data)
        return false;

    //Load the user here
    $restaurant = new Restaurant($restaurant_data);
 
    return $restaurant;
}

class Restaurant {

    public function __construct($data) {
        global $ssdb;
        
        
        foreach (get_object_vars($data) as $key => $value)
            $this->$key = $value;
    }
    
        public static function get_data_by($field, $value) {

        
        global $ssdb;

        //Check if searching by user_id
        if ('ID' == $field) {
            // Make sure the value is numeric to avoid casting objects, for example,
            // to int 1.
            if (!is_numeric($value))
                return false;
            $value = intval($value);
            if ($value < 1)
                return false;
        } else {
            $value = trim($value);
        }

        if (!$value)
            return false;

        switch ($field) {
            case 'ID':

                $db_field = 'ID';
                break;
            case 'user_ID':

                $db_field = 'user_ID';
                break;

            default:
                return false;
        }

        
        if (!$restaurant = $ssdb->get_row(
                        //"SELECT * FROM $ssdb->users WHERE $db_field = $value"
                        "SELECT * FROM  ". $ssdb->restaurants. " WHERE " . $db_field . " = \"" . $value ."\""
                ))
            return false;

        

        return $restaurant;
    }
    
    public function update_restaurant_value($field, $value) {
        global $ssdb;
    }
    
    public function restaurant_has_main_img(){
        
        if(isset($this->main_img) && $this->main_img != NULL){
            return true;
        }else{
            return false;
        }
    }
    
    public function get_restaurant_images(){
        global $ssdb;
        $images = array();
        $results = $ssdb->get_row(
                        //"SELECT * FROM $ssdb->users WHERE $db_field = $value"
                        "SELECT * FROM  ". $ssdb->media. " WHERE `ID`  = \"" . $this->ID ."\""
                );
        
        if (isset($results->image_1) && $results->image_1 != NULL) {
            $images["image_1"] = "data:image/jpeg;base64," . base64_encode($results->image_1);
        }else{
            $images["image_1"] = ROOT . TEMPLATES . "/img/" . "placeholder.jpg";
        }

        if (isset($results->image_2) && $results->image_2 != NULL) {
            $images["image_2"] = "data:image/jpeg;base64," . base64_encode($results->image_2);
        }else{
            $images["image_2"] = ROOT . TEMPLATES . "/img/" . "placeholder.jpg";
        }

        if (isset($results->image_3) && $results->image_3 != NULL) {
            $images["image_3"] = "data:image/jpeg;base64," . base64_encode($results->image_3);
        }else{
            $images["image_3"] = ROOT . TEMPLATES . "/img/" . "placeholder.jpg";
        }

        if (isset($results->image_4) && $results->image_4 != NULL) {
            $images["image_4"] = "data:image/jpeg;base64," . base64_encode($results->image_4);
        }else{
            $images["image_4"] = ROOT . TEMPLATES . "/img/" . "placeholder.jpg";
        }
        return $images;
    }
    
    
       public function get_restaurant_gallery(){
        global $ssdb;
        $images = array();
        
        array_push( $images , get_restaurant_main_img());
                
                
        $results = $ssdb->get_row(
                        //"SELECT * FROM $ssdb->users WHERE $db_field = $value"
                        "SELECT * FROM  ". $ssdb->media. " WHERE `ID`  = \"" . $this->ID ."\""
                );
        
        if (isset($results->image_1) && $results->image_1 != NULL) {
               array_push( $images , "data:image/jpeg;base64," . base64_encode($results->image_1));
        }

        if (isset($results->image_2) && $results->image_2 != NULL) {
            array_push( $images , "data:image/jpeg;base64," . base64_encode($results->image_2));
        }

        if (isset($results->image_3) && $results->image_3 != NULL) {
            array_push( $images , "data:image/jpeg;base64," . base64_encode($results->image_3));
        }

        if (isset($results->image_4) && $results->image_4 != NULL) {
            array_push( $images , "data:image/jpeg;base64," . base64_encode($results->image_4));
        }
        return $images;
    }
    
    public function get_restaurant_main_img(){
        if(isset($this->main_img) && $this->main_img != NULL){
            return "data:image/jpeg;base64," .base64_encode($this->main_img);
        }
    }
    
    public function get_restaurant_main_img_pending(){
        if(isset($this->main_img_pending) && $this->main_img_pending != NULL){
            return "data:image/jpeg;base64," .base64_encode($this->main_img_pending);
        }
    }
    
    public function get_restaurant_schedule(){
        global $ssdb;
        $schedule = array();
        $results = $ssdb->get_results(
                        
                        "SELECT * FROM  ". $ssdb->schedule. " WHERE `ID`  = \"" . $this->ID ."\" "
                );
        
        if ($results) {
            foreach ($results as $day) {
                //var_dump($day);
                $day_num = intval($day->day);
                if ($day->active == "1") {
                    $schedule[$day_num]["active"] = TRUE;
                } else {
                    $schedule[$day_num]["active"] = FALSE;
                }
                if ($day->start_time != NULL)
                    $schedule[$day_num]["start_time"] = $day->start_time;
                if ($day->end_time != NULL){
                    $schedule[$day_num]["end_time"] = $day->end_time;
                }
                
                
            }
        }
        
        return $schedule;
    }
    
       public function get_restaurant_tables(){
        global $ssdb;
        $tables = array();
        $results = $ssdb->get_results(
                        
                        "SELECT * FROM  ". "tables" . " WHERE `ID`  = \"" . $this->ID ."\" "
                );
        
        if ($results) {
            foreach ($results as $table) {
                
                $table_ID = intval($table->table_ID);
                
                if ($table->active == 1) {
                    $tables[$table_ID]["active"] = TRUE;
                } else {
                    $tables[$table_ID]["active"] = FALSE;
                }
                if ($table->count != NULL)
                    $tables[$table_ID]["count"] = $table->count;
                if ($table->capacity != NULL)
                    $tables[$table_ID]["capacity"] = $table->capacity;
                
                
            }
        }
       
        return $tables;
    }
    
    
    public function get_restaurant_reservation_enabled(){
        return $this->reservation_enabled;
    }
    
    public function get_restaurant_hosts(){
        global $ssdb;
        $hosts = array();
        $results = $ssdb->get_results(
                        
                        "SELECT * FROM  ". "users" . " WHERE `restaurant_ID`  = \"" . $this->ID ."\" "
                );
        if($results){
            foreach ($results as $host_data) {
                $host = new User($host_data);
                array_push($hosts , $host);
            }
            return $hosts;
        }else{
            return false;
        }
    
    }
    
    
    public function get_restaurant_reservations(){
        global $ssdb;
        $reservations = array();
        $sql = "SELECT * FROM  ". "`reservations`" . " WHERE `ID`  = \"" . $this->ID ."\"  AND `confirmed` = 0";
        //var_dump($sql);
        $results = $ssdb->get_results($sql);
        if($results){
            foreach ($results as $reservation) {
                $data = array();
                $data["time"] = $reservation->time;
                $data["party"] = $reservation->party;
                $data["email"] = $reservation->email;
                $data["name"] = $reservation->name;
                $data["reservation_id"] = $reservation->reservation_id;
                array_push($reservations , $data);
            }
            return $reservations;
        }else{
            return false;
        }
   
    }
    
    
    public function get_restaurant_distance(){
        return round($this->distance , 1);
    }
    
    public function get_restaurant_status(){
        return $this->status;
    }
    
    public function get_restaurant_formatted_status(){
        switch($this->status){
            case 'ready':
                $status = "New";
                break;
            case 'pending':
                $status = "Pending Changes";
                break;
            case 'active':
                $status = "Active";
                break;
            default :
                break;
            
        }
        
        return $status;
    }
    
    public function restaurant_confirm_changes(){
        global $ssdb;
        $ID = $this->ID;
        $sql = "UPDATE `restaurants` 
            SET 
            `formatted_location` = `formatted_location_pending` ,
             `place_id`  = `place_id_pending` , 
            `lat` = `lat_pending` , 
            `long` = `long_pending`, 
             `cuisine` = `cuisine_pending` ,
             `phone_number` = `phone_number_pending` ,
            `description` =`description_pending`,
            `website` = `website_pending`,
            `main_img` =`main_img_pending`,
            `NAME` = `name_pending`
            WHERE `ID` =  \"$ID\"";
        
        $ssdb->query($sql);
    }

}
