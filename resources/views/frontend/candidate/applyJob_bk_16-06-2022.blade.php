@extends('layouts.app_after_login_layout')
@section('content')
<style>
   .apply-job-holder #cke_1_contents {
      height: 150px !important;
   }
</style>   
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
   /* var AuthUser = '<?php //echo Auth::user()->id;?>'; */
   var jobId = '<?php echo $jobId; ?>';
  
   function lanFilter(str){
   if(str != undefined){
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
      else{
      return 'Der Antwortmodus ist Video. Bitte stellen Sie sicher, dass Sie eine Webcam richtig angeschlossen haben. Sie haben 1 Minute Zeit, um die Frage zu lesen und 4 Minuten, um sie zu beantworten. Der Countdown beginnt, sobald Sie auf OK klicken';
      }  
   }
</script>
  
<script src="{{asset('frontend/js/applyJob.js')}}"></script>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script> 
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
            //S3 BUCKET IMG
            $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
            $command = $adapter->getClient()->getCommand('GetObject', [
            'Bucket' => $adapter->getBucket(),
            'Key'    => $adapter->getPathPrefix(). '' . $val['upload']['name']
            ]);
            $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
            $val['upload']['location'] = (string)$img->getUri();

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
      $jobAppliedId =  isset($appliedJob) ? $appliedJob['job_applied_id'] : '';
      ?>

               <section class="section section-applyjob">
                  <div class="container">
                    <div class="row">
                      <div class="col-12"> 
                        <div class="section-myprofile">
                           <div class="mb-5 col-sm-12 details-panel-header">
                                 <h3 class="mt-0 text-center font-22 ">{{__('messages.APPLY_TO')}} </h3>
                           </div>
                           @if(Auth::user() == NULL)
                           <div class="row">
                              <div class="col-12 col-lg-6 border-right">
                                 <div class="sign_in_sec new_sign current">
                                    <div class="mt-md-1">
                                       <form id="candidate_login" method="POST" action="{{ url('candidate/login') }}" >
                                          @csrf
                                          <h3>Log in</h3>                 
                                          <div class="row">
                                             <div class="col-12">
                                                <div class="sn-field">
                                                   <input type="text" id="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus="" placeholder="{{ __('messages.EMAIL') }}">
                                                   @if (($typ == '') && ($errors->has('email')))
                                                   <label id="email-error" class="error" for="Name">{{ $errors->first('email') }}</label>
                                                   @endif
                                                   <i class="la la-user"></i>
                                                </div>
                                             </div>
                                             <div class="col-12">
                                                <div class="sn-field password-holder">
                                                   <input class=" @error('password') is-invalid @enderror " id="password" value="{{ old('password') }}" name="password" type="password" placeholder="{{ __('messages.PASSWORD') }}">
                                                   @if ($errors->has('password'))
                                                   <label id="email-error" class="error" for="Name">{{ $errors->first('password') }}</label>
                                                   @endif
                                                   <i class="la la-lock"></i>
                                                   <button class="eye_showHide" id="eye_showHide" type="button"> <i id="eye-sh" class="fa fa-eye"></i>
                                                   </button>
                                                </div>
                                             </div>
                                             <div class="mt-4 col-12">
                                                <button class="submit-btn" type="submit" value="submit">Sign in</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12 col-lg-6">
                                 <div class="sign_in_sec new_sign current sign-upfrm">
                                    <div class="tab-content">
                                       <div class="dff-tab tab-pane active">
                                       <div class="mt-1 password-info">
                                          <p>New in the website? Create your account, it is quickly!</p>
                                       </div>
                                          <form id="candidate_sign_up" method="POST" action="{{ url('candidate/register') }}" aria-label="Register">
                                             @csrf
                                             <input type="hidden" name="user_type" value="2">
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input value="{{ old('first_name') }}" class="{{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" type="text" name="first_name" placeholder="{{ __('messages.NAME') }} *">
                                                      @if ($errors->has('first_name'))
                                                      <label id="email-error" class="error" for="Name">{{ $errors->first('first_name') }}</label>
                                                      @endif
                                                      <i class="la la-user"></i>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input type="email" value="{{ old('email') }}" name="email" placeholder="{{ __('messages.EMAIL') }} *" class="@error('email') is-invalid @enderror">
                                                      @if (($typ == 2) && ($errors->has('email')))
                                                      <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                                      @endif
                                                      <i class="la la-envelope "></i>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="mb-3 sn-field password-holder">
                                                      <input class="@error('password') is-invalid @enderror chkPasswordCls" value="{{ old('password') }}" type="password" name="password" id="password_org" placeholder="{{ __('messages.PASSWORD') }} *" title="Minimum 8 caracteres (including number, lower case, etc)">
                                                      @if ($errors->has('password'))
                                                      <label id="email-error" class="error" for="password">{{ $errors->first('password') }}</label>
                                                      @endif
                                                      <i class="la la-lock"></i>
                                                      <button class="eye_showHide" type="button" id="eye-open-hide-1"> 
                                                         <i id="eye-sh-1" class="fa fa-eye"></i>
                                                      </button>
                                                      <div class="mt-1 password-info">
                                                      {{ __('messages.CANDIDATE_PASSWORD_SHOULD_BE') }}
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="reenter-passholder"> 
                                                      <div class="sn-field password-holder">
                                                         <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('messages.RE_ENTER_PASSWORD') }} *">
                                                         <i class="la la-lock"></i>
                                                         <button class="eye_showHide" type="button" id="eye-open-hide-2"> 
                                                            <i id="eye-sh-2" class="fa fa-eye"></i>
                                                         </button>
                                                      </div>
                                                      <span class="confirm-success d-none"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-12 col-md-4">
                                                   <div class="p-0 mt-4 col-12">
                                                      <button type="submit" class="submit-btn signup-candidate confirm-submission-candidate" value="submit">Register </button>
                                                   </div>
                                                </div>
                                                <div class="pl-0 col-12 col-md-8 for-mob-s">
                                                   <div class="p-0 col-12">
                                                      <label class="check-style fs-12">{{ __('messages.I_HAVE_READ_AND_AGREE_TO_THE') }} <a href="http://dev107.developer24x7.com/cnp1356/public/terms-use" target="_blank">{{ __('messages.TERMS_OF_USE') }}</a>.
                                                      <input id="terms_conditions_status" type="checkbox" name="terms_conditions_status">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div>
                                                   <div class="p-0 col-12">
                                                      <label class="check-style fs-12">{{ __('messages.I_HAVE_READ_AND_AGREE_WITH_THE') }} <a href="http://dev107.developer24x7.com/cnp1356/public/privacy-policy" target="_blank">{{ __('messages.PRIVACY_POLICY') }}</a>.
                                                      <input id="privacy_policy_status" type="checkbox" name="privacy_policy_status">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div>
                                                   <!-- <div class="p-0 col-12">
                                                      <label class="check-style fs-12">{{ __('messages.I_HAVE_READ_AND_AGREE_WITH_THE') }} <a href="http://dev107.developer24x7.com/cnp1356/public/cookies-policy" target="_blank">{{ __('messages.COOKIES_POLICY') }}</a>.
                                                      <input id="cookies_policy_status" type="checkbox" name="cookies_policy_status">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div> -->
                                                   <div class="p-0 col-12">
                                                      <label class="check-style fs-12">{{ __('messages.I_WISH_TO_RECEIVE_NEWSLETTER') }} 
                                                      <input id="is_newsletter_subscribed" type="checkbox" name="is_newsletter_subscribed">
                                                      <span class="checkmark"></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endif
                              <form id="step_one" action="" method="post">
                              {{ csrf_field() }}
                              <div class="login-form" id="apply-job-company"> 
                              <input name="job_applied_id" id="job_applied_id" value="{{$jobAppliedId}}" type="hidden"/>
                              <input name="job_id" id="job_id" value="{{$jobId}}" type="hidden"/>
                             <div class="row">
                                <div class="col-sm-12 col-xl-12 apply-job-holder">
                                <div class="form-group">
                                 <label class="question-label">{{__('messages.COVER_LETTER')}}:</label>
                                    <textarea  id="cover_letter" name="cover_letter">{{isset($appliedJob) ? $appliedJob['cover_letter'] : ''}}</textarea>
                                    <label class="error descErr" style="display:none;"></label>
                                 </div>
                                </div>
                             </div>
                             <div class="mt-4 mb-5 row browse-f-sec">
                                <div class="col-12 col-md-12">
                                <label>{{__('messages.UPLOAD_CURRICULUM')}}</label>
                                <div class="p-0 mb-2 mr-sm-2 col-sm-12 wrap-input-container form-inline">
                                       <label class="custom-file-upload form-control">
                                          <i class="fa fa-cloud-upload"></i>{{ isset($uploadedCV) ? $uploadedCV->org_name : 'click here to upload your cv' }}
                                       </label>
                                       <input class="file-upload" name="file" type="file" id="cv">
                                       <button class="btn-clear" type="button" data-role="remove" id="removeCV">
                                          <i class="fa fa-times"></i>
                                       </button>
                                       <input type="hidden" id="is_delete_cv" name="is_delete_cv" value="0">
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-md-6">
                                    <label>{{__('messages.ADDITIONAL_DOCUMENTS')}}</label>
                                    @if(isset($uploadOtherDoc))
                                       @foreach($uploadOtherDoc as $doc)
                                       <div data-role="dynamic-fields">
                                          <div class="form-inline form-row">             
                                             <!-- file upload start-->
                                             <div class="mb-2 mr-sm-2 col-10 col-sm-10 col-md-10 col-lg-11 wrap-input-container">
                                                <label class="custom-file-upload form-control">
                                                   <i class="fa fa-cloud-upload"></i> {{ $doc->org_name }}
                                                </label>
                                                <input class="file-upload" name="additional_doc[]" type="file" id="addDoc">
                                             </div>
                                             <!-- file upload ends-->                
                                                            
                                             <button class="mb-2 btn btn-sm btn-danger btn-cross" data-role="remove">
                                             <i class="fa fa-times"></i>
                                             </button>
                                             <button class="mb-2 btn btn-sm btn-primary" data-role="add">
                                                <i class="fa fa-plus"></i>
                                             </button>
                                          </div>  <!-- /div.form-inline -->
                                       </div>  <!-- /div[data-role="dynamic-fields"] --> 
                                       @endforeach
                                    @endif
                                    <div data-role="dynamic-fields">
                                       <div class="form-inline form-row">             
                                          <!-- file upload start-->
                                          <div class="mb-2 mr-sm-2 col-10 col-sm-10 col-md-10 col-lg-11 wrap-input-container">
                                             <label class="custom-file-upload form-control">
                                                <i class="fa fa-cloud-upload"></i> click here to upload document
                                             </label>
                                             <input class="file-upload" name="additional_doc[]" type="file">
                                          </div>
                                          <!-- file upload ends-->                
                                                            
                                          <button class="mb-2 btn btn-sm btn-danger btn-cross" data-role="remove">
                                          <i class="fa fa-times"></i>
                                          </button>
                                          <button class="mb-2 btn btn-sm btn-primary" data-role="add">
                                             <i class="fa fa-plus"></i>
                                          </button>
                                       </div>  <!-- /div.form-inline -->
                                    </div>  <!-- /div[data-role="dynamic-fields"] --> 
                                 </div> --}}
                             </div>
                             @if(Auth::user() && Auth::user()->is_payment_done == 2)
                             <div class="mt-4 mb-4 row align-items-center justify-content-between">
                                 <div class="mb-2 col-12 form-group">
                                    <label for="staticEmail2">Highlight sentence</label>
                                 </div>
                                 <div class="mb-0 col-12 form-group">
                                    <input type="text" class="form-control" id="inputPassword2" placeholder="Enter your choice" name="highlight_sentence" value="{{ isset($profile) ? $profile->highlight_sentence : '' }}">
                                 </div>
                             </div>
                             @endif
                             <div class="mt-4 row">
                                <div class="text-center col-sm-12">
                               
                                <!-- <button class="btn site-btn-color apply-step-one discard-aftr-1" id="save-as-draft" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.SAVE_AS_DRAFT')}}</button> -->
                                <?php if($jobAppliedId != ''){?>
                                  <!-- <button class="btn site-btn-color discard_job_app discard_job_app_rmvb_1" id="discard_job_app" type="button" data-id="{{$jobAppliedId}}" @if(Auth::user() == NULL) disabled @endif>{{__('messages.DISCARD')}}</button> -->
                                  <?php }?>
                                <?php if($jobDetails['questions']->count() == 0){?>
                                 <button class="btn site-btn-color apply-cls" id="nextbtn-cncl" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.APPLY')}}</button>
                                <?php }else{?>
                                <button class="btn site-btn-color rmv-cls-next" @if(Auth::user() == NULL) disabled @endif id="<?php if(count($specificQuestion['question']) > 0){?>nextbtn<?php }else{?>nextbtn2<?php }?>" type="button">{{__('messages.NEXT')}}</button>
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
                                           <textarea class="form-control"  placeholder="{{__('messages.ANS')}}:" name="answer_{{$key+1}}">{{@$specificQuestion['answer'][$key]}}</textarea>
                                       </div>
                                    <?php }?>
                                    </div>
                                </div>
                             </div>
                             
                             <div class="mt-4 row">
                                <div class="text-center col-12">
                                
                                  <button class="btn site-btn-color" id="prevbtn" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.PREV')}}</button>
                                  <!-- <button class="btn site-btn-color apply-step-two discard-aftr-2" id="save-as-draft" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.SAVE_AS_DRAFT')}}</button> -->
                                  <?php if($jobAppliedId != ''){?>
                                  <!-- <button class="btn site-btn-color discard_job_app discard_job_app_rmvb_2" id="discard_job_app" type="button" data-id="{{$jobAppliedId}}" @if(Auth::user() == NULL) disabled @endif>{{__('messages.DISCARD')}}</button> -->
                                  <?php }?>
                                  <?php if(!empty($interviewQuestion['question'])){ ?>   
                                  <button class="btn site-btn-color" id="nextbtn2" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.NEXT')}}</button>
                                  <?php }else{?>
                                    <button class="btn site-btn-color apply-cls" id="nextbtn2-cncl" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.APPLY')}}</button>
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
                                   <div class="info-holder">
                                       <div class="row">
                                          <div class="mb-3 col-sm-12">
                                             <h4 class="text-left"> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT1')}}  </h4>
                                          </div>
                                          <div class="col-sm-12 col-xl-12">
                                          
                                          <h5 class="total-title"> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT2')}} </h5>
                                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT3')}} </p>
                                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT4')}} </p>
                                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT5')}}</p>
                                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT6')}}  </p>

                                          <h5 class="mt-4 total-title"> {{__('messages.OUR_SUGGESTION')}}:</h5>
                                          <p>  {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT7')}}</p>

                                             <h6 class="h5-title">** {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT8')}} {{count($interviewQuestion['question'])}} {{__('messages.INTERVIEW_QUESTIONS')}}.  </h6>

                                          </div>

                                       </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="interview-question-holder">
                                       <?php if(!empty($interviewQuestion['question'])){
                                          foreach($interviewQuestion['question'] as $key=>$val){
                                             if($key == 0){
                                                $count = '1';
                                             }else if($key == 1){
                                                $count = '2';
                                             }else if($key == 2){
                                                $count = '3';
                                             }
                                          ?>
                                       <div class="mb-5 form-group">
                                          <div class="mb-4 d-flex"> 
                                             <label class="mb-0 page-title">{{$key+1}}.{{__('messages.QUESTION')}} {{$count}} : <span>  {{__('messages.DO_YOU_WANT_TO_ACTIVE_QUESTION')}} </span> </label>
                                             
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
                                          <div class="show_hide_question_{{$key}}" style="<?php  if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ echo 'display:block';}else{ echo 'display:none';}?>">
                                             <div class="d-flex justify-content-between">
                                                <!-- align-items-center -->
                                                <h5 class="my-0 h5-title">Q: {{@$val}}</h5>
                                                <input type="hidden" id="video_question_id_{{$key+1}}" name="video_question_id_{{$key+1}}" value="{{$interviewQuestion['id'][$key]}}"/>
                                                <div class="text-center w-110">
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
                                                <div class="d-flex flex-wrap justify-content-between">
                                                <!-- align-items-center -->
                                                   <h5 class="my-0 h5-title mb-2">{{__('messages.TELL_US')}}</h5>
                                                   <!-- media-action -->
                                                      <div class="media-action">
                                                         <!-- actionicon-box -->
                                                         <div class="actionicon-box row">
                                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                            <!-- actionicon-box-item -->
                                                            <div class="actionicon-box-item media align-items-center">
                                                               <div class="media-icon mr-3">
                                                               <i class="fa fa-microphone"></i>
                                                               </div>
                                                               <div class="media-body">
                                                               {{__('messages.START')}}
                                                               </div>
                                                            </div>
                                                            <!-- actionicon-box-item -->
                                                         </div>
                                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                            <!-- actionicon-box-item -->
                                                            <div class="actionicon-box-item media align-items-center">
                                                               <div class="media-icon mr-3">
                                                               <i class="fa fa-square"></i>
                                                               </div>
                                                               <div class="media-body">
                                                               {{__('messages.STOP')}}
                                                               </div>
                                                            </div>
                                                            <!-- actionicon-box-item -->
                                                         </div>
                                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                            <!-- actionicon-box-item -->
                                                            <div class="actionicon-box-item media align-items-center">
                                                               <div class="media-icon mr-3">
                                                               <i class="fa fa-circle"></i>
                                                               </div>
                                                               <div class="media-body">
                                                               {{__('messages.RECORD')}}
                                                               </div>
                                                            </div>
                                                            <!-- actionicon-box-item -->
                                                         </div>
                                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                            <!-- actionicon-box-item -->
                                                            <div class="actionicon-box-item media align-items-center">
                                                               <div class="media-icon mr-3">
                                                               <i class="fa fa-play"></i>
                                                               </div>
                                                               <div class="media-body">
                                                               {{__('messages.TO_VIEW')}}
                                                               </div>
                                                            </div>
                                                            <!-- actionicon-box-item -->
                                                         </div>
                                                         </div>
                                                         <!-- actionicon-box -->
                                                      </div>
                                                   <!-- media-action -->
                                                <!--  <div class="text-center w-110">
                                                      <div id="timeContainer" class="well well-sm">
                                                      <time id="timerValue">00:00:00</time>
                                                      </div>
                                                   </div>   -->
                                                </div>  
                                                <div class="interview-video-generator" id="video_intro_form_{{$key}}">
                                                   <?php if(@$interviewQuestion['interviewVideo'][$interviewQuestion['id'][$key]] != ''){ ?> 
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
                                             
                                           <p class="mb-0 mt-3 add_text_alert_{{$key}}">
                                           <?php if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ ?>
                                           {{__('messages.SELECT_ONO_OF_VIDEOS_BELOW_YOU_CAN_TRY_3_TIMES')}}
                                           <?php }?>
                                           </p>  
                                         <div class="flex-wrap d-flex justify-content-between "> 
                                             
                                                <div class="select-newstyle">
                                                      <input type="hidden" id="count-atteched-{{$key+1}}" name="count-atteched-{{$key+1}}" value="{{count($attemptArr[$interviewQuestion['id'][$key]])}}"/> 
                                                            <div class="flex-wrap list-inline-item d-flex" id="all-atteched-video-{{$key}}">

                                                            <?php if(!empty($attemptArr[$interviewQuestion['id'][$key]])){ 
                                                              $lastIndex = array_key_last($attemptArr[$interviewQuestion['id'][$key]]);
                                                         foreach($attemptArr[$interviewQuestion['id'][$key]] as $index=>$data){ ?>
                                                               <?php 
                                                               if($index == 0){ ?>
                                                                <label class="mr-2 check-style" style="width:auto;"> <?php
                                                                  echo __('messages.ATTACHMENT').' 1';
                                                               }else if($index == 1){ ?>
                                                                <label class="mr-2 check-style" style="width:auto;"> <?php
                                                                  echo __('messages.ATTACHMENT').' 2';
                                                               }else if($index == 2){ ?>
                                                                <label class="mr-2 check-style" style="width:auto;"> <?php
                                                                  echo __('messages.ATTACHMENT').' 3';
                                                               }
                                                               ?>
                                                               <input type="radio" class="chk-video-cls disable-cls-redio-{{$key}}" data-id="{{$data['id']}}" data-no="{{$key}}" id="attempt-{{$index+1}}" name="attempt_question_{{$key+1}}" value="{{$data['id']}}"  <?php if($data['is_selected'] == 1){ echo 'checked';}else if($lastIndex == $index){ echo 'checked';} ?>>
                                                               <span class="checkmark"></span>
                                                               </label>
                                                               <?php }
                                                         }?>
                                                            </div>
                                                </div>  
                                           
                                                <div id="timerButtons" class="flex-wrap mx-0 mt-2 d-flex">
                                                   <button type="button"  id="stop-{{$key}}" class="mb-2 mr-2 btn btn-danger min-w-130" style="<?php if(count($attemptArr[$interviewQuestion['id'][$key]]) == 0){ echo 'display:block'; }else{ echo 'display:none'; }?>" >{{__('messages.STOP')}}</button>
                                                   <button type="button"  id="start-{{$key}}" class="mb-2 btn site-btn-color min-w-130" style="<?php if((!empty($attemptArr[$interviewQuestion['id'][$key]])) && count($attemptArr[$interviewQuestion['id'][$key]]) < 3){ echo 'display:block'; }else{ echo 'display:none'; }?>">{{__('messages.RESTART')}}</button>
                                                </div> 
                                         </div>       
                                          
                                           </div>
                                          </div>
                                       <?php } }?>
                                                                                                                                                
                                    </div>
                                </div>
                             </div>
                             <div class="mt-4 row">
                                <div class="text-center col-12">
                                <label style="display: none;" class="error upload-error-n-intro"> Error Message </label>
                                 <button class="btn site-btn-color enable-disable-cls-prev" id="<?php if(count($specificQuestion['question']) == 0){?>prevbtn<?php }else{?>prevbtn2<?php }?>" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.PREV')}}</button>
                                  <!-- <button class="btn site-btn-color apply-step-three upload-intro-video-func enable-disable-cls discard-aftr-3" id="save-as-draft" type="button" data-id="0" @if(Auth::user() == NULL) disabled @endif>{{__('messages.SAVE_AS_DRAFT')}}</button> -->
                                  <?php if($jobAppliedId != ''){?>
                                  <!-- <button class="btn site-btn-color discard_job_app enable-disable-cls discard_job_app_rmvb_3" id="discard_job_app" type="button" data-id="{{$jobAppliedId}}" @if(Auth::user() == NULL) disabled @endif>{{__('messages.DISCARD')}}</button> -->
                                  <?php }?>
                                  <button class="btn site-btn-color upload-intro-video-func enable-disable-cls" type="button" data-id="1" @if(Auth::user() == NULL) disabled @endif>{{__('messages.APPLY')}}</button>
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
      <div class="modal custom-modal profile-modal " id="tips-interview-copy">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <div class="row">
                        <div class="mb-3 col-sm-12">
                           <h4 class="text-left"> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT1')}}  </h4>
                        </div>
                        <div class="col-sm-12 col-xl-12">
                          
                          <h5 class="total-title"> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT2')}} </h5>
                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT3')}} </p>
                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT4')}} </p>
                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT5')}}</p>
                          <p><i class="mr-2 fa fa-paper-plane-o" aria-hidden="true"></i> {{__('messages.APPLY_JOB_STEP3_TIPS_TEXT6')}}  </p>

                          <h5 class="mt-4 total-title"> {{__('messages.OUR_SUGGESTION')}}:</h5>
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

<!-- <script>
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
  </script> -->

   <script>
      $('document').ready( function(){
         $( '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]' ).each(function( index ) {
          if(index == 0){
            $(this).prop('disabled', false);
          }
        });
         
      });
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
function checkCamera(){
   //Is Camera enable or disable
   navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

   navigator.getMedia({video: true}, function() {
   // webcam is available
   }, function() {
   // webcam is not available
   swal(lanFilter(allMsgText.SORRY_NO_CAMERA_FOUND))
         .then((value) => {
         location.reload();
      });
   });
  
}
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
         swal(lanFilter(allMsgText.SORRY_NO_CAMERA_FOUND))
            .then((value) => {
              location.reload();
          });
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
         
         //Is Camera enable or disable
         setInterval(function(){ 
            checkCamera();
         }, 2000);
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
                  var fileName = 'Video '+length;
                  html = '<div class="apply-job-video-sec" id="attempt-label-'+length+'" ><label  class="mr-2 check-style" style="width:auto;"><p class="video_name">'+fileName+'</p><input type="radio" class="chk-video-cls disable-cls-redio-0" data-id="'+attempId+'" data-no="0" id="attempt-"'+length+' name="attempt_question_1" value="'+attempId+'" ><span class="checkmark"></span></label> <label title="Remove" class="delete_this_video" data-value="'+length+'" ><i  class=" las la-times" ></i></label></div>';
                  //html = '<div  style="float:left" clas="attachment"><input type="radio" id="attempt-"'+length+' name="attempt_question_1" value="'+attempId+'"><label for="male">'+fileName+'</label></div>';
                  $('#all-atteched-video-0').append(html);
                  $(".enable-disable-cls").attr("disabled", false);
                  $(".enable-disable-cls-prev").attr("disabled", false);
                  if(length == 1){
                     $('.add_text_alert_0').html($this.lanFilter(allMsgText.SELECT_ONO_OF_VIDEOS_BELOW_YOU_CAN_TRY_3_TIMES));
                  }
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
         swal(lanFilter(allMsgText.SORRY_NO_CAMERA_FOUND))
            .then((value) => {
              location.reload();
          });
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
         
         //Is Camera enable or disable
         setInterval(function(){ 
            checkCamera();
         }, 2000);
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
                  let fileName = 'Video '+length;
                  html = '<div class="apply-job-video-sec" id="attempt-label-'+length+'"><label class="mr-2 check-style"   style="width:auto;"><p class="video_name">'+fileName+'</p><input type="radio" class="chk-video-cls disable-cls-redio-1" data-id="'+attempId+'" data-no="1" id="attempt-"'+length+' name="attempt_question_2" value="'+attempId+'" ><span class="checkmark"></span></label></label> <label title="Remove" class="delete_this_video" data-value="'+length+'" ><i  class=" las la-times" ></i></label></div>';
                  //html = '<div  style="float:left" clas="attachment"><input type="radio" id="attempt-"'+length+' name="attempt_question_2" value="'+attempId+'"><label for="male">'+fileName+'</label></div>';
                  $('#all-atteched-video-1').append(html);
                  $(".enable-disable-cls").attr("disabled", false);
                  $(".enable-disable-cls-prev").attr("disabled", false);
                  if(length == 1){
                     $('.add_text_alert_1').html($this.lanFilter(allMsgText.SELECT_ONO_OF_VIDEOS_BELOW_YOU_CAN_TRY_3_TIMES));
                  }
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
         swal(lanFilter(allMsgText.SORRY_NO_CAMERA_FOUND))
            .then((value) => {
              location.reload();
          });
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

         //Is Camera enable or disable
         setInterval(function(){ 
            checkCamera();
         }, 2000);
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
                  let fileName = 'Video '+length;
                  html = '<div class="apply-job-video-sec" id="attempt-label-'+length+'"><label class="mr-2 check-style"  style="width:auto;"><p class="video_name">'+fileName+'</p><input type="radio" class="chk-video-cls disable-cls-redio-2" data-id="'+attempId+'" data-no="2" id="attempt-"'+length+' name="attempt_question_3" value="'+attempId+'" ><span class="checkmark"></span></label></label> <label title="Remove" class="delete_this_video" data-value="'+length+'" ><i  class=" las la-times" ></i></label></div>';
                  //html = '<div  style="float:left" clas="attachment"><input type="radio" id="attempt-"'+length+' name="attempt_question_3" value="'+attempId+'"><label for="male">'+fileName+'</label></div>';
                  $('#all-atteched-video-2').append(html);
                  $(".enable-disable-cls").attr("disabled", false);
                  $(".enable-disable-cls-prev").attr("disabled", false);
                  if(length == 1){
                     $('.add_text_alert_2').html($this.lanFilter(allMsgText.SELECT_ONO_OF_VIDEOS_BELOW_YOU_CAN_TRY_3_TIMES));
                  }
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
//function to delete seleted video
$(document).on('click','.delete_this_video',function(event){
         // event.stopPropagation();
         var clicked_video_block = $(this).parent().parent();
         var clicked_block_id = clicked_video_block.attr('id'); 
         var video_number = $(this).attr('data-value');
         var $clickedEvent = $(this);
         switch(clicked_block_id){
               case 'all-atteched-video-0':                      
                      clicked_video_block.find('#attempt-label-'+video_number).fadeOut().remove();
                      //$clickedEvent.fadeOut().remove(); 
                     // console.log('old length :: '+video_one_stack.length);                    
                      video_one_stack.splice((parseInt(video_number)-1), 1);
                     // console.log('new length ::'+video_one_stack.length); 
                     // console.log(' Old validationCount1 :: '+validationCount1);
                      validationCount1--;
                     // console.log(' New validationCount1 :: '+validationCount1);

                      // revert record button
                       if(video_one_stack.length == 2){
                          $('#start-0').show();   
                          $('#stop-0').hide(); 
                      }
                      // shuffle video labels
                      let selectedLoopsVideo1 = clicked_video_block.find('.check-style');
                         if(selectedLoopsVideo1.length){
                             $(selectedLoopsVideo1).each(function(index,element){
                                $(this).find('.video_name').text('video '+(index+1));
                              });
                             
                         }
                    if(selectedLoopsVideo1.length == 0){
                        video_one_stack.length = 0
                    }
               break;
               case 'all-atteched-video-1':

                      clicked_video_block.find('#attempt-label-'+video_number).fadeOut().remove();
                    //  $clickedEvent.fadeOut().remove(); 
                     // console.log('old length :: '+video_one_stack.length);                    
                      video_two_stack.splice((parseInt(video_number)-1), 1);
                     // console.log('new length ::'+video_one_stack.length); 
                     // console.log(' Old validationCount1 :: '+validationCount1);
                      validationCount2--;
                     // console.log(' New validationCount1 :: '+validationCount1);

                      // revert record button
                       if(video_two_stack.length == 2){
                          $('#start-1').show();   
                          $('#stop-1').hide(); 
                      }
                      // shuffle video labels
                      let selectedLoopsVideo2 = clicked_video_block.find('.check-style');
                         if(selectedLoopsVideo2.length){
                             $(selectedLoopsVideo2).each(function(index,element){
                                $(this).find('.video_name').text('video '+(index+1));
                              });
                             
                         }
                     if(selectedLoopsVideo2.length == 0){
                        video_two_stack.length = 0
                     }    
               break;
               case 'all-atteched-video-2':

                      clicked_video_block.find('#attempt-label-'+video_number).fadeOut().remove();
                    //  $clickedEvent.fadeOut().remove(); 
                     // console.log('old length :: '+video_one_stack.length);                    
                      video_three_stack.splice((parseInt(video_number)-1), 1);
                     // console.log('new length ::'+video_one_stack.length); 
                     // console.log(' Old validationCount1 :: '+validationCount1);
                      validationCount3--;
                     // console.log(' New validationCount1 :: '+validationCount1);

                      // revert record button
                       if(video_three_stack.length == 2){
                          $('#start-2').show();   
                          $('#stop-2').hide(); 
                      }
                      // shuffle video labels
                      let selectedLoopsVideo3 = clicked_video_block.find('.check-style');
                         if(selectedLoopsVideo3.length){
                             $(selectedLoopsVideo3).each(function(index,element){
                                $(this).find('.video_name').text('video '+(index+1));
                              });
                             
                         }
                      if(selectedLoopsVideo3.length == 0){
                        video_three_stack.length = 0
                     } 
               break;
               default:
                       console.log('no match');
         }
});
</script>

<script type="text/javascript">
   $(document).on('change', '.file-upload', function(){
       //var files = $(this).prop("files");
      // console.log(files);
       if ($(this).prop("files")) {
         $(this).siblings('.custom-file-upload').addClass('active');
       }else{
         $(this).siblings('.custom-file-upload').removeClass('active');
       }
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
