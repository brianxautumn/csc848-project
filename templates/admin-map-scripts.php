<?php
global $use_pending_map;
global $restaurant_place_id;
global $restaurant_lat;
global $restaurant_long;
global $restaurant_formatted_location;

//var_dump($use_pending_map);
if($use_pending_map){
    //echo "pending changes";
    $map_place_id = $restaurant_place_id;
    $map_lat = $restaurant_lat;
    $map_long = $restaurant_long;
    $map_formated_location = $restaurant_formatted_location;    
}else{
    $map_place_id = get_restaurant_place_id();
    $map_lat = get_restaurant_lat();
    $map_long = get_restaurant_long();
    $map_formated_location = get_restaurant_formatted_location();
}
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
        
        var map = new google.maps.Map(document.getElementById('map'),
                mapOptions);

        var input = /** @type {HTMLInputElement} */(
                document.getElementById('pac-input'));

        // Create the autocomplete helper, and associate it with
        // an HTML text input box.
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

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
            infowindow.setContent("<?php print_title(); ?> <br> <?php echo $map_formated_location; ?>");
            //console.log(place.address_components.types);
            infowindow.open(map, marker);
            
    <?php
    }
    ?>
        // Get the full place details when the user selects a place from the
        // list of suggestions.
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            infowindow.close();
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            
            //update the inputs 
            $("#restaurant_formatted_location").val(place.formatted_address);
            $("#restaurant_place_id").val(place.place_id);
            $("#restaurant_lat").val(place.geometry.location.lat);
            $("#restaurant_long").val(place.geometry.location.lng);

            // Set the position of the marker using the place ID and location.
            marker.setPlace(/** @type {!google.maps.Place} */ ({
                placeId: place.place_id,
                location: place.geometry.location
            }));
            marker.setVisible(true);

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                    place.formatted_address + '</div>');
            //console.log(place.address_components.types);
            infowindow.open(map, marker);
        });
    }

// Run the initialize function when the window has finished loading.
    google.maps.event.addDomListener(window, 'load', initialize);
});
    </script>