<div class="post-block <?php echo e($postRow['highlighted']==1?'post-item highlighted':''); ?>" id="rmv-post-<?php echo e($postRow['id']); ?>">
   <?php if($postRow['highlighted']==1): ?>
      <span class="premium-logo"><img src="<?php echo e(asset('frontend/images/premium.svg')); ?>" /></span>
   <?php endif; ?>
   <div class="media">
      <div class="user-profile user_profile_id" id="user_profile_id_<?php echo e($postRow['id']); ?>"> <a href="<?php echo e(url($postedUser.'/profile/'.$postRow['user']['slug'])); ?>"> 
      <?php if($postRow['user']['profileImage'] != null){?>
         <img src="<?php echo e(asset($postRow['user']['profileImage']['location'])); ?>" alt="">
      <?php }else{ ?>
         <img src="<?php echo e(asset('frontend/images/user-pro-img-demo.png')); ?>" alt="">
      <?php }?>
      </a> </div>
      <div class="media-body media_body_id" id="media_body_id_<?php echo e($postRow['id']); ?>">
      <a href="<?php echo e(url($user_type.'/view-job-post/'.encrypt($postRow['id']))); ?>">
         <h5 class="post-name"><?php echo $postRow['title']; ?></h5>
         <p class="post-location"><?php echo e($postRow['user']['company_name']); ?></p>
      </a>
      </div>
      <div class="dropdown msg-dropdown">
         <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fa fa-ellipsis-v"></i>
         </button>
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item copy_link_id_<?php echo e($postRow['id']); ?>" href="<?php echo e(url($user_type.'/view-job-post/'.encrypt($postRow['id']))); ?>" id="copyButton" data-id="<?php echo e($postRow['id']); ?>"><?php echo e(__('messages.COPY_LINK')); ?></a>
            <?php if(Auth::user()->id == $postRow['user']['id']){?>
            <a class="dropdown-item post-remove-data" href="javascript:void(0);" id="post-delete-id" data-id="<?php echo e($postRow['id']); ?>"><?php echo e(__('messages.DELETE_POST')); ?></a>
            <?php }?>
            <?php if(Auth::user()->id != $postRow['user']['id']){?>
            <a class="dropdown-item" href="javascript:void(0);" id="report-post-id" data-id="<?php echo e($postRow['id']); ?>"><?php echo e(__('messages.REPORT')); ?></a>
            <?php }?>
         </div>
      </div>
   </div>
   <div class="post-body post_body_id" id="post_body_id_<?php echo e($postRow['id']); ?>">
      <div class="dash-job-description">
         <ul class="list-unstyled d-flex flex-wrap">
            <li class="mr-3">
               <p><i class="fa fa-map-marker" aria-hidden="true"></i>
                  <?php echo e($postRow['city'] ? $postRow['city'].',' : ''); ?>

                  <?php echo e(isset($postRow['postState'][0]['state']['name']) ? $postRow['postState'][0]['state']['name'].',' : ''); ?>

                  <?php echo e($postRow['country']['name']); ?>

               </p>
            </li>
            <li class="mr-3"><p><i class="fa fa-user"></i> <?php foreach($postRow['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo isset($val['masterInfo']['name']) ? $val['masterInfo']['name'] : '';}}?> </p></li>
            <li class="mr-3"><p><i class="fa fa-calendar" aria-hidden="true"></i><?php foreach($postRow['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo isset($val['masterInfo']['name']) ? $val['masterInfo']['name'] : '';}}?></p></li>
         </ul>
         <p><?php echo substr($postRow['description'],0,260) ; if(strlen($postRow['description']) > 260){ echo '...'.__('messages.READ_MORE');}?></p>
      </div>
      
   </div>  
</div><?php /**PATH /var/www/html/centralJobs/resources/views/frontend/post/jobpost.blade.php ENDPATH**/ ?>