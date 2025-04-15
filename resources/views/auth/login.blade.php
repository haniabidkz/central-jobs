@extends('layouts.app_before_login_layout')
@section('content')

<!--  Custome login View  -->
 <!-- main -->
            <main>
               <section class="home-section2">
                  <div class="container">
                     <div class="row">
                        <div class="col-12 text-center mb-5">
                        </div>
                     </div>
                     <div class="row mt-5">
                        <div class="col-lg-7">
                           <div class="pt-5">
                              <div class="w-100 mb-5">
                                 <a class="home-logo" href="index.html"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="Logo" class="img-fluid"></a>
                              </div>
                              <h3 class="title"> We are not here only to show you job posts.</h3>
                              <h2 class="title">We are here to <b> help you build your FUTURE! </b></h2>
                           </div>
                        </div>
                        <div class="col-lg-5 d-flex justify-content-center">
                           <div class="login-sec">
                              <ul class="sign-control">
                                 <li data-tab="tab-1" class="current"><a href="#" title="">Sign in</a></li>
                                 <li data-tab="tab-2"><a href="#" title="">Sign up</a></li>
                              </ul>
                              <div class="sign_in_sec current" id="tab-1">
                                 <ul class="signin-tab nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link active" id="tab-3-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="true"><i class="fa fa-user" aria-hidden="true"></i>
                                       Candidate</a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" id="tab-4-tab" data-toggle="tab" href="#tab-4" role="tab" aria-controls="#tab-4" aria-selected="false"><i class="fa fa-user" aria-hidden="true"></i>
                                       Employer</a>
                                    </li>
                                 </ul>
                                 <!-- Tab panes -->
                                 <div class="tab-content">
                                    <div class="dff-tab tab-pane active" id="tab-3" role="tabpanel" aria-labelledby="tab-3-tab">
                                       <!-- <h3>Sign in</h3> -->
                                       <form method="POST" action="{{ url('login') }}">
                                          @csrf
                                          <div class="row">
                                             <div class="col-12">
                                                <div class="sn-field">
                                                   <input type="text" id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                                   <i class="la la-user"></i>

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                             </div>
                                             <div class="col-12">
                                                <div class="sn-field  password-holder">
                                                   <input class=" @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Password">
                                                   <i class="la la-lock"></i>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                   <button class="eye_showHide" type="button"> <i class="la la-eye"></i>

                                                   </button>
                                                </div>
                                             </div>
                                             <div class="col-6 col-sm-6">
                                                <label class="check-style">Remember Me
                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
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
                                       <div class="login-resources">
                                          <h4>Sign In with</h4>
                                          <ul>
                                             <li><a href="#" title="" class="fb"><i class="fa fa-facebook"></i>Facebook</a></li>
                                             <li><a href="#" title="" class="google"><i class="fa fa-google"></i>Google</a></li>
                                          </ul>
                                       </div>
                                       <!--login-resources end-->
                                    </div>
                                    <div class="tab-pane" id="tab-4" role="tabpanel" aria-labelledby="tab-4-tab">
                                       <!-- <h3>Sign in</h3> -->
                                       <form method="POST" action="{{ route('login') }}">
                                          <div class="row">
                                             <div class="col-12">
                                                <div class="sn-field">
                                                   <input type="text" name="username" placeholder="Username">
                                                   <i class="la la-user"></i>
                                                </div>
                                                <!--sn-field end-->
                                             </div>
                                             <div class="col-12">
                                                <div class="sn-field  password-holder">
                                                   <input type="password" name="password" placeholder="Password">
                                                   <i class="la la-lock"></i>
                                                   <button class="eye_showHide" type="button"> <i class="la la-eye"></i></button>
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
                                    </div>
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
                                       <form method="POST" action="{{ route('login') }}">
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
                                                   <button class="eye_showHide" type="button"> <i class="la la-eye"></i></button>
                                                </div>
                                             </div>
                                             <div class="col-12">
                                                <div class="sn-field password-holder">
                                                   <input type="password" name="repeat-password" placeholder="Re-enter Password">
                                                   <i class="la la-lock"></i>
                                                   <button class="eye_showHide" type="button"> <i class="la la-eye"></i></button>
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
                                       <form method="POST" action="{{ route('login') }}">
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
                                                   <button class="eye_showHide" type="button"> <i class="la la-eye"></i></button>
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
                        </div>
                     </div>
                  </div>
               </section>
            </main>

@endsection
<!-- End Custom Login View -->
