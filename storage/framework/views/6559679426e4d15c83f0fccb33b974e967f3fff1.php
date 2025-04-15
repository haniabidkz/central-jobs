<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('frontend/js/sweetalert.min.js')); ?>"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php echo e(asset('frontend/css/select2.min.css')); ?>">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo e(asset('frontend/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/BsMultiSelect.js')); ?>"></script>

<?php
$typ = old('user_type');
$seg = request()->segment(count(request()->segments()));
if ($seg == 'joinus') {
   $typ = 3;
} ?>
<?php
$regSuccessImage = '';
if (((Session::get('regSuccessMsg') != '') && (Session::get('regSuccessMsg') != null)) || ((Session::get('status') != '') && (Session::get('status') != null)) || ((Session::get('statusRegistration') != '') && (Session::get('statusRegistration') != null))) {
   if ((Session::get('regSuccessMsg') != '') && (Session::get('regSuccessMsg') != null)) {
      $regSuccessMsg = Session::get('regSuccessMsg');
      $title = Session::get('title');
   }

   if ((Session::get('status') != '') && (Session::get('status') != null)) {
      $regSuccessMsg = Session::get('status');
      $title = 'Registration';
   }

   if ((Session::get('statusRegistration') != '') && (Session::get('statusRegistration') != null)) {
      $regSuccessMsg = Session::get('statusRegistration')['message'];
      $regSuccessImage = Session::get('statusRegistration')['image'];
      $title = 'Registration';
   }

   ?>
   <script>
      <?php if ($regSuccessImage != "") { ?>
         var data = '<?php echo $regSuccessMsg; ?>';
         var replacableText = '';
         if(data.includes('check his SPAM folder'))
         replacableText = 'check his SPAM folder';
         else 
         replacableText = '(überprüfen Sie bitte auch Ihren SPAM-Ordner)';
         var data1 = data.replace(replacableText, "<b style='display:inline-block;color:#000'>"+replacableText+"</b>");
         var title = '<?php echo strip_tags($title); ?>';
         var image = '<?php echo $regSuccessImage; ?>';

         var content = document.createElement('div');
         content.innerHTML = data1;
         content.innerHTML += '<br><img src=' + image + ' />';

         swal({
            title: title,
            icon: "success",
            content: content,
            className: "swal-email-notification"
         });
      <?php } else { ?>
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
      <?php } ?>
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
   $(document).on('click', '.step-one-cls', function() {
      $('.step-one-text-cls').show();
   });
   $(document).on('click', '.step-one-cls-hide', function() {
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
               <div class="text-center col-12">
                  <div class="w-100">
                     <a class="home-logo home-page-logo" href="<?php echo e(url('/')); ?>">
                        <!-- <img src="<?php echo e(asset('frontend/images/logo-color-2.png')); ?>" alt="Logo" class="img-fluid"> -->
                        <!-- <div class="logo-bg-holder">
                                       <img src="<?php echo e(asset('frontend/images/logo-white.png')); ?>" alt="Logo" class="img-fluid">
                                    </div> -->
                        <div class="logo-bg-holder">
                           <img src="<?php echo e(asset('frontend/images/logo.png')); ?>" alt="Logo" class="img-fluid">
                        </div>
                        <h2><span>CENTRAL</span> Jobs</h2>

                     </a>

                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <div class="text-center alert alert-danger step-one-text-cls" role="alert" style="display:none;">
                     <?php if (isset($data[1]['text'])) {
                        echo strip_tags($data[1]['text']);
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="section-home-container home-new-container">
         <div class="container">
            <div class="row justify-content-between ">
               <div class="p-0 col-lg-12 home-leftpanel d-flex justify-content-start">
                  <form class="w-100" method="get" action="<?php echo e(url('candidate/my-jobs')); ?>">
                     <input type="hidden" name="company" value="1">
                     <div class="login-sec login-sec-new form-home">
                        <div class="row">
                           <div class="col-12 col-md-3">
                              <!-- <input type="text" class="form-control" placeholder="Reference"> -->
                              <input type="text" class="form-control" placeholder="<?php echo e(__('messages.REFERENCE')); ?>" name="job_id" id="job_id" value="<?php echo e(@$search['job_id']); ?>">
                           </div>
                           <div class="col-12 col-md-3">
                              <?php if(isset($search['position_name']) && $search['position_name'] != ''){
                              foreach($search['position_name'] as $key=>$value){
                              if(!in_array($value,$position)){
                              array_push($position,$value);
                              }
                              }

                              }
                              ?>
                              <input type="text" class="form-control" name="position_name[]" placeholder="Keyword">
                              <!-- <div class="input-search">
                                 <div class="form-group required">
                                    <select name="position_name[]" id="position_name" data-placeholder="<?php echo e(__('messages.KEYWORD')); ?>" id="itskills" class="form-control js-example-tags" multiple="multiple" style="display: none;">
                                       <?php if($position): ?>
                                       <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($val); ?>" <?php if((isset($search['position_name'])) && in_array($val,$search['position_name'], TRUE)): ?>selected <?php endif; ?>><?php echo e($val); ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>
                                    </select>
                                 </div>
                              </div> -->
                           </div>
                           <div class="col-12 col-md-3">
                              <!-- <input type="text" class="form-control" placeholder="Austria"> -->
                              <!-- <div class="input-search">
                                             <div class="form-group  multi-select-states-area">
                                                <select name="state"  id="state" data-placeholder="<?php echo e(__('messages.STATE')); ?>"  class="form-control">
                                                   <option value=""><?php echo e(__('messages.STATE')); ?> </option>
                                                   <?php if($states): ?>
                                                   <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <?php if($value['name'] == 'Austria'): ?>
                                                   <option value="<?php echo e($value['id']); ?>" <?php if($value['id'] == @$search['state']): ?>selected <?php endif; ?>><?php echo e($value['name']); ?></option>
                                                   <?php endif; ?>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   <?php endif; ?>
                                                </select>   
                                             </div>
                                          </div> -->
                              <div class="input-search">
                                 <div class="form-group  multi-select-states-area">
                                    <select name="country" id="country" data-placeholder="<?php echo e(__('messages.COUNTRY')); ?>" class="form-control">
                                       <option value="14">Austria</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-md-3">
                              <!-- <input type="text" class="form-control" placeholder="City"> -->
                              <div class="input-search">
                                 <div class="form-group">

                                    <select name="cityy_comp" id="cityy_comp" class="form-control select-city-area city-dropdown">
                                       <option value=""><?php echo e(__('messages.CITY')); ?> </option>
                                       <option value="7156">Wien - Vienna</option>
                                       <?php if ($cities) {
                                          foreach ($cities as $key => $city) {
                                             if ($city->id == 7157 || $city->id == 7156) {
                                                continue;
                                             }
                                             ?>
                                             <?php echo e($city->id); ?>

                                             <option value="<?php echo e($city->id); ?>" <?php if ($city->id == @$search['cityy_comp']) {
                                                                                    echo 'selected';
                                                                                 } ?>><?php echo e($city->name); ?></option>
                                       <?php  }
                                       } ?>
                                    </select>

                                    
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mt-4 row">
                        <div class="col-12 d-flex justify-content-end">
                           <button type="submit" class="login-btn"><?php echo e(__('messages.SEARCH')); ?></button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>

         </div>
         <div class="bg-black-home"></div>
      </div>
      <div class="bottom-part">
         <div class="container">
            <div class="row">
               <div class="col-12 col-lg-5 video_part_home video-home-new d-flex justify-content-start align-items-center">
                  <div class="laptop-video-div">
                     <div class="text-center login-max-width img-with-laptop-holder">
                        <img src="<?php echo e(asset('frontend/images/laptop-bgimg.png')); ?>">
                        <div class="img-with-laptop">
                           <img src="<?php echo e(asset('frontend/images/laptop_picture_original.jpg')); ?>">
                           <div class="laptop-text">
                              <h2>Jobs &amp;<br> Karriere</h2>
                           </div>
                           
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 col-lg-7 best-text">
                  
                  <h4><?php echo e(__('messages.THE_BEST_COMPANIES_ADVERTISE_HERE')); ?></h4>
                  <h2><?php echo e(__('messages.YOUR_NEW_JOB_IS_HERE')); ?></h2>
               </div>
            </div>
            <div class="p-5 bg-white b-radius row justified-content-center">
               <?php $__currentLoopData = $best_advertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="text-center col-12 col-md-3">
                  <label><?php echo e($add['initial_text']); ?></label>
                  <h2><?php echo e($add['position']); ?></h2>
                  <p><?php echo e($add['requirment']); ?></p>
                  <span><?php echo e($add['ref_no']); ?></span>
               </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <!-- <div class="text-center col-12 col-md-3">
                              <label>Logistics company is looking for:</label>
                              <h2>Engineer</h2>
                              <p>3 years experience</p>
                              <span>Ref: 66474984</span>
                           </div>
                           <div class="text-center col-12 col-md-3">
                              <label>Logistics company is looking for:</label>
                              <h2>Manager</h2>
                              <p>3 years experience</p>
                              <span>Ref: 66474984</span>
                           </div>
                           <div class="text-center col-12 col-md-3">
                              <label>Logistics company is looking for:</label>
                              <h2>Analyst</h2>
                              <p>3 years experience</p>
                              <span>Ref: 66474984</span>
                           </div> -->
            </div>
            <div class="text-right home_foot_cntns">
               <?php if (isset($data[3]['text'])) {
                  echo $data[3]['text'];
               } ?>
            </div>
         </div>
      </div>
   </section>
</main>
<!-- main End -->
<script>
   $(".js-example-tags").select2({
      tags: true,
      width: '100%'
   });
</script>
<?php $__env->stopSection(); ?>
<!-- End Custom Login View -->
<?php echo $__env->make('layouts.app_before_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/home.blade.php ENDPATH**/ ?>