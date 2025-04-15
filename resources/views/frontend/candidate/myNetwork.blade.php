@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/myNetwork.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- main -->
<main>
      <section class="section searchprofile-page">
         <div class="container">
            <div class="row mb-3">
                  <div class="col-6">
                  <?php if(!empty($networkList)){ ?>
                  <h3 class="total-title">{{ __('messages.INVITATION_PENDING') }}</h3>
                  <?php }?>
                  </div>
                  <div class="col-6 text-right"><a class="btn site-btn-color" href="{{url('candidate/following-list')}}">{{ __('messages.FOLLOWING_LIST') }}</a></div>
            </div>
            <div class="row">
               <div class="col-12 searchprofile-slider">
                  <div class="swiper-container">
                     <div class="swiper-wrapper">
                        <?php if(!empty($networkList)){ 
                           foreach($networkList as $key=>$value){ 
                              if(($value['user']['user_type'] == 2) || (($value['user']['user_type'] == 3) && ($value['user']['profile']['approve_status'] == 1))){
                                 if($value['user']['user_type'] == 2){
                                    $userType = 'candidate';
                                 }else if($value['user']['user_type'] == 3){
                                    $userType = 'company';
                                 }
                           ?>
                        <div class="swiper-slide">
                           <div class="profile-whitebox">
                              <!-- <a href="" class="crossprofile"><i class="la la-times"></i></a> -->
                              <div class="profile-img-holder">
                                 <div class="profile-bg-img">
                                 <a href="{{url($userType.'/profile/'.$value['user']['slug'])}}"> 
                                 <?php if($value['user']['banner_image'] != null){?>
                                          <img src="{{asset($value['user']['banner_image']['location'])}}" alt="">
                                 <?php }else{ ?>
                                          <img src="{{asset('frontend/images/user-pro-bg-img.jpg')}}" alt="">
                                 <?php }?>
                                 </a>
                                 </div>
                                 <div class="profile-img">
                                 <a href="{{url($userType.'/profile/'.$value['user']['slug'])}}">    
                                 <?php if($value['user']['profile_image'] != null){?>
                                          <img src="{{asset($value['user']['profile_image']['location'])}}" alt="">
                                 <?php }else{ ?>
                                          <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                 <?php }?>
                                 </div>
                              </div>   
                              <div class="profile-text-holder">
                                 <h3 class="h3-profile"><a href="{{url($userType.'/profile/'.$value['user']['slug'])}}"> <?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name']; }else if($value['user']['user_type'] == 3){ echo $value['user']['company_name'];}?></a></h3>
                           
                                 <?php if($value['user']['user_type'] == 2){?>
                                 <h6><?php echo $value['user']['current_company']['title']; if($value['user']['current_company']['title'] != ''){ echo ' at '.$value['user']['current_company']['company_name'];}?></h6>
                                 <?php }else if($value['user']['user_type'] == 3){?>
                                    <h6>{{$value['user']['profile']['business_name']}}</h6>
                                 <?php }?>
                                 <?php if($value['user']['user_type'] == 3){?>
                                 <h5 class="mutual-tag"> <a href="javascript:void(0);"> {{count($value['user']['followers'])}}  {{ __('messages.FOLLOWERS') }} </a></h5>
                                 <?php }else if($value['user']['user_type'] == 2){?>
                                 <h5 class="mutual-tag"> <a href=""><img src="{{ asset('frontend/images/mutual-icon.png')}}" alt="mutual-icon" class="mutual-icon"> {!! Helper::mutualFrnds($value['user']['id']) !!} {{ __('messages.MUTUAL_CONNECT') }}</a></h5>
                                 <?php }?>
                                 <div class="btn-holder-same">
                                    <button class="btn site-btn-color accept-reject-cls" id="connect-id-{{$value['user']['id']}}" data-id="{{$value['user']['id']}}" data-tag="1" data-connect="{{$value['id']}}"> {{ __('messages.ACCEPT') }} </button>
                                    <button class="btn site-btn-color accept-reject-cls" id="connect-id-{{$value['user']['id']}}" data-id="{{$value['user']['id']}}" data-tag="2" data-connect="{{$value['id']}}"> {{ __('messages.REJECT') }} </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } } }?>

                     </div>
                  </div>
               </div>                                                                                                                      
            </div>  
            <div class="row mb-3">
               <div class="col-12">
                                 <h3 class="mt-0 total-title">{{count($connectedList)}} {{ __('messages.PEOPLE') }} <?php if(count($connectedList) > 1){ ?>{{ __('messages.ARE') }}<?php }?> {{ __('messages.CONNECTED_WITH_YOU') }} </h3>
               </div>
            </div> 
            <form action="{{url('candidate/my-network')}}" id="candidate" method="get">  
            <div class="row whitebg mx-0 mb-4 pt-4 pb-2">
               <div class="col-12 d-flex input-search-holder "> 
                  <div class="input-search">
                     <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{ __('messages.CANDIDATES_NAME') }} / {{ __('messages.COMPANIES_NAME') }}" name="name" value="{{@$search['name']}}">
                     </div>  
                  </div>    
                  <div class="input-search">
                     <div class="form-group d-flex">
                        <button class="btn site-btn-color mr-2"> {{ __('messages.SEARCH') }}</button>
                        <?php if(@$search['name'] != ''){?>
                        <a class="btn site-btn-color src-res-com" href="{{ url('candidate/my-network') }}"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        <?php }?>
                     </div>
                  </div>
               </div>   
            </div>
            </form>
            <div class="row">
               <div class="col-12 searchconnected-slider">
                  <div class="swiper-container">
                     <div class="swiper-wrapper">
                     <?php if(!empty($connectedList)){ 
                           foreach($connectedList as $key=>$value){ 
                              
                                 if($value['user']['user_type'] == 2){
                                    $userType = 'candidate';
                                 }else if($value['user']['user_type'] == 3){
                                    $userType = 'company';
                                 }

                                 $followUnfollowArr = [];
                                 if((!empty($value['user']['followers'])) && count($value['user']['followers']) != 0){
                                    foreach($value['user']['followers'] as $key=>$val){
                                          array_push($followUnfollowArr,$val['follower_id']);
                                    }
                                 }
                                 

                           ?>             
                        <div class="swiper-slide">
                           <div class="profile-whitebox">
                              <div class="profile-img-holder">
                                 <div class="profile-bg-img">
                                 <a href="{{url($userType.'/profile/'.$value['user']['slug'])}}"> 
                                 <?php if($value['user']['banner_image'] != null){?>
                                          <img src="{{asset($value['user']['banner_image']['location'])}}" alt="">
                                 <?php }else{ ?>
                                          <img src="{{asset('frontend/images/user-pro-bg-img.jpg')}}" alt="">
                                 <?php }?>
                                 </div>
                                 <div class="profile-img">
                                 <a href="{{url($userType.'/profile/'.$value['user']['slug'])}}">    
                                 <?php if($value['user']['profile_image'] != null){?>
                                          <img src="{{asset($value['user']['profile_image']['location'])}}" alt="">
                                 <?php }else{ ?>
                                          <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                 <?php }?>
                                 </div>
                              </div>
                              <div class="profile-text-holder">
                                 <h3 class="h3-profile"><a href="{{url($userType.'/profile/'.$value['user']['slug'])}}"> <?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name']; }else if($value['user']['user_type'] == 3){ echo $value['user']['company_name'];}?></a></h3>
                                 
                                 <?php if($value['user']['user_type'] == 2){?>
                                 <h6><?php echo $value['user']['current_company']['title']; if($value['user']['current_company']['title'] != ''){ echo ' at '.$value['user']['current_company']['company_name'];}?></h6>
                                 <?php }else if($value['user']['user_type'] == 3){?>
                                    <h6>{{$value['user']['profile']['business_name']}}</h6>
                                 <?php }?>
                                 <?php if($value['user']['user_type'] == 3){?>
                                 <h5 class="mutual-tag"> <a href="javascript:void(0);" style="cursor:default;"> <span id="total-follow-{{$value['id']}}"><?php echo $result = Helper::getFollowerCount($value['user']['id']);?></span>  {{ __('messages.FOLLOWERS') }} </a></h5>
                                 <?php }else if($value['user']['user_type'] == 2){?>
                                 <h5 class="mutual-tag"> <a href="javascript:void(0);" style="cursor:default;"><img src="{{ asset('frontend/images/mutual-icon.png')}}" alt="mutual-icon" class="mutual-icon"> {!! Helper::mutualFrnds($value['user']['id']) !!} {{ __('messages.MUTUAL_CONNECT') }}</a></h5>
                                 <?php }?>
                                 <div class="btn-holder-same">
                                 <?php $result = Helper::chkUserBlockByMe($value['user']['id']);
                                 if(empty($result)){
                                 ?>
                                 <button class="btn site-btn-color accept-reject-cls" id="connect-id-{{$value['user']['id']}}" data-id="{{$value['user']['id']}}" data-tag="0" data-connect="{{$value['id']}}"> {{ __('messages.REMOVE_CONNECTION') }} </button>
                                 <?php }else{?>
                                    <button class="btn site-btn-color w-100 mr-2 block_user" data-id="{{$value['user']['id']}}" data-block="0" id="block_user_{{$value['user']['id']}}">{{__('messages.UN_BLOCK')}}</button>    
                                 <?php }?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } }
                        
                         ?>
                     </div>
                  </div>
               </div> 
               
               <?php 
                        if(count($connectedList) == 0){?>
                        
                        <div class="col-12">
                           <div class="nodata-found-holder">
                              <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
                              <h4>{{ __('messages.SORRY_NO_PROFILE_FOUND') }}</h4> 
                           </div>
                        </div> 
                        <?php }?>
            </div>  
         </div>
      </section>
      <!--messages-page end-->
   </main>
      <!-- main End -->
                         
       @endsection
      <!-- main-page -->
     
     


