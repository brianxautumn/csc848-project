<?php

function generate_available_reservation_times(){
    //var_dump($_POST);
    
    $time = strtotime($_POST["time"]);
    $date = strtotime($_POST["date"]);
    $party = $_POST["party"];
    $restaurant_id = $_POST["ID"];
    $restaurant = get_restaurant_by("ID" , $restaurant_id);
    //
    
    $day_number = (date( "w", $date));
    $schedule= $restaurant->get_restaurant_schedule();
    $tables = $restaurant->get_restaurant_tables();
    
    $available_tables = array();
    $best_match;
    
    foreach($tables as $table){
      if($table["active"] && $party <= intval($table["capacity"])) array_push($available_tables, $table);
    }
    
    
    $table_is_available = count($available_tables) >0;
    //var_dump($table_is_available);
    
    $constraints = $schedule[$day_number];
    
    
    
    $time = strtotime('+30 minutes', $time);
    if($time > strtotime('22:00'))
        $time = strtotime('22:00');
    
    $start_time = strtotime( $constraints["start_time"]);
    $end_time = strtotime( $constraints["end_time"]);
    
    //var_dump($time);
    //var_dump(strtotime(  $constraints["start_time"]));
    $result_count = 0;
    for($i = 0; $i < 4; $i++){
        $disabled = "";
        if(!$constraints["active"]){
          $disabled = "disabled";  
        }else if($time < $start_time ){
            $disabled = "disabled"; 
        }else if( $time >= strtotime('-30 minutes' , $end_time)){
            $disabled = "disabled";
        }else if(!$table_is_available){
          $disabled = "disabled";
        }
        //var_dump($time);
        
       $formatted_time =  date("g:i  A", $time);
       echo "<label class=\"btn btn-primary $disabled\">
                <input  type=\"radio\" name=\"reservation_time_slot\"  autocomplete=\"off\" value=\"$time\"> $formatted_time
            </label>"; 
       $time = strtotime('+30 minutes', $time);
    }
    
    
    
    exit;
}
