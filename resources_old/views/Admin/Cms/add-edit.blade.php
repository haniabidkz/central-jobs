@extends('layouts.admin') @section('content')

<script src="{{asset('pages/admin/cms.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if(@$details['id'] != '')
                <h1>Page Edit</h1> @else
                <h1>Page Add</h1> @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin/page-list')}}">Page List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Page Edit @else Page Add @endif</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('/admin/page-list')}}" title="Back to List">Back</a>
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
                <form role="form" method="post" id="editPage" action="{{ url('admin/update-page-info') }}" enctype="multipart/form-data">
                    <input name="id" hidden value="{{@$details['id']}}">
                    @else
                    <form role="form" method="post" id="addPage" action="{{ url('admin/store-page') }}" enctype="multipart/form-data">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Page Edit @else Page Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Page Name</label>
                                            <input type="text" name="page_name" value="{{@$details['page_name']}}" class="form-control" id="name" placeholder="Page Name"> @if ($errors->has('page_name'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('page_name') }}
                                            </span> @endif
                                        </div>
                                    </div>
                                   
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Banner Image <a href="#" data-toggle="tooltip" data-placement="top" title="Recommended image width and height is 1920px X 498px and following extensions are allowed .jpg .jpeg .png .bmp"><i class="fa fa-question-circle" aria-hidden="true" style="color:black;"></i></a></label>
                                            <input type="file" name="banner_image" value="" class="form-control" id="banner_image"> </br>
                                            <?php if(@$details['upload'] != ''){ ?>
                                            <span id="banner_img" class="error">
                                            <div class="rmv-img">
                                                <img src="<?php echo URL::asset('/upload/banner_image/'.@$details['upload']['name'])?>" class="img-fluid img-thumbnails" height="200" width="200">
                                                <a class="remImage" href="javascript:void(0);" id="deleteImg" data-img-id = "{{@$details['upload']['id']}}" data-page-id = "{{@$details['id']}}">
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