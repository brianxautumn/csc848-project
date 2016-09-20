<?php

$display_update_message = false;

if (isset($_POST["check"]) && $_POST["check"] == 'checking-update') {
    
    $tables = array();
    for($table = 0; $table <5; $table ++){
        $data = array();
        $keys= array();
    
        if($_POST["table_" . $table . '_enabled'] == 'on'){
            $data["active"] = "TRUE";
        }else{
            $data["active"] = "FALSE";
        }
 
        
       $data["count"] = "\"". $_POST["table_" . $table . '_count'] . "\""; 
       $data["capacity"] = "\"".  $_POST["table_" . $table . '_capacity'] . "\"";
       
       //Add the key that will make the query unique along with the normal ID
       $keys["table_ID"] = $table;
       //var_dump($data);
       update_restaurant_values($data , "tables" , $keys);
         
       
       //Now update the setting to activate/ dissable reservation system
       
    $data = array();
        if ($_POST["reservation_enabled"] == 'on') {
            $data["reservation_enabled"] = "TRUE";
            update_restaurant_values($data);
        } else {
            $data["reservation_enabled"] = "FALSE";
            update_restaurant_values($data);
        }
    }


    $display_update_message = true;
}
//Now Load existing table data to display
$table_data = get_restaurant_tables();

?>


<div class="col-md-12">
    <div class="admin-heading"><h1>Manage available tables and Capacity</h1></div>
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
                <div class="wdgt-header">Manage available table types by number, and capacity</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    
                    
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <div class ="alert <?php if(get_restaurant_is_open()) echo"alert-info"; else echo "alert-danger";?>">
                            <input  type="checkbox" <?php if(get_restaurant_reservation_enabled()) echo "checked";?> class="" name="reservation_enabled" id="reservation_enabled" <?php if(!get_restaurant_is_open()) echo"disabled=\"disabled\"";?>>
                        Enable reservations at your restaurant through Super Seater. (Requires at least 1 open business day)
                        </div>
                        
                        <input type="hidden" name="check" value="checking-update">



                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Active</th>
                                    <th>Table Count</th>
                                    <th>Capacity</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($table_num = 0; $table_num < 5; $table_num++){
                                    print_capacity_selector($table_num , $table_data[$table_num]);
                                }
                                ?>

                                


                            </tbody>
                        </table>








                        <button class="btn btn-primary" type="submit" id="update_button">Update Listing</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>