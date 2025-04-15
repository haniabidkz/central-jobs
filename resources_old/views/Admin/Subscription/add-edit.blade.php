@extends('layouts.admin') @section('content')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('pages/admin/subscription.js')}}"></script>
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
                <h1>Service Edit</h1> @else
                <h1>Service Add</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/subscription-list')}}">Service List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Service Edit @else Service Add @endif</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/subscription-list')}}" title="Back to List"> Back</a>
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
                <form role="form" method="post" id="editSubscription" action="{{ url('admin/edit-subscription-post') }}">
                    <input name="id" hidden value="{{@$details['id']}}">
                    @else
                    <form role="form" method="post" id="addSubscription" action="{{ url('admin/add-subscription-post') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Service Edit @else Service Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Service Name <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="title" value="{{@$details['title']}}" class="form-control" id="title" placeholder="Service Name"> @if ($errors->has('title'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('title') }}
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Subscription Details <span class="" style="color:red;">* </span></label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Subscription Description">{{@$details['description']}}</textarea>
                                            @if ($errors->has('description'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('description') }}
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Subscription Price </label>
                                            <input type="text" name="price" value="{{@$details['price']}}" class="form-control" id="price" placeholder="Subscription Price"> @if ($errors->has('price'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('price') }}
                                            </span> @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Subscription Instruction <span class="" style="color:red;">* </span></label>
                                            <textarea  id="instruction" name="instruction"><?php echo @$details['instruction'];?></textarea>
                                            <span class="descErr"></span>
                                        </div>
                                    </div>   
                                   
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="select-newstyle">
                                                <div class="list-inline-item">
                                                    <label class="check-style">
                                                        Active
                                                        <input type="radio" name="status" value="1" <?php if(((@$details['status'] == 1) && (@$details['status'] != '')) || empty(@$details)){ echo 'checked';} ?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="list-inline-item">
                                                    <label class="check-style">
                                                        Inactive
                                                        <input type="radio" name="status" value="0" <?php if((!empty(@$details)) && (@$details['status'] == 0)){ echo 'checked';} ?>>
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