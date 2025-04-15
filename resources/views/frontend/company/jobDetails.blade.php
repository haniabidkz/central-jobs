<div class="job-list-holder whitebg mb-2">
   <div class="media"> 
      <div class="media-body">     
         <h3 class="total-title">{{$firstJobArr['title']}} </h3> 
         <p><i class="fa fa-building-o" aria-hidden="true"></i>{{$company}}</p>
         <p><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.PUBLISH_DATE') }}: {{date('d-m-Y',strtotime($firstJobArr['start_date']))}}</p>
         <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$firstJobArr['city']}}, <?php if(!empty($firstJobArr['postState'])){ foreach($firstJobArr['postState'] as $key=>$state){ if($key > 0){ echo ' , ';} echo $state['state']['name'];}}?> , {{$firstJobArr['country']['name']}} </p>
         <p><i class="fa fa-clock-o" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($firstJobArr['start_date']) <= $toDay) && (strtotime($firstJobArr['end_date']) >= $toDay)){ echo __('messages.ONGOING');}else if(strtotime($firstJobArr['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($firstJobArr['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?></p>
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
         <p> {{strip_tags($firstJobArr['description'])}}</p>
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