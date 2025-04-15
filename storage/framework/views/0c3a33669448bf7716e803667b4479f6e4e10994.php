<script src="https://www.google.com/recaptcha/api.js" ></script>

<?php $__env->startSection('content'); ?>
 <!-- main -->
  
   
<main>
   <section class="banner banner-innerpage">
        <div class="bannerimage">
           <img src="<?php echo e(asset(@$data[0]['page_content']['page_info']['banner_image']['location'])); ?>" alt="image">
        </div>
        <div class="bennertext">
            <div class="innertitle">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <h2><?php echo e(strip_tags(@$data[2]['text'])); ?></h2>                
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
                            <form id="form_contact_us" method="post" action="<?php echo e(url('contact-us')); ?>">

                                <?php echo e(csrf_field()); ?>


                                <div class="login-form mw-100">
                                    <div class="form-group" id="subject_parent">
                                        <select class="form-control" name="subject" onchange="checkSubject()" id="subject">
                                        <option value=""><?php echo e(__('messages.SELECT_YOUR_SUBJECT')); ?></option>
                                        <option value="Questions"><?php echo e(__('messages.QUESTIONS')); ?></option>
                                        <option value="Suggestion"><?php echo e(__('messages.SUGGESTION')); ?></option>
                                        <option value="Complain"><?php echo e(__('messages.COMPLAIN')); ?></option>
                                        <option value="Financial"><?php echo e(__('messages.FINANCIAL')); ?></option>
                                        <option value="Data Protection - DPO"><?php echo e(__('messages.DATA_PROTECTION')); ?></option>
                                        <option value="Change Data"><?php echo e(__('messages.CHANGE_DATA')); ?></option>

                                        
                                        <option value="Other"><?php echo e(__('messages.OTHER')); ?></option> 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="name" placeholder="<?php echo e(__('messages.NAME')); ?>" type="text" />
                                    </div>
                                    <div class="form-group required">
                                        <input class="form-control" name="email" placeholder="<?php echo e(__('messages.EMAIL')); ?>" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="description" placeholder="<?php echo e(__('messages.DESCRIPTION')); ?>"></textarea>
                                    </div>
                                    <div class="g-recaptcha"
					     data-sitekey="<?php echo e(config('app.recaptcha_SiteKey')); ?>"
					     data-callback="submitForm"
					     data-size="invisible">
					</div>
                                    <div class="social-btnlist">
                                        <button   class="w-100 btn site-btn-color contact_us_btn" name="submit1" type="submit"><?php echo e(__('messages.SUBMIT_REQUEST')); ?> <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
                                    </div> 
                                    <div class="form-group privicy-checkbox mt-3">
                                        <label class="check-style"><?php echo e(__('messages.I_AGREE_TO_THE')); ?> <a href="<?php echo e(url('privacy-policy')); ?>"><?php echo e(__('messages.PRIVACY_POLICY')); ?></a><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE_AFTER')); ?>

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
            
        },

        messages: {
            name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_NAME),
            email: $this.lanFilter(allMsgText.PLEASE_PROVIDE_EMAIL),
            subject: $this.lanFilter(allMsgText.PLEASE_SELECT_SUBJECT),
            description: $this.lanFilter(allMsgText.PLEASE_PROVIDE_DESCRIPTION),
            privacy_policy: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_PRIVACY_POLICY)
            
        },
        submitHandler: function (event) {

              if (grecaptcha.getResponse()) {
                event.submit();
            }else{
                grecaptcha.reset();
                grecaptcha.execute();
            }
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
            $("#subject_parent").after('<div class="form-group commercial_register"> <input required class="form-control" name="commercial_register" placeholder="<?php echo e(__('messages.COMMERCIAL_REGISTER')); ?>" type="text" /> </div>');
        }else{
            $(".commercial_register").remove();
        }

    }
  
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_after_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/frontend/cms/contactUs.blade.php ENDPATH**/ ?>