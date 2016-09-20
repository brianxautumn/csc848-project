$(function () {

    $("#slideshow > div:gt(0)").hide();

    setInterval(function () {
        $('#slideshow > div:first')
                .fadeOut(3000)
                .next()
                .fadeIn(3000)
                .end()
                .appendTo('#slideshow');
    }, 6000);

    $("#restaurant_main_upload").change(function () {
        validateImg(this, $("#restaurant_main_preview"));
    });

    $("#restaurant_image_1_upload").change(function () {
        validateImg(this, $("#restaurant_image_1_preview"));
    });

    $("#restaurant_image_2_upload").change(function () {
        validateImg(this, $("#restaurant_image_2_preview"));
    });

    $("#restaurant_image_3_upload").change(function () {
        validateImg(this, $("#restaurant_image_3_preview"));
    });

    $("#restaurant_image_4_upload").change(function () {
        validateImg(this, $("restaurant_image_4_preview"));
    });




    $("#day_0_start").change(function () {
        console.log(this.value());
    });
    var badImgCounter = [];
    function validateImg(input, preview) {
        var inputId = $(input).attr("id");
        
        var MIN = 400;
        var MAX = 1800;
        var RATIO = 2;

        if (input.files && input.files[0]) {
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
            var reader = new FileReader();
            var file = input.files[0];
            var filename = $(input).val();
            var extension = filename.split('.').pop().toLowerCase();
            var img = new Image();
            //var fr = new FileReader();
            console.log(inputId);
       

            //&& img.width < MAX && img.height < MAX && img.width > MIN && img.height > MIN
            if ($.inArray(extension, fileExtension) == -1  && file.size < 1024 * 1024 * 2 ){
                if(badImgCounter.indexOf(inputId) == -1){
                   badImgCounter.push(inputId); 
                   
                }
                $(input).parent( ".form-group" ).css( "background-color", "#ff8080" );
                $("#update_button").attr("disabled", "disabled");
                alert("Invalid image");
                return false;
            }else{
                reader.readAsDataURL(file);
            
                img.src = reader.result;
            }
            

            reader.onload = function (e) {
                //'background-image',   e.target.result
                var result = 'url(' + e.target.result + ')';
                //console.log(result);
                //$('#restaurant_main_preview').css('background-image' , result );
                preview.css('background-image', result);
            }

            
            
            if(badImgCounter.indexOf(inputId) != -1){
                   badImgCounter.splice(badImgCounter.indexOf(inputId) , 1);
                   $(input).parent( ".form-group" ).css( "background-color", "transparent" );
            }
            
            console.log(badImgCounter);
            
            if(badImgCounter.length == 0 ){
                
       
                
                $("#update_button").removeAttr("disabled");
            }
            
        }
    }


    $("#kill-banner").click(function (event) {
        event.preventDefault();
        $("#class-banner").hide("slow");
    });

    
    $( "#datepicker" ).datepicker({
        minDate: new Date()
    });
    //initializes datepickers original date
    $( "#datepicker" ).datepicker('setDate', new Date());
    updateAvailableTimes();
    
    $( "#datepicker" ).change(updateAvailableTimes);

 
    $("#reservation_party_size").change(updateAvailableTimes);
    $("#reservation_time").change(updateAvailableTimes);

    //updateAvailableTimes();
    
    function updateAvailableTimes(){

        var party = $("#reservation_party_size").val();
        var date = $("#datepicker").val();
        var time = $("#reservation_time").val();
        var restaurant_id = $("#restaurant_id").val();
        $.ajax(
                {
                    url: window.location.pathname + "/get_times/",
                    type: "POST",
                    data: {
                        party: party,
                        date: date,
                        time: time,
                        ID: restaurant_id
                    },
                    success: function (result) {
                        $("#available_times").html(result);
                    }});
    }


    //----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
 
        e.preventDefault();
    });
 
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
 
        e.preventDefault();
    });
    
    var preview_target;
$('.modal').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
  $(this).find('iframe').attr('src', preview_target);
})

    $('.admin-preview-button').click(function(event){
        event.preventDefault();
        preview_target = $(this).attr('location');
        
        $('#admin-preview-modal').on('show', function () {

           $('#preview-iframe').attr("src", "werwe");
      
            });
     $('#admin-preview-modal').modal({show:true});
    });
    /**
    $('.admin-preview-button').bind( "click", function( event ) {
        event.preventDefault();
        $('#admin-preview-modal').on('show', function () {

           $('iframe').attr("src", "www.google.com");
      
            });
         $('#admin-preview-modal').modal({show:true});
     });
     **/
    
    
    
    $("#registration-form").validate({
        rules: {
            user_email: {
                required: true,
                email: true
            },
            user_password:{
                required: true,
                minlength: 6
            },
            user_confirm_password:{
                equalTo: "#user_password"
            }
        }
    });
    
        $("#registration-form-restaurant").validate({
        rules: {
            user_email: {
                required: true,
                email: true
            },
            user_password:{
                required: true,
                minlength: 6
            },
            user_confirm_password:{
                equalTo: "#user_password"
            }
        }
    });
    
    $("#restaurant-basic-info").validate({
       rules:{
           restaurant_phone_number:{
               phoneUS: true
           },
           restaurant_website:{
               url: true
           }
       } 
    });
    
    
    $("#restaurant_reservation_form").validate({
        rules: {
            user_email: {
                required: true,
                email: true
            },
            reservation_name:{
                required: true
            },
            reservation_time_slot: {
                required: true
            }
        },
        messages:{
           reservation_time_slot:{
               required: "Please Select an Available Time"
           },
           reservation_name:{
                required: "Please enter a name"
            },
            user_email: {
                required: "Please enter an Email"
            }
        },
        errorPlacement: function(error, element) {
        if (element.attr("name") == "reservation_time_slot" ) {
      error.appendTo("#reservation-error-output");
        } else {
      error.insertAfter(element);
    }
  }
        
    });
    
    
     $("#search_location").click(function(){
         
         $(this).select();
     });

});