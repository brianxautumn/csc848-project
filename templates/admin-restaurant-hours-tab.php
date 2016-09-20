<?php
$display_update_message = false;


if (isset($_POST["check"]) && $_POST["check"] == 'checking-update') {
    $active_days = 0;
    
    $schedule = array();
    
    for($day = 0; $day <7; $day ++){
        $data = array();
        $keys= array();
    
        if($_POST["day_" . $day . '_active'] == 'on'){
            $data["active"] = "TRUE";
            $active_days++;
        }else{
            $data["active"] = "FALSE";
        }
        
       $start_time = date("G:i:00" , strtotime($_POST["day_" . $day . '_start']));
               
       $end_time =  date( "G:i:00" , strtotime ($_POST["day_" . $day . '_end']));
       
       
       $data["start_time"] = "\"".  $start_time . "\""; 
       $data["end_time"] = "\"".  $end_time . "\"";
       
       
       $keys["day"] = $day;
       update_restaurant_values($data , "schedule" , $keys);
    }
    
    //check if there is at least 1 active day then update restaurant to be open
    $data = array();
    if($active_days >0){
        $data["is_open"] = "TRUE";
        update_restaurant_values($data );
        
    }else{
        $data["is_open"] = "FALSE";
        update_restaurant_values($data );
    }
    
   
     $display_update_message = true;
}else{
   
}

$schedule = get_restaurant_schedule();

?>

<div class="col-md-12">
    <div class="admin-heading"><h1>Business Hours</h1></div>
</div>  

<div class="content">

    <div class="tbl">
        <div class="col-md-12">
            <?php
            if ($display_update_message) {
                ?>
                <div class="alert alert-success alert-border alert-soft"><span class="glyphicon glyphicon-ok"></span> <strong>Listing Updated</strong>  </div>
                <?php
            }
            ?>

            <div class="wdgt">
                <div class="wdgt-header">Manage your Operating Hours</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="check" value="checking-update">



                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Open</th>
                                    <th>Day</th>
                                    <th>Open Time</th>
                                    <th>Close Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_0_active" id="day_0_active" <?php if($schedule[0]["active"]) echo "checked"; ?>></td>
                                    <td>Sunday</td>
                                    <td> <?php print_time_selector("day_0_start", $schedule[0]["start_time"]) ?> </td>
                                    <td> <?php print_time_selector("day_0_end", $schedule[0]["end_time"] )  ?> </td>
                                </tr>

                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_1_active" id="day_1_active" <?php if($schedule[1]["active"]) echo "checked"; ?> ></td>
                                    <td>Monday</td>
                                    <td> <?php print_time_selector("day_1_start", $schedule[1]["start_time"] ) ?> </td>
                                    <td> <?php print_time_selector("day_1_end" , $schedule[1]["end_time"] ) ?> </td>
                                </tr>


                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_2_active" id="day_2_active" <?php if($schedule[2]["active"]) echo "checked"; ?> ></td>
                                    <td>Tuesday</td>
                                    <td> <?php print_time_selector("day_2_start", $schedule[2]["start_time"] ) ?> </td>
                                    <td> <?php print_time_selector("day_2_end", $schedule[2]["end_time"] ) ?> </td>
                                </tr>


                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_3_active" id="day_3_active" <?php if($schedule[3]["active"]) echo "checked"; ?> ></td>
                                    <td>Wednesday</td>
                                    <td> <?php print_time_selector("day_3_start", $schedule[3]["start_time"] ) ?> </td>
                                    <td> <?php print_time_selector("day_3_end", $schedule[3]["end_time"] ) ?> </td>
                                </tr>



                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_4_active" id="day_4_active" <?php if($schedule[4]["active"]) echo "checked"; ?> ></td>
                                    <td>Thursday</td>
                                    <td> <?php print_time_selector("day_4_start", $schedule[4]["start_time"] ) ?> </td>
                                    <td> <?php print_time_selector("day_4_end", $schedule[4]["end_time"] ) ?> </td>
                                </tr>


                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_5_active" id="day_5_active" <?php if($schedule[5]["active"]) echo "checked"; ?> ></td>
                                    <td>Friday</td>
                                    <td> <?php print_time_selector("day_5_start", $schedule[5]["start_time"] ) ?> </td>
                                    <td> <?php print_time_selector("day_5_end", $schedule[5]["end_time"] ) ?> </td>
                                </tr>


                                <tr>
                                    <td class="center"><input  type="checkbox" class="flat-checkbox" name="day_6_active" id="day_6_active" <?php if($schedule[6]["active"]) echo "checked"; ?> ></td>
                                    <td>Saturday</td>
                                    <td> <?php print_time_selector("day_6_start", $schedule[6]["start_time"] ) ?> </td>
                                    <td> <?php print_time_selector("day_6_end", $schedule[6]["end_time"] ) ?> </td>
                                </tr>


                            </tbody>
                        </table>








                        <button class="btn btn-primary" type="submit" id="update_button">Update Listing</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>