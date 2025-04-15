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
                                 <h4 class="page-title">{{ __('messages.MY_JOBS') }}</h4> 
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
                              <div class="input-search">
                                 <div class="form-group required">
                                    <input type="text" class="form-control" placeholder="{{ __('messages.REFERENCE') }}" name="job_id" id="job_id" value="{{@$search['job_id']}}">
                                    <label class="error-position-name" style="display:none;"></label>
                                 </div>   
                                 </div>  
                                 <!-- <div class="input-search">
                                 <div class="form-group required">
                                    <input type="text" class="form-control" placeholder="Position Name *">
                                 </div>  
                                 </div> -->
                                 <?php if(isset($search['position_name']) && $search['position_name'] != ''){
                                    foreach($search['position_name'] as $key=>$value){
                                       if(!in_array($value,$position)){
                                          array_push($position,$value);
                                       }
                                    }
                                    
                                 }?>
                                 <div class="input-search">
                                 <div class="form-group required">
                                    <select name="position_name[]" id="position_name" data-placeholder="{{ __('messages.KEYWORD') }}" id="itskills" class="form-control js-example-tags" multiple="multiple" style="display: none;">
                                       <?php if($position){ 
                                        foreach($position as $key=>$val){  
                                          ?>
                                       <option value="{{$val}}" <?php if((isset($search['position_name'])) && in_array($val,$search['position_name'], TRUE)){ echo 'selected';}?>>{{$val}}</option>
                                       <?php } }?>
                                    </select>
                                    
                                 </div>   
                                 </div>    
                                 
                                 
                                 <div class="input-search">
                                    <div class="form-group  multi-select-states-area">
                                    <select name="state"  id="state" data-placeholder="{{ __('messages.STATE') }}"  class="form-control">
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
                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="{{ __('messages.CITY') }}" name="city" id="city" value="{{@$search['city']}}">
                                    </div>
                                 </div>
                                 <div class="input-search">
                                    <div class="form-group d-flex">
                                    <button class="btn site-btn-color search-job-cls mr-2"> {{ __('messages.SEARCH') }}</button>
                                    <?php if(!empty($search) && (((isset($search['position_name'])) && ($search['position_name'] != '')) || ((isset($search['state'])) && ($search['state'] != '')) || ((isset($search['job_id'])) && ($search['job_id'] != '')))){?>
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
                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="{{ __('messages.CITY') }}" name="city_comp" id="city_comp" value="{{@$search['city_comp']}}">
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
         <?php if($jobList->count() != 0){ if(!empty($search) && (((isset($search['position_name'])) && ($search['position_name'] != '')) || ((isset($search['state'])) && ($search['state'] != '')) || ((isset($search['job_id'])) && ($search['job_id'] != '')) || ((isset($search['company_name'])) && ($search['company_name'] != '')) || ((isset($search['state_comp'])) && ($search['state_comp'] != '')))){?>
            <div class="col-12 col-lg-4 pr-lg-0">
               <!-- <div class="details-panel-header"> <h4>Job List</h4> </div> -->
               <div class=" media align-items-center mb-3 py-3 col-12 whitebg">
                  <div class="media-body">
                     <h4 class="my-0 total-title"><?php echo Auth::user()->first_name;?></h4>
                  </div>  
                  <div class="switch-slider d-flex align-items-center">
                     <p class="mb-0 mr-2">{{ __('messages.JOB_ALERT') }} </p>
                     <label class="switch">
                        <input id="start" type="checkbox" <?php if($jobAlertSetting == 1){ echo 'checked';}?>>
                        <span class="slider round"></span>
                     </label>
                  </div> 
               </div>
            </div>
         <?php } }?>
            <?php if($jobList->count() != 0){?>
                    <!-- /.card-header -->
                    <div class="col-12">
                        <div class="table-responsive job-tbl-cls"> 
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>{{ __('messages.SL_NO') }}</th>
                                        <th>{{ __('messages.REFERENCE') }}</th>
                                        <th>{{ __('messages.TITLE') }}</th>
                                        <th>{{ __('messages.STATE') }}</th>
                                        <th>{{ __('messages.CITY') }}</th>
                                        <th>{{ __('messages.POSITION') }}</th>
                                        <th>{{ __('messages.TYPE') }}</th>
                                        <th>{{ __('messages.START') }}</th>
                                        <th>{{ __('messages.END') }}</th>
                                        <th>{{ __('messages.COMPANY_NAME') }}</th>
                                        <th>{{ __('messages.STATUS') }}</th>
                                        <th>{{ __('messages.ACTION') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lastParam = app('request')->input('page');
                                    if($lastParam == '' || $lastParam == 1){
                                        $i = 0; 
                                    }
                                    else{ 
                                        $i= (($lastParam-1) * env('FRONTEND_PAGINATION_LIMIT'));
                                    } 
                                   foreach($jobList as $key=>$job){ 
                                     $i++ ;
                                     if($job['city'] != ''){
                                       $citiesArr = explode(",",$job['city']);
                                       if(!empty($citiesArr)){
                                          $city = $citiesArr[0];
                                       }
                                    }
                                     ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td>{{$job['job_id']}}</td>
                                        <td>{{$job['title']}}</td>
                                        <td><?php if(count($job['postState']) > 0){ echo $job['postState'][0]['state']['name'];}?></td>
                                        <td>{{$city}}</td>
                                        <td>
                                            <?php 
                                            if($job['cmsBasicInfo']){ 
                                                foreach($job['cmsBasicInfo'] as $key=>$val){
                                                    if($val['type'] == 'seniority'){
                                                        echo $val['masterInfo']['name'];
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        <?php 
                                            if($job['cmsBasicInfo']){ 
                                                foreach($job['cmsBasicInfo'] as $key=>$val){
                                                    if($val['type'] == 'employment_type'){
                                                        echo $val['masterInfo']['name'];
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{date('Y-m-d',strtotime($job['start_date']))}}</td>
                                        <td>{{date('Y-m-d',strtotime($job['end_date']))}}</td>
                                        <td>{{$job['company']['company_name']}}</td>
                                        <td>
                                        <?php $toDay = strtotime(date('Y-m-d')); if((strtotime($job['start_date']) <= $toDay) && (strtotime($job['end_date']) >= $toDay)){ echo __('messages.ONGOING');}else if(strtotime($job['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($job['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?>
                                        </td>
                                       
                                        <td>
                                        
                                        <div class="dropdown">
                                            <button class="btn site-btn-color btn-sm  dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">{{ __('messages.ACTIONS') }} </button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                

                                                    <li><a class="dropdown-item" href="{{url('candidate/view-job-post/'.encrypt($job['id']))}}">{{ __('messages.VIEW') }}</a></li>
                                                    <!--Apply via MyHR -   Inside MyHR Portal  "Apply Through" is set as 'MyHR' -->
                                                   <?php if($job['applied_by'] == 1){ 
                                                      if(($job['isApplied'] == null) || ($job['isApplied']['applied_status'] == 0) || ($job['isApplied']['applied_status'] == 1)){?>
                                                   <li> <a class="dropdown-item" href="{{secure_url('candidate/apply-job/'.encrypt($job['id']))}}" > {{ __('messages.APPLY_VIA_MYHR') }} </a> </li>
                                                   <?php }elseif(($job['isApplied'] != null) && ($job['isApplied']['applied_status'] == 2)){?>
                                                      <li> <a class="dropdown-item" href="javascript:void(0);" > {{ __('messages.APPLIED') }} </a> </li>
                                                   <?php } }else if($job['applied_by'] == 2){?>
                                                   <!-- Apply via Company - Outside MyHR Portal -->
                                                   <li> <a class="dropdown-item" href="{{$job['website_link']}}" target="_blank"> {{ __('messages.APPLY_VIA_COMPANY_PORTAL') }}</a> </li>
                                                   <?php }?>
                                                   <?php if($job['applied_by'] == 2){ ?>
                                                   <?php if($job['isApplied'] == null){?>
                                                   <li> <a class="dropdown-item saveJobCls" href="javascript:void(0);" id="save-job-{{$job['id']}}" data-id="{{$job['id']}}" data-type="1"> {{ __('messages.SAVE_JOB') }} </a>  </li>
                                                   <?php }else if(($job['isApplied'] != null) && ($job['isApplied']['applied_status'] == 0 || $job['isApplied']['applied_status'] == 1)){?>
                                                      <li> <a class="dropdown-item saveJobCls" href="javascript:void(0);" id="save-job-{{$job['id']}}" data-id="{{$job['id']}}" data-type="0"> {{ __('messages.SAVED') }} </a>  </li>
                                                   <?php }?>
                                                   <?php }?>
                                                   <li>
                                                   <a class="dropdown-item" href="javascript:void(0);" id="share-post-modal-id" data-id="{{$job['id']}}">{{ __('messages.SHARE_AS_POST') }}</a>
                                                   </li>
                                                   <li>
                                                   <a class="dropdown-item copy_link_id_{{$job['id']}}" href="{{url('candidate/view-job-post/'.encrypt($job['id']))}}" id="copyButton" data-id="{{$job['id']}}">{{ __('messages.COPY_LINK') }}</a>
                                                   </li>
                                                   <li>
                                                   <a class="dropdown-item" href="javascript:void(0);" id="report-post-id" data-id="{{$job['id']}}">{{ __('messages.REPORT') }}</a>
                                                   </li>
                                                </ul>
                                        </div>
                                        </td>
                                    </tr>
                                          <?php }?>
                                </tbody>   
                            </table>
                       </div>  
                    </div>
                    <div class="col-12 col-md-4 order-2 order-md-1"></div>
                     <div class="col-12 col-md-8 order-1 order-md-2 myjob-list">
                           <?php $lastParam = app('request')->input('page');
                                    if($lastParam == '' || $lastParam == 1){
                                       $i = 0; 
                                    }
                                    else{ 
                                       $i= (($lastParam-1) * env('FRONTEND_PAGINATION_LIMIT'));
                                    } 
                                 foreach($jobList as $key=>$job){ 
                                    $i++ ;
                                    if($job['city'] != ''){
                                       $citiesArr = explode(",",$job['city']);
                                       if(!empty($citiesArr)){
                                          $city = $citiesArr[0];
                                       }
                                    }
                                    ?>
                                 <div class="media">
                                    <div class="media-body">
                                       <h4 class="position-name">
                                          <?php 
                                                if($job['cmsBasicInfo']){ 
                                                      foreach($job['cmsBasicInfo'] as $key=>$val){
                                                         if($val['type'] == 'seniority'){
                                                            echo $val['masterInfo']['name'];
                                                         }
                                                      }
                                                }
                                                ?>
                                       </h4>
                                       <h5 class="company-name">
                                       {{$job['company']['company_name']}}
                                       </h5>
                                       <ul class="joblistcitydate">
                                          <li><i class="fa fa-calendar" aria-hidden="true"></i>{{date('Y-m-d',strtotime($job['start_date']))}}</li>
                                          <li><i class="fa fa-map-marker" aria-hidden="true"></i>{{$city}}</li>
                                       </ul>   
                                       
                                    </div>
                                    <div class="media-img-holder">
                                       <img src="{{ asset('frontend/images/fvg-logo.png') }}" alt="Logo" class="img-fluid">
                                    </div>
                                 </div> 
                           <?php }?>
                     </div> 
                    
                    <!-- /.card-body -->

                    <div class="col-12 mt-3">
                    <?php echo $jobList->appends(request()->query())->links() ;?>
                    </div>
                     <?php }?>
                  
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