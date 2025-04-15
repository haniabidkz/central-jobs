<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo e(asset('frontend/js/job.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('frontend/js/BsMultiSelect.js')); ?>"></script>  



<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>

    <style>
      .note-dropdown-menu.dropdown-menu.note-check.dropdown-fontname.show{
         font-size:inherit !important;
      }

      .note-btn.btn.btn-light.btn-sm[title="Video"] {
         display: none !important;
      }

    </style>


<main>
<section class="section-myprofile-outer">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <form name="post_job" id="post_job" action="<?php echo e(url('company/post-job-post')); ?>" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="id" value = "<?php echo e($id); ?>">
               <div class="section-myprofile">
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4><?php echo e(__('messages.POST_JOB')); ?></h4>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <input type="text" class="form-control" placeholder="<?php echo e(__('messages.POSITION_NAME')); ?> *" name="title" id="title" autocomplete="off">
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="country_id" id="country_id" disabled>
                                 <option value=""> <?php echo e(__('messages.COUNTRY')); ?> *</option>
                                 <?php if($countries){
                                   foreach($countries as $key=>$val){
                                   ?>
                                 <option value="<?php echo e($val['id']); ?>" <?php if($val['id'] == $selectedCountry){ echo 'selected';} ?>><?php echo e($val['name']); ?></option>
                                 <?php } }?>
                              </select>
                           </div>
                        </div>
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group multiple-select multi-select-states-area required">
                              <select name="state_id[]" data-placeholder="<?php echo e(__('messages.STATE')); ?> *" id="state" class="form-control multi-select-states"  multiple="multiple" style="display: none;" autocomplete="off">
                              <?php if($states){
                                    foreach ($states as $key => $value) {
                                    ?>
                                   <option value="<?php echo e($value['id']); ?>"><?php echo e($value['name']); ?></option>
                                   <?php } } ?>
                              </select>
                              
                           </div>
                           <label class="error error-state" style="display:none;"></label>
                        </div> -->
                        <div class="col-12 col-sm-6 col-xl-4">
                           <!-- <div class="form-group multiple-select multi-select-city-area required">
                           <select name="city[]" data-placeholder="<?php echo e(__('messages.CITY')); ?>" id="city" class="form-control multi-select-city"  multiple="multiple" style="display: none;" autocomplete="off">
                                   
                              </select>
                                      
                              
                           </div> -->
                           <div class="form-group">
                              <select class="form-control" name="city" id="city">
                                    <option value=""> <?php echo e(__('messages.CITY')); ?></option>
                                    <?php if($cities){
                                    foreach($cities as $key=>$val){
                                    ?>
                                    <option value="<?php echo e($val['name']); ?>"><?php echo e($val['name']); ?></option>
                                    <?php } }?>
                              </select>
                                      
                  
                           </div>
                           <label class="error error-city" style="display:none;"></label>
                        </div>



                        <div class="col-12 col-sm-6 col-xl-4">
                           
                           <div class="form-group required">
                              <select class="form-control" name="type" id="type">
                                    <option value=""> <?php echo e(__('messages.TYPE')); ?> *</option>
                                    <option>Hybrid</option>
                                    <option>Onsite</option>
                                    <option>Remote</option>
                              </select>
                                      
                  
                           </div>
                           <label class="error error-city" style="display:none;"></label>
                        </div>

                        
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="seniority" id="    ">
                                 <option value=""><?php echo e(__('messages.SENIORITY_LEVEL')); ?> *</option>
                                 <?php if($seniority){
                                    foreach($seniority as $key=>$val){?>
                                       <option value="<?php echo e($val['name']); ?>"><?php echo e($val['name']); ?></option>
                                 <?php } }?>
                                 
                              </select>
                           </div>
                        </div> -->
                           <!-- If select Others -div should be display: block -->
                        <div class="col-12 col-sm-6 col-xl-4 seniority_other_open" style="display: none;">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="<?php echo e(__('messages.SPECIFY_OTHER')); ?>" name="seniority_other" id="seniority_other" autocomplete="off">
                           </div>
                        </div>
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="employment" id="employment">
                                 <option value=""><?php echo e(__('messages.EMPLOYMENT_TYPE')); ?> *</option>
                                 <?php if($employment){
                                    foreach($employment as $key=>$val){?>
                                       <option value="<?php echo e($val['id']); ?>"><?php echo e($val['name']); ?></option>
                                 <?php } }?>
                                 
                              </select>
                           </div>
                        </div> -->
                        <!-- If select Others -div should be display: block -->
                        <div class="col-12 col-sm-6 col-xl-4 employment_other_open" style="display: none;">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="<?php echo e(__('messages.SPECIFY_OTHER')); ?>" name="employment_other" id="employment_other" autocomplete="off">
                           </div>
                        </div>
                       
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Language Known">
                           </div>
                        </div> -->
                        
                        <!-- If select Others -div should be display: block -->
                        <!-- <div class="col-12 col-sm-6 col-xl-4 language_other_open" style="display: none;">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Specify Other Language" name="language_other" id="language_other">
                           </div>
                        </div> -->
                        
                        <!-- <div class="col-12">
                           <div class="form-group selected-skill-cls">
                              Selected Skill List
                              <textarea class="form-control" placeholder=""></textarea>
                           </div>
                        </div> -->

                        <!-- <div class="col-12">
                           <h4 class="qus-title"><?php echo e(__('messages.SCREENING_QUESTION')); ?> <span> (<?php echo e(__('messages.SCREENING_QUESTION_TEXT')); ?>) </span>
                           </h4>
                           <div class="interview-question-holder">
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="<?php echo e(__('messages.QUESTION')); ?> 1" name="screening_1"></textarea>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="<?php echo e(__('messages.QUESTION')); ?> 2" name="screening_2"></textarea>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="<?php echo e(__('messages.QUESTION')); ?> 3" name="screening_3"></textarea>
                              </div>                                                                   
                           </div>
                        </div>  -->
                        <!-- <div class="col-12">
                           <h4 class="qus-title"><?php echo e(__('messages.INTERVIEW_QUESTIONS')); ?> <span> (<?php echo e(__('messages.INTERVIEW_QUESTIONS_TEXT')); ?>) </span>
                              </h4>
                           <div class="interview-question-holder">
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="<?php echo e(__('messages.QUESTION')); ?> 1" name="interview_1" id="interview_1"></textarea>
                              </div>
                              
                              <label class="error error-interview" style="display:none;"></label>                                                                 
                           </div>
                        </div> -->
                                                      
                        <div class="col-12 col-sm-12 col-xl-12">
                           <h4 class="qus-title"><?php echo e(__('messages.JOB_DESCRIPTION')); ?> <span> (<?php echo e(__('messages.JOB_DESCRIPTION_TEXT')); ?>) </span></h4>

                           <div class="form-group required">
                              <!-- <textarea class="form-control" placeholder="<?php echo e(__('messages.JOB_DESCRIPTION')); ?> *" name="description" id="description"></textarea> -->
                              

                              <textarea id="description" name="description"></textarea>

                              <label class="error descErr" style="display:none;"></label>
                              <br>
                              <label for="gdpr-consent">
                                 <input type="checkbox" id="gdpr-consent" name="gdprConsent" required>
                                 I consent to the processing of my personal data in accordance with the 
                                 <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                               </label>
                           </div>
                           
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required"> Start Date:
                              <div class="select-dat">
                                 <input type="text" class="form-control" placeholder="<?php echo e(__('messages.TO_BE_PUBLISHED_ON')); ?> *" id="start_date" name="start_date" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required"> End Date:

                              <div class="select-dat">
                                    <input type="text" class="form-control" placeholder="<?php echo e(__('messages.LAST_DAY_OF_JOB_POST')); ?> *" id="end_date" name="end_date" autocomplete="off">
                              </div>
                           </div>   
                        </div>
                        
                        <!-- If select Company Portal -div should be display: block -->
                        <div class="col-12 col-sm-6 col-xl-4 company_portal" style="display: none;">
                           <div class="form-group required">
                              <input type="text" class="form-control" placeholder="<?php echo e(__('messages.WEBSITE_LINK')); ?>" name="website_link" id="website_link">
                           </div>
                        </div>
                        <div class="col-12 mt-3">
                           <div class="form-group">
                              <button class="site-btn btn submit-job-post" type="submit" ><?php echo e(__('messages.SUBMIT')); ?></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
</main>
<script>
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".multiple-select select.multi-select-city").bsMultiSelect();
          $(".js-example-tags").select2({tags: true,width:'100%'});
          var startDate = '<?php echo date('Y/m/d');?>';

          $(document).ready(function() {
            $( "#start_date" ).datepicker({
                  dateFormat: "yy-mm-dd",
                  minDate: new Date(startDate),
                  onSelect: function(selected) {
                  $("#end_date").datepicker("option","minDate", selected)
               }
            });
               
            $('#end_date').datepicker({
                  dateFormat: "yy-mm-dd",
                  minDate: 0,
                  onSelect: function(selected) {
                  $("#start_date").datepicker("option","maxDate", selected)
                  }
            });
            $( "#seniority" ).on( "change", function() {
               if($('#seniority').val() == 'other'){
                  $('.seniority_other_open').show();
               }else{
                  $('.seniority_other_open').hide();
               }
               
            });
            $( "#employment" ).on( "change", function() {
               if($('#employment').val() == 'other'){
                  $('.employment_other_open').show();
               }else{
                  $('.employment_other_open').hide();
               }
               
            });
            // $( ".selecte-skill-cls" ).on( "change", function() {
            //    //alert();
            //    var skill = $('.selecte-skill-cls').val();
            //    console.log(skill);
            //    // if($('#language').val() == 'other'){
            //    //    $('.language_other_open').show();
            //    // }else{
            //    //    $('.language_other_open').hide();
            //    // }
               
            // });
            $( "#applied_by" ).on( "change", function() {
               if($('#applied_by').val() == 2){
                  $('.company_portal').show();
               }else{
                  $('.company_portal').hide();
               }
               
            });
         });
      </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_after_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/frontend/company/jobPost.blade.php ENDPATH**/ ?>