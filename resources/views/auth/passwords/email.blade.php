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
                                       <a href="{{url('/')}}" class="logo-holder" ><img src="{{ asset('frontend/images/logo-color2.png') }}" alt="" class="img-fluid"></a>
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
                                          <h3>{{ __('messages.FORGOT_PASSWORD') }}</h3>
                                                                                    
                                          <h5 class="signup-description mb-4 ">{{ __('messages.FORGOT_PASSWORD_TEXT') }}.</h5>
                                          <form autocomplete="off" id="email_pass_reset_link" method="POST" action="{{ route('password.email') }}">
                                              @csrf
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="sn-field">
                                                      <input class="@error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.EMAIL') }} *">
                                                      <!-- error -->
                                                    
                                                      <!-- end -->
                                                      <i class="la la-user"></i>
                                                   </div>
                                                   @if ($errors->first('email'))
                                             
                                                    <label id="email-error" class="error" for="email"> {{   $errors->first('email') }}</label>

                                                    @elseif (session('status'))
                                                       
                                                        <label id="email-error" class="success-color" for="email"> {{ session('status') }}</label>

                                                    @elseif(session('error_status'))

                                                        <label id="email-error" class="error-color" for="email"> {{ session('error_status') }}</label>

                                                     @endif
                                                </div>
                                                
                                                <div class="col-12 mt-4">
                                                   <button class="submit-btn" type="submit" value="submit">{{ __('messages.SUBMIT') }}</button>
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
