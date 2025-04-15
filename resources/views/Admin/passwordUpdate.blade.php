@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Change Password</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="javascript:history.back()" title="Back to List">  Back</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-12">
                <!-- form start -->
                <form role="form" method="POST" id="changePassword" action="{{ url('/admin/password-update') }}">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <!-- /.card-body Account Details-->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="content_title">Old Password<span style="color:red">*</span> </label>
                                        <div class="password-holder">
                                            <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder=" Old Password" autocomplete="off"/>
                                            <span toggle="#password-field" class="fa fa-eye-slash toggle-password"> </span>
                                        </div>
                                        <span id="oldPasswordspan" style="color: red"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="content_title">New Password<span style="color:red">*</span> </label>
                                        <div class="password-holder">
                                           <input type="password" id="password" name="password" class="form-control" placeholder=" New Password" autocomplete="off"/>
                                           <span toggle="#password-field" class="fa fa-eye-slash toggle-password-new"></span>
                                        </div>   
                                        <span id="passwordspan" style="color: red"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="content_title">Confirm Password<span style="color:red">*</span> </label>
                                        <div class="password-holder">
                                           <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder=" Confirm password" autocomplete="off"/>
                                           <span toggle="#password-field" class="fa fa-eye-slash toggle-password-re"></span>
                                        </div>
                                        <span id="password_confirmationspan" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body Account Details-->
                        <!-- general form elements -->
                        <div class="card-footer">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    <!-- /.card -->
                </form>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('script')
<script src="{{asset('pages/admin/settings.js')}}"></script>

<script type="text/javascript">
   // Post.passwordUpdate();
</script>

@endsection