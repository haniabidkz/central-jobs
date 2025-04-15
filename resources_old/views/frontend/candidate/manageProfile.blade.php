@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('js/manageProfile.js')}}"></script>
<!-- Content Header (Page header) -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <!-- main -->
 <main>
   <section class="section profile-account-setting">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="section-myprofile">
                     <div class="login-form">
                        <div class="row mb-4">
                           <div class="col-12">
                              <h4 class="font-22">{{ __('messages.MANAGE_PROFILE') }}</h4> 
                              <form role="form" method="post" id="manage-form" action="{{ url('candidate/manage-profile-post') }}">
                                {{csrf_field()}}
                              <input name="id" hidden value="{{Auth::user()->id}}">
                              <!-- <div class="manage-div media">
                                 <div class="media-body">
                                   <h4>{{ __('messages.ACTIVE_ACCOUNT') }}</h4>
                                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pretium nulla quis erat dapibus, varius hendrerit neque suscipit. Integer in ex euismod, posuere lectus id</p>
                                 </div>
                                 <div class="switch-slider">
                                   <label class="switch">
                                      <input id="start1" type="radio" name="acc" class="status" <?php// if(Auth::user()->status == 1){echo 'checked';}?> value="1">
                                      <span class="slider round"></span>
                                   </label>
                                 </div> 
                              </div>
                              <div class="manage-div media">
                                 <div class="media-body">
                                    <h4>{{ __('messages.DEACTIVATE_ACCOUNT') }}</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pretium nulla quis erat dapibus, varius hendrerit neque suscipit. Integer in ex euismod, posuere lectus id</p>
                                 </div>   
                                 <div class="switch-slider">
                                   <label class="switch">
                                      <input id="start2" type="radio"  name="acc" class="status" <?php //if(Auth::user()->status == 2){echo 'checked';}?> value="2">
                                      <span class="slider round"></span>
                                   </label>
                                 </div> 
                              </div> -->
                              <div class="manage-div media">
                                 <div class="media-body">
                                   <h4 class="mb-4">{{ __('messages.PERMANENTLY_DELETE_ACCOUNT') }}</h4>
                                   <div class="pl-3">
                                       <p>{{ __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE1') }} <strong> CENTRAL JOBS PORTAL. </strong> {{-- __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE1_HALF') --}}</p>
                                       <p>{{ __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE2_1') }}</p>
                                       <p>{{ __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE2') }}</p>
                                       <p>{{ __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE3') }}</p>

                                       <p class="text-right  mb-0"> <strong> {{ __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE4') }} </strong></p>
                                       <p class="text-right"><strong>{{ __('messages.DELETE_TEXT_FOR_MANAGE_SETTINGS_LINE5') }} </strong></p>
                                    </div>     
                                 </div>  
                                 <input id="start3" type="hidden"  name="acc" class="status"  value="3">
                                 <!-- <div class="switch-slider">
                                    <label class="switch">
                                      <input id="start3" type="radio"  name="acc" class="status"  <?php //if(Auth::user()->deleted_at != null){echo 'checked';}?> value="3">
                                      <span class="slider round"></span>
                                    </label>
                                 </div>  -->
                              </div>
                              <div class="form-group mb-0 mt-4">
                                <button class="btn site-btn-color" type="submit"> {{ __('messages.DELETE_SUBMIT') }}</button>
                              </div> 
                            </form>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </section>
</main>
<!-- main End -->
@endsection