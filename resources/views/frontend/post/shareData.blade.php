<?php 
if($postRow['category_id'] == 3 || $postRow['category_id'] == 4){
   //S3 BUCKET IMG
   if($postRow['upload']['name'] != ''){
      $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
      $command = $adapter->getClient()->getCommand('GetObject', [
      'Bucket' => $adapter->getBucket(),
      'Key'    => $adapter->getPathPrefix(). '' . $postRow['upload']['name']
      ]);
      $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
      $path = (string)$img->getUri();
   }else{
      $path = '';
   }
}  
?>
<div class="post-block">
            <div class="media">
               <div class="user-profile"> 
                  
                  <?php if($postRow['user']['profileImage'] != null){?>
                     <img src="{{asset($postRow['user']['profileImage']['location'])}}" alt="">
                  <?php }else{ ?>
                     <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                  <?php }?>
                  
               </div>
               <div class="media-body">
               
               <h5 class="post-name"> 
                  <?php 
                  if($postRow['user']['user_type'] == 2){ 
                     echo $postRow['user']['first_name'];
                  }else if($postRow['user']['user_type'] == 3){
                     if($postRow['category_id'] == 1){
                        echo $postRow['title'];
                     }else{
                        echo $postRow['user']['company_name'];
                     }
                     
                  } ?>
               </h5>
                  <?php if($postRow['user']['user_type'] == 2){?>
                  <p class="post-location"><?php  echo $postRow['user']['currentCompany']['title'];?> <?php if($postRow['user']['currentCompany']['title'] != ''){ echo ' at '.$postRow['user']['currentCompany']['company_name'];}?></p>
                  <?php }elseif($postRow['user']['user_type'] == 3){
                     if($postRow['category_id'] == 1){?>
                        <p class="post-location">{{$postRow['user']['company_name']}}</p>
                     <?php }else{ ?>
                        <p class="post-location"><span class="no-follow"><?php echo count($postRow['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                     <?php } }?>
               
               </div>
            </div>

            <div class="post-body">
            
            <?php if($postRow['category_id'] == 1){?>
               <div class="dash-job-description">
                  <ul class="list-unstyled d-flex flex-wrap">
                     <li class="mr-3"><p><i class="fa fa-map-marker" aria-hidden="true"></i>{{@$postRow['city']}}, {{@$postRow['postState'][0]['state']['name']}} , {{$postRow['country']['name']}} </p></li>
                     <li class="mr-3"><p><i class="fa fa-user"></i> <?php foreach($postRow['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo $val['masterInfo']['name'];}}?> </p></li>
                     <li class="mr-3"><p><i class="fa fa-calendar" aria-hidden="true"></i><?php foreach($postRow['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo $val['masterInfo']['name'];}}?></p></li>
                  </ul>
                  <p><?php echo substr($postRow['description'],0,260) ; if(strlen($postRow['description']) > 260){ echo '...';}?></p>
               </div>
            <?php }else if($postRow['category_id'] == 2){?>   
               <p><?php echo substr($postRow['description'],0,260) ; if(strlen($postRow['description']) > 260){ echo '...';}?></p>
            <?php }else if($postRow['category_id'] == 3){?>
               <p><?php echo substr($postRow['title'],0,260) ; if(strlen($postRow['title']) > 260){ echo '...';}?></p>
               <img src="{{$path}}" class="img-fluid" alt="banner">
            <?php }else if($postRow['category_id'] == 4){?>
               <p><?php echo substr($postRow['title'],0,260) ; if(strlen($postRow['title']) > 260){ echo '...';}?></p>
               <div class="video-holder-div">
                  <video controls>
                  <source src="{{$path}}">                                           
                  </video>
               </div> 
            <?php }?>
          
            </div>   
            
         </div>