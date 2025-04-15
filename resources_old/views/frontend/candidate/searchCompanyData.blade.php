<?php $count = count($searchCompResult) ; if($searchCompResult){ 
 foreach($searchCompResult as $key=>$value){ 
     $followUnfollowArr = [];
     if((!empty($value['followers'])) && count($value['followers']) != 0){
        foreach($value['followers'] as $key=>$val){
            array_push($followUnfollowArr,$val['follower_id']);
        }
     }
     ?>
<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4 text-center">
    <div class="profile-connect-box">
        <div class="profile-img-holder"> 
        <a href="{{url('company/profile/'.$value['slug'])}}">
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
        <h3 class="h3-profile"><a href="{{url('company/profile/'.$value['slug'])}}"> {{$value['company_name']}}</a></h3>
        <h6>{{$value['profile']['business_name']}}</h6>
        <h5 class="mutual-tag"> <a href=""> <span id="total-follow-{{$value['id']}}"><?php echo $result = Helper::getFollowerCount($value['id']);?></span>  {{ __('messages.FOLLOWERS') }} </a></h5>
         <div class="btn-holder d-flex justify-content-center">
            <?php $result = Helper::chkUserBlockByMe($value['id']); 
                if(empty($result)){
                ?>
            <button class="btn site-btn-color w-100 follow-unfollow-user-{{$value['id']}}" id="follow-unfollow-user" data-id="{{$value['id']}}" <?php if(!empty($followUnfollowArr) && (in_array(Auth::user()->id,$followUnfollowArr))){ ?>data-follow="0"<?php }else{ ?> data-follow="1"<?php }?>><?php if(!empty($followUnfollowArr) && (in_array(Auth::user()->id,$followUnfollowArr))){ echo __('messages.UN_FOLLOW');}else{ echo  __('messages.FOLLOW') ;}?></button>
            <?php }else{?>
                    <button class="btn site-btn-color w-100 mr-2 block_user" data-id="{{$value['id']}}" data-block="0" id="block_user_{{$value['id']}}">{{__('messages.UN_BLOCK')}}</button>    
            <?php }?>
         </div>
        </div>
    </div>
</div> 
<?php } }  if($count == 0){?>
    <div class="col-12">
            <div class="nodata-found-holder">
               <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
               <h4>{{ __('messages.SORRY_NO_PROFILE_FOUND') }}</h4> 
            </div>
         </div> 
<?php }?>