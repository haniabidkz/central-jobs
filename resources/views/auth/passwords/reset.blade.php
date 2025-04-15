@extends('layouts.app_before_login_layout')
@section('content')

<!--  Custome login View  -->
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
                                         <a href="{{url('/')}}" class="logo-holder"><img src="{{ asset('frontend/images/logo-color2.png') }}" alt="" class="img-fluid"></a>
                                         <p> </p>
                                      </div>
                                      <!--cm-logo end-->    
                                      <img src="{{ asset('frontend/images/ResetPassword-person.jpg') }}" alt=""  class="img-fluid">         
                                   </div>
                                   <!--cmp-info end-->
                                </div>
                                <div class="col-md-6 col-12">
                                   <div class="d-flex align-items-center h-100">
                                      <div class="login-sec">
                                         <div class="sign_in_sec current" >
                                            <h3>{{ __('messages.RESET_PASSWORD') }}</h3>
                                            <h5 class="signup-description mb-4">{{ __('messages.RESET_PASSWORD_TEXT') }}</h5>
                                              <form id="reset_password" method="POST" action="{{ route('password.update') }}">
                                                <input type="hidden" name="email" id="email" value="{{request()->get('email')}}"/>
                                                <input type="hidden" name="token" value="{{Request::segment(3)}}"/>
                                                @csrf
                                               <div class="row">
                                                 
                                                  <div class="col-12">
                                                     <div class="sn-field  password-holder">
                                                        
                                                         <input placeholder="{{ __('messages.NEW_PASSWORD') }} *" id="password" type="password" class="form-control @error('password') is-invalid @enderror chkPasswordCls" name="password" required autocomplete="new-password">
                                                         @if ($errors->has('password'))
                                                         <label id="email-error" class="error" for="Name">{{ $errors->first('password') }}</label>
                                                         @endif
                                                        <i class="la la-lock"></i>
                                                        <button class="eye_showHide" type="button" id="eye-open-hide-5"> <i class="fa fa-eye" id ="eye-sh-5"></i>
                                                        </button>
                                                     </div>
                                                     <span id="error_pass"></span>
                                                  </div>
                                                  <div class="col-12">
                                                    <div class="reenter-passholder">
                                                     <div class="sn-field password-holder">
                                                        
                                                         <input placeholder="{{ __('messages.RE_ENTER_NEW_PASSWORD') }} *" id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                          @if ($errors->has('password_confirmation'))
                                                           <label id="email-error" class="error" for="Name">{{ $errors->first('password_confirmation') }}</label>
                                                           @endif
                                                        <i class="la la-lock"></i>
                                                        <button class="eye_showHide" type="button" id="eye-open-hide-6"> <i class="fa fa-eye" id ="eye-sh-6"></i>
                                                        </button>
                                                     </div>
                                                     <span id="error_con_pass"></span>
                                                     <span class="confirm-success d-none"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                  </div>
                                                </div>
                                                  @if (session('status'))
                                                <div class="col-12">
                                                  <label id="email-error" class="error-color" for="email"> {{ __('messages.YOUR_RESET_PASSWORD_LINK_HAS_EXPIRED') }}</label>
                                                </div>
                                               @endif
                                                  <div class="col-12 mt-4">
                                                     <button class="submit-btn chkPass" type="submit" value="submit" disabled>{{ __('messages.SUBMIT') }}</button>
                                                  </div>
                                               </div>
                                            </form>
                                         </div>
                                         <!--sign_in_sec end-->
                                      </div>
                                      <!--login-sec end-->
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
            </main>
<!-- main End -->
            
@endsection
<!-- End Custom Login View -->
