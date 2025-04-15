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
                     <!-- <h3 class="total-title">Invitation</h3> -->
                  </div>
               <!-- <div class="col-6 text-right"><a class="btn site-btn-color" href="{{url('candidate/following-list')}}">Following List</a></div> -->
            </div>
             
            <div class="row mb-3">
               <div class="col-12">
                                 <h3 class="mt-0 total-title">{{count($connectedList)}} {{ __('messages.PEOPLE') }} <?php if(count($connectedList) > 1){ ?>{{ __('messages.ARE') }}<?php }?> {{ __('messages.CONNECTED_WITH_YOU') }} </h3>
               </div>
            </div> 
            <form action="{{url('company/my-network')}}" id="candidate" method="get">  
            <div class="row whitebg mx-0 mb-4 pt-4 pb-2">
               <div class="col-12 d-flex input-search-holder "> 
                  <div class="input-search">
                     <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{ __('messages.CANDIDATES_NAME') }}" name="name" value="{{@$search['name']}}">
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
                              
                                 if($value['user_connected_with_company']['user_type'] == 2){
                                    $userType = 'candidate';
                                 }else if($value['user_connected_with_company']['user_type'] == 3){
                                    $userType = 'company';
                                 }
                           ?>             
                        <div class="swiper-slide">
                           <div class="profile-whitebox">
                              <div class="profile-img-holder">
                                 <div class="profile-bg-img">
                                 <a href="{{url($userType.'/profile/'.$value['user_connected_with_company']['slug'])}}"> 
                                 <?php if($value['user_connected_with_company']['banner_image'] != null){?>
                                          <img src="{{asset($value['user_connected_with_company']['banner_image']['location'])}}" alt="">
                                 <?php }else{ ?>
                                          <img src="{{asset('frontend/images/user-pro-bg-img.jpg')}}" alt="">
                                 <?php }?>
                                 </div>
                                 <div class="profile-img">
                                 <a href="{{url($userType.'/profile/'.$value['user_connected_with_company']['slug'])}}">    
                                 <?php if($value['user_connected_with_company']['profile_image'] != null){?>
                                          <img src="{{asset($value['user_connected_with_company']['profile_image']['location'])}}" alt="">
                                 <?php }else{ ?>
                                          <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                 <?php }?>
                                 </div>
                              </div>
                              <div class="profile-text-holder">
                                 <h3 class="h3-profile"><a href="{{url($userType.'/profile/'.$value['user_connected_with_company']['slug'])}}"> {{$value['user_connected_with_company']['first_name']}}</a></h3>
                                 <h6><?php echo $value['user_connected_with_company']['current_company']['title'];?> <?php if($value['user_connected_with_company']['current_company']['title'] != ''){?>{{ __('messages.AT') }}<?php }?> <?php echo $value['user_connected_with_company']['current_company']['company_name'];?></h6>
                                 <h5 class="mutual-tag"> <a href=""><img src="{{ asset('frontend/images/mutual-icon.png')}}" alt="mutual-icon" class="mutual-icon"> {!! Helper::mutualFrnds($value['user_connected_with_company']['id']) !!} {{ __('messages.MUTUAL_CONNECT') }}</a></h5>
                                 <div class="btn-holder-same">
                                 <?php $result = Helper::chkUserBlockByMe($value['user_connected_with_company']['id']);
                                 if(empty($result)){
                                 ?>
                                    <a href="{{url('/candidate/message/')}}/{{encrypt($value['user_connected_with_company']['id'])}}" class="btn site-btn-color"> {{ __('messages.MESSAGE') }} </a>
                                 <?php }else{?>
                                    <button class="btn site-btn-color w-100 mr-2 block_user" data-id="{{$value['user_connected_with_company']['id']}}" data-block="0" id="block_user_{{$value['user_connected_with_company']['id']}}">{{__('messages.UN_BLOCK')}}</button>    
                                 <?php }?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } } ?>
                     </div>
                  </div>
               </div>
               <?php if(count($connectedList) == 0){?>
                  <div class="col-12">
                     <div class="nodata-found-holder">
                        <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
                        <h4>{{ __('messages.SORRY_NO_RESULT_FOUND') }}</h4> 
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
     
     


