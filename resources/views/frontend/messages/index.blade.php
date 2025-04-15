@extends('layouts.app_after_login_layout')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="{{ asset('frontend/js/messages.js')}}"></script>
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php 
   function formatTimeString($timeStamp) {
      $str_time = date("Y-m-d H:i:sP", $timeStamp);
      $time = strtotime($str_time);
      $d = new DateTime($str_time);
      
      $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satday', 'Sunday'];
      $months = ['Jan', 'Feb', 'Mar', 'Apr', ' May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
      
      if ($time > strtotime('today')) {
         return 'Today';
      } elseif ($time > strtotime('yesterday')) {
         return 'Yesterday';
      } elseif ($time > strtotime('last weeks')) {
         return $weekDays[$d->format('N') - 1];
      } else {
         return $d->format('j') . ' ' . $months[$d->format('n') - 1] . ' ' . date("Y");
         
      }
      
   }
   
   ?>
 <!-- main -->
            <main>
               <section class="messages-page">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-12 col-lg-4 col-xl-4 col-12 pr-lg-0">
                           <div class="msgs-list-holder">
                              <!-- <div class="msg-title">
                                 <h3>Messages</h3>
                                 <ul>
                                    <li><a href="#" title=""><i class="fa fa-cog"></i></a></li>
                                    <li><a href="#" title=""><i class="fa fa-ellipsis-v"></i></a></li>
                                 </ul>
                                 </div> -->
                                
                              <div class="custom-tab" id="tab-2">
                                 <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link <?php if($candidateName != ''){ echo 'active';}else if((Auth::user()->user_type == 3) || (($userChatingInfo->user_type == 2) && (Auth::user()->user_type == 2) && ($companyName == ''))){ echo 'active';}?>" id="tab-5-tab" data-toggle="tab" href="#tab-5" role="tab" aria-controls="tab-5" aria-selected="true"><i class="fa fa-user" aria-hidden="true"></i>{{ __('messages.CANDIDATE') }}</a>
                                    </li>
                                    @if(Auth::user()->user_type != 3)
                                       <li class="nav-item">
                                          <a class="nav-link <?php if(($companyName != '') || ($userChatingInfo->user_type == 3)){ echo 'active';}?>" id="tab-6-tab" data-toggle="tab" href="#tab-6" role="tab" aria-controls="tab-6" aria-selected="false">
                                             <i class="fa fa-user" aria-hidden="true"></i>{{ __('messages.EMPLOYER') }}
                                          </a>
                                       </li>
                                    @endif

                                 </ul>
                                 <div class="tab-content">
                                    <div class="tab-pane <?php if($candidateName != ''){ echo 'active';}else if((Auth::user()->user_type == 3) || (($userChatingInfo->user_type == 2) && (Auth::user()->user_type == 2) && ($companyName == ''))){ echo 'active';}?>" id="tab-5" role="tabpanel" aria-labelledby="tab-5-tab">
                                    <form action="" id="candidate_name" method="get">
                                       <div class="message-search-form"> 
                                             <input type="text" class="form-control" name="candidate_name" value="{{@$candidateName}}">
                                             <button class="btn" type="submit"><img src="{{ asset('frontend/images/ic-search.svg')}}" alt="search"></button>
                                       </div>
                                       </form>
                                       <div class="messages-list">
                                          <?php  $i = 0; ?>
                                           @if(!empty($usersChatHistory)) 
                                          <ul>
                                          	
                                          	    @foreach ($usersChatHistory as $row)
                                          	      @if($row->user_from_id != $userId && $row->user_type == 2)
                                                   <?php $i++ ;?>
		                                            <li>
		                                             	<a href="{{url('/candidate/message/')}}/{{encrypt($row->id)}}">
		                                                <div class="media usr-msg-details">
                                                      
		                                                   <div class="usr-ms-img">
                                                         <?php if(($row->deleted_at != null) || ($row->status == 2) || ($row->status == 0) || ($row->isLogedInUserBlock)){?>
                                                            <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                                            <?php }else{?>
		                                                   	@if($row->profileImage == null)
		                                                      <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
		                                                       @endif

		                                                    @if($row->profileImage != null)
		                                                      <img src="{{asset($row->profileImage->location)}}" alt="">
		                                                    @endif
                                                            <?php }?>
		                                                     <!--  <span class="msg-status"></span> -->
		                                                   </div>
		                                                   <div class="media-body usr-mg-info">
		                                                      <h3> {{ $row->first_name }} </h3>
		                                                      <p> {{ substr($userLastChatedData[$row->id]['message'],0,10)}}...</p>
		                                                   </div>
		                                                   <!--usr-mg-info end-->
		                                                  <!--  <span class="msg-notifc">1</span> -->
		                                                </div>
		                                                <!--usr-msg-details end-->
		                                            	</a>
		                                             </li>
		                                          	@endif	                                                                                      	
                                             	@endforeach
                                            
                                          </ul>
                                           @endif
                                          <?php if($i == 0){?>
                                             <div class="add-contact-holder">
                                                <div class="add-contact">
                                                   <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                                   <h4> {{ __('messages.ADD_YOUR_CONTACT') }}</h4>
                                                </div>
                                             </div>
                                          <?php }?>
                                       </div>
                                       <!--messages-list end-->
                                    </div>
                                    <!--dff-tab end-->
                                    @if(Auth::user()->user_type != 3)
                                    <div class="tab-pane <?php if(($companyName != '') || ($userChatingInfo->user_type == 3)){ echo 'active';}?>" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
                                    <form action="" id="company_name" method="get">
                                       <div class="message-search-form"> 
                                          <input type="text" class="form-control" name="company_name" value="{{@$companyName}}">
                                          <button class="btn"><img src="{{ asset('frontend/images/ic-search.svg')}}" alt="search"></button>
                                       </div>
                                       </form>
                                       <div class="messages-list">
                                          <?php $j = 0;?>

                                       @if(!empty($usersChatHistory)) 
                                          <ul>                                          	
                                          	    @foreach ($usersChatHistory as $row)
                                          	    	
		                                             @if($row->user_to_id != $userId && $row->user_type == 3)
                                                   <?php $j++ ;?>
		                                              <li>
                                                      <a href="{{url('/company/message/')}}/{{encrypt($row->id)}}">
                                                      <div class="media usr-msg-details">
                                                         <div class="usr-ms-img">
                                                         <?php if(($row->deleted_at != null) || ($row->status == 2) || ($row->status == 0) || ($row->isLogedInUserBlock)){?>
                                                            <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                                            <?php }else{?>
                                                            @if($row->profileImage == null)
                                                            <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                                             @endif

                                                          @if($row->profileImage != null)
                                                            <img src="{{asset($row->profileImage->location)}}" alt="">
                                                          @endif
                                                         <?php }?>
                                                           <!--  <span class="msg-status"></span> -->
                                                         </div>
                                                         <div class="media-body usr-mg-info">
                                                            <h3> {{ $row->company_name }} </h3>
                                                            <p> {{ substr($userLastChatedData[$row->id]['message'],0,10)}}...</p>
                                                         </div>
                                                         <!--usr-mg-info end-->
                                                        <!--  <span class="msg-notifc">1</span> -->
                                                      </div>
                                                      <!--usr-msg-details end-->
                                                   </a>
                                                   
                                                   </li>
		                                             @endIf
                                             	@endforeach
                                            
                                          </ul>
                                       @endif
                                       <?php if($j == 0){?>
                                             <div class="add-contact-holder">
                                                <div class="add-contact">
                                                   <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                                   <h4> {{ __('messages.ADD_YOUR_CONTACT') }}</h4>
                                                </div>
                                             </div>
                                          <?php }?>
                                       </div>
                                       <!--messages-list end-->
                                    </div>
                                    @endif
                                    <!--dff-tab end-->
                                 </div>
                              </div>
                           </div>
                           <!--msgs-list-holder end-->
                        </div>
                        <?php if($userChatingInfo->user_type == 2){
                           $user_type = 'candidate';
                        }
                        else if($userChatingInfo->user_type == 3){
                           $user_type = 'company';
                        }?>
                        <div class="col-md-12 col-lg-8 col-xl-8 col-12 pl-lg-0">
                           <div class="main-conversation-box">
                              <div class="message-bar-head">
                                 <div class="media">
                                    <div class="usr-ms-img">
                                    <?php if(($userChatingInfo->deleted_at != null) || ($userChatingInfo->status == 2) || ($userChatingInfo->status == 0) || ($userChatingInfo->isLogedInUserBlock)){?>
                                       <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                       <?php }else{?>  
                                    <a href="{{url($user_type.'/profile/'.$userChatingInfo->slug)}}"> 
                                    @if($userChatingInfo->profileImage == null)
                                       <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                    @endif
                                    
                                    @if($userChatingInfo->profileImage != null)
                                       <img src="{{ asset($userChatingInfo->profileImage->location)}}" alt="">
                                    @endif
                                    </a>
                                       <?php }?>
                                    </div>
                                    <div class="media-body usr-mg-info">
                                       <h3>
                                       <?php if(($userChatingInfo->deleted_at != null) || ($userChatingInfo->status == 2) || ($userChatingInfo->status == 0) || ($isSelectedUserBlocked) || ($userChatingInfo->isLogedInUserBlock)){
                                          if($userChatingInfo->user_type == 2){
                                             echo $userChatingInfo->first_name;
                                          }else if($userChatingInfo->user_type == 3){
                                             echo $userChatingInfo->company_name;
                                          }
                                          
                                       }else{?>
                                       <a href="{{url($user_type.'/profile/'.$userChatingInfo->slug)}}"> 
                                          @if($userChatingInfo->user_type == 2)
                                             {{ $userChatingInfo->first_name }} 
                                       	@endif
                                          @if($userChatingInfo->user_type == 3)
                                             {{ $userChatingInfo->company_name }} 
                                          @endif
                                       </a>
                                       <?php }if((Auth::user()->id != $userSelectedId) && (($userChatingInfo->deleted_at != null) || ($userChatingInfo->status == 2) || ($userChatingInfo->status == 0))){?>
                                          <p><i class="fa fa-ban" aria-hidden="true"></i> {{ __('messages.UNABLE_TO_SEND_MESSAGE') }}</p>
                                       <?php }else if($isSelectedUserBlocked){?>
                                       <p><i class="fa fa-ban" aria-hidden="true"></i> {{ __('messages.UNBLOCK') }} {{ $userChatingInfo->first_name }} {{ __('messages.TO_SEND_MESSAGE') }}</p>
                                       <?php }?>
                                       </h3>
                                    </div>
                                    <!--usr-mg-info end-->
                                    <!-- <a href="#" title=""><i class="fa fa-ellipsis-v"></i></a> -->
                                    @if(Auth::user()->id != $userSelectedId)
                                    <div class="dropdown msg-dropdown">
                                       <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <i class="fa fa-ellipsis-v"></i>
                                       </button>
                                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                                          @if(!$isSelectedUserBlocked)
                                                <a class="dropdown-item block-contact" data-action="block" data-id="{{$userSelectedId}}" href="javascript:void(0)">{{ __('messages.BLOCK') }}</a>
                                          @endif
                                          @if($isSelectedUserBlocked)
                                                <a class="dropdown-item block-contact" data-action="unblock" data-id="{{$userSelectedId}}" href="javascript:void(0)">{{ __('messages.UN_BLOCK') }}</a>
                                          @endif
                                          <?php if(count($chatHitoryBtwnUsers) > 0){?>
                                          <a class="dropdown-item delete-contact" data-id="{{$userSelectedId}}" href="javascript:void(0)">{{ __('messages.DELETE_POST') }}</a>
                                       <?php }?>
                                       </div>
                                    </div>
                                    @endif

                                 </div>
                              </div>
                              <!--message-bar-head end-->
                              <div class="messages-line mCustomScrollbar max-height">
                              	<?php /*
                                 <div class="main-message-box">
                                    <div class="messg-usr-img">
                                       <img src="{{ asset('frontend/images/resources/m-img1.png')}}" alt="">
                                    </div>
                                    <!--messg-usr-img end-->
                                    <div class="message-dt">
                                       <div class="message-inner-dt img-bx">
                                          <img src="{{ asset('frontend/images/resources/mt-img1.png')}}" alt="">
                                          <img src="{{ asset('frontend/images/resources/mt-img2.png')}}" alt="">
                                          <img src="{{ asset('frontend/images/resources/mt-img3.png')}}" alt="">
                                       </div>
                                       <!--message-inner-dt end-->
                                       <span>Sat, Aug 23, 1:08 PM</span>
                                    </div>
                                    <!--message-dt end-->
                                 </div>
								*/ ?>
                      
								 @foreach($chatHitoryBtwnUsers as $key=>$chatRow)
                         <?php 
                         if($key > 0){
                           $previous = date('Y-m-d',strtotime($chatHitoryBtwnUsers[$key-1]->created_at));
                         }else{
                           $previous = date('Y-m-d',strtotime($chatHitoryBtwnUsers[$key]->created_at));
                         }
                         $current = date('Y-m-d',strtotime($chatHitoryBtwnUsers[$key]->created_at));
                         if($previous != $current){?>
                         <div class="day-div"> <h6><?php echo formatTimeString(strtotime($chatRow->created_at)); ?></h6> </div>
                         <?php }else if($key == 0){?>
                           <div class="day-div"> <h6><?php echo formatTimeString(strtotime($chatRow->created_at)); ?></h6> </div>
                         <?php }?>
								 		 @if($chatRow->user_from_id == $userId)
		                                 <!--main-message-box end by second user-->
                                       
		                                 <div class="main-message-box ta-right" id="remove_msg_{{$chatRow->id}}">
                                          @if($chatRow->attachments->count()<1)
                                          
		                                    <div class="message-dt">
		                                       <div class="message-inner-dt">
                                             <a href="javascript:void(0);" class="remove_msg"  data-id="{{$chatRow->id}}"><i class="las la-trash"></i></a>
		                                          <p>{{ $chatRow->message }}</p>
		                                       </div>
		                                      
		                                       <span>{{date('H:i A',strtotime($chatRow->created_at))}}</span>
		                                    </div>
                                          @endif

		                                    <!--message-dt end-->
		                                    <div class="messg-usr-img">
                                          @if(!empty($userProfInfo['profileImage']))
                                             <img class="profile-image-src-menu" id="profile-image-src-menu" src="{{ asset($userProfInfo['profileImage']['location']) }}" alt="">
                                          @else
                                             <img class="profile-image-src-menu" id="profile-image-src-menu" src="{{ asset('frontend/images/user-pro-img-demo.png') }}" alt="">
                                          @endif
		                                    </div>
		                                    <!--messg-usr-img end-->
                                          @if($chatRow->attachments->count()>0)
                                          <!--messg-usr-img end-->
                                          
                                             <div class="message-dt">
                                               
                                                <div class="message-inner-dt img-bx">
                                                   @foreach($chatRow->attachments as $fileRow)
                                                      <!-- <a href="{{asset($fileRow->location)}}" download> -->
                                                      <div class="demofile-img-holder">
                                                         <!-- <img src="{{asset($fileRow->location)}}" alt="Attachment"> -->
                                                         <a href="javascript:void(0);" class="remove_msg"  data-id="{{$chatRow->id}}"><i class="las la-trash"></i></a>
                                                         <img class="demofile-img" src="{{ asset('frontend/images/document.png') }}" alt="Attachment">
                                                         <a href="{{url($user_type.'/download-message-file/'.$fileRow->name)}}" class="download-message-btn"><i class="las la-download"></i> </a>
                                                       </div>
                                                         <!-- </a> -->
                                                   @endforeach
                                                   <!-- <img src="images/resources/mt-img2.png" alt="">
                                                   <img src="images/resources/mt-img3.png" alt=""> -->
                                                </div>
                                               
                                                <!--message-inner-dt end-->
                                                <span>{{date('H:i A',strtotime($chatRow->created_at))}}</span>
                                             </div>
                                             <!--message-dt end-->
                                          @endif   
                                       </div>

                                       
		                                 <!--main-message-box end-->
		                                <!--  <div class="date-time-holder d-block text-center">
		                                    <div class="date-time-inner">23 Aug 2020 </div>
		                                 </div> -->
		                                 <!-- end msg by second person -->
		                                 @endif

		                                 @if($chatRow->user_from_id != $userId)
		                                 <!-- Message by current logged user -->
                                       
		                                 <div class="main-message-box st3">
		                                    <div class="message-dt st3">
                                             @if($chatRow->attachments->count()<1)
                                             
		                                       <div class="message-inner-dt">
		                                          <p>{{ $chatRow->message }}</p>
		                                       </div>
		                                       <!--message-inner-dt end-->
                                             <span>
                                             @if($userChatingInfo->user_type == 2)
                                                   {{ $userChatingInfo->first_name }} 
                                                @endif
                                                @if($userChatingInfo->user_type == 3)
                                                   {{ $userChatingInfo->company_name }} 
                                                @endif , {{date('H:i A',strtotime($chatRow->created_at))}}</span>
                                              @endif
		                                    </div>
		                                    <!--message-dt end-->
		                                    <div class="messg-usr-img">
                                          <?php if(($userChatingInfo->deleted_at != null) || ($userChatingInfo->status == 2) || ($userChatingInfo->status == 0) || ($userChatingInfo->isLogedInUserBlock)){?>
                                             <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                          <?php }else{?>
                                          @if($userChatingInfo->profileImage == null)
                                             <img src="{{ asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                          @endif
                                          
                                          @if($userChatingInfo->profileImage != null)
                                             <img src="{{ asset($userChatingInfo->profileImage->location)}}" alt="">
                                          @endif
                                          <?php }?>
		                                    </div>
		                                    <!--messg-usr-img end-->
                                          @if($chatRow->attachments->count()>0)
                                          <!--messg-usr-img end-->
                                             <div class="message-dt">
                                             
                                                <div class="message-inner-dt img-bx">
                                                   @foreach($chatRow->attachments as $fileRow)
                                                      <!-- <a href="{{asset($fileRow->location)}}" download> -->
                                                      <div class="demofile-img-holder">
                                                         <!-- <img src="{{asset($fileRow->location)}}" alt="Attachment"> -->
                                                         <img class="demofile-img" src="{{ asset('frontend/images/document.png') }}" alt="Attachment">
                                                         <a href="{{url($user_type.'/download-message-file/'.$fileRow->name)}}" class="download-message-btn"><i class="las la-download"></i> </a>
                                                       </div>
                                                         <!-- </a> -->
                                                   @endforeach
                                                   <!-- <img src="images/resources/mt-img2.png" alt="">
                                                   <img src="images/resources/mt-img3.png" alt=""> -->
                                                </div>
                                               
                                                <!--message-inner-dt end-->
                                                <span>
                                                @if($userChatingInfo->user_type == 2)
                                                   {{ $userChatingInfo->first_name }} 
                                                @endif
                                                @if($userChatingInfo->user_type == 3)
                                                   {{ $userChatingInfo->company_name }} 
                                                @endif , {{date('H:i A',strtotime($chatRow->created_at))}}</span>
                                             </div>
                                             <!--message-dt end-->
                                          @endif  
		                                 </div>
		                                 @endif

		                                 <!--main-message-box end by current user logged in-->
                                  @endforeach
                                 
                                
                                 <!--main-message-box end-->
                                 @if($chatHitoryBtwnUsers->isEmpty())
                                 <div class=""> 
                                    <div class="start-message-holder">
                                       <img src="{{asset('frontend/images/startmessage.jpg')}}" alt="">
                                       <h4> {{ __('messages.START_CHAT') }} </h4>
                                    </div>
                                 </div> 
                                 @endif

                              </div>

                              @if(Auth::user()->id != $userSelectedId)
                              <!--messages-line end-->                             
                              <div class="message-send-area">
                                 <form autocomplete="off" id="msg-sender" method="post" action="{{url('store-message')}}/{{encrypt($userSelectedId)}}">
                                 	{{ csrf_field()}}
                                    <input accept="image/*" type="file" style="display: none;"  name="image" class="img-upload">
                              <input  type="file" style="display: none;"  name="fileupload" class="fileupload-upload">
                                    <!-- file uploading start-->
                                    <div style="display: none;" class="file-uploading message-send-form-holder media 
                                    " >                                                                                                                                       
                                             <div class="message-file-uploading">
                                             {{ __('messages.FILE_UPLOADING') }}... <img src="{{asset('frontend/images/pdf-img.pdf')}}" alt="">
                                             </div>
                                             
                                    </div>
                                    <!-- file uploading end-->
                                    <?php if(Auth::user()->status == 2){
                                       $disable='disabled';
                                    }
                                    else if(($userChatingInfo->deleted_at != null) || ($userChatingInfo->status == 2) || ($userChatingInfo->status == 0)){
                                         $disable='disabled';
                                        }else if($isSelectedUserBlocked){
                                          $disable='disabled';
                                          }else{
                                             $disable='';
                                          }?>
                                    <div class="message-send-form-holder media">
                                       <div class="message-send-input-box media-body">
                                          <input type="text" class="form-control" id="message" name="message" placeholder="{{ __('messages.TYPE_A_MESSAGE_HERE') }}" <?php echo $disable;?>>
                                          <!-- <a class="smile-icon" href="#" title=""><i class="fa fa-smile-o"></i></a> -->
                                          <ul class="attach-camera-icon">
                                             <!-- <li><a href="javascript:void(0)" title="" class="msg-icon img-upload-message"><i class="fa fa-camera"></i></a></li> -->
                                             <li><a href="javascript:void(0)" title="" class="msg-icon file-upload-message"><i class="fa fa-paperclip"></i></a></li>
                                          </ul>
                                       </div>
                                       
                                       <button type="submit" class="msg-send" <?php echo $disable;?>><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                    </div>
                                 </form>
                                 
                              </div>
                              <!--message-send-area end-->
                              @endif 

                           </div>
                           <!--main-conversation-box end-->
                        </div>
                     </div>
                  </div>
               </section>
               <!--messages-page end-->
            </main>
            <!-- main End -->
<script>
   
   $(document).ready(function() {
     
      $(".messages-line").mCustomScrollbar({
         callbacks:{
            onScrollStart:function(){
               window.scrollTo(0,document.body.scrollHeight)
            }
         }
      }).mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
      
   });
</script>
@endsection

