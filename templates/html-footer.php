<div class="popup" data-popup="popup-1" style="z-index: 4">
                                      <div class="popup-inner">
                                       
                                          <h5><b>Privacy Policy</b></h5>
                                          <p>This privacy policy discloses the privacy practices for http://sfsuswe.com/~f15g15/. This privacy policy applies solely to information collected by this web site. It will notify you of the following</p>
                                          <ol type="I">
                                            <li>What personally identifiable information is collected from you through the web site, how it is used and with whom it may be shared.</li>
                                            <li> What choices are available to you regarding the use of your data.</li>
                                            <li> The security procedures in place to protect the misuse of your information.</li>
                                            <li> How you can correct any inaccuracies in the information.</li>
                                          </ol>
                                            
                                          <h5><b>Your Access to and Control Over Information.</b></h5>
                                            <p>You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>
                                            <ul style="list-style-type:disc">
                                                <li>See what data we have about you, if any.</li>

                                                <li>Change/correct any data we have about you.</li>

                                                <li>Have us delete any data we have about you.</li>

                                                <li>Express any concern you have about our use of your data.</li>
                                            </ul>
                                 
                                            <h5><b>Updates</b></h5>

                                                <p>Our Privacy Policy may change from time to time and all updates will be posted on this page.</p>
                                
                                             <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
                                      </div>
                                    </div> 

<div class="popup" data-popup="popup-2" style="z-index: 4">
                                      <div class="popup-inner">
                                       
                                          <h5><b>Terms & Conditions</b></h5>
                                          <ul>
                                                <li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
                                                <li> This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties: [insert list of information].</li>
                                                <li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
                                                <li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
                                          </ul>
                                
                                             <a class="popup-close" data-popup-close="popup-2" href="#">x</a>   
                                      </div>
                                    </div> 

<div class="popup" data-popup="popup-3" style="z-index: 4">
                                      <div class="popup-inner">
                                       
                                          <h4>About Us</h4>
                                         <p> Team F15G15 - Software Engineering Class CSC 648-848 <br/>  San Francisco State University. <br/>
                                             <br/>
                                             Ryan Veca (Team Lead)<br/>
                                             Brian Parra (Tech Lead)<br/>
                                             Kenny McHoes <br/>
                                             Aman Arora <br/>
                                             Vince DiCarlo <br/>
                                             Sandeep Tulachan <br/>                         
                                                                                         
                                                                                      
                                         </p>
                                         
                                       
                                
                                             <a class="popup-close" data-popup-close="popup-3" href="#">x</a>   
                                      </div>
                                    </div> 

<footer <?php if(is_search()) echo "class=\"footer-search\""; ?>>
    <div class="footer-content">
        <div class="container">
            <div class="col-md-4">Copyright &copy; 2015 Team 15</div>

            <div class="col-md-8">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php print_home_url(); ?>">Home</a></li>
                    <?php if(!is_logged_in()){ ?><li><a href="<?php print_register_restaurant_url(); ?>">Business Registration</a></li> <?php }?>
                    <li><a data-popup-open="popup-2" href= "#">Terms &amp; Conditions</a></li>
                    <li><a data-popup-open="popup-1" href="#">Privacy Policy</a></li>
                    <li><a data-popup-open="popup-3" href="#">About Us</a></li>
                </ul><!-- /.nav -->
            </div>


        </div>
    </div>
</footer>

</div> <!-- End Wrap -->

    <!-- This way sucks, fix it later -->
    <script src="<?php echo  ROOT .TEMPLATES .'/js/jquery-2.1.4.min.js'?>" type="text/javascript"></script>
    <script src="<?php echo ROOT .TEMPLATES .'/js/jquery-ui.min.js'?>" type="text/javascript"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo  ROOT .TEMPLATES .'/js/bootstrap.min.js'?>" type="text/javascript"></script>
    <script src="<?php echo ROOT .TEMPLATES .'/js/app.js'?>" type="text/javascript"></script>
    <script src="<?php echo ROOT .TEMPLATES .'/js/jquery.validate.min.js'?>" type="text/javascript"></script>
    <script src="<?php echo ROOT .TEMPLATES .'/js/additional-methods.js'?>" type="text/javascript"></script>
    
    <!-- Load Maps API -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYnwbgdWLmxymh4ieGWclIGYuuArUoTFE&libraries=places"></script>
    <?php
    if(get_admin_tab() == 'basic-info'){
        load_admin_map_scripts();
    }else if(is_restaurant() || is_reservation()){
        load_restaurant_map_scripts();
    }
    ?>
    
    

    <script>
        //$( "#reservation_form" ).load( "<?php template_path('reservation-form.php'); ?>" );
    </script>


    <script>
    $(function () {
        var searchInput = /** @type {HTMLInputElement} */(
                document.getElementById('search_location'));
        var searchAutocomplete = new google.maps.places.Autocomplete(searchInput);
        
        

        
        searchAutocomplete.addListener('place_changed', function() {

       
        var searchPlace = searchAutocomplete.getPlace();
       
        
        $("#place_id_search").val(searchPlace.place_id);
        $("#lat_search").val(searchPlace.geometry.location.lat);
        $("#long_search").val(searchPlace.geometry.location.lng);
        $("#place_restore_search").val(searchPlace.formatted_address);
        console.log(searchPlace);
        //if (!place.geometry) {
         //    window.alert("Autocomplete's returned place contains no geometry");
        //return;
        //}
    });
    
    });
    </script>
    
    <?php
    if(is_search()) load_search_map_scripts(null);
    ?>

</body>
</html>
