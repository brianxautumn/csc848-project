<?php
global $markers;

global $restaurant_marker_counter;

?>

<script>
    $(function () {
    /**
     * GOOGLE MAPS API
     */
    var markers = new Array();
            var icons = [
      <?php
        for($i = 0; $i< 20; $i++){
            echo '"';
            echo  load_map_icon($i);
            echo '"';
            if ($i != 19) echo " , ";
        }
      ?>
    ];
    
            var iconsActive = [
      <?php
        for($i = 0; $i< 20; $i++){
            echo '"';
            echo  load_map_icon_active($i);
            echo '"';
            if ($i != 19) echo " , ";
        }
      ?>
    ];
    
    function initializeSearchResultsMap() {

        var mapOptions = {
            center: {
            lat: <?php echo get_search_lat(); ?>, lng: <?php echo get_search_long(); ?>},
            zoom: 14,
            scrollwheel: false
        };             
                        

    
    var locations = [
    <?php
        for($i = 0; $i < $restaurant_marker_counter; $i++){
            $name = $markers[$i]["name"];
            $lat= $markers[$i]["map_lat"];
            $long = $markers[$i]["map_long"];
            echo "['".  htmlspecialchars ($name , ENT_QUOTES) . " ' , \"$lat\", \"$long\"  ] \n";
            if ($i != 19) echo " , ";
        }
    ?>
                    ];
    
    
    var iconsLength = <?php echo $restaurant_marker_counter; ?>;
    
    
        
        var map = new google.maps.Map(document.getElementById('fullscreen-map'),
                mapOptions);

  

  

     
      for (var i = 0; i < locations.length; i++) {  
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: icons[i+1],
        id: i+1
        
      });
      google.maps.event.addListener(marker, "click", markerClick);
      markers.push(marker);

      

    }
    
    function autoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      for (var i = 0; i < markers.length; i++) {  
				bounds.extend(markers[i].position);
      }
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
    autoCenter();
    
    
    
                        
                        
    }// end load
    
    var that;
        var markerClick = function() {
				if (that) {
					that.setZIndex();
                                        
				}
				that = this;
				this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
                                scroll_to_result(this.id);
				
			};
                        
            function highlightMarker(marker , id) {
               
				if (that) {
                                    
					that.setZIndex();
                                        
				}
                                for (var i = 0; i < markers.length; i++) {
                               
                                    
                                    markers[i].setIcon(icons[markers[i].id]);
                                }
                                
				that = marker;
				marker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
                                marker.setIcon(iconsActive[id]);
				
			};



// Run the initialize function when the window has finished loading.
    google.maps.event.addDomListener(window, 'load', initializeSearchResultsMap);
    
       $( ".result_wrap" ).mouseover(function() {
        var id= $(this).attr('id');
        highlightMarker(markers[id-1] , id);
        
    });
    
    $( ".result_wrap" ).mouseout(function() {
        for (var i = 0; i < markers.length; i++) {
                               
                                    
                                    markers[i].setIcon(icons[markers[i].id]);
                                }
    });
    

    function scroll_to_result(id)
    {//fullscreen-scroll-inner
         var myId = '#' + id;
         var scrollTo = $(myId).offset().top + $("#scroll-helper").scrollTop() - $(myId).height() ;
         console.log($("#fullscreen-scroll-inner").scrollTop() );
         console.log(scrollTo);

if(scrollTo !=0 )
{
  $("#scroll-helper").animate({scrollTop: scrollTo}, "slow");
}
      
    }
});
    </script>