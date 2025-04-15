@extends('layouts.app_after_login_layout')
@section('content')
<?php $user_type = Auth::user()->user_type; $currentCompanyArr = [];?>
<input type="hidden" name="user_type" value="{{$user_type}}" id="user_type"/>
 <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
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
  <script type="text/javascript"> var introVideoData; </script>
  
  <!-- End Js video library section -->

      <!-- main -->
      <main>
         <section class="section-myprofile-outer">
            <div class="container">
               <div class="row">
                  <div class="col-12 col-lg-4 col-xl-3">
                        <div class="profile-side-panel">
                           <div class="details-panel-header mb-4">
                              <div class="profile-img-holder">
                                 <div class="profile-bg-img">
                                    <?php if(!empty($profileData['banner_image'])){?>
                                       <img id="banner-image-src" src="{{asset($profileData['banner_image']['location'])}}" alt="Profile Background Image">
                                    <?php }else{?>
                                       <img id="banner-image-src" src="<?php echo url('/');?>/frontend/images/user-pro-bg-img.jpg" alt="Profile Background Image">
                                    <?php }?>
                                    
                                    <div class="msk d-flex justify-content-center " data-toggle="modal" data-target="#change-image-banner">
                                        <img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon">
                                    </div>

                                    <a href="javascript:void(0)" class="crossprofile remove-old-banner-img-func"><i class="la la-times"></i></a>
                                 </div> 
                                 <div class="profile-img">
                                    <?php if(!empty($profileData['profile_image'])){?>
                                       <img id="profile-image-src" src="{{asset($profileData['profile_image']['location']) }}" alt="Profile Image">
                                    <?php }else{?>
                                       <img id="profile-image-src" src="<?php echo url('/');?>/frontend/images/user-pro-img-demo.png" alt="Profile Image">
                                    <?php }?>
                                    <div class="msk d-flex justify-content-center" data-toggle="modal" data-target="#change-image">
                                       <img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon">
                                    </div>
                                    
                                 </div>
                              </div>   
                             <h3 class="h3-profile user-dynamic-name-func"><?php echo ($profileData['first_name']?base64_decode($profileData['first_name']):'') .' '. ($profileData['last_name']?$profileData['last_name']:'') ;?></h3>
                             <h5 class="text-company user-profession-finc"><?php echo (isset($profileData['profile']['profile_headline'])?$profileData['profile']['profile_headline']:'');?></h5>
                             <h6 class="color-lightgray address-data-func"><?php echo (isset($profileData['state']['name'])?$profileData['state']['name']:'');?></h6>
                           </div>
                              <h4 class="h4-head">{{__('messages.PROFILE_INFORMATION')}}</h4>
                           <div class="one-pagenav">
                              <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
                                 <ul class="navlist">
                                    <li> <a class="js-scroll-trigger" href="#section1"> {{__('messages.PERSONAL_INFORMATION')}} </a> </li>
                                    <li> <a class="js-scroll-trigger" href="#section2"> {{__('messages.PROFESSIONAL_INFORMATION')}} </a></li>
                                    <li> <a class="js-scroll-trigger" href="#section3"> {{__('messages.HOBBIES')}} </a> </li>
                                    <li> <a class="js-scroll-trigger" href="#section4"> {{__('messages.CV_SUMMARY')}} </a> </li>
                                    <!-- <li> <a class="js-scroll-trigger" href="#section5"> {{__('messages.UPLOAD_CV')}}  </a></li> -->
                                    <li> <a class="js-scroll-trigger" href="#section6"> {{__('messages.UPLOAD_INTRO_VIDEO')}} </a> </li>
                                 </ul>
                              </nav>
                           </div>
                        </div>
                  </div>
                  <div class="col-12 col-lg-8 col-xl-9">
                     <div class="edit-profile-holder">
                        <section class="section-myprofile" id="section1">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <div class="edit-info-holder">
                                       <h4>{{__('messages.PERSONAL_INFORMATION')}}</h4>
                                       <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                                       <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#professional-info" ><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon"></button>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.NAME')}}:</label> 
                                      <span class="first_name_func"> 
                                       {{ base64_decode($profileData['first_name']) }}
                                       </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.PROFILE_HEADLINE')}}/{{__('messages.KEYWORD')}} :</label> 
                                      <span class="profile_headline_func"><?php echo ($profileData['profile']['profile_headline']?$profileData['profile']['profile_headline']:'');?>
                                   </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.EMAIL')}} : <span>({{__('messages.ONLY_COMPANIES_WILL_BE_ABLE_TO_SEE_YOUR_EMAIL')}})</span></label> 
                                      <span class="email_func">{{ base64_decode($profileData['email']) }}</span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.COUNTRY')}} :</label> 
                                      <span class="country_id_func">
                                      <?php echo (isset($profileData['country']['name'])?$profileData['country']['name']:'');?>
                                       </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.STATE')}} :</label> 
                                      <span class="state_id_func">
                                      <?php echo (isset($profileData['state']['name'])?$profileData['state']['name']:'');?>
                                      </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.CITY') }} :</label> 
                                       <span class="city_id_func">
                                       <?php echo ($profileData['city_id']?$profileData['city_id']:'');?>
                                       </span>
                                    </div>
                                 </div>
                                 <!-- <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.ADDRESS_LINE1')}} :</label> 
                                      <span class="address1_func">
                                         <?php // echo ($profileData['address1']?$profileData['address1']:'');?>
                                      </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.ADDRESS_LINE2')}} :</label> 
                                      <span class="address2_func">
                                      <?php //echo ($profileData['address2']?$profileData['address2']:'');?>
                                     </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                      <label class="label-tag">{{__('messages.ZIP_CODE')}} :</label> 
                                      <span class="postal_func">
                                       <?php //echo ($profileData['postal']?$profileData['postal']:'');?>
                                    </span>
                                    </div>
                                 </div> -->
                              </div>
                           </div>
                        </section>
                        <section class="section-myprofile myprofile-highlight-section">
                        <!-- <p><span>Upload your Recommendation Letter:</span> <p>
                        <p>By the time you apply for a specific position, you will be able to also upload your Recommendation Letter.</p>
                        <p><span>Increase your chances to be hired:</span> we recomend you to fill in all information below! This is how companies can find you!
                        </p> -->
                        <?php echo $cmsData[0]['text'];?>
                        </section>
                        <section class="section-myprofile" id="section2">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <h4> {{__('messages.PROFESSIONAL_INFO')}} </h4>
                                    <h6> {{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                                 </div>
                              </div>
                              <div class="companydetails">
                                 <div class="row">
                                    <div class="col-sm-12 details-panel-header">
                                       <div class="edit-info-holder">
                                          <h5 class="total-title"> {{__('messages.COMPANY_DETAILS')}} </h5>
                                          <button class="btn site-btn-color addbtn" data-toggle="modal" data-target="#add-professional-experience" >+</button> 
                                       </div>
                                    </div>
                                 </div> 
                                 <span id="apend_data"></span>
                                 <?php if(!empty($profileDataOld['professionalInfo'])){ ?>

                                  <div class="row section-infodata">
                                  <div class="col">
                                 <?php foreach($profileDataOld['professionalInfo'] as $key=>$value){
                                    array_push($currentCompanyArr,$value['currently_working_here']);
                                  ?>
                                 <div class="row section-infodata-item" id="edit_company_details_<?php echo $value['id'];?>"> 
                                    <div class="col-12">
                                       <div class="edit-info-holder">
                                        <div class="edit-delete-btn-holder">
                                          <button class="btn site-btn-color editbtn profEditCls" id="professional_edit_<?php echo $key+1;?>" data-id="{{$value['id']}}" data-edit-chk="{{$value['currently_working_here']}}"><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon"></button>
                                          <button class="btn site-btn-color editbtn deleteProf" id="professional_edit_<?php echo $key+1;?>" data-id="{{$value['id']}}" data-current-chk="{{$value['currently_working_here']}}"><i class="las la-trash"></i></button>
                                        </div>
                                       </div>
                                    </div>   
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.TITLE')}} :</label>
                                          <span class="title_func">
                                            {{($value['title']?$value['title']:'')}}
                                          </span>
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.TYPE_OF_EMPLOYMENT')}} :</label>
                                          <span class="type_of_employment_func">
                                          <?php if($value['type_of_employment'] == 1){?>
                                             {{__('messages.FULL_TIME')}}
                                          <?php }else if($value['type_of_employment'] == 2){?>
                                             {{__('messages.PART_TIME')}}
                                          <?php }else if($value['type_of_employment'] == 3){?>
                                             {{__('messages.CONTRACT')}}
                                          <?php }else if($value['type_of_employment'] == 4){?>
                                             {{__('messages.INTERNSHIP')}}
                                          <?php }else if($value['type_of_employment'] == 5){?>
                                             {{__('messages.SELF_EMPLOYED')}}
                                          <?php }?>
                                        </span>
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.COMPANY_NAME')}} :</label>
                                          <span class="company_name_func">
                                          {{($value['company_name']?$value['company_name']:'')}}
                                        </span>
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.CURRENTLY_WORKING_HERE')}} :</label>
                                          <span class="currently_working_here_func">
                                          <?php if($value['currently_working_here'] == 1){?>
                                             {{__('messages.YES')}}
                                          <?php }else{?>
                                             {{__('messages.NO')}}
                                          <?php }?>
                                        </span>
                                       </div>                                  
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.START_DATE')}} :</label>
                                          <span class="start_date_func">
                                          {{($value['start_date']?date('Y-m-d',strtotime($value['start_date'])):'')}}
                                        </span>
                                       </div>
                                    </div>
                                    <!-- if  Currently Working Here no this shuld be show -->
                                    
                                    <?php if($value['end_date'] != ''){?>
                                    <div class="col-12 col-sm-12 col-md-6 endCls">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.END_DATE')}} :</label>
                                          <span class="end_date_func">
                                          {{($value['end_date']?date('Y-m-d',strtotime($value['end_date'])):'')}}
                                        </span>
                                       </div>
                                    </div>
                                  <?php }else{?>
                                    <div class="col-12 col-sm-12 col-md-6 endCls" style="display:none;">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.END_DATE')}} :</label>
                                          <span class="end_date_func">
                                          {{($value['end_date']?date('d-m-Y',strtotime($value['end_date'])):'')}}
                                        </span>
                                       </div>
                                    </div>
                                  <?php }?>
                                 </div> 
                                <?php } ?>
                              </div>
                            </div>
                             <?php } $currentCompanyArr = json_encode($currentCompanyArr);?>

                              </div>

                              <div class="education-details">
                                 <div class="row"> 
                                    <div class="col-sm-12 details-panel-header">
                                       <div class="edit-info-holder">
                                          <h5 class="total-title"> {{__('messages.EDUCATION_DETAILS')}} </h5>
                                          <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#add-education">+</button>
                                       </div>
                                    </div>
                                 </div> 
                                 <span id="apend_education_data"></span> 
                                 <?php if(!empty($profileDataOld['educationalInfo'])){ ?>
                                    <!-- section-infodata -->
                                    <div class="row section-infodata">
                                      <div class="col">
                                        <?php foreach($profileDataOld['educationalInfo'] as $key=>$value){ ?>
                                          <!-- section-infodata-item -->
                                          <div class="row section-infodata-item" id="edit_education_details_<?php echo $value['id'];?>"> 
                                            <div class="col-sm-12">
                                               <div class="edit-info-holder">
                                                <div class="edit-delete-btn-holder">
                                                  <button class="btn site-btn-color editbtn educationEditCls" data-id="{{$value['id']}}"><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon"></button>
                                                  <button class="btn site-btn-color editbtn deleteEducation" data-id="{{$value['id']}}"><i class="las la-trash"></i></button>
                                                </div>
                                               </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                               <div class="form-view">
                                                  <label class="label-tag">{{__('messages.SCHOOL')}} :</label>
                                                  <span class="school_name_func">
                                                 {{($value['school_name']?$value['school_name']:'')}}
                                               </span>
                                               </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                               <div class="form-view">
                                                  <label class="label-tag">{{__('messages.DEGREE')}} :</label>
                                                  <span class="degree_func">
                                                  {{($value['degree']?$value['degree']:'')}}
                                                </span>
                                               </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                               <div class="form-view">
                                                  <label class="label-tag">{{__('messages.FIELD_OF_STUDY')}} :</label>
                                                  <span class="subject_func">
                                                  {{($value['subject']?$value['subject']:'')}}
                                                </span>
                                               </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                               <div class="form-view">
                                                  <label class="label-tag">{{__('messages.START_YEAR')}} :</label>
                                                  <span class="start_year_func">
                                                  {{($value['start_year']?$value['start_year']:'')}}
                                                </span>
                                               </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                               <div class="form-view">
                                                  <label class="label-tag">{{__('messages.END_YEAR')}} :</label>
                                                  <span class="end_year_func">
                                                  {{($value['end_year']?$value['end_year']:'')}}
                                                </span>
                                               </div>
                                            </div>
                                          </div>
                                          <!-- section-infodata-item -->
                                        <?php } ?>
                                      </div>
                                    </div>
                                    <!-- section-infodata -->
                                <?php } ?>

                              <div class="language-details">
                                 <div class="row"> 
                                    <div class="col-sm-12 details-panel-header">
                                       <div class="edit-info-holder">
                                          <h5 class="total-title"> {{__('messages.LANGUAGE_DETAILS')}} </h5>
                                          <?php if(!empty($profileDataOld['cmsBasicInfo'])){ 
                                            $langCount = 0;
                                          foreach($profileDataOld['cmsBasicInfo'] as $key=>$lang){ 
                                             if($lang['language'] != null){
                                              $langCount++;
                                             }
                                           }
                                         }
                                          ?>
                                          <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#add-language" <?php if($langCount > 6){ echo 'disabled';}?>>+</button>
                                        
                                       </div>
                                    </div>
                                 </div> 
                                 <span id="langAddCls"></span>
                                 <?php if(!empty($profileDataOld['cmsBasicInfo'])){ 
                                    foreach($profileDataOld['cmsBasicInfo'] as $key=>$lang){ 
                                       if($lang['language'] != null){  
                                    ?>
                                 <div class="row" id="edit_language_details_<?php echo $lang['language']['id'];?>"> 
                                    <div class="col-sm-12">
                                       <div class="edit-info-holder">
                                          <div class="edit-delete-btn-holder">
                                            <button class="btn site-btn-color editbtn langEditCls" data-lang="{{$lang['language']['id']}}" data-prof="{{$lang['language']['fluency']['fluencyLabel']['id']}}"><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg" alt="Edit-icon"></button>
                                            <button class="btn site-btn-color editbtn deleteLang" data-lang="{{$lang['language']['id']}}" data-prof="{{$lang['language']['fluency']['fluencyLabel']['id']}}"><i class="las la-trash"></i></button>
                                          </div>
                                       </div>
                                    </div>   
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.LANGUAGE')}}</label>
                                          <span class="lang_name_func">
                                          {{$lang['language']['name']}}
                                        </span>
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.PROFICIENCY_LEVEL')}}</label>
                                          <span class="fluency_func">
                                          {{($lang['language']['fluency']['fluencyLabel']['name']?$lang['language']['fluency']['fluencyLabel']['name']:'')}}
                                        </span>
                                       </div>
                                    </div>
                                 </div>
                              <?php } } }?>
                              <div class="row">
                                 <div class="col-sm-12 details-panel-header">
                                    <div class="edit-info-holder">
                                       <h5 class="total-title"> {{__('messages.IT_SKILL')}} </h5>
                                       <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#others"><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg" alt="Edit-icon"></button>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-view">
                                      <!-- <label class="label-tag mb-2"> {{__('messages.IT_SKILL')}}</label> -->
                                       <ul class="skill-tags" id = "skillPrev">
                                          <?php $skillArr = [];
                                           if(!empty($profileDataOld['userSkill'])){ 
                                          foreach($profileDataOld['userSkill'] as $key=>$val){
                                            array_push($skillArr,$val['skill']['id']);
                                            ?>
                                          <li><span>{{$val['skill']['name']}}</span></li>
                                         <?php } }?>    
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                        <section class="section-myprofile" id="section3">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-sm-12 details-panel-header">
                                    <div class="edit-info-holder">
                                       <h4>{{__('messages.HOBBIES')}}</h4>
                                       <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#hobbies"><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg" alt="Edit-icon"></button>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-view">
                                      <!-- <label class="label-tag mb-2"> {{__('messages.HOBBIES')}}</label> -->
                                       <ul class="skill-tags" id = "hobbyPrev">
                                          <?php $hobbyArray = [];
                                          if(!empty($profileDataOld['cmsBasicInfo'])){ 
                                          foreach($profileDataOld['cmsBasicInfo'] as $key=>$lang){
                                             if($lang['hobby'] != null){
                                              array_push($hobbyArray,$lang['hobby']['name']);
                                          ?>
                                          <li><span>{{$lang['hobby']['name']}}</span></li>
                                          <?php } } }?>
                                          <!-- <li><span>Fashion</span></li>
                                          <li><span>Cooking</span></li>
                                          <li><span>Listening to music</span></li>
                                          <li><span>Makeup</span></li>  
                                          <li><span>Watching movies</span></li> -->     
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                        <section class="section-myprofile" id="section4">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <div class="edit-info-holder">
                                       <h4>{{__('messages.CV_SUMMARY')}}</h4>
                                       <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                                       <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#cv-summary" ><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg" alt="Edit-icon"></button>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-view">
                                       <p id="cvSummaryPrev">{{($profileDataOld['profile']['cv_summary']?$profileDataOld['profile']['cv_summary']:'')}}</p>
                                    </div>   
                                 </div>
                                 
                              </div>
                           </div>
                        </section>
                                                
                        <section class="section-myprofile" id="section6">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                  <div class="edit-info-holder details-panel-header-pr-new">
                                       <div class="details-panel-header-pr-new-left">
                                       <h4>{{__('messages.INTRODUCTION_YOURSELF_VIA_VIDEO')}}</h4>
                                       <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                                       </div>
                                       <div  class="details-panel-header-pr-new-right">
                                          <h6 class="error-color">({{__('messages.ONLY_COMPANIES_WILL_HAVE_ACCESS_TO_THIS_VIDEO')}})</h6>
                                       </div>
                                       <button class="btn site-btn-color editbtn open-intro-modal-func" data-toggle="modal" data-target="#intro-video" data-backdrop="static" data-keyboard="false"><img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg" alt="Edit-icon"></button>
                                   </div>
                                    <!-- <div class="edit-info-holder">
                                       <h5 class="form-sub-heading intro-video-msg"> 
                                       {{__('messages.INTRO_VIDEO_LINE1')}} 
                                       <strong>{{__('messages.INTRO_VIDEO_LINE2')}}</strong>
                                       <p>
                                       {{__('messages.INTRO_VIDEO_LINE3')}} 
                                       <span>{{__('messages.INTRO_VIDEO_LINE4')}}</span>
                                     </p>
                                       </h5> 
                                       
                                    </div>-->
                                 </div>
                                 <div class="col-12">
                                   <div class="form-view new">
                                     <p id="cvSummaryPrev">
                                        {{__('messages.INTRO_VIDEO_LINE1')}} 
                                        <strong>{{__('messages.INTRO_VIDEO_LINE2')}}</strong><br>
                                        {{__('messages.INTRO_VIDEO_LINE3')}} 
                                       <span>{{__('messages.INTRO_VIDEO_LINE4')}}</span>
                                     </p>
                                   </div>

                                 </div>
                                 <div class="col-12">
                                    
                                   <?php 
                                   if(!empty($profileDataOld['introVideo'])){
                                         $uploadedIntroStatus = 'flex';
                                         $uploadedIntroDefault = 'none';
                                      }else{
                                         $uploadedIntroStatus = 'none';
                                         $uploadedIntroDefault = 'flex';
                                      }
                                       
                                   ?>
                                  <div style="display: {{ $uploadedIntroStatus }}!important" class="intro-new-video intro-video intro-video-div-func">
                                       <a href="javascript:void(0)" class="crossprofile"><i class="la la-times remove-intri-video-func"></i></a>
                                        <video   controls class="video-js vjs-default-skin" >
                                              <source src="{{asset(isset($profileDataOld['introVideo']['location'])?$profileDataOld['introVideo']['location']:'')}}" type="video/mp4">                                                                                    
                                        </video>  
                                    </div>  
                                   
                                    <!-- intro video uploader -->
                                    <div id="intro-video-default" style="display: {{ $uploadedIntroDefault }}!important" class="intro-video-default align-items-center justify-content-center">
                                       <div class="text-center">
                                          <i class="la la-cloud-upload-alt"></i>
                                          <h4 class="total-title mb-4 file-uploding-progress"> {{__('messages.DRAG_AND_DROP_FILES_HERE_TO_UPLOAD')}}</h4>
                                          <p style="display: none;" class="file-upload-error-drop"></p>
                                          <div class="d-flex align-items-center flex-wrap justify-content-center "> 
                                             <div class="custom-inputfile mx-2 mb-3">             
                                                <input type="file" id="intro_video">
                                                <label for="intro_video" id="intro_video_label">
                                                {{__('messages.UPLOAD_FROM_DEVICE')}}</label>      
                                             </div> 
                                             <button class="btn site-btn-color open-record-intro-popup  mx-2 mb-3">{{__('messages.RECORD_YOUR_VIDEO')}}</button>
                                          </div> 
                                          <h6 style="display: none;" class="error upload-error-n-intro"> Error Message </h6>  
                                       </div>

                                    </div>
                                    <!-- end intro video uploader -->
                                   
                                 </div>
                                 
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <!-- main End -->
      <!--footer start-->
      <!-- <script src="{{ asset('frontend/js/dropzone.min.js')}}"></script>
      <script src="{{ asset('frontend/js/aos.js')}}"></script>
      <script src="{{ asset('frontend/js/jquery.easing.min.js')}}"></script>
      <script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>
      <script src="{{ asset('frontend/js/tagsinput.js')}}"></script> 
      <script src="{{ asset('frontend/js/swiper.min.js')}}"></script> -->
      <script src="{{ asset('frontend/js/profile.users.js')}}"></script>      
      <script src="{{ asset('frontend/js/cropper.js')}}"></script>
      <!--footer end-->
       <!-- ================Modal================ -->
      <!-- change-image -->
      <div class="modal custom-modal change-image" id="change-image" >
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="upload-photo d-flex justify-content-between">
                     <div class="upload-photo-inner" data-toggle="modal" data-target="#change-image-before">
                        <div class="upload-images "> <img class="upload-images-func" src="<?php echo url('/');?>/frontend/images/ic-user-upload-photo.svg" alt="user">  </div>
                        <h4>{{__('messages.UPLOAD_PHOTO')}}</h4>
                     </div>
                     <div class="upload-photo-inner">
                        <div class="upload-images remove-old-profile-image-func"> <img src="<?php echo url('/');?>/frontend/images/ic-user-remove-photo.svg" alt="remove"> </div>
                        <h4 id="change-image-remove">{{__('messages.REMOVE_EXISTING_IMAGE')}} </h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- change-image -->

      <!-- change banner image -->
      <div class="modal custom-modal change-image new-upload-modal" id="change-image-banner" >
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close close-image" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <!-- <div class="upload-photo d-flex justify-content-between">
                     <div class="upload-photo-inner" data-toggle="modal" data-target="#change-image-before-banner">
                        <div class="upload-images"> <img class="upload-images-banner-func" src="<?php echo url('/');?>/frontend/images/ic-user-upload-photo.svg" alt="user">  </div>
                        <h4>Upload Photo</h4>
                     </div>
                     <div class="upload-photo-inner">
                        <div class="upload-images remove-old-banner-image-func"> <img src="<?php echo url('/');?>/frontend/images/ic-user-remove-photo.svg" alt="remove"> </div>
                        <h4 id="change-image-remove-banner">Remove Existing Image</h4>
                     </div>
                  </div> -->
                     <nav>
                     <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <!-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{__('messages.UPLOAD_PHOTO')}}</a> -->
                        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">{{__('messages.UPLOAD_FROM_LIBRARY')}}</a>
                     </div>
                     </nav>
                     <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                           <!-- <h5 class="mt-0 heading-profile-img">{{__('messages.IMAGE_UPLOAD')}} </h5> -->
                           <div class="drag-div">
                              <span class="after-span top-left"></span> <span class="after-span top-right"></span>
                              <span class="after-span bottom-left"></span> <span class="after-span bottom-right"></span>
                             <!--  <form action="/file-upload" class="dropzone" id="myBannerDropzone">
                                 <div class="fallback">
                                    <input name="file" type="file" multiple />
                                 </div>
                              </form> -->
                              <div class="dropzone" id="myBannerDropzone"></div>
                              <div class="drag-div-inner">
                                 <h6 id="upload_banner_image_now">{{__('messages.UPDATE_IMAGE')}}</h6>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                           <!-- <h3 class="heading-profile-img mt-0"> {{__('messages.UPLOAD_FROM_LIBRARY')}} </h3> -->
                           <div class="mCustomScrollbar max-height">
                              <div class="profile-bg ">
                                @if($imageLibrary)
                                    @foreach($imageLibrary as $imgLibRow)
                                     <div data-id="{{$imgLibRow['id']}}" class="profile-banner-holder func-profile-banner-holder <?php if(isset($profileData['banner_image']['org_name']) && $profileData['banner_image']['org_name'] == $imgLibRow['org_name']){ echo "selected-banner";}?>">
                                        <div class="banner-holder">
                                           <img src="{{asset('/')}}{{$imgLibRow['location']}}" alt="Profile Background Image">
                                           <a href="javascript:void(0)" class="crossprofile"><i class="las la-check"></i></a>
                                        </div>
                                     </div> 
                                     @endforeach
                                 @endif
                                
                              </div>
                           </div>
                           <div class="d-block mt-3">
                              <button class="site-btn-color btn upload-lib-banner-func" type="button">{{__('messages.UPDATE_JOB')}}</button>
                           </div>
                              
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>
    <?php /*  <div class="modal custom-modal change-image profile-img-upload" id="change-image-before-banner">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <h5 class="text-center mt-0 heading-profile-img"> Profile Background Image Upload </h5>
                  <div class="drag-div">
                     <span class="after-span top-left"></span> <span class="after-span top-right"></span>
                     <span class="after-span bottom-left"></span> <span class="after-span bottom-right"></span>
                    <!--  <form action="/file-upload" class="dropzone" id="my-awesome-dropzone">
                        <div class="fallback">
                           <input name="file" type="file" multiple />
                        </div>
                     </form> -->
                     <div class="dropzone" id="myBannerDropzone"></div>
                     <div class="drag-div-inner">
                        <h6 id="upload_banner_image_now" class="upload-profile-img-func">update image</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> */ ?>
      <!-- End change banner image -->

      <!-- change-image-before -->
      <div class="modal custom-modal change-image profile-img-upload" id="change-image-before">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close close-image" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <h5 class="text-center mt-0 heading-profile-img"> {{__('messages.PROFILE_IMAGE_UPLOAD')}} </h5>
                  <div class="drag-div">
                     <span class="after-span top-left"></span> <span class="after-span top-right"></span>
                     <span class="after-span bottom-left"></span> <span class="after-span bottom-right"></span>
                    <!--  <form action="/file-upload" class="dropzone" id="my-awesome-dropzone">
                        <div class="fallback">
                           <input name="file" type="file" multiple />
                        </div>
                     </form> -->
                     <div class="dropzone" id="myDropzone"></div>
                     <div class="drag-div-inner">
                        <h6 id="upload_image_now" class="upload-profile-img-func">{{__('messages.UPDATE_IMAGE')}}</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- change-image-before -->


      <!-- ================profile-modal================ -->
      <!-- professional-info -->
      <div class="modal custom-modal profile-modal" id="professional-info">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <form name="form_profile_info" id="form_profile_info" action="{{ url('/candidate/store-profile-info') }}" method="post">
                     {{csrf_field()}}
                     <div class="login-form">
                        <div class="row">
                           <div class="col-12  details-panel-header">
                              <h4 class="text-left">{{__('messages.EDIT_PERSONAL_INFO')}}</h4>
                              <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-6">
                              <div class="form-group required">
                                 <input value="{{base64_decode($profileData['first_name'])}}" name="first_name" id="first_name" type="text" class="form-control" placeholder="{{__('messages.NAME')}} *">
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-6">
                              <div class="form-group required">
                                 <input id="profile_headline" value="<?=($profileData['profile']['profile_headline']!='') ?$profileData['profile']['profile_headline']:''?>" name="profile_headline" type="text" class="form-control" placeholder="{{__('messages.PROFILE_HEADLINE')}}/{{__('messages.KEYWORD')}}* ">
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-6">
                              <div class="form-group required">
                                 <input readonly="" value="{{ base64_decode($profileData['email']) }}" name="email" id="email" type="email" class="form-control" placeholder="{{__('messages.EMAIL')}} *">
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-6">
                              <div class="form-group required">
                              <input type="hidden" name="country_id" value="{{$profileData['country_id']}}"/>
                                 <select name="country_id" id="country_id" class="form-control" disabled>
                                    <option value="" selected data-default> {{__('messages.SELECT_COUNTRY')}} *</option>
                                    @foreach ($countries as $country)

                                   
                                    <option <?=($country['id'] == $profileData['country_id'])? 'selected':''?> value="{{$country['id']}}">{{$country['name']}}</option>
                                    @endforeach                                   
                                 </select>
                              </div>
                           </div>
                            <?php 
                                   $states = [];
                                   $city = [];
                                    foreach ($countries as $key => $countryRow) {
                                       if($countryRow['id'] == $profileData['country_id']){
                                          $states = $countryRow['states'];
                                          foreach($states as $k=>$val){
                                             if($val['id'] == $profileData['state_id']){
                                                $city = $val['city'];
                                             }
                                              
                                          }
                                          break;
                                       }
                                    }
                                   // dd($city);
                           ?>
                           <div class="col-12 col-sm-6 col-xl-6">
                              <div class="form-group  required">
                                 <select  name="state_id" data-placeholder="State" id="state_id" class="form-control "  style="display: block;">
                                  <option value="">{{__('messages.SELECT_STATE')}}</option>
                                   @foreach ($states as $row)
                                    <option <?=($row['id'] == $profileData['state_id'])? 'selected':''?> value="{{$row['id']}}">{{$row['name']}}</option>
                                    @endforeach   
                                 </select>
                              </div>
                           </div>
                          
                           
                           <div class="col-12 col-sm-6 col-xl-6">
                              <div class="form-group  required">
                                 <input type="text" class="form-control" placeholder="{{ __('messages.CITY') }}" value="{{$profileData['city_id']}}" name="city_id" id="city_id">
                              </div>
                           </div>
                           <!-- <div class="col-12">
                              <div class="form-group required">
                                 <input value="{{$profileData['address1']}}" name="address1" id="address1" type="text" class="form-control" placeholder="{{__('messages.ADDRESS_LINE1')}} *">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="form-group required">
                                 <input value="{{$profileData['address2']}}" name="address2" type="text" class="form-control" placeholder="{{__('messages.ADDRESS_LINE2')}}">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="form-group required">
                                 <input value="{{$profileData['postal']}}" name="postal" id="postal" type="text" class="form-control" placeholder="{{__('messages.ZIP_CODE')}} *">
                              </div>
                           </div> -->
                           <div class="col-12">
                              <div class="form-group">
                                 <button class="site-btn btn submit-prfl-info-btn" type="submit" >{{__('messages.UPDATE_JOB')}}</button>
                              </div>
                           </div>
                        </div>
                     </div>
                 </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Add professional-experience -->
      <div class="modal custom-modal profile-modal addPrfix" id="add-professional-experience">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_company_info_add" id="form_company_info_add" action="{{ url('/candidate/store-company-info') }}" method="post">
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.ADD_PROFESSIONAL_EXPERIENCE')}}</h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <input class="form-control" placeholder="Title *" type="text" id="title" name="title">
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group">
                              <select class="form-control" id="type_of_employment" name="type_of_employment">
                                 <option value="">{{__('messages.TYPE_OF_EMPLOYMENT')}}</option>
                                 <option value="1">{{__('messages.FULL_TIME')}} </option> 
                                 <option value="2"> {{__('messages.PART_TIME')}} </option> 
                                 <option value="3">  {{__('messages.CONTRACT')}} </option> 
                                 <option value="4"> {{__('messages.INTERNSHIP')}} </option> 
                                 <option value="5"> {{__('messages.SELF_EMPLOYED')}} </option>
                              </select>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <input class="form-control" placeholder="{{__('messages.COMPANY_NAME')}}" type="text" id="company_name" name="company_name">
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <div class="select-newstyle">
                                <div class="list-inline-item">
                                   <label class="check-style">
                                   {{__('messages.CURRENTLY_WORKING_HERE')}} 
                                      <input type="checkbox" id="myCheck" class="currently-working-check chkCurrentCompAdd" name="currently_working_here" value="1">
                                      <span class="checkmark"></span>
                                      <label id="currently_working_err_add" class="error"></label>
                                   </label>
                                </div>
                              </div>
                           </div>                                    
                       </div>
                       <div class="col-12 col-sm-6 col-xl-6">
                          <div class="form-group required">
                             <div class="select-dat">
                                <input type="text" class="form-control" placeholder="{{__('messages.START_DATE')}} *" id="datetimepicker1"  name="start_date" autocomplete="off">
                             </div>
                          </div>
                       </div>
                       <div class="col-12 col-sm-6 col-xl-6 checkWorking-showhide add-end-date">
                          <div class="form-group required">
                             <div class="select-dat">
                                   <input type="text" class="form-control" placeholder="{{__('messages.END_DATE')}}" id="datetimepicker2" name="end_date" autocomplete="off">
                             </div>
                          </div>   
                       </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-comp-info-btn" type="submit" >{{__('messages.SUBMIT')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Edit professional-experience -->
      <div class="modal custom-modal profile-modal prfexp" id="professional-experience">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_company_info" id="form_company_info" action="{{ url('/candidate/store-company-info') }}" method="post">
                      <input type="hidden" name="id" value="" id="id"/>
                      <input type="hidden" name="currently_working" value="" id="currently_working"/>
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.EDIT_PROFESSIONAL_EXPERIENCE')}}</h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <input class="form-control" placeholder="{{__('messages.TITLE')}} *" type="text" id="title" name="title" value="">
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group">
                              <select class="form-control" id="type_of_employment" name="type_of_employment">
                                 <option value="">{{__('messages.TYPE_OF_EMPLOYMENT')}}</option>
                                 <option value="1"> {{__('messages.FULL_TIME')}} </option> 
                                 <option value="2"> {{__('messages.PART_TIME')}} </option> 
                                 <option value="3"> {{__('messages.CONTRACT')}} </option> 
                                 <option value="4"> {{__('messages.INTERNSHIP')}} </option>
                                 <option value="5"> {{__('messages.SELF_EMPLOYED')}} </option>
                              </select>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <input class="form-control" placeholder="{{__('messages.COMPANY_NAME')}}" type="text" id="company_name" name="company_name" value="">
                           </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                               <div class="select-newstyle">
                                 <div class="list-inline-item">
                                    <label class="check-style">
                                    {{__('messages.CURRENTLY_WORKING_HERE')}} 
                                       <input type="checkbox" id="myCheck" class="currently-working-check chkCurrentComp"  name="currently_working_here" value="1">
                                       <span class="checkmark"></span>
                                       <label id="currently_working_err" class="error"></label>
                                    </label>
                                 </div>
                               </div>
                            </div>                                    
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <div class="select-dat">
                                 <input type="text" class="form-control" placeholder="{{__('messages.START_DATE')}} *" id="datetimepicker4" name="start_date"  value="" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6 checkWorking-showhide edit-end-date">
                           <div class="form-group required">
                              <div class="select-dat">
                                    <input type="text" class="form-control" placeholder="{{__('messages.END_DATE')}}" id="datetimepicker5" name="end_date"  value="" autocomplete="off">
                              </div>
                           </div>   
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-comp-info-btn" type="submit" >{{__('messages.UPDATE_JOB')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- education -->
      <div class="modal custom-modal profile-modal educationPre" id="education">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_education_info" id="form_education_info" action="{{ url('/candidate/store-company-info') }}" method="post">
                      <input type="hidden" name="id" value="" id="id"/>
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.EDIT_EDUCATIONAL_QUALIFICATION')}}</h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        
                        <div class="col-12">
                           <div class="form-group  required">
                              <input class="form-control" placeholder="{{__('messages.SCHOOL')}} *" type="text" name="school_name" id="school_name" value="">
                           </div>
                        </div>
                        <div class="col-12 col-sm-12 col-xl-6">
                           <div class="form-group  required">
                              <input class="form-control" placeholder="{{__('messages.DEGREE')}} *" type="text" name="degree" id="degree" value="">
                           </div>
                        </div>
                        <div class="col-12 col-sm-12 col-xl-6">
                           <div class="form-group">
                              <input class="form-control" placeholder="{{__('messages.FIELD_OF_STUDY')}} " type="text" name="subject" id="subject" value="">
                           </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-6">
                             <div class="form-group">
                              <select class="form-control" name="start_year" id="start_year">
                                    <option value=""> {{__('messages.START_YEAR')}} </option>
                                    <?php for($i=1900;$i<=date('Y');$i++){?>
                                    <option value="{{$i}}"> {{$i}} </option> 
                                    <?php }?>
                                 </select>
                                 <label id="start_year_err" class="error"></label>
                             </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-6">
                           <div class="form-group">
                              <select class="form-control" name="end_year" id="end_year">
                                 <option value="">{{__('messages.END_YEAR')}}</option>
                                <?php for($j=1900;$j<=date('Y');$j++){?>
                                    <option value="{{$j}}"> {{$j}} </option> 
                                    <?php }?>
                             </select>
                             <label id="end_year_err" class="error"></label>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-edu-info-btn" type="submit" >{{__('messages.UPDATE_JOB')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- add education -->
      <div class="modal custom-modal profile-modal addEdu" id="add-education">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_edu_info_add" id="form_edu_info_add" action="{{ url('/candidate/store-educational-info') }}" method="post">
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.ADD_EDUCATIONAL_QUALIFICATION')}}</h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        
                        <div class="col-12">
                           <div class="form-group  required">
                              <input class="form-control" placeholder="{{__('messages.SCHOOL')}} *" type="text" name="school_name" id="school_name">
                           </div>
                        </div>
                        <div class="col-12 col-sm-12 col-xl-6">
                           <div class="form-group  required">
                              <input class="form-control" placeholder="{{__('messages.DEGREE')}} *" type="text" name="degree" id="degree">
                           </div>
                        </div>
                        <div class="col-12 col-sm-12 col-xl-6">
                           <div class="form-group">
                              <input class="form-control" placeholder="{{__('messages.FIELD_OF_STUDY')}} " type="text" name="subject" id="subject">
                           </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-6">
                             <div class="form-group">
                              <select class="form-control" name="start_year" id="start_year">
                                    <option value=""> Start Year </option>
                                    <?php for($i=1900;$i<=date('Y');$i++){?>
                                    <option value="{{$i}}"> {{$i}} </option> 
                                    <?php }?>
                                 </select>
                                 <label id="start_year_err" class="error"></label>
                             </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-6">
                           <div class="form-group">
                              <select class="form-control" name="end_year" id="end_year">
                                 <option value="">{{__('messages.END_YEAR')}}</option>
                                <?php for($j=1900;$j<=date('Y');$j++){?>
                                    <option value="{{$j}}"> {{$j}} </option> 
                                    <?php }?>
                             </select>
                             <label id="end_year_err" class="error"></label>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-edu-info-btn" type="submit" >{{__('messages.ADD')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- language -->
      <div class="modal custom-modal profile-modal langClass" id="language">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_lang_edit" id="form_lang_edit" action="{{ url('/candidate/store-language-info') }}" method="post">
                      <input type="hidden" id="lang_unique_id" name="lang_unique_id" value=""/>
                      <input type="hidden" id="old_lang_id" name="old_lang_id" value=""/>
                      <input type="hidden" id="old_fluency_id" name="old_fluency_id" value=""/>
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.EDIT_LANGUAGE_DETAILS')}} </h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <select class="form-control" name="master_cms_cat_id" id="master_cms_cat_id">
                                 <option value="">{{__('messages.LANGUAGE')}} *</option>
                                 <?php if(!empty($allLanguageArr)){
                                  foreach($allLanguageArr as $key=>$val){
                                  ?>
                                 <option value="{{$val['id']}}"> {{$val['name']}} </option> 
                                  <?php } }?>
                             </select>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <select class="form-control" name="master_fluncy" id="master_fluncy">
                                 <option value="">{{__('messages.PROFICIENCY_LEVEL')}} *</option>
                                 <?php if(!empty($allProfArr)){
                                  foreach($allProfArr as $key=>$val){
                                  ?>
                                 <option value="{{$val['id']}}"> {{$val['name']}} </option> 
                                  <?php } }?>
                             </select>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-lang-info-btn" type="submit" >{{__('messages.UPDATE_JOB')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- add language -->
      <div class="modal custom-modal profile-modal" id="add-language">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_lang_add" id="form_lang_add" action="{{ url('/candidate/store-language-info') }}" method="post">
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.ADD')}} {{__('messages.LANGUAGE_DETAILS')}} </h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <select class="form-control" name="master_cms_cat_id" id="master_cms_cat_id">
                                 <option value="">{{__('messages.LANGUAGE')}} *</option>
                                 <?php if(!empty($allLanguageArr)){
                                  foreach($allLanguageArr as $key=>$val){
                                  ?>
                                 <option value="{{$val['id']}}"> {{$val['name']}} </option> 
                                  <?php } }?>
                             </select>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <select class="form-control" name="master_fluncy" id="master_fluncy">
                                 <option value="">{{__('messages.PROFICIENCY_LEVEL')}} *</option>
                                 <?php if(!empty($allProfArr)){
                                  foreach($allProfArr as $key=>$val){
                                  ?>
                                 <option value="{{$val['id']}}"> {{$val['name']}} </option> 
                                  <?php } }?>
                             </select>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-lang-info-btn-add" type="submit" >{{__('messages.ADD')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>      
      <!-- others -->
      <div class="modal custom-modal profile-modal" id="others">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_skill" id="form_skill" action="{{ url('/candidate/store-skills') }}" method="post">
                        {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.EDIT_IT_SKILL')}}</h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        <div class="col-12 col-xl-12">
                           <div class="form-group required">
                              <select name="skill[]" data-placeholder="{{__('messages.IT_SKILL')}} *" id="skill" class="form-control js-example-tags"  multiple="multiple" >
                                  <?php if(!empty($allSkillArr)){ 
                                    foreach($allSkillArr as $key=>$val){ ?>
                                  <option value="{{$val['id']}}" <?php if(in_array($val['id'],$skillArr, TRUE)){ echo 'selected';}?>>{{$val['name']}}</option>
                                  <?php } }?>
                                  
                              </select>
                              
                            </select>
                              <label id="errorClsSkill" class="error" style="display: none;"></label>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                           <?php if(!empty($skillArr)){?>
                              <button class="site-btn btn skill-submit-btn" type="button" >{{__('messages.UPDATE_JOB')}}</button>
                           <?php }else{?>
                              <button class="site-btn btn skill-submit-btn" type="button" >{{__('messages.ADD')}}</button>
                           <?php }?>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>  
      <!-- Hobbies -->
      <div class="modal custom-modal profile-modal addHobby" id="hobbies">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_hobby" id="form_hobby" action="{{ url('/candidate/store-hobbies') }}" method="post">
                        {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.EDIT_HOBBIES')}} <span>({{__('messages.SEPARATE_EACH_HOBBY_BY_ENTER_ANY_KEY')}})</span></h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        
                        <div class="col-12 col-xl-12">
                           <div class="form-group">
                              <?php $hobbyString = '';
                               if(!empty($hobbyArray)){ 
                                $hobbyString = implode(',',$hobbyArray);
                              }?>
                              <div class="hobbies-tooltip" data-toggle="tooltip" data-placement="top" title="{{__('messages.WRITE_YOUR_HOBBIES_AND_CLICK_ON_UPDATE_BUTTON')}}">
                                 <i class="la la-exclamation-circle"></i>
                              </div>
                              <input type="text" data-role="tagsinput"  placeholder="{{__('messages.HOBBIES')}}" value="{{$hobbyString}}"  name="hobby" id="hobby">
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                           <?php if(!empty($hobbyArray)){?>
                              <button class="site-btn btn hobby-submit-btn" type="submit" >{{__('messages.UPDATE_JOB')}}</button>
                           <?php }else{?>
                              <button class="site-btn btn hobby-submit-btn" type="submit" >{{__('messages.ADD')}}</button>
                           <?php }?>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>        
      <!-- cv-summary -->
      <div class="modal custom-modal profile-modal" id="cv-summary">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_cv_summary" id="form_cv_summary" action="{{ url('/candidate/store-cv-summary') }}" method="post">
                        {{csrf_field()}}
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left"> {{__('messages.EDIT_CV_SUMMARY')}} </h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                        </div>
                        <div class="col-12 col-xl-12">
                           <div class="form-group">
                              <textarea class="form-control" name="cv_summary" id="cv_summary">{{$profileDataOld['profile']['cv_summary']}} </textarea>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn cv-summary-sub-btn" type="submit" >{{__('messages.UPDATE_JOB')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div> 
      <!-- cv-update -->
      <div class="modal custom-modal profile-modal" id="cv-update">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <form id="upload_cv_form" action="{{url('/candidate/store-cv')}}" method="post" enctype="multipart/form-data" >
                     {{ csrf_field() }}
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                           <h4 class="text-left"> {{__('messages.UPLOAD_CV')}}  </h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                           <h6 style="display: none;" class="error upload-error-n"> Error Message </h6>
                        </div>

                        <div class="col-12 col-xl-12">
                           <div class="cv-upload-section-func" style="display: none;">
                              
                              <div class="cv-holder">
                                 <!-- <a href="" class="crossprofile"><i class="la la-times"></i></a>
                                 <a href="" class="downloadprofile"><i class="la la-download"></i></a>
                                 <div class="uploadprofile">
                                    <input type="file">
                                    <span><i class="la la-upload"></i></span>
                                 </div> -->
                                 <a href="#">
                                    <img src="<?php echo url('/');?>/frontend/images/document.png" alt="" class="cv">
                                    <!-- When pdf file upload-->
                                    <!-- <img src="<?php // echo url('/');?>/frontend/images/pdf-img.png" alt="" class="cv"> -->
                                 </a>    
                              </div>
                              <div class="media file-name-image mb-3" style="display: none;">
                                 <span class="mr-1"> <i class="la la-file-alt"></i> 
                                    <!-- When pdf file upload "la la-file-pdf" icon remove class "d-none" and "la la-file-alt" icon add "d-none" class-->
                                    <i class="la la-file-pdf d-none"></i>
                                    <i class="la la-file-word d-none"></i>
                                 </span>
                                 <div class="media-body cv-name-func"><p></p></div>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="d-flex flex-wrap "> 
                                 <div class="custom-inputfile mr-2 mb-2">             
                                    <input class="cv_file_upload" name="file" type="file" id="file">
                                    <label for="file" class=""><i class="fa fa-cloud-upload mr-2" aria-hidden="true"></i>
                                    {{__('messages.BROWSE_CV')}}</label>      
                                 </div>  
                                 <a href="javascript:void(0)" class="btn site-btn mb-2 upload_cv_func">           
                                 {{__('messages.UPLOAD')}}
                                 </a>    
                              </div>
                           </div>
                        </div>
                       <!--  <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn upload_cv_func" type="button" >Update</button>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </form>
               </div>
            </div>
         </div>
      </div> 
      <!-- intro-video -->
      <div class="modal custom-modal profile-modal refresh-modal-intro" id="intro-video">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 col-sm-12 details-panel-header">
                          <!-- media -->
                          <div class="media">
                            <!-- media-body -->
                            <div class="media-body mr-3">
                              <h4 class="text-left"> {{__('messages.INTRO_VIDEO')}} </h4>
                              <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                              <h6 style="display: none;" class="error upload-error-n-intro-vdo"> Error Message </h6>
                            </div>
                            <!-- media-body -->
                            <!-- media-action -->
                            <div class="media-action">
                              <!-- actionicon-box -->
                              <div class="actionicon-box row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
                          </div>
                          <!-- media -->
                        </div>
                        <div class="col-12 col-xl-12">
                           <div class="form-group">
                              <div class="webcamp-holder"> 
                                <form id="video_intro_form" action="" method="post" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                   <div id="videoplayersection">
                                    <video id="myVideo" playsinline class="video-js vjs-default-skin">
                                          <p class="vjs-no-js">
                                            To view this video please enable JavaScript, or consider upgrading to a
                                            web browser that
                                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                              supports HTML5 video.
                                            </a>
                                          </p>
                                    </video>
                                  </div>
                                  </form>
                              </div>
                           </div>
                           <div class="form-group d-flex flex-wrap mb-0">
                              <!-- media -->
                              <div class="media align-items-center mb-3">
                                <div class="media-action mr-4">
                                  <button class="site-btn btn upload-intro-video-func" type="button">
                                    {{__('messages.UPLOAD')}}
                                  </button>
                                  <button class="site-btn btn delete-intro-video-func" type="button"  disabled>
                                    {{__('messages.DELETE_SUBMIT')}}
                                  </button>
                                </div>
                                <div class="media-body">
                                  {{__('messages.YOU_CAN_TRY_AS_MANY_TIME_AS_YOU_WANT')}} <br> {{__('messages.WHEN_IT_IS_READY_JUST_CLICK_IN_UPLOAD')}}
                                </div>
                              </div>
                              <!-- media -->
                           </div>
                        </div>
                       <!--  <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn upload-intro-video-func" type="button" >Upload</button>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> 
     <form id="security_form" action="" method="post">
            {{csrf_field()}}
     </form>

     <!-- Video JS --->
     

<script type="text/javascript"> 
var currentCompanyArr = <?php echo $currentCompanyArr; ?>; 

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
<script>
        
   var options = {
      controls: true,
      width: 635,
      height: 240,
      plugins: {
         record: {
            audio: true,
            video: true,
            maxLength: 60,
            debug: true
            }
      }
   };

// apply some workarounds for certain browsers
  applyVideoWorkaround();

var player = videojs('myVideo', options, function() {
    // print version information at startup
    var msg = 'Using video.js ' + videojs.VERSION +
        ' with videojs-record ' + videojs.getPluginVersion('record') +
        ' and recordrtc ' + RecordRTC.version;
    videojs.log(msg);
});

// error handling
player.on('deviceError', function() {
   swal(lanFilter(allMsgText.SORRY_NO_CAMERA_FOUND))
   .then((value) => {
      
   });
    console.log('device error:', player.deviceErrorCode);
});

player.on('error', function(element, error) {
    console.error(error);
});

// user clicked the record button and started recording
player.on('startRecord', function() {
    console.log('started recording!');
    $("#intro-video").find(".delete-intro-video-func").prop("disabled", false);
    $("#intro-video").find(".close").attr("disabled", true);
    $("#intro-video").find(".upload-intro-video-func").attr("disabled", true);
    $("#intro-video").find("#intro_video").attr("disabled", true);
    $("#intro-video").find("#intro_video_label").attr("disabled", true);
    $("#intro-video").modal({
            backdrop: 'static',
            keyboard: false
        });
});

// user completed recording and stream is available
player.on('finishRecord', function() {
   $("#intro-video").find(".close").attr("disabled", false);
   $("#intro-video").find(".upload-intro-video-func").attr("disabled", false);
   $("#intro-video").find("#intro_video").attr("disabled", false);
   $("#intro-video").find("#intro_video_label").attr("disabled", false);
    // the blob object contains the recorded data that
    // can be downloaded by the user, stored on server etc.
    console.log('finished recording: ', player.recordedData);
    introVideoData = player.recordedData;
});
$(document).ready(function() {
   let currentDate = new Date();
   //DATEPICKER
   $('#datetimepicker4').datepicker({maxDate:'0',dateFormat:'yy-mm-d'});
  
  setTimeout(function(){       
      $('#datetimepicker4').data("DateTimePicker").maxDate(currentDate);
      $('#datetimepicker5').data("DateTimePicker").maxDate(currentDate);
  },1000);
  
  $('#datetimepicker4').datepicker({ useCurrent: false, dateFormat:'yy-mm-d'});
  
  $("#datetimepicker4").on("dp.change", function (e) {
        $('#datetimepicker5').data("DateTimePicker").minDate(e.date);
  });
  
 
  $('#datetimepicker1').datepicker({maxDate:'0',dateFormat:'yy-mm-d'});
  setTimeout(function(){       
      $('#datetimepicker1').data("DateTimePicker").maxDate(currentDate);
      $('#datetimepicker2').data("DateTimePicker").maxDate(currentDate);
  },1000);
  $('#datetimepicker2').datepicker({ useCurrent: false, dateFormat:'yy-mm-d'});
  
  $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
  });

  $(".js-example-tags").select2({tags: true,width:'100%'}); 
  $(document).on("click",".close-image",function(){
   $("#myBannerDropzone").html('<div class="dz-default dz-message"><span>Drop files here to upload</span></div>');
   $("#myDropzone").html('<div class="dz-default dz-message"><span>Drop files here to upload</span></div>');
  });  
  $(document).on("click",".chkCurrentComp",function(){
     
      var currentOrNot = $('#currently_working').val();
      console.log(currentOrNot);
      var n = currentCompanyArr.includes(1);
      var chk = $('.prfexp .chkCurrentComp').prop("checked");
      if(chk){
         
         if(n){
            if(currentOrNot != 1){
              
               $('.prfexp .chkCurrentComp').prop("checked",false);
               $('#currently_working_err').html('You already added current company');
               $('#currently_working_err').attr("style", "display:block");
               setTimeout(function() {
                     $('#currently_working_err').delay(3000).fadeOut(600);
               });
            }else{
               $(".edit-end-date").hide();
            }
            
         }
         else{
            
            $(".edit-end-date").hide();
         }
      }else{
         $(".edit-end-date").show();
      }
  });
  $(document).on("click",".chkCurrentCompAdd",function(){
    
      
      var n = currentCompanyArr.includes(1);
      var chk = $('.addPrfix .chkCurrentCompAdd').prop("checked");
      if(chk){
         
         if(n){
            
            $('.addPrfix .chkCurrentCompAdd').prop("checked",false);
            $('#currently_working_err_add').html('You already added current company');
            $('#currently_working_err_add').attr("style", "display:block");
            setTimeout(function() {
                  $('#currently_working_err_add').delay(3000).fadeOut(600);
            });
         }
         else{
            
            $(".add-end-date").hide();
         }
      }else{
         $(".add-end-date").show();
      }
  });

   $(window).load(function () {
      var $this = this;
      var message_local = localStorage.getItem("message_local");
      if(message_local == "delete_intro"){
         let msg = $this.lanFilter(allMsgText.YOUR_INTRO_VIDEO_REMOVED_SUCCESSFULLY);
         let msgBox = $(".alert-holder-success");
         msgBox.addClass('success-block');
         msgBox.find('.alert-holder').html(msg);
         setTimeout(function(){ msgBox.removeClass('success-block')},5000);

			//$this.showSuccessMsg(msg);
         localStorage.removeItem("message_local");
         var lastparam = localStorage.getItem("myitme");
         if(lastparam == "intro"){
            setTimeout(function(){ 
               $(".refresh-modal-intro").modal('show');
            },2000);
            
            localStorage.removeItem("myitme");
         }
      }
      
      
   });   
  
});
</script>

<!-- End Video JS -->
<!-- ================profile-modal================ -->
 @endsection
<!-- main-page -->
     
     


