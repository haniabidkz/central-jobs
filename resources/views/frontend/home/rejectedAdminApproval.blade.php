<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>MyHR</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.ico') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/line-awesome.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jquery.mCustomScrollbar.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap-datetimepicker.min.css') }}"  >      
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/tagsinput.css') }}" > 
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/swiper.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive.css') }}">

      <script type="text/javascript"> const _BASE_URL = '{{ url("/") }}'</script>
       <!-- main-page -->
      <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/popper.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/moment.min.js') }}" type="text/javascript"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/tagsinput.js') }}"></script> 
      <script type="text/javascript" src="{{ asset('frontend/js/dropzone.min.js') }}"></script>      
      <script type="text/javascript" src="{{ asset('frontend/js/jquery.easing.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/BsMultiSelect.js') }}"></script>     
      <script type="text/javascript" src="{{ asset('frontend/js/swiper.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
   </head>
   <body>
      <div class="sign-in">
         <div class="container">
            <div class="sign-in-page">
               <div class="signin-popup">
                  <div class="signin-pop">
                     <div class="row">
                        <div class="col-md-12 col-12">
                           <div class="success-message-holder text-center admin-block-section">
                              <div class="w-100 d-block">
                                 <div class="success-icon mx-auto mb-4"> 
                                    <img src="{{ asset('frontend/images/warning-icon.png')}}" alt="warning-icon" class="img-fluid">
                                 </div>
                              </div>
                              <h2 class="title mb-4">{{ __('messages.YOUR_ACCOUNT_COULD_NOT_BE_VALIDATED') }} </h2>
                              <div class="my-3">   
                                 <!----<a href="{{ route('logout') }}" class="site-btn-color btn" onclick="event.preventDefault();
                                                                       document.getElementById('logout-form').submit();"> Verify Your Indentity</a>
                                                                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>-->
                              </div>
                              <!-- <h3 class="sub-title">Welcome to My Hr portal! </h3> -->
                              <div class="row mt-5">
                                 <div class="col-12 col-lg-12 text-left">
                                    <h4>{{ __('messages.WHY_DID_THIS_HAPPEN') }} </h4>
                                    <p>{{ __('messages.BEFORE_WE_VALIDATE_YOUR_ACCOUNT') }}</p>
                                    <p>{{ __('messages.INCASE_YOUR_ACCOUNT_HAS_NOT_VALIDATED_YET') }}</p>
                                 </div>
                                 <div class="col-12 col-lg-12 text-left">
                                    <h4>{{ __('messages.WHAT_SHOULD_I_DO_NOW') }} </h4>
                                    <p>{{ __('messages.AS_SOON_AS_YOU_SEND_US_THE_INFORMATION_MISSING') }}</p>
                                    <p>{{ __('messages.INCASE_YOU_DIDNOT_RECEIVE_OUR_PREVIOUS_EMAIL') }}</p>
                                 </div>
                              </div>
                              <div class="row mt-3">
                                 <div class="col-12 col-lg-12 text-left">
                                    <p class="visit-text mb-0">{{ __('messages.THANK_YOU') }}, </p>
                                    <p class="visit-text mb-0">{{ __('messages.MEURH_TEAM') }} </p>
                                    <p class="visit-text mb-0">{{ __('messages.IF_NECESSARY_YOU_CAN_ALSO_SEND_EMAIL') }}: <a href="javascript:void(0);">{{env('SUPPORT_EMAIL_ID')}}</a> </p>
                                    <p class="visit-text mb-0">{{ __('messages.THANKS') }}! </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--signin-pop end-->
               </div>
               <!--signin-popup end-->
            </div>
            <!--sign-in-page end-->
         </div>
         <!--theme-layout end-->
      </div>
      
   </body>
</html>

