@extends('layouts.app_after_login_layout')
@section('content')
<?php $user_type = Auth::user()->user_type;?>
<input type="hidden" name="user_type" value="{{$user_type}}" id="user_type"/>
 <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
 <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('frontend/js/viewFollower.js')}}"></script>
      <!-- main -->
     <main>
         <section class="section-myprofile-outer">
            <div class="container">
               <div class="row">
                  <div class="col-12 col-lg-4 col-xl-3">
                     <div class="profile-side-panel">
                        <div class="details-panel-header mb-4" id="leftMenu">
                           <div class="profile-img-holder">
                              <div class="profile-bg-img">
                                 <?php if($profileData['bannerImage'] != null){?>
                                 <img id="banner-image-src" src="{{asset($profileData['bannerImage']['location'])}}" alt="user-profile-bg">
                                 <?php }else{?>
                                    <img id="banner-image-src" src="{{ asset('frontend/images/user-pro-bg-img.jpg')}}" alt="user-profile-bg">
                                 <?php }?>
                                

                                <!--  <div class="msk d-flex justify-content-center" data-toggle="modal" data-target="#change-image-banner">
                                    <img class="cam-open cam-banner-open" src="{{ asset('frontend/images/ic-camera-icon.svg')}}" alt="camara">
                                 </div> -->

                                 <div class="msk d-flex justify-content-center " data-toggle="modal" data-target="#change-image-banner">
                                        <img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon">
                                 </div>

                                  <a href="javascript:void(0)" class="crossprofile remove-old-banner-img-func">
                                    <i class="la la-times"></i>
                                  </a>

                              </div>
                              <div class="profile-img">
                                 <?php if($profileData['profileImage'] != null){?>
                                 <img id="profile-image-src" src="{{asset($profileData['profileImage']['location'])}}" alt="user-profile">
                                  <?php }else{?>
                                    <img id="profile-image-src" src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="user-profile">
                                  <?php }?>

                                 <div class="msk d-flex justify-content-center" data-toggle="modal" data-target="#change-image">
                                       <img src="<?php echo url('/');?>/frontend/images/pencil-edit-button.svg"  alt="Edit-icon">
                                 </div>

                              </div>
                           </div>
                           <h3 class="h3-profile">
                              <span class="company_name_func">
                              <?php echo ($profileData['company_name']?$profileData['company_name']:'');?>
                              </span>
                           </h3>
                           <h5 class="text-company">
                              <span class="business_name_func">
                              <?php echo (isset($profileData['profile']['business_name'])?$profileData['profile']['business_name']:'');?>
                              </span>
                              </h5>
                           <h6 class="color-lightgray">
                              <span class="state_id_func_lft">
                              <?php echo (isset($profileData['state']['name'])?$profileData['state']['name']:'').',';?>
                              </span>
                              <span class="country_id_func">
                              <?php echo (isset($profileData['country']['name'])?$profileData['country']['name']:'');?>
                              </span>
                           </h6>
                        </div>
                        <!--<div class="user_pro_status">
                           <h3><span>{{ __('messages.FOLLOWERS') }} <b>{{$allFollowers}}</b></span></h3>
                        </div>-->
                        <div class="followers-holder">
                           <!--<div class="followers-title">
                              <h3>{{ __('messages.PEOPLE_VIEWED_PROFILE') }}</h3>
                              <i class="la la-ellipsis-v"></i>
                           </div>-->
                           <!--sd-title end-->
                           <!-- <div class="followers-list"> -->
                           <?php if(!empty($allFollowersList)){
                        foreach($allFollowersList as $key=>$val){ 
                           if($val['user']['user_type'] == 2){ 
                              $type = 'candidate';
                              }elseif($val['user']['user_type'] == 3){ 
                                 $type = 'company';
                                 }else{
                                    $type = '';
                                 }
                                 ?>
                              <!--<div class="media">
                              <?php if($val['user']['profileImage'] != null){?>
                                 <img src="{{asset($val['user']['profileImage']['location'])}}" alt="">
                              <?php }else{ ?>
                                 <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                              <?php }?>
                                 <div class="media-body">
                                    <h4><a href="{{url($type.'/profile/'.$val['user']['slug'])}}"> <?php //echo $val['user']['first_name'].' '.$val['user']['last_name']; ?></a></h4>
                                    <span><?php //echo $val['user']['profile']['profile_headline']; ?></span>
                                 </div>-->
                                 <!-- <div class="dropdown msg-dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                                    <a href="javascript:void(0);" class="btn site-btn-color dropdown-toggle block_user" type="button" data-id="{{$val['user']['id']}}" <?php if($val['user']['isUserBlockedByLogedInUser'] != null){?> data-block="0" <?php }else{?> data-block="1" <?php }?> id="block_user_{{$val['user']['id']}}">
                                          <?php //if($val['user']['isUserBlockedByLogedInUser'] != null){ 
                                            // echo  __('messages.UN_BLOCK');
                                          //}else{
                                            // echo  __('messages.BLOCK');
                                         // }
                                       
                                       ?> 
                                    </a>
                                    </div>
                                 </div> 
                              </div>-->
                              <?php } }?>
                              <!--<div class="view-more">
                                 <a href="{{url('company/view-followers')}}" title="" class="btn site-btn">{{ __('messages.VIEW_FOLLOWERS') }}</a>
                              </div>-->
                           <!-- </div> -->
                           <!--suggestions-list end-->
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-lg-8 col-xl-9">
                     <div class="">
                        <section class="section-myprofile" id="section1">
                           <div class="login-form">
                              <div class="row">
                                 <div class="col-12 details-panel-header">
                                    <h4>{{ __('messages.PROFILE_INFORMATION') }}</h4>
                                    <h6>{{ __('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF') }}</h6>
                                    <div class="edit-info-holder">
                                       <h5 class="form-sub-heading"> {{ __('messages.PROFESSIONAL_INFO') }} </h5>
                                       <button class="btn site-btn-color editbtn" data-toggle="modal" data-target="#professional-info" ><img src="{{ asset('frontend/images/pencil-edit-button.svg')}}" alt="edit"></button>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.COMPANY_NAME') }} :</label> 
                                       <span class="company_name_func"> 
                                       <?php echo ($profileData['company_name']?$profileData['company_name']:'');?>
                                    </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.COMPANY_BUSINESS') }} :</label> 
                                       <span class="business_name_func"> 
                                       <?php echo ($profileData['profile']['business_name']?$profileData['profile']['business_name']:'');?>
                                    </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.TELEPHONE_NO') }} :</label> 
                                       <span class="telephone_func"> 
                                       <?php echo ($profileData['telephone']?base64_decode($profileData['telephone']):'');?>
                                       </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.CONTACT_NAME') }} :</label> 
                                      <span class="first_name_func"> 
                                       <?php echo ($profileData['first_name']?base64_decode($profileData['first_name']):''); echo ' '; ?> 
                                    </span>
                                    <span class="last_name_func"> 
                                        <?php echo ($profileData['last_name']?$profileData['last_name']:'');?>
                                     </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.COMPANY_EMAIL') }} :</label> 
                                       <span class="email_func">
                                       <?php echo ($profileData['email']?base64_decode($profileData['email']):'');?>
                                    </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.CNPJ') }} :</label> 
                                       <span class="cnpj_func">
                                          <?php echo ($profileData['cnpj']?$profileData['cnpj']:'');?>
                                       </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.COUNTRY') }} :</label> 
                                       <span class="country_id_func">
                                       <?php echo (isset($profileData['country']['name'])?$profileData['country']['name']:'');?>
                                    </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.STATE') }} :</label> 
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
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.ADDRESS_LINE1') }} :</label> 
                                       <span class="address1_func">
                                       <?php echo ($profileData['address1']?$profileData['address1']:'');?>
                                    </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.ADDRESS_LINE2') }} :</label> 
                                       <span class="address2_func">
                                       <?php echo ($profileData['address2']?$profileData['address2']:'');?>
                                    </span>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-view">
                                       <label class="label-tag">{{ __('messages.ZIP_CODE') }} :</label> 
                                       <span class="postal_func">
                                          <?php echo ($profileData['postal']?$profileData['postal']:'');?>
                                       </span>
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
      <!-- <script src="{{ asset('frontend/js/dropzone.min.js')}}"></script>
      <script src="{{ asset('frontend/js/aos.js')}}"></script>
      <script src="{{ asset('frontend/js/jquery.easing.min.js')}}"></script>
      <script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>
      <script src="{{ asset('frontend/js/tagsinput.js')}}"></script> 
      <script src="{{ asset('frontend/js/swiper.min.js')}}"></script> -->
      <script src="{{ asset('frontend/js/profile.users.js')}}"></script>
      <script src="https://unpkg.com/cropperjs"></script>
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
                        <h4>{{ __('messages.UPLOAD_PHOTO') }}</h4>
                     </div>
                     <div class="upload-photo-inner">
                        <div class="upload-images remove-old-profile-image-func"> <img src="<?php echo url('/');?>/frontend/images/ic-user-remove-photo.svg" alt="remove"> </div>
                        <h4 id="change-image-remove">{{ __('messages.REMOVE_EXISTING_IMAGE') }} </h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- change-image-before -->
      <div class="modal custom-modal change-image profile-img-upload" id="change-image-before">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close close-image" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                 <h5 class="text-center mt-0 heading-profile-img"> {{ __('messages.PROFILE_IMAGE_UPLOAD') }} </h5>
                  <div class="drag-div">
                     <span class="after-span top-left"></span> <span class="after-span top-right"></span>
                     <span class="after-span bottom-left"></span> <span class="after-span bottom-right"></span>
                     <!-- <form action="/file-upload" class="dropzone" id="my-awesome-dropzone">
                        <div class="fallback">
                           <input name="file" type="file" multiple />
                        </div>
                     </form> -->
                     <div class="dropzone" id="myDropzone"></div>
                     <div class="drag-div-inner">
                        <h6 id="upload_image_now" class="upload-profile-img-func">{{ __('messages.UPDATE_IMAGE') }}</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- change banner image -->
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
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload Photo</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Upload from library</a>
                     </div>
                     </nav>
                     <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                           <!-- <h5 class="mt-0 heading-profile-img">{{ __('messages.IMAGE_UPLOAD') }} </h5> -->
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
                                 <h6 id="upload_banner_image_now">{{ __('messages.UPDATE_IMAGE') }}</h6>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                           <!-- <h3 class="heading-profile-img mt-0"> {{ __('messages.UPLOAD_FROM_LIBRARY') }} </h3> -->
                           <div class="mCustomScrollbar max-height">
                              <div class="profile-bg ">
                                @if($imageLibrary)
                                    @foreach($imageLibrary as $imgLibRow)
                                     <div data-id="{{$imgLibRow['id']}}" class="profile-banner-holder func-profile-banner-holder <?php if(isset($profileData['banner_image']['org_name']) == $imgLibRow['org_name']){ echo "selected-banner";}?>">
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
                                 <button class="site-btn-color btn upload-lib-banner-func" type="button">{{ __('messages.UPDATE_JOB') }}</button>
                           </div> 
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>

      <!-- change-image-before -->
      <div class="modal custom-modal change-image profile-img-upload" id="change-image-before">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close close-image" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <h5 class="text-center mt-0 heading-profile-img"> {{ __('messages.PROFILE_IMAGE_UPLOAD') }} </h5>
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
                        <h6 id="upload_image_now" class="upload-profile-img-func">{{ __('messages.UPDATE_IMAGE') }}</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- change-image-before -->
      <!-- End change banner image -->


      <!-- ================profile-modal================ -->
      <!-- professional-info -->
      <div class="modal custom-modal profile-modal professionalCls" id="professional-info">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <form name="form_company_profile_info" id="form_company_profile_info" action="{{ url('/company/store-profile-info') }}" method="post">
                     {{csrf_field()}}
                  <div class="login-form">
                     <div class="row">
                        <div class="col-sm-12 details-panel-header">
                                                    <h6>{!! __('messages.EDIT_PROFILE_MESSAGE', ['link' => '<a href="/contact-us">contact us</a>']) !!}</h6>

                        </div>
                                             </div>
                  </div>
               </form>
               </div>
            </div>
         </div>
      </div>
      <form id="security_form" action="" method="post">
            {{csrf_field()}}
     </form>
      <!-- ================profile-modal================ --> 
     <script>
     $(document).on("click",".close-image",function(){
         $("#myBannerDropzone").html('<div class="dz-default dz-message"><span>Drop files here to upload</span></div>');
         $("#myDropzone").html('<div class="dz-default dz-message"><span>Drop files here to upload</span></div>');
      }); 
     </script>

      <!-- ================profile-modal================ -->
       @endsection
      <!-- main-page -->

