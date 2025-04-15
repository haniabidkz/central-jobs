<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MyHR | Forgot Password</title>
        <link rel="icon"  type="image/png" href="{{asset('backend/dist/img/favicon.ico')}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
        <!-- Custom Style -->
        <link rel="stylesheet" href="{{asset('backend/dist/css/style.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/square/blue.css')}}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <!-- jQuery -->
        <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- iCheck -->
        <script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
       <!-- Valivation -->
       <script src="{{ asset('frontend/js/formvalidator.min.js') }}" type="text/javascript" ></script>
        <!-- Validation -->
        <script src="{{asset('pages/admin/settings.js')}}"></script>
        <script type="text/javascript">
            Post.sendMail();
        </script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
               <a href="{{url('admin/dashboard')}}"><img src="{{asset('backend/dist/img/logo-color.png')}}" alt="Lifestyle Admin Logo" class="img-fluid"></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Send Password Reset Link</p>

                    <form method="POST" id="sendmail" action="{{ url('admin/verify-email') }}" aria-label="{{ __('Reset Password') }}">
                            @csrf
    
                            <!-- <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> -->
                            <div class="row">
                               <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><span class="fa fa-envelope form-control-feedback" style="width:16px;"></span></span>
                                            </div>
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>  
                            <div class="row mt-3">  
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>    


                        </form>

                    <!--
                    <div class="social-auth-links text-center mb-3">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fa fa-facebook mr-2"></i> Sign in using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fa fa-google-plus mr-2"></i> Sign in using Google+
                        </a>
                    </div>
                    -->
                    <!-- /.social-auth-links -->


                    {{-- <p class="mb-1">
                    <a href="{{route('password.request')}}">I forgot my password</a>
                    </p> --}}
                    <!--
                    <p class="mb-0">
                        <a href="register.html" class="text-center">Register a new membership</a>
                    </p>
                    -->
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
           
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Message Bar Container -->
            @include('layouts._partials.messagebar')
            <!-- /Message Bar Container -->
           
        </div>
        <!-- /.content-wrapper -->
        
    </body>
</html>






                    

                