<?php $count = count($searchResult) ; if($searchResult){ 
 foreach($searchResult as $key=>$value){
    $connectionArr = [];
    $connectionId = '';
    $accepted = 1;
    if($value['connection'] != null){
        foreach($value['connection'] as $key=>$val){
            if($val['request_sent_by'] == Auth::user()->id){
                $connectionId = $val['id'];
            }
            array_push($connectionArr,$val['request_sent_by']);
        }
    } 
    if($value['connectionAcceptBy'] != null){
        foreach($value['connectionAcceptBy'] as $key=>$val){
           if((Auth::user()) && ($val['request_accepted_by'] == Auth::user()->id)){
              $connectionId = $val['id'];
              $accepted = $val['status'];
           }
           array_push($connectionArr,$val['request_accepted_by']);
        }
     }
     ?>
<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4   text-center">
    <div class="profile-connect-box">
        <div class="profile-img-holder">
        <a href="{{url('candidate/profile/'.$value['slug'])}}">
        <div class="profile-img">
        <?php if($value['profileImage'] != null){?>
                <img src="{{asset($value['profileImage']['location'])}}" alt="">
        <?php }else{ ?>
                <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
        <?php }?>
        </div>
        </a>
        </div>
        <div class="profile-text-holder">
        <h3 class="h3-profile"><a href="{{url('candidate/profile/'.$value['slug'])}}"> <?php echo $value['first_name'];?></a></h3>
        <h6><?php echo $value['currentCompany']['title']; if($value['currentCompany']['title'] != ''){ echo ' at '.$value['currentCompany']['company_name']; } ?></h6>
        <h6><?php echo $value['state']['name'];?> , <?php echo $value['country']['name'];?></h6>
        <div class="btn-holder">
            <?php $result = Helper::chkUserBlockByMe($value['id']); 
            if(empty($result)){
            ?>
            <?php if((Auth::user()) && (!empty($connectionArr)) && (in_array(Auth::user()->id,$connectionArr)) && ($accepted == 0)){?>
                <button class="btn site-btn-color accept-reject-cls" id="connect-id-{{$value['id']}}" data-id="{{$value['id']}}" data-tag="1" data-connect="{{$connectionId}}">{{ __('messages.ACCEPT') }}</button>    
            <?php }else if((Auth::user()) && (!empty($connectionArr)) && (in_array(Auth::user()->id,$connectionArr))){?>
                <button class="btn site-btn-color accept-reject-cls" id="connect-id-{{$value['id']}}" data-id="{{$value['id']}}" data-tag="0" data-connect="{{$connectionId}}">{{ __('messages.REMOVE_CONNECTION') }}</button>    
            <?php }else{ ?>
                <button class="btn site-btn-color connect-cls" id="connect-id-{{$value['id']}}" data-id="{{$value['id']}}" data-tag="0">{{ __('messages.CONNECT') }}</button>
            <?php  }?>
            
            <a href="{{url('/candidate/message/')}}/{{encrypt($value['id'])}}" class="btn site-btn-color"><i class="fa fa-comments" aria-hidden="true"></i></a>
            <?php }else{?>
                <button class="btn site-btn-color w-100 mr-2 block_user" data-id="{{$value['id']}}" data-block="0" id="block_user_{{$value['id']}}">{{__('messages.UN_BLOCK')}}</button>    
            <?php }?>
        </div>
        </div>
    </div>
</div>
<?php } } if($count == 0){?>
    <div class="col-12">
            <div class="nodata-found-holder">
               <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
               <h4>{{ __('messages.SORRY_NO_PROFILE_FOUND') }}</h4> 
            </div>
         </div> 
<?php }?>