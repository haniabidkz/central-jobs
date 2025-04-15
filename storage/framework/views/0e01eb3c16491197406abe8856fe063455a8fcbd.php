<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('frontend/js/sweetalert.min.js')); ?>"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<?php 
$typ = old('user_type'); 
//$seg = request()->segment(count(request()->segments())); if($seg == 'joinus'){ $typ = 3;}
?>
<?php if((Session::get('regSuccessMsg') != '') && (Session::get('regSuccessMsg') != null)){
   $regSuccessMsg = Session::get('regSuccessMsg');
   $title = Session::get('title');?>
<script>
var data = '<?php echo strip_tags($regSuccessMsg);?>';
var title = '<?php echo strip_tags($title);?>';
//swal(title, data, "success");
swal({
  title: title,
   icon: "success",
   text: data,
  //showConfirmButton: false,
  //html: true,
  className: "swal-email-notification"
});
</script>
<?php } ?>


<!--  Custome login View  -->
 <!-- main -->
            <main>
               <section class="home-section2">
                  <div class="logo-section">
                     <div class="container">
                        <div class="row">
                           <div class="col-12 text-center">
                              <div class="w-100">
                                 <a class="home-logo home-page-logo" href="<?php echo e(url('/')); ?>">
                                    <!-- <img src="<?php echo e(asset('frontend/images/logo-color-2.png')); ?>" alt="Logo" class="img-fluid"> -->
                                    <div class="logo-bg-holder">
                                          <img src="<?php echo e(asset('frontend/images/logo.png')); ?>" alt="Logo" class="img-fluid">
                                    </div>
                                    <h2><span>CENTRAL</span> Jobs</h2>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>  
                  </div>  
                  <div class="company-signup-section">  
                     <div class="container pt-4"> 
                        <!-- <div class="row">
                           <div class="col">
                              <div
                              class="alert alert-danger text-center step-one-text-cls"
                              role="alert"
                              style="display:none;">
                                 <?php //if(isset($data[3]['text'])){ echo strip_tags($data[3]['text']);} ?>
                              </div>
                           </div>
                        </div> -->
                        <div class="row align-items-start justify-content-between mt-0 mt-lg-4">
                           <div class="col-lg-7">
                              <div class="signup_part_home">
                                 <div class="">
                                    <p><?php echo e(__('messages.GENTELMAN_RECRUITERS')); ?></p>
                                     <p><?php echo e(__('messages.THANK_YOU_VERY_MUCH_FOR_VISITING_OUR_SITE')); ?></p>
                                    <p><?php echo e(__('messages.WE_WANT_TO_WORK_WITH_YOU')); ?></p>
                                    <p><?php echo e(__('messages.SOME_ADVANTAGE_OF_OUR_PLATFORM')); ?></p>

                                    <p><strong>1 – <?php echo e(__('messages.COMPANY_REGISTRATION_STEP_1_HEADING')); ?></strong></p>
                                    <p><?php echo e(__('messages.COMPANY_REGISTRATION_STEP_1')); ?></p>


                                    <p><strong>2 – <?php echo e(__('messages.COMPANY_REGISTRATION_STEP_2_HEADING')); ?></strong></p>
                                    <p><?php echo e(__('messages.COMPANY_REGISTRATION_STEP_2')); ?></p>


                                    <p><strong>3 – <?php echo e(__('messages.COMPANY_REGISTRATION_STEP_3_HEADING')); ?></strong></p>
                                    <p><?php echo e(__('messages.COMPANY_REGISTRATION_STEP_3')); ?></p>
                                    <p><strong>4 – <?php echo e(__('messages.COMPANY_REGISTRATION_STEP_4_HEADING')); ?></strong></p>
                                    <p><?php echo e(__('messages.COMPANY_REGISTRATION_STEP_4')); ?></p>

                                    
                                    <p><strong>5 – <?php echo e(__('messages.COMPANY_REGISTRATION_STEP_5_HEADING')); ?></strong></p>
                                    <p><?php echo e(__('messages.COMPANY_REGISTRATION_STEP_5')); ?></p>

                                    <?php if(__('messages.COMPANY_REGISTRATION_STEP_6_HEADING') !=''): ?>
                                    <p><strong>6 – <?php echo e(__('messages.COMPANY_REGISTRATION_STEP_6_HEADING')); ?></strong></p>
                                    <p><?php echo e(__('messages.COMPANY_REGISTRATION_STEP_6')); ?></p>
                                    <?php endif; ?>
                                    


                                     <p><?php echo e(__('messages.WE_ARE_HERE_TO_HELP_YOU')); ?></p>
                                     <p><?php echo e(__('messages.WE_WISH_A_LOT_OF_SUCCESS')); ?></p>
                                    <p><?php echo e(__('messages.THANK_YOU_FOR_YOUR_PREFERENCE')); ?></p>
                                 </div>
                                 
                              </div>
                           </div>
                           <div class="col-lg-5 d-flex justify-content-center">
                              <div class="">
                                 <div class="login-sec login-sec-new">

                                    <ul class="sign-control step-one-cls">
                                       <li id="step-one-cls-hide" data-tab="tab-1" <?php if($typ == ''){?>class="current" <?php }?>><a href="#" title=""><?php echo e(__('messages.SIGN_IN_COMPANY')); ?></a></li>
                                       <span><li data-tab="tab-2" <?php if($typ != ''){?>class="current" <?php }?>><a href="#" title="" id=""><?php echo e(__('messages.SIGN_UP_COMPANY')); ?></a></li></span>
                                    </ul>

                                    
                                    <div class="sign_in_sec new_sign <?php if($typ == ''){?>current <?php }?>" id="tab-1">
                                       <!-- Tab panes -->
                                       <div class="mt-md-5">
                                          <!-- <h3>Sign in</h3> -->
                                          <form id="candidate_login"  method="POST" action="<?php echo e(url('login')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="row">
                                                   <div class="col-12">
                                                      <div class="sn-field">
                                                         <input type="text" id="email" type="email" class=" <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> " name="email" value="<?php echo e(old('email')); ?>"  autocomplete="email" autofocus placeholder="<?php echo e(__('messages.EMAIL')); ?>">
                                                         <?php if(($typ == '') && ($errors->has('email'))): ?>
                                                         <label id="email-error" class="error" for="Name"><?php echo e($errors->first('email')); ?></label>
                                                         <?php endif; ?>
                                                         <i class="la la-user"></i>                                                                                          
                                                      </div>
                                                   </div>
                                                   <div class="col-12">
                                                      <div class="sn-field  password-holder">
                                                         <input class=" <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" value="<?php echo e(old('password')); ?>" name="password" type="password" placeholder="<?php echo e(__('messages.PASSWORD')); ?>">
                                                         <?php if($errors->has('password')): ?>
                                                         <label id="email-error" class="error" for="Name"><?php echo e($errors->first('password')); ?></label>
                                                         <?php endif; ?>
                                                         <i class="la la-lock"></i>

                                                         <button class="eye_showHide" id="eye_showHide" type="button"> <i id ="eye-sh" class="fa fa-eye"></i>

                                                         </button>
                                                      </div>
                                                   </div>
                                                   <!-- <div class="col-6 col-sm-6">
                                                      <label class="check-style">Remember Me
                                                         <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                         <span class="checkmark"></span>
                                                      </label>
                                                   </div> -->
                                                   <div class="col-6 col-sm-6">
                                                      <p class="forgot-password"><a href="<?php echo e(route('password.request')); ?>"> <?php echo e(__('messages.FORGOT_PASSWORD')); ?>? </a> </p>
                                                   </div>
                                                      <?php if(session('status')): ?>
                                                      <div class="col-12 flash_message">
                                                         <div
                                                         class="alert alert-danger"
                                                         role="alert">
                                                            <?php echo e(session('status')); ?>

                                                         </div>
                                                      </div>
                                                   <?php endif; ?>
                                                   <div class="col-12 mt-4">
                                                      <button class="submit-btn" type="submit" value="submit"><?php echo e(__('messages.SIGN_IN_COMPANY')); ?></button>
                                                   </div>
                                                </div>
                                             </form>
                                          <!-- <div class="login-resources">
                                             <h4>Sign In with</h4>
                                             <ul>
                                                <li><a href="#" title="" class="fb"><i class="fa fa-facebook"></i>Facebook</a></li>
                                                <li><a href="#" title="" class="google"><i class="fa fa-google"></i>Google</a></li>
                                             </ul>
                                          </div> -->
                                          <!--login-resources end-->
                                       </div>
                                    </div>
                                    <!--sign_in_sec end-->
                                    <div class="sign_in_sec new_sign <?php if($typ != ''){?>current <?php }?>" id="tab-2">
                                       <ul class="signin-tab nav nav-tabs justify-content-start" id="myTab2" role="tablist">
                                          <!-- <li class="nav-item">
                                             <a class="nav-link px-0 <?php if($typ == 2 || $typ == ''){?> active  step-one-cls<?php }?>" id="tab-5-tab" data-toggle="tab" href="#tab-5" role="tab"  aria-selected="true"><i class="fa fa-user" aria-hidden="true"></i><?php echo e(__('messages.CANDIDATE')); ?></a>
                                          </li> -->
                                          <li class="nav-item">
                                             <a class="nav-link px-0 <?php if($typ == 3 || $typ == ''){?> active <?php }?> step-one-cls-hide" id="tab-6-tab" data-toggle="tab" href="#tab-6" role="tab" aria-selected="false"><i class="fa fa-user" aria-hidden="true"></i><?php echo e(__('messages.EMPLOYER')); ?></a>
                                          </li>
                                       </ul>
                                       <div class="tab-content">
                                          
                                          <!--dff-tab end-->
                                          <div class="tab-pane <?php if($typ == 3 || $typ == ''){?> active <?php }?>" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
                                             <div class="step_process">
                                             <ul>
                                                <li>
                                                <div class="step_process_outer">
                                                <h6 class="stp_hd"><?php echo e(__('messages.REGISTER')); ?></h6>
                                                <span class="number">1</span></div>
                                                </li>
                                                <li>
                                                <div class="step_process_outer">
                                                <h6 class="stp_hd"><?php echo e(__('messages.CONFIRM_YOUR_EMAIL')); ?></h6>
                                                <span class="number">2</span></div>
                                                </li>
                                                <li>
                                                <div class="step_process_outer">
                                                <h6 class="stp_hd"><?php echo e(__('messages.WE_WILL_APPROVE_YOUR_REGISTRATION')); ?></h6>
                                                <span class="number">3</span></div>
                                                </li>
                                                <li>
                                                <div class="step_process_outer">
                                                <h6 class="stp_hd"><?php echo e(__('messages.START_UPLOADING_YOUR_JOB_OFFERS')); ?></h6>
                                                <span class="number">4</span></div>
                                                </li>
                                             </ul>
                                             </div>
                                             <form id="company_sign_up" method="POST" action="<?php echo e(route('register')); ?>" aria-label="<?php echo e(__('Register')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="user_type" value="3">
                                                <div class="row">
                                                   
                                                   <div class="col-12">
                                                      <div class="sn-field">
                                                         <input value="<?php echo e(old('company_name')); ?>" class="<?php echo e($errors->has('company_name') ? ' is-invalid' : ''); ?>" type="text" name="company_name" placeholder="<?php echo e(__('messages.COMPANY_NAME')); ?> *">

                                                         <?php if($errors->has('company_name')): ?>
                                                         <label id="email-error" class="error" for="email"><?php echo e($errors->first('company_name')); ?></label>
                                                         <?php endif; ?>


                                                         <i class="la la-building"></i>
                                                      </div>
                                                   </div>
                                                   <div class="col-12">
                                                      <div class="sn-field">
                                                         <input type="text" value="<?php echo e(old('email_com')); ?>"  placeholder="<?php echo e(__('messages.COMPANY_EMAIL')); ?> *" name="email_com" class="<?php $__errorArgs = ['email_com'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                                                         <?php if(($typ == 3) && ($errors->has('email_com'))): ?>
                                                         <label id="email-error" class="error" for="email"><?php echo e($errors->first('email_com')); ?></label>
                                                         <?php endif; ?>
                                                         <i class="la la-envelope"></i>
                                                      </div>
                                                   </div>
                                                   <div class="col-12">
                                                      <div class="sn-field">
                                                         <input type="text" value="<?php echo e(old('cnpj')); ?>"  placeholder="<?php echo e(__('messages.CNPJ')); ?> *" name="cnpj" class="<?php $__errorArgs = ['cnpj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                                                         <?php if(($typ == 3) && ($errors->has('cnpj'))): ?>
                                                         <label id="email-error" class="error" for="email"><?php echo e($errors->first('cnpj')); ?></label>
                                                         <?php endif; ?>
                                                         <i class="la la-key"></i>
                                                      </div>
                                                   </div>
                                                   <div class="col-12">
                                                      <div class="sn-field  password-holder">
                                                      <input class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> chkPasswordEmpCls" value="<?php echo e(old('password')); ?>" type="password" id="password_org_c" name="password" placeholder="<?php echo e(__('messages.PASSWORD_COMPANY')); ?> *">

                                                         <?php if($errors->has('password')): ?>
                                                         <label id="email-error" class="error" for="password"><?php echo e($errors->first('password')); ?></label>
                                                         <?php endif; ?>
                                                         <i class="la la-lock"></i>
                                                         <button class="eye_showHide" type="button" id="eye-open-hide-3"> <i class="fa fa-eye" id ="eye-sh-3"></i></button>
                                                         <div class="password-info mt-1">
                                                            <?php echo e(__('messages.EMPLOYER_PASSWORD_SHOULD_BE')); ?>

                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-12">
                                                      <div class="reenter-passholder">
                                                         <div class="sn-field password-holder">
                                                         <input type="password" id="password_confirmation" name="password_confirmation" placeholder="<?php echo e(__('messages.RE_ENTER_PASSWORD')); ?> *" class="chkConPasswordEmpCls">
                                                            <i class="la la-lock"></i>
                                                            <button class="eye_showHide" type="button" id="eye-open-hide-4"> <i class="fa fa-eye" id ="eye-sh-4"></i></button>
                                                         </div>
                                                         
                                                         <span class="confirm-success d-none"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                      
                                                   </div>   
                                                   </div>
                                                   
                                                   <div class="col-12">
                                                      <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_TO_THE')); ?> <a href="<?php echo e(url('terms-use')); ?>" target="_blank" ><?php echo e(__('messages.TERMS_OF_USE')); ?></a> <?php echo e(__('messages.I_HAVE_READ_AND_AGREE_TO_THE_AFTER')); ?>.
                                                      <input id="terms_conditions_status" type="checkbox" name="terms_conditions_status">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-12">
                                                      <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE')); ?> <a href="<?php echo e(url('privacy-policy')); ?>" target="_blank" ><?php echo e(__('messages.PRIVACY_POLICY')); ?></a> <?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE_AFTER')); ?>.
                                                      <input id="privacy_policy_status" type="checkbox" name="privacy_policy_status">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div>
                                                   <!-- <div class="col-12">
                                                      <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE')); ?> <a href="<?php echo e(url('cookies-policy')); ?>" target="_blank" ><?php echo e(__('messages.COOKIES_POLICY')); ?></a> <?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE_AFTER')); ?>.
                                                      <input id="cookies_policy_status" type="checkbox" name="cookies_policy_status">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div> -->
                                                   <div class="col-12">
                                                      <label class="check-style"><?php echo e(__('messages.I_WISH_TO_RECEIVE_NEWSLETTER')); ?> 
                                                      <input id="is_newsletter_subscribed" type="checkbox" name="is_newsletter_subscribed">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-12 mt-4">
                                                      <button class="submit-btn confirm-submission signup-company" type="submit" value="submit"><?php echo e(__('messages.SIGN_UP_COMPANY')); ?> </button>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                          <!--dff-tab end-->
                                       </div>
                                    </div>
                                 </div>
                                 <div class="login-bottom-section text-right">
                                 <p> <?php  if(isset($data[5]['text'])){ echo $data[5]['text']; }?> </p>
                                 </div>
                              </div>
                           </div>
                           
                        </div>
                        <div class="row pb-4 align-items-center">
                           <div class="col-lg-6 d-lg-flex justify-content-center">
                               <div class="signupimg-holder">
                                    <!-- <img  src="<?php echo e(asset('frontend/images/merge_image.png')); ?>" alt="Logo" class="img-fluid"> -->
                                    <div class="img-holder signup-img1">
                                       <img  src="<?php echo e(asset('frontend/images/signup-page-1.png')); ?>" alt="signup-page" class="img-fluid">
                                    </div>  
                                    <div class="img-holder signup-img2"> 
                                       <img  src="<?php echo e(asset('frontend/images/signup-page-2.png')); ?>" alt="signup-page" class="img-fluid">
                                    </div>
                               </div>
                           </div> 
                           <div class="col-lg-6">   
                              <div class="home_foot_cntns text-right">
                                 <?php  if(isset($data[3]['text'])){ echo $data[3]['text']; }?>
                              </div>
                           </div>  
                        </div>    
                     </div>
                  </div> 
               </section>

               
            </main>
            <!-- main End -->
      
<?php $__env->stopSection(); ?>
<!-- End Custom Login View -->

<?php echo $__env->make('layouts.app_before_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/companySignup.blade.php ENDPATH**/ ?>