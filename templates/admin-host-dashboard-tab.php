<?php
$reservations = get_restaurant_reservations();
//var_dump($reservations);
function multidimensional_search($parents, $searched) {
    if (empty($searched) || empty($parents)) {
        return false;
    }

    foreach ($parents as $key => $value) {
        $exists = true;
        foreach ($searched as $skey => $svalue) {
            $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
        }
        if ($exists) {
            return $key;
        }
    }

    return false;
}

if (isset($_POST["check"]) && $_POST["check"] == 'create_host') {
        $id_confirmed = $_POST["confirmation"];
     
        
        $id = multidimensional_search($reservations,  array('reservation_id' => $id_confirmed)) ;
            
        if($id >= 0){
            confirm_reservation($id_confirmed );
            unset($reservations[$id]);
            
        }
    }
    
?>

<div class="col-md-12">
    <div class="admin-heading"><h1>Today's Reservations</h1></div>
</div>  

<div class="content">

    <div class="tbl">
        <div class="col-md-12">

            <div class="wdgt">
                <div class="wdgt-header">Reservations for today</div>
                <div class="wdgt-body" style="padding-bottom:10px;">

                       <?php if ($reservations) {?>
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                         <input type="hidden" name="check" value="create_host">
                        <table class="table table-hover table-striped host_reservation_view">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Party Size</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Manage</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reservations as $reservation){ ?>
                                <tr>
                                    <td><?php echo date("g:i  A", strtotime ($reservation["time"])); ?></td>
                                    <td><?php echo $reservation["party"]; ?></td>
                                    <td><?php echo $reservation["name"]; ?></td>
                                    <td><?php echo $reservation["email"]; ?></td>
                                    <td><button type="submit" class="btn btn-success" name="confirmation" value="<?php echo $reservation["reservation_id"]?>">Confirm</button></td>
                                    
                                </tr>

                                <?php }?>

                            </tbody>
                        </table>
                    </form>
                       <?php }else {?>
                    <p>No Reservations today</p>
                       <?php } ?>
                       
                   
                </div>
            </div>

        </div>

    </div>

</div>