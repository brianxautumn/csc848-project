<?php
global $reservation;
global $restaurant;

if ($reservation) {
    if (isset($_POST["check"]) && $_POST["check"] == 'check') {
        $reservation->delete_reservation();
    }
}
?>

<div class="main-content">
    <div class="padded_content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="restaurant_detail">
                    <h2>Reservation Confirmation</h2>
                    <?php if($reservation != FALSE){ ?>
                    <ul>
                        <li>
                            <strong>Location : </strong> <a href="<?php print_restaurant_url(); ?>"><?php print_title(); ?></a>
                        </li>
                        
                        <li>
                            <strong>Address : </strong> <a href="<?php echo get_directions_url(); ?>"><?php echo get_restaurant_formatted_location(); ?></a>
                        </li>
                        
                        <li>
                            <strong>Date : </strong> <?php echo  date( "l, F d, Y", get_reservation_date());?>
                        </li>
                        
                        <li>
                            <strong>Time : </strong> <?php echo date("g:i  A", get_reservation_time());?>
                        </li>
                        <li>
                            <strong>Party : </strong> <?php echo get_reservation_party(); ?>
                        </li>
                        <li>
                            <strong>Name : </strong> <?php echo get_reservation_name(); ?>
                        </li>
                    </ul>
                    <hr>
                    Save this link for your records!
                    <hr>
                    
                    <form class="" action='' method="POST">
                        <input type="hidden" name="check" value="check">
                        <div class="control" style="text-align: center;">
                                    <button class="btn btn-danger" type="submit">Cancel Reservation</button>
                        </div>
                    </form>
                    
                    <hr>
                    <div id="restaurant-map"></div>
                    
                    <?php } else { ?>
                    <strong>Sorry, that is an invalid reservation number</strong>
                    <?php }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>