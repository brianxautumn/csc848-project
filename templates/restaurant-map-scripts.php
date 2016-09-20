<?php

    $map_place_id = get_restaurant_place_id();
    $map_lat = get_restaurant_lat();
    $map_long = get_restaurant_long();
    $map_formated_location = get_restaurant_formatted_location();

?>

<script>
    $(function () {
    /**
     * GOOGLE MAPS API
     */
    
    function initialize() {
        <?php
        if(get_restaurant_place_id()){
            ?>
            var mapOptions = {
            center: new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_long; ?>),
            zoom:17,
    scrollwheel: false
        };               
                        
            <?php
        }else{
            ?>
        var mapOptions = {
            center: {
            lat: -33.8688, lng: 151.2195},
            zoom: 17,
            scrollwheel: false
        };             
                        
                        
        <?php
        
        }
        ?>
        
        var map = new google.maps.Map(document.getElementById('restaurant-map'),
                mapOptions);

  

  

     
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map
        });
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
        
        <?php
        if(get_restaurant_place_id()){
            ?>
             marker.setPlace(/** @type {!google.maps.Place} */ ({
                placeId: '<?php echo get_restaurant_place_id(); ?>',
                location: new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_long; ?>)
            }));
            marker.setVisible(true); 
            infowindow.setContent("<?php print_title(); ?> <br> <?php echo $map_formated_location; ?> <br> <a target = 'blank' href='<?php echo get_directions_url(); ?> '>get directions</a> ");
            //console.log(place.address_components.types);
            infowindow.open(map, marker);
            
    <?php
    }
    ?>
        // Get the full place details when the user selects a place from the
        // list of suggestions.

    }

// Run the initialize function when the window has finished loading.
    google.maps.event.addDomListener(window, 'load', initialize);
});
    </script>