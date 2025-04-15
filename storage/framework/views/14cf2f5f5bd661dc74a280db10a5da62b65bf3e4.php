<?php $__env->startSection('content'); ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                            <h2><?php echo e(strip_tags(@$data[1]['text'])); ?></h2>                
                        </div>
                    </div>
                </div>
            </div>                  
        </div>
    </section>
       <!-- wraper-trams- -->
    <section class="wraper-default-innerpage">
        <div class="container">
            <div class="row">                                
               <div class="col-12">
                  <div class="text-right font-weight-bold mb-2">
                    <a href="javascript:void(0);" class="text-dark consent_withdraw"> <?php echo e(__('messages.CONSENT_WITHDRAW')); ?> </a>
                  </div>
                  <div class="default-main whitebg cookies-text">
                  <?php echo @$data[0]['text']; ?>
                  </div>
               </div>
            </div>
        </div>       
    </section>
</main>
<!-- main End -->
<?php if(Auth::user()){?>
<script>
$(document).ready(function(){
    $(document).on('click','.consent_withdraw',function(){
       <?php if(Auth::user()->user_type == 2){?>
            var usertype = 'candidate';
        <?php }else if(Auth::user()->user_type == 3){?>
            var usertype = 'company';
       <?php } ?>
        
        var text = allMsgText.YOUR_PROFILE_WILL_BE_DELETED_AS_THE_CONTENT_FOR_POLICIES_IS_MANDATORY;
        swal({
            //title: allMsgText.ARE_YOU_SURE,
            text: text,
            buttons: [true, "Proceed"],
        })
        .then((willDelete) => {
            if(willDelete){
                window.location.href = _BASE_URL+'/'+usertype+'/manage-profile';
            }
            
        });
    });
});
</script>
<?php }else{?>
<script>
    $(document).ready(function(){
        $(document).on('click','.consent_withdraw',function(){
            var text = allMsgText.PLEASE_LOGIN_TO_YOUR_ACCOUNT_TO_WITHDRAW_YOUR_CONSENT;
            swal({
                //title: allMsgText.ARE_YOU_SURE,
                text: text,
                cancel: true,
            })
            .then((willDelete) => {
                
            });
        });
    });
</script>
<?php }?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_after_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/frontend/cms/terms.blade.php ENDPATH**/ ?>