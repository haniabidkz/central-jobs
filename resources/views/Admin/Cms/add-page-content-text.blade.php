@extends('layouts.admin') @section('content')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('pages/admin/cms.js')}}"></script>
<script>
   Post.addCms();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Page Content Text Add of <b>{{$details['content_ref']}}</b></h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin/page-list')}}">Page List</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/page-content-reference/'.encrypt($idRf))}}">Page Content Reference
</a></li>
                    <li class="breadcrumb-item active">Page Content Text Add</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/page-content-reference/'.encrypt($idRf))}}" title="Back to List">Back</a>
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
                    <form role="form" method="post" id="addCmsText" action="{{ url('admin/add-page-content-text') }}">
                    <input type="hidden" name="page_contents_id" value="{{$id}}" id="page_contents_id">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Page Content Text Add</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="language_type" value="English" class="form-control" id="language_type" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Text</label>
                                            <textarea  id="text_english" name="text_english"></textarea>
                                            <strong class="descErrEng"></strong>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="language_type" value="French" class="form-control" id="language_type" disabled="disabled">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Text</label>
                                            <textarea  id="text_french" name="text_french"></textarea>
                                            <strong class="descErrFre"></strong>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="language_type" value="Portuguese" class="form-control" id="language_type" disabled="disabled">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Text</label>
                                            <textarea  id="text_portuguese" name="text_portuguese"></textarea>
                                            <strong class="descErrPrt"></strong>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                            <!-- /.card-body Account Details-->
                           
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