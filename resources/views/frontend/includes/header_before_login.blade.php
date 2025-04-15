<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" locale="{{ Cookie::get('locale') }}">
   <head>
      <meta charset="UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Central Jobs</title> 
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.ico') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/line-awesome.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jquery.mCustomScrollbar.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap-datetimepicker.min.css') }}"  >      
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/tagsinput.css') }}" > 
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/swiper.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive.css') }}">

      <script type="text/javascript"> const _BASE_URL = '{{ url("/") }}'</script>
      @php $allmsg = __('messages');
      foreach($allmsg as $key=>$value){
         $allmsg[$key] = str_replace("'",'|',$value);
      }

      

      $allmsg = json_encode($allmsg);

      @endphp
      <script type="text/javascript"> 
      
      var allMsgText = '{!! $allmsg !!}';
      allMsgText =  JSON.parse(allMsgText);
     
      </script>
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
      <script type="text/javascript" src="{{ asset('js/commonFunctions.js') }}?r=22042022"></script>
      <script type="text/javascript" src="{{ asset('js/commonScreeningFunctions.js') }}"></script>
      
      
   </head>
   <body>
      <!-- main-page-start -->
      <div class="main-page">
         <nav id="sidebar" class="sidebar-nav sidebar-login-header">
            <div id="dismiss">
               <i class="la la-close"></i>
            </div>
            <div class="sidebar-header">
               <a class="d-block" href="index.html"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="Logo" class="img-fluid"></a>
            </div>
            <div class="profile-head">
               <div class="profile-pic"><img src="{{ asset('frontend/images/resources/user.png') }}" alt=""></div>
            </div>
            <ul class="nav navbar-nav">
               <li class="nav-item dropdown dashboard-nav-item">
                  <a class="nav-link" href="network.html">  My Profile  </a>
                  <ul class="dropdown-menu">
                     <li><a href="manageprofile.html">Manage Profile </a></li>
                     <li><a href="view-follower.html">View Follower</a></li>
                     <li><a href="settings.html">Alert Settings</a></li>
                  </ul>
               </li>
               <li class="nav-item dashboard-nav-item">
                  <a class="nav-link" href="{{url('dashboard')}}">Dashboard</a>
               </li>
               <li class="nav-item dropdown dashboard-nav-item">
                  <a class="nav-link" href="javascript:void(0)">  Network </a>
                  <ul class="dropdown-menu">
                    <li> <a class="dropdown-item" href="searchprofile.html">Search Profile </a> </li>
                    <li> <a class="dropdown-item" href="my-network.html">My Network</a> </li>
                  </ul>
               </li>
               <li class="nav-item dashboard-nav-item">
                  <a class="nav-link" href="candidate.html">Candidate</a>
               </li>
               <li class="nav-item job-item dropdown dashboard-nav-item">
                  <a class="nav-link" href="javascript:void(0)">Jobs</a>
                  <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="my-job.html">My Jobs </a></li>
                     <li><a class="dropdown-item" href="track-job.html">Track Jobs </a></li>
                  </ul>
               </li>
               <li class="nav-item dashboard-nav-item">
                  <a class="nav-link" href="messages.html">Messages</a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="{{url('candidate/dashboard')}}">{{ __('messages.DASHBOARD') }}</a>
               </li>
               <li class="nav-item dropdown all-nav">
               <a class="nav-link" href="javascript:void(0)">  {{ __('messages.NETWORK') }} </a>
               <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{url('candidate/search-profile')}}">{{ __('messages.SEARCH_PROFILE') }} </a></li>
                  <li><a class="dropdown-item" href="{{url('candidate/my-network')}}">{{ __('messages.MY_NETWORK') }}</a></li>
                  <li><a class="dropdown-item" href="{{url('candidate/message')}}/{{encrypt(0)}}">{{ __('messages.MESSAGES') }}</a></li>
               </ul>
               </li>
               <li class="nav-item job-item dropdown all-nav">
               <a class="nav-link" href="javascript:void(0)">{{ __('messages.JOBS_CAPS') }}</a>
               <ul class="dropdown-menu"> 
               <li><a class="dropdown-item" href="{{ url('candidate/my-jobs') }}">{{ __('messages.MY_JOBS') }} </a></li>
               <li><a class="dropdown-item" href="{{ url('candidate/track-job') }}">{{ __('messages.TRACK_JOBS') }} </a></li>
               </ul>
               </li>
              
               <li class="nav-item all-nav">
                  <a class="nav-link" href="{{url('about-us')}}">{{ __('messages.ABOUT_US') }}</a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="{{url('service')}}">{{ __('messages.SERVICES') }} </a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="{{url('training-category-list')}}">{{ __('messages.TRAINING') }}</a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="{{url('tips')}}">{{ __('messages.TIPS') }}</a>
               </li>
               <li class="nav-item all-nav d-xl-none d-lg-none d-md-none d-sm-block d-block">
                  <a class="nav-link" href="{{url('joinus')}}">{{ __('messages.EMPLOYER_SIGNUP') }}</a>
               </li>
            </ul>
            <ul class="nav login-signup-btnlist">
               <li>
                  <a class="login-btn" href="login.html">Login</a>
               </li>
               <li>
                  <a class="signup-btn" href="signup.html">Join Us</a>
               </li>
            </ul>
         </nav>
         <div class="main-container">
            <!-- header -->
            <header class="header fixed-top login-header" id="header">
               <nav class="navbar navbar-expand-lg navbar-light">
                  <div class="container">
                     <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('frontend/images/logo-color2.png') }}" alt="Logo" class="img-fluid"></a>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav mr-auto">
                           <li class="nav-item dashboard-nav-item">
                              <a class="nav-link" href="dashboard.html">Dashboard</a>
                           </li>
                           <li class="nav-item dropdown dashboard-nav-item">
                              <a class="nav-link" href="javascript:void(0)">  Network </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="searchprofile.html">Search Profile </a></li>
                                 <li><a class="dropdown-item" href="my-network.html">My Network</a>
                              </ul>
                           </li>
                           <li class="nav-item dashboard-nav-item">
                              <a class="nav-link" href="candidate.html">Candidate</a>
                           </li>
                           <li class="nav-item  dropdown dashboard-nav-item">
                              <a class="nav-link" href="javascript:void(0)">Jobs</a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="my-job.html">My Jobs </a></li>
                                 <li><a class="dropdown-item" href="track-job.html">Track Jobs </a></li>
                              </ul>
                           </li>
                           <li class="nav-item dashboard-nav-item">
                              <a class="nav-link" href="messages.html">Messages</a>
                           </li>
                           <!-- <li class="nav-item all-nav">
                              <a class="nav-link" href="{{url('candidate/dashboard')}}">{{ __('messages.DASHBOARD') }}</a>
                           </li>
                           <li class="nav-item dropdown all-nav">
                           <a class="nav-link" href="javascript:void(0)">  {{ __('messages.NETWORK') }} </a>
                           <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{url('candidate/search-profile')}}">{{ __('messages.SEARCH_PROFILE') }} </a></li>
                              <li><a class="dropdown-item" href="{{url('candidate/my-network')}}">{{ __('messages.MY_NETWORK') }}</a></li>
                              <li><a class="dropdown-item" href="{{url('candidate/message')}}/{{encrypt(0)}}">{{ __('messages.MESSAGES') }}</a></li>
                           </ul>
                           </li> -->
                           <li class="nav-item job-item dropdown all-nav">
                           <a class="nav-link" href="javascript:void(0)">{{ __('messages.JOBS_CAPS') }}</a>
                           <ul class="dropdown-menu"> 
                           <li><a class="dropdown-item" href="{{ url('candidate/my-jobs') }}">{{ __('messages.MY_JOBS') }} </a></li>
                           <li><a class="dropdown-item" href="{{ url('candidate/track-job') }}">{{ __('messages.TRACK_JOBS') }} </a></li>
                           </ul>
                           </li>
                           
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="{{url('about-us')}}">{{ __('messages.ABOUT_US') }}</a>
                           </li>
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="{{url('service')}}">{{ __('messages.SERVICES') }} </a>
                           </li>
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="{{url('training-category-list')}}">{{ __('messages.TRAINING') }}</a>
                           </li>
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="{{url('tips')}}">{{ __('messages.TIPS') }}</a>
                           </li>
                        </ul>
                     </div>
                     <div class="right-nav-box">
                        <div class="notifica dashboard-nav-item">
                           <a href="#" title="" class="not-box-openm">
                           <span class="noti"> <img src="{{ asset('frontend/images/ic-notification.png') }}" alt="notification" class="img-fluid"> <span></span> </span>
                           </a>
                           <div class="notification-box msg" id="message">
                              <div class="nt-title">
                                 <h4>Setting</h4>
                                 <a href="#" title="">Clear all</a>
                              </div>
                              <div class="nott-list">
                                 <div class="notfication-details">
                                    <div class="media">
                                       <div class="noty-user-img">
                                          <img src="{{ asset('frontend/images/resources/ny-img1.png') }}" alt="">
                                       </div>
                                       <div class="media-body">
                                          <h3><a href="messages.html" title="">Jassica William</a> <span>2 min ago</span></h3>
                                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="notfication-details">
                                    <div class="media">
                                       <div class="noty-user-img">
                                          <img src="{{ asset('frontend/images/resources/ny-img1.png') }}" alt="">
                                       </div>
                                       <div class="media-body">
                                          <h3><a href="messages.html" title="">Jassica William</a> <span>2 min ago</span></h3>
                                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="notfication-details">
                                    <div class="media">
                                       <div class="noty-user-img">
                                          <img src="{{ asset('frontend/images/resources/ny-img1.png') }}" alt="">
                                       </div>
                                       <div class="media-body">
                                          <h3><a href="messages.html" title="">Jassica William</a> <span>2 min ago</span></h3>
                                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="view-all-nots">
                                    <a href="messages.html" class="btn site-btn" title="">View All Messsages</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                       
                        <a class="signup-btn d-xl-block d-lg-block d-md-block d-sm-none d-none" href="{{url('joinus')}}">
                           {{ __('messages.EMPLOYER_SIGNUP') }}
                        </a>
                        
                        <div class="dropdown language-list">
                           <a class="dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           @if(Cookie::get('locale') == 'en')En @elseif(Cookie::get('locale') == 'fr')Fr @elseif(Cookie::get('locale') == 'ge' || Cookie::get('locale') == '')Ge @elseif(Cookie::get('locale') == 'pt' )Pt @endif
                           </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item change-lang-" href="{{ url('locale/en') }}" data-id="1" style = "@if(Cookie::get('locale') == 'en') display:none; @endif">En</a>   
                            <a class="dropdown-item change-lang-" href="{{ url('locale/fr') }}" data-id="2" style = "@if(Cookie::get('locale') == 'fr') display:none; @endif">Fr</a> 
                              <a class="dropdown-item change-lang-" href="{{ url('locale/pt') }}" data-id="3" style = "@if(Cookie::get('locale') == 'pt' || Cookie::get('locale') == '') display:none; @endif">Pt</a>
                           </div> 
                        </div>
                        <div class="user-account dashboard-nav-item">
                           <div class="user-info">
                              <img src="{{ asset('frontend/images/user.png') }}" alt="">
                              <i class="fa fa-caret-down"></i>
                           </div>
                           <div class="user-account-settingss">
                              <ul class="us-links">
                                 <li><a href="myprofile.html">My Profile </a></li>
                                 <li><a href="manageprofile.html">Manage Profile </a></li>
                                 <li><a href="view-follower.html">View Follower</a></li>
                                 <li><a href="settings.html">Alert Settings</a></li>
                              </ul>
                           </div>
                        </div>
                        <ul class="nav login-signup-btnlist">
                           <li>
                              <a class="login-btn" href="{{ route('candidate.login') }}">{{ __('messages.SIGN_IN') }}</a>
                           </li>
                           <!-- <li>
                              <a class="signup-btn" href="sign-in.html">Join Us</a>
                           </li>-->
                        </ul>
                        <button type="button" id="sidebarCollapse" class="btn btn-info d-block d-lg-none">
                        <img src=" {{ asset('frontend/images/ic-burger-menu.svg') }}" alt="burger-menu" class="img-fluid">
                        </button>
                     </div>
                  </div>
               </nav>
            </header>
            <!-- header End-->
            <div class="header-gap"></div>

            <!-- success message section add "success-block" to show class -->
            <section class="alert-holder-error" >
               <div class="container">
                  <div class="alert-holder-errmsg"> Error </div>  
               </div>
            </section>
            <!-- End success message section -->
            <?php if(Session::has('error-msg')){ $message = Session::get('error-msg');?>
               <script type="text/javascript">
                  let msgBoxTempFlush = $(".alert-holder-error");
                  let msgToDisplay = '<?=$message?>';
                  msgBoxTempFlush.addClass('error-block');
                  msgBoxTempFlush.find('.alert-holder-errmsg').html(msgToDisplay);
                  setTimeout(function(){ msgBoxTempFlush.removeClass('error-block')},8000);
               </script>
            <?php } ?>

            <!-- success message section add "success-block" to show class -->
            <section class="alert-holder-success" >
               <div class="container">
                  <div class="alert-holder"> Success </div>  
               </div>
            </section>
            <!-- End success message section -->
            <?php if(Session::has('success-msg')){ $message = Session::get('success-msg');?>
               <script type="text/javascript">
                  let msgBoxTempFlush = $(".alert-holder-success");
                  let msgToDisplay = '<?=$message?>';
                  msgBoxTempFlush.addClass('success-block');
                  msgBoxTempFlush.find('.alert-holder').html(msgToDisplay);
                  setTimeout(function(){ msgBoxTempFlush.removeClass('success-block')},8000);
               </script>
            <?php } ?>
