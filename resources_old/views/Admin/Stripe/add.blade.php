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
                <form enctype="multipart/form-data" role="form" method="post" id="addAdvertise" action="{{ url('admin/product-store') }}">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Stripe Product </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <!-- /.card-body Account Details-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="plan_id">Plan Id <span class="" style="color:red;">* </span></label>
                                                <input type="text" name="plan_id" id= "plan_id"  class="form-control"  placeholder="Plan Id" required> 
                                                <small class="form-text text-muted">The plan unique identifier.</small>
                                                @if ($errors->has('plan_id'))
                                                <span class="error" role="alert">
                                                    <strong>{{ $errors->first('plan_id') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="plan_name">Plan Name <span class="" style="color:red;">* </span></label>
                                                <input type="text" name="plan_name" id= "plan_name"  class="form-control" placeholder="Plan Name" required> 
                                                <small class="form-text text-muted">The name of the plan.</small>
                                                @if ($errors->has('plan_name'))
                                                <span class="error" role="alert">
                                                    <strong>{{ $errors->first('plan_name') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="amount">Amount(€) <span class="" style="color:red;">* </span></label>
                                                <input type="number" class="form-control" id="amount" placeholder="Amount" name="amount" required>
                                                <small class="form-text text-muted">A positive amount for the transaction.</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="interval">Interval <span class="" style="color:red;">* </span></label>
                                                <select class="form-control" id="interval" name="interval" required>
                                                    <option selected dissabled>Select interval</option>
                                                    <option value = "week">Weekly</option>
                                                    <option value = "month">Monthly</option>
                                                    <option value = "year">Annually</option>
                                                </select>
                                                <small class="form-text text-muted">Specifies billing frequency.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                            

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="desc">Statement Descriptor</label>
                                        <input type="text" class="form-control" id="desc" name="desc" maxlength="22">
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
                                        <textarea class="form-control" id="plan_desc" name="plan_desc"></textarea>
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
                                                <input type="text" class="form-control" id="general" name="general">
                                                <small class="form-text text-muted">This is the content that goes under the name of the Product.</small>
                                                @if ($errors->has('general'))
                                                <span class="error" role="alert">
                                                    <strong>{{ $errors->first('general') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="Free" name="free">
                                                <small class="form-text text-muted">This is the content that goes under the name of the Product.(Free section)</small>
                                                @if ($errors->has('Free'))
                                                <span class="error" role="alert">
                                                    <strong>{{ $errors->first('Free') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="below_description" name="below_description">
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
                                
                            </div>
                        </div>
                        <!-- /.card-body Account Details-->
                        <!-- general form elements -->
                        
                        <div class="card-footer">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                        
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