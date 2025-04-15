@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{ asset('frontend/js/job.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<main>
<section class="section section-myjob">
<div class="container">
   <div class="row">
      <div class="col-12">
         <form>
            <div class="section-myprofile">
               <div class="login-form">
                  <div class="row mb-4">
                     <div class="col-12 col-sm-8">
                        <h4 class="page-title">{{ __('messages.SEARCH_PREVIOUS_JOB_POST_HERE') }}</h4> 
                     </div>
                     <div class="col-12 col-sm-4 text-sm-right">
                        <?php if(Auth::user()->user_type == 3){?>
                        <a class="btn site-btn-color" href="{{ url('company/post-job') }}">{{ __('messages.POST_JOB') }}</a>
                        <?php }?>
                     </div>
                  </div>
                  <form id="search-job" action="{{ url('company/my-jobs') }}" method="post">
                  {{csrf_field()}}
                  <div class="row">   
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <div class="select-dat">
                              <input type="text" class="form-control" placeholder="{{ __('messages.START_DATE') }}" id="start_date" name="start_date" autocomplete="off" value="{{@$search['start_date']}}">
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <div class="select-dat">
                                 <input type="text" class="form-control" placeholder="{{ __('messages.END_DATE') }}" id="end_date" name="end_date" autocomplete="off" value="{{@$search['end_date']}}">
                                 <label class="error error-end-date" style="display:none;"></label>
                           </div>
                        </div>   
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <input type="text" class="form-control" placeholder="{{ __('messages.POSITION_NAME') }}" id="title" name="title" value="{{@$search['title']}}">
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group required">
                           <select class="form-control" name="country_id" id="country_id_search">
                           <option value=""> {{ __('messages.COUNTRY') }} *</option>
                           <?php if($countries){
                              foreach($countries as $key=>$val){
                              ?>
                           <option value="{{$val['id']}}" <?php if($val['id'] == $selectedCountry){ echo 'selected';} ?>>{{$val['name']}}</option>
                           <?php } }?>
                           </select>
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group  multi-select-states-area required">
                           <select name="state"  id="state" class="form-control">
                           <option value="">{{ __('messages.STATE') }} </option>
                           <?php if($states){
                                 foreach ($states as $key => $value) {
                                 ?>
                                 <option value="{{$value['id']}}" <?php if($value['id'] == @$search['state']){ echo 'selected';} ?>>{{$value['name']}}</option>
                                 <?php } } ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group required">
                           <input type="text" class="form-control" placeholder="{{ __('messages.JOB_ID') }}" name="job_id" id="job_id" value="{{@$search['job_id']}}">
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <select class="form-control" name="status" id="status">
                              <option value=""> {{ __('messages.STATUS') }}</option>
                              <option value="1" <?php if(@$search['status'] == 1){ echo 'selected';}?>>{{ __('messages.ONGOING') }}</option>
                              <option value="2" <?php if(@$search['status'] == 2){ echo 'selected';}?>>{{ __('messages.CLOSED') }}</option>
                              <option value="3" <?php if(@$search['status'] == 3){ echo 'selected';}?>>{{ __('messages.PENDING_PUBLICATION') }}</option>
                           </select>
                           <label class="error error-required-search" style="display:none;"></label>
                        </div>
                     </div> 
                     <div class="col-12">
                        <div class="form-group d-flex">
                           <button class="site-btn btn search-cls mr-2" type="submit">{{ __('messages.SEARCH') }}</button>
                           <?php $searchCop = $search ; if(!empty($searchCop) && (isset($searchCop['_token']) && $searchCop['_token'] != '') ){?>
                           <a class="btn site-btn-color" href="{{ url('company/my-jobs') }}"><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                           <?php } ?>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="row">
      <div class="col-12 col-lg-4 pr-lg-0">
         <div class="job-list-page">
            <div class="mCustomScrollbar max-height">
               <?php $firstJobArr=[]; if($jobList){ 
                  foreach($jobList as $key=>$val){ if($key == 0){ 
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
                     <h6>{{$val['job_id']}}</h6>
                     <h3 class="total-title">{{$val['title']}}</h3>
                     <p class="fixed-icon"><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.PUBLISH_DATE') }}: {{date('d-m-Y',strtotime($val['start_date']))}}</p>
                     <p class="fixed-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$city}}, {{@$val['postState'][0]['state']['name']}} , {{$val['country']['name']}} </p>
                     <p class="fixed-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($val['start_date']) <= $toDay) && (strtotime($val['end_date']) >= $toDay)){ echo __('messages.ONGOING');}else if(strtotime($val['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($val['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?></p>
                     <h5 class="h5-title">{{ __('messages.TOTAL_APPLICANT') }} : <span> <?php  $result = Helper::getAppliedCandidateCount($val['id']); echo $result;?></span></h5>
                     <a href="{{ url('company/applied-candidates/'.encrypt($val['id'])) }}" class="apply-btn">{{ __('messages.VIEW_APPLICANT') }} </a>
               </div>
                  <?php } 
                  echo $jobList->appends(request()->query())->links() ;
               }?>
            </div>                               
         </div>
      </div>
               
      <div class="col-12 col-lg-8 mt-4 mt-lg-0" id="job_details">
         <?php if(!empty($firstJobArr)){ //echo '<pre>'; print_r($firstJobArr['postState'][0]['state']['name']); exit;?> 
            <!-- <div class="details-panel-header"> <h4>Job Details</h4> </div> -->
            <div class="job-list-holder whitebg mb-2">
               <div class="media"> 
                  <div class="media-body">     
                     <h3 class="total-title">{{$firstJobArr['title']}} </h3> 
                     <p class="fixed-icon"><i class="fa fa-building-o" aria-hidden="true"></i>{{$company}}</p>
                     <p class="fixed-icon"><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.PUBLISH_DATE') }}: {{date('d-m-Y',strtotime($firstJobArr['start_date']))}}</p>
                     <p class="fixed-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$firstJobArr['city']}}, <?php if(!empty($firstJobArr['postState'])){ foreach($firstJobArr['postState'] as $key=>$state){ if($key > 0){ echo ' , ';} echo $state['state']['name'];}}?> , {{$firstJobArr['country']['name']}} </p>
                     <p class="fixed-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($firstJobArr['start_date']) <= $toDay) && (strtotime($firstJobArr['end_date']) >= $toDay)){ echo __('messages.ONGOING');}else if(strtotime($firstJobArr['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($firstJobArr['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?></p>
                     <ul class="btn-list d-flex list-none">
                        <li> <a class="btn site-btn-color ml-2" href="{{ url('company/applied-candidates/'.encrypt($firstJobArr['id'])) }}"> {{ __('messages.VIEW_APPLICANT') }} </a> </li>
                     </ul>
                  </div> 
                  <?php  $result = Helper::getAppliedCandidateCount($firstJobArr['id']); if($result == 0){?>  
                  <div class="dropdown msg-dropdown">
                     <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-ellipsis-v"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <!--CVisible only in case of Employerqqqqqqqqqqqq-->
                        <a class="dropdown-item" href="{{url('company/edit-job/'.encrypt($firstJobArr['id']))}}">{{ __('messages.EDIT') }}</a>
                     </div>
                  </div>
                  <?php }?>
               </div>
            </div> 
            <div class="job-list-holder whitebg">  
               <div class="row">
                  <div class="col-12">
                     <h3 class="total-title mb-3">{{ __('messages.JOB_DESCRIPTION') }} </h3>
                     <p> {{$firstJobArr['description']}}</p>
                  </div>  
                  <div class="col-12 mt-3">
                     <ul class="job-dt">
                        <li><span><?php if($firstJobArr['cmsBasicInfo']){ foreach($firstJobArr['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'seniority'){ echo $val['masterInfo']['name'];} }}?></span></li>
                        <li><span class="btn" style="cursor:default;"><?php if($firstJobArr['cmsBasicInfo']){ foreach($firstJobArr['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'employment_type'){ echo $val['masterInfo']['name'];} }}?></span></li>
                        
                     </ul>
                     <!-- If select Others -div should be display: block -->
                     <ul class="job-dt flex-wrap" style="display: none;" >
                        <li class="w-100 mb-2"><span>Others</span> <span class="ml-3">freelancer</span></li>
                        <li class="w-100"><span class="btn">Others</span> <span class="ml-3">Hourly</span></li> 
                     </ul>
                     
                  </div>
                  <div class="col-12 col-md-6">
                     <ul class="job-dt">
                        <li><span><?php if($firstJobArr['cmsBasicInfo']){ $i = 0; foreach($firstJobArr['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'language'){ $i++; if($i > 1){ echo ' , '; } echo $val['masterInfo']['name'];} }}?>  </span></li>
                     </ul>
                  </div> 
                  <div class="col-12">
                     <ul class="skill-tags">
                        <?php if($firstJobArr['selectedSkill']){ foreach($firstJobArr['selectedSkill'] as $key=>$val){?>
                        <li><span>{{$val['skill']['name']}}</span></li>
                        <?php } }?>
                     </ul>
                  </div> 
                  <!-- Specific Question : Should not be displayed in case user type is Candidate -->
                  <div class="col-12">
                     <p>{{ __('messages.SPECIFIC_QUESTION') }}: </p> 
                     <?php $serial = 0; if($firstJobArr['questions']){ 
                        foreach($firstJobArr['questions'] as $key=>$val){
                           if($val['type'] == 1){ $serial++?>
                     <h5 class="h5-title">{{$serial}}. {{$val['question']}}</h5>
                     <?php } } }if($serial == 0){?>
                        <h5 class="h5-title">N/A</h5>
                     <?php }?>
                  </div> 
                  <!-- Should not be displayed in case user type is Candidate -->
                  <div class="col-12 mb-3">
                     
                     <p>{{ __('messages.INTERVIEW_QUESTIONS') }}:</p>
                     <?php $serial1 = 0; if($firstJobArr['questions']){ 
                        foreach($firstJobArr['questions'] as $key=>$val){
                           if($val['type'] == 2){ $serial1++?>
                     <h5 class="h5-title">{{$serial1}}. {{$val['question']}}</h5>
                     <?php } } }if($serial1 == 0){?>
                        <h5 class="h5-title">N/A</h5>
                     <?php }?>
                  </div>
                  <div class="col-12">
                     <ul class="job-dt mb-2">
                        <li><p class="mr-2">{{ __('messages.START_DATE') }}: </p><span>{{date('d-m-Y',strtotime($firstJobArr['start_date']))}} </span></li> 
                        <li> - </li>
                        <li><p class="mr-2">{{ __('messages.END_DATE') }}: </p> <span>{{date('d-m-Y',strtotime($firstJobArr['end_date']))}} </span></li>
                     </ul>
                  </div>
                  <div class="col-12">
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
$(".multiple-select select.multi-select-states").bsMultiSelect();
$(document).ready(function() {
   $( "#start_date" ).datepicker({
         dateFormat: "yy-mm-dd",
         //maxDate: '0',
         onSelect: function(selected) {
         $("#end_date").datepicker("option","minDate", selected)
      }
   });
      
   $('#end_date').datepicker({
         dateFormat: "yy-mm-dd",
         //maxDate: '0',
         onSelect: function(selected) {
         $("#start_date").datepicker("option","maxDate", selected)
         }
   });
});
</script>
@endsection