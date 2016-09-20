<?php

/**
 * Holds Query Object, and API to access it. Use these functions to interact with the query object in the templates
 */

/**
 * Checks to see if we are on the front page of the site
 *
 * @return bool true if is on the front page of the site
 */
function is_front_page() {
    global $ss_query;

    if (!isset($ss_query)) {
        echo "You are doing somethign wrong.";
        return false;
    }
    return $ss_query->is_front_page();
    

}

function is_page(){
    return false;
}

function is_reservation(){
    global $ss_query;
    return $ss_query->is_reservation();
}

function get_restaurant_count(){
    global $ss_query;
    return $ss_query->get_restaurant_count();
}

function is_restaurant_register(){
    global $ss_query;
    return $ss_query->is_restaurant_register();
}

function is_search(){
    global $ss_query;

    if (!isset($ss_query)) {
        echo "You are doing somethign wrong.";
        return false;
    }
    return $ss_query->is_search();
    

}

function is_restaurant(){
    global $ss_query;
    return $ss_query->is_restaurant();
}

function have_results() {
    global $ss_query;
    return $ss_query->have_results();
}

function load_restaurant() {
	global $ss_query;

	$ss_query->load_restaurant();
}

function is_register() {
	global $ss_query;
        
	return $ss_query->is_register();
}

function is_login() {
	global $ss_query;
        
	return $ss_query->is_login();
}


function is_admin() {
	global $ss_query;
        
	return $ss_query->is_admin();
}

function get_search_lat(){
    global $ss_query;
        
	return $ss_query->query_array['lat'];
}

function get_search_long(){
    global $ss_query;
        
	return $ss_query->query_array['long'];
}

function get_search_string(){
    global $ss_query;
        
	return $ss_query->query_array['string'];
}

function get_search_restaurant_number(){
    global $ss_query;
    return $ss_query->current_restaurant;
}
/*
 * Master Query Class
 */

class SuperSeater_Query {

    /**
     * unparsed query
     * @access public
     * @var array
     */
    public $query;

    /**
     * query after parsing

     * @var array query array for parsing
     */
    public $query_array = array();
    
    public $is_search = false;
    
    public $is_admin = false;
    
    public $is_front_page = false;
    
    public $is_restaurant_register = false;
    
    public $is_page = false;
    
    public $is_reservation = false;
    
    public $is_restaurant = false;
    
    public $is_login = false;
    
    public $results;
    
    public $restaurant_count = 0;
    
    public $current_restaurant = -1;
    
    public $restaurants;
    
    public $restaurant;
    
    public $queried_object;
    
    public $queried_object_id;
    
    public $current_result = -1;
    
    public $is_register = false;
    

    

   public function init() {
		
	}
    
    function __construct($query = '') {
        if (!empty($query)) {
            $this->query($query);
        }
    }

    public function query($query) {
        $this->init();
        $this->query_array  = $query;
        
        /*
        if(count($this->query_array) == 0) $this->is_front_page = true;
       
        if(isset($this->query_array['search'])){
            $this->is_search = true;
            return $this->get_results();
        }else if (isset($this->query_array['restaurant_id'])){
            $this->is_restaurant = true;
            return $this->get_single_restaurant_result();
            
        }
         * */
        
        
        //is home page
        if ($query["action"] == "register"){
            
            $this->is_register = true;
            
        }
        
        //is Login
        else if ($query["action"] == "restaurant-register"){
            //echo "is logins";
            $this->is_restaurant_register = true;  
            
        }
        
        //is Login
        else if ($query["action"] == "login"){
            //echo "is logins";
            $this->is_login = true;  
            
        }
        
        //is Login
        else if ($query["action"] == "admin"){
           
            $this->is_admin = true;  
            if(get_user_type() == 'system_admin'){
                //var_dump($this->query_array);
                return $this->get_results();
            }
            
        }
        
        
        //is search
        else if ($query["action"] == "search"){
            
            $this->is_search = true;
            
            return $this->get_results();
            
        }
        //restaurant view
        else if ($query["action"] == "restaurant"){
            
            $this->is_restaurant = true;
            
            return $this->get_single_restaurant_result();
            
        }
        
        else if ($query["action"] == "reservation-view"){
            
            $this->is_reservation = true;
            
            
            
        }
        
        else{
            
            $this->is_front_page = true;
        }
        
        
    }
    
    //test

    
    public function get_results(){
        global $ssdb;
        $search = $this->query_array['string'];
        $cuisine_filter = $this->query_array['cuisine_filter'];
        if($cuisine_filter == "Any") $cuisine_filter = false;
        
        $lat = $this->query_array['lat'];
 
        $distance = "";
        $long = $this->query_array['long'];
        if($lat && $long){
            $distance = ", ( 3959 * acos( cos( radians($lat) ) * cos( radians( `lat` ) ) 
                        * cos( radians(`long`) - radians($long)) + sin(radians($lat)) 
                        * sin( radians(`lat`)))) AS distance ";
        }
        
        //var_dump($cuisine_filter);
        
        $string = "";
        $strings = array();       

        $query_string = "SELECT  * $distance FROM  `restaurants` WHERE 1=1";
        
        if($this->query_array['status'] == "review"){
            $query_string = $query_string  . " AND (`status` = \"ready\" OR `status` = \"pending\" ) ";
        }else{
            $query_string = $query_string  . " AND (`status` = \"active\" OR `status` = \"pending\" OR `status` = \"pending-denied\" )  ";
        }
        
        
        

        if ($search) {
            $query_string = $query_string . " AND ";
            for ($i = 0; $i < strlen($search); $i++) {
                if ($search[$i] != ' ') {
                    $string = $string . $search[$i];
                } else {
                    array_push($strings, $string);
                    $string = "";
                }
            }
            if ($string != "") {
                array_push($strings, $string);
            }

            for ($i = 0; $i < count($strings); $i++) {
                $query_string = $query_string . " `NAME` LIKE '%" . $strings[$i] . "%' OR ";
                $query_string = $query_string . "  `formatted_location` LIKE '%" . $strings[$i] . "%' ";

                if ($i != count($strings) - 1) {
                    $query_string = $query_string . " OR";
                }
            }
        }

        if($distance){
            //HAVING `distance` < 50
            $query_string = $query_string . " HAVING `distance` < 20   ";
        }
        
        if($cuisine_filter){
            //$query_string = $query_string  . " AND `cuisine` = \"$cuisine_filter\"";
           
            $query_string = $query_string . " ORDER BY  FIELD( `cuisine` , \"$cuisine_filter\") DESC , `distance` ";
           
        }else if (!$this->query_array['status'] == "review"){
             $query_string = $query_string . " ORDER BY `distance` ";
        }
        
        if($this->query_array['status'] != "review"){
            $query_string = $query_string . " LIMIT 20;";
        }
        
        // var_dump($query_string);
        //Okay so we now have an array of all the restaurant results here, and the total count, can be limited for pagination
        if($this->restaurants = $ssdb->get_results( $query_string )){
          $this->restaurant_count = count($this->restaurants);  
       
        }
        
        
        

    }
    
    public function get_single_restaurant_result(){
        global $ssdb;
        
        $query_string = "SELECT *  FROM  `restaurants` WHERE  `ID` = ".
                $this->query_array['restaurant_id'] ." LIMIT 1";
        
        //Okay so we now have an array of all the restaurant results here,
        //and the total count, can be limited for pagination
        $this->restaurants = $ssdb->get_results( $query_string );
        $this->restaurant_count = count($this->restaurants);
        
        
        

    }

    public function is_front_page() {
        //Test if you are looking at the front page
        return $this->is_front_page;
    }
    
    public function is_search() {
        //Test if you are looking at the front page
        return $this->is_search;
    }
    
    public function is_page() {
        //Test if you are looking at the front page
        return $this->is_page;
    }
 
    public function is_reservation() {
        //Test if you are looking at the front page
        return $this->is_reservation;
    }
    
    public function is_restaurant() {
        //Test if you are looking at the front page
        return $this->is_restaurant;
    }
    
    public function is_register(){
        //Test if you are on the registration page
        return $this->is_register;
    }
    
    public function is_restaurant_register(){
        //Test if you are on the registration page
        return $this->is_restaurant_register;
    }
    
    public function is_login(){
        
        return $this->is_login;
    }
    
    public function is_admin(){
        
        return $this->is_admin;
    }
    
    
    function parse_search(){
        
    }
    
    public function have_results() {
        
        if ($this->current_restaurant +1  < $this->restaurant_count) {
            return true;
        }
        $this->in_the_loop = false;
       
        return false;
    }
    
    public function load_restaurant(){
        global $restaurant;
        
        $restaurant = new Restaurant($this->next_restaurant());
        $this->setup_postdata( $restaurant );
    }
    
    public function next_restaurant(){
        $this->current_restaurant ++;

        $this->restaurant = $this->restaurants[$this->current_restaurant];
	return $this->restaurant;
        
    }
    
    public function setup_postdata(){
        
    }
    
    public function get_restaurant_count(){
        return $this->restaurant_count;
    }


    public function rewind_results() {
        $this->current_restaurant = -1;
        if ($this->result_count > 0) {
            $this->restaurant = $this->restaurants[0];
        }
    }

}
