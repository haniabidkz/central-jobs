<script src="{{ asset('frontend/js/job.js')}}"></script>
<div class="job-list-holder whitebg mb-2">
                  <div class="media"> 
                     <div class="media-body">     
                        <h3 class="total-title">{{$firstJobArr['title']}} </h3> 
                        <p><i class="fa fa-building-o" aria-hidden="true"></i>{{$firstJobArr['company']['company_name']}}</p>
                        <p><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.POSTED') }}: {{date('d-m-Y',strtotime($firstJobArr['start_date']))}}</p>
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$firstJobArr['city']}}, <?php if(!empty($firstJobArr['postState'])){ foreach($firstJobArr['postState'] as $key=>$state){ if($key > 0){ echo ' , ';} echo $state['state']['name'];}}?> , {{$firstJobArr['country']['name']}} </p>
                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($firstJobArr['start_date']) <= $toDay) && (strtotime($firstJobArr['end_date']) >= $toDay)){ echo __('messages.ONGOING');}else if(strtotime($firstJobArr['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($firstJobArr['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?> </p>
                        
                        <ul class="btn-list d-flex list-none">
                           <!--Visible only in case of Candidate and "Apply Through" is set as 'Company Portal'-->
                           <?php if($firstJobArr['applied_by'] == 2){ ?>
                              <?php if($firstJobArr['isApplied'] == null){?>
                              <li> <button class="btn site-btn-color saveJobCls" id="save-job-{{$firstJobArr['id']}}" data-id="{{$firstJobArr['id']}}" data-type="1"> {{ __('messages.SAVE_JOB') }} </button>  </li>
                              <?php }else if(($firstJobArr['isApplied'] != null) && ($firstJobArr['isApplied']['applied_status'] == 0 || $firstJobArr['isApplied']['applied_status'] == 1)){?>
                                 <li> <button class="btn site-btn-color saveJobCls" id="save-job-{{$firstJobArr['id']}}" data-id="{{$firstJobArr['id']}}" data-type="0"> {{ __('messages.SAVED') }} </button>  </li>
                              <?php } }?>
                           <?php if($firstJobArr['applied_by'] == 1){ 
                              if(($firstJobArr['isApplied'] == null) || ($firstJobArr['isApplied']['applied_status'] == 0) || ($firstJobArr['isApplied']['applied_status'] == 1)){?>
                           <li> <a class="btn site-btn-color ml-2" href="{{url('candidate/apply-job/'.encrypt($firstJobArr['id']))}}" > <span class="apply-portal-icon"> <img src="{{asset('frontend/images/logo.png')}}" alt="logo"> </span> {{ __('messages.APPLY_VIA_MYHR') }} </a> </li>
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
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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