
<?php

if (have_results()) :load_restaurant(); 

if (isset($_POST["check"]) && $_POST["check"] == 'check') {
    
    $data["ID"] =  "\"" . get_restaurant_ID() . "\"";
    $data["party"] = "\"" . $_POST["reservation_party_size"] . "\"";
    $data["date"] = "\"" .   date('Y-m-d', strtotime(str_replace('-', '/', $_POST["datepicker"])))  . "\"";
    $time_temp = strtotime($_POST["reservation_time_slot"]);
    $time = date("G:i:00", $_POST["reservation_time_slot"]);
    $data["time"] = "\"" . $time . "\"";
    $data["email"] = "\"" . $_POST["user_email"] . "\"";
    $data["name"] = "\"" . $_POST["reservation_name"] . "\"";
    //var_dump($data);
    //var_dump($time);
    make_reservation($data ,  true);
}

$restaurant_images = get_restaurant_gallery();
$img_count = count($restaurant_images);


?>

<div class="main-content">
    <div class="padded_content">
    <div class="container">
        <div class="row">
            <div class="col-md-5 ">
                
                <div class="restaurant_detail">
                <h2><?php   print_title(); ?></h2>
                <ul>
                <li><span class=" glyphicon glyphicon-cutlery"></span><?php echo get_restaurant_cuisine(); ?></li>
                <li><span class="glyphicon glyphicon-earphone"></span><?php echo get_restaurant_phone_number(); ?></li>
                <li><span class="glyphicon glyphicon-map-marker"></span><?php echo get_restaurant_formatted_location(); ?></li>
                <li><span class="glyphicon glyphicon-screenshot"></span><a target = 'blank' href='<?php echo get_directions_url(); ?> '>get directions</a></li>
                
                <li><span class="glyphicon glyphicon-globe"></span><?php echo get_restaurant_website(); ?></li>
                <li><span class="glyphicon glyphicon-bookmark"></span><?php if (get_restaurant_reservation_enabled()) echo "<a href=\"#reservation_form\">reserve now!</a>"; else echo "reservations not available"; ?></li>
            </ul>
                
                <hr>
                <h3>About</h3>
                <p>
                <?php echo get_restaurant_description(); ?>
                </p>
                </div>
                
                <div class="restaurant_detail">
                    <h3>Hours</h3>
                    <?php print_restaurant_hours(); ?>
                </div>
                
                
                
                <?php 
                    if (get_restaurant_reservation_enabled()) {
                        load_reservation_form();
                    }
                    ?>
                
                
                
            </div>
            
            <div class="col-md-7">
                <!--
                <div class="restaurant_gallery" style = "background-image:url(<?php load_restaurant_main_img(); ?>)">
                    
                </div>
                -->
                <div id="restaurant-carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <?php
                            $active = "class=\"active\"";
                                for($i = 0 ; $i < $img_count; $i ++){
                                    
                                    echo "<li data-target=\"#restaurant-carousel\" data-slide-to=\"$i\" $active></li>";
                                    if($i ==0) $active = "";
                                }
                                    
                             
                            ?>
                         
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $active = "active";
                            for($i = 0 ; $i < $img_count; $i ++){
                                $img = $restaurant_images[$i];
                                    echo "<div class=\"item $active\" style=\"background-image:url($img)\">";
                                    //echo "<img src=\"" . $img . "\" alt=\"\">";
                                    
                                    echo "</div>";
                                    if($i ==0) $active = "";
                                    
                                    
                                }
                            ?>

                            
                        </div>
                        
                        <?php
                            if($img_count > 1){
                        ?>
                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#restaurant-carousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#restaurant-carousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        <?php
                            }
                        ?>
                    </div>

                
                <div class="restaurant_detail">
                    <h3>Location</h3>
                    <div id="restaurant-map"></div>
                </div>
            </div>
            
            
        </div>
        
    </div>
    </div>
</div>


    
 <?php else: ?>

    Sorry, Invalid Restaurant;

<?php endif; ?>