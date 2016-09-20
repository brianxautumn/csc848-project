<?php

$display_update_message = false;
if (isset($_POST["check"]) && $_POST["check"] == 'checking-update') {
    $restaurant_images = get_restaurant_images();

    if (isset($_FILES['restaurant_image_1_upload']) && $_FILES['restaurant_image_1_upload']["size"] > 0) {
        if (validate_img_upload($_FILES['restaurant_image_1_upload']["tmp_name"])) {
            $data["image_1"] = "\"" . addslashes(file_get_contents($_FILES['restaurant_image_1_upload']["tmp_name"])) . "\"";
            $restaurant_images['image_1'] = "data:image/jpeg;base64," . base64_encode((file_get_contents($_FILES['restaurant_image_1_upload']["tmp_name"])));
        }
    }

    if (isset($_FILES['restaurant_image_2_upload']) && $_FILES['restaurant_image_2_upload']["size"] > 0) {
        if (validate_img_upload($_FILES['restaurant_image_2_upload']["tmp_name"])) {
            $data["image_2"] = "\"" . addslashes(file_get_contents($_FILES['restaurant_image_2_upload']["tmp_name"])) . "\"";
            $restaurant_images['image_2'] = "data:image/jpeg;base64," . base64_encode((file_get_contents($_FILES['restaurant_image_2_upload']["tmp_name"])));
        }
    }

    if (isset($_FILES['restaurant_image_3_upload']) && $_FILES['restaurant_image_3_upload']["size"] > 0) {
        if (validate_img_upload($_FILES['restaurant_image_3_upload']["tmp_name"])) {
            $data["image_3"] = "\"" . addslashes(file_get_contents($_FILES['restaurant_image_3_upload']["tmp_name"])) . "\"";
            $restaurant_images['image_3'] = "data:image/jpeg;base64," . base64_encode((file_get_contents($_FILES['restaurant_image_3_upload']["tmp_name"])));
        }
    }

    if (isset($_FILES['restaurant_image_4_upload']) && $_FILES['restaurant_image_4_upload']["size"] > 0) {
        if (validate_img_upload($_FILES['restaurant_image_4_upload']["tmp_name"])) {
            $data["image_4"] = "\"" . addslashes(file_get_contents($_FILES['restaurant_image_4_upload']["tmp_name"])) . "\"";
            $restaurant_images['image_4'] = "data:image/jpeg;base64," . base64_encode((file_get_contents($_FILES['restaurant_image_4_upload']["tmp_name"])));
        }
    }


    update_restaurant_values($data , "media");
    

    
    $display_update_message = true;
    
    
} else {
    $restaurant_images = get_restaurant_images();
   // var_dump( $restaurant_images);
}
?>



<div class="col-md-12">
    <div class="admin-heading"><h1>Gallery</h1></div>
</div>  

<div class="content">

    <div class="tbl">
        <div class="col-md-12">
            <?php
            if ($display_update_message) {
                ?>
                <div class="alert alert-success alert-border alert-soft"><span class="glyphicon glyphicon-ok"></span> <strong>Listing Updated</strong>  </div>
                <?php
            }
            ?>

            <div class="wdgt">
                <div class="wdgt-header">Add up to 4 images, png, jpeg, and gif allowed 2MB max</div>
        <div class="wdgt-body" style="padding-bottom:10px;">
         <form role="form" method="post" action="" enctype="multipart/form-data">
             <input type="hidden" name="check" value="checking-update">
          





             <div class="form-group">
                 <label for="exampleInputFile">Image 1</label>
                 <div id="restaurant_image_1_preview" class="admin_upload_preview" style="background-image:url(<?php echo $restaurant_images['image_1']; ?>);"></div>
                 <input type="file" id="restaurant_image_1_upload"  name="restaurant_image_1_upload"/>
             </div>
             <hr>
             <div class="form-group">
                 <label for="exampleInputFile">Image 2</label>
                 <div id="restaurant_image_2_preview" class="admin_upload_preview" style="background-image:url(<?php echo $restaurant_images['image_2']; ?>);"></div>
                 <input type="file" id="restaurant_image_2_upload"  name="restaurant_image_2_upload"/>
             </div>
<hr>
             <div class="form-group">
                 <label for="exampleInputFile">Image 3</label>
                 <div id="restaurant_image_3_preview" class="admin_upload_preview" style="background-image:url(<?php echo $restaurant_images['image_3']; ?>);"></div>
                 <input type="file" id="restaurant_image_3_upload"  name="restaurant_image_3_upload"/>
             </div>

<hr>
             <div class="form-group">
                 <label for="exampleInputFile">Image 4</label>
                 <div id="restaurant_image_4_preview" class="admin_upload_preview" style="background-image:url(<?php echo $restaurant_images['image_4']; ?>);"></div>
                 <input type="file" id="restaurant_image_4_upload"  name="restaurant_image_4_upload"/>
             </div>
<hr>



          <button class="btn btn-primary" type="submit" id="update_button">Update Listing</button>
         </form>
        </div>
       </div>

      </div>
   
     </div>

    </div>