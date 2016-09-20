
<div class = "result_wrap" id="<?php echo (get_search_restaurant_number() + 1);?>">
    <div class = "result_inner">

        
        
        
        <div class = "result_image">
            
            <a href="<?php print_restaurant_url(); ?>"> <img class = "result_image" src="<?php load_restaurant_main_img(); ?>">  </img> </a>
    
        </div> 
        
        
        

        <div class = "result_content">
            <h3 class="search_title"><a href="<?php print_restaurant_url(); ?>"> <?php echo get_search_restaurant_number() + 1 . ") "; print_title(); ?> </a></h3>
            <ul>
                <li><span class=" glyphicon glyphicon-cutlery"></span><?php echo get_restaurant_cuisine(); ?></li>
                <li><span class="glyphicon glyphicon-earphone"></span><?php echo get_restaurant_phone_number(); ?></li>
                <li><span class="glyphicon glyphicon-map-marker"></span><?php echo get_restaurant_formatted_location(); ?></li>
                
                <li><span class="glyphicon glyphicon-road"></span><?php echo get_restaurant_distance(); ?> Miles Away</li>
            </ul>

        </div>
        
        <div class="result_controls">
            <?php if(get_restaurant_reservation_enabled()) {?>
                <a href="<?php echo get_restaurant_reserve_url(); ?>"  class="btn btn-primary btn-lg">Reserve Now</a>
            <?php } else { ?>
                <button disabled  class="btn btn-primary btn-lg">Not Available</button>
            <?php } ?>
        </div>

    </div>
</div>

