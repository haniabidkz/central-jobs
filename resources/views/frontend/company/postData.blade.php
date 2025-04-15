
<?php  $i = 0; if(!empty($postData)){ 
    foreach($postData as $key=>$val){ $nodata = 0; $sharePostId = $val['id'];
    $i++;
    $addClassLike = '';
                if(!empty($val['likes']) && (Auth::user())){
                foreach($val['likes'] as $key=>$valike){
                    if($valike['user_id'] == Auth::user()->id){
                        $addClassLike = 'addlike';
                    }
                }
            }
?>
<div class="col-12 col-xl-6 mb-3  mb-md-4">
    <div class="post-block  recent-post-block-section  h-100 ">
        <div class="media">
            <div class="user-profile"> 
            <?php if($val['company']['profileImage'] != null){?>
                    <img src="{{asset($val['company']['profileImage']['location'])}}" alt="">
                <?php }else{ ?>
                    <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                <?php }?>
                </div>
            <div class="media-body">
                <h5 class="post-name">{{$val['company']['company_name']}}</h5>
                <p class="post-location">
                   {{isset($val['company']['city']['name'])?$val['company']['city']['name']:''}}
                  <?php 
                     if(isset($val['company']['city']['name'])){
                  ?>,
                  <?php 
                     }
                  ?> 
                  {{isset($val['company']['state']['name'])?$val['company']['state']['name']:''}} 
                  <?php 
                     if(isset($val['company']['state']['name'])){
                  ?>,
                  <?php 
                     }
                  ?> 
                  {{isset($val['company']['country']['name'])?$val['company']['country']['name']:''}}</p>
            </div>
        </div>
        <div class="post-body">
            <div class="mCustomScrollbar recent-post-max-height">
                    <?php if($val['category_id'] == 1){?>
                        <a href="{{url($user_type.'/view-job-post/'.encrypt($val['id']))}}">
                    <?php }else{?>
                        <a href="{{url($user_type.'/view-post/'.encrypt($val['id']))}}">
                    <?php }?>
                        <?php if($val['category_id'] == 1){?>
                            <div class="dash-job-description">
                                <ul class="list-unstyled d-flex flex-wrap">
                                <li class="mr-3"><p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$val['city']}}, {{@$val['postState'][0]['state']['name']}} , {{$val['country']['name']}} </p></li>
                                <li class="mr-3"><p><i class="fa fa-user"></i> <?php foreach($val['cmsBasicInfo'] as $key=>$value){ if($value['type'] == 'seniority'){ echo $value['masterInfo']['name'];}}?> </p></li>
                                <li class="mr-3"><p><i class="fa fa-calendar" aria-hidden="true"></i><?php foreach($val['cmsBasicInfo'] as $key=>$values){ if($values['type'] == 'employment_type'){ echo $values['masterInfo']['name'];}}?></p></li>
                                </ul>
                                <p><?php echo substr($val['description'],0,350) ; if(strlen($val['description']) > 350){ echo '...';}?></p>
                            </div>
                        <?php }else if($val['category_id'] == 2){?>
                            <p><?php echo substr($val['description'],0,350); if(strlen($val['description']) > 350){ echo '...';} ?></p>
                        <?php }else if($val['category_id'] == 3){?>
                            <img src="{{asset($val['upload']['location'])}}/{{$val['upload']['name']}}" class="img-fluid" alt="" >
                        <?php }else if($val['category_id'] == 4){?>
                            <div class="video-holder-div">
                                <video controls>
                                <source src="{{asset($val['upload']['location'])}}/{{$val['upload']['name']}}">                                           
                                </video>
                            </div>   
                        <?php }?>
                        </a>    
        
            </div>
        </div>


        <?php if($val['sharedPost'] != null){ //dd($postRow['sharedPost']['post']['']);
      if($val['sharedPost']['post']['reportedPost'] != null){
         $countReport = count($val['sharedPost']['post']['reportedPost']);
      }else{
         $countReport = 0;
      }
         
         //dd($countReport);
         $sharePostId = $val['sharedPost']['reference_post_id'];
         if($val['sharedPost']['post']['user']['user_type'] == 2){
            $user = 'candidate';
         }else if($val['sharedPost']['post']['user']['user_type'] == 3){
            $user = 'company';
         }else {
            $user = '';
         }
         
      ?>
      <div class="share-post-block">
         <?php if(($countReport == 0) && ($val['sharedPost']['post'] != null)){ ?>
            <input type="hidden" name="nodata" id="nodata_{{$val['id']}}" value="0">
         <div class="post-block">
            <div class="media">
               <div class="user-profile"> 
                  <a href="{{url($user.'/profile/'.$val['sharedPost']['post']['user']['slug'])}}"> 
                  <?php if($val['sharedPost']['post']['user']['profileImage'] != null){?>
                     <img src="{{asset($val['sharedPost']['post']['user']['profileImage']['location'])}}" alt="">
                  <?php }else{ ?>
                     <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                  <?php }?>
                  </a>
               </div>
               <div class="media-body">
               <?php if($val['sharedPost']['post']['category_id'] == 1){?>
               <a href="{{url($user.'/view-job-post/'.encrypt($val['sharedPost']['post']['id']))}}">
               <?php }else{?>
               <a href="{{url($user.'/view-post/'.encrypt($val['sharedPost']['post']['id']))}}">
               <?php }?>
               <h5 class="post-name"> 
                  <?php 
                  if($val['sharedPost']['post']['user']['user_type'] == 2){ 
                     echo $val['sharedPost']['post']['user']['first_name'];
                  }else if($val['sharedPost']['post']['user']['user_type'] == 3){
                     if($val['sharedPost']['post']['category_id'] == 1){
                        echo $val['sharedPost']['post']['title'];
                     }else{
                        echo $val['sharedPost']['post']['user']['company_name'];
                     }
                     
                  } ?>
               </h5>
                  <?php if($val['sharedPost']['post']['user']['user_type'] == 2){?>
                  <p class="post-location"><?php  echo $val['sharedPost']['post']['user']['currentCompany']['title'];?> <?php if($val['sharedPost']['post']['user']['currentCompany']['title'] != ''){ echo ' at '.$val['sharedPost']['post']['user']['currentCompany']['company_name'];}?></p>
                  <?php }elseif($val['sharedPost']['post']['user']['user_type'] == 3){
                     if($val['sharedPost']['post']['category_id'] == 1){?>
                        <p class="post-location">{{$val['sharedPost']['post']['user']['company_name']}}</p>
                     <?php }else{ ?>
                        <p class="post-location"><span class="no-follow"><?php echo count($val['sharedPost']['post']['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                     <?php } }?>
               </a>
               </div>
            </div>

            <div class="post-body">
            
            <?php if($val['sharedPost']['post']['category_id'] == 1){?>
               <a href="{{url($user.'/view-job-post/'.encrypt($val['sharedPost']['post']['id']))}}">
               <div class="dash-job-description">
                  <ul class="list-unstyled d-flex flex-wrap">
                     <li class="mr-3"><p><i class="fa fa-map-marker" aria-hidden="true"></i>{{@$val['sharedPost']['post']['city']}}, {{@$val['sharedPost']['post']['postState'][0]['state']['name']}} , {{$val['sharedPost']['post']['country']['name']}} </p></li>
                     <li class="mr-3"><p><i class="fa fa-user"></i> <?php foreach($val['sharedPost']['post']['cmsBasicInfo'] as $key=>$val1){ if($val1['type'] == 'seniority'){ echo $val1['masterInfo']['name'];}}?> </p></li>
                     <li class="mr-3"><p><i class="fa fa-calendar" aria-hidden="true"></i><?php foreach($val['sharedPost']['post']['cmsBasicInfo'] as $key=>$val2){ if($val2['type'] == 'employment_type'){ echo $val2['masterInfo']['name'];}}?></p></li>
                  </ul>
                  <p><?php echo substr($val['sharedPost']['post']['description'],0,260) ; if(strlen($val['sharedPost']['post']['description']) > 260){ echo '...';}?></p>
               </div>
               </a>
            <?php }else if($val['sharedPost']['post']['category_id'] == 2){?>   
               <a href="{{url($user.'/view-post/'.encrypt($val['sharedPost']['post']['id']))}}">
               <p><?php echo substr($val['sharedPost']['post']['description'],0,260) ; if(strlen($val['description']) > 260){ echo '...';}?></p>
               </a>
            <?php }else if($val['sharedPost']['post']['category_id'] == 3){?>
               <a href="{{url($user.'/view-post/'.encrypt($val['sharedPost']['post']['id']))}}">
               <p><?php echo substr($val['sharedPost']['post']['title'],0,260) ; if(strlen($val['sharedPost']['post']['title']) > 260){ echo '...';}?></p>
               <img src="{{asset($val['sharedPost']['post']['upload']['location'])}}/{{$val['sharedPost']['post']['upload']['name']}}" class="img-fluid" alt="banner">
            </a>
            <?php }else if($val['sharedPost']['post']['category_id'] == 4){?>
               <a href="{{url($user.'/view-post/'.encrypt($val['sharedPost']['post']['id']))}}">
               <p><?php echo substr($val['sharedPost']['post']['title'],0,260) ; if(strlen($val['sharedPost']['post']['title']) > 260){ echo '...';}?></p>
               <div class="video-holder-div">
                  <video controls>
                  <source src="{{asset($val['sharedPost']['post']['upload']['location'])}}/{{$val['sharedPost']['post']['upload']['name']}}">                                           
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
                <div class=""><span id="total-like-{{$val['id']}}">{{count($val['likes'])}}</span> {{__('messages.LIKE')}} </div> 
                <div class=""><span><?php $comment = 0;
                    if(!empty($val['comments'])){ 
                    foreach($val['comments'] as $key=>$value){
                        if(count($value['reported']) == 0){
                            $comment++;
                        }
                    }
                    }
                    echo $comment;
                    ?></span> {{__('messages.COMMENTS')}}</div>
            </div>
            
            <?php if((Auth::user()) && (Auth::user()->user_type != 1)){ ?>
                <ul class="d-flex justify-content-between">
                    <li> <a class="like-post-{{$val['id']}} {{$addClassLike}}" id="like-post-id" data-like="{{count($val['likes'])}}" data-id="{{$val['id']}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{__('messages.LIKE')}} </a> </li>
                    <li> <a class="comments-link" data-toggle="modal" id="comment-post-modal-id" data-id="{{$val['id']}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{__('messages.COMMENT')}} </a> </li>
                    <li> <a class="share-link"  data-toggle="modal" id="share-post-modal-id" data-id="{{$val['id']}}" data-no="{{$nodata}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
                </ul>
            <?php }?>
            
        </div>
    </div>
</div>
<?php } }?>