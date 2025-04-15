<?php 
$sharePostId = $postRow['id']; $nodata = 0;
?>
<div class="post-block" id="rmv-post-{{$postRow['id']}}">
      <div class="media">
         <div class="user-profile user_profile_id" id="user_profile_id_{{$postRow['id']}}"><a href="{{url($postedUser.'/profile/'.$postRow['user']['slug'])}}"> 
         <?php if($postRow['user']['profileImage'] != null){?>
            <img src="{{asset($postRow['user']['profileImage']['location'])}}" alt="">
         <?php }else{ ?>
            <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
         <?php }?>
         </a> </div>
         <div class="media-body media_body_id" id="media_body_id_{{$postRow['id']}}">
            <a href="{{url($user_type.'/view-post/'.encrypt($postRow['id']))}}">
               <h5 class="post-name"> <?php 
            if($postRow['user']['user_type'] == 2){ 
               echo $postRow['user']['first_name'].' '.$postRow['user']['last_name'];
            }else if($postRow['user']['user_type'] == 3){
               echo $postRow['user']['company_name'];
            } ?></h5>
               <?php if($postRow['user']['user_type'] == 2){?>
            <p class="post-location"><?php  echo $postRow['user']['currentCompany']['title'];?> <?php if($postRow['user']['currentCompany']['title'] != ''){?>at<?php }?> <?php echo $postRow['user']['currentCompany']['company_name'];?></p>
            <?php }elseif($postRow['user']['user_type'] == 3){?>
            <p class="post-location"><span class="no-follow"><?php echo count($postRow['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
            <?php }?>
            </a>
         </div>
         <div class="dropdown msg-dropdown">
            <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
               <a class="dropdown-item copy_link_id_{{$postRow['id']}}" href="{{url($user_type.'/view-post/'.encrypt($postRow['id']))}}" data-id="{{$postRow['id']}}" id="copyButton">{{ __('messages.COPY_LINK') }}</a>
               <?php if(Auth::user()->id == $postRow['user']['id']){?>
               <a class="dropdown-item post-remove-data" href="javascript:void(0);" id="post-delete-id" data-id="{{$postRow['id']}}">{{ __('messages.DELETE_POST') }}</a>
               <?php }?>
               <?php if(Auth::user()->id != $postRow['user']['id']){?>
               <a class="dropdown-item" href="javascript:void(0);" id="report-post-id" data-id="{{$postRow['id']}}">{{ __('messages.REPORT') }}</a>
               <?php }?>
            </div>
         </div>
      </div>
      <div class="post-body pt-2 post_body_id" id="post_body_id_{{$postRow['id']}}">
         <a href="{{url($user_type.'/view-post/'.encrypt($postRow['id']))}}">
            <?php if($postRow['category_id'] == 1){?>
               <p><?php echo substr($postRow['description'],0,260);?></p>
            <?php }else if($postRow['category_id'] == 2){?>   
               <p><?php echo substr($postRow['description'],0,260) ; if(strlen($postRow['description']) > 260){ echo '...'.__('messages.READ_MORE');}?></p>
            <?php }else if($postRow['category_id'] == 3){?>
               <img src="{{ asset($postRow['upload']['location']) }}" class="img-fluid">
            <?php }else if($postRow['category_id'] == 4){?>
               <img src="{{ asset($postRow['upload']['location']) }}" class="img-fluid">
            <?php }?>
         </a>  
      </div>
      <?php if($postRow['sharedPost'] != null){ //dd($postRow['sharedPost']['post']['']);
      if($postRow['sharedPost']['post']['category_id'] == 3 || $postRow['sharedPost']['post']['category_id'] == 4){
         //S3 BUCKET IMG
         if($postRow['sharedPost']['post']['upload']['name'] != ''){
            $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
            $command = $adapter->getClient()->getCommand('GetObject', [
            'Bucket' => $adapter->getBucket(),
            'Key'    => $adapter->getPathPrefix(). '' . $postRow['sharedPost']['post']['upload']['name']
            ]);
            $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
            $path = (string)$img->getUri();
         }else{
            $path = '';
         }
      }  
      if($postRow['sharedPost']['post']['reportedPost'] != null){
         $countReport = count($postRow['sharedPost']['post']['reportedPost']);
      }else{
         $countReport = 0;
      }
         
         //dd($countReport);
         $sharePostId = $postRow['sharedPost']['reference_post_id'];
         if($postRow['sharedPost']['post']['user']['user_type'] == 2){
            $user = 'candidate';
         }else if($postRow['sharedPost']['post']['user']['user_type'] == 3){
            $user = 'company';
         }else {
            $user = '';
         }
        $isBlockUser = Helper::checkBlockUser($postRow['sharedPost']['post']['user']['id']); 
      ?>
      <div class="share-post-block">
         <?php if(($countReport == 0) && (empty($isBlockUser)) && ($postRow['sharedPost']['post'] != null)){ ?>
            <input type="hidden" name="nodata" id="nodata_{{$postRow['id']}}" value="0">
         <div class="post-block">
            <div class="media">
               <div class="user-profile"> 
                  <a href="{{url($user.'/profile/'.$postRow['sharedPost']['post']['user']['slug'])}}"> 
                  <?php if($postRow['sharedPost']['post']['user']['profileImage'] != null){?>
                     <img src="{{asset($postRow['sharedPost']['post']['user']['profileImage']['location'])}}" alt="">
                  <?php }else{ ?>
                     <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                  <?php }?>
                  </a>
               </div>
               <div class="media-body">
               <?php if($postRow['sharedPost']['post']['category_id'] == 1){?>
               <a href="{{url($user.'/view-job-post/'.encrypt($postRow['sharedPost']['post']['id']))}}">
               <?php }else{?>
               <a href="{{url($user.'/view-post/'.encrypt($postRow['sharedPost']['post']['id']))}}">
               <?php }?>
               <h5 class="post-name"> 
                  <?php 
                  if($postRow['sharedPost']['post']['user']['user_type'] == 2){ 
                     echo $postRow['sharedPost']['post']['user']['first_name'];
                  }else if($postRow['sharedPost']['post']['user']['user_type'] == 3){
                     if($postRow['sharedPost']['post']['category_id'] == 1){
                        echo $postRow['sharedPost']['post']['title'];
                     }else{
                        echo $postRow['sharedPost']['post']['user']['company_name'];
                     }
                     
                  } ?>
               </h5>
                  <?php if($postRow['sharedPost']['post']['user']['user_type'] == 2){?>
                  <p class="post-location"><?php  echo $postRow['sharedPost']['post']['user']['currentCompany']['title'];?> <?php if($postRow['sharedPost']['post']['user']['currentCompany']['title'] != ''){ echo ' at '.$postRow['sharedPost']['post']['user']['currentCompany']['company_name'];}?></p>
                  <?php }elseif($postRow['sharedPost']['post']['user']['user_type'] == 3){
                     if($postRow['sharedPost']['post']['category_id'] == 1){?>
                        <p class="post-location">{{$postRow['sharedPost']['post']['user']['company_name']}}</p>
                     <?php }else{ ?>
                        <p class="post-location"><span class="no-follow"><?php echo count($postRow['sharedPost']['post']['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                     <?php } }?>
               </a>
               </div>
            </div>

            <div class="post-body">
            
            <?php if($postRow['sharedPost']['post']['category_id'] == 1){ ?>
               <a href="{{url($user.'/view-job-post/'.encrypt($postRow['sharedPost']['post']['id']))}}">
               <div class="dash-job-description">
                  <ul class="list-unstyled d-flex flex-wrap">
                     <li class="mr-3"><p><i class="fa fa-map-marker" aria-hidden="true"></i>{{@$postRow['sharedPost']['post']['city']}}, {{@$postRow['sharedPost']['post']['postState'][0]['state']['name']}} , {{$postRow['sharedPost']['post']['country']['name']}} </p></li>
                     <li class="mr-3"><p><i class="fa fa-user"></i> <?php foreach($postRow['sharedPost']['post']['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo $val['masterInfo']['name'];}}?> </p></li>
                     <li class="mr-3"><p><i class="fa fa-calendar" aria-hidden="true"></i><?php foreach($postRow['sharedPost']['post']['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo $val['masterInfo']['name'];}}?></p></li>
                  </ul>
                  <p><?php echo substr($postRow['sharedPost']['post']['description'],0,260) ; if(strlen($postRow['sharedPost']['post']['description']) > 260){ echo '...';}?></p>
               </div>
               </a>
            <?php }else if($postRow['sharedPost']['post']['category_id'] == 2){?>   
               <a href="{{url($user.'/view-post/'.encrypt($postRow['sharedPost']['post']['id']))}}">
               <p><?php echo substr($postRow['sharedPost']['post']['description'],0,260) ; if(strlen($postRow['description']) > 260){ echo '...';}?></p>
               </a>
            <?php }else if($postRow['sharedPost']['post']['category_id'] == 3){?>
               <a href="{{url($user.'/view-post/'.encrypt($postRow['sharedPost']['post']['id']))}}">
               <p><?php echo substr($postRow['sharedPost']['post']['title'],0,260) ; if(strlen($postRow['sharedPost']['post']['title']) > 260){ echo '...';}?></p>
               <img src="{{$path}}" class="img-fluid" alt="banner">
            </a>
            <?php }else if($postRow['sharedPost']['post']['category_id'] == 4){?>
               <a href="{{url($user.'/view-post/'.encrypt($postRow['sharedPost']['post']['id']))}}">
               <p><?php echo substr($postRow['sharedPost']['post']['title'],0,260) ; if(strlen($postRow['sharedPost']['post']['title']) > 260){ echo '...';}?></p>
               <div class="video-holder-div">
                  <video controls>
                  <source src="{{$path}}">                                           
                  </video>
               </div> 
               </a>
            <?php }?>
           
            </div>   
            
         </div>
            <?php }else{  $nodata = 1;?>
            <div class="post-block mb-0">
            <i class="fa fa-lock fa-lg" aria-hidden="true" ></i>
            <h6 class="total-sub-title">{{ __('messages.POST_NOT_AVAILABLE') }}</h6>
            <p class="mb-0">{{ __('messages.POST_DELETED_TEXT') }}</p>
            </div>
            <?php }?>
      </div>

      <?php }?>
      <div class="like-comment-box">
         <div class="d-flex only-like-comment">
            <div class=""><span id="total-like-{{$postRow['id']}}">{{count($postRow['likes'])}}</span> {{ __('messages.LIKE') }} </div> 
            <div class=""><span> <?php $comment = 0;
            if(!empty($postRow['comments'])){ 
               foreach($postRow['comments'] as $key=>$val){
                  $reportedChk = 0;
                  if(count($val['reported']) > 0){
                     foreach($val['reported'] as $key1=>$val1){
                        if($val1['user_id'] == Auth::user()->id){
                           $reportedChk++;
                        }
                     }
                  }

                  if((count($val['reported']) == 0) || ($reportedChk == 0)){
                     $comment++;
                  }
               }
            }
            echo $comment;
            ?></span> {{ __('messages.COMMENTS') }}</div>
         </div>
         <ul class="d-flex justify-content-between">
            <li> <a class="like-post-{{$postRow['id']}} {{$addClassLike}}" id="like-post-id" data-like="{{count($postRow['likes'])}}" data-id="{{$postRow['id']}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('messages.LIKE') }} </a> </li>
            <li> <a class="comments-link" data-toggle="modal" id="comment-post-modal-id" data-id="{{$postRow['id']}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ __('messages.COMMENT') }} </a> </li>
            <li> <a class="share-link"  data-toggle="modal" id="share-post-modal-id" data-id="{{$sharePostId}}" data-no="{{$nodata}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
         </ul>       
      </div>
   </div>