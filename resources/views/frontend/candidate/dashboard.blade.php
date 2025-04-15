@extends('layouts.app_after_login_layout')
@section('content')
<input name="user_type" id="user_type" type="hidden" value="{{$user_type_id}}"/>
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('frontend/js/dashboard.js')}}"></script>
<?php //echo ini_get('post_max_size'); exit; ?>
 <!-- main -->
            <main>
               <section class="section section-dashboard">
                  <div class="container">
                    <div class="row">
                       <div class="col-12 col-xl-12 mx-auto">
                          <div class="login-form">
                              
                              <div class="row mb-4">
                                <div class="col-12 col-lg-3">

                                    <div class="profile-side-panel">
                                       <div class="details-panel-header border-bottom-0 pb-0 mb-2">
                                          <div class="profile-img-holder">
                                             <div class="profile-bg-img">

                                                @if(!empty($userProfInfo['bannerImage']))
                                                   <img class="profile-image-src-menu" id="profile-image-src-menu" src="{{ asset($userProfInfo['bannerImage']['location']) }}" alt="">
                                                @else
                                                   <img class="profile-image-src-menu" id="profile-image-src-menu" src="<?php echo url('/');?>/frontend/images/user-pro-bg-img.jpg" alt="">
                                                @endif
                                             </div>
                                             <div class="profile-img">
                                                @if(!empty($userProfInfo['profileImage']))
                                                   <img class="profile-image-src-menu" id="profile-image-src-menu" src="{{ asset($userProfInfo['profileImage']['location']) }}" alt="">
                                                @else
                                                   <img class="profile-image-src-menu" id="profile-image-src-menu" src="<?php echo url('/');?>/frontend/images/user-pro-img-demo.png" alt="">
                                                @endif
                                             </div>
                                          </div>
                                          <h3 class="h3-profile"><?php if($userProfInfo['user_type'] == 2){ echo ($userProfInfo['first_name']?auth()->user()->first_name:'');}else if($userProfInfo['user_type'] == 3){ echo ($userProfInfo['company_name']?$userProfInfo['company_name']:'');}?></h3>
                                          <h5 class="text-company"><?php if($userProfInfo['user_type'] == 2){ echo (isset($userProfInfo['profile']['profile_headline'])?$userProfInfo['profile']['profile_headline']:'');}else if($userProfInfo['user_type'] == 3){ echo (isset($userProfInfo['profile']['business_name'])?$userProfInfo['profile']['business_name']:'');}?></h5>
                                          <h6 class="color-lightgray"><?php echo (isset($userProfInfo['state']['name'])?$userProfInfo['state']['name'].',':''); echo (isset($userProfInfo['country']['name'])?$userProfInfo['country']['name']:'');?></h6>
                                          <div class="profile-btn-holder">
                                             <?php if($userProfInfo['user_type'] == 3){?>
                                                <a href="{{url('company/my-profile')}}" class="btn site-btn-color w-100"> {{ __('messages.EDIT_PROFILE') }}</a> 
                                             <?php }else if($userProfInfo['user_type'] == 2){?>
                                                <a href="{{url('candidate/my-profile')}}" class="btn site-btn-color w-100"> {{ __('messages.EDIT_PROFILE') }}</a> 
                                             <?php }?>
                                          </div>
                                          
                                          
                                       </div>
                                     
                                       <div class="create-post-holder-pos">
                                          <!-- <h4 class="page-title"> {{ __('messages.CREATE_POST') }} </h4> -->
                                          <div class="create-post-holder ">
                                          <?php if($userProfInfo['user_type'] == 3){?>
                                             <a
                                             href="{{ url('company/my-jobs') }}"
                                             class="btn site-btn-color w-100 mt-3">
                                             {{ __('messages.MANAGE_YOUR_JOB_POST') }}
                                             </a>
                                             <!-- <div class="manage-job-post">
                                                   <a href="{{ url('company/my-jobs') }}" > 
                                                      <span class="create-icon"> 
                                                      <i class="fa fa-user" aria-hidden="true"></i>
                                                      </span> 
                                                      Manage Your job post
                                                   </a> 
                                             </div> -->
                                          <?php }?>
                                                <!--<div class="create-post" data-toggle="modal" data-target="#create-any-post-modal">
                                                   <a class="create-icon"> <i class="fa fa-pencil-square" aria-hidden="true"></i> </a>
                                                   {{ __('messages.CREATE_POST') }}
                                                </div> -->
                                                <!-- <div class="create-post" data-toggle="modal" data-target="#create-text-post-modal">
                                                   <a class="create-icon"> <i class="fa fa-pencil-square" aria-hidden="true"></i> </a>
                                                   {{ __('messages.WRITE_A_POST') }}
                                                </div>
                                                <div class="create-post" data-toggle="modal" data-target="#create-img-post-modal">
                                                   <a class="create-icon"> <i class="fa fa-camera" aria-hidden="true"></i> </a>
                                                   {{ __('messages.POST_AN_IMAGE') }}
                                                </div>   
                                                <div class="create-post" data-toggle="modal" data-target="#create-video-post-modal">
                                                   <a class="create-icon"> <i class="fa fa-video-camera" aria-hidden="true"></i> </a>
                                                   {{ __('messages.POST_A_VIDEO') }}
                                                </div>    -->
                                          </div>
                                       </div>
                                    </div>  
                                </div>   
                                <div class="col-12 col-lg-9">
                                    <?php  $isdata=0; if($postData){  
                                       foreach($postData as $key=>$postRow){ 
                                         
                                             $isdata++;
                                             if($postRow['user']['user_type'] == 2){ 
                                                $postedUser = 'candidate';
                                             }else if($postRow['user']['user_type'] == 3){
                                                $postedUser = 'company';
                                             } else{
                                                $postedUser = 'company';
                                             }
                                            
                                             $addClassLike = '';
                                             if(!empty($postRow['likes'])){
                                                foreach($postRow['likes'] as $key=>$val){
                                                   if($val['user_id'] == Auth::user()->id){
                                                      $addClassLike = 'addlike';
                                                   }
                                                }
                                             }
                                          if($postRow['category_id'] == 3 || $postRow['category_id'] == 4 ){
                                             //S3 BUCKET IMG
                                             if($postRow['upload']['name'] != ''){
                                                $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
                                                $command = $adapter->getClient()->getCommand('GetObject', [
                                                'Bucket' => $adapter->getBucket(),
                                                'Key'    => $adapter->getPathPrefix(). '' . $postRow['upload']['name']
                                                ]);
                                                $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
                                                $path = (string)$img->getUri();
                                             }else{
                                                $path = '';
                                             }
                                            
                                          }   
                                         
                                       
                                    ?>
                                    @if($postRow['category_id'] == 1)                                   
                                        @include('frontend.post.jobpost')
                                    @endif 

                                    @if($postRow['category_id'] == 2)
                                        @include('frontend.post.textpost')
                                    @endif

                                    @if($postRow['category_id'] == 3)                                   
                                        @include('frontend.post.imagepost')
                                    @endif 

                                    @if($postRow['category_id'] == 4)                                   
                                        @include('frontend.post.videopost')
                                    @endif 

                                    <?php  } 
                                 echo $postData->appends(request()->query())->onEachSide(1)->links() ;
                                 } if($isdata == 0){?>
                                    <!--  nodata-found-holder -->
                                       <div class="nodata-found-holder">
                                          <img src="{{asset('frontend/images/warning-icon.png')}}" alt="">
                                          <h4> {{ __('messages.NO_DATA_FOUND') }} </h4>
                                       </div>
                                    <!--  nodata-found-holder --> 
                                    <?php } ?>
                                </div> 
                          </div> 
                       </div>   
                    </div>                      
                  </div>
               </section>
            </main>
<!-- main End -->
 <!-- Create Post Modal -->
      <div class="modal custom-modal profile-modal dashboard-modal" id="create-text-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <form action="{{ url('/store-text-post') }}" method="post" id="text_post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left">{{ __('messages.CREATE_POST') }}</h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label class="question-label">{{ __('messages.WRITE_SOMETHING_TO_SHARE') }}</label>
                              <textarea class="form-control" name="description" id="description"></textarea>
                           </div>
                           
                        </div>
                        <div class="col-12 text-left">
                           <button class="btn site-btn-color" type="submit">{{ __('messages.POST') }}</button>
                        </div>
                     </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
<!-- Create Video Post -->
 
<!-- End Video Post image -->      
 <!-- Create Post Modal -->
      <div class="modal custom-modal profile-modal dashboard-modal" id="create-img-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                  <form action="{{ url('/store-image-post') }}" method="post" id="image_post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input hidden id="file" name="file"/>
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left">{{ __('messages.CREATE_POST') }}</h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label class="question-label">{{ __('messages.WRITE_SOMETHING_TO_SHARE') }}</label>
                              <textarea class="form-control write-creat post-title-data" name="title" id="title"></textarea>
                           </div>
                        </div>   
                        <div class="col-12">
                          <!--  <label class="question-label mb-3">Upload your image or video</label> -->
                           <div class="drag-div">
                              <span class="after-span top-left"></span> <span class="after-span top-right"></span>
                              <span class="after-span bottom-left"></span> <span class="after-span bottom-right"></span>
                              
                                 <div class="fallback postImageUpload dropzone " id="postImageUpload" >
                                    
                                 </div>
                                 
                              
                              <!-- <div class="drag-div-inner">
                                 <h6>update image</h6>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 text-left mt-3">
                           <button class="btn site-btn-color" type="submit">{{ __('messages.POST') }}</button>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Create Post Modal -->    
       <!-- ================Modal================ -->
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
                           <button class="btn site-btn-color report-post-cls" type="submit">{{ __('messages.SUBMIT') }}</button>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Report Modal -->
      <!-- Report Modal -->
      <div class="modal custom-modal profile-modal report-modal" id="report-modal-open">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
               <?php if(Auth::user()->user_type == 2){?>
               <form id="report" action="{{url('/candidate/report-comment')}}" method="post" >
               <?php }else if(Auth::user()->user_type == 3){?>
                  <form id="report" action="{{url('/company/report-comment')}}" method="post" >
               <?php }?>
                     {{ csrf_field() }}
                     <input type="hidden" name="comment_id" id="comment_id" value=""/>
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
                           <button class="btn site-btn-color report-submit-btn post-comment-report-cls" type="submit">{{ __('messages.SUBMIT') }}</button>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Report Modal -->
      <!-- Comment Post Modal -->
      <div class="modal custom-modal profile-modal  text-left " id="comment-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                     <div class="row">
                        <!-- <div class="col-sm-12 details-panel-header">
                           <h4 class="text-center">Comment</h4>
                        </div> -->
                        <div class="col-12">
                           <!-- write-comment-box -->
                           <div class="write-comment-box-holder function-write-comment-box">
                              <div class="mCustomScrollbar max-height" id="no-data">
                                 <div class="comment-list" id="commentListApp">
                                                                                             
                                 </div>
                              </div> 
                              <div class="comment-list comment-list-not-found" style="display:none;">
                                                                                             
                                 </div>  
                              <div class="message-send-area">
                                 <form id="post_comment" action="{{url('/candidate/post-comment')}}" method="post" >
                                 {{ csrf_field() }}
                                 <input type="hidden" name="post_id" id="post_id" value=""/>
                                    <div class="message-send-form-holder media">
                                       <div class="message-send-input-box media-body">
                                          <!-- <input type="text" class="form-control" name="comment" placeholder="Comment"> -->
                                          <textarea class="form-control h-44" name="comment" placeholder="{{ __('messages.COMMENT') }}"></textarea>
                                       </div>
                                       <button type="submit" class="msg-send"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>   
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Comment Modal -->

      <!-- Create Post Modal -->

      <!-- Comment Post Modal -->
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
                                    @if(!empty($userProfInfo['profileImage']) && !is_null($userProfInfo['profileImage']))
                                       <img src="{{ asset($userProfInfo['profileImage']['location']) }}" alt="">
                                    @else
                                       <img src="{{ asset('frontend/images/user.png') }}" alt="">
                                    @endif
                                     
                                     </div>
                                    <div class="media-body">
                                       <?php if(Auth::user()->user_type == 2){?>
                                          <h5 class="post-name">{{Auth::user()->first_name}}</h5>
                                          <p class="post-location">
                                             <?php  
                                             if(isset(Auth::user()->currentCompany['title']) && Auth::user()->currentCompany['title'] !=''){ 
                                                echo Auth::user()->currentCompany['title'];
                                                echo ' at '. Auth::user()->currentCompany['company_name'];
                                                } 
                                             ?></p>
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
      <div class="modal custom-modal profile-modal dashboard-modal" id="create-any-post-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                  <form action="{{ url('/store-any-post') }}" method="post" id="any_post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input hidden id="file" name="file"/>
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left">{{ __('messages.CREATE_POST') }}</h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label class="question-label">{{ __('messages.WRITE_SOMETHING_TO_SHARE') }}</label>
                              <textarea class="form-control write-creat post-title-data" name="title" id="title"></textarea>
                           </div>
                        </div>   
                        <div class="col-12">
                          <!--  <label class="question-label mb-3">Upload your image or video</label> -->
                           <div class="drag-div">
                              <span class="after-span top-left"></span> <span class="after-span top-right"></span>
                              <span class="after-span bottom-left"></span> <span class="after-span bottom-right"></span>
                                 <div class="fallback postVideoUpload dropzone " id="postVideoUpload" >
                                 </div>
                           </div>
                        </div>
                        <div class="col-12 text-left mt-3">
                           <button class="btn site-btn-color" type="submit">{{ __('messages.POST') }}</button>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Comment Modal -->      
@endsection
