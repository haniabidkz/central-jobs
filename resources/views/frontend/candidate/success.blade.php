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
      <div class="sign-in sign-in-full">
         <div class="container">
            <div class="sign-in-page">
               <div class="signin-popup">
                  <div class="signin-pop">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="success-message-holder text-center">
                              <div class="w-100 d-block">
                                 <div class="success-icon mx-auto mb-4"> 
                                    <img src="{{ asset('frontend/images/success-icon.png')}}" alt="success" class="img-fluid">
                                 </div>
                              </div>
                              <h2 class="title mb-4">{{ __('messages.CONGRATULATION') }} </h2>
                              <h3 class="sub-title">{{ __('messages.WELCOME_TO_MYHR_PORTAL') }} </h3>
                              <h4>{{ __('messages.WE_WILL_HELP_YOU_BUILD_YOUR_FUTURE') }}</h4>
                              <p>{{ __('messages.WELCOME_PAGE_TEXT') }}</p>
                              <h6> {{ __('messages.CLICK') }} <a href="{{url('home')}}"> {{ __('messages.HERE') }}</a> {{ __('messages.TO_START_LOOKING_FOR_YOUR_NEW_JOB') }} </h6>
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

