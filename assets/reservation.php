<?php

function make_reservation($data, $redirect = false) {
    global $ssdb;
    $reservation_id = $ssdb->insert("reservations", $data);

    if ($redirect) {
        $location = HOME_URI . "/?reservation_id=$reservation_id";
        header("Location: $location");
        exit;
    }
}

function confirm_reservation($key){
    
    global $ssdb;
    global $restaurant;
    $table_to_update = "reservations";
    $data["confirmed"] = 1;
    $keys["reservation_id"] =  "\"". $key .  "\"";

    $ssdb->update($table_to_update, $data ,  $restaurant->ID, $keys);
}


function get_reservation_date(){
    global $reservation;
    return strtotime($reservation->date);
}

function get_reservation_time(){
    global $reservation;
    return strtotime($reservation->time);
}

function get_reservation_party(){
    global $reservation;
    return $reservation->party;
}

function get_reservation_name(){
    global $reservation;
    return $reservation->name; 
}

function get_reservation_by($field, $value) {

    $reservation_data = Reservation::get_data_by($field, $value);
    //var_dump($reservation_data);

    if (!$reservation_data)
        return false;

    //Load the user here
    $reservation = new Reservation($reservation_data);

    return $reservation;
}

class Reservation {

    public function __construct($data) {


        foreach (get_object_vars($data) as $key => $value)
            $this->$key = $value;
    }

    public static function get_data_by($field, $value) {


        global $ssdb;

        //Check if searching by user_id
        if ('reservation_id' == $field) {
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
            case 'reservation_id':
                $user_id = $value;
                $db_field = 'reservation_id';
                break;
            case 'email':
                $user_email = $value;
                $db_field = 'email';
                break;
            default:
                return false;
        }


        if (!$reservation = $ssdb->get_row(
                //"SELECT * FROM $ssdb->users WHERE $db_field = $value"
                "SELECT * FROM  " . "reservations" . " WHERE " . $db_field . " = \"" . $value . "\""
                ))
            return false;


        
        return $reservation;
    }
    
    public function delete_reservation($redirect = "index"){
        global $ssdb;
        $id = $this->reservation_id;
        $sql = "DELETE FROM `reservations` WHERE `reservation_id` = $id";
        $ssdb->query($sql );
        if($redirect == "index"){
            $home = get_home_url();
            header("Location: $home");
                exit;
        }
        
    }
    
    public function get_reservation_date(){
        return $this->date;
    }
    
    public function get_reservation_time(){
        return $this->time;
    }
    
    public function get_reservation_url(){
        return HOME_URI . "/?reservation_id=" . $this->reservation_id;
    }
    
    public function get_restaurant_name(){
        global $ssdb;
        $sql = "SELECT NAME FROM  " . "restaurants" . " WHERE " . "ID" . " = \"" . $this->ID . "\"";
        $name = $ssdb->get_row($sql);
        return $name->NAME;
    }

}
