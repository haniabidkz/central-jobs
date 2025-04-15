@extends('layouts.app_after_login_layout')
@section('content')
<input name="user_type" id="user_type" type="hidden" value="{{$user_type_id}}"/>
<script src="{{asset('frontend/js/dashboard.js')}}"></script>

<main>
               <section class="section section-dashboard">
                  <div class="container">
                    <div class="row">
                       <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                          <div class="login-form">
                              <div class="row mb-4">
                                <div class="col-12">
                                   
                                    <?php 
                                       if($postData['user']['user_type'] == 2){ 
                                          $postedUser = 'candidate';
                                       }else if($postData['user']['user_type'] == 3){
                                          $postedUser = 'company';
                                       }  
                                       $addClassLike = '';
                                       if(!empty($postData['likes'])){
                                          foreach($postData['likes'] as $key=>$val){
                                             if((Auth::user()) && ($val['user_id'] == Auth::user()->id)){
                                                $addClassLike = 'addlike';
                                             }
                                          }
                                       }

                                       if($postData['category_id'] == 3 || $postData['category_id'] == 4 ){
                                          //S3 BUCKET IMG
                                          if($postData['upload']['name'] != ''){
                                             $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
                                             $command = $adapter->getClient()->getCommand('GetObject', [
                                             'Bucket' => $adapter->getBucket(),
                                             'Key'    => $adapter->getPathPrefix(). '' . $postData['upload']['name']
                                             ]);
                                             $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
                                             $path = (string)$img->getUri();
                                          }else{
                                             $path = '';
                                          }
                                       }  
                                    ?>
                                    @if($postData['category_id'] == 1)
                                        @include('frontend.post.jobpostDetail')
                                    @endif

                                    @if($postData['category_id'] == 2)
                                        @include('frontend.post.textpostDetail')
                                    @endif   

                                    @if($postData['category_id'] == 3)                                   
                                        @include('frontend.post.imagepostDetail')
                                    @endif 

                                    @if($postData['category_id'] == 4)                                   
                                        @include('frontend.post.videopostDetail')
                                    @endif 
                                    
                                </div> 

                              </div> 
                           </div>   
                        </div>                      
                     </div>
                  </div>
               </section>
            </main>
            <!-- Report Modal -->
 <div class="modal custom-modal profile-modal report-modal" id="report-modal-open">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
               <?php if((Auth::user()) && (Auth::user()->user_type == 2)){?>
               <form id="report" action="{{url('/candidate/report-comment')}}" method="post" >
               <?php }else if((Auth::user()) && (Auth::user()->user_type == 3)){?>
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
                                 <input type="hidden" name="post_id" id="post_id" value="{{$postData['id']}}"/>
                                    <div class="message-send-form-holder media">
                                       <div class="message-send-input-box media-body">
                                          <input type="text" class="form-control" name="comment" placeholder="{{ __('messages.COMMENT') }}">
                                          
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

                                       <?php if((Auth::user()) && (Auth::user()->user_type == 2)){?>
                                          <h5 class="post-name">{{Auth::user()->first_name}}</h5>
                                          <p class="post-location"><?php echo Auth::user()->currentCompany['title']; if(Auth::user()->currentCompany['title'] !=''){ echo ' at '. Auth::user()->currentCompany['company_name'];} ?></p>
                                       <?php }else if((Auth::user()) && (Auth::user()->user_type == 3)){?>
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
@endsection
 