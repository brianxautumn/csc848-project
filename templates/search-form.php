<div class="<?php if(!is_front_page()) echo "search_container"; else echo "home_search_container";?> ">
<form role="search" method="get" class="search-form" action="<?php print_home_url(); ?>" >
    <input type="hidden" name="lat_search" id="lat_search" <?php if ($_GET["lat_search"] != "") { echo "value = \"" . $_GET['lat_search'] . "\"";} else {echo "value = \"37.7749295\"";} ?>>
    <input type="hidden" name="long_search" id="long_search" <?php if ($_GET["long_search"] != ""){  echo "value = \"" . $_GET['long_search'] . "\"";} else {echo "value = \"-122.41941550000001\"";}?>>
    <input type="hidden" name="place_id_search" id="place_id_search">
    <input type="hidden" name="place_restore_search" id="place_restore_search" <?php if ($_GET["place_restore_search"] != ""){  echo "value = \"" . $_GET['place_restore_search'] . "\"";} else {echo "value = \"San Francisco, CA, United States\"";}?>>
    <div class="search_bar" style="background-image:url(<?php if(!is_front_page()) load_template_image("search-background.jpg")?>)">
        <div class="container">
        
        <!-- old class input-group -->
        <div class="col-md-3">
            <label class="search-label">Location</label>
        <input id="search_location" name="search_location" class="controls" type="text"
        placeholder="Enter a location" <?php if ($_GET["place_restore_search"] != ""){  echo "value = \"" . $_GET['place_restore_search'] . "\"";} else {echo "value = \"San Francisco, CA, United States\"";}?>>
        </div>
        
        <div class="col-md-3">
            <label class="search-label">Restaurant Name or Keyword</label>
            <input type="text" class="form-control" name="search" placeholder="Search for..." <?php if (isset($_GET["search"])) echo "value = \"" . $_GET['search'] . "\"";?> >
        </div>
        
        <div class="col-md-3">
            <label class="search-label">Cuisine</label>
           <select  class="form-control form-primary" name="cuisine">
               <?php 
               $selected = "";
               if($_GET["cuisine"] == "Any") $selected = "selected";
               echo "<option $selected>Any</option>";
               ?>
               
               <?php
               $cuisines = get_cuisines();
               foreach($cuisines as $cuisine){
                   $selected = "";
                   if($_GET["cuisine"] == $cuisine) $selected = "selected";
                   echo "<option $selected>$cuisine</option>";
               }
               ?>

           </select>
        </div>
        
        <div class="col-md-3">
            <label class="search-label">Search Now!</label>
      <span class="input-group-btn">
          
        <button class="btn btn-block" type="submit" id="search_button">Find Restaurants</button>
      </span>
        </div>
        
        <div class="clearfix"></div>
      <?php
    if(is_search()){
        ?>
    <div id="search-description">
        Showing <?php echo get_restaurant_count(); ?> Best Results <?php if(get_search_string()) echo "for " . get_search_string(); ?> within 20 Miles of <?php echo $_GET["search_location"];?>
    </div>
    <?php
    }
    ?>  
        </div>
    </div><!-- /search bar -->
    
    
</form>
    
    
</div>