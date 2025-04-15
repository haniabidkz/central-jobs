@extends('layouts.admin')
@section('content')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('pages/admin/settings.js')}}"></script>
<script type="text/javascript">
    Post.editCms();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$details['title']}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{$details['title']}}</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/cms-page')}}" title="Back to List">  Back</a>
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
            <div class="col-md-12">
                <!-- form start -->
                <form role="form" method="post" id="editCms" action="">
                    <input name="id" hidden value="{{$details['id']}}">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{$details['title']}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" value="{{$details['meta_title']}}"
                                                class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                                                id="meta_title" placeholder="Meta Title">
                                            @if ($errors->has('meta_title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('meta_title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>                             

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="meta_desc">Meta Description</label>
                                            <textarea  name="meta_desc"
                                                class="form-control {{ $errors->has('meta_desc') ? ' is-invalid' : '' }}"
                                                id="meta_desc" placeholder="Meta Description">{{$details['meta_desc']}}</textarea>
                                            @if ($errors->has('meta_desc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('meta_desc') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" value="{{$details['title']}}"
                                                class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                id="title" placeholder="Title">
                                            @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea  id="description" name="description"
                                                class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                placeholder="Description" >{{$details['description']}}
                                            </textarea>
                                            <strong class="descErr"></strong>
                                            @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body Account Details-->
                                <!-- /.card-footer--> 
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
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

