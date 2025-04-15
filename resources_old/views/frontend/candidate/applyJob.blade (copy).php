@extends('layouts.app_after_login_layout')
@section('content')
<script type="text/javascript"> var introVideoData1;var introVideoData2; var introVideoData3; var videoExist; var validationCount1 = 0; 
   var validationCount2 = 0; 
   var validationCount3 = 0;
   var chkCameraOnOff1 = 0; 
   var chkCameraOnOff2 = 0; 
   var chkCameraOnOff3 = 0; 
   var QUESTION_READING_TIME = 60;  //second
   var INTERVIEW_DURATION = 240;//second
   var startVideRrcd1 = 0;
   var startVideRrcd2 = 0;
   var startVideRrcd3 = 0;
   var AuthUser = '<?php echo Auth::user()->id;?>';
   var jobId = '<?php echo $jobId; ?>';
  
   function lanFilter(str){
      // console.log('str1');
      // console.log(str);
      // console.log('str');
      var res = str.split("|");
      if(res[1] != undefined){
         str = str.replace("|","'");
         return str;
      }else{
         return str;
      }
      
   }
</script>
<script src="{{asset('frontend/js/applyJob.js')}}"></script>
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Js Video Livrary Done By Israfil -->

<link href="{{asset('frontend/jsvideo/video-js.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontend/jsvideo/videojs.record.min.css')}}" rel="stylesheet">
  <!-- <link href="{{asset('frontend/jsvideo/examples.css')}}" rel="stylesheet"> -->

  <script src="{{asset('frontend/jsvideo/video.min.js')}}"></script>
  <script src="{{asset('frontend/jsvideo/RecordRTC.js')}}"></script>
  <script src="{{asset('frontend/jsvideo/adapter.js')}}"></script>

  <script src="{{asset('frontend/jsvideo/videojs.record.min.js')}}"></script>

  <script src="{{asset('frontend/jsvideo/browser-workarounds.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-webcam/1.0.0/jquery.webcam.min.js"></script>
  
  <!-- End Js video library section -->
  
<main>

<?php //SET SPECIFIC QUESTIONS , ID AND ANSWER IF AVAILBLE

      //IF ANSWER AVAILABLE
      $specificAns['answer'] = [];
      $specificAns['id'] = [] ;
      if(!empty($appliedAnswer)){
         foreach($appliedAnswer as $key=>$val){
            array_push($specificAns['answer'],$val['answer']);
            array_push($specificAns['id'],$val['job_post_specific_questions_id']);
         }
      }

      //SET QUESTIONS
      $specificQuestion['question'] = [] ;
      $specificQuestion['id'] = [] ;
      $specificQuestion['answer'] = [] ;

      //SET INTERVIEW VIDEO QUESTION
      $interviewQuestion['question'] = [] ;
      $interviewQuestion['id'] = [] ;
      $interviewQuestion['interviewVideo'] = [] ;
      $interviewQuestion['mandetory_setting'] = 0;


      //IF VIDEO ANSWER AVAILABLE
      $interviewAns['interviewVideo'] = [];
      $interviewAns['id'] = [] ;
      
      if(!empty($appliedVideoAnswer)){
         foreach($appliedVideoAnswer as $key=>$val){
            array_push($interviewAns['interviewVideo'],$val['upload']['location']);
            array_push($interviewAns['id'],$val['job_post_specific_questions_id']);
         }
      }

      if(!empty($jobDetails['questions'])){
         foreach($jobDetails['questions'] as $key=>$val){
            //SET SPECIFIC QUESTION
            if($val['type'] == 1){
               array_push($specificQuestion['question'],$val['question']);
               array_push($specificQuestion['id'],$val['id']);

               //IF ANSWER AVAILABLE
               if(!empty($specificAns)){
                  foreach($specificAns['id'] as $key1=>$val1){
                     if($val['id'] == $val1){
                        $specificQuestion['answer'][$key] = $specificAns['answer'][$key1];
                     }
                  }

               }
               
            }
            //SET INTERVIEW VIDEO QUESTION
            if($val['type'] == 2){
               array_push($interviewQuestion['question'],$val['question']);
               array_push($interviewQuestion['id'],$val['id']);
               $interviewQuestion['mandetory_setting'] = $val['mandatory_setting'];
               // 0->None of them are mandatory, 1->All are mandatory, 2->Any one is mandatory, 3->Any two are mandatory

               //IF VIDEO ANSWER AVAILABLE
               if(!empty($interviewAns)){
                  //dd($interviewAns);
                  foreach($interviewAns['id'] as $key2=>$val2){
                     if($val['id'] == $val2){
                     $interviewQuestion['interviewVideo'][$val2] = $interviewAns['interviewVideo'][$key2];
                     }
                  }

               }
            }
         }
      } 
      //SET SPECIFIC QUESTIONS , ID AND ANSWER IF AVAILBLE
      
      $videoCount = count($interviewQuestion['question']);
      $videoExsistCount = count($interviewQuestion['interviewVideo']);
      $mandetory = '';
      $mandatoryset = 0;
      if($interviewQuestion['mandetory_setting'] == 0){
         $interviewQuestion['mandetory_setting'] = 0;
         $mandetory = "None of questions are mandatory";
         $mandatoryset = 0;
      }else if($interviewQuestion['mandetory_setting'] == 1){
         $interviewQuestion['mandetory_setting'] = $videoCount;
         $mandetory = "All questions are mandatory";
         $mandatoryset = 1;
      }else if($interviewQuestion['mandetory_setting'] == 2){
         $interviewQuestion['mandetory_setting'] = 1;
         $mandetory = "Any one question is mandatory";
         $mandatoryset = 2;
      }else if($interviewQuestion['mandetory_setting'] == 3){
         $interviewQuestion['mandetory_setting'] = 2;
         $mandetory = "Any two questions are mandatory";
         $mandatoryset = 3;
      }
      
      // 0->None of them are mandatory, 1->All are mandatory, 2->Any one is mandatory, 3->Any two are mandatory
      //dd($videoExsistCount); 
     // dd($appliedVideoAnswerAttempt);
      $attemptArr = [];
      if(!empty($interviewQuestion['id'])){
        foreach($interviewQuestion['id'] as $key=>$val){
          $attemptArr[$val] = [];
          if(!empty($appliedVideoAnswerAttempt)){
             foreach($appliedVideoAnswerAttempt as $key1=>$val1){
                      if($val == $val1['question_id']){
                          array_push($attemptArr[$val], $val1);
                      }
            }
          }
            
        }
      }
      $jobAppliedId =  $appliedJob['job_applied_id'];
      //dd($attemptArr);
      ?>

               <section class="section section-applyjob">
                  <div class="container">
                    <div class="row">
                      <div class="col-12"> 
                        <div class="section-myprofile">
                          <div class="col-sm-12 mb-5 details-panel-header">
                              <h3 class="text-center font-22 mt-0 ">{{__('messages.APPLY_TO')}} {{$companyName}}</h3>
                          </div>
                          <form id="step_one" action="" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <div class="login-form" id="apply-job-company"> 
                          <input name="job_applied_id" id="job_applied_id" value="{{$jobAppliedId}}" type="hidden"/>
                          <input name="job_id" id="job_id" value="{{$jobId}}" type="hidden"/>
                             <div class="row">
                                <div class="col-sm-12 col-xl-6 apply-job-holder">
                                   <div class="media">
                                       <div class="user-img">
                                       <?php if($candidateDetails['profileImage'] != null){?>
                                       <img src="{{asset($candidateDetails['profileImage']['location'])}}" alt="" class="mCS_img_loaded">
                                       <?php }else{ ?>
                                                <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="" class="mCS_img_loaded">
                                       <?php }?>
                                          <!-- <img src="images/resources/s1.png" alt="" class="mCS_img_loaded"> -->
                                       </div> 
                                       <?php 
                                       if($appliedJob['user_phone'] != ''){
                                          $phone = $appliedJob['user_phone'];
                                       }else if($candidateDetails['telephone'] != ''){
                                          $phone = $candidateDetails['telephone'];
                                       }else{
                                          $phone = '';
                                       }
                                       ?>  
                                       <div class="media-body text-left ml-2">
                                          <h5 class="total-sub-title-black text-left mt-0">{{$candidateDetails['first_name']}}</h5>
                                          <p>{{$currentJobTitle}} <?php if($currentJobTitle != ''){ echo 'at';} ?> {{$currentCompany}}</p>
                                          <?php if(($candidateDetails['city']['name'] != '') || ($candidateDetails['state']['name'] != '') || ($candidateDetails['country']['name'] != '')){?>
                                          <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php if($candidateDetails['city']['name'] != ''){ echo $candidateDetails['city']['name'].' , ';} if($candidateDetails['state']['name'] != ''){ echo $candidateDetails['state']['name'].' , ';} if($candidateDetails['country']['name'] != ''){ echo $candidateDetails['country']['name'];}?> </p>
                                          <?php }?>
                                          <p><i class="fa fa-envelope-o" aria-hidden="true"></i> {{$candidateDetails['email']}} </p>
                                          <p><i class="fa fa-phone" aria-hidden="true"></i> <span class="show-phn"> <?php echo ($appliedJob['user_phone']?$appliedJob['user_phone']:$candidateDetails['telephone']);?> </span>
                                            <button class="download-btn edit-site-btn phone-edit"> <i class="fa fa-pencil" aria-hidden="true"></i> </button> </p>
                                          <div class="max-60 mt-2 d-none phone-edit-open">
                                            <div class="form-group">
                                               <input type="text" class="form-control" placeholder="{{__('messages.PHONE_NO')}}" name="phone" id="phone" value="<?php echo ($appliedJob['user_phone']?$appliedJob['user_phone']:$candidateDetails['telephone']);?>">
                                            </div>
                                          </div> 
                                          <p class="phn-rqrd error"></p>  
                                          <p><i class="fa fa-map-marker" aria-hidden="true"></i> {{__('messages.LOCATION_APPLY_FOR')}} : <?php echo ($appliedJob['user_city']?$appliedJob['user_city']:''); if($appliedJob['user_city'] != ''){ echo ' , ';}?> <?php echo ($appliedJob['state']['name']?$appliedJob['state']['name']:''); if($appliedJob['state']['name'] != ''){ echo ' , ';}?>  <?php echo ($appliedJob['country']['name']?$appliedJob['country']['name']:'');?> <button class="download-btn edit-site-btn location-edit"> <i class="fa fa-pencil" aria-hidden="true"></i> </button></p>
                                          <div class="max-60 mt-2 d-none location-edit-open">
                                            <div class="form-group">
                                            <input type="hidden" name="country" value="{{$selectedCountry}}"/>
                                               <select class="form-control" name="country" id="country" disabled>
                                                  <option value=""> {{__('messages.COUNTRY')}} *</option>
                                                  <?php foreach($countries as $key=>$val){?>
                                                  <option value="{{$val['id']}}" <?php if($val['id'] == $selectedCountry){ echo 'selected';}?>>{{$val['name']}}</option>
                                                  <?php }?>
                                               </select>
                                            </div>
                                            <div class="form-group">
                                               <select class="form-control select-states-area" name="state" id="state">
                                                  <option value=""> {{__('messages.STATE')}} *</option>
                                                  <?php foreach($states as $key=>$val){?>
                                                  <option value="{{$val['state_id']}}" <?php if($val['state_id'] == $selectedState){ echo 'selected';}?>>{{$val['state']['name']}}</option>
                                                  <?php }?>
                                               </select>
                                            </div>
                                            <div class="form-group">
                                              <input class="form-control select-city-area" name="city" id="city" value="{{$jobDetails['city']}}" disabled/>
                                              <input type="hidden" class="form-control select-city-area" name="city" id="city" value="{{$jobDetails['city']}}"/>  
                                            </div>
                                          </div>  
                                          <!-- <p> {{__('messages.RESUME')}} <a class="download-btn" <?php //if($candidateDetails['uploadedCV']['location'] != ''){?> href="{{asset($candidateDetails['uploadedCV']['location'])}}"<?php //}else{?> href="javascript:void(0);"<?php //}?>download><i class="fa fa-download" aria-hidden="true"></i></a> <button class="download-btn edit-site-btn btn cv-upload" > <i class="fa fa-pencil" aria-hidden="true"></i> </button> </p>
                                          <div class="max-60 mt-2 d-none cv-upload-open">
                                             <div class="custom-inputfile"> 
                                                <input type="hidden" id="oldfile" name="oldfile" value="<?php //echo ($candidateDetails['uploadedCV']['name']?$candidateDetails['uploadedCV']['name']:'') ;?>">            
                                               <input class="cv_file_upload" type="file" id="file" name="file" value="<?php //echo ($candidateDetails['uploadedCV']['name']?$candidateDetails['uploadedCV']['name']:'') ;?>">
                                               <label for="file"><i class="fa fa-cloud-upload mr-2" aria-hidden="true"></i>
                                               {{__('messages.UPDATE_CV')}}</label>  </br>
                                             </div>
                                          </div> -->
                                             <!-- <div class="cv-upload-section-func" style="display: none;">
                              
                                                   <div class="cv-holder">
                                                      <a href="#">
                                                         <img src="<?php //echo url('/');?>/frontend/images/document.png" alt="" class="cv">
                                                      </a>    
                                                   </div>
                                                   <div class="media file-name-image mb-3" style="display: none;">
                                                      <span class="mr-1"> <i class="la la-file-alt"></i> 
                                                         
                                                         <i class="la la-file-pdf d-none"></i>
                                                         <i class="la la-file-word d-none"></i>
                                                      </span>
                                                      <div class="cv-name-func"><p></p></div>
                                                   </div>
                                             </div>
                                             <?php // if($candidateDetails['uploadedCV']['location'] != ''){?>
                                             <p class="old-cv"> {{$candidateDetails['uploadedCV']['org_name']}} </p>
                                             <?php //}?>
                                             <p style="display: none;" class="error upload-error-n"> Error Message </p> -->
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-6">
                                  <div class="intro-video video-div-available">
                                    @if(!empty($candidateDetails['introVideo']))
                                  <video   controls class="video-js vjs-default-skin" >
                                          
                                                 <source src="{{asset($candidateDetails['introVideo']['location'])}}" type="video/mp4">
                                           
                                       </video>  
                                    @else
                                                 <p>{{__('messages.NO_VIDEO_AVAILABLE')}}</p>
                                           @endif 
                                  </div>
                                </div>
                             </div>
                             <div class="row mt-4">
                                <div class="col-sm-12  text-center">
                               
                                <button class="btn site-btn-color apply-step-one" id="save-as-draft" type="button">{{__('messages.SAVE_AS_DRAFT')}}</button>
                                <?php if($jobDetails['questions']->count() == 0){?>
                                 <button class="btn site-btn-color apply-cls" id="nextbtn-cncl" type="button">{{__('messages.APPLY')}}</button>
                                <?php }else{?>
                                <button class="btn site-btn-color rmv-cls-next" id="<?php if(count($specificQuestion['question']) > 0){?>nextbtn<?php }else{?>nextbtn2<?php }?>" type="button">{{__('messages.NEXT')}}</button>
                                <?php }?>
                                </div>   
                             </div>
                             
                          </div> 
                           <?php
                           if(!empty($specificQuestion['question'])){ ?>
                          <div class="login-form" id="next-specific-qus"> 
                             <div class="row">
                                <div class="col-sm-12 details-panel-header">
                                   <h4>{{__('messages.SPECIFIC_QUESTION')}}: </h4><p>({{__('messages.APPLY_JOB_SPECIFIC_QUESTION_TEXT')}})</p>
                                </div>
                                <div class="col-12">
                                    <div class="interview-question-holder">
                                    <?php foreach($specificQuestion['question'] as $key=>$val){?>
                                       <div class="form-group">
                                           <label class="question-label">{{$key+1}}.{{$val}}</label>
                                           <input type="hidden" name="question_id_{{$key+1}}" value="{{$specificQuestion['id'][$key]}}"/>
                                           <textarea class="form-control"  placeholder="Ans:" name="answer_{{$key+1}}">{{@$specificQuestion['answer'][$key]}}</textarea>
                                       </div>
                                    <?php }?>
                                    </div>
                                </div>
                             </div>
                             <div class="row  mt-4">
                                <div class="col-12  text-center">
                                
                                  <button class="btn site-btn-color" id="prevbtn" type="button">{{__('messages.PREV')}}</button>
                                  <button class="btn site-btn-color apply-step-two" id="save-as-draft" type="button">{{__('messages.SAVE_AS_DRAFT')}}</button>
                                  <?php if(!empty($interviewQuestion['question'])){ ?>   
                                  <button class="btn site-btn-color" id="nextbtn2" type="button">{{__('messages.NEXT')}}</button>
                                  <?php }else{?>
                                    <button class="btn site-btn-color apply-cls" id="nextbtn2-cncl" type="button">{{__('messages.APPLY')}}</button>
                                  <?php }?>
                                </div>
                             </div>
                             
                          </div>    
                           <?php }
                           if(!empty($interviewQuestion['question'])){ //dd($interviewQuestion['question']);?>           
                          <div class="login-form" id="next-interview-qus"> 
                             <div class="row">
                                <div class="col-sm-12 details-panel-header">
                                   <h4 class="mb-4">{{__('messages.INTERVIEW_QUESTIONS')}}:</h4>
                                   <h5 class="total-title">{{__('messages.PAY_ATTENTION_THIS_COMPANY_REQUESTED')}}  "{{$mandetory}}"</h5>
                                   <h5 class="form-sub-heading"><i>"{{__('messages.TO_ANSWER_AN_INTERVIEW_QUESTION_YOU_NEED_TO_ACTIVATE_THE_QUESTION')}}" </i><a class="ml-2" data-toggle="modal" data-target="#tips-interview"><i class="fa fa-question-circle" aria-hidden="true"></i></a> </h5>
                                </div>
                                <div class="col-12">
                                    <div class="interview-question-holder">
                                       <?php if(!empty($interviewQuestion['question'])){ 
                                          foreach($interviewQuestion['question'] as $key=>$val){
                                             if($key == 0){
                                                $count = 'One';
                                             }else if($key == 1){
                                                $count = 'Two';
                                             }else if($key == 2){
                                                $count = 'Three';
                                             }
                                             
                                          ?>
                                       <div class="form-group mb-5">
                                          <div class="d-flex mb-4"> 
                                             <label class="page-title mb-0">{{$key+1}}.{{__('messages.QUESTION')}} {{$count}} : <span>  {{__('messages.DO_YOU_WANT_TO_ACTIVE_QUESTION')}} </span> </label>
                                             
                                             <div class="switch-slider timerButtons">
                                               <label class="switch">
                                                  <input id="start_vid_{{$key}}" type="checkbox" <?php if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ echo 'checked disabled';} ?> class="start_vid_{{$key}}">
                                                  <span class="slider round"></span>
                                               </label>
                                             </div>  
                                             <!-- <div id="timerButtons">
                                                <button type="button" id="start-1" class="btn btn-success">STOP</button>
                                             </div> -->
                                          </div> 
                                          <div class="show_hide_question_{{$key}}" style="<?php if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ echo 'display:block';}else{ echo 'display:none';}?>">
                                             <div class="d-flex justify-content-between">
                                                <!-- align-items-center -->
                                                <h5 class="h5-title my-0">Q: {{@$val}}</h5>
                                                <input type="hidden" id="video_question_id_{{$key+1}}" name="video_question_id_{{$key+1}}" value="{{$interviewQuestion['id'][$key]}}"/>
                                                <div class="w-110 text-center">
                                                   <div id="timeContainer" class="well well-sm">
                                                    <?php if(count($attemptArr[$interviewQuestion['id'][$key]]) < 3){?>
                                                      <time id="timerValue" class="timerValue_{{$key}}">00:00:00</time>
                                                    <?php }?>
                                                   </div>
                                                </div>  
                                             </div> 
                                          </div>   
                                          <div class="show_hode_{{$key}}" style="<?php if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ echo 'display:block';}else{ echo 'display:none';}?>">

                                             <div class="interview-video-holder">
                                                <div class="d-flex  justify-content-between">
                                                <!-- align-items-center -->
                                                   <h5 class="h5-title my-0">{{__('messages.TELL_US')}}</h5>
                                                <!--  <div class="w-110 text-center">
                                                      <div id="timeContainer" class="well well-sm">
                                                      <time id="timerValue">00:00:00</time>
                                                      </div>
                                                   </div>   -->
                                                </div>  
                                                <div class="interview-video-generator" id="video_intro_form_{{$key}}">
                                                   <?php if(@$interviewQuestion['interviewVideo'][$interviewQuestion['id'][$key]] != ''){?> 
                                                   <div id="divVideo">    
                                                   <video   controls class="video-js vjs-default-skin reset_upload_{{$key}}" >
                                                      
                                                         <source class="checked-video-cls-{{$key}}" src="{{asset(@$interviewQuestion['interviewVideo'][$interviewQuestion['id'][$key]])}}" type="video/mp4">
                                                                                                                                             
                                                   </video>
                                                   </div>
                                                   <video id="myVideo_{{$key}}" playsinline class="video-js vjs-default-skin vjs-hidden" >
                                                         
                                                            <p class="vjs-no-js">
                                                            To view this video please enable JavaScript, or consider upgrading to a
                                                            web browser that
                                                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                                               supports HTML5 video.
                                                            </a>
                                                            </p>
                                                      </video>  
                                                      <?php }else if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ $endValueArr = end($attemptArr[$interviewQuestion['id'][$key]]); ?>
                                                         <div id="divVideo">   
                                                        <video   controls class="video-js vjs-default-skin reset_upload_{{$key}}" >
                                                      
                                                         <source class="checked-video-cls-{{$key}}" src="{{asset($endValueArr['location'])}}" type="video/mp4">
                                                                                                                                             
                                                   </video>
                                                   </div>
                                                   <video id="myVideo_{{$key}}" playsinline class="video-js vjs-default-skin vjs-hidden" >
                                                         
                                                            <p class="vjs-no-js">
                                                            To view this video please enable JavaScript, or consider upgrading to a
                                                            web browser that
                                                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                                               supports HTML5 video.
                                                            </a>
                                                            </p>
                                                      </video>
                                                     <?php }
                                                      else{?>
                                                      <div id="divVideo" style="display:none;">   
                                                        <video   controls class="video-js vjs-default-skin reset_upload_{{$key}}" >
                                                      
                                                         <source class="checked-video-cls-{{$key}}" src="" type="video/mp4">
                                                                                                                                             
                                                        </video>
                                                       </div>
                                                      <video id="myVideo_{{$key}}" playsinline class="video-js vjs-default-skin">
                                                         
                                                            <p class="vjs-no-js">
                                                            To view this video please enable JavaScript, or consider upgrading to a
                                                            web browser that
                                                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                                               supports HTML5 video.
                                                            </a>
                                                            </p>
                                                      </video>
                                                   
                                                   <?php }?>
                                                
                                                </div>

                                             </div> 
                                             
                                         <div class="d-flex flex-wrap justify-content-between ">     
                                             
                                                <div class="select-newstyle">
                                                      <input type="hidden" id="count-atteched-{{$key+1}}" name="count-atteched-{{$key+1}}" value="{{count($attemptArr[$interviewQuestion['id'][$key]])}}"/> 
                                                            <div class="list-inline-item d-flex flex-wrap" id="all-atteched-video-{{$key}}">
                                                            <?php if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ 
                                                              $lastIndex = array_key_last($attemptArr[$interviewQuestion['id'][$key]]);
                                                         foreach($attemptArr[$interviewQuestion['id'][$key]] as $index=>$data){ ?>
                                                               <label class="check-style mr-2" style="width:auto;"> <?php 
                                                               if($index == 0){ 
                                                                  echo __('messages.ATTACHMENT').'1';
                                                               }else if($index == 1){
                                                                  echo __('messages.ATTACHMENT').'2';
                                                               }else if($index == 2){
                                                                  echo __('messages.ATTACHMENT').'3';
                                                               }
                                                               ?>
                                                               <input type="radio" class="chk-video-cls disable-cls-redio-{{$key}}" data-id="{{$data['id']}}" data-no="{{$key}}" id="attempt-{{$index+1}}" name="attempt_question_{{$key+1}}" value="{{$data['id']}}"  <?php if($data['is_selected'] == 1){ echo 'checked';}else if($lastIndex == $index){ echo 'checked';} ?>>
                                                               <span class="checkmark"></span>
                                                               </label>
                                                               <?php }
                                                         }?>
                                                            </div>
                                                </div>  

                                                <div id="timerButtons" class="mx-0 d-flex flex-wrap">
                                                   <button type="button"  id="stop-{{$key}}" class="btn btn-danger min-w-130 mb-2 mr-2" style="<?php if(count($attemptArr[$interviewQuestion['id'][$key]]) == 0){ echo 'display:block'; }else{ echo 'display:none'; }?>" >{{__('messages.STOP')}}</button>
                                                   <button type="button"  id="start-{{$key}}" class="btn btn-default min-w-130 mb-2" style="<?php if((!empty($attemptArr[$interviewQuestion['id'][$key]])) && count($attemptArr[$interviewQuestion['id'][$key]]) < 3){ echo 'display:block'; }else{ echo 'display:none'; }?>">{{__('messages.RESTART')}}</button>
                                                </div> 
                                         </div>       
                                          
                                           </div>
                                          </div>
                                       <?php } }?>
                                                                                                                                                
                                    </div>
                                </div>
                             </div>
                             <div class="row  mt-4">
                                <div class="col-12 text-center">
                                <label style="display: none;" class="error upload-error-n-intro"> Error Message </label>
                                             <button class="btn site-btn-color enable-disable-cls-prev" id="<?php if(count($specificQuestion['question']) == 0){?>prevbtn<?php }else{?>prevbtn2<?php }?>" type="button">{{__('messages.PREV')}}</button>
                                  <button class="btn site-btn-color apply-step-three upload-intro-video-func enable-disable-cls" id="save-as-draft" type="button" data-id="0">{{__('messages.SAVE_AS_DRAFT')}}</button>
                                  <button class="btn site-btn-color upload-intro-video-func enable-disable-cls" type="button" data-id="1">{{__('messages.APPLY')}}</button>
                                </div>
                             </div>
                          </div>
                           <?php }?>
                          </form>             
                        </div>  
                      </div>    
                    </div>      
                  </div>
               </section>
            </main>
      <!-- main End -->
      <!--footer start-->
      <script src="{{ asset('frontend/js/dropzone.min.js')}}"></script>
      <script src="{{ asset('frontend/js/aos.js')}}"></script>
      <script src="{{ asset('frontend/js/jquery.easing.min.js')}}"></script>
      <script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>
      <script src="{{ asset('frontend/js/tagsinput.js')}}"></script> 
      <script src="{{ asset('frontend/js/swiper.min.js')}}"></script>
      <!--footer end-->
       
      <!-- ================Modal================ -->
      <!-- Report Modal -->
      <div class="modal custom-modal  profile-modal " id="tips-interview">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <div class="row">
                        <div class="col-sm-12 mb-3">
                           <h4 class="text-left"> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT1')}}  </h4>
                        </div>
                        <div class="col-sm-12 col-xl-12">
                          
                          <h5 class="total-title"> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT2')}} </h5>
                          <p><i class="fa fa-paper-plane-o mr-2" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT3')}} </p>
                          <p><i class="fa fa-paper-plane-o  mr-2" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT4')}} </p>
                          <p><i class="fa fa-paper-plane-o  mr-2" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT5')}}</p>
                          <p><i class="fa fa-paper-plane-o  mr-2" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT6')}}  </p>

                          <h5 class="total-title mt-4"> {{__('messages.OUR_SUGGESTION')}}:</h5>
                          <p>  {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT7')}}</p>

                           <h6 class="h5-title">** {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT8')}} {{count($interviewQuestion['question'])}} {{__('messages.INTERVIEW_QUESTIONS')}}.  </h6>

                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Report Modal -->
       <!-- apply-modal -->
      <div class="modal custom-modal profile-modal " id="apply-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  
               </div>
            </div>
         </div>
      </div>
      <!-- apply-modal -->
      <script type="text/javascript">var mandatoryset = <?php echo $mandatoryset; ?>;  var videoRequiredCount = <?php echo $interviewQuestion['mandetory_setting']; ?>; var totalVideo = <?php echo $videoCount;?>;</script>

<script>
  var isCameraOffFound = 0;
  navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia({video: true}, function() {
    //alert('webcam is available');
    // webcam is available
  }, function() {
    $("input.start_vid_0").attr("disabled", true);
    $("input.start_vid_1").attr("disabled", true);
    $("input.start_vid_2").attr("disabled", true);
      if(mandatoryset != 0){
         $(".enable-disable-cls").attr("disabled", true);
      } 
    $("#start-0").attr("disabled",true);
    $("#start-1").attr("disabled",true);
    $("#start-2").attr("disabled",true);
    //alert('webcam is not available');
    // webcam is not available
  });

  setInterval(function(){ 

    navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia({video: true}, function() {
    //alert('webcam is available');
    // webcam is available
  }, function() {
    QUESTION_READING_TIME = 0;  //second
    INTERVIEW_DURATION = 0;//second
    if((chkCameraOnOff1 == 1) || (chkCameraOnOff2 == 1) || (chkCameraOnOff3 == 1)){
      isCameraOffFound ++;
      if(isCameraOffFound == 1){
           swal(lanFilter(allMsgText.SORRY_NO_CAMERA_FOUND))
            .then((value) => {
              location.reload();
          });

      }
     
    }
    $("input.start_vid_0").attr("disabled", true);
    $("input.start_vid_1").attr("disabled", true);
    $("input.start_vid_2").attr("disabled", true);
    if(mandatoryset != 0){
         $(".enable-disable-cls").attr("disabled", true);
      } 
    $("#start-0").attr("disabled",true);
    $("#start-1").attr("disabled",true);
    $("#start-2").attr("disabled",true);

    if(startVideRrcd1 == 1){
      setTimeout(function(){ 
        $('#video_intro_form_0 .vjs-icon-record-stop').trigger('click');     
             
      }, 500);
    }
    if(startVideRrcd2 == 1){
      setTimeout(function(){ 
        $('#video_intro_form_1 .vjs-icon-record-stop').trigger('click');     
             
      }, 500);
    }
    if(startVideRrcd3 == 1){
      setTimeout(function(){ 
        $('#video_intro_form_2 .vjs-icon-record-stop').trigger('click');     
             
      }, 500);
    }
   
    //alert('webcam is not available');
    // webcam is not available
  });
     }, 1000);
  </script>

   <script>
   var video_one_stack = [];  
   var video_two_stack = []; 
   var video_three_stack = [];  
   var options = {
      controls: true,
      width: 635,
      height: 260,
      plugins: {
         record: {
            audio: true,
            video: true,
            maxLength: INTERVIEW_DURATION,
            debug: true
         }
      }
   };
//only timer

function startTimerOnly(no){

   var msec = 0;
   var sec = 0;
   var min = 0;
   var question1timer;
   var myVar;

   myVar = setInterval(myTimer, 1000);
   question1timer = 0; 
   
    function myTimer() {
      if(question1timer >= INTERVIEW_DURATION){
         myStopFunction();         
         return false;
      }         
      question1timer ++;
      msec += 1;
      if (msec == 60) {
            sec += 1;
            msec = 00;
           if (sec == 60) {
              sec = 00;
              min += 1;
              if (sec % 2 == 0) {
                 //alert("Pair");
              }
           }
      }
      var mint = min < 10 ? "0" + min : min;
      var secnd = sec < 10 ? "0" + sec : sec;
      var msecnd = msec < 10 ? "0" + msec : msec;

      var t = mint + ":" + secnd + ":" + msecnd;
      $('.timerValue_'+no).html(t);
      
   }
   function myStopFunction() {
      clearInterval(myVar);
      
   }
   
}//end play one
function openVideo(no){
   var msec = 0;
   var sec = 0;
   var min = 0;
   var question1timer;
   var myVar;
  
   $('.show_hode_'+no).show('slow');
        setTimeout(function(){ 
           $('#video_intro_form_'+no+' .vjs-record').trigger('click');  
            setTimeout(function(){ 
                $('#video_intro_form_'+no+' .vjs-icon-record-start').trigger('click'); 
                //TIMER FUNCTION
                 myVar = setInterval(myTimer, 1000);
                 question1timer = 0;    
            }, 3000);
   }, 500);

   
   function myTimer() {
      if(question1timer >= INTERVIEW_DURATION){
         myStopFunction();         
         return false;
      }         
      question1timer ++;
      msec += 1;
      if (msec == 60) {
            sec += 1;
            msec = 00;
           if (sec == 60) {
              sec = 00;
              min += 1;
              if (sec % 2 == 0) {
                 //alert("Pair");
              }
           }
      }
      var mint = min < 10 ? "0" + min : min;
      var secnd = sec < 10 ? "0" + sec : sec;
      var msecnd = msec < 10 ? "0" + msec : msec;

      var t = mint + ":" + secnd + ":" + msecnd;
      $('.timerValue_'+no).html(t);
      
   }
   function myStopFunction() {
      clearInterval(myVar);
      
   }
}//end play one

// apply some workarounds for certain browsers
applyVideoWorkaround();
videoExist = <?php echo $videoExsistCount; ?>;
if(videoExist == 0){
   videoExist == '';
}
var videoCount = <?php echo $videoCount; ?>;
if(videoCount > 0){
   
   for(var $i = 0; $i < videoCount; $i++){
    
      if($i == 0){

        var player_1 = videojs('myVideo_'+$i, options, function() {
         // print version information at startup
         var msg = 'Using video.js ' + videojs.VERSION +
            ' with videojs-record ' + videojs.getPluginVersion('record') +
            ' and recordrtc ' + RecordRTC.version;
         videojs.log(msg);
      });

      // error handling
      player_1.on('deviceError', function() {
         console.log('device error:', player_1.deviceErrorCode);
      });

      player_1.on('error', function(element, error) {
         console.error(error);
      });

      // user clicked the record button and started recording

      player_1.on('startRecord', function() {
         $(".disable-cls-redio-0").attr("disabled", true);
         INTERVIEW_DURATION = 120;
         console.log('started recording!');
         startVideRrcd1++;
       });

      // user completed recording and stream is available
     player_1.on('finishRecord', function() { INTERVIEW_DURATION = 0;   
      $(".disable-cls-redio-0").attr("disabled", false); 
         // the blob object contains the recorded data that
         // can be downloaded by the user, stored on server etc.
         console.log('finished recording 1: ', player_1.recordedData);
         introVideoData1 = player_1.recordedData;
          video_one_stack.push(player_1.recordedData);  

          // ATTEMPT STORE IN DB
          var jobId = $('#job_id').val();
          var questionId = $('#video_question_id_1').val();
          var attachmentCount1 = $('#count-atteched-1').val();
          var fd = new FormData();
          fd.append('file1',introVideoData1);
          fd.append('questionId',questionId);
          fd.append('jobId',jobId);
         
          $.ajax({
                url: _BASE_URL+"/candidate/store-interview-attempt",
                data:fd,
                method:'POST',
                dataType:'json',
                cache : false,
                processData: false,
                contentType: false,
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(attempId){
                  validationCount1 ++;
                  var length = 0;
                  if(parseInt(attachmentCount1) >= parseInt(1)){
                      length = parseInt(attachmentCount1) + parseInt(1);
                      $('#count-atteched-1').val(length);
                  }else{
                      length = video_one_stack.length;
                  }
                  if(length >= 1){
                      if(length == 3){
                        $('#start-0').hide();
                        $('#stop-0').hide();
                      }else{
                       $('#start-0').show();   
                       $('#stop-0').hide(); 
                      }
                  }
                  var html = '';
                  var fileName = 'Attachment'+length;
                  html = '<label class="check-style mr-2" style="width:auto;">'+fileName+'<input type="radio" class="chk-video-cls disable-cls-redio-0" data-id="'+attempId+'" data-no="0" id="attempt-"'+length+' name="attempt_question_1" value="'+attempId+'" ><span class="checkmark"></span></label>';
                  //html = '<div  style="float:left" clas="attachment"><input type="radio" id="attempt-"'+length+' name="attempt_question_1" value="'+attempId+'"><label for="male">'+fileName+'</label></div>';
                  $('#all-atteched-video-0').append(html);
                  $(".enable-disable-cls").attr("disabled", false);
                  $(".enable-disable-cls-prev").attr("disabled", false);
                },
                error: function(){
                      alert("Something happend wrong.Please try again");
                } 
          }).done(function() {
                   
          });
          //ATTEMPT STORE IN DB
      });

     //function to stop video
      $(document).on('click','#stop-0',function(){
            
            setTimeout(function(){ 
              $('#video_intro_form_0 .vjs-icon-record-stop').trigger('click');     
                   
            }, 500);
      });
      //function to stop video
      $(document).on('click','#start-0',function(){
         var attachmentCount1 = $('#count-atteched-1').val();
         if(attachmentCount1 == 2){
            swal({
               text: "This is your final chance!",
               buttons: true,
               dangerMode: true,
             })
               .then((willDelete) => {
                  if (willDelete) {
                     $(".enable-disable-cls").attr("disabled", true);
                     $(".enable-disable-cls-prev").attr("disabled", true);
                     chkCameraOnOff1++;
                     setTimeout(function(){ 
                           console.log('start-0');
                           console.log($('.reset_upload_0').length);
                           //if player 0 exists
                           if($('.reset_upload_0').length){
                              $('.reset_upload_0').fadeOut(function(){
                                    $('#myVideo_0').removeClass("vjs-hidden");                          
                              });
                              $('#video_intro_form_0 .vjs-record').trigger('click');
                              setTimeout(function(){ 
                                       $('#video_intro_form_0 .vjs-icon-record-start').trigger('click');  
                                       $('#stop-0').show();   
                                       $('#start-0').hide(); 
                                       startTimerOnly(0);
                              },2000);
                           }else{
                              $('#video_intro_form_0 .vjs-icon-record-start').trigger('click'); 
                              $('#stop-0').show();   
                              $('#start-0').hide(); 
                              startTimerOnly(0); 
                           }    
                              
                     }, 500);
                  }
               });
         }else{
          
            $(".enable-disable-cls").attr("disabled", true);
            $(".enable-disable-cls-prev").attr("disabled", true);
            chkCameraOnOff1++;
            setTimeout(function(){ 
                  console.log('start-0');
                  console.log($('.reset_upload_0').length);
                  //if player 0 exists
                  if($('.reset_upload_0').length){
                       $('.reset_upload_0').fadeOut(function(){
                           $('#myVideo_0').removeClass("vjs-hidden");                          
                       });
                       $('#video_intro_form_0 .vjs-record').trigger('click');
                       setTimeout(function(){ 
                              $('#video_intro_form_0 .vjs-icon-record-start').trigger('click');  
                              $('#stop-0').show();   
                              $('#start-0').hide(); 
                              startTimerOnly(0);
                       },2000);
                  }else{
                      $('#video_intro_form_0 .vjs-icon-record-start').trigger('click'); 
                      $('#stop-0').show();   
                      $('#start-0').hide(); 
                      startTimerOnly(0); 
                  }    
                     
            }, 500);
         }
            
      });

      }
      else if($i == 1){

        var player_2 = videojs('myVideo_'+$i, options, function() {
         // print version information at startup
         var msg = 'Using video.js ' + videojs.VERSION +
            ' with videojs-record ' + videojs.getPluginVersion('record') +
            ' and recordrtc ' + RecordRTC.version;
         videojs.log(msg);
      });

      // error handling
      player_2.on('deviceError', function() {
         console.log('device error:', player_2.deviceErrorCode);
      });

      player_2.on('error', function(element, error) {
         console.error(error);
      });

      // user clicked the record button and started recording

      player_2.on('startRecord', function() {
         $(".disable-cls-redio-1").attr("disabled", true);
         INTERVIEW_DURATION = 120;
         console.log('started recording!');
         startVideRrcd2++;
      });

      // user completed recording and stream is available
     player_2.on('finishRecord', function() { INTERVIEW_DURATION = 0;
         $(".disable-cls-redio-1").attr("disabled", false);
         // the blob object contains the recorded data that
         // can be downloaded by the user, stored on server etc.
         console.log('finished recording: ', player_2.recordedData);
         introVideoData2 = player_2.recordedData;
         video_two_stack.push(player_2.recordedData);  
          
          // ATTEMPT STORE IN DB
          var jobId = $('#job_id').val();
          var questionId = $('#video_question_id_2').val();
          var attachmentCount2 = $('#count-atteched-2').val();
          var fd = new FormData();
          fd.append('file1',introVideoData2);
          fd.append('questionId',questionId);
          fd.append('jobId',jobId);
         
          $.ajax({
                url: _BASE_URL+"/candidate/store-interview-attempt",
                data:fd,
                method:'POST',
                dataType:'json',
                cache : false,
                processData: false,
                contentType: false,
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(attempId){
                  validationCount2 ++;
                  var length = 0;
                  if(parseInt(attachmentCount2) >= parseInt(1)){
                      length = parseInt(attachmentCount2) + parseInt(1);
                      $('#count-atteched-2').val(length);
                  }else{
                      length = video_two_stack.length;
                  }
                  if(length >= 1){
                      if(length == 3){
                        $('#start-1').hide();
                        $('#stop-1').hide();
                      }else{
                       $('#start-1').show();   
                       $('#stop-1').hide(); 
                      }
                  }
                  var html = '';
                  let fileName = 'Attachment'+length;
                  html = '<label class="check-style mr-2" style="width:auto;">'+fileName+'<input type="radio" class="chk-video-cls disable-cls-redio-1" data-id="'+attempId+'" data-no="1" id="attempt-"'+length+' name="attempt_question_2" value="'+attempId+'" ><span class="checkmark"></span></label>';
                  //html = '<div  style="float:left" clas="attachment"><input type="radio" id="attempt-"'+length+' name="attempt_question_2" value="'+attempId+'"><label for="male">'+fileName+'</label></div>';
                  $('#all-atteched-video-1').append(html);
                  $(".enable-disable-cls").attr("disabled", false);
                  $(".enable-disable-cls-prev").attr("disabled", false);
                },
                error: function(){
                      alert("Something happend wrong.Please try again");
                } 
          }).done(function() {
                   
          });
          //ATTEMPT STORE IN DB
      });

     //function to stop video
      $(document).on('click','#stop-1',function(){
            
            setTimeout(function(){ 
              $('#video_intro_form_1 .vjs-icon-record-stop').trigger('click');     
                   
            }, 500);
      });
      //function to stop video
      $(document).on('click','#start-1',function(){
         var attachmentCount2 = $('#count-atteched-2').val();
         if(attachmentCount2 == 2){
            swal({
               text: "This is your final chance!",
               buttons: true,
               dangerMode: true,
             })
               .then((willDelete) => {
                  if (willDelete) {
                     $(".enable-disable-cls").attr("disabled", true);
                     $(".enable-disable-cls-prev").attr("disabled", true);
                     chkCameraOnOff2++;
                     
                     setTimeout(function(){ 
                     
                           //if player 0 exists
                           if($('.reset_upload_1').length){
                              $('.reset_upload_1').fadeOut(function(){
                                    $('#myVideo_1').removeClass("vjs-hidden");                          
                              });
                              $('#video_intro_form_1 .vjs-record').trigger('click');
                              setTimeout(function(){ 
                                       $('#video_intro_form_1 .vjs-icon-record-start').trigger('click');  
                                       $('#stop-1').show();   
                                       $('#start-1').hide(); 
                                       startTimerOnly(1);
                              },2000);
                           }else{
                              $('#video_intro_form_1 .vjs-icon-record-start').trigger('click'); 
                              $('#stop-1').show();   
                              $('#start-1').hide(); 
                              startTimerOnly(1); 
                           }    
                              
                     }, 500);
                  }
               });
            }else{
               $(".enable-disable-cls").attr("disabled", true);
               $(".enable-disable-cls-prev").attr("disabled", true);
               chkCameraOnOff2++;
               
               setTimeout(function(){ 
               
                     //if player 0 exists
                     if($('.reset_upload_1').length){
                        $('.reset_upload_1').fadeOut(function(){
                              $('#myVideo_1').removeClass("vjs-hidden");                          
                        });
                        $('#video_intro_form_1 .vjs-record').trigger('click');
                        setTimeout(function(){ 
                                 $('#video_intro_form_1 .vjs-icon-record-start').trigger('click');  
                                 $('#stop-1').show();   
                                 $('#start-1').hide(); 
                                 startTimerOnly(1);
                        },2000);
                     }else{
                        $('#video_intro_form_1 .vjs-icon-record-start').trigger('click'); 
                        $('#stop-1').show();   
                        $('#start-1').hide(); 
                        startTimerOnly(1); 
                     }    
                        
               }, 500);
            }

            
      });
         
      }else if($i == 2){

        var player_3 = videojs('myVideo_'+$i, options, function() {
         // print version information at startup
         var msg = 'Using video.js ' + videojs.VERSION +
            ' with videojs-record ' + videojs.getPluginVersion('record') +
            ' and recordrtc ' + RecordRTC.version;
         videojs.log(msg);
      });

      // error handling
      player_3.on('deviceError', function() {
         console.log('device error:', player_3.deviceErrorCode);
      });

      player_3.on('error', function(element, error) {
         console.error(error);
      });

      // user clicked the record button and started recording

      player_3.on('startRecord', function() {
         $(".disable-cls-redio-2").attr("disabled", true);
         INTERVIEW_DURATION = 120;
         console.log('started recording!');
         startVideRrcd3++;
      });

      // user completed recording and stream is available
     player_3.on('finishRecord', function() { INTERVIEW_DURATION = 0;
         $(".disable-cls-redio-2").attr("disabled", false);
         // the blob object contains the recorded data that
         // can be downloaded by the user, stored on server etc.
         console.log('finished recording: ', player_3.recordedData);
         introVideoData3 = player_3.recordedData;
          video_three_stack.push(player_3.recordedData);  

          // ATTEMPT STORE IN DB
          var jobId = $('#job_id').val();
          var questionId = $('#video_question_id_3').val();
          var attachmentCount3 = $('#count-atteched-3').val();
          var fd = new FormData();
          fd.append('file1',introVideoData3);
          fd.append('questionId',questionId);
          fd.append('jobId',jobId);
         
          $.ajax({
                url: _BASE_URL+"/candidate/store-interview-attempt",
                data:fd,
                method:'POST',
                dataType:'json',
                cache : false,
                processData: false,
                contentType: false,
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(attempId){
                  validationCount3 ++;
                  var length = 0;
                  if(parseInt(attachmentCount3) >= parseInt(1)){
                      length = parseInt(attachmentCount3) + parseInt(1);
                      $('#count-atteched-3').val(length);
                  }else{
                      length = video_three_stack.length;
                  }
                  if(length >= 1){
                      if(length == 3){
                        $('#start-2').hide();
                        $('#stop-2').hide();
                      }else{
                       $('#start-2').show();   
                       $('#stop-2').hide(); 
                      }
                  }
                  var html = '';
                  let fileName = 'Attachment'+length;
                  html = '<label class="check-style mr-2" style="width:auto;">'+fileName+'<input type="radio" class="chk-video-cls disable-cls-redio-2" data-id="'+attempId+'" data-no="2" id="attempt-"'+length+' name="attempt_question_3" value="'+attempId+'" ><span class="checkmark"></span></label>';
                  //html = '<div  style="float:left" clas="attachment"><input type="radio" id="attempt-"'+length+' name="attempt_question_3" value="'+attempId+'"><label for="male">'+fileName+'</label></div>';
                  $('#all-atteched-video-2').append(html);
                  $(".enable-disable-cls").attr("disabled", false);
                  $(".enable-disable-cls-prev").attr("disabled", false);
                },
                error: function(){
                      alert("Something happend wrong.Please try again");
                } 
          }).done(function() {
                   
          });
          //ATTEMPT STORE IN DB
      });

      //function to stop video
        $(document).on('click','#stop-2',function(){
              
              setTimeout(function(){ 
                $('#video_intro_form_2 .vjs-icon-record-stop').trigger('click');                             
              }, 500);
        });
        //function to stop video
        $(document).on('click','#start-2',function(){
         var attachmentCount3 = $('#count-atteched-3').val();
         if(attachmentCount3 == 2){
            swal({
               text: "This is your final chance!",
               buttons: true,
               dangerMode: true,
             })
               .then((willDelete) => {
                  if (willDelete) {
                     $(".enable-disable-cls").attr("disabled", true);
                     $(".enable-disable-cls-prev").attr("disabled", true);
                     chkCameraOnOff3++;
                     
                     setTimeout(function(){ 
                     
                           //if player 0 exists
                           if($('.reset_upload_2').length){
                              $('.reset_upload_2').fadeOut(function(){
                                    $('#myVideo_2').removeClass("vjs-hidden");                          
                              });
                              $('#video_intro_form_2 .vjs-record').trigger('click');
                              setTimeout(function(){ 
                                       $('#video_intro_form_2 .vjs-icon-record-start').trigger('click');  
                                       $('#stop-2').show();   
                                       $('#start-2').hide(); 
                                       startTimerOnly(2);
                              },2000);
                           }else{
                              $('#video_intro_form_2 .vjs-icon-record-start').trigger('click'); 
                              $('#stop-2').show();   
                              $('#start-2').hide(); 
                              startTimerOnly(2); 
                           }    
                              
                     }, 500);
                  }
               });
            }else{
               $(".enable-disable-cls").attr("disabled", true);
               $(".enable-disable-cls-prev").attr("disabled", true);
               chkCameraOnOff3++;
               
               setTimeout(function(){ 
               
                     //if player 0 exists
                     if($('.reset_upload_2').length){
                        $('.reset_upload_2').fadeOut(function(){
                              $('#myVideo_2').removeClass("vjs-hidden");                          
                        });
                        $('#video_intro_form_2 .vjs-record').trigger('click');
                        setTimeout(function(){ 
                                 $('#video_intro_form_2 .vjs-icon-record-start').trigger('click');  
                                 $('#stop-2').show();   
                                 $('#start-2').hide(); 
                                 startTimerOnly(2);
                        },2000);
                     }else{
                        $('#video_intro_form_2 .vjs-icon-record-start').trigger('click'); 
                        $('#stop-2').show();   
                        $('#start-2').hide(); 
                        startTimerOnly(2); 
                     }    
                        
               }, 500);
            }

              
        });

      }
         
   }  

}



$(document).ready(function(){
   
   //FIRST ONE START
   $('#start_vid_0').click(function(){
      swal({
         text: lanFilter(allMsgText.CAMERA_ON_ALERT_AT_APPLY_JOB),
         buttons: true,
         dangerMode: true,
      })
      .then((willDelete) => {
         if (willDelete) {
            $('.show_hide_question_0').show('slow');
            $("input.start_vid_0").attr("disabled", true);
            $(".enable-disable-cls").attr("disabled", true);
            $(".enable-disable-cls-prev").attr("disabled", true);
            //CHECK CAMERA ON / OFF
            chkCameraOnOff1++;

            //TIMER FUNCTION
            var myVar = setInterval(myTimer, 1000);
            var msec = 00;
            var sec = 00;
            var min = 00;

            var question1timer = 0;
            function myTimer() {
               if(question1timer >= QUESTION_READING_TIME){
                  myStopFunction();
                  openVideo(0);
                  return false;
               }
                  
               question1timer ++;
               msec += 1;
               if (msec == 60) {
                  sec += 1;
                  msec = 00;
                  if (sec == 60) {
                     sec = 00;
                     min += 1;
                     if (sec % 2 == 0) {
                        //alert("Pair");
                     }
                  }
               }
             
               var mint = min < 10 ? "0" + min : min;
                var secnd = sec < 10 ? "0" + sec : sec;
                var msecnd = msec < 10 ? "0" + msec : msec;

                var t = mint + ":" + secnd + ":" + msecnd;
               $('.timerValue_0').html(t);
               
               }
               function myStopFunction() {
                  clearInterval(myVar);
                  
               }
               
            }else{
               $("#start_vid_0").prop("checked", false);
            }
         });	

   });
   //SECOND ONE START
   $('#start_vid_1').click(function(){
      swal({
         text: lanFilter(allMsgText.CAMERA_ON_ALERT_AT_APPLY_JOB),
         buttons: true,
         dangerMode: true,
      })
      .then((willDelete) => {
         if (willDelete) {
            $('.show_hide_question_1').show('slow');
            $("input.start_vid_1").attr("disabled", true);
            $(".enable-disable-cls").attr("disabled", true);
            $(".enable-disable-cls-prev").attr("disabled", true);
            //CHECK CAMERA ON / OFF
            chkCameraOnOff2++;
            //TIMER FUNCTION
            var myVar = setInterval(myTimer, 1000);
            var msec = 00;
            var sec = 00;
            var min = 00;

            var question1timer = 0;
            function myTimer() {
               if(question1timer >= QUESTION_READING_TIME){
                  myStopFunction();
                  openVideo(1);
                  return false;
               }
                  
               question1timer ++;
               msec += 1;
               if (msec == 60) {
                  sec += 1;
                  msec = 00;
                  if (sec == 60) {
                     sec = 00;
                     min += 1;
                     if (sec % 2 == 0) {
                        //alert("Pair");
                     }
                  }
               }
             
               var mint = min < 10 ? "0" + min : min;
                var secnd = sec < 10 ? "0" + sec : sec;
                var msecnd = msec < 10 ? "0" + msec : msec;

                var t = mint + ":" + secnd + ":" + msecnd;
               $('.timerValue_1').html(t);
               
            }
            function myStopFunction() {
               clearInterval(myVar);
               
            }
            
         }else{
            $("#start_vid_1").prop("checked", false);
         }
      });	

   });
   //THIRD ONE START
   $('#start_vid_2').click(function(){
      swal({
         text: lanFilter(allMsgText.CAMERA_ON_ALERT_AT_APPLY_JOB),
         buttons: true,
         dangerMode: true,
      })
      .then((willDelete) => {
         if (willDelete) {
            $('.show_hide_question_2').show('slow');
            $("input.start_vid_2").attr("disabled", true);
            $(".enable-disable-cls").attr("disabled", true);
            $(".enable-disable-cls-prev").attr("disabled", true);
            //CHECK CAMERA ON / OFF
            chkCameraOnOff3++;
            //TIMER FUNCTION
            var myVar = setInterval(myTimer, 1000);
            var msec = 00;
            var sec = 00;
            var min = 00;

            var question1timer = 0;
            function myTimer() {
               if(question1timer >= QUESTION_READING_TIME){
                  myStopFunction();
                  openVideo(2);
                  return false;
               }
                  
               question1timer ++;
               msec += 1;
               if (msec == 60) {
                  sec += 1;
                  msec = 00;
                  if (sec == 60) {
                     sec = 00;
                     min += 1;
                     if (sec % 2 == 0) {
                        //alert("Pair");
                     }
                  }
               }
               var mint = min < 10 ? "0" + min : min;
              var secnd = sec < 10 ? "0" + sec : sec;
              var msecnd = msec < 10 ? "0" + msec : msec;

              var t = mint + ":" + secnd + ":" + msecnd;
               $('.timerValue_2').html(t);
               
            }
            function myStopFunction() {
               clearInterval(myVar);
               
            }
            
         }else{
            $("#start_vid_2").prop("checked", false);
         }
      });	

   });

});


$(document).on('click','.reset_vid',function(){
      var id = $(this).attr("data-id");
      var deleteId = $(this).attr("data-del");
      var applyId = $('#job_applied_id').val();
      $('.reset_upload_'+id).hide('slow');
      $('#reset_vid_'+id).hide('slow');
      $('#myVideo_'+id).show('slow');
      console.log(deleteId); 
      console.log(applyId); 
      $.ajax({
            url: _BASE_URL+"/candidate/delete-interview-video",
            data:{'questionid' : deleteId,'applyid' : applyId},
            method:'POST',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
               console.log(response);
               videoExist = (videoExist - 1);
            },
            error: function(){
                  alert("Something happend wrong.Please try again");
            }	
      }).done(function() {
               
   });
});

// $(document).on('click','#nextbtn2',function(){
      
//       $('#apply-job-company').hide();
// });
$(document).on('click','#prevbtn',function(){
      
      $('#next-interview-qus').hide();
});


</script>
<style type="text/css">
  #video_intro_form_1 .vjs-icon-record-start{ display: none; }
  #video_intro_form_1 .vjs-icon-record-stop{ display: none; }

  #video_intro_form_0 .vjs-icon-record-start{ display: none; }
  #video_intro_form_0 .vjs-icon-record-stop{ display: none; }

  #video_intro_form_2 .vjs-icon-record-start{ display: none; }
  #video_intro_form_2 .vjs-icon-record-stop{ display: none; }
</style>
@endsection
