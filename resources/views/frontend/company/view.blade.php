@extends('layouts.app_after_login_layout')
@section('content')
<input name="user_type" id="user_type" type="hidden" value="{{$user_type_id}}"/>
<script src="{{asset('frontend/js/dashboard.js')}}"></script>
<script src="{{asset('frontend/js/follow.js')}}"></script>
<script src="{{asset('frontend/js/viewFollower.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
$followUnfollowArr = [];
if((!empty($profileData['followers'])) && count($profileData['followers']) != 0){
   foreach($profileData['followers'] as $key=>$val){
       array_push($followUnfollowArr,$val['follower_id']);
   }
}
?>
      <!-- main -->
      <main>
               <section class="section section-myprofile-outer">
                  <div class="container">
                     <div class="row">
                        <div class="col-12 col-lg-4 col-xl-3">
                           <div class="profile-side-panel">
                              <div class="details-panel-header mb-3">
                                 <div class="profile-img-holder">
                                    <div class="profile-bg-img">
                                       <?php if($profileData['bannerImage'] != null){?>
                                       <img src="{{ asset($profileData['bannerImage']['location'])}}" alt="user-profile-bg">
                                       <?php }else{?>
                                          <img src="{{ asset('frontend/images/user-pro-bg-img.jpg')}}" alt="user-profile-bg">
                                       <?php }?>
                                    </div>
                                    <div class="profile-img">
                                       <?php if($profileData['profileImage'] != null){?>
                                       <img src="{{asset($profileData['profileImage']['location'])}}" alt="user-profile">
                                        <?php }else{?>
                                          <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="user-profile">
                                        <?php }?>
                                    </div>
                                 </div>
                                 <h3 class="h3-profile"><?php echo ($profileData['company_name']?$profileData['company_name']:'');?></h3>
                                 <h5 class="text-company">{{isset($profileData['profile']['business_name'])?$profileData['profile']['business_name']:''}}
                                    <?php //echo ($profileData['profile']['business_name']?$profileData['profile']['business_name']:'');?>
                                 </h5>
                                 <h6 class="color-lightgray">
                                    {{isset($profileData['state']['name'])?$profileData['state']['name']:''}} , {{isset($profileData['country']['name'])?$profileData['country']['name']:''}}
                                    <?php //echo ($profileData['state']['name']?$profileData['state']['name']:'').', '.($profileData['country']['name']?$profileData['country']['name']:'');?>
                                 </h6>
                              </div>
                              <div class="user_pro_status pb-2 mb-3">
                                 <h3 class="text-center"><span>{{ __('messages.FOLLOWERS') }} <b id="total-follow-{{$profileData['id']}}">{{$allFollowers}}</b></span></h3>
                              </div>
                              <?php  if((Auth::user()) && ((Auth::user()->user_type != 1) && (Auth::user()->id != $profileData['id']))){;
                              if($profileData['isUserBlockedByLogedInUser'] == null){ ?>
                              <div class="profile-btn-holder d-flex">
                                 <?php if($user_type_id == 2){?>
                                 <button class="btn site-btn-color mr-2 w-100 follow-unfollow-user-{{$profileData['id']}}" id="follow-unfollow-user" data-id="{{$profileData['id']}}" <?php if(!empty($followUnfollowArr) && (in_array(Auth::user()->id,$followUnfollowArr))){ ?>data-follow="0"<?php }else{ ?> data-follow="1"<?php }?>><?php if(!empty($followUnfollowArr) && (in_array(Auth::user()->id,$followUnfollowArr))){ echo __('messages.UN_FOLLOW');}else{ echo __('messages.FOLLOW');}?></button> 
                                 <?php }else{ ?>
                                    <button class="btn site-btn-color mr-2 w-100" href="{{url('/')}}">{{ __('messages.FOLLOW') }}</button> 
                                    <?php }?>
                                 <div class="dropdown msg-dropdown">
                                    <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       
                                       <?php if(($user_type_id == 2) && (Auth::user()) && (!in_array(Auth::user()->id,$isReported))){?>
                                       <a class="dropdown-item" href="javascript:void(0);" id="report-company-id" data-id="{{$profileData['id']}}">{{ __('messages.REPORT') }}</a>
                                       <?php }else if(($user_type_id == 2) && (Auth::user()) && (in_array(Auth::user()->id,$isReported))){?>
                                          <a class="dropdown-item"  href="javascript:void(0);" style="cursor:default;" disabled>{{ __('messages.REPORTED') }}</a>
                                       <?php }
                                       else{?>
                                          <a class="dropdown-item"  href="{{url('/')}}" >{{ __('messages.REPORT') }}</a>
                                       <?php } ?>
                                       
                                    </div>
                                 </div>
                              </div>
                              <?php }else{?>
                                    <div class="profile-btn-holder d-flex">
                                    <button class="btn site-btn-color w-100 mr-2 block_user" data-id="{{$profileData['id']}}" data-block="0" id="block_user_{{$profileData['id']}}">{{__('messages.UN_BLOCK')}}</button>    
                                    </div>
                                 <?php } }?>

                                 <?php if((Auth::user()) && (Auth::user()->id == 1)){?>
                                    <div class="profile-btn-holder d-flex">
                                    <?php if($profileData['status'] == 1){?>
                              <button class="btn site-btn-color w-100 mr-2" id="" data-id="{{$profileData['id']}}" style="cursor:default;">Active</button>     
                              <?php }else{?>
                                 <button class="btn site-btn-color w-100 mr-2" id="" data-id="{{$profileData['id']}}" style="cursor:default;">Inactive</button>       
                              <?php }?>
                                    </div>
                                 <?php }?>
                           </div>
                        </div>
                        <div class="col-12 col-lg-8 col-xl-9">
                           <div class="">
                              <section class="section-myprofile" id="section1">
                                 <div class="login-form">
                                    <div class="row">
                                       <div class="col-12 details-panel-header">
                                          <h4>{{__('messages.PROFILE_INFORMATION')}}</h4>
                                          <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{__('messages.COMPANY_NAME')}} :</label> 
                                             <?php echo ($profileData['company_name']?$profileData['company_name']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{__('messages.COMPANY_BUSINESS')}} :</label> 
                                             <?php echo ($profileData['profile']['business_name']?$profileData['profile']['business_name']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{__('messages.COUNTRY')}} :</label> 
                                             {{isset($profileData['country']['name'])?$profileData['country']['name']:''}}
                                             <?php //echo ($profileData['country']['name']?$profileData['country']['name']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{__('messages.STATE')}} :</label> 
                                             {{isset($profileData['state']['name'])?$profileData['state']['name']:''}}
                                             <?php //echo ($profileData['state']['name']?$profileData['state']['name']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{__('messages.CITY')}} :</label> 
                                             <?php echo ($profileData['city_id']?$profileData['city_id']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{__('messages.ADDRESS_LINE1')}}  :</label> 
                                             <?php echo ($profileData['address1']?$profileData['address1']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                          <label class="label-tag">{{ __('messages.ADDRESS_LINE2') }} :</label> 
                                             <?php echo ($profileData['address2']?$profileData['address2']:'');?>
                                          </div>
                                       </div>                                             
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{ __('messages.ZIP_CODE') }} :</label> 
                                                <?php echo ($profileData['postal']?$profileData['postal']:'');?>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-12 col-md-6">
                                          <div class="form-view">
                                             <label class="label-tag">{{ __('messages.CNPJ') }} :</label> 
                                                <?php echo ($profileData['cnpj']?$profileData['cnpj']:'');?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </section>
                           </div>
                           
                           <input type="hidden" name="page" id="page" value="{{$search['page']}}"/>
                           <input type="hidden" name="slug" id="slug" value="{{$profileData['slug']}}"/>
                           
                           <?php $isBlockUser = Helper::checkBlockUser($profileData['id']); 
                           if(empty($isBlockUser)){
                           ?>
                           <div class="row" id="post-data">
                           <div class="col-12"> <h4 class="total-title"> {{__('messages.RECENT_POST')}} </h4></div>
                           @include('frontend.company.postData')
                           <?php if($postData->count() == 0){?>
                           <div class="col-12">
                              <div class="post-coming">
                                 <p class="mb-0"> {{__('messages.NEW_POST_COMING_SOON')}}......</p>
                              </div>
                           </div>
                           <?php }?>
                              <div class="col-12 ajax-load" style="display:none">
                                 <div class="process-comm">
                                      <div class="spinner">
                                         <div class="bounce1"></div>
                                         <div class="bounce2"></div>
                                         <div class="bounce3"></div>
                                      </div>
                                 </div> 
                              </div>
                           </div>
                           <?php }?>
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
       <script>
        
              
               $(document).ready(function() {
                  // scroll pagination
                  var $this = this;
                  var page = $('#page').val();

                  $(window).scroll(function() {
                        if($(window).scrollTop() == $(document).height() - $(window).height()) {
                           page++;
                           //search with list
                           
                           $(window).scrollTop($(window).scrollTop()-1);
                           loadMoreData(page);
                           
                        }
                  });
                  
               });
            
           function loadMoreData(page){
                        $(document).ready(function() {
                        var slug = $('#slug').val();   
                        $('.ajax-load').show();
                        $.ajax(
                           {   
                              url: _BASE_URL+'/company/profile/'+slug+'?page=' + page,
                              type: "get",
                              async: false,
                              headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              },
                              success:function(){
                                          // let newPageNum = $('#page_num').val();
                                          // $('#page_num').val((newPageNum+1))
                              }
                           })
                           .done(function(data)
                           {
                              console.log(data);
                              //$('.ajax-load').hide();
                              if(data == 0){
                                    $('.ajax-load').html("No more records found");
                                    return;
                              }
                              $('#post-data').fadeIn();
                              $("#post-data").append(data.html);
                              $('.ajax-load').hide();
                           })
                           .fail(function(jqXHR, ajaxOptions, thrownError)
                           {
                              alert('server not responding...');
                           });
                        });
            } 
          </script>
      <!-- main-page -->
      <!-- ================Modal================ -->
      <!-- change-image -->
      <!-- Report Modal -->
      <div class="modal custom-modal profile-modal report-modal" id="report-modal-open">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
               <?php if((Auth::user()) && Auth::user()->user_type == 2){?>
               <form id="report" action="{{url('/candidate/report-comment')}}" method="post" >
               <?php }else if((Auth::user()) && Auth::user()->user_type == 3){?>
                  <form id="report" action="{{url('/company/report-comment')}}" method="post" >
               <?php }?>
                     {{ csrf_field() }}
                     <input type="hidden" name="comment_id" id="comment_id" value=""/>
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.REPORT')}}</h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label>{{__('messages.WHY_ARE_YOU_REPORTING')}}</label>
                              <textarea class="form-control" name="comment" id="comment"></textarea>
                           </div>
                        </div>
                        <div class="col-12 ext-left">
                           <button class="btn site-btn-color report-submit-btn" type="submit">{{__('messages.SUBMIT')}}</button>
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
                                          <input type="text" class="form-control" name="comment" placeholder="{{__('messages.COMMENT')}}">
                                          
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
     <!-- Report Company Modal -->
     <div class="modal custom-modal profile-modal report-company-modal" id="report-company-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
               <form id="report_company" action="{{url('/candidate/report-company')}}" method="post" >
                     {{ csrf_field() }}
                     <input type="hidden" name="company_id" id="company_id" value=""/>
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4 class="text-left">{{__('messages.REPORT')}}</h4>
                        </div>
                        <div class="col-12">
                           <div class="form-group required">
                              <label>{{__('messages.WHY_ARE_YOU_REPORTING')}}</label>
                              <textarea class="form-control" name="comment" id="comment"></textarea>
                           </div>
                        </div>
                        <div class="col-12 ext-left">
                           <button class="btn site-btn-color report-submit-btn report-company-cls" type="submit">{{__('messages.SUBMIT')}}</button>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Report Company Modal -->

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
                                       @if (Auth::user()->user_type == 2)
                                          <h5 class="post-name">{{Auth::user()->first_name}}</h5>
                                          <p class="post-location">
                                             @if (isset(Auth::user()->currentCompany['title']) && Auth::user()->currentCompany['title'] !='')
                                              {{Auth::user()->currentCompany['title']}} at {{Auth::user()->currentCompany['company_name']}}
                                             @endif
                                          </p>
                                       @elseif (Auth::user()->user_type == 3)
                                          <h5 class="post-name">{{Auth::user()->company_name}}</h5>
                                          <p class="post-location">{{isset(Auth::user()->profile['business_name'])?Auth::user()->profile['business_name']:''}}</p>
                                       @endif

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
      <!-- ================profile-modal================ -->

      
      
      
      
   <!-- </body>
</html> -->

