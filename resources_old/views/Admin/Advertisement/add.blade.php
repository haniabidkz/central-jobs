@extends('layouts.admin') @section('content')

<script src="{{asset('pages/admin/advertise.js')}}"></script>
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
                <h1>Advertisement Edit</h1> @else
                <h1>Advertisement Add</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/advertise-list')}}">Advertisement List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Advertisement Edit @else Advertisement Add @endif</li>
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
                <form role="form" method="post" id="editAdvertise" action="{{ url('admin/advertise-edit-post') }}" enctype="multipart/form-data">
                    <input name="id" type="hidden" value="{{@$details['id']}}">
                    @else
                    <form enctype="multipart/form-data" role="form" method="post" id="addAdvertise" action="{{ url('admin/advertise-add-post') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Advertisement Edit @else Advertisement Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Advertisement Url <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="url" value="{{@$details['url']}}" class="form-control" id="course_url" placeholder="Advertisement Url"> @if ($errors->has('url'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Advertisement Image </label>
                                            <input type="file" name="image_name" value="" class="form-control" id="image_name"> </br>
                                            <?php if(@$details['image_name'] != ''){ ?>
                                            <span id="banner_img" class="error">
                                            <div class="rmv-img">
                                                <img src="<?php echo URL::asset('/upload/advertise_image/'.@$details['image_name'])?>" class="img-fluid img-thumbnails" height="200" width="200">
                                                <a class="remImage" href="javascript:void(0);" id="deleteImg" data-img-id = "{{@$details['id']}}" data-page-id = "{{@$details['id']}}">
                                                <span aria-hidden="true">×</span>
                                                </a> 
                                            </div>
                                            </span>
                                            <?php }else{?>
                                                <span id="banner_img" class="error"></span>
                                           <?php } ?>
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