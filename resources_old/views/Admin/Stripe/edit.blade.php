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
                @if(@$plan['id'] != '')
                <h1>Edit Stripe Product</h1> @else
                <h1>Add Stripe Product</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/payment-cms-list')}}">Stripe Products List</a></li>
                    <li class="breadcrumb-item active"> @if(@$plan['id'] != '') Edit Stripe Product @else Add Stripe Product @endif</li>
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
                @if(@$plan['id'] != '')
                <form role="form" method="post" id="editAdvertise" action="{{ url('admin/product-list-edit') }}" enctype="multipart/form-data">
                    {{-- {{ url('admin/product-list-edit') }} --}}
                    <input name="plan_id" type="hidden" value="{{$plan['id']}}">
                    @else
                    {{-- <form enctype="multipart/form-data" role="form" method="post" id="addAdvertise" action="{{ url('admin/payment-cms-add') }}"> --}}
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if($plan['id'] != '') Edit Stripe Product @else Add Stripe Product @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="plan_name">Plan Name <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="plan_name" id= "plan_name" value="{{ $plan['name'] }}" class="form-control" id="name" placeholder="Plan Name"> 
                                            <small class="form-text text-muted">The name of the plan.</small>
                                            @if ($errors->has('plan_name'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('plan_name') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="desc">Statement Descriptor</label>
                                            <input type="text" class="form-control" id="desc" name="desc" value = "{{$plan['statement_descriptor']}}" maxlength="22">
                                            <small class="form-text text-muted">An arbitrary string which will be displayed on the customer's bank statement.(NOTE : max statement length is 22 characters)</small>
                                            @if ($errors->has('desc'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('desc') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="plan_desc">Plan Description</label>
                                            <textarea class="form-control" id="plan_desc" name="plan_desc">{{$plan['product']}}</textarea>
                                            <small class="form-text text-muted">The product's description, meant to be displayable to the customer.</small>
                                            @if ($errors->has('plan_desc'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('plan_desc') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            
                                            <label for="plan_desc">Metadata</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="general" name="general"
                                                    @if (isset($plan['product_metadata']['General']))
                                                        value="{{trim($plan['product_metadata']['General'])}}"
                                                    @endif >
                                                    <small class="form-text text-muted">This is the content that goes under the name of the Product.</small>
                                                    @if ($errors->has('general'))
                                                    <span class="error" role="alert">
                                                        <strong>{{ $errors->first('general') }}</strong>
                                                    </span> 
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="Free" name="free"
                                                    @if (isset($plan['product_metadata']['Free']))
                                                        value="{{trim($plan['product_metadata']['Free'])}}"
                                                    @endif >
                                                    <small class="form-text text-muted">This is the content that goes under the name of the Product.(Free section)</small>
                                                    @if ($errors->has('Free'))
                                                    <span class="error" role="alert">
                                                        <strong>{{ $errors->first('Free') }}</strong>
                                                    </span> 
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="below_description" name="below_description"
                                                    @if (isset($plan['product_metadata']['Below Description']))
                                                        value="{{trim($plan['product_metadata']['Below Description'])}}"
                                                    @endif >
                                                    <small class="form-text text-muted">This is the content that goes under the description of the Product.(Free section)</small>
                                                    @if ($errors->has('below_description'))
                                                    <span class="error" role="alert">
                                                        <strong>{{ $errors->first('below_description') }}</strong>
                                                    </span> 
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Value <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="value" value="{{ @$details['value'] }}" class="form-control" id="value" placeholder="Eg: 1490"> 
                                            @if ($errors->has('value'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('value') }}</strong>
                                            </span> 
                                            @endif
                                        </div>
                                    </div> --}}
                                    
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
                            @if(@$plan['id'] != '')
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