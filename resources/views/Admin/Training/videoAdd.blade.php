@extends('layouts.admin') @section('content')

<script src="{{asset('pages/admin/training.js')}}"></script>
<script>
    Post.videoAdd();
    Post.videoEdit();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if(@$details['id'] != '')
                <h1>Video Edit</h1> @else
                <h1>Video Add</h1> @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/training-video-list')}}">Video List</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Video Edit @else Video Add @endif</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
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
                <form role="form" method="post" id="editVideo" action="">
                    <input name="id" hidden value="{{@$details['id']}}">
                    @else
                    <form role="form" method="post" id="addVideo" action="{{ url('admin/training-video-post') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Video Edit @else Video Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="form-control" name="category_id" id="category_id">
                                                <option value="">Select Category Name</option>
                                                @if(count($categoryList) > 0)
                                                @foreach($categoryList as $key=>$val)
                                                <option value="{{$val['id']}}" <?php if($val['id'] == @$details['category_id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('category_id'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>  
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="title">Video Title</label>
                                            <input type="text" name="title" value="{{@$details['title']}}" class="form-control" id="title" placeholder="Video Name"> @if ($errors->has('title'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Video Description</label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Video Description">{{@$details['description']}}</textarea>
                                            @if ($errors->has('description'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Video Key</label>
                                            <input type="text" name="youtube_video_key" value="{{@$details['youtube_video_key']}}" class="form-control" id="youtube_video_key" placeholder="Youtube video key"> @if ($errors->has('youtube_video_key'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('youtube_video_key') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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