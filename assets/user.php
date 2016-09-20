<?php

function change_password($new_password = null){
    global $current_user;
    $current_user->change_password($new_password);
}

function delete_account(){
    global $current_user;
    $current_user->delete_account();
}

function get_user_email(){
    global $current_user;
    return $current_user->user_email;
}

function get_user_name(){
    global $current_user;
    return $current_user->user_name;
}

function get_user_reservations() {
    global $current_user;
    return $current_user->get_user_reservations();
}

function get_user_type(){
    global $current_user;
    if($current_user){
        return $current_user->get_user_type();
    }else{
        return false;
    }
    
}

function get_available_admin_tabs(){
    global $current_user;
    return $current_user->get_available_admin_tabs();
}


function sign_on() {


    if (!empty($_POST['user_email']))
        $credentials['user_email'] = $_POST['user_email'];

    if (!empty($_POST['user_password']))
        $credentials['user_password'] = $_POST['user_password'];




    //REMEMBER TO SANITIZE INPUT LATER

    $password_hash = hash("md5", $credentials['user_password']);
    if ($user = get_user_by('user_email', $credentials['user_email'])) {


        if ($user->user_password == $password_hash) {
            set_authentication_cookie($user->ID);
            $location = HOME_URI . "/admin";
            header("Location: $location");
            exit;
        }
    } else {
       
        return "error";
    }
}



function set_authentication_cookie($user_id) {

 

    //$cookie = $user_id . add more stuff here;

    setcookie(AUTHENTICATION_COOKIE, $user_id , 0, "/", "", false, true);
}

function username_exists($user_name) {

    if ($user = get_user_by('user_name', $user_name)) {
        return $user->ID;
    } else {
        return null;
    }
}

function email_exists($user_email) {

    if ($user = get_user_by('user_email', $user_email)) {
        return $user->ID;
    } else {
        return null;
    }
}

function get_user_by($field, $value) {
    
    $userdata = User::get_data_by($field, $value);

    if (!$userdata)
        return false;

    //Load the user here
    $user = new User($userdata);
 
    return $user;
}

function verify_password($password){
    
    return true;
    
}

function is_logged_in(){
    global $super_seater;
    return $super_seater->is_logged_in();
}

function register_new_user($user_name, $user_email, $user_password, $user_confirm_password , $type = "user" , $restaurant_name = null, $restaurant_ID = null) {
    $login_errors = array();
    $sanitized_user_login = sanitize_user_name($user_name);

    //$user_email = filter_var($user_email ,FILTER_VALIDATE_EMAIL );
    //Check Username
    if ($sanitized_user_login == '') {
        array_push($login_errors, 'empty_user_name');
    } else if (!validate_username($user_name)) {
        array_push($login_errors, 'invalid_user_name');
    } else if (username_exists($sanitized_user_login)) {
        array_push($login_errors, 'taken_user_name');
    }
    

    //Check Email
    if ($user_email == '') {
        array_push($login_errors, 'empty_user_email');
    } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        array_push($login_errors, 'invalid_user_email');
    } else if(email_exists($user_email)){
        array_push($login_errors, 'taken_user_email');
    }
    
    //if this is going to be a new restaurant owner, then check the restaurant name
    if($type == "restaurant_owner"){
        if($restaurant_name == ''){
           array_push($login_errors, 'empty_restaurant_name'); 
        }
        
    }
    
    
    
    
    //check passwords
    if($user_password == ''){
         array_push($login_errors, 'empty_user_password');
    }else if ($user_password != $user_confirm_password){
        array_push($login_errors, 'missmatch_user_password');
    }else if (!verify_password($user_password)){
        array_push($login_errors, 'invalid_user_password');
    }else{
        $password_to_save = hash("md5" ,$user_password);
    }
    
    
    
    //var_dump($login_errors);
    if($login_errors) return $login_errors;
    
    create_user($user_name, $user_email, $password_to_save , $type , $restaurant_ID);
    
    //VALIDATE THAT THE USER WAS CREATED
    if ($user = get_user_by("user_email", $user_email)) {
        
        //Next, if this is a restaurant owner, then register a new restaurant
        if($type == "restaurant_owner"){
            register_new_restaurant($restaurant_name, $user->ID);
        }
        if($type != 'host'){
            set_authentication_cookie($user->ID);
            $location = HOME_URI . "/admin";
            header("Location: $location");
            exit;
        }
      
    }
}

function create_user($user_name, $user_email, $user_password , $type , $restaurant_ID = null) {
        global $ssdb;
        $data['ID'] = "\"" . rand() ."\"" ;
        $data['user_name'] = "\"". $user_name . "\"";
        $data['user_email'] = "\"" . $user_email. "\"";
        $data['user_password'] =  "\"" .$user_password. "\"";
        $data['type'] =  "\"" .$type. "\"";
        if ($restaurant_ID) $data["restaurant_ID"] = "\"" . $restaurant_ID . "\"";
        $ssdb->insert( $ssdb->users, $data  );


}

function delete_user($user_ID , $redirect = false){
    global $ssdb;
    $sql = "DELETE from users WHERE `ID` = $user_ID";
    var_dump($sql);
    $ssdb->query($sql);
    
}

function sanitize_user_name($user_name) {


    $raw_username = $user_name;
    $user_name = strip_tags($user_name);
    //var_dump($user_name);
    //$username = remove_accents( $username );
    // Kill octets
    $user_name = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $user_name);
    $user_name = preg_replace('/&.+?;/', '', $user_name); // Kill entities

    return $user_name;
}

function validate_username($user_name) {
    $sanitized = sanitize_user_name($user_name);
    return ( $sanitized == $user_name );
}

function get_user_password(){
    global $current_user;
    return $current_user->user_password;
}

class User {

    public function __construct($data) {


        foreach (get_object_vars($data) as $key => $value)
            $this->$key = $value;
    }

    public static function get_data_by($field, $value) {

        
        global $ssdb;

        //Check if searching by user_id
        if ('user_id' == $field) {
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
                $user_id = $value;
                $db_field = 'ID';
                break;
            case 'user_name':
                $user_name = $value;
                $db_field = 'user_name';
                break;
            case 'user_email':
                $user_email = $value;
                $db_field = 'user_email';
                break;
            default:
                return false;
        }

        
        if (!$user = $ssdb->get_row(
                        //"SELECT * FROM $ssdb->users WHERE $db_field = $value"
                        "SELECT * FROM  ". $ssdb->users. " WHERE " . $db_field . " = \"" . $value ."\""
                ))
            return false;

        

        return $user;
    }
    
    
    public function get_user_type(){
        //Doing this to prevent unauthorized user types
        if (!isset($this->type) || $this->type == "user" || $this->type == '' ){
            return "user";
        }else if ($this->type == "restaurant_owner"){
            return "restaurant_owner";
        }else if ($this->type == "host"){
            return "host";
        }else if ($this->type == "system_admin"){
            return "system_admin";
        }
    }
    
    public function get_available_admin_tabs(){
        $tabs = array();
        //push the dashboard tab to all user types
        $tab_info = array("tab" => "dashboard" , "title" => "Dashboard" , "icon" =>"glyphicon-home");
        array_push($tabs, $tab_info);
        
        
        
        switch (get_user_type()) {
            case "user":
                //Push Reservations
                $tab_info = array("tab" => "reservations", "title" => "Reservations", "icon" => "glyphicon-tag");
                array_push($tabs, $tab_info);

                break;
            case "restaurant_owner":
                //Push Reservations
                $tab_info = array("tab" => "basic-info", "title" => "Basic Information", "icon" => "glyphicon-th-list");
                array_push($tabs, $tab_info);
                
                $tab_info = array("tab" => "hours", "title" => "Buisness Hours", "icon" => "glyphicon-calendar");
                array_push($tabs, $tab_info);
                
                $tab_info = array("tab" => "gallery", "title" => "Manage Gallery", "icon" => "glyphicon-picture");
                array_push($tabs, $tab_info);
                
                $tab_info = array("tab" => "tables", "title" => "Manage Tables", "icon" => "glyphicon-cutlery");
                array_push($tabs, $tab_info);
                
                $tab_info = array("tab" => "employees", "title" => "Manage Employees", "icon" => "glyphicon-user");
                array_push($tabs, $tab_info);
                
                break;
            case "host" :
                break;
            default:
                break;
        }

        //Push Reservations
        $tab_info = array("tab" => "settings" , "title" => "Settings" , "icon" =>"glyphicon glyphicon-cog");
        array_push($tabs, $tab_info);
        
        return $tabs;
    }
    
    public function get_user_reservations(){
        global $ssdb;
        
        $sql = "SELECT * FROM  ". "reservations". " WHERE " . "email" . " = \"" . $this->user_email ."\"" . "ORDER BY `date`";
        
        if($reservation_data = $ssdb->get_results($sql)){
        $reservations = array();
        foreach($reservation_data as $data){
            array_push($reservations, new Reservation($data));
        }
        return $reservations;
        }else{
            return false;
        }
        
    }
    
    public function change_password($new_password = null){
        
        global $ssdb;
        $user_id = $this->ID;
        $sql = "UPDATE `users` SET `user_password` = \"$new_password\" WHERE `ID` = $user_id";
        $ssdb->query($sql);
        
    }
    
    public function delete_account(){
        global $ssdb;
        $user_id = $this->ID;
        
        
        if($this->type == "restaurant_owner"){
            $restaurant_id = $this->restaurant_ID;
            $sql = "DELETE FROM `users` WHERE `restaurant_ID` = $restaurant_id";
            $ssdb->query($sql);
            $sql = "DELETE FROM `restaurants` WHERE `ID` = $restaurant_id  LIMIT 1   ";
            $ssdb->query($sql);
        }
        
        $sql = "DELETE FROM `users` WHERE `ID` = $user_id LIMIT 1";
        $ssdb->query($sql);
        
        $location = HOME_URI . "/logout";
        header("Location: $location");
        exit;
    }

}
