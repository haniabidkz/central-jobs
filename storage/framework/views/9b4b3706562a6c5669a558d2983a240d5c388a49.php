<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('frontend/js/sweetalert.min.js')); ?>"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php 
$typ = old('user_type'); 
$seg = request()->segment(count(request()->segments())); 
if($seg == 'joinus')
{ 
   $typ = 3;
}
?>
<?php if((Session::get('regSuccessMsg') != '') && (Session::get('regSuccessMsg') != null)){
   $regSuccessMsg = Session::get('regSuccessMsg');
   $title = Session::get('title');
?>
<script>
var data = '<?php echo strip_tags($regSuccessMsg); ?>';
var title = '<?php echo strip_tags($title); ?>';
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
<script>
$(document).ready(function() {

$('ul.step-one-cls span li').click(function() {
   $('.step-one-text-cls').show(); 
});
$('ul.step-one-cls li#step-one-cls-hide').click(function() {
   $('.step-one-text-cls').hide(); 
});
});
$(document).on('click','.step-one-cls',function(){
   $('.step-one-text-cls').show(); 
});
$(document).on('click','.step-one-cls-hide',function(){
   $('.step-one-text-cls').hide(); 
});
</script>

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
                  <div class="section-home-container">
                     <div class="container">  
                        <div class="row justify-content-between ">
                           <div class="col-lg-6 home-leftpanel d-flex justify-content-center">
                              <div class="login-sec login-sec-new">
                                 <ul class="sign-control step-one-cls">
                                    <li id="step-one-cls-hide" data-tab="tab-1" <?php if($typ == ''): ?> class="current" <?php endif; ?>><a href="#" title=""><?php echo e(__('messages.SIGN_IN')); ?></a></li>
                                    <span><li data-tab="tab-2" <?php if($typ != ''): ?> class="current" <?php endif; ?>><a href="#" title="" id=""><?php echo e(__('messages.SIGN_UP')); ?></a></li></span>
                                 </ul>
                                 <div class="sign_in_sec new_sign <?php if($typ == ''): ?> current <?php endif; ?>" id="tab-1">
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
                                                   <button class="submit-btn" type="submit" value="submit"><?php echo e(__('messages.SIGN_IN')); ?></button>
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
                                 <div class="sign_in_sec new_sign <?php if($typ != ''): ?> current <?php endif; ?>" id="tab-2">
                                    <ul class="signin-tab nav nav-tabs justify-content-start" id="myTab2" role="tablist">
                                       <li class="nav-item">
                                          <a class="nav-link px-0 <?php if($typ == 2 || $typ == ''): ?> active  step-one-cls <?php endif; ?>" id="tab-5-tab" data-toggle="tab" href="#tab-5" role="tab"  aria-selected="true"><i class="fa fa-user" aria-hidden="true"></i><?php echo e(__('messages.CANDIDATE')); ?></a>
                                       </li>
                                       <!-- <li class="nav-item">
                                          <a class="nav-link px-0 <?php if($typ == 3): ?> active <?php endif; ?> step-one-cls-hide" id="tab-6-tab" data-toggle="tab" href="#tab-6" role="tab" aria-selected="false"><i class="fa fa-user" aria-hidden="true"></i><?php echo e(__('messages.EMPLOYER')); ?></a>
                                       </li> -->
                                    </ul>
                                    <div class="tab-content">
                                       <div class="dff-tab tab-pane <?php if($typ == 2 || $typ == ''): ?> active <?php endif; ?>" id="tab-5" role="tabpanel" aria-labelledby="tab-5-tab">
                                          <div class="step_process">
                                          <?php if(isset($data[0]['text'])): ?><?php echo $data[0]['text']; ?> <?php endif; ?>
                                          </div>
                                          <form id="candidate_sign_up" method="POST" action="<?php echo e(route('register')); ?>" aria-label="<?php echo e(__('Register')); ?>">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="user_type" value="2">
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input value="<?php echo e(old('first_name')); ?>" class="<?php echo e($errors->has('first_name') ? ' is-invalid' : ''); ?>" id="first_name" type="text" name="first_name" placeholder="<?php echo e(__('messages.NAME')); ?> *" >
                                                      <?php if($errors->has('first_name')): ?>
                                                      <label id="email-error" class="error" for="Name"><?php echo e($errors->first('first_name')); ?></label>
                                                      <?php endif; ?>
                                                      <i class="la la-user"></i>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input type="email" value="<?php echo e(old('email')); ?>" name="email" placeholder="<?php echo e(__('messages.EMAIL')); ?> *" class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                      <?php if(($typ == 2) && ($errors->has('email'))): ?>
                                                      <label id="email-error" class="error" for="email"><?php echo e($errors->first('email')); ?></label>
                                                      <?php endif; ?>
                                                      <i class="la la-envelope <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"></i>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="sn-field password-holder mb-3">
                                                      <input class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> chkPasswordCls" value="<?php echo e(old('password')); ?>" type="password"  name="password" id="password_org" placeholder="<?php echo e(__('messages.PASSWORD')); ?> *">
                                                      <?php if($errors->has('password')): ?>
                                                      <label id="email-error" class="error" for="password"><?php echo e($errors->first('password')); ?></label>
                                                      <?php endif; ?>
                                                      <i class="la la-lock"></i>
                                                      <button class="eye_showHide" type="button" id="eye-open-hide-1"> 
                                                         <i id ="eye-sh-1" class="fa fa-eye"></i>
                                                         <!-- <img src="<?php echo e(asset('frontend/images/ic-show-password.png')); ?>" alt=""> 
                                                         <img src="<?php echo e(asset('frontend/images/ic-show-password-cross.png')); ?>" alt="">  -->
                                                      </button>
                                                      <div class="password-info mt-1">
                                                      <?php echo e(__('messages.CANDIDATE_PASSWORD_SHOULD_BE')); ?>

                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="reenter-passholder"> 
                                                      <div class="sn-field password-holder">
                                                         <input type="password" id="password_confirmation" name="password_confirmation" placeholder="<?php echo e(__('messages.RE_ENTER_PASSWORD')); ?> *">
                                                         <i class="la la-lock"></i>
                                                         <button class="eye_showHide" type="button" id="eye-open-hide-2"> 
                                                            <i id ="eye-sh-2" class="fa fa-eye"></i>
                                                            <!-- <img src="<?php echo e(asset('frontend/images/ic-show-password.png')); ?>" alt=""> 
                                                            <img src="<?php echo e(asset('frontend/images/ic-show-password-cross.png')); ?>" alt="">  -->
                                                         </button>
                                                      </div>
                                                      <span class="confirm-success d-none"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_TO_THE')); ?> <a href="<?php echo e(url('terms-use')); ?>" target="_blank" ><?php echo e(__('messages.TERMS_OF_USE')); ?></a>.
                                                   <input id="terms_conditions_status" type="checkbox" name="terms_conditions_status">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE')); ?> <a href="<?php echo e(url('privacy-policy')); ?>" target="_blank" ><?php echo e(__('messages.PRIVACY_POLICY')); ?></a>.
                                                   <input id="privacy_policy_status" type="checkbox" name="privacy_policy_status">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div>
                                                 <!-- <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE')); ?> <a href="<?php echo e(url('cookies-policy')); ?>" target="_blank" ><?php echo e(__('messages.COOKIES_POLICY')); ?></a>.
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
                                                <!-- <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.SIGN_UP_AGREE')); ?> MeuRH <a href="<?php echo e(url('terms-use')); ?>" target="_blank" ><?php echo e(__('messages.TERM_CONDITIONS')); ?></a>.
                                                   <input id="terms_conditions_status" type="checkbox" name="terms_conditions_status">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div> -->
                                                <div class="col-12 mt-4">
                                                   <button type="submit" class="submit-btn signup-candidate confirm-submission-candidate" value="submit"><?php echo e(__('messages.SIGN_UP')); ?> </button>
                                                </div>
                                             </div>
                                          </form>
                                          <div class="login-resources">
                                             <h4>Sign In with</h4>
                                             <ul>
                                                <li><a href="#" title="" class="fb"><i class="fa fa-facebook"></i>Facebook</a></li>
                                                <li><a href="#" title="" class="google"><i class="fa fa-google"></i>Google</a></li>
                                             </ul>
                                          </div>
                                       </div>
                                       <!--dff-tab end-->
                                       <div class="tab-pane <?php if($typ == 3): ?> active <?php endif; ?>" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
                                          <form id="company_sign_up" method="POST" action="<?php echo e(route('register')); ?>" aria-label="<?php echo e(__('Register')); ?>">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="user_type" value="3">
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input value="<?php echo e(old('first_name')); ?>" class="<?php echo e($errors->has('first_name') ? ' is-invalid' : ''); ?>" id="first_name" name="first_name" placeholder="<?php echo e(__('messages.CONTACT_NAME')); ?> *">
                                                      <?php if($errors->has('first_name')): ?>
                                                      <label id="email-error" class="error" for="Contact name"><?php echo e($errors->first('first_name')); ?></label>
                                                      <?php endif; ?>
                                                      <i class="la la-user"></i>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input value="<?php echo e(old('telephone')); ?>" class="<?php echo e($errors->has('telephone') ? ' is-invalid' : ''); ?>"  type="text" id="telephone" name="telephone" placeholder="<?php echo e(__('messages.CONTACT_NO')); ?>">
                                                      <?php if($errors->has('telephone')): ?>
                                                      <label id="email-error" class="error" for="email"><?php echo e($errors->first('telephone')); ?></label>
                                                      <?php endif; ?>
                                                      <i class="la la-phone"></i>
                                                   </div>
                                                </div>
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
unset($__errorArgs, $__bag); ?> chkPasswordEmpCls" value="<?php echo e(old('password')); ?>" type="password" id="password_org_c" name="password" placeholder="<?php echo e(__('messages.PASSWORD')); ?> *">
                                                      <?php if($errors->has('password')): ?>
                                                      <label id="email-error" class="error" for="password"><?php echo e($errors->first('password')); ?></label>
                                                      <?php endif; ?>
                                                      <i class="la la-lock"></i>
                                                      <button class="eye_showHide" type="button" id="eye-open-hide-3"> <i class="fa fa-eye" id ="eye-sh-3"></i></button>
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
                                                   <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_TO_THE')); ?> <a href="<?php echo e(url('terms-use')); ?>" target="_blank" ><?php echo e(__('messages.TERMS_OF_USE')); ?></a>.
                                                   <input id="terms_conditions_status" type="checkbox" name="terms_conditions_status">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE')); ?> <a href="<?php echo e(url('privacy-policy')); ?>" target="_blank" ><?php echo e(__('messages.PRIVACY_POLICY')); ?></a>.
                                                   <input id="privacy_policy_status" type="checkbox" name="privacy_policy_status">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.I_HAVE_READ_AND_AGREE_WITH_THE')); ?> <a href="<?php echo e(url('cookies-policy')); ?>" target="_blank" ><?php echo e(__('messages.COOKIES_POLICY')); ?></a>.
                                                   <input id="cookies_policy_status" type="checkbox" name="cookies_policy_status">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="check-style"><?php echo e(__('messages.I_WISH_TO_RECEIVE_NEWSLETTER')); ?> 
                                                   <input id="is_newsletter_subscribed" type="checkbox" name="is_newsletter_subscribed">
                                                   <span class="checkmark"></span>
                                                   </label>
                                                </div>
                                                <div class="col-12 mt-4">
                                                   <button class="submit-btn confirm-submission signup-company" type="button" value="submit"><?php echo e(__('messages.SIGN_UP')); ?> </button>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <!--dff-tab end-->
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 video_part_home d-flex  justify-content-center align-items-center">
                              <div class="laptop-video-div">
                                  <h4 class="laptop-top-text text-center"><?php echo e(__('messages.JOBS_CAREERS')); ?></h4>
                               
                                       </div>
                                    </div> --}}
                               </div>    
                           </div>
                        </div>
                     </div>
                     <div class="bg-black-home"></div>
                  </div>
                  <div class="container">  
                     <div class="home_foot_cntns text-right">
                        <?php if(isset($data[3]['text'])): ?><?php echo $data[3]['text']; ?> <?php endif; ?>
                     </div>
                  </div>      
               </section>
            </main>
            <!-- main End -->
      
<?php $__env->stopSection(); ?>
<!-- End Custom Login View -->

<?php echo $__env->make('layouts.app_before_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/login.blade.php ENDPATH**/ ?>