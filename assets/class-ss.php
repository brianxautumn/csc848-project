<?php

/**
 * This is the Super Seater Enviroment class. It is going to figure out what to do, and what type 
 * of query it needs to ask for.
 * 
 *----- Edit, now this is just going to be the view controller class and it only invoqes query for the restaurant building,
 * migrate the functions later!
 */

function get_cuisines(){
    global $super_seater;
    return $super_seater->get_cuisines();
    
}



class SuperSeater {
    
    public $query_vars;
    
    /**
     * This tells use wether a user is logged on
     * @var type 
     */
    public $is_session = false;
    
    /*
     * The Requested address
     */
    public $request_args;
    
    public $finalized_args = array();
    
    public $admin_tab;
    
    /**
     * Here is a list of the things that can be displayed
     */
    public $public_query_vars = array('search', 'restaurant_id' , 'page_id',
        'reservation_id' , 'cuisine' , 'page' , 'lat_search' , 'long_search' , 'place_id_search' );
    
    public $cuisines = array("American" , "Italian" , "Mexican" , "Chinese", "Vietnamese" , "Japanese" , "Korean");

    
    public function main($query_args = '') {
        /*
         * start parsing request here, handle extra stuff through $query-args
         */
        $this->load_cookies();
        $this->parse_request($query_args);
        
        $this->run_query();
        
        


    }

    
    /*
     * This is where you parse the actual url and decide what to do with it
     */
    public function parse_request($query_args) {
        
        global $current_user;
        
        
        $pathinfo = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
	list( $pathinfo ) = explode( '?', $pathinfo );
	$pathinfo = str_replace( "%", "%25", $pathinfo );
        
        
        list( $req_uri ) = explode( '?', $_SERVER['REQUEST_URI'] );
        $self = $_SERVER['PHP_SELF'];
        
        //now trim off the pathinfo from the req_uri to get rid of garbage
        $req_uri = str_replace($pathinfo, '', $req_uri);
        $req_uri = str_replace(ROOT, '', $req_uri);
        $self = str_replace(ROOT, '' , $self );
        $req_uri = str_replace($self, '', $req_uri);
        
        
        //This is now the filtered request path
        $this->request_args = explode("/", $req_uri);
        //var_dump($this->request_args);
 
        //Start off with a clean array of variables to query
        $this->query_vars = array();
        
        

        

         foreach ($this->public_query_vars as $qvar) {
             
            if (isset($_POST[$qvar])) {
                $this->query_vars[$qvar] = $_POST[$qvar];
            } elseif (isset($_GET[$qvar])) {
                $this->query_vars[$qvar] = $_GET[$qvar];
            }

            //Make sure to parse if there are strings
            //Dont forget to sanitize the strings later, could be bad!!!!!!
            if (!empty($this->query_vars[$qvar])) {
                if (!is_array($this->query_vars[$qvar])) {
                    $this->query_vars[$qvar] = (string) $this->query_vars[$qvar];
                } else {
                    foreach ($this->query_vars[$qvar] as $vkey => $v) {
                        if (!is_object($v)) {
                            $this->query_vars[$qvar][$vkey] = (string) $v;
                        }
                    }
                }
          
            }
        }
        
                //Okay Now we decide the order of presidence that things take
        
        //Register
        if (in_array("register", $this->request_args)) {
            //echo "is register page";
            
            if ($this->is_session) {
                $location = HOME_URI . "/admin";
                header("Location: $location");
                exit;
            }
            $this->finalized_args['action'] = "register";
        }

        //Restaurant Registration
        else if(in_array( "restaurant-register" , $this->request_args)){
            //echo "is restaurant registration page";
            if ($this->is_session) {
                $location = HOME_URI . "/admin";
                header("Location: $location");
                exit;
            }
            $this->finalized_args['action'] = "restaurant-register";
        }
        
        //Login
        else if(in_array( "login" , $this->request_args)){
            //echo "is login page";
            //Before the user hits the login page, check if they are already logged in
            //if they are, redirect them to admin
                if($this->is_session){
                    $location = HOME_URI . "/admin";
                    header("Location: $location");
                    exit;
                }
                $this->finalized_args['action'] = "login";
  
        }
        
        //Login
        else if (in_array("logout", $this->request_args)) {
            unset($_COOKIE[AUTHENTICATION_COOKIE]);
            setcookie(AUTHENTICATION_COOKIE , '' ,time() - 3600 , "/" );
            $location = HOME_URI;
            header("Location: $location");
            exit;
        }

        //Control Panel
        else if(in_array( "control-panel" , $this->request_args) || 
                in_array( "my-account" , $this->request_args)||
                in_array( "admin" , $this->request_args)){
            //echo "is control panel page";
                if (!$this->is_session) {
                $location = HOME_URI . "/register";
                header("Location: $location");
                exit;
            }
            $this->finalized_args['action'] = "admin";
            //Now Check for tabs
            switch (get_user_type()) {
                case "user":
                    if(in_array( "reservations" , $this->request_args)){
                        $this->admin_tab = "reservations";
                    }else if (in_array( "settings" , $this->request_args)){
                        $this->admin_tab = "settings";
                    }else if(in_array( "dashboard" , $this->request_args)){
                        $this->admin_tab = "dashboard";
                    }else{
                        $this->admin_tab = "dashboard";
                    }

                    break;
                case "restaurant_owner":
                    global $restaurant;
                    $restaurant = get_restaurant_by("user_ID" , $current_user->ID );
                    if (in_array("basic-info", $this->request_args)) {
                        $this->admin_tab = "basic-info";
                    } else if (in_array("hours", $this->request_args)) {
                        $this->admin_tab = "hours";
                    } else if (in_array("gallery", $this->request_args)) {
                        $this->admin_tab = "gallery";
                    } else if (in_array("tables", $this->request_args)) {
                        $this->admin_tab = "tables";
                    } else if (in_array("employees", $this->request_args)) {
                        $this->admin_tab = "employees";
                    } else if (in_array("settings", $this->request_args)) {
                        $this->admin_tab = "settings";
                    } else if (in_array("dashboard", $this->request_args)) {
                        $this->admin_tab = "dashboard";
                    } else {
                        $this->admin_tab = "dashboard";
                    }

                    break;
                    
                case "host":
                    global $restaurant;
                    $restaurant = get_restaurant_by("ID" , $current_user->restaurant_ID );
                    if (in_array("settings", $this->request_args)) {
                        $this->admin_tab = "settings";
                    } else if (in_array("dashboard", $this->request_args)) {
                        $this->admin_tab = "dashboard";
                    } else {
                        $this->admin_tab = "dashboard";
                    }
                    break;
                
                case "system_admin":
                    if (in_array("settings", $this->request_args)) {
                        $this->admin_tab = "settings";
                    } else if (in_array("dashboard", $this->request_args)) {
                        $this->admin_tab = "dashboard";
                        $this->finalized_args['status'] = "review";
                    } else {
                        $this->admin_tab = "dashboard";
                        $this->finalized_args['status'] = "review";
                    }
           
                    break;
                    
                default :
                    return;
            }
        }
        
        //Reservation form
        else if(in_array( "reservation" , $this->request_args)){
           $this->finalized_args['action'] = "reservation";
        }
        
        //Reservation form
        else if(in_array( "get_times" , $this->request_args)){
           //
            //This is an ajax request
            generate_available_reservation_times();
            
        }
        
        
        //Search
        else if(isset($this->query_vars['search'])){
           // echo "is search page";
            $this->finalized_args['action'] = "search";
            $this->finalized_args['string'] = $this->query_vars['search'];
            $this->finalized_args['cuisine_filter'] = $this->query_vars['cuisine'];
            $this->finalized_args['page'] = $this->query_vars['page'];
            $this->finalized_args['lat'] = $this->query_vars['lat_search'];
            $this->finalized_args['long'] = $this->query_vars['long_search'];
        }
        
        //Restaurant_id
        else if(isset($this->query_vars['restaurant_id'])){
            //echo "is restaurant";
            $this->finalized_args['action'] = "restaurant";
            $this->finalized_args['restaurant_id'] = $this->query_vars['restaurant_id'];
        }
        
        //Page_id
        else if(isset($this->query_vars['page_id'])){
            $this->finalized_args['action'] = "page";
            
        }
        //Reservation
        else if(isset($this->query_vars['reservation_id'])){
            $this->finalized_args['action'] = "reservation-view";
            $this->load_reservation();
            
            
        }
 
        else{

            $this->finalized_args['action'] = "home";
        }


    }
    
    public function run_query(){
        global $master_query;
        
        $master_query->query($this->finalized_args);
        
    }
    
    public function load_cookies(){
        global $current_user;
        
        if(isset($_COOKIE[AUTHENTICATION_COOKIE]) ){
            $ID = $_COOKIE[AUTHENTICATION_COOKIE];

            if($user = get_user_by("ID", $ID)){
                $current_user = $user;
                $this->is_session = true;
                /*
                switch(get_user_type()){
                    case "user":
                        break;
                    case "restaurant_owner":
                        break;
                    default:
                        break;
                }
                 * */
                
                
                //echo "Welcome";
            }
            
            
        }
    }
    
    public function is_logged_in(){
        return $this->is_session;
    }
    
    public function get_admin_tab(){
        return $this->admin_tab;
    }
    
    public function load_reservation(){
        global $reservation;
        global $restaurant;
        if($reservation = get_reservation_by("reservation_id", intval($this->query_vars['reservation_id']))){
            $restaurant = get_restaurant_by("ID" , $reservation->ID );
        }
    }
    
    public function get_cuisines(){
        return $this->cuisines;
    }

}

