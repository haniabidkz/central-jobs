@extends('layouts.admin') @section('content')

<script src="{{ asset('pages/admin/bestAdvertise.js') }}"></script>
<script>
    Post.edit();
    Post.add();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                @if(@$details['id'] != '')
                <h1>Payment CMS Edit</h1> @else
                <h1>Payment CMS Add</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/payment-cms-list')}}">Payment CMS List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Payment CMS Edit @else Payment CMS Add @endif</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="javascript:history.back()" title="Back to List"> Back</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- form start -->
                @if(@$details['id'] != '')
                <form role="form" method="post" id="editAdvertise" action="{{ url('admin/payment-cms-edit') }}" enctype="multipart/form-data">
                    <input name="id" type="hidden" value="{{@$details['id']}}">
                    @else
                    <form enctype="multipart/form-data" role="form" method="post" id="addAdvertise" action="{{ url('admin/payment-cms-add') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Payment CMS Edit @else Payment CMS Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Payment Name <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="name" value="{{ @$details['name'] }}" class="form-control" id="name" placeholder="Name" Readonly> 
                                            @if ($errors->has('name'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Value <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="value" value="{{ @$details['value'] }}" class="form-control" id="value" placeholder="Eg: 1490"> 
                                            @if ($errors->has('value'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('value') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="col-12">
                                        <div class="form-group">
                                            <div class="select-newstyle">
                                                <div class="list-inline-item">
                                                    <label class="check-style">
                                                        Active
                                                        <input type="radio" name="status" value="1" @if(((@$details['status'] == 1) && (@$details['status'] != '')) || empty(@$details)) checked @endif>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="list-inline-item">
                                                    <label class="check-style">
                                                        Inactive
                                                        <input type="radio" name="status" value="0" @if((!empty(@$details)) && (@$details['status'] == 0)) checked @endif>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>    
                                    </div> -->
                                </div>
                            </div>
                            <!-- /.card-body Account Details-->
                            <!-- general form elements -->
                            @if(@$details['id'] != '')
                                <div class="card-footer">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            @else
                                <div class="card-footer">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            @endif
                        </div>
                        <!-- /.card -->
                    </form>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection