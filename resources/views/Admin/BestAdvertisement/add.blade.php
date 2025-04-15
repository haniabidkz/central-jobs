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
                <h1>Best Advertisement Edit</h1> @else
                <h1>Best Advertisement Add</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/best-advertise-list')}}">Best Advertisement List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Best Advertisement Edit @else Best Advertisement Add @endif</li>
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
                <form role="form" method="post" id="editAdvertise" action="{{ url('admin/best-advertise-edit') }}" enctype="multipart/form-data">
                    <input name="id" type="hidden" value="{{@$details['id']}}">
                    @else
                    <form enctype="multipart/form-data" role="form" method="post" id="addAdvertise" action="{{ url('admin/best-advertise-add') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Best Advertisement Edit @else Best Advertisement Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Advertisement initial text <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="initial_text" value="{{ @$details['initial_text'] }}" class="form-control" id="initial_text" placeholder="Eg: Logistics company is lookig for:"> 
                                            @if ($errors->has('initial_text'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('initial_text') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Advertisement Position <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="position" value="{{ @$details['position'] }}" class="form-control" id="position" placeholder="Eg: Analyst"> 
                                            @if ($errors->has('position'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('position') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Companies Requirment <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="requirment" value="{{ @$details['requirment'] }}" class="form-control" id="requirment" placeholder="Eg: 3 years experience"> 
                                            @if ($errors->has('requirment'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('requirment') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Reference No<span class="" style="color:red;">* </span></label>
                                            <input type="text" name="ref_no" value="{{ @$details['ref_no'] }}" class="form-control" id="ref_no" placeholder="Eg: Ref: 66474984"> 
                                            @if ($errors->has('ref_no'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('ref_no') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
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
                                    </div>
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