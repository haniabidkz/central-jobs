var Post = {
    init: function(){
        Post.list();
        Post.add();
        Post.edit();
    },
    list:function(){
        $(document).ready(function() {
            // CKEDITOR.replace( 'instruction');
            // //DATEPICKER
            // $( "#start_date" ).datepicker({
            //     dateFormat: "yy/mm/dd",
            //     //minDate: +1,
            //     onSelect: function(selected) {
            //     $("#end_date").datepicker("option","minDate", selected)
            //    }
            // });
            // $('#end_date').datepicker({
            //     dateFormat: "yy/mm/dd",
            //     //minDate: +1,
            //     onSelect: function(selected) {
            //     $("#start_date").datepicker("option","maxDate", selected)
            //     }
            // });
            //FOR JOB AND COMPANY CHANGE STATUS
            $( ".status" ).on( "click", function() {
                var status = $(this).data("val");
                var id = $(this).data("id");
                $(document).find(".loder-holder").removeClass('d-none');
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/subscription-change-status",
                    data: { 'status': status,'id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        //$(document).find(".loder-holder").addClass('d-none');
                        //console.log(res);
                        location. reload();
                    }
                }); 
            });
            //SEARCH FIELD VALIDATION
            $('#searchBtn').on("click", function() {
               var title = $.trim($('#title').val());
               var status = $('#status').val();
               if((title == '') && (status == '')){
                    $('#searchId').html('Please enter any search value.');
                    return false;
               } 
            });
        });
    },
    edit:function(){
        $(document).ready(function() {
            CKEDITOR.replace( 'instruction');
            // ADD CATEGORY VALIDATION
            $( "#editSubscription" ).submit( function( e ) { 
                $('.descErr').html("");
                $(".descErr").removeClass("error");
                
                //in case, if didn't worked, remove below comment. This will get the textarea with current status
               //CKEDITOR.instances.textarea_input_name.updateElement( ); 
               var messageLength = CKEDITOR.instances['instruction'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLength )
               {
                   $('.descErr').html("Please enter subscription instruction.");
                   $(".descErr").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   return false;
               }
                return true;
           } );

            // jQuery.validator.addMethod("notEqual", function(value, element, param) {
            //   return this.optional(element) || value != param;
            // }, "Please specify a different (non-default) value");
            $.validator.addMethod("noSpace", function(value, element) { 
                if(value != ''){
                    value = $.trim(value);
                    if(value == ''){
                        return false;
                    }else{
                        return true;
                    }	
                }
                //return value.indexOf(" ") < 0 && value != ""; 
                }, 'No space please and do not leave it empty.'); 
            $("#editSubscription").validate({
                rules: {
                    title: {
                        required: true,
                        noSpace: true
                    },
                    price: {
                        //required:true,
                        //notEqual: 0 ,
                        number: true
                    },
                    description:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    }
                },
                messages:{
                    title:{
                        required: "Please enter your service name."
                    },
                    price: {
                        //required: "Please enter subscription price.",
                       // notEqual: "Please enter valid subscription price.",
                        number: "Price should be decimal numbers only."
                    },
                    description:{
                        required: "Please enter subscription details ",
                        maxlength: "Subscription details  should not exceed 255 characters."
                    }
                }
            });
            
        });
    },
    add:function(){
        $(document).ready(function() {
            // ADD CATEGORY VALIDATION
            // jQuery.validator.addMethod("notEqual", function(value, element, param) {
            //   return this.optional(element) || value != param;
            // }, "Please specify a different (non-default) value");
            $.validator.addMethod("noSpace", function(value, element) { 
                if(value != ''){
                    value = $.trim(value);
                    if(value == ''){
                        return false;
                    }else{
                        return true;
                    }	
                }
                //return value.indexOf(" ") < 0 && value != ""; 
                }, 'No space please and do not leave it empty.'); 
            $("#addSubscription").validate({
                rules: {
                    title: {
                        required: true,
                        noSpace: true,
                    },
                    price: {
                        required:true,
                        min: 1,
                        number: true
                    },
                    description:{
                        noSpace: true,
                        maxlength: 255
                    }
                },
                messages:{
                    title:{
                        required: "Please enter your subscription title."
                    },
                    price: {
                        required: "Please enter subscription price.",
                        min: "Amount must be greater than 0",
                        number: "Price should be decimal numbers only."
                    },
                    description:{
                        maxlength: "Description should not exceed 255 characters."
                    }
                }
            });
            
        });
    },
}

Post.init();