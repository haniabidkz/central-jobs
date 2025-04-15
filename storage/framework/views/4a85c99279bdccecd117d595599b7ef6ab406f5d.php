<!--footer start-->
            <footer>
               <div class="footy-sec">
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <div class="d-flex justify-content-between">
                              <ul>
                                 <li><a href="<?php echo e(url('privacy-policy')); ?>" title=""><?php echo e(__('messages.PRIVACY_POLICY')); ?></a></li>
                                 <li><a href="<?php echo e(url('cookies-policy')); ?>" title=""><?php echo e(__('messages.COOKIES_POLICY')); ?></a></li>
                                 <li><a href="<?php echo e(url('terms-use')); ?>" title=""><?php echo e(__('messages.TERMS_OF_USE')); ?></a></li>
                                 <li><a href="<?php echo e(url('contact-us')); ?>" title=""><?php echo e(__('messages.CONTACT_US')); ?></a></li>
                                 <!-- <li><a href="<?php echo e(url('tips')); ?>" title=""><?php echo e(__('messages.TIPS')); ?></a></li> -->
                              </ul>
                              <p>© Copyright Central Jobs <?php echo date('Y');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </footer>
            <!--footer end-->
         </div>
         <div class="overlay"></div>
      </div>
      <div id="cover-spin"></div>

      <script type="text/javascript" src="<?php echo e(asset('frontend/js/aos.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/custom.js')); ?>"></script>
      <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
      
       <!-- Cookies Section -->
               <?php if(!isset($_COOKIE['cookie_consent'])){?>
               <div class="accept-cookies-holder">
                  <div class="container">
                        <div class="d-flex justify-content-between">  
                           <div class="text-holder">
                              <p><?php echo e(__('messages.COOKIES_ACCEPT_POLICY')); ?> <a class="cookie-anchor" href="<?php echo e((url('cookies-policy'))); ?>"><b><?php echo e(__('messages.COOKIES_POLICY')); ?></b></a>.
                               
                              <?php echo e(__('messages.COOKIES_ACCEPT_POLICY_2')); ?></p>
                           </div>
                           <div class=""> 
                              <div class="d-flex">
                                 <button class="btn coockies_consent site-btn-color mr-3 coockies-accept"> <?php echo e(__('messages.COOKIES_ACCEPT_POLICY_BUTTON')); ?> </button>
                                 <button class="btn site-btn" id="cookies-close"> <?php echo e(__('messages.REJECT')); ?> </button>
                              </div>
                           </div>   
                        </div> 
                  </div>       
               </div>
            <?php } ?>
               <script type="text/javascript">
                  $(document).on('click','.coockies_consent',function(){
                       Cookies.set('cookie_consent', 'yes' , { expires: 365 });
                       $('.accept-cookies-holder').hide();
                  });
               
               </script>
            <!-- Cookies Section -->
            
            <script>
               $(document).on('click', '.finalPayment', function(e) {
                  var flag       = true;
                  var card       = $('#card').val().trim();
                  var cvc        = $('#cvc').val().trim();
                  var exp_month  = $('#exp_month').val().trim();
                  var exp_year   = $('#exp_year').val().trim();

                  if(card=='' || cvc=='' || exp_month=='' || exp_year=='' ){
                     flag = false;
                  }
                  if(flag){
                     $('#cover-spin').show();
                  }
                  
               });
           </script>
           <?php echo $__env->yieldPushContent('page-script'); ?>
           <?php echo $__env->yieldPushContent('sub-page-script'); ?>
   </body>
</html>

<?php /**PATH /var/www/html/centralJobs/resources/views/frontend/includes/footer_after_login.blade.php ENDPATH**/ ?>