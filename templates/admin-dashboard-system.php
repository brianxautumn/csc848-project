<?php
global $restaurant;
$data = array();
if (isset($_POST["confirm"])){
    
    $ID = $_POST["confirm"];
    $restaurant = get_restaurant_by("ID" , $ID );
    $current_status = get_restaurant_status();
    
    if($current_status != "active"){
       $data["status"] = "\"active\"";
        update_restaurant_values($data);
        restaurant_confirm_changes();
    
        //Lazy way, but fastest for now and it works becasue mysqli is non-blocking
        $location = HOME_URI . "/admin";
        header("Location: $location");
        exit;
     
    }
    
    
    
}else if (isset($_POST["deny"])){
    $ID = $_POST["deny"];
    $restaurant = get_restaurant_by("ID" , $ID );
    $current_status = get_restaurant_status();
    
    
    if($current_status != "active"){
        switch($current_status){
            case 'ready':
                 $data["status"] = "\"ready-denied\"";
                break;
            case 'pending':
                 $data["status"] = "\"pending-denied\"";
                break;
       
        }
        
        update_restaurant_values($data);
    
        //Lazy way, but fastest for now and it works becasue mysqli is non-blocking
        $location = HOME_URI . "/admin";
        header("Location: $location");
        exit;
    }

}

?>

<div class="col-md-12">
    <div class="admin-heading"><h1>System Administration</h1></div>
</div>  





<div class="content">

    <div class="tbl">
        <div class="col-md-12">


            <div class="wdgt">
                <div class="wdgt-header">Pending Confirmations</div>
                <div class="wdgt-body" style="padding-bottom:10px;">
                    
                    

                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <table class="table table-hover table-striped">
                           
                            <thead>
                                <tr>
                                    <th>Restaurant Name</th>
                                    <th>Status</th>
                                    <th>Preview</th>
                                    <th>Confirm</th>
                                    <th>Deny</th>

                                </tr>
                            </thead>
                            <tbody>
     
                                
                                   <?php
                    if (have_results()) :

                        while (have_results()) : load_restaurant();
                                 
                                ?>
                                <tr>
                                    <td><?php echo get_restaurant_name(); ?></td>
                                    <td><?php echo get_restaurant_formatted_status(); ?></td>
                                    <td><a href="#" class="btn btn-info admin-preview-button" location="<?php print_restaurant_url(); ?>">Preview Changes</a></td>
                                    <td><button type="submit" class="btn btn-success" name="confirm" value="<?php echo get_restaurant_ID(); ?>">Confirm</button></td>
                                    <td><button type="submit" class="btn btn-danger" name="deny" value="<?php echo get_restaurant_ID(); ?>">Deny</button></td>
                                </tr>
                                
                                
                                <?php endwhile; 
                                else:
                                ?>
                                
                               <!-- All restaurants up to date. -->
                                
                                <?php 
                                endif;
                                ?>
                                


                            </tbody>
                         </form>
                        </table>
                 



                        
                  
                </div>
            </div>

        </div>

    </div>

</div>




<div class="modal fade" id="admin-preview-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Preview Changes</h4>
      </div>
      <div class="modal-body">
        <iframe id="preview-iframe" style="zoom:0.0" width="99.6%" height="350" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
