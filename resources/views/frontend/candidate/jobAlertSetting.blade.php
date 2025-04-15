@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/job.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- main -->
<main>
      <section class="section section-follower">
         <div class="container">
            <div class="row">
               <div class="col-12 col-md-12 col-lg-10 mx-auto">
                  <div class="profile-side-panel mb-0">
                     <div class="followers-holder">
                        <div class="followers-title">
                           <div class=" media align-items-center  whitebg">
                                 <div class="media-body">
                                    <h4 class="my-0 total-title">{{ __('messages.SAVE_JOB_ALERT') }} </h4>
                                 </div>  
                                 <!-- <div class="switch-slider d-flex align-items-center">
                                    <p class="mb-0 mr-2">Job Alert </p>
                                 <label class="switch">
                                    <input id="start" type="checkbox" >
                                    <span class="slider round"></span>
                                 </label>
                                 </div>  -->
                           </div>
                        </div>
                        <!--sd-title end-->
                        <div class="followers-list">
                           <?php if($jobAlertHistory->count() > 0){ 
                              foreach($jobAlertHistory as $key=>$val){ ?>
                           <div class="media job-list-holder border-0" id="alert_row_{{$val['id']}}">
                              <div class="media-body">
                                    <!-- Displayed in case of search by Position Name   -->
                                    <h4 class="h3-head mb-2">{{$val['keyword']}}</h4>
                                 <!-- Displayed in case of search by Company -->
                                 <?php if($val['country']['name'] != '' || $val['state']['name'] != '' || $val['city']){?>
                                 <p><i class="fa fa-map-marker font-20 mr-2" aria-hidden="true"></i><?php $coma= ''; if($val['state']['name'] != ''){ echo $val['state']['name']; $coma = ', ';} if($val['city'] != ''){ echo $coma.$val['city'];} ?></p>
                                 <?php }?>
                              </div>
                              <div class="d-flex align-items-center profile-btn-holder">
                                    <button class="btn site-btn-color" href="javascript:void(0);" id="alert-delete-id" data-id="{{$val['id']}}"> {{ __('messages.DELETE_POST') }} </button>
                              </div>
                           </div>
                           <?php } 
                              echo $jobAlertHistory->appends(request()->query())->links() ;
                              }else{?>
                              <div class="col-12">
                              <div class="nodata-found-holder">
                                 <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
                                 <h4>{{ __('messages.SORRY_NO_RESULT_FOUND') }}</h4> 
                              </div>
                           </div> 
                           <?php }?>
                        </div>
                        <!--suggestions-list end-->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
<!-- main End -->
@endsection