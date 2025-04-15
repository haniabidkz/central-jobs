<?php $sharePostId = $postData['id'];?>
<div class="post-block">
                                       <div class="media">
                                          <div class="user-profile user_profile_id" id="user_profile_id_{{$postData['id']}}"> 
                                          <a href="{{url($postedUser.'/profile/'.$postData['user']['slug'])}}"> 
                                          <?php if($postData['user']['profileImage'] != null){?>
                                             <img src="{{asset($postData['user']['profileImage']['location'])}}" alt="">
                                          <?php }else{ ?>
                                             <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                          <?php }?>
                                          </a> 
                                          </div>
                                          <div class="media-body media_body_id" id="media_body_id_{{$postData['id']}}">
                                             <h5 class="post-name">
                                             <?php 
                                             if($postData['user']['user_type'] == 2){ 
                                                echo $postData['user']['first_name'].' '.$postData['user']['last_name'];
                                             }else if($postData['user']['user_type'] == 3){
                                                echo $postData['user']['company_name'];
                                             } 
                                             ?>
                                             </h5>
                                             <?php if($postData['user']['user_type'] == 2){?>
                                             <p class="post-location"><?php  echo $postData['user']['currentCompany']['title'];?> at <?php echo $postData['user']['currentCompany']['company_name'];?></p>
                                             <?php }elseif($postData['user']['user_type'] == 3){?>
                                             <p class="post-location"><span class="no-follow"><?php echo count($postData['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                                             <?php }?>
                                          </div>
                                       </div>
                                       <div class="post-body post_body_id" id="post_body_id_{{$postData['id']}}">
                                          <p>{{$postData['description']}}</p>
                                       </div>   

                                       <?php if($postData['sharedPost'] != null){
                                          if($postData['sharedPost']['post']['category_id'] == 3 || $postData['sharedPost']['post']['category_id'] == 4){
                                             //S3 BUCKET IMG
                                             if($postData['sharedPost']['post']['upload']['name'] != ''){
                                                $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
                                                $command = $adapter->getClient()->getCommand('GetObject', [
                                                'Bucket' => $adapter->getBucket(),
                                                'Key'    => $adapter->getPathPrefix(). '' . $postData['sharedPost']['post']['upload']['name']
                                                ]);
                                                $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
                                                $path = (string)$img->getUri();
                                             }else{
                                                $path = '';
                                             }
                                             
                                          }
                                          if($postData['sharedPost']['post']['reportedPost'] != null){
                                             $countReport = count($postData['sharedPost']['post']['reportedPost']);
                                          }else{
                                             $countReport = 0;
                                          }
                                          $sharePostId = $postData['sharedPost']['reference_post_id'];

                                          if($postData['sharedPost']['post']['user']['user_type'] == 2){
                                             $user = 'candidate';
                                          }else if($postData['sharedPost']['post']['user']['user_type'] == 3){
                                             $user = 'company';
                                          }else {
                                             $user = '';
                                          }
                                          $isBlockUser = Helper::checkBlockUser($postData['sharedPost']['post']['user']['id']); 
                                       ?>
                                       <div class="share-post-block">
                                       <?php if(($countReport == 0) && (empty($isBlockUser)) && ($postData['sharedPost']['post'] != null)){ ?>
                                          <div class="post-block">

                                             <div class="media">
                                                <div class="user-profile"> 
                                                   <a href="{{url($user.'/profile/'.$postData['sharedPost']['post']['user']['slug'])}}"> 
                                                   <?php if($postData['sharedPost']['post']['user']['profileImage'] != null){?>
                                                      <img src="{{asset($postData['sharedPost']['post']['user']['profileImage']['location'])}}" alt="">
                                                   <?php }else{ ?>
                                                      <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                                   <?php }?>
                                                   </a>
                                                </div>
                                                <div class="media-body">
                                                <!-- <a href="{{url($user.'/view-post/'.encrypt($postData['sharedPost']['post']['id']))}}"> -->
                                                <?php if($postData['sharedPost']['post']['category_id'] == 1){?>
                                                <a href="{{url($user.'/view-job-post/'.encrypt($postData['sharedPost']['post']['id']))}}">
                                                <?php }else{?>
                                                <a href="{{url($user.'/view-post/'.encrypt($postData['sharedPost']['post']['id']))}}">
                                                <?php }?>
                                                <h5 class="post-name"> 
                                                <?php 
                                                   if($postData['sharedPost']['post']['user']['user_type'] == 2){ 
                                                      echo $postData['sharedPost']['post']['user']['first_name'];
                                                   }else if($postData['sharedPost']['post']['user']['user_type'] == 3){
                                                      if($postData['sharedPost']['post']['category_id'] == 1){
                                                         echo $postData['sharedPost']['post']['title'];
                                                      }else{
                                                         echo $postData['sharedPost']['post']['user']['company_name'];
                                                      }
                                                      
                                                   } ?>
                                                </h5>
                                                   <?php if($postData['sharedPost']['post']['user']['user_type'] == 2){?>
                                                   <p class="post-location"><?php  echo $postData['sharedPost']['post']['user']['currentCompany']['title'];?> <?php if($postData['sharedPost']['post']['user']['currentCompany']['title'] != ''){ echo ' at '.$postData['sharedPost']['post']['user']['currentCompany']['company_name'];}?></p>
                                                   <?php }elseif($postData['sharedPost']['post']['user']['user_type'] == 3){
                                                      if($postData['sharedPost']['post']['category_id'] == 1){?>
                                                      <p class="post-location">{{$postData['sharedPost']['post']['user']['company_name']}}</p>
                                                   <?php }else{ ?>
                                                      <p class="post-location"><span class="no-follow"><?php echo count($postData['sharedPost']['post']['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                                                   <?php } }?>
                                                </a>
                                                </div>
                                             </div>

                                             <div class="post-body">
                                             <a href="{{url($user.'/view-post/'.encrypt($postData['sharedPost']['post']['id']))}}">
                                             <?php if($postData['sharedPost']['post']['category_id'] == 1){?>
                                                <div class="dash-job-description">
                                                   <ul class="list-unstyled d-flex flex-wrap">
                                                      <li class="mr-3"><p><i class="fa fa-map-marker" aria-hidden="true"></i>{{@$postData['sharedPost']['post']['city']}}, {{@$postData['sharedPost']['post']['postState'][0]['state']['name']}} , {{$postData['sharedPost']['post']['country']['name']}} </p></li>
                                                      <li class="mr-3"><p><i class="fa fa-user"></i> <?php foreach($postData['sharedPost']['post']['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo $val['masterInfo']['name'];}}?> </p></li>
                                                      <li class="mr-3"><p><i class="fa fa-calendar" aria-hidden="true"></i><?php foreach($postData['sharedPost']['post']['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo $val['masterInfo']['name'];}}?></p></li>
                                                   </ul>
                                                   <p><?php echo substr($postData['sharedPost']['post']['description'],0,260) ; if(strlen($postData['sharedPost']['post']['description']) > 260){ echo '...';}?></p>
                                                </div>
                                             <?php }else if($postData['sharedPost']['post']['category_id'] == 2){?>   
                                                <p><?php echo substr($postData['sharedPost']['post']['description'],0,260) ; if(strlen($postData['description']) > 260){ echo '...';}?></p>
                                             <?php }else if($postData['sharedPost']['post']['category_id'] == 3){?>
                                                <p><?php echo substr($postData['sharedPost']['post']['title'],0,260) ; if(strlen($postData['sharedPost']['post']['title']) > 260){ echo '...';}?></p>
                                                <img src="{{$path}}" class="img-fluid" alt="banner">
                                             <?php }else if($postData['sharedPost']['post']['category_id'] == 4){?>
                                                <p><?php echo substr($postData['sharedPost']['post']['title'],0,260) ; if(strlen($postData['sharedPost']['post']['title']) > 260){ echo '...';}?></p>
                                                <div class="video-holder-div">
                                                   <video controls>
                                                   <source src="{{$path}}">                                           
                                                   </video>
                                                </div> 
                                             <?php }?>
                                             </a>
                                             </div>   
                                             
                                          </div>
                                          <?php }else{?>
                                          <div class="post-block">
                                          <i class="fa fa-lock fa-lg" aria-hidden="true" ></i>
                                          <h6>{{ __('messages.POST_NOT_AVAILABLE') }}</h6>
                                          <p>{{ __('messages.POST_DELETED_TEXT') }}</p>
                                          </div>
                                          <?php }?>
                                       </div>

                                       <?php }?>         

                                       <div class="like-comment-box">
                                          <div class="d-flex only-like-comment">
                                             <div class=""><span id="total-like-{{$postData['id']}}">{{count($postData['likes'])}}</span> {{ __('messages.LIKE') }} </div> 
                                             <div class=""><span>
                                             <?php $comment = 0;
                                             if(!empty($postData['comments'])){ 
                                                foreach($postData['comments'] as $key=>$val){
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
                                             ?>
                                             </span> {{ __('messages.COMMENTS') }}</div>
                                          </div>
                                          <?php if(Auth::user()){?>
                                          <ul class="d-flex justify-content-between">
                                             <li> <a class="like-post-{{$postData['id']}} {{$addClassLike}}" id="like-post-id" data-like="{{count($postData['likes'])}}" data-id="{{$postData['id']}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('messages.LIKE') }} </a> </li>
                                             <li> <a id="comment-post-modal-id" data-id="{{$postData['id']}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ __('messages.COMMENT') }} </a> </li>
                                             <li> <a id="share-post-modal-id" data-id="{{$sharePostId}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
                                          </ul>
                                          <?php }else{?>   
                                             <ul class="d-flex justify-content-between">
                                             <li> <a class="" href="{{url('/')}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('messages.LIKE') }} </a> </li>
                                             <li> <a href="{{url('/')}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ __('messages.COMMENT') }} </a> </li>
                                             <li> <a class="share-link" href="{{url('/')}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
                                          </ul>  
                                          <?php }?> 
                                       </div>
                                    </div>