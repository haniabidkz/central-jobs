<script src="https://www.google.com/recaptcha/api.js" ></script>
@extends('layouts.app_after_login_layout')
@section('content')
 <!-- main -->
  
   
<main>
   <section class="banner banner-innerpage">
        <div class="bannerimage">
           <img src="{{asset(@$data[0]['page_content']['page_info']['banner_image']['location'])}}" alt="image">
        </div>
        <div class="bennertext">
            <div class="innertitle">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <h2>{{strip_tags(@$data[2]['text'])}}</h2>                
                        </div>
                        
                    </div>
                </div>
            </div>                  
        </div>
    </section>
       <!-- wraper-trams- -->
       <section class="wraper-default-innerpage">
            <div class="container">
                    <div class="row justify-content-center">                                
                        <div class="col-12 col-lg-8">
                            <!-- <img src="images/contact-img.jpg" alt=""> -->
                            <div class="default-main whitebg">
                            <form id="form_contact_us" method="post" action="{{url('contact-us')}}">

                                {{ csrf_field() }}

                                <div class="login-form mw-100">
                                    <div class="form-group" id="subject_parent">
                                        <select class="form-control" name="subject" onchange="checkSubject()" id="subject">
                                        <option value="">{{__('messages.SELECT_YOUR_SUBJECT')}}</option>
                                        <option value="Questions">{{__('messages.QUESTIONS')}}</option>
                                        <option value="Suggestion">{{__('messages.SUGGESTION')}}</option>
                                        <option value="Complain">{{__('messages.COMPLAIN')}}</option>
                                        <option value="Financial">{{__('messages.FINANCIAL')}}</option>
                                        <option value="Data Protection - DPO">{{__('messages.DATA_PROTECTION')}}</option>
                                        <option value="Change Data">{{__('messages.CHANGE_DATA')}}</option>

                                        
                                        <option value="Other">{{__('messages.OTHER')}}</option> 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="name" placeholder="{{__('messages.NAME')}}" type="text" />
                                    </div>
                                    <div class="form-group required">
                                        <input class="form-control" name="email" placeholder="{{__('messages.EMAIL')}}" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="description" placeholder="{{__('messages.DESCRIPTION')}}"></textarea>
                                    </div>
                                    <!-- Manual CAPTCHA -->
                                    <div class="form-group required">
                                        <div class="g-recaptcha" data-sitekey="6LfjpoIrAAAAAHU9raDrgmzo5Vv7KcO0PQtIXFrH"></div>
                                        <label id="recaptcha-error" class="error" style="display:none;color:#e74c3c;margin-top:5px;"></label>
                                    </div>
                                    <div class="social-btnlist">
                                        <button   class="w-100 btn site-btn-color contact_us_btn" name="submit1" type="submit">{{__('messages.SUBMIT_REQUEST')}} <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
                                    </div> 
                                    <div class="form-group privicy-checkbox mt-3">
                                        <label class="check-style">{{__('messages.I_AGREE_TO_THE')}} <a href="{{url('privacy-policy')}}">{{__('messages.PRIVACY_POLICY')}}</a>{{__('messages.I_HAVE_READ_AND_AGREE_WITH_THE_AFTER')}}
                                            <input type="checkbox" name="privacy_policy" id="privacy_policy">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                            </form>    
                        </div>
                        <!--  <div class="col-12 col-lg-6">
                            <div class="contact-information">
                                <?php echo @$data[1]['text']; ?>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>       
        </section>
               <!--  <div class="contact-map">
                <?php echo @$data[0]['text']; ?>
                </div> -->
       
</main>
<!-- main End -->





<script>
$(document).ready(function(){
    
    $.validator.addMethod("laxEmail", function(value, element) {
              // allow any non-whitespace characters as the host part
              var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
              return this.optional( element ) || re.test( value );
            }, 'Please enter a valid email address.');
    $.validator.addMethod("noSpace", function(value, element) { 
    if(value != ''){
        value = $.trim(value);
        if(value == ''){
            return false;
        }else{
            return true;
        }	
    }

    //return value.indexOf(" ",1) < 0 && value != ""; 
    }, $this.lanFilter($this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY)));
    $.validator.addMethod("recaptchaRequired", function(value, element, param) {
        return grecaptcha.getResponse().length > 0;
    }, "Please verify that you are not a robot.");

    $("#form_contact_us").validate({
        rules: {
            name: {
                required: true,	
                noSpace: true																			
            },
            email: {
                required: true,	
                laxEmail: true																			
            },
            subject:{
                required: true
            },
            description:{
                required: true,
                noSpace: true
            },
            privacy_policy:{
                required: true
            },
            'g-recaptcha-response': {
                recaptchaRequired: true
            }
        },

        messages: {
            name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_NAME),
            email: $this.lanFilter(allMsgText.PLEASE_PROVIDE_EMAIL),
            subject: $this.lanFilter(allMsgText.PLEASE_SELECT_SUBJECT),
            description: $this.lanFilter(allMsgText.PLEASE_PROVIDE_DESCRIPTION),
            privacy_policy: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_PRIVACY_POLICY),
            'g-recaptcha-response': "Please verify that you are not a robot."
            
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") === "g-recaptcha-response") {
                $("#recaptcha-error").html(error.text()).show();
            } else {
                error.insertAfter(element);
            }
        },
        success: function(label, element) {
            if ($(element).attr("name") === "g-recaptcha-response") {
                $("#recaptcha-error").hide();
            }
        },
        submitHandler: function(form) {
            if (grecaptcha.getResponse().length === 0) {
                $("#recaptcha-error").html("Please verify that you are not a robot.").show();
                return false;
            }
            $("#recaptcha-error").hide();
            form.submit();
        }
    });
   
    // Prevent manual submit if reCAPTCHA not checked
    $('#form_contact_us').on('submit', function(e) {
        if (grecaptcha.getResponse().length === 0) {
            e.preventDefault();
            $("#recaptcha-error").html("Please verify that you are not a robot.").show();
        } else {
            $("#recaptcha-error").hide();
        }
    });
});
var validationCheck = false;
/* $("#form_contact_us").submit(function(event) {	
    if (grecaptcha.getResponse()) {
        alert('asd')
        // 2) finally sending form data
        event.submit();
    }else{
        // 1) Before sending we must validate captcha

        grecaptcha.reset();
        console.log('validation completed.');

        event.preventDefault(); //prevent form submit before captcha is completed
        grecaptcha.execute();

    }

}); */
 function submitForm() {
 event.preventDefault();
        console.log('captcha completed.');        
        $("#form_contact_us").submit();
        return true;
    }


    function checkSubject(){
        var subject = $("#subject").val();
        if(subject == 'Change Data'){
            $("#subject_parent").after('<div class="form-group commercial_register"> <input required class="form-control" name="commercial_register" placeholder="{{__('messages.COMMERCIAL_REGISTER')}}" type="text" /> </div>');
        }else{
            $(".commercial_register").remove();
        }

    }
  
</script>
@endsection
