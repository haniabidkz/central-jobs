<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="<?php echo e(asset('frontend/js/sweetalert.min.js')); ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<input name="user_type" id="user_type" type="hidden" value="<?php echo e($user_type_id); ?>"/>
<script src="<?php echo e(asset('frontend/js/dashboard.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/job.js')); ?>"></script>
<?php 
if($postData['user']['user_type'] == 2){ 
   $postedUser = 'candidate';
}else if($postData['user']['user_type'] == 3){
   $postedUser = 'company';
}else{
   $postedUser = '';
}

$addClassLike = '';
if(!empty($postData['likes'])){
   foreach($postData['likes'] as $key=>$val){
      if((Auth::user()) && ($val['user_id'] == Auth::user()->id)){
         $addClassLike = 'addlike';
      }
   }
}
?>

<main>
               <section class="section section-myjob company-page">
                  <div class="container">
                     <div class="row">
                        <div class="col-12 col-lg-10 mt-4 mt-lg-0 mx-auto">
                           <!-- <div class="details-panel-header"> <h4>Job Details</h4> </div> -->
                           <div class="post-block">
                              <div class="job-list-holder company-list-holder px-0 whitebg mb-2">
                                 <div class="media"> 
                                    <div class="company-list-img">
                                       <div class="profile-img "> <a href="<?php echo e(url($postedUser.'/profile/'.$postData['user']['slug'])); ?>"> 
                                             <?php if($postData['user']['profileImage'] != null){?>
                                                <img src="<?php echo e(asset($postData['user']['profileImage']['location'])); ?>" alt="">
                                             <?php }else{ ?>
                                                <img src="<?php echo e(asset('frontend/images/user-pro-img-demo.png')); ?>" alt="">
                                             <?php }?>
                                             </a> 
                                       </div>
                                    </div>
                                    <div class="media-body media_body_id ml-4" id="media_body_id_<?php echo e($postData['id']); ?>">     
                                       <h3 class="total-title"><?php echo e($postData['title']); ?> </h3> 
                                       <p><i class="fa fa-building-o mr-2" aria-hidden="true"></i><a href="<?php echo e(url($postedUser.'/profile/'.$postData['user']['slug'])); ?>"><?php echo e($postData['user']['company_name']); ?></a></p>
                                       <p><i class="fa fa-calendar mr-2" aria-hidden="true"></i>Publish Date: <?php echo e(date('d-m-Y',strtotime($postData['start_date']))); ?></p>
                                       <p><i class="fa fa-map-marker mr-2" aria-hidden="true"></i><?php echo e($postData['city']); ?> <?php if(!empty($postData['postState'])){ foreach($postData['postState'] as $key=>$state){ if($key > 0){ echo ' , ';} echo $state['state']['name'];}}?><?php echo e(!empty($postData['country']['name']) ? ' , '.$postData['country']['name'] : ''); ?> </p>
                                       <p><i class="fa fa-clock-o mr-2" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($postData['start_date']) <= $toDay) && (strtotime($postData['end_date']) >= $toDay)){ echo  __('messages.ONGOING');}else if(strtotime($postData['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($postData['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?></p>

                                       <p><i class="fa fa-clock-o mr-2" aria-hidden="true"></i><?php echo e($postData['type'] ?? '-'); ?></p>
                                       
                                    </div>
                                    
                                    <?php $toDay = strtotime(date('Y-m-d')); if((strtotime($postData['start_date']) <= $toDay) && (strtotime($postData['end_date']) >= $toDay)){ if((Auth::user()) && (Auth::user()->user_type == 2)){ ?>
                                    <?php if($postData['applied_by'] == 1){ 
                                       if(($postData['isApplied'] == null) || ($postData['isApplied']['applied_status'] == 0) || ($postData['isApplied']['applied_status'] == 1)){
                                       ?>
                                    
                                   
                                       <!-- <form id="step_one" action="" method="post" enctype="multipart/form-data">
                                          <?php echo e(csrf_field()); ?>

                                          <input name="job_id" id="job_id" value="<?php echo e($postData['id']); ?>" type="hidden"/>
                                          <input type="hidden" name="country" value="30"/>
                                          <input type="hidden" class="form-control" name="city" id="city" value="<?php echo e($postData['city']); ?>"/>  
                                       <a class="btn site-btn-color apply-cls" href="javascript:void(0);" > <?php echo e(__('messages.APPLY_VIA_MYHR')); ?> </a> 
                                       </form> -->
                                    
                                       <?php  }elseif(($postData['isApplied'] != null) && ($postData['isApplied']['applied_status'] == 2)){?>
                                       
                                    <?php } }else if($postData['applied_by'] == 2){?>
                                    <!-- Apply via Company - Outside MyHR Portal -->
                                     
                                    <?php }?>
                                    <?php if($postData['applied_by'] == 2){ ?>
                                    <?php if($postData['isApplied'] == null){?>
                                     <!-- <a class="btn site-btn-color saveJobCls" href="javascript:void(0);" id="save-job-<?php echo e($postData['id']); ?>" data-id="<?php echo e($postData['id']); ?>" data-type="1"> <?php echo e(__('messages.SAVE_JOB')); ?> </a>   -->
                                    <?php }else if(($postData['isApplied'] != null) && ($postData['isApplied']['applied_status'] == 0 || ((isset($job) && $job['isApplied']['applied_status'] == 1)))){?>
                                       <!-- <a class="btn site-btn-color saveJobCls" href="javascript:void(0);" id="save-job-<?php echo e($postData['id']); ?>" data-id="<?php echo e($postData['id']); ?>" data-type="0"> <?php echo e(__('messages.SAVED')); ?> </a>  -->
                                    <?php }?>
                                    <?php }?>
                                    <?php }else if(!Auth::user()){?>
                                       <?php if($postData['applied_by'] == 1){ 
                                       if(($postData['isApplied'] == null) || ($postData['isApplied']['applied_status'] == 0) || ($postData['isApplied']['applied_status'] == 1)){
                                       ?>
                                    
                                   
                                       <?php  }elseif(($postData['isApplied'] != null) && ($postData['isApplied']['applied_status'] == 2)){?>
                                       <a class="btn site-btn-color" href="javascript:void(0);" > <?php echo e(__('messages.APPLIED')); ?> </a> 
                                    <?php } }else if($postData['applied_by'] == 2){?>
                                    <!-- Apply via Company - Outside MyHR Portal -->
                                     
                                    <?php }?>
                                    <?php } }?>
                                 </div>
                              </div> 
                              
                              
                           </div>



                           <div class="job-list-holder whitebg">  
                              <div class="row">
                                 <div class="col-12">
                                  <h3 class="total-title mb-3"><?php echo e(__('messages.JOB_DESCRIPTION')); ?> </h3>
                                  <p> <?php echo $postData['description']; ?></p>
                                 </div>  
                                 <div class="col-12 mt-3">
                                    <ul class="job-dt">
                                       <li><span><?php if($postData['cmsBasicInfo']){ foreach($postData['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo $val['masterInfo']['name'];} }}?></span></li>
                                       <li><span class="btn" style="cursor:default;"><?php if($postData['cmsBasicInfo']){ foreach($postData['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo $val['masterInfo']['name'];} }}?></span></li>
                                       
                                    </ul>
                                    <!-- If select Others -div should be display: block -->
                                    <ul class="job-dt flex-wrap" style="display: none;" >
                                       <li class="w-100 mb-2"><span>Others</span> <span class="ml-3">freelancer</span></li>
                                       <li class="w-100"><span class="btn">Others</span> <span class="ml-3">Hourly</span></li> 
                                    </ul>
                                    
                                 </div>
                                 <div class="col-12 col-md-6">
                                    <ul class="job-dt">
                                       <li><span><?php if($postData['cmsBasicInfo']){ $i = 0; foreach($postData['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'language'){ $i++; if($i > 1){ echo ' , '; } echo $val['masterInfo']['name'];} }}?>  </span></li>
                                    </ul>
                                 </div> 
                                 <div class="col-12">
                                    <ul class="skill-tags">
                                    <?php if($postData['selectedSkill']){ foreach($postData['selectedSkill'] as $key=>$val){?>
                                    <li><span><?php echo e($val['skill']['name']); ?></span></li>
                                    <?php } }?>   
                                    </ul>
                                 </div> 
                                 <?php if((Auth::user()) && (Auth::user()->user_type == 3)){?>
                                 <!-- Specific Question : Should not be displayed in case user type is Candidate -->
                               
                                 <!-- Should not be displayed in case user type is Candidate -->
                                                                    <?php }?>
                                 <div class="col-12">
                                    <ul class="job-dt mb-2">
                                       <li><p class="mr-2"><?php echo e(__('messages.START_DATE')); ?>: </p><span><?php echo e(date('d-m-Y',strtotime($postData['start_date']))); ?> </span></li> 
                                       <li> - </li>
                                       <li><p class="mr-2"><?php echo e(__('messages.END_DATE')); ?>: </p> <span><?php echo e(date('d-m-Y',strtotime($postData['end_date']))); ?> </span></li>
                                    </ul>
                                 </div>
                               <!--  <div class="col-12">
                                    <ul class="job-dt mb-0 flex-wrap">
                                       <li class="w-100 mb-2"><p class="mr-2"><?php echo e(__('messages.APPLY_THROUGH')); ?>: </p> <span><?php if($postData['applied_by'] == 1){ echo __('messages.MYHR');}else{ echo __('messages.COMPANY_PORTAL') ;}?> </span></li> 
                                       <?php if($postData['applied_by'] == 2){?>
                                       <li class="w-100"><p class="mr-2"><?php echo e(__('messages.WEBSITE_LINK')); ?>: </p><span> <a href="<?php echo e($postData['website_link']); ?>" target="_blank"><?php echo e($postData['website_link']); ?></a>  </span></li>
                                       <?php }?>
                                    </ul>
                                 </div>    -->                                                      
                              </div>   
                           </div>
                        </div>   
                     </div>
                  </div>
               </section>
            </main>
            <!-- Report Modal -->
 <div class="modal custom-modal profile-modal report-modal" id="report-modal-open">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
               <?php if((Auth::user()) && (Auth::user()->user_type == 2)){?>
               <form id="report" action="<?php echo e(url('/candidate/report-comment')); ?>" method="post" >
               <?php }else if((Auth::user()) && (Auth::user()->user_type == 3)){?>
                  <form id="report" action="<?php echo e(url('/company/report-comment')); ?>" method="post" >
               <?php }?>
                     <?php echo e(csrf_field()); ?>

                     <input type="hidden" name="comment_id" id="comment_id" value=""/>
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left"><?php echo e(__('messages.REPORT')); ?></h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label><?php echo e(__('messages.WHY_ARE_YOU_REPORTING')); ?></label>
                              <textarea class="form-control" name="comment" id="comment"></textarea>
                           </div>
                        </div>
                        <div class="col-12 ext-left">
                           <button class="btn site-btn-color report-submit-btn post-comment-report-cls" type="submit"><?php echo e(__('messages.SUBMIT')); ?></button>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Report Modal -->
      <!-- Comment Post Modal -->
      <div class="modal custom-modal profile-modal  text-left " id="comment-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <div class="row">
                        <!-- <div class="col-sm-12 details-panel-header">
                           <h4 class="text-center">Comment</h4>
                        </div> -->
                        <div class="col-12">
                           <!-- write-comment-box -->
                           <div class="write-comment-box-holder function-write-comment-box">
                              <div class="mCustomScrollbar max-height" id="no-data">
                                 <div class="comment-list" id="commentListApp">
                                                                                             
                                 </div>
                              </div> 
                              <div class="comment-list comment-list-not-found" style="display:none;">
                                                                                             
                                 </div>  
                              <div class="message-send-area">
                                 <form id="post_comment" action="<?php echo e(url('/candidate/post-comment')); ?>" method="post" >
                                 <?php echo e(csrf_field()); ?>

                                 <input type="hidden" name="post_id" id="post_id" value="<?php echo e($postData['id']); ?>"/>
                                    <div class="message-send-form-holder media">
                                       <div class="message-send-input-box media-body">
                                          <input type="text" class="form-control" name="comment" placeholder="<?php echo e(__('messages.COMMENT')); ?>">
                                          
                                       </div>
                                       <button type="submit" class="msg-send"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>   
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Comment Modal -->
      <div class="modal custom-modal profile-modal " id="share-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                  <form id="post_share" action="<?php echo e(url('/post-share')); ?>" method="post" >
                     <?php echo e(csrf_field()); ?>

                     <div class="row">
                        <!-- <div class="col-sm-12 details-panel-header">
                           <h4 class="text-center">Share</h4>
                        </div> -->
                        <!-- Share post-block -->
                       <div class="col-12"> 
                           <div class="share-post-block-holder function-share-post-block-holder">
                              <div class="post-block">
                                 <div class="media">
                                    <div class="user-profile">
                                    <?php if(!empty($userProfInfo['profileImage'])): ?>
                                       <img src="<?php echo e(asset($userProfInfo['profileImage']['location'])); ?>" alt="">
                                    <?php else: ?>
                                       <img src="<?php echo e(asset('frontend/images/user.png')); ?>" alt="">
                                    <?php endif; ?>
                                     
                                     </div>
                                    <div class="media-body">

                                       <?php if((Auth::user()) && (Auth::user()->user_type == 2)){?>
                                          <h5 class="post-name"><?php echo e(Auth::user()->first_name); ?></h5>
                                          <p class="post-location">
                                          <?php echo e(isset(Auth::user()->currentCompany['title']) ? Auth::user()->currentCompany['title'] : ''); ?>

                                          <?php echo e(isset(Auth::user()->currentCompany['title']) && isset(Auth::user()->currentCompany['company_name']) ? ' at '. Auth::user()->currentCompany['company_name'] : ''); ?>

                                          </p>
                                       <?php }else if((Auth::user()) && (Auth::user()->user_type == 3)){?>
                                          <h5 class="post-name"><?php echo e(isset(Auth::user()->company_name) ? Auth::user()->company_name : ''); ?></h5>
                                          <p class="post-location"><?php echo isset(Auth::user()->profile['business_name']) ? Auth::user()->profile['business_name'] : ''; ?></p>
                                       <?php }?>
                                    </div>
                                 </div>
                                 <div class="post-body">
                                    <input type="hidden" name="post_id" id="post_id" value=""/>
                                    <textarea class="form-control" placeholder="<?php echo e(__('messages.WRITE_SOMETHING')); ?>" name="description"></textarea>
                                 </div>   
                                 <div class="share-post-block post_no_data">
                                    <div class="post-block">
                                       <div class="media">
                                          <div class="user-profile user_profile_id"> <img src="<?php echo e(asset('frontend/images/user-pro-img.png')); ?>" alt="user-profile"> </div>
                                          <div class="media-body media_body_id">
                                             <h5 class="post-name">Carolyn Thompson</h5>
                                             <p class="post-location">UI Developer at Unified Infotech</p>
                                          </div>
                                       </div>
                                       <div class="post-body post_body_id">
                                          <img src="<?php echo e(asset('frontend/images/blog-details-banner.jpg')); ?>" class="img-fluid">
                                       </div>   
                                       
                                    </div>
                                 </div> 
                                 <div class="text-right mt-3">
                                    <button class="btn site-btn-color"><?php echo e(__('messages.SHARE')); ?></button>
                                 </div>  
                              </div>
                           </div>
                       </div>    
                     </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app_after_login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/centralJobs/resources/views/frontend/candidate/viewJobPost.blade.php ENDPATH**/ ?>