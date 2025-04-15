@extends('layouts.admin') @section('content')

<script src="{{asset('pages/admin/training.js')}}"></script>
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
                <h1>Training Category Edit</h1> @else
                <h1>Training Category Add</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/training-category-list')}}">Training Category List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Training Category Edit @else Training Category Add @endif</li>
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
                <form role="form" method="post" id="editCategory" action="">
                    <input name="id" hidden value="{{@$details['id']}}">
                    @else
                    <form role="form" method="post" id="addCategory" action="{{ url('admin/training-category-post') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Category Edit @else Category Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Category Name <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="name" value="{{@$details['name']}}" class="form-control" id="name" placeholder="Category Name"> @if ($errors->has('name'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Course Url <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="course_url" value="{{@$details['course_url']}}" class="form-control" id="course_url" placeholder="Course Url"> @if ($errors->has('course_url'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('course_url') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Category Description</label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Category Description">{{@$details['description']}}</textarea>
                                            @if ($errors->has('description'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <!-- <label><input type="radio" name="status" value="1" <?php if(((@$details['status'] == 1) && (@$details['status'] != '')) || empty(@$details)){ echo 'checked';} ?>>Active</label>
                                            <label><input type="radio" name="status" value="0" <?php if((!empty(@$details)) && (@$details['status'] == 0)){ echo 'checked';} ?>>Inactive</label> -->
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