
@extends('layouts.app_after_login_layout')
@section('content')
<script type="text/javascript">
    const companyList = <?php echo $company_json; ?>;
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('frontend/js/job.js')}}"></script>
<main>
   <section class="section section-myjob">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <form>
                  <div class="section-myprofile">
                     <div class="login-form">
                        <div class="row mb-3">
                           <div class="col-12">
                                 <h4 class="page-title">{{ __('messages.MY_JOBS') }} - {{ __('messages.CANDIDATE') }}</h4> 
                           </div>
                        </div>
                       
                        <div class="row">
                              <div class="col-12">
                                 <div class="form-group">
                                 <div class="select-newstyle">
                                    <div class="list-inline-item">
                                          <label class="check-style">
                                          {{ __('messages.POSITION_NAME') }}
                                             <input type="radio" name="company" id="positionCheck" onclick="check_positionFunction()" value="1" <?php if(@$search['company'] == 1){?> checked <?php }?>>
                                          <span class="checkmark"></span>
                                          </label>
                                    </div>
                                    <div class="list-inline-item">
                                          <label class="check-style">
                                          {{ __('messages.COMPANY_NAME') }}
                                          <input type="radio" name="company" id="companyCheck" onclick="check_companyFunction()" value="2" <?php if(@$search['company'] == 2){?> checked <?php }?>>
                                          <span class="checkmark"></span>
                                          </label>
                                    </div>
                                 </div>
                                 </div>                                    
                              </div>
                        </div> 
                              <div class="row mb-4" id="checkPosition" <?php if(@$search['company'] == 1){?> style="display:block;" <?php }else{?> style="display:none;"<?php }?>>
                              <div class="col-12"> <h4 class="total-sub-title">{{ __('messages.POSITION_NAME') }}</h4>  </div>
                              <div class="col-12 d-flex input-search-holder "> 
                                 <!-- <div class="input-search">
                                 <div class="form-group required">
                                    <input type="text" class="form-control" placeholder="Position Name *">
                                 </div>  
                                 </div> -->
                                 <div class="input-search">
                                 <div class="form-group required">
                                    <select name="position_name[]" id="position_name" data-placeholder="{{ __('messages.POSITION_NAME') }} *" id="itskills" class="form-control js-example-tags" multiple="multiple" style="display: none;">
                                       <?php if($position){ 
                                        foreach($position as $key=>$val){  
                                          ?>
                                       <option value="{{$val}}" <?php if((isset($search['position_name'])) && in_array($val,$search['position_name'], TRUE)){ echo 'selected';}?>>{{$val}}</option>
                                       <?php } }?>
                                    </select>
                                    <label class="error-position-name" style="display:none;"></label>
                                 </div>   
                                 </div>    
                                 <div class="input-search">
                                    <div class="form-group">
                                       <select class="form-control" name="country_id" id="country_id_search">
                                       <option value="">{{ __('messages.COUNTRY') }}</option>
                                       <?php if($countries){
                                          foreach($countries as $key=>$val){
                                          ?>
                                       <option value="{{$val['id']}}" <?php if($val['id'] == $selectedCountry){ echo 'selected';} ?>>{{$val['name']}}</option>
                                       <?php } }?>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="input-search">
                                    <div class="form-group  multi-select-states-area">
                                    <select name="state"  id="state" data-placeholder="{{ __('messages.STATE') }}" id="state" class="form-control">
                                    <option value="">{{ __('messages.STATE') }} </option>
                                    <?php if($states){
                                    foreach ($states as $key => $value) {
                                    ?>
                                    <option value="{{$value['id']}}" <?php if($value['id'] == @$search['state']){ echo 'selected';} ?>>{{$value['name']}}</option>
                                    <?php } } ?>
                                    </select>   
                                    </div>
                                 </div>
                                 <div class="input-search">
                                    <div class="form-group d-flex">
                                    <button class="btn site-btn-color search-job-cls mr-2"> {{ __('messages.SEARCH') }}</button>
                                    <?php if(!empty($search) && (isset($search['position_name'])) && ($search['position_name'] != '')){?>
                                    <a class="btn site-btn-color" href="{{ url('candidate/my-jobs') }}"><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                                    <?php }?>
                                    </div>
                                 </div>
                              </div>   
                           </div>
                           <div class="row mb-4" id="checkCompany" <?php if(@$search['company'] == 2){?> style="display:block;" <?php }else{?> style="display:none;"<?php }?>>
                              <div class="col-12"> <h4 class="total-sub-title">{{ __('messages.COMPANY_NAME') }}</h4>  </div>
                              <div class="col-12 d-flex input-search-holder "> 
                                 <div class="input-search">
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="{{ __('messages.COMPANY_NAME') }} *" name="company_name" id="company_name" value="{{@$search['company_name']}}">
                                    <label class="error-company-name" style="display:none;"></label>
                                 </div>  
                                 </div>    
                                 <div class="input-search">
                                    <div class="form-group">
                                    <select class="form-control" name="country_id_search_company" id="country_id_search_company">
                                    <option value="">{{ __('messages.COUNTRY') }}</option>
                                       <?php if($countries){
                                          foreach($countries as $key=>$val){
                                          ?>
                                       <option value="{{$val['id']}}" <?php if($val['id'] == $selectedCountry1){ echo 'selected';} ?>>{{$val['name']}}</option>
                                       <?php } }?>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="input-search">
                                    <div class="form-group multi-select-states-area-company">
                                    <select name="state_comp"  id="state_comp" data-placeholder="State"  class="form-control">
                                    <option value="">{{ __('messages.STATE') }} </option>
                                    <?php if($states1){
                                    foreach ($states1 as $key => $value) {
                                    ?>
                                    <option value="{{$value['id']}}" <?php if($value['id'] == @$search['state_comp']){ echo 'selected';} ?>>{{$value['name']}}</option>
                                    <?php } } ?>
                                    </select> 
                                    </div>
                                 </div>
                                 <div class="input-search">
                                    <div class="form-group d-flex">
                                    <button class="btn site-btn-color search-job-cls mr-2"> {{ __('messages.SEARCH') }}</button>
                                    <?php if(!empty($search) && (isset($search['company_name'])) && ($search['company_name'] != '')){?>
                                    <a class="btn site-btn-color" href="{{ url('candidate/my-jobs') }}"><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                                    <?php }?>
                                    </div>
                                 </div>
                              </div>   
                           </div>
                           
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="row">
            <div class="col-12 col-lg-4 pr-lg-0">
               <!-- <div class="details-panel-header"> <h4>Job List</h4> </div> -->
               <div class=" media align-items-center mb-3 py-3 col-12 whitebg">
                  <div class="media-body">
                     <h4 class="my-0 total-title"><?php echo Auth::user()->first_name;?></h4>
                  </div>  
                  <div class="switch-slider d-flex align-items-center">
                     <p class="mb-0 mr-2">{{ __('messages.JOB_ALERT') }} </p>
                     <label class="switch">
                        <input id="start" type="checkbox" <?php if(Auth::user()->is_notification_on == 1){ echo 'checked';}?>>
                        <span class="slider round"></span>
                     </label>
                  </div> 
               </div>
               <div class="job-list-page">
                  <div class="mCustomScrollbar max-height">
                  <?php $firstJobArr=[]; if($jobList){  
                  foreach($jobList as $key=>$val){ 
                     if($key == 0){
                        $firstJobArr = $val;
                     }
                     if($val['city'] != ''){
                        $citiesArr = explode(",",$val['city']);
                        if(!empty($citiesArr)){
                           $city = $citiesArr[0];
                        }
                     }
                  ?>
                     <div class="job-list-holder open_details whitebg <?php if($key == 0){?>active<?php }?>" data-id="{{$val['id']}}" id="open_details_{{$val['id']}}">
                        <div class="media">
                              <div class="user-img">
                              <?php if($val['company']['profileImage'] != null){?>
                                       <img src="{{asset($val['company']['profileImage']['location'])}}" alt="">
                              <?php }else{ ?>
                                       <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                              <?php }?>
                              </div>
                              <div class="media-body ml-2">
                                 <h3 class="total-title">{{$val['title']}}</h3>
                                 <p class="fixed-icon"><i class="fa fa-building-o" aria-hidden="true"></i>{{$val['company']['company_name']}}</p>
                                 <p class="fixed-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$city}} , {{@$val['postState'][0]['state']['name']}} , {{$val['country']['name']}} </p>
                                 <p class="fixed-icon"><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.START_DATE') }}:  {{date('d.m.Y',strtotime($val['start_date']))}} </p>
                              </div>
                           </div>
                           <!-- <h3 class="total-title mt-3"> Connection Details </h3> -->
                           <div class="connection-details d-flex align-items-center mt-3">
                              <!-- Show latest three in font -->
                              <ul class="connect-list">
                              <?php $result = Helper::connectedFrndsImage($val['company']['company_name']); 
                              if(!empty($result) && ($result->count() > 0)){ 
                              foreach($result as $key=>$value){ //dd($value); 
                              if($key < 3){
                                 if($key == 0){
                                    $cls = 'st';
                                 } else if($key == 1){
                                    $cls = 'nd';
                                 } else if($key == 2){
                                    $cls = 'rd';
                                 }
                                 
                              ?>
                                 <li class="connect-list-img-{{$key+1}}{{$cls}}"> 
                                    <div class="user-img"> 
                                    <?php if($value['user']['profileImage'] != null){?>
                                             <img src="{{asset($value['user']['profileImage']['location'])}}" alt="">
                                    <?php }else{ ?>
                                             <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                    <?php }?>
                                    </div> 
                                 </li>
                              <?php } } }?>
                              </ul>
                              <h5 class="m-0"><?php echo $result->count();?> {{ __('messages.PEOPLE_ARE_CONNECTED') }}</h5>
                           </div>
                           
                     </div>
                     <?php } 
                     echo $jobList->appends(request()->query())->links() ;
                  }?>
                     
                  </div>                               
               </div>
            </div>
            <div class="col-12 col-lg-8 mt-4 mt-lg-0" id="job_details">
               <!-- <div class="details-panel-header"> <h4>Job Details</h4> </div> -->
               <?php if(!empty($firstJobArr)){ ?>
               <div class="job-list-holder whitebg mb-2">
                  <div class="media"> 
                     <div class="media-body">     
                        <h3 class="total-title">{{$firstJobArr['title']}} </h3> 
                        <p class="fixed-icon"><i class="fa fa-building-o" aria-hidden="true"></i>{{$firstJobArr['company']['company_name']}}</p>
                        <p class="fixed-icon"><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.POSTED') }}: {{date('d-m-Y',strtotime($firstJobArr['start_date']))}}</p>
                        <p class="fixed-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$firstJobArr['city']}}, <?php if(!empty($firstJobArr['postState'])){ foreach($firstJobArr['postState'] as $key=>$state){ if($key > 0){ echo ' , ';} echo $state['state']['name'];}}?> , {{$firstJobArr['country']['name']}} </p>
                        <p class="fixed-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($firstJobArr['start_date']) <= $toDay) && (strtotime($firstJobArr['end_date']) >= $toDay)){ echo __('messages.ONGOING');}else if(strtotime($firstJobArr['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($firstJobArr['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?> </p>
                        
                        <ul class="btn-list d-flex list-none">
                           <!--Visible only in case of Candidate and "Apply Through" is set as 'Company Portal'-->
                             <?php if($firstJobArr['applied_by'] == 2){ ?>
                              <?php if($firstJobArr['isApplied'] == null){?>
                              <li> <button class="btn site-btn-color saveJobCls" id="save-job-{{$firstJobArr['id']}}" data-id="{{$firstJobArr['id']}}" data-type="1"> {{ __('messages.SAVE_JOB') }} </button>  </li>
                              <?php }else if(($firstJobArr['isApplied'] != null) && ($firstJobArr['isApplied']['applied_status'] == 0 || $firstJobArr['isApplied']['applied_status'] == 1)){?>
                                 <li> <button class="btn site-btn-color saveJobCls" id="save-job-{{$firstJobArr['id']}}" data-id="{{$firstJobArr['id']}}" data-type="0"> {{ __('messages.SAVED') }} </button>  </li>
                              <?php }?>
                              <?php }?>
                           <!--Apply via MyHR -   Inside MyHR Portal  "Apply Through" is set as 'MyHR' -->
                           <?php if($firstJobArr['applied_by'] == 1){ 
                              if(($firstJobArr['isApplied'] == null) || ($firstJobArr['isApplied']['applied_status'] == 0) || ($firstJobArr['isApplied']['applied_status'] == 1)){?>
                           <li> <a class="btn site-btn-color ml-2" href="{{secure_url('candidate/apply-job/'.encrypt($firstJobArr['id']))}}" > <span class="apply-portal-icon"> <img src="{{asset('frontend/images/logo.png')}}" alt="logo"> </span> {{ __('messages.APPLY_VIA_MYHR') }} </a> </li>
                           <?php }elseif(($firstJobArr['isApplied'] != null) && ($firstJobArr['isApplied']['applied_status'] == 2)){?>
                              <li> <a class="btn site-btn-color ml-2" href="javascript:void(0);" > <span class="apply-portal-icon"> <img src="{{asset('frontend/images/logo.png')}}" alt="logo"> </span> {{ __('messages.APPLIED') }} </a> </li>
                           <?php } }else if($firstJobArr['applied_by'] == 2){?>
                           <!-- Apply via Company - Outside MyHR Portal -->
                           <li> <a class="btn site-btn-color ml-2" href="{{$firstJobArr['website_link']}}" target="_blank"> {{ __('messages.APPLY_VIA_COMPANY_PORTAL') }}</a> </li>
                           <?php }?>
                        </ul>
                     </div>   
                     <div class="dropdown msg-dropdown">
                        <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                           <!--CVisible only in case of Candidate-->
                           <a class="dropdown-item" href="javascript:void(0);" id="share-post-modal-id" data-id="{{$firstJobArr['id']}}">{{ __('messages.SHARE_AS_POST') }}</a>
                           <!--CVisible only in case of Candidate-->
                           <a class="dropdown-item copy_link_id_{{$firstJobArr['id']}}" href="{{url('candidate/view-job-post/'.encrypt($firstJobArr['id']))}}" id="copyButton" data-id="{{$firstJobArr['id']}}">{{ __('messages.COPY_LINK') }}</a>
                           <!--CVisible only in case of Candidate-->
                           <a class="dropdown-item" href="javascript:void(0);" id="report-post-id" data-id="{{$firstJobArr['id']}}">{{ __('messages.REPORT') }}</a>
                        </div>
                     </div>
                  </div>
               </div> 
               <div class="job-list-holder whitebg">  
                  <div class="row">
                     <div class="col-12 col-sm-12 col-md-12">
                        <h3 class="total-title mb-3">{{ __('messages.JOB_DESCRIPTION') }} </h3>
                        <p> {{$firstJobArr['description']}}</p>
                     </div>  
                     <div class="col-12 col-sm-12 col-md-12 mt-3">
                     <ul class="job-dt">
                        <li><span><?php if($firstJobArr['cmsBasicInfo']){ foreach($firstJobArr['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo $val['masterInfo']['name'];} }}?></span></li>
                        <li><span class="btn" style="cursor:default;"><?php if($firstJobArr['cmsBasicInfo']){ foreach($firstJobArr['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo $val['masterInfo']['name'];} }}?></span></li>
                        
                     </ul>
                        <ul class="job-dt flex-wrap" style="display: none;">
                           <li class="w-100 mb-2"><span>Others</span> <span class="ml-3">freelancer</span></li>
                           <li class="w-100"><span class="btn">Others</span> <span class="ml-3">Hourly</span></li> 
                        </ul>
                     </div>
                     <div class="col-12 col-sm-12 col-md-6">
                        <ul class="job-dt">
                           <li><span><?php if($firstJobArr['cmsBasicInfo']){ $i = 0; foreach($firstJobArr['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'language'){ $i++; if($i > 1){ echo ' , '; } echo $val['masterInfo']['name'];} }}?>  </span></li>
                        </ul>
                     </div> 
                     <div class="col-12 col-sm-12 col-md-12">
                        <ul class="skill-tags">
                        <?php if($firstJobArr['selectedSkill']){ foreach($firstJobArr['selectedSkill'] as $key=>$val){?>
                        <li><span>{{$val['skill']['name']}}</span></li>
                        <?php } }?>
                        </ul>
                     </div> 
                     <div class="col-12 col-sm-12 col-md-12">
                        <ul class="job-dt mb-2">
                           <li><p class="mr-2">{{ __('messages.START_DATE') }}: </p><span>{{date('d-m-Y',strtotime($firstJobArr['start_date']))}} </span></li> 
                           <li> - </li>
                           <li><p class="mr-2">{{ __('messages.END_DATE') }}: </p> <span>{{date('d-m-Y',strtotime($firstJobArr['end_date']))}} </span></li>
                        </ul>
                     </div>
                     <div class="col-12 col-sm-12 col-md-12">
                        <ul class="job-dt mb-0 flex-wrap">
                           <li class="w-100 mb-2"><p class="mr-2">{{ __('messages.APPLY_THROUGH') }}: </p> <span><?php if($firstJobArr['applied_by'] == 1){ echo __('messages.MYHR');}else{ echo __('messages.COMPANY_PORTAL');}?> </span></li> 
                           <?php if($firstJobArr['applied_by'] == 2){ ?>
                           <li class="w-100"><p class="mr-2">{{ __('messages.WEBSITE_LINK') }}: </p><span> <a href="{{$firstJobArr['website_link']}}" target="_blank">{{$firstJobArr['website_link']}}</a>  </span></li>
                              <?php }?>
                        </ul>
                     </div> 
                                                                                       
                  </div>   
               </div>
               <?php }?>
            </div> 
            <?php if($jobList->count() == 0){?>
            <div class="col-12">
               <div class="nodata-found-holder">
                  <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
                  <h4>{{ __('messages.SORRY_NO_JOBS_FOUND') }}</h4> 
               </div>
            </div> 
               <?php }?>  
         </div>
      </div>
   </section>
</main>

<script>

$(".js-example-tags").select2({tags: true,width:'100%'});
$(document).ready(function() {
var arrCompany= new Array();

   $.each( companyList, function(key, obj){
         arrCompany.push(obj);
   });
   $( "#company_name" ).autocomplete({
      source: arrCompany
   });
});
</script>
<div class="modal custom-modal profile-modal " id="share-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                  <form id="post_share" action="{{url('/post-share')}}" method="post" >
                     {{ csrf_field() }}
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
                                    @if(!empty($userProfInfo['profileImage']))
                                       <img src="{{ asset($userProfInfo['profileImage']['location']) }}" alt="">
                                    @else
                                       <img src="{{ asset('frontend/images/user.png') }}" alt="">
                                    @endif
                                     
                                     </div>
                                    <div class="media-body">

                                       <?php if(Auth::user()->user_type == 2){?>
                                          <h5 class="post-name">{{Auth::user()->first_name}}</h5>
                                          <p class="post-location"><?php echo Auth::user()->currentCompany['title']; if(Auth::user()->currentCompany['title'] !=''){ echo ' at '. Auth::user()->currentCompany['company_name'];} ?></p>
                                       <?php }else if(Auth::user()->user_type == 3){?>
                                          <h5 class="post-name">{{Auth::user()->company_name}}</h5>
                                          <p class="post-location"><?php echo Auth::user()->profile['business_name']; ?></p>
                                       <?php }?>
                                    </div>
                                 </div>
                                 <div class="post-body">
                                    <input type="hidden" name="post_id" id="post_id" value=""/>
                                    <textarea class="form-control" placeholder="{{ __('messages.WRITE_SOMETHING') }}" name="description"></textarea>
                                 </div>   
                                 <div class="share-post-block post_no_data">
                                    <div class="post-block">
                                       <div class="media">
                                          <div class="user-profile user_profile_id"> <img src="{{asset('frontend/images/user-pro-img.png')}}" alt="user-profile"> </div>
                                          <div class="media-body media_body_id">
                                             <h5 class="post-name">Carolyn Thompson</h5>
                                             <p class="post-location">UI Developer at Unified Infotech</p>
                                          </div>
                                       </div>
                                       <div class="post-body post_body_id">
                                          <img src="{{asset('frontend/images/blog-details-banner.jpg')}}" class="img-fluid">
                                       </div>   
                                       
                                    </div>
                                 </div> 
                                 <div class="text-right mt-3">
                                    <button class="btn site-btn-color">{{ __('messages.SHARE') }}</button>
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

      <!-- Report Modal -->
      <div class="modal custom-modal profile-modal report-modal" id="report-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
               <?php if(Auth::user()->user_type == 2){?>
               <form id="reportPost" action="{{url('/report-post')}}" method="post" >
               <?php }else if(Auth::user()->user_type == 3){?>
                  <form id="reportPost" action="{{url('/report-post')}}" method="post" >
               <?php }?>
                     {{ csrf_field() }}   
                     <input type="hidden" name="post_id" id="post_id" value=""/>                   
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left">{{ __('messages.REPORT') }}</h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label>{{ __('messages.WHY_ARE_YOU_REPORTING') }}</label>
                              <textarea class="form-control" name="comment" id="comment"></textarea>
                           </div>
                        </div>
                        <div class="col-12 ext-left">
                           <button class="btn site-btn-color" type="submit">{{ __('messages.SUBMIT') }}</button>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Report Modal -->
@endsection