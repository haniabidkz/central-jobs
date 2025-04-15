<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MyHR | Log in</title>
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
        <script src="{{ asset('frontend/assets/js/formvalidator.min.js') }}" type="text/javascript" ></script>
        <!-- Validation -->
        <script src="{{asset('pages/admin/settings.js')}}"></script>
        <script type="text/javascript">
            Post.login();
        </script>
    </head>
    <div class="content-wrapper">
            <!-- Message Bar Container -->
            @include('layouts._partials.messagebar')
            <!-- /Message Bar Container -->
    </div>
    <body class="hold-transition login-page bg-site-color">
    <!-- Content Wrapper. Contains page content -->

            <!-- /.content-wrapper -->
            <div class="login-box">
                <div class="login-logo">
                    <a href="{{url('admin/dashboard')}}"><img src="{{asset('backend/dist/img/logo-color.png')}}" alt="Lifestyle Admin Logo" class="img-fluid"></a>
                </div>
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session </p>
                        <form action="{{url('admin/login')}}" method="post" id="login">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><span class="fa fa-envelope form-control-feedback"></span></span>
                                            </div>
                                            <input name="email" id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" >
                                        </div>
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>    
                                <div class="col-12">    
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><span class="fa fa-lock form-control-feedback" style="width:16px;"></span></span>
                                            </div>
                                            <input name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" >
                                        </div>
                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>    
                            </div>
                            <div class="row mt-3">
                                <!-- <div class="col-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox" name="remember_me" value="1"> Remember Me
                                        </label>
                                    </div>
                                </div> -->
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-flat">Sign In</button>
                                </div>
                                <div class="col-12 col-sm-6 d-flex align-items-center justify-content-sm-end">
                                    <p class="m-0">
                                        <a class="forgot-link" href="{{url('admin/forgot-password')}}">I forgot my password</a>
                                    </p>
                                </div>    
                            </div>

                        </form>

                        
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->
        
    </body>
</html>

