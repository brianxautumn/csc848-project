<?php

$reservations = get_user_reservations();

?>

<div class="col-md-12">
    <div class="admin-heading"><h1>My Reservations</h1></div>
</div>  

<div class="content">

    <div class="tbl">
        <div class="col-md-12">


            <div class="wdgt">
                <div class="wdgt-header">Latest Reservations</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    
                        <input type="hidden" name="check" value="checking-update">


                        <?php if($reservations) { ?>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Restaurant</th>
                                    <th>Confirmation</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($reservations as $reservation){
                                        //No need for global reservation here , just be careful to not call things to make it crash
                                        $date = $reservation->get_reservation_date();
                                        $time = date("g:i  A", strtotime($reservation->get_reservation_time()));
                                        $link = $reservation->get_reservation_url();
                                        $restaurant_name = $reservation->get_restaurant_name();
                                        echo "<tr>";
                                        echo "<td>$date</td>";
                                        echo "<td>$time</td>";
                                        echo "<td>$restaurant_name</td>";
                                        echo "<td><a href=\"$link\" target=\"new\"><label class=\" btn btn-info\">View</label></a> </td>";
                                        
                                        echo "</tr>";
                                    }
                                ?>
                                
                                


                            </tbody>
                        </table>
                        <?php } else { ?>
                        No reservations yet! 
                        <?php } ?>

                        
                        







                        
                  
                </div>
            </div>

        </div>

    </div>

</div>