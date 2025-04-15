<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>MyHR</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}"> 
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/line-awesome.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jquery.mCustomScrollbar.min.css') }}" >
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap-datetimepicker.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive.css') }}">
   </head>
   <body>
      <!-- main-page-start -->
      <div class="main-page">
         <nav id="sidebar" class="sidebar-nav login-header">
            <div id="dismiss">
               <i class="la la-close"></i>
            </div>
            <div class="sidebar-header">
               <a class="d-block" href="index.html"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="Logo" class="img-fluid"></a>
            </div>
            <!-- after login -->  
            <div class="profile-head">
               <div class="profile-pic"><img src="{{ asset('frontend/images/resources/user.png') }}" alt=""></div>
               <h4>Hello!</h4>
               <h4>Christina Fitzgerald</h4>
            </div>

            <ul class="nav navbar-nav">
               <li class="nav-item dropdown dashboard-nav-item">
                  <a class="nav-link" href="network.html">  My Profile  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a href="manageprofile.html">Manage Profile </a></li>
                     <li><a href="view-follower.html">View Follower</a></li>
                     <li><a href="settings.html">Alert Settings</a></li>
                  </ul>
               </li>
               <li class="nav-item dashboard-nav-item">
                  <a class="nav-link" href="dashboard.html">Dashboard</a>
               </li>
               <li class="nav-item dropdown dashboard-nav-item">
                  <a class="nav-link" href="network.html">  Network </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="searchprofile.html">Search Profile </a>
                     <a class="dropdown-item" href="my-network.html">My Network</a>
                  </ul>
               </li>
               <li class="nav-item dashboard-nav-item">
                  <a class="nav-link" href="candidate.html">Candidate</a>
               </li>
               <li class="nav-item dropdown dashboard-nav-item">
                  <a class="nav-link" href="job.html">Jobs</a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a class="dropdown-item" href="my-job.html">My Jobs </a></li>
                     <li><a class="dropdown-item" href="track-job.html">Track Jobs </a></li>
                  </ul>
               </li>
               <li class="nav-item dashboard-nav-item">
                  <a class="nav-link" href="messages.html">Messages</a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="about.html">About Us</a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="service.html">Services </a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="training.html">Training</a>
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
                     <a class="navbar-brand" href="index.html"><img src="{{ asset('frontend/images/logo-color2.png') }}" alt="Logo" class="img-fluid"></a>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav mr-auto">
                           <li class="nav-item dashboard-nav-item">
                              <a class="nav-link" href="dashboard.html">Dashboard</a>
                           </li>
                           <li class="nav-item dropdown dashboard-nav-item">
                              <a class="nav-link" href="network.html">  Network </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a class="dropdown-item" href="searchprofile.html">Search Profile </a></li>
                                 <li><a class="dropdown-item" href="my-network.html">My Network</a>
                              </ul>
                           </li>
                           <li class="nav-item dashboard-nav-item">
                              <a class="nav-link" href="candidate.html">Candidate</a>
                           </li>
                           <li class="nav-item dropdown dashboard-nav-item">
                              <a class="nav-link" href="job.html">Jobs</a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <li><a class="dropdown-item" href="my-job.html">My Jobs </a></li>
                                 <li><a class="dropdown-item" href="track-job.html">Track Jobs </a></li>
                              </ul>
                           </li>
                           <li class="nav-item dashboard-nav-item">
                              <a class="nav-link" href="messages.html">Messages</a>
                           </li>
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="about.html">About Us</a>
                           </li>
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="service.html">Services </a>
                           </li>
                           <li class="nav-item all-nav">
                              <a class="nav-link" href="training.html">Training</a>
                           </li>
                        </ul>
                     </div>
                     <div class="right-nav-box">
                        <div class="notifica dashboard-nav-item">
                           <a href="#" title="" class="not-box-openm">
                           <span class="noti"><img src="{{ asset('frontend/images/ic-notification.png') }}" class="img-fluid"> <span></span></span>
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
                        <div class="dropdown language-list">
                           <a class="dropdown-toggle" href="forgot-password.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           En
                           </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#">Sp</a>
                              <a class="dropdown-item" href="#">Pt</a>
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
                              <a class="login-btn" href="sign-in.html">Login</a>
                           </li>
                           <li>
                              <a class="signup-btn" href="sign-in.html">Join Us</a>
                           </li>
                        </ul>
                        <button type="button" id="sidebarCollapse" class="btn btn-info d-block d-lg-none">
                        <img src="{{ asset('frontend/images/ic-burger-menu.svg') }}" alt="burger-menu" class="img-fluid">
                        </button>
                     </div>
                  </div>
               </nav>
            </header>
            <!-- header End-->
            <div class="header-gap"></div>
            <!-- main -->
            <main>
               <div class="sign-in">
		         <div class="container">
		            <div class="sign-in-page">
		               <div class="signin-popup">
		                  <div class="signin-pop">
		                     <div class="row">
		                        <div class="col-md-6 col-12 right-border-sign">
		                           <div class="cmp-info">
		                              <div class="cm-logo">
		                                 <a href="index.html"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="" class="img-fluid"></a>
		                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
		                              </div>
		                              <!--cm-logo end-->	
		                              <img src="{{ asset('frontend/images/ResetPassword-person.jpg') }}" alt=""  class="img-fluid">			
		                           </div>
		                           <!--cmp-info end-->
		                        </div>
		                        <div class="col-md-6 col-12">
		                           <div class="login-sec">
		                              <ul class="sign-control">
		                                 <li data-tab="tab-1" class="current"><a href="#" title="">Sign in</a></li>
		                                 <li data-tab="tab-2"><a href="#" title="">Sign up</a></li>
		                              </ul>
		                              <div class="sign_in_sec current" id="tab-1">
		                                 <!-- Tab panes -->
	                                    <div class="mt-md-5 pt-md-5">
	                                       <!-- <h3>Sign in</h3> -->
	                                       <form>
	                                          <div class="row">
	                                             <div class="col-12">
	                                                <div class="sn-field">
	                                                   <input type="text" name="username" placeholder="Username">
	                                                   <i class="la la-user"></i>
	                                                </div>
	                                             </div>
	                                             <div class="col-12">
	                                                <div class="sn-field  password-holder">
	                                                   <input type="password" name="password" placeholder="Password">
	                                                   <i class="la la-lock"></i>
	                                                   <button class="eye_showHide" type="button"> <img src="{{ asset('frontend/images/ic-show-password.png') }}" alt=""> </button>
	                                                </div>
	                                             </div>
	                                             <div class="col-6 col-sm-6">
	                                                <label class="check-style">Remember Me
	                                                <input type="checkbox">
	                                                <span class="checkmark"></span>
	                                                </label>
	                                             </div>
	                                             <div class="col-6 col-sm-6 text-right">
	                                                <p class="forgot-password"><a href="forgot-password.html"> Forgot Password? </a> </p>
	                                             </div>
	                                             <div class="col-12 mt-4">
	                                                <button class="submit-btn" type="submit" value="submit">Sign in</button>
	                                             </div>
	                                          </div>
	                                       </form>
	                                       <!-- <div class="login-resources">
	                                          <h4>Sign In with</h4>
	                                          <ul>
	                                             <li><a href="#" title="" class="fb"><i class="fa fa-facebook"></i>Facebook</a></li>
	                                             <li><a href="#" title="" class="google"><i class="fa fa-google"></i>Google</a></li>
	                                          </ul>
	                                       </div> -->
	                                       <!--login-resources end-->
	                                    </div>
		                              </div>
		                              <!--sign_in_sec end-->
		                              <div class="sign_in_sec" id="tab-2">
		                                 <ul class="signin-tab nav nav-tabs" id="myTab2" role="tablist">
		                                    <li class="nav-item">
		                                       <a class="nav-link active" id="tab-5-tab" data-toggle="tab" href="#tab-5" role="tab" aria-controls="tab-5" aria-selected="true"><i class="fa fa-user" aria-hidden="true"></i>Candidate</a>
		                                    </li>
		                                    <li class="nav-item">
		                                       <a class="nav-link" id="tab-6-tab" data-toggle="tab" href="#tab-6" role="tab" aria-controls="#tab-6" aria-selected="false"><i class="fa fa-user" aria-hidden="true"></i>Employer</a>
		                                    </li>
		                                 </ul>
		                                 <div class="tab-content">
		                                    <div class="dff-tab tab-pane active" id="tab-5" role="tabpanel" aria-labelledby="tab-5-tab">
		                                       <form>
		                                          <div class="row">
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="text" name="name" placeholder="Full Name">
		                                                   <i class="la la-user"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="email" name="email" placeholder="Email">
		                                                   <i class="la la-envelope"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field password-holder">
		                                                   <input type="password" name="password" placeholder="Password">
		                                                   <i class="la la-lock"></i>
		                                                   <button class="eye_showHide" type="button"> <img src="{{ asset('frontend/images/ic-show-password.png') }}" alt=""></button>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field password-holder">
		                                                   <input type="password" name="repeat-password" placeholder="Re-enter Password">
		                                                   <i class="la la-lock"></i>
		                                                   <button class="eye_showHide" type="button"> <img src="{{ asset('frontend/images/ic-show-password.png') }}" alt=""></button>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <label class="check-style">Yes, I understand and agree to the workwise Terms & Conditions.
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                                </label>
		                                             </div>
		                                             <div class="col-12 mt-4">
		                                                <button type="submit" class="submit-btn" value="submit">Sign Up </button>
		                                             </div>
		                                          </div>
		                                       </form>
		                                       <div class="login-resources">
		                                          <h4>Sign In with</h4>
		                                          <ul>
		                                             <li><a href="#" title="" class="fb"><i class="fa fa-facebook"></i>Facebook</a></li>
		                                             <li><a href="#" title="" class="google"><i class="fa fa-google"></i>Google</a></li>
		                                          </ul>
		                                       </div>
		                                    </div>
		                                    <!--dff-tab end-->
		                                    <div class="tab-pane" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
		                                       <form>
		                                          <div class="row">
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="text" name="contact-name" placeholder="Contact Name">
		                                                   <i class="la la-user"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="text" name="contact-no" placeholder="Contact No">
		                                                   <i class="la la-phone"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="text" name="company-name" placeholder="Company Name">
		                                                   <i class="la la-building"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="email" name="email" placeholder="Company Email">
		                                                   <i class="la la-envelope"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field">
		                                                   <input type="password" name="password" placeholder="Password">
		                                                   <i class="la la-lock"></i>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <div class="sn-field password-holder">
		                                                   <input type="password" name="repeat-password" placeholder="Re-enter Password">
		                                                   <i class="la la-lock"></i>
		                                                   <button class="eye_showHide" type="button"> <img src="{{ asset('frontend/images/ic-show-password.png') }}" alt=""></button>
		                                                </div>
		                                             </div>
		                                             <div class="col-12">
		                                                <label class="check-style">Yes, I understand and agree to the workwise Terms & Conditions.
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                                </label>
		                                             </div>
		                                             <div class="col-12 mt-4">
		                                                <button class="submit-btn" type="submit" value="submit">Sign Up </button>
		                                             </div>
		                                          </div>
		                                       </form>
		                                    </div>
		                                    <!--dff-tab end-->
		                                 </div>
		                              </div>
		                           </div>
		                           <!--login-sec end-->
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
            </main>
            <!-- main End -->
    <!-- include footer -->
    @include('frontend.includes.footer_before_login')
    <!-- include footer -->
