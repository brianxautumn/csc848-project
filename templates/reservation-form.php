
<div class="restaurant_detail" id="reservation_form">
    <h3>Reserve a table</h3>
    <form class="reservation_form" method="post" action="" enctype="multipart/form-data" id="restaurant_reservation_form">
        <input type="hidden" name="check" value="check">
        <input type="hidden" name="restaurant_id" id="restaurant_id" value="<?php echo get_restaurant_ID();?>">
        <div class="reservation_controls">
            <select name="reservation_party_size" id="reservation_party_size">
                <?php
                for ($i = 1; $i < 20; $i++) {
                    echo "<option value=\"$i\">";
                    echo $i . " persons";
                    echo "</option>";
                }
                ?>
            </select>
            <input type="text" id="datepicker" name="datepicker">

            <?php print_time_selector("reservation_time", $default = "17:00") ?>

        </div>


        <div class="btn-group" data-toggle="buttons" id="available_times" name="available_times">
            
            <label class="btn btn-primary">
                <input type="radio"  name="reservation_time_slot" id="reservation_time_slot0" autocomplete="off" value="4:00"> 4:30 PM
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="reservation_time_slot" id="reservation_time_slot1" autocomplete="off" value="4:00"> 5:00 PM
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="reservation_time_slot" id="reservation_time_slot2" autocomplete="off" value="4:00"> 5:30 PM
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="reservation_time_slot" id="reservation_time_slot3" autocomplete="off" value="4:00"> 6:00 PM
            </label>
        </div>
        <div id="reservation-error-output"></div>
        <div class="control-group">
            <!-- E-mail -->
            <label class="control-label" >Name</label>
            <div class="controls">
                <input type="text"   required name="reservation_name" id="reservation_name" placeholder="" class="input-xlarge" >
                <p class="help-block">Please provide your Name</p>
            </div>
        </div>
        

        <?php if(!is_logged_in()){ ?>
        <div class="control-group">
            <!-- E-mail -->
            <label class="control-label" for="email">E-mail</label>
            <div class="controls">
                <input type="text"   required name="user_email" placeholder="" class="input-xlarge" value="<?php echo htmlspecialchars($user_email); ?>">
                <p class="help-block">Please provide your E-mail</p>
            </div>
        </div>
        <?php } else{ ?>
        <input type="hidden" name="user_email" value="<?php echo get_user_email() ?>">
        <?php } ?>

        <div class="controls" style="text-align:center;">
            <button class="btn btn-success" type="submit">Make Reservation</button>
        </div>

    </form>
</div>
