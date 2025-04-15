<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" locale="<?php echo e(Cookie::get('locale')); ?>">
   <head>
      <meta charset="UTF-8">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <title>Central Jobs</title> 
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <link rel="icon" type="image/png" href="<?php echo e(asset('frontend/images/favicon.ico')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/animate.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>">
      <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/line-awesome.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/font-awesome.min.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/jquery.mCustomScrollbar.min.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/bootstrap-datetimepicker.min.css')); ?>"  >      
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/tagsinput.css')); ?>" > 
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/swiper.min.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/select2.min.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/style.css')); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/responsive.css')); ?>">
      <script type="text/javascript"> const _BASE_URL = '<?php echo e(url("/")); ?>'</script>
      <?php $allmsg = __('messages');
      foreach($allmsg as $key=>$value){
         $allmsg[$key] = str_replace("'",'|',$value);
      }
      $allmsg = json_encode($allmsg);

      ?>
      <script type="text/javascript"> 
      
      var allMsgText = '<?php echo $allmsg; ?>';
      allMsgText =  JSON.parse(allMsgText);
      
     
      </script>
       <!-- main-page -->
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/popper.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/moment.min.js')); ?>" type="text/javascript"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/bootstrap-datetimepicker.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/tagsinput.js')); ?>"></script> 
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/dropzone.min.js')); ?>"></script>      
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.easing.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/BsMultiSelect.js')); ?>"></script>     
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/swiper.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.validate.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('frontend/js/select2.min.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('js/commonFunctions.js')); ?>"></script>
      <script type="text/javascript" src="<?php echo e(asset('js/commonScreeningFunctions.js')); ?>"></script>
      <?php if(Auth::check()): ?>
      <input type="hidden" name="user" id="user" value="<?php echo e(auth()->user()->user_type); ?>"/>
      <input type="hidden" name="chkrpt" id="chkrpt" value="<?php echo e(auth()->user()->id); ?>"/>
      <?php endif; ?>
     
   </head>
   <body>
   <?php  
      $url = explode('@',Route::currentRouteAction());
      $controllerStrng = $url[0];
      $controllerStrng = str_replace("\\","/","$controllerStrng");
      $controllerArr = explode('/',$controllerStrng);
      $controller = end($controllerArr);
      $action = $url[1];
      //echo $action; exit;
   ?>
       <!-- main-page-start -->
      <div class="main-page">
        <nav id="sidebar" class="sidebar-nav dash-sidenav">
            <div id="dismiss">
               <i class="la la-close"></i>
            </div>
            <div class="sidebar-header">
               <a class="d-block" href="index.html"><img src="<?php echo e(asset('/frontend/images/logo-color.png')); ?>" alt="Logo" class="img-fluid"></a>
            </div>
            <?php if(auth()->user()): ?>
            <div class="profile-head">
               <div class="profile-pic">
                  <?php if(!empty($userProfInfo['profileImage'])): ?>
                     <img class="profile-image-src-menu" id="profile-image-src-menu" src="<?php echo e(asset($userProfInfo['profileImage']['location'])); ?>" alt="">
                  <?php else: ?>
                     <img class="profile-image-src-menu" id="profile-image-src-menu" src="<?php echo e(asset('frontend/images/user.png')); ?>" alt="">
                  <?php endif; ?>
               </div>   
                  
            </div>
            <?php endif; ?>
            <ul class="nav navbar-nav">
               <?php if(auth()->user()): ?>
               <li class="nav-item dropdown dashboard-nav-item"> 
                   
                  <a class="nav-link" href="javascript:void(0);">  <?php echo e(__('messages.MY_PROFILE')); ?>  </a>
                  <ul class="dropdown-menu">
                     <?php if((auth()->user()) && (auth()->user()->user_type == 2)): ?>
                        <!--<li><a href="<?php echo e(url('candidate/my-profile')); ?>"><?php echo e(__('messages.MY_PROFILE')); ?> </a></li> -->
                        <li><a href="<?php echo e(url('candidate/manage-profile')); ?>"><?php echo e(__('messages.DELETE_PROFILE')); ?> </a></li>
                        <li><a href="<?php echo e(url('candidate/view-followers')); ?>"><?php echo e(__('messages.VIEW_FOLLOWER')); ?></a></li> 
                        <li><a href="<?php echo e(url('candidate/job-alert-setting')); ?>"><?php echo e(__('messages.ALERT_SETTINGS')); ?></a></li>
                     <?php elseif((auth()->user()) && (auth()->user()->user_type == 3)): ?>
                        <li><a href="<?php echo e(url('company/my-profile')); ?>"><?php echo e(__('messages.MY_PROFILE')); ?> </a></li>
                        <li><a href="<?php echo e(url('company/manage-profile')); ?>"><?php echo e(__('messages.DELETE_PROFILE')); ?> </a></li>
                        <!-- <li><a href="<?php echo e(url('company/view-followers')); ?>"><?php echo e(__('messages.VIEW_FOLLOWER')); ?></a></li> -->
                     <?php endif; ?>
                     <li>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                           document.getElementById('logout-form').submit();">
                                              <?php echo e(__('messages.LOGOUT')); ?>

                        </a>
                     </li>
                  </ul>
               </li>
               <?php endif; ?>
               <?php if((auth()->user()) && (auth()->user()->user_type == 3)): ?>
               <!--<li class="nav-item dashboard-nav-item">
                  <a class="nav-link highligh-cls" href="<?php echo e(url('company/find-candidates')); ?>"><?php echo e(__('messages.CANDIDATE')); ?></a>
               </li>-->
               <?php endif; ?>
               <li class="nav-item job-item dropdown dashboard-nav-item">
                  
                  <?php if((auth()->user()) && (auth()->user()->user_type == 3)): ?>
                     <a class="nav-link" href="javascript:void(0)"><?php echo e(__('messages.JOBS')); ?></a>
                     <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="<?php echo e(url('company/my-jobs')); ?>"><?php echo e(__('messages.MY_JOBS')); ?> </a></li>
                     </ul>
                  <?php elseif((auth()->user()) && (auth()->user()->user_type == 2)): ?>
                     <a class="nav-link" href="javascript:void(0)"><?php echo e(__('messages.JOBS')); ?></a>
                     <ul class="dropdown-menu"> 
                     <li><a class="dropdown-item" href="<?php echo e(url('candidate/my-jobs')); ?>"><?php echo e(__('messages.MY_JOBS')); ?> </a></li>
                     <li><a class="dropdown-item" href="<?php echo e(url('candidate/track-job')); ?>"><?php echo e(__('messages.TRACK_JOBS')); ?> </a></li>
                     </ul>
                  <?php else: ?>
                     <a class="nav-link" href="javascript:void(0)"><?php echo e(__('messages.JOBS_CAPS')); ?></a>
                     <ul class="dropdown-menu"> 
                     <li><a class="dropdown-item" href="<?php echo e(url('candidate/my-jobs')); ?>"><?php echo e(__('messages.MY_JOBS')); ?> </a></li>
                     <li><a class="dropdown-item" href="<?php echo e(url('candidate/track-job')); ?>"><?php echo e(__('messages.TRACK_JOBS')); ?> </a></li>
                     </ul>
                  <?php endif; ?>
               </li>
                
               <li class="nav-item all-nav">
                  <a class="nav-link" href="<?php echo e(url('about-us')); ?>"><?php echo e(__('messages.ABOUT_US')); ?></a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="<?php echo e(url('service')); ?>"><?php echo e(__('messages.SERVICES')); ?> </a>
               </li>
               <li class="nav-item all-nav">
                  <a class="nav-link" href="<?php echo e(url('training-category-list')); ?>"><?php echo e(__('messages.TRAINING')); ?></a>
               </li>
               <li class="nav-item all-nav <?php if($action == 'tips'): ?>active <?php endif; ?>">
                  <a class="nav-link" href="<?php echo e(url('tips')); ?>"><?php echo e(__('messages.TIPS')); ?></a>
               </li>
               <li class="nav-item all-nav">
                  <?php if((auth()->user()) && (auth()->user()->user_type == 3)): ?>
                     
                  <?php else: ?>
                                      <?php endif; ?>
               </li>
               
               <?php if(!Auth::check()): ?>
               <li class="nav-item all-nav d-xl-none d-lg-none d-md-none d-sm-block d-block">
                     <a class="nav-link" href="<?php echo e(url('joinus')); ?>"><?php echo e(__('messages.EMPLOYER_SIGNUP')); ?></a>
               </li>
               <?php endif; ?>
            </ul>
            <ul class="nav login-signup-btnlist">
            <li>
               <a class="login-btn" href="<?php echo e(route('candidate.login')); ?>"><?php echo e(__('messages.LOGING')); ?></a>
            </li>
            <!-- <li>
               <a class="signup-btn" href="<?php echo e(url('joinus')); ?>"><?php echo e(__('messages.JOIN_US')); ?></a>
            </li> -->
            </ul>
        </nav>
        <div class="main-container">
            <!-- header -->
            <header class="header fixed-top dashboard-header" id="header">
               <nav class="navbar navbar-expand-xl navbar-light">
                  <div class="container">
                     <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('frontend/images/logo-color2.png')); ?>" alt="Logo" class="img-fluid"></a>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav mr-auto">
                           <?php if((auth()->user()) && (auth()->user()->user_type == 3)): ?>
                           <!--<li class="nav-item dashboard-nav-item <?php if($action == 'findCandidates'): ?> active <?php endif; ?>">
                              <a class="nav-link highligh-cls" href="<?php echo e(url('company/find-candidates')); ?>"><?php echo e(__('messages.CANDIDATE')); ?></a>
                           </li>-->

                           <!--<li class="nav-item dropdown dashboard-nav-item <?php if($action == 'myNetwork' || ($action == 'index' && $controller == 'MessageController')): ?> active <?php endif; ?>">
                              <a class="nav-link" href="javascript:void(0)">  <?php echo e(__('messages.NETWORK')); ?> </a>
                              <ul class="dropdown-menu">
                                 
                                 <li><a class="dropdown-item" href="<?php echo e(url('company/my-network')); ?>"><?php echo e(__('messages.MY_NETWORK')); ?></a></li>
                                 <li><a class="dropdown-item" href="<?php echo e(url('company/message')); ?>/<?php echo e(encrypt(auth()->user()->id)); ?>"><?php echo e(__('messages.MESSAGES')); ?></a></li>
                              </ul>
                           </li>-->

                          
                           <?php endif; ?>
                           <li class="nav-item job-item dropdown dashboard-nav-item <?php if($action == 'jobList' || $action == 'trackJob' || $action == 'postJob' || $action == 'editJob' || $action == 'viewJobPost' || $action == 'appliedCandidates' || $action == 'applyJob'){ echo 'active';}?>">
                              
                              <?php if((auth()->user()) && (auth()->user()->user_type == 3)){?>
                                 <a class="nav-link before-login" href="<?php echo e(url('company/dashboard/')); ?>"><?php echo e(__('messages.JOBS')); ?></a>
                                 <!-- <a class="nav-link" href="javascript:void(0)"><?php echo e(__('messages.JOBS')); ?></a>
                                 <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="<?php echo e(url('company/my-jobs')); ?>"><?php echo e(__('messages.MY_JOBS')); ?> </a></li>
                                 </ul> -->
                              <?php }else if((auth()->user()) && (auth()->user()->user_type == 2)){?>
                                 <a class="nav-link before-login" href="<?php echo e(url('candidate/my-jobs')); ?>"><?php echo e(__('messages.JOBS_CAPS')); ?></a>
                                 <!-- <a class="nav-link" href="javascript:void(0)"><?php echo e(__('messages.JOBS')); ?></a>
                                 <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="<?php echo e(url('candidate/my-jobs')); ?>"><?php echo e(__('messages.MY_JOBS')); ?> </a></li>
                                 <li><a class="dropdown-item" href="<?php echo e(url('candidate/track-job')); ?>"><?php echo e(__('messages.TRACK_JOBS')); ?> </a></li>
                                 </ul> -->
                                 
                              <?php }else{?>
                                 <a class="nav-link before-login" href="<?php echo e(url('candidate/my-jobs')); ?>"><?php echo e(__('messages.JOBS_CAPS')); ?></a>
                                 <!-- <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="<?php echo e(url('candidate/my-jobs')); ?>"><?php echo e(__('messages.MY_JOBS')); ?> </a></li>
                                 <li><a class="dropdown-item" href="<?php echo e(url('candidate/track-job')); ?>"><?php echo e(__('messages.TRACK_JOBS')); ?> </a></li>
                                 </ul> -->
                              <?php }?>
                              
                           </li>
                           
                           <li class="nav-item all-nav <?php if($action == 'aboutUs'){ echo 'active';}?>">
                              <a class="nav-link" href="<?php echo e(url('about-us')); ?>"><?php echo e(__('messages.ABOUT_US')); ?></a>
                           </li>
                          
                           </li>
                           <li class="nav-item all-nav <?php if($action == 'index' && $controller == 'TrainingController'){ echo 'active';}?>">
                              <a class="nav-link" href="<?php echo e(url('training-category-list')); ?>"><?php echo e(__('messages.TRAINING')); ?></a>
                           </li>
                           <li class="nav-item all-nav <?php if($action == 'tips'){ echo 'active';}?>">
                              <a class="nav-link" href="<?php echo e(url('tips')); ?>"><?php echo e(__('messages.TIPS')); ?></a>
                           </li>
                           <li class="nav-item all-nav">
                              <?php if((auth()->user()) && (auth()->user()->user_type == 3)): ?>
                                
                              <?php else: ?>
                                 

                              <?php endif; ?>

                           </li>

                        </ul>
                     </div>
                     <div class="right-nav-box">
                        <?php if((auth()->user()) && (Auth::user()->user_type != 1)){ //dd($userNotification->count());?>
                        <div class="notifica dashboard-nav-item">
                           <a href="javascript:void(0);" title="" class="not-box-openm">
                              <span class="noti"><img src="<?php echo e(asset('frontend/images/ic-notification.png')); ?>" alt="notification" class="img-fluid"> <?php if($userNewNotificationCount > 0) { ?><span></span> <?php }?></span>
                           </a>
                           <div class="notification-box msg mCustomScrollbar max-height" id="message">
                               
                               <?php if(($userNotification) && ($userNotification->count()) > 0){ ?>
                              <div class="nott-list">
                                 <?php 
                                   foreach($userNotification as $key=>$value){ ?>
                                 <div class="notfication-details <?php if($value['seen_status'] == 0){?>notfication-details-new <?php }?>">
                                    <div class="media">
                                       <div class="noty-user-img">
                                          <?php if($value['user']['profileImage'] != null){?>
                                             <img src="<?php echo e(asset($value['user']['profileImage']['location'])); ?>" alt="" height="35" width="35">
                                          <?php }else{ ?>
                                             <img src="<?php echo e(asset('frontend/images/user-pro-img-demo.png')); ?>" alt="" height="35" width="35">
                                          <?php }?>
                                       </div>
                                       <div class="media-body">
                                       <?php if($value['type'] == 'message'){?>
                                          <?php if((auth()->user()) && (auth()->user()->user_type == 2)){?>
                                          <a href="<?php echo e(url('/candidate/message/')); ?>/<?php echo e(encrypt($value['from_user_id'])); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">
                                          <?php }elseif((auth()->user()) && (auth()->user()->user_type == 3)){?>
                                             <!--<a href="<?php echo e(url('/company/message/')); ?>/<?php echo e(encrypt($value['from_user_id'])); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">-->
                                          <?php }?>
                                             <h3 class="noti-name-cls"><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'];}else{ echo $value['user']['company_name'];}?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo substr($value['message']['message'],0,27); if(strlen($value['message']['message']) > 27){ echo '...';}?></p>
                                             </a>
                                          <?php }else if($value['type'] == 'connection_request'){?>
                                             <?php if((auth()->user()) && (auth()->user()->user_type == 2)){?>
                                          <a href="<?php echo e(url('/candidate/my-network')); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">
                                          <?php }?>
                                             <h3 class="noti-name-cls"><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'];}else{ echo $value['user']['company_name'];}?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'].' '.__('messages.REQUESTED_TO_CONNECT') ;}else{ echo $value['user']['company_name'].' '.__('messages.REQUESTED_TO_CONNECT');} ;?></p>
                                             </a>
                                          <?php } else if($value['type'] == 'connection_accepted'){?>
                                             <?php if((auth()->user()) && (auth()->user()->user_type == 2)){?>
                                             <a href="<?php echo e(url('/candidate/my-network')); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">
                                             <?php }else if((auth()->user()) && (auth()->user()->user_type == 3)){?>
                                                <!--<a href="<?php echo e(url('/company/my-network')); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">-->
                                             <?php }?>
                                             <h3 class="noti-name-cls"><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'];}else{ echo $value['user']['company_name'];}?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'].' '.__('messages.HAS_ACCEPTED_YOUR_CONNECTION_REQUEST');}else{ echo $value['user']['company_name'].' '.__('messages.HAS_ACCEPTED_YOUR_CONNECTION_REQUEST');}?></p>
                                             </a>
                                          <?php } else if($value['type'] == 'connection_rejected'){?>
                                             <?php if((auth()->user()) && (auth()->user()->user_type == 2)){?>
                                             <a href="<?php echo e(url('/candidate/my-network')); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">
                                             <?php }else if((auth()->user()) && (auth()->user()->user_type == 3)){?>
                                                <!--<a href="<?php echo e(url('/company/my-network')); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">-->
                                             <?php }?>
                                             <h3 class="noti-name-cls"><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'];}else{ echo $value['user']['company_name'];}?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'].' '.__('messages.HAS_REJECTED_YOUR_CONNECTION_REQUEST');}else{ echo $value['user']['company_name'].' '.__('messages.HAS_REJECTED_YOUR_CONNECTION_REQUEST');}?></p>
                                             </a>
                                          <?php } else if($value['type'] == 'job'){ ?>
                                             <a href="<?php echo e(url('/candidate/view-job-post')); ?>/<?php echo e(encrypt($value['type_id'])); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['company_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo __('messages.NEW_JOB_POSTED_BY').' '.$value['user']['company_name'].'.';?> </p>
                                             </a>
                                          <?php }else if($value['type'] == 'follow'){?>
                                             <a href="<?php echo e(url('/candidate/view-followers')); ?>/<?php echo e(encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'];}else{ echo $value['user']['company_name'];}?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php if($value['user']['user_type'] == 2){ echo $value['user']['first_name'].' '.__('messages.IS_FOLLOWING_YOU');}else{ echo $value['user']['company_name'].' '.__('messages.IS_FOLLOWING_YOU');}?></p>
                                             </a>
                                          <?php }else if($value['type'] == 'comment'){
                                             if($value['user']['user_type'] == 2){
                                             ?>
                                             <a href="<?php echo e(url('/').'/'.$value['redirect_link'].'/'.encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['first_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo __('messages.NEW_COMMENT_ON_YOUR_POST');?></p>
                                             </a>
                                          <?php }else if($value['user']['user_type'] == 3){ ?>
                                             <a href="<?php echo e(url('/').'/'.$value['redirect_link'].'/'.encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['company_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo __('messages.NEW_COMMENT_ON_YOUR_POST');?></p>
                                             </a>
                                          <?php } }else if($value['type'] == 'like'){
                                             if($value['user']['user_type'] == 2){
                                             ?>
                                             <a href="<?php echo e(url('/').'/'.$value['redirect_link'].'/'.encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['first_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo $value['user']['first_name'].' '.__('messages.LIKE_YOUR_POST');?></p>
                                             </a>
                                          <?php }else if($value['user']['user_type'] == 3){ ?>
                                             <a href="<?php echo e(url('/').'/'.$value['redirect_link'].'/'.encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['company_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo $value['user']['company_name'].' '.__('messages.LIKE_YOUR_POST');?></p>
                                             </a>
                                        <?php } }else if($value['type'] == 'share_post'){
                                             if($value['user']['user_type'] == 2){
                                             ?>
                                             <a href="<?php echo e(url('/').'/'.$value['redirect_link'].'/'.encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['first_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo __('messages.YOUR_POST_SHARED_BY').' '.$value['user']['first_name'].'.';?></p>
                                             </a>
                                          <?php }else if($value['user']['user_type'] == 3){ ?>
                                             <a href="<?php echo e(url('/').'/'.$value['redirect_link'].'/'.encrypt($value['id'])); ?>" title="">
                                             <h3 class="noti-name-cls"><?php echo $value['user']['company_name'];?> <span><?php echo time_elapsed_string($value['created_at']); ?></span></h3>
                                             <p><?php echo __('messages.YOUR_POST_SHARED_BY').' '.$value['user']['company_name'].'.';?></p>
                                             </a>
                                        <?php } }?>
                                       </div>
                                    </div>
                                 </div>
                                 <?php }?>
                                   
                              </div>
                                 <?php }else{?>
                                    <div class="notification-nodata">
                                  <img src="<?php echo e(asset('frontend/images/warning-icon.png')); ?>" alt="notification" class="img-fluid"/>
                                  <h4> <?php echo e(__('messages.NO_DATA_FOUND')); ?> </h4>
                               </div>
                                 <?php }?>
                           </div>
                           
                        </div>
                        <?php } ?>  
                       
                         <?php if(!Auth::check()){?>
                         <a class="signup-btn d-xl-block d-lg-block d-md-block d-sm-none d-none" href="<?php echo e(url('joinus')); ?>">
                           <?php echo e(__('messages.EMPLOYER_SIGNUP')); ?>

                        </a>   
                         <?php }?>      
                         <div class="dropdown language-list">
                           <a class="dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <?php //if(Cookie::get('locale') == 'en'){ echo 'En';} else if(Cookie::get('locale') == 'fr'){ echo 'Fr';} else if(Cookie::get('locale') == 'de'){ echo 'Ge';} else if(Cookie::get('locale') == 'pt' || Cookie::get('locale') == ''){ echo 'Pt';} ?>
                           <?php if(Cookie::get('locale') == 'en'){ echo 'En';} else if(Cookie::get('locale') == 'fr'){ echo 'Fr';} else if(Cookie::get('locale') == 'de' || Cookie::get('locale') == ''){ echo 'Ge';} else if(Cookie::get('locale') == 'pt'){ echo 'Pt';} ?>
                           </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                             <a class="dropdown-item change-lang-" href="<?php echo e(url('locale/en')); ?>" data-id="1" style = "<?php if(Cookie::get('locale') == 'en'){?> display:none; <?php }?>">En</a>   
                             <!-- <a class="dropdown-item change-lang-" href="<?php echo e(url('locale/fr')); ?>" data-id="2" style = "<?php if(Cookie::get('locale') == 'fr'){?> display:none; <?php }?>">Fr</a> -->
                              <a class="dropdown-item change-lang-" href="<?php echo e(url('locale/de')); ?>" data-id="4" style = "<?php if(Cookie::get('locale') == 'de'){?> display:none; <?php }?>">Ge</a>
                              <!-- <a class="dropdown-item change-lang-" href="<?php echo e(url('locale/pt')); ?>" data-id="3" style = "<?php if(Cookie::get('locale') == 'pt' || Cookie::get('locale') == ''){?> display:none; <?php }?>">Pt</a> -->
                           </div>
                        </div>

                        

                        <?php if((Auth::check()) && (Auth::user()->user_type != 1)){?>
                        <div class="user-account dashboard-nav-item">
                           <div class="user-info">
                              <?php if(!empty($userProfInfo['profileImage'])): ?>
                                 <img class="profile-image-src-menu" id="profile-image-src-menu" src="<?php echo e(asset($userProfInfo['profileImage']['location'])); ?>" alt="">
                              <?php else: ?>
                                 <img class="profile-image-src-menu" id="profile-image-src-menu" src="<?php echo e(asset('frontend/images/user.png')); ?>" alt="">
                              <?php endif; ?>
                              <i class="fa fa-caret-down"></i>
                           </div>
                           <div class="user-account-settingss">
                              <ul class="us-links">
                                 <?php if((Auth::check()) && (auth()->user()->user_type == 2)){?>
                                    <!--<li><a href="<?php echo e(url('candidate/my-profile')); ?>"><?php echo e(__('messages.MY_PROFILE')); ?> </a></li> -->
                                    <li><a href="<?php echo e(url('candidate/manage-profile')); ?>"><?php echo e(__('messages.DELETE_PROFILE')); ?> </a></li>
                                   <!-- <li><a href="<?php echo e(url('candidate/view-followers')); ?>"><?php echo e(__('messages.VIEW_FOLLOWER')); ?></a></li> -->
                                   <li><a href="<?php echo e(url('candidate/see-application')); ?>"><?php echo e(__('messages.SEE_APPLICATIONS')); ?></a></li>
                                   <!--<li><a href="<?php echo e(url('candidate/job-alert-setting')); ?>"><?php echo e(__('messages.ALERT_SETTINGS')); ?></a></li> -->
                                 <?php }elseif((Auth::check()) && (auth()->user()->user_type == 3)){?>
                                    <li><a href="<?php echo e(url('company/my-profile')); ?>"><?php echo e(__('messages.MY_PROFILE')); ?> </a></li>
                                    <li><a href="<?php echo e(url('company/manage-profile')); ?>"><?php echo e(__('messages.DELETE_PROFILE')); ?> </a></li>
                                    <!--<li><a href="<?php echo e(url('company/view-followers')); ?>"><?php echo e(__('messages.VIEW_FOLLOWER')); ?></a></li>-->
                                 <?php }?>
                                 
                                 
                                 <li>
                                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                                       document.getElementById('logout-form').submit();">
                                                          <?php echo e(__('messages.LOGOUT')); ?>

                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <div class="user-name">
                              <p>
                                 <?php if((Auth::check()) && (auth()->user()->user_type != 1)): ?>
                                    <?php echo e(auth()->user()->first_name); ?>

                                 <?php else: ?> 
                                    Admin
                                 <?php endif; ?>
                              </p>
                           </div>
                        </div>
                         <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                 <?php }?>
                                 <?php if(!Auth::check()){?>
                        
                        <?php }?>
                        <button type="button" id="sidebarCollapse" class="btn btn-info d-block d-xl-none">
                        <img src="<?php echo e(asset('frontend/images/ic-burger-menu.svg')); ?>" alt="burger-menu" class="img-fluid">
                        </button>
                     </div>
                  </div>
               </nav>
            </header>
            <!-- header End-->
            <div class="header-gap"></div>
            <!-- success message section add "success-block" to show class -->
            <section class="alert-holder-success" >
               <div class="container">
                  <div class="alert-holder"> Success </div>  
               </div>
            </section>

            <!-- success message section add "success-block" to show class -->
            <section class="alert-holder-error" >
               <div class="container">
                  <div class="alert-holder-errmsg"> Error </div>  
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
            <?php 
            function time_elapsed_string($datetime, $full = false) {
               $now = new DateTime;
               $ago = new DateTime($datetime);
               $diff = $now->diff($ago);
           
               $diff->w = floor($diff->d / 7);
               $diff->d -= $diff->w * 7;
           
               $string = array(
                   'y' => 'year',
                   'm' => 'month',
                   'w' => 'week',
                   'd' => 'day',
                   'h' => 'hour',
                   'i' => 'min',
                   's' => 'sec',
               );
               foreach ($string as $k => &$v) {
                   if ($diff->$k) {
                       $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                   } else {
                       unset($string[$k]);
                   }
               }
           
               if (!$full) $string = array_slice($string, 0, 1);
               return $string ? implode(', ', $string) . ' ago' : 'just now';
           }
            ?>
            <?php if((Auth::check()) && (auth()->user()->user_type != 1)){?>
            <script>
            window.setInterval(function(){
            
               $.ajax({
                  url: _BASE_URL+"/check-session-user-status",
                  method:'POST',
                  dataType:'json',
                  cache : false,
                  processData: false,
                  contentType: false,
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response){
                     if(response.success == 0){
                        let msg = response.message;
                        let msgBox = $(".alert-holder-error");
                        msgBox.addClass('error-block');
                        msgBox.find('.alert-holder-errmsg').html(msg);
                        setTimeout(function(){ msgBox.removeClass('error-block')},8000);
                        location.reload();
                     }
                     
                  },
                  error: function(){
                     // let msg = "Something happend wrong.Please try again";
                     // let msgBox = $(".alert-holder-error");
                     // msgBox.addClass('error-block');
                     // msgBox.find('.alert-holder-errmsg').html(msg);
                     // setTimeout(function(){ msgBox.removeClass('error-block')},8000);
                     location.reload();
                  }	
               });

            }, 5000);
            </script>
         <?php }?>



         <?php /**PATH /var/www/html/centralJobs/resources/views/frontend/includes/header_after_login.blade.php ENDPATH**/ ?>