@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/follow.js')}}"></script>
<script src="{{asset('frontend/js/viewFollower.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(auth()->user()){
   $user_type = Auth::user()->user_type;
   }else{
      $user_type = '';
   } 
   
   $followUnfollowArr = [];
   if((!empty($profileData['followers'])) && count($profileData['followers']) != 0){
      foreach($profileData['followers'] as $key=>$val){
         array_push($followUnfollowArr,$val['follower_id']);
      }
   }

   $connectionArr = [];
   $connectionId = '';
   $accepted = 1;
   if($profileData['connection'] != null){
      foreach($profileData['connection'] as $key=>$val){
         if((Auth::user()) && ($val['request_sent_by'] == Auth::user()->id)){
            $connectionId = $val['id'];
         }
         array_push($connectionArr,$val['request_sent_by']);
         
      }
   }
   if($profileData['connectionAcceptBy'] != null){
      foreach($profileData['connectionAcceptBy'] as $key=>$val){
         if((Auth::user()) && ($val['request_accepted_by'] == Auth::user()->id)){
            $connectionId = $val['id'];
            $accepted = $val['status'];
         }
         array_push($connectionArr,$val['request_accepted_by']);
      }
   }
   ?>
      <!-- main -->
      <main>
         <section class="section-myprofile-outer">
            <div class="container">
               <div class="row">
                  <div class="col-lg-3">
                     <div class="profile-side-panel">
                        <div class="details-panel-header mb-4">
                           <div class="profile-img-holder">
                              <div class="profile-bg-img">
                                 <?php if($profileData['bannerImage'] != null){?>
                                 <img src="{{asset($profileData['bannerImage']['location'])}}" alt="Profile Background Image">
                                 <?php }else{?>
                                    <img src="<?php echo url('/');?>/frontend/images/user-pro-bg-img.jpg" alt="Profile Background Image">
                                 <?php }?>
                              </div>
                              <div class="profile-img">
                                 <?php if(!empty($profileData['profileImage'])){?>
                                 <img src="{{asset($profileData['profileImage']['location']) }}" alt="Profile Image">
                                 <?php }else{?>
                                    <img src="<?php echo url('/');?>/frontend/images/user-pro-img-demo.png" alt="Profile Image">
                                 <?php }?>
                              </div>
                           </div>
                           <h3 class="h3-profile"><?php echo ($profileData['first_name']?$profileData['first_name']:'') .' '. ($profileData['last_name']?$profileData['last_name']:'') ;?></h3>
                           <h5 class="text-company"><?php echo ($profileData['profile']['profile_headline']?$profileData['profile']['profile_headline']:'');?></h5>
                           <h6 class="color-lightgray"><?php echo ($profileData['state']['name']?$profileData['state']['name']:'');?></h6>
                           
                           <?php if((Auth::user()) && (Auth::user()->user_type != 1) && (Auth::user()->id != $profileData['id'])){
                           if($profileData['isUserBlockedByLogedInUser'] == null){ ?>
                           <div class="profile-btn-holder">
                              <?php if((Auth::user()) && (!empty($connectionArr)) && (in_array(Auth::user()->id,$connectionArr)) && ($accepted == 0)){?>
                                 <button class="btn site-btn-color w-100 mr-2 accept-reject-cls" id="connect-id-{{$profileData['id']}}" data-id="{{$profileData['id']}}" data-tag="1" data-connect="{{$connectionId}}">{{ __('messages.ACCEPT') }}</button>    
                              <?php }else if((Auth::user()) && (!empty($connectionArr)) && (in_array(Auth::user()->id,$connectionArr))){?>
                                 <button class="btn site-btn-color w-100 mr-2 accept-reject-cls" id="connect-id-{{$profileData['id']}}" data-id="{{$profileData['id']}}" data-tag="0" data-connect="{{$connectionId}}">{{ __('messages.REMOVE') }}</button>    
                              <?php }else if(Auth::user() && (Auth::user()->id != $profileData['id'])){ ?>
                                 <button class="btn site-btn-color w-100 mr-2 connect-cls" id="connect-id-{{$profileData['id']}}" data-id="{{$profileData['id']}}" data-tag="0">{{ __('messages.CONNECT') }}</button>
                              <?php  }else{ ?>
                                 <a class="btn site-btn-color w-100 mr-2" href="{{url('/')}}">{{ __('messages.CONNECT') }}</a>
                              <?php } ?>
                              <!-- <button class="btn site-btn-color w-100 mr-2">Connect</button>  -->
                              <?php if(($user_type != '') && ($user_type == 2)){?>
                              <a href="{{url('/candidate/message/')}}/{{encrypt($profileData['id'])}}" class="btn site-btn-color mr-2"> <i class="fa fa-comments"></i></a> 
                              <?php }else if(($user_type != '') && ($user_type == 3)){?>
                                 <a href="{{url('/company/message/')}}/{{encrypt($profileData['id'])}}" class="btn site-btn-color mr-2"> <i class="fa fa-comments"></i></a> 
                              <?php }?>
                              <?php if((Auth::user()) && (Auth::user()->user_type == 2)){?>
                              <div class="dropdown msg-dropdown">
                                 <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="fa fa-ellipsis-h"></i>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                 <?php if($user_type == 2 && (Auth::user()) && (Auth::user()->id != $profileData['id'])){?>
                                    <a class="dropdown-item follow-unfollow-user-{{$profileData['id']}}" id="follow-unfollow-user" data-id="{{$profileData['id']}}" <?php if(!empty($followUnfollowArr) && (in_array(Auth::user()->id,$followUnfollowArr))){ ?>data-follow="0"<?php }else{ ?> data-follow="1"<?php }?> href="javascript:void(0);" ><?php if(!empty($followUnfollowArr) && (in_array(Auth::user()->id,$followUnfollowArr))){ echo __('messages.UN_FOLLOW');}else{ echo __('messages.FOLLOW');}?></a>
                                 <?php }else if($user_type == 2){?>
                                    <a class="dropdown-item"  href="{{url('/')}}" >{{ __('messages.FOLLOW') }}</a>
                                 <?php }?>
                                    
                                 </div>
                              </div>
                                 <?php }?>
                                 
                           </div>
                           <?php }else{?>
                              <div class="profile-btn-holder">
                              <button class="btn site-btn-color w-100 mr-2 block_user" data-id="{{$profileData['id']}}" data-block="0" id="block_user_{{$profileData['id']}}">{{__('messages.UN_BLOCK')}}</button>    
                              </div>
                           <?php } }?>

                           <?php if((Auth::user()) && (Auth::user()->id == 1)){?>
                              <div class="profile-btn-holder">
                              <?php if($profileData['status'] == 1){?>
                              <button class="btn site-btn-color w-100 mr-2" id="" data-id="{{$profileData['id']}}" style="cursor:default;">Active</button>     
                              <?php }else{?>
                                 <button class="btn site-btn-color w-100 mr-2" id="" data-id="{{$profileData['id']}}" style="cursor:default;">Inactive</button>       
                              <?php }?>
                              </div> 
                           <?php }?> 
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
                  <div class="col-lg-9">
                     <div class="">
                        <section class="section-myprofile" id="section1">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <h4>{{__('messages.PERSONAL_INFORMATION')}} </h4>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.NAME')}}:</label> 
                                       <?php echo ($profileData['first_name']?$profileData['first_name']:'') .' '. ($profileData['last_name']?$profileData['last_name']:'') ;?>
                                    </div>
                                 </div>
                                 <?php if(($user_type != '') && ($user_type != 2)){?>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.PROFILE_HEADLINE')}} :</label> 
                                       <?php echo ($profileData['profile']['profile_headline']?$profileData['profile']['profile_headline']:'');?>
                                    </div>
                                 </div>
                                
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.EMAIL')}} :</label> 
                                       <?php echo ($profileData['email']?$profileData['email']:'');?>
                                    </div>
                                 </div>

                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.COUNTRY')}} :</label> 
                                       <?php echo ($profileData['country']['name']?$profileData['country']['name']:'');?>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.STATE')}} :</label> 
                                       <?php echo ($profileData['state']['name']?$profileData['state']['name']:'');?>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.CITY')}} :</label> 
                                       <?php echo ($profileData['city_id']?$profileData['city_id']:'');?>
                                    </div>
                                 </div>
                                 <!-- <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.ADDRESS_LINE1')}} :</label> 
                                       <?php // echo ($profileData['address1']?$profileData['address1']:'');?>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.ADDRESS_LINE2')}} :</label> 
                                       <?php //echo ($profileData['address2']?$profileData['address2']:'');?>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{__('messages.ZIP_CODE')}} :</label> 
                                       <?php // echo ($profileData['postal']?$profileData['postal']:'');?>
                                    </div>
                                 </div> -->
                                 <?php }?>
                              </div>
                           </div>
                        </section>
                        <section class="section-myprofile" id="section2">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <!-- <h4> Professional Info </h4>
                                    <h6> Provide the basic informations about yourself</h6> -->
                                 </div>
                              </div>
                              <div class="Companydetails">
                                 <div class="row">
                                    <div class="col-sm-12 details-panel-header">
                                       <div class="edit-info-holder">
                                          <h5 class="total-title"> {{__('messages.COMPANY_DETAILS')}}</h5>
                                       </div>
                                    </div>
                                 </div>   
                                 <?php if(!empty($profileData['professionalInfo'])){ ?>
                                    <div class="row section-infodata">
                                  <div class="col">
                                 <?php foreach($profileData['professionalInfo'] as $key=>$value){
                                  ?>
                                 <div class="row section-infodata-item"> 
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.TITLE')}} :</label>
                                          {{($value['title']?$value['title']:'')}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.TYPE_OF_EMPLOYMENT')}} :</label>
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
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.COMPANY_NAME')}} :</label>
                                          {{($value['company_name']?$value['company_name']:'')}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.CURRENTLY_WORKING_HERE')}} :</label>
                                          <?php if($value['currently_working_here'] == 1){?>
                                             {{__('messages.YES')}}
                                          <?php }else{?>
                                             {{__('messages.NO')}}
                                          <?php }?>
                                       </div>                                  
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.START_DATE')}} :</label>
                                          {{($value['start_date']?date('Y-m-d',strtotime($value['start_date'])):'')}}
                                       </div>
                                    </div>
                                    <!-- if  Currently Working Here no this shuld be show -->
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.END_DATE')}} :</label>
                                          {{($value['end_date']?date('Y-m-d',strtotime($value['end_date'])):'')}}
                                       </div>
                                    </div>
                                 </div> 
                                <?php } ?>
                             </div>
                          </div>
                            <?php }?>
                              </div>

                              <div class="education-details">
                                 <div class="row"> 
                                    <div class="col-sm-12 details-panel-header">
                                       <div class="edit-info-holder">
                                          <h5 class="total-title"> {{__('messages.EDUCATION_DETAILS')}} </h5>
                                       </div>
                                    </div>
                                 </div>   
                                 <?php if(!empty($profileData['educationalInfo'])){ ?>
                                    <div class="row section-infodata">
                                      <div class="col">
                                 <?php foreach($profileData['educationalInfo'] as $key=>$value){
                                  ?>
                                 <div class="row section-infodata-item"> 
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.SCHOOL')}} :</label>
                                         {{($value['school_name']?$value['school_name']:'')}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.DEGREE')}} :</label>
                                          {{($value['degree']?$value['degree']:'')}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.FIELD_OF_STUDY')}} :</label>
                                          {{($value['subject']?$value['subject']:'')}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.START_YEAR')}} :</label>
                                          {{($value['start_year']?$value['start_year']:'')}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.END_YEAR')}} :</label>
                                          {{($value['end_year']?$value['end_year']:'')}}
                                       </div>
                                    </div>
                                 </div>
                                 <?php } ?>
                              </div>
                           </div>
                              <?php } ?>                                    
                              </div>

                              <div class="language-details">
                                 <div class="row"> 
                                    <div class="col-sm-12 details-panel-header">
                                       <div class="edit-info-holder">
                                          <h5 class="total-title"> {{__('messages.LANGUAGE_DETAILS')}} </h5>
                                       </div>
                                    </div>
                                 </div> 
                                 <?php if(!empty($profileData['cmsBasicInfo'])){
                                    foreach($profileData['cmsBasicInfo'] as $key=>$lang){
                                       if($lang['language'] != null){
                                    ?>
                                 <div class="row">    
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.LANGUAGE')}}</label>
                                          {{$lang['language']['name']}}
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                       <div class="form-view">
                                          <label class="label-tag">{{__('messages.PROFICIENCY_LEVEL')}}</label>
                                          {{($lang['language']['fluency']['fluencyLabel']['name']?$lang['language']['fluency']['fluencyLabel']['name']:'')}}
                                       </div>
                                    </div>
                                 </div>
                              <?php } } }?>
                                 
                              </div> 
                              <div class="row">
                                 <div class="col-sm-12 details-panel-header">
                                    <div class="edit-info-holder">
                                       <h5 class="total-title">  {{__('messages.OTHERS')}}</h5>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12">
                                    <div class="form-view">
                                       <label class="label-tag mb-2">{{__('messages.IT_SKILL')}}</label>
                                        <ul class="skill-tags">
                                         <?php if(!empty($profileData['selectedSkill'])){ 
                                          foreach($profileData['selectedSkill'] as $key=>$val){ if($val['type'] == 'candidate'){?>
                                          <li><span>{{$val['skill']['name']}}</span></li>
                                         <?php } } }?>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                        <section class="section-myprofile" id="section3">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <h4> {{__('messages.HOBBIES')}}</h4>
                                 </div>   
                                 <div class="col-12">
                                    <div class="form-view">
                                       <label class="label-tag mb-2">{{__('messages.HOBBIES')}}</label>
                                       <ul class="skill-tags">
                                          <?php if(!empty($profileData['cmsBasicInfo'])){
                                          foreach($profileData['cmsBasicInfo'] as $key=>$lang){
                                             if($lang['hobby'] != null){
                                          ?>
                                          <li><span>{{$lang['hobby']['name']}}</span></li>
                                          <?php } } }?>
                                         <!--  <li><span>Fashion</span></li>
                                          <li><span>Cooking</span></li>
                                          <li><span>Listening to music</span></li>
                                          <li><span>Makeup</span></li>  
                                          <li><span>Watching movies</span></li>  -->    
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
                                    <!-- <h4>CV Summary</h4>
                                    <h6>Provide the basic informations about yourself</h6> -->
                                    <div class="edit-info-holder">
                                       <h5 class="form-sub-heading"> {{__('messages.CV_SUMMARY')}} </h5>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-view">
                                       <p><?php echo ($profileData['profile']['cv_summary']?$profileData['profile']['cv_summary']:''); ?></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                        <!-- <?php //if(($user_type != '') && ($user_type != 2)){ ?>
                        <section class="section-myprofile" id="section5">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    
                                    <div class="edit-info-holder">
                                       <h5 class="form-sub-heading"> {{__('messages.DOWNLOAD_CV')}}</h5>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    
                                    <div class="cv-holder  @if(!empty($profileData['uploadedCV'])) cv-holder-upload  @endif   cv-holder-page-section">
                                       
                                       <a href="<?php //if($downloadCvFlag == 1){ echo asset($profileData['uploadedCV']['location']);}else{?> javascript:void(0);<?php //}?>"  class="downloadprofile" download><i class="la la-download"></i></a>
                                       <?php// if($profileData['id'] == Auth::user()->id){?>
                                       <div class="uploadprofile">
                                        
                                          <span><i class="la la-upload uploadprofile-now"></i></span>
                                       </div>
                                       <?php //}?>
                                       @if(!empty($profileData['uploadedCV']))
                                       <a class="uploadprofile-new" href="<?php //if($downloadCvFlag == 1){ echo asset($profileData['uploadedCV']['location']);}else{?> javascript:void(0);<?php //}?>" download>
                                          <?php
                                               //$filename = explode('.',$profileData['uploadedCV']['name']);  
                                               //$fileType = $filename[(count($filename)-1)];
                                          ?>
                                          <?php //if($fileType == 'pdf'){ ?>
                                          <img src="<?php// echo url('/');?>/frontend/images/pdf-img.png" alt="{{$profileData['uploadedCV']['name']}}" class="cv">
                                         <?php //}else{ ?>
                                             <img src="<?php// echo url('/');?>/frontend/images/doc-img.png" alt="{{$profileData['uploadedCV']['name']}}" class="cv">
                                         <?php //} ?>
                                          
                                       </a>
                                       @else
                                       
                                        <img src="<?php // echo url('/');?>/frontend/images/document.png" alt="" class="cv">
                                       @endif
                                       
                                    </div>
                                     @if(!empty($profileData['uploadedCV']))
                                    <div class="media file-name-image cv-file-name-image">
                                       <span class="mr-1"> <i class="la la-file-alt"></i> 
                                          
                                          <i class="la la-file-pdf d-none"></i>
                                       </span>
                                       <div class="media-body"><p class="cv-file-name-image">{{$profileData['uploadedCV']['org_name']}}</p></div>
                                    </div>
                                    @endif
                                 </div>
                                
                              </div>
                           </div>
                        </section>
                     <?php //}?> -->
                        <section class="section-myprofile" id="section6">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <!-- <h4>Introduction yourself via Video</h4>
                                    <h6>Provide the basic informations about yourself</h6> -->
                                    <div class="edit-info-holder">
                                       <h5 class="form-sub-heading"> {{__('messages.INTRO_VIDEO')}} </h5>
                                    </div>
                                 </div>
                                 
                                 <div class="col-12">
                                    <div class="intro-video">
                                       <?php if(($user_type != '') && (($user_type == 3) || (($user_type == 2) && ($profileData['id'] == Auth::user()->id)))){?>
                                          
                                        <video   controls class="video-js vjs-default-skin" >
                                           @if(!empty($profileData['introVideo']))
                                                 <source src="{{asset($profileData['introVideo']['location'])}}" type="video/mp4">
                                           @else
                                                 <source src="<?php echo url('/');?>/frontend/images/video.mp4" type="video/mp4">
                                           @endif
                                       </video>  
                                       <!-- <video  autoplay muted="">
                                          <source src="<?php echo url('/').''.$profileData['profile']['uploadVideo']['location'];?>" type="video/mp4">
                                       </video> -->
                                        <?php }else{?>
                                          <p>{{__('messages.THIS_VIDEO_IS_ONLY_AVAILABLE_FOR_COMPANY')}}</p>
                                        <?php }?>
                                    </div>
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
      <script src="{{ asset('frontend/js/dropzone.min.js')}}"></script>
      <script src="{{ asset('frontend/js/aos.js')}}"></script>
      <script src="{{ asset('frontend/js/jquery.easing.min.js')}}"></script>
      <script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>
      <script src="{{ asset('frontend/js/tagsinput.js')}}"></script> 
      <script src="{{ asset('frontend/js/swiper.min.js')}}"></script>
      <!--footer end-->
       
      <!-- main-page -->
      <!-- ================Modal================ -->
      <!-- change-image -->
      <div class="modal custom-modal  profile-modal report-modal" id="report-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <div class="row">
                        <div class="col-sm-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.REPORT')}}</h4>
                        </div>
                        <div class="col-sm-12 col-xl-12">
                           <div class="form-group required">
                              <label>{{__('messages.WHY_ARE_YOU_REPORTING')}}</label>
                              <textarea class="form-control"></textarea>
                           </div>
                        </div>
                        <div class="col-sm-12 col-xl-12 text-left">
                           <button class="btn site-btn-color" type="submit">{{__('messages.SUBMIT')}}</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

   <div class="modal custom-modal  profile-modal connection-request" id="connection-request">
   <div class="modal-dialog">
      <div class="modal-content">
         <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
         <div class="modal-body">
            <div class="login-form">
            <form id="connect" action="{{url('/send-connection-request')}}" method="post" >
               <div class="row">
                  <div class="col-sm-12 details-panel-header">
                     <h4 class="text-left">{{__('messages.CONNECTION_REQUEST')}}</h4>
                  </div>
                  <div class="col-sm-12 col-xl-12">
                     <div class="form-group required">
                        <label>{{__('messages.WRITE_PERSONAL_NOTE')}}</label>
                        <input type="hidden" name="candidate_id" id="candidate_id"/>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                     </div>
                  </div>
                  <div class="col-sm-12 col-xl-12 text-left">
                     <button class="btn site-btn-color conect-btn" type="submit">{{__('messages.SEND_NOW')}}</button>
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
     @endsection

      <!-- ================profile-modal================ -->

      
      
      
      
   <!-- </body>
</html> -->

