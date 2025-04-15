<?php $__env->startSection('content'); ?>

<!--  Custome login View  -->
  <!-- main -->
            <main>
               <div class="sign-in">
               <div class="container">
                  <div class="sign-in-page">
                     <div class="signin-popup">
                        <div class="signin-pop">
                           <div class="row">
                              <div class="col-md-6 col-12 right-border-sign">
                                 <div class="cmp-info">
                                    <div class="cm-logo">
                                       <a href="<?php echo e(url('/')); ?>" class="logo-holder" ><img src="<?php echo e(asset('frontend/images/logo-color2.png')); ?>" alt="" class="img-fluid"></a>
                                       <p> </p>
                                    </div>
                                    <!--cm-logo end-->   
                                    <img src="<?php echo e(asset('frontend/images/ResetPassword-person.jpg')); ?>" alt=""  class="img-fluid">         
                                 </div>
                                 <!--cmp-info end-->
                              </div>
                              <div class="col-md-6 col-12">
                                 <div class="d-flex align-items-center h-100">
                                    <div class="login-sec">
                                       <div class="sign_in_sec current" >
                                          <h3><?php echo e(__('messages.FORGOT_PASSWORD')); ?></h3>
                                                                                    
                                          <h5 class="signup-description mb-4 "><?php echo e(__('messages.FORGOT_PASSWORD_TEXT')); ?>.</h5>
                                          <form autocomplete="off" id="email_pass_reset_link" method="POST" action="<?php echo e(route('password.email')); ?>">
                                              <?php echo csrf_field(); ?>
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('messages.EMAIL')); ?> *">
                                                      <!-- error -->
                                                    
                                                      <!-- end -->
                                                      <i class="la la-user"></i>
                                                   </div>
                                                   <?php if($errors->first('email')): ?>
                                             
                                                    <label id="email-error" class="error" for="email"> <?php echo e($errors->first('email')); ?></label>

                                                    <?php elseif(session('status')): ?>
                                                       
                                                        <label id="email-error" class="success-color" for="email"> <?php echo e(session('status')); ?></label>

                                                    <?php elseif(session('error_status')): ?>

                                                        <label id="email-error" class="error-color" for="email"> <?php echo e(session('error_status')); ?></label>

                                                     <?php endif; ?>
                                                </div>
                                                
                                                <div class="col-12 mt-4">
                                                   <button class="submit-btn" type="submit" value="submit"><?php echo e(__('messages.SUBMIT')); ?></button>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <!--sign_in_sec end-->
                                    </div>
                                    <!--login-sec end-->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--signin-pop end-->
                     </div>
                     <!--signin-popup end-->
                  </div>
                  <!--sign-in-page end-->
              </div>
               <!--theme-layout end-->
              </div>
            </main>
            <!-- main End -->
<?php $__env->stopSection(); ?>
<!-- End Custom Login View -->

<?php echo $__env->make('layouts.app_before_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>