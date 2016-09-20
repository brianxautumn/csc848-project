<?php
if ($_GET["search"] != "") {
    $search = "for " . $_GET['search'] . " ";
} else {
    $search = "Restaurants ";
}
global $restaurant;


$search = $search . "near " . $_GET["place_restore_search"];

global $markers;
global $restaurant_marker_counter;
$markers = array();
$restaurant_marker_counter = 0;
?>

<div class="main-content">
    <div class="fullscreen-wrapper">

        <div class="fullscreen-scroll" id="fullscreen-scroll">
            <div class="scroll-helper" id="scroll-helper">
            <div class="fullscreen-scroll-inner" id="fullscreen-scroll-inner">
                <div class="fullscreen-scroll-padding">


                    <?php
                    if (have_results()) :

                        while (have_results()) : load_restaurant();
                            


                            load_search_result();
                            
                                $markers[$restaurant_marker_counter]["name"] = get_restaurant_name();
                                $markers[$restaurant_marker_counter]["map_place_id"] = get_restaurant_place_id();
                                $markers[$restaurant_marker_counter]["map_lat"] = get_restaurant_lat();
                                $markers[$restaurant_marker_counter]["map_long"] = get_restaurant_long();
                                
                                $restaurant_marker_counter++;


                        endwhile;

                    else:
                        ?>

                        Sorry, no results

                    <?php endif; ?>
                </div>
            </div>
            </div>

        </div>

        <div id="fullscreen-map" class="fullscreen-map">

        </div>

    </div>
</div>

