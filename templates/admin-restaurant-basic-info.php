<?php
global $use_pending_map;
global $restaurant_place_id;
global $restaurant_lat;
global $restaurant_long;
global $restaurant_formatted_location;

$all_fields = true;

$display_update_message = false;


if (isset($_POST["check"]) && $_POST["check"] == 'checking-update') {
    //echo "receiving data";

    $restaurant_name = $_POST["restaurant_name"];
    
    
    
    
    $restaurant_phone_number = $_POST["restaurant_phone_number"];
    $restaurant_cuisine = $_POST["restaurant_cuisine"];
    $current_cuisine = $restaurant_cuisine;
    $restaurant_description = $_POST["restaurant_description"];
    $restaurant_website = $_POST["restaurant_website"];
    $restaurant_main_img = get_restaurant_main_img();

    $data["NAME_pending"] = "\"". $restaurant_name . "\"";
    //$data["location"] = "\"". $restaurant_location . "\"";
    
    //Only need to update these if there was a change
    
        $restaurant_formatted_location = $_POST["restaurant_formatted_location"];
        $restaurant_place_id = $_POST["restaurant_place_id"];
        $restaurant_lat = $_POST["restaurant_lat"];
        $restaurant_long = $_POST["restaurant_long"];

        $data["formatted_location_pending"] = "\"" . $restaurant_formatted_location . "\"";
        $data["place_id_pending"] = "\"" . $restaurant_place_id . "\"";
        $data["lat_pending"] = "\"" . $restaurant_lat . "\"";
        $data["long_pending"] = "\"" . $restaurant_long . "\"";
        
        
    
    
    if (isset($_POST["restaurant_place_id"]) && $_POST["restaurant_place_id"] != "" && $_POST["restaurant_place_id"] != NULL) {
       $use_pending_map = true; 
    }



    $data["phone_number_pending"] = "\"". $restaurant_phone_number. "\"";
    $data["cuisine_pending"] = "\"".$restaurant_cuisine. "\"";
    $data["description_pending"] =  "\"".$restaurant_description . "\"";
    $data["website_pending"] =  "\"".$restaurant_website . "\"";
    
    //var_dump($_FILES['restaurant_main_upload']["size"] >0);
    if (isset($_FILES['restaurant_main_upload']) && $_FILES['restaurant_main_upload']["size"] >0) {
        if (validate_img_upload($_FILES['restaurant_main_upload']["tmp_name"])) {
            $data["main_img_pending"] =  "\"". addslashes(file_get_contents($_FILES['restaurant_main_upload']["tmp_name"])) . "\"";
            $restaurant_main_img = "data:image/jpeg;base64," . base64_encode((file_get_contents($_FILES['restaurant_main_upload']["tmp_name"])));
        }
       
    }

    if($restaurant_name == NULL || $restaurant_name == "") $all_fields = false;
    if($restaurant_phone_number == NULL || $restaurant_phone_number == "") $all_fields = false;
    if($restaurant_cuisine == NULL || $restaurant_cuisine == "") $all_fields = false;
    if($restaurant_description == NULL || $restaurant_description == "") $all_fields = false;
    if($restaurant_website == NULL || $restaurant_website == "") $all_fields = false;
    if($restaurant_formatted_location == NULL || $restaurant_formatted_location == "") $all_fields = false;
    if($restaurant_main_img == NULL || $restaurant_main_img == "") $all_fields = false;
    
    
    $current_status = get_restaurant_status();
    //|| $current_status == "ready" 
    if($all_fields && ($current_status == "new" || $current_status == "ready-denied" ) ){
        $current_status = "ready";
        $data["status"] = "  \"ready\" ";
        update_restaurant_values($data);
    }else if(!$all_fields && $current_status == "new"  ){
        
        update_restaurant_values($data);
    }else{
         $current_status = "pending";
        $data["status"] = "  \"pending\" ";
        update_restaurant_values($data);
    }
    update_restaurant_values($data);
   
    
    
   
    
    $display_update_message = true;
    
    
} else {
    $restaurant_name = get_restaurant_name();
    //$restaurant_location = get_restaurant_location();
    $restaurant_phone_number = get_restaurant_phone_number();
    $restaurant_cuisine = get_restaurant_cuisine();
    $restaurant_description = get_restaurant_description();
    $restaurant_website = get_restaurant_website();
    $restaurant_main_img = get_restaurant_main_img();
    $restaurant_place_id = get_restaurant_place_id();
    $current_cuisine = get_restaurant_cuisine();
    
$restaurant_lat = get_restaurant_lat();
$restaurant_long = get_restaurant_long();
$restaurant_formatted_location = get_restaurant_formatted_location();
$current_status = get_restaurant_status();
}

    
    if($restaurant_name == NULL || $restaurant_name == "") $all_fields = false;
    if($restaurant_phone_number == NULL || $restaurant_phone_number == "") $all_fields = false;
    if($restaurant_cuisine == NULL || $restaurant_cuisine == "") $all_fields = false;
    if($restaurant_description == NULL || $restaurant_description == "") $all_fields = false;
    if($restaurant_website == NULL || $restaurant_website == "") $all_fields = false;
    if($restaurant_formatted_location == NULL || $restaurant_formatted_location == "") $all_fields = false;
    if($restaurant_main_img == NULL || $restaurant_main_img == "") $all_fields = false;
    
    
?>

<div class="col-md-12">
    <div class="admin-heading"><h1>Basic Information</h1></div>
</div>     


 <div class="content">

     <div class="tbl">
      <div class="col-md-12">
          
          <?php
          if($display_update_message){
              ?>
               <div class="alert alert-success alert-border alert-soft"><span class="glyphicon glyphicon-ok"></span> <strong>Listing Updated</strong>  </div>
         <?php
               }
          ?>
               
          <?php
          if(!$all_fields){
              ?>
               <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong>All Fields Must Be Completed</strong>  </div>
         <?php
               }
          ?>
               
               <?php
             if($current_status == 'pending' || $current_status == 'pending-denied'){
              ?>
             <div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> <strong>Your changes are pending.</strong>  </div>
         <?php
               }
          ?>
             
             <?php
             if($current_status == 'pending-denied' || $current_status == 'ready-denied'){
              ?>
            <div class="alert alert-danger"><span class="glyphicon glyphicon-ban-circle"></span> <strong>Your data was not approved. Please review Basic Info resubmit.</strong>  </div>
         <?php
               }
          ?>
               
               
       <div class="wdgt">
        <div class="wdgt-header">Manage your restaurant's basic information</div>
        <div class="wdgt-body" style="padding-bottom:10px;">
         <form role="form" method="post" action="" enctype="multipart/form-data" id="restaurant-basic-info">
             <input type="hidden" name="check" value="checking-update">
          <div class="form-group">
              <button class="btn btn-primary" type="submit" id="update_button">Update Listing</button>
              <br>
              <br>
           <label>Restaurant Name</label>
           <input type="text" class="form-control" placeholder="Restaurant Name" name="restaurant_name" value="<?php echo $restaurant_name; ?>">
          </div>
          <div class="form-group">
           <label>Location</label>
           <!-- <input type="text" class="form-control" placeholder="Enter your location" name="restaurant_location" value="<?php echo $restaurant_location; ?>">
           -->
           
           <input id="pac-input" class="controls" type="text"
        placeholder="Enter a location">
           <div id="map" ></div>
           <input type="hidden" name="restaurant_formatted_location" id="restaurant_formatted_location" value="<?php echo $restaurant_formatted_location; ?>">
           <input type="hidden" name="restaurant_place_id" id="restaurant_place_id" value="<?php echo $restaurant_place_id;?>">
           <input type="hidden" name="restaurant_lat" id="restaurant_lat" value="<?php echo $restaurant_lat;?>">
           <input type="hidden" name="restaurant_long" id="restaurant_long" value="<?php echo $restaurant_long;?>">

           
          </div>
           <div class="form-group">
           <label>Phone Number</label>
           <input type="text" class="form-control" placeholder="Phone Number" name="restaurant_phone_number" id="restaurant_phone_number" value="<?php echo $restaurant_phone_number; ?>">
           </div>

           <div class="form-group">
               <label>Website (use http://)</label>
               <input type="text" class="form-control" placeholder="Website" name="restaurant_website" id="restaurant_website" value="<?php echo $restaurant_website; ?>">
           </div>

          <div class="form-group">
           <label>Cuisine</label>
           <select  class="form-control form-primary" name="restaurant_cuisine">
               <?php
               $cuisines = get_cuisines();
               foreach($cuisines as $cuisine){
                   $selected = "";
                   if($current_cuisine == $cuisine) $selected = "selected";
                   echo "<option $selected>$cuisine</option>";
               }
               ?>

           </select>
          </div>

          <div class="form-group">
           <label>Description</label>
           <textarea class="form-control form-dark" rows="3" name="restaurant_description"><?php echo $restaurant_description; ?></textarea>
          </div>
          <div class="form-group">
           <label for="exampleInputFile">Restaurant Main Image</label>
           <div id="restaurant_main_preview" style="background-image:url(<?php echo $restaurant_main_img;?>);"></div>
           <input type="file" id="restaurant_main_upload"  name="restaurant_main_upload"/>
          </div>
             
                 
             

          <button class="btn btn-primary" type="submit" id="update_button">Update Listing</button>
         </form>
        </div>
       </div>

      </div>
   
     </div>

    </div>