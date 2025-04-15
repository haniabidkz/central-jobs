<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>{{$pageTitle}}</title>
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
      <div class="sign-in">
         <div class="container">
            <div class="sign-in-page">
               <div class="signin-popup">
                  <div class="signin-pop">
                     <div class="row">
                        <div class="col-md-12 col-12">
                           <div class="success-message-holder login-form">
                              <h2 class="sub-title mb-2">Purchase form</h2>
                              <div class="row mt-4">
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                       <label>Subscription ID :</label> {{$orderInformation['subscription_code']}}
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                       <label>Service Name :</label> {{$orderInformation['subscription_history']['title']}}
                                    </div>
                                 </div> 
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                       <label>Candidate’s email ID :</label> {{$orderInformation['candidate_email']}}
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                       <label>Candidate Name :</label> {{$orderInformation['candidate_name']}}
                                    </div>
                                 </div>  
                                 <?php if($orderInformation['service_start_from'] != NULL){?>
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                       <label>Proposed Date-time :</label> {{$orderInformation['service_start_from']}}
                                    </div>
                                 </div>
                               <?php } ?>
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                      <label>Price to be Paid :</label> ${{$orderInformation['amount']}}
                                    </div>
                                 </div>  
                                 <?php if($orderInformation['additional_info'] != ''){?>
                                 <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-view-text">
                                      <label>Additional information :</label> {{$orderInformation['additional_info']}} 
                                    </div>
                                 </div> 
                                  <?php } ?>
                                 <div class="col-12 mt-3 text-left">
                                    <div class="form-group">
                                       <a href="#" class="btn site-btn-color">Pay Now</a>
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
      <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/popper.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/moment.min.js') }}" type="text/javascript"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/custom.js') }}"></script>
   </body>


