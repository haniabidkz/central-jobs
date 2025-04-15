<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Meu RH | {{$pageTitle}}</title>
        <link rel="icon"  type="image/png" href="{{asset('backend/dist/img/favicon.ico')}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('backend/plugins/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
        <!-- Custom Style -->
        <link rel="stylesheet" href="{{asset('backend/dist/css/style.css')}}">
        
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/flat/blue.css')}}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{asset('backend/plugins/morris/morris.css')}}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{asset('backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{asset('backend/plugins/datepicker/datepicker3.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker-bs3.css')}}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <!-- select 2 -->
        <link href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet">

        <!-- Owl Carousel -->
        <link rel="stylesheet" href="{{asset('backend/plugins/owlcarousel/assets/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/plugins/owlcarousel/assets/owl.theme.default.min.css')}}">
        <style>

            .error {
                color:red;
            }

        </style>
        <!-- jQuery -->
        <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{asset('backend/plugins/morris/morris.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{asset('backend/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
        <!-- jvectormap -->
        <script src="{{asset('backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{asset('backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{asset('backend/plugins/knob/jquery.knob.js')}}"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="{{asset('backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- datepicker -->
        <script src="{{asset('backend/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <!-- Slimscroll -->
        <script src="{{asset('backend/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{asset('backend/plugins/fastclick/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('backend/dist/js/adminlte.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset('backend/dist/js/pages/dashboard.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset('backend/dist/js/demo.js')}}"></script>

        <!-- Owl Carousel -->
        <script src="{{asset('backend/plugins/owlcarousel/owl.carousel.min.js')}}"></script>

        <!-- Valivation -->
        <script src="{{ asset('frontend/js/formvalidator.min.js') }}" type="text/javascript" ></script>

        <!-- select 2 -->    
        <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
        <!-- JS file -->
        <script src="{{ asset('autocomplete/jquery.easy-autocomplete.min.js') }}"></script>

        <!-- CSS file -->
        <link rel="stylesheet" href="{{ asset('autocomplete/easy-autocomplete.min.css') }}">

        <!-- Additional CSS Themes file - not required-->
        <link rel="stylesheet" href="{{ asset('autocomplete/easy-autocomplete.themes.min.css') }}">
        <!-- Custome css -->
        <link rel="stylesheet" href="{{ asset('backend/dist/css/custome.css') }}">    
        
        <!-- Confirmation Box -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
         <!-- Confirmation Box -->
        @yield('script')
        <script>
        function OnInput() {
          
          
        }
        </script>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <div class="loder-holder d-none" >
               <div class="loader"></div>
            </div>
             <!-- Navbar -->
             @include('layouts._partials.navigation')
            <!-- Navbar -->

            <!-- Main Sidebar Container -->
            @include('layouts._partials.sidebar')
            <!-- /Main Sidebar Container -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Message Bar Container -->
                @include('layouts._partials.messagebar')
                <!-- /Message Bar Container -->
                @yield('content')

                <script>
                    const BASE_URL = "<?php echo url('/'); ?>";
                </script>
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <strong>Copyright &copy; 2019-2020 </strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version 1.0</b> 
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
    </body>

</html>
