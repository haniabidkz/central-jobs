var Post = {
    init: function(){
        Post.passwordUpdate();
        Post.resetPassword();
        Post.sendMail();
        Post.login();
        Post.editCms();
        Post.addCms();
    },
    passwordUpdate:function(){
        $(document).ready(function() {
           $( ".toggle-password" ).on( "click", function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $("#oldPassword");
                if (input.attr("type") === "password") {
                  input.attr("type", "text");
                } else {
                  input.attr("type", "password");
                }

            });
           $( ".toggle-password-new" ).on( "click", function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $("#password");
                if (input.attr("type") === "password") {
                  input.attr("type", "text");
                } else {
                  input.attr("type", "password");
                }

            });
           $( ".toggle-password-re" ).on( "click", function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $("#password_confirmation");
                if (input.attr("type") === "password") {
                  input.attr("type", "text");
                } else {
                  input.attr("type", "password");
                }

            });
           $( "#password_confirmation" ).on( "keyup", function() {
                var pass = $("#password").val();
                var passConf = $("#password_confirmation").val();
                if(pass == passConf){
                  $('#password_confirmation').addClass('match-cls');
                }else{
                  $('#password_confirmation').removeClass('match-cls');
                }
            });
            $( "#password" ).on( "keyup", function() {
                var pass = $("#password").val();
                var passConf = $("#password_confirmation").val();
                if(pass == passConf){
                  $('#password_confirmation').addClass('match-cls');
                }else{
                  $('#password_confirmation').removeClass('match-cls');
                }
            });
           jQuery.validator.addMethod("noSpace", function(value, element) { 
              return value.indexOf(" ") < 0 && value != ""; 
            }, "No space please and don't leave it empty");
            $("#changePassword").validate({
                rules: {
                    oldPassword: {
                        required: true,
                        noSpace : true,
                        minlength : 6
                    },
                    password: {
                        required: true,
                        noSpace : true,
                        minlength : 6,
                        maxlength: 15
                    },
                    password_confirmation: {
                        required: true,
                        noSpace : true,
                        minlength : 6,
                        maxlength: 15,
                        equalTo : "#password"
                    }
                },
                messages: {
                    password_confirmation: {
                        equalTo: "Confirm password doesn't match with your new password"
                    }
                },
            });
        
        
        });
    },
    resetPassword:function(){
        $(document).ready(function() {
          jQuery.validator.addMethod("noSpace", function(value, element) { 
              return value.indexOf(" ") < 0 && value != ""; 
            }, "No space please and don't leave it empty");
            $("#resetPass").validate({

                rules: {
                    email: {
                        required: true,
                        email : true

                    },
                    password: {
                        required: true,
                        noSpace : true,
                        minlength : 6,
                        maxlength: 15,
                        //PASSWORD:true
                    },
                    password_confirmation: {
                        required: true,
                        noSpace : true,
                        minlength : 6,
                        maxlength: 15,
                            //PASSWORD:true,
                        equalTo : "#password"
                    }
                },
                messages: {
                    email:{
                        required: "Please enter email.",
                        email: "Please enter valid email."
                    },
                    password:{
                        required: "Please enter password.",
                        minlength: "Please enter atleast 6 character.",
                        maxlength: "Maximum character length is 15."
                    },
                    password_confirmation: {
                        required: "Please enter confirm password.",
                        equalTo: "Confirm password doesn't match with your new password."
                    }
                },
            });
        
        
        });
    },
    sendMail:function(){
        $(document).ready(function() {
            $("#sendmail").validate({
                rules: {
                    email: {
                        required: true,
                        email : true

                    }
                },
                messages:{
                    email:{
                        required: "Please enter email.",
                        email: "Please enter valid email."
                    }
                }
            });
        
        
        });
    },
    login:function(){
        $(document).ready(function() {
            $("#login").validate({

                rules: {
                    email: {
                        required: true,
                        email : true

                    },
                    password: {
                        required: true
                    }
                },
                messages:{
                    email:{
                        required: "Please enter email.",
                        email: "Please enter valid email."
                    },
                    password:{
                        required: "Please enter password."
                    }
                }
            });
        
        
        });
    },
    addCms:function(){
        $(document).ready(function() {
            CKEDITOR.replace( 'text_english');
            CKEDITOR.replace( 'text_french');
            CKEDITOR.replace( 'text_portuguese');

            $( "#addCmsText" ).submit( function( e ) { 
                $('.descErrEng').html("");
                $(".descErrEng").removeClass("error");
                $('.descErrFre').html("");
                $(".descErrFre").removeClass("error");
                $('.descErrPrt').html("");
                $(".descErrPrt").removeClass("error");
                //in case, if didn't worked, remove below comment. This will get the textarea with current status
               //CKEDITOR.instances.textarea_input_name.updateElement( ); 
               var messageLengthEng = CKEDITOR.instances['text_english'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLengthEng )
               {
                   $('.descErrEng').html("Please enter english description.");
                   $(".descErrEng").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   $('html, body').animate({
                        scrollTop: ($('.error').first().offset().top)
                    },500);
                   return false;
               }
               var messageLengthFr = CKEDITOR.instances['text_french'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLengthFr )
               {
                   $('.descErrFre').html("Please enter french description.");
                   $(".descErrFre").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   $('html, body').animate({
                        scrollTop: ($('.error').first().offset().top)
                    },500);
                   return false;
               }
               var messageLengthPr = CKEDITOR.instances['text_portuguese'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLengthPr )
               {
                   $('.descErrPrt').html("Please enter portuguese description.");
                   $(".descErrPrt").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   return false;
               }
                return true;
           } );
        });
    },
    editCms:function(){
        $(document).ready(function() {
            CKEDITOR.replace( 'text');

            $( "#editCmsText" ).submit( function( e ) { 
                $('.descErr').html("");
                $(".descErr").removeClass("error");
                
                //in case, if didn't worked, remove below comment. This will get the textarea with current status
               //CKEDITOR.instances.textarea_input_name.updateElement( ); 
               var messageLength = CKEDITOR.instances['text'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLength )
               {
                   $('.descErr').html("Please enter description.");
                   $(".descErr").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   return false;
               }
                return true;
           } );
        });
    }
}

Post.init();