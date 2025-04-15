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
                           <div class="success-message-holder text-center email-verification-section">
                              <div class="w-100 d-block">
                                 <div class="success-icon mx-auto mb-4"> 
                                    <img src="{{ asset('frontend/images/email.svg') }}" alt="warning-icon" class="img-fluid">
                                 </div>
                              </div>
                              <h2 class="title mb-2">{{ __('messages.EMAIL_VERIFICATION_PENDING') }} </h2>
                              
                              <!-- <h3 class="sub-title">Welcome to My Hr portal! </h3> -->
                              <div class="row mt-4">
                                 <div class="col-12 col-lg-12">
                                    <p>{{ __('messages.AN_EMAIL_HAS_ALREADY_BEEN_SEND_TO_YOUR_EMAIL_ID') }} "<a href="" class="email-link">{{base64_decode(Request::segment(2))}}</a>" {{ __('messages.FOR_VERIFICATION') }} </p>
                                    <p>{{ __('messages.IF_YOU_HAVE_NOT_RECEIVED_VARIFICATION_EMAIL') }} </p>
                                    <div class="my-3">   
                                       <a href="{{ url('resend-email/'.Request::segment(2)) }}" class="site-btn-color btn"> {{ __('messages.RESEND_EMAIL') }}</a>
                                    </div> 
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

