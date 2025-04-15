@extends('layouts.admin') @section('content')

<script src="{{asset('pages/admin/cms.js')}}"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                @if(@$details['id'] != '')
                <h1>Page Content Reference Edit</h1> @else
                <h1>Page Content Reference Add</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin/page-content-reference')}}/{{$encryptedId}}">Page Content Reference</a></li>
                    <li class="breadcrumb-item active"> @if(@$details['id'] != '') Page Content Reference Edit @else Page Content Reference Add @endif</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('/admin/page-content-reference')}}/{{$encryptedId}}" title="Back to List"> Back</a>
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
                <form role="form" method="post" id="editPageContent" action="{{ url('admin/update-page-cont-ref-info')}}/{{$encryptedId}}">
                    <input name="id" hidden value="{{@$details['id']}}">
                    <input name="page_id" hidden value="{{@$details['page_id']}}">
                    @else
                    <form role="form" method="post" id="addPageContent" action="{{ url('admin/store-page-reference') }}/{{$encryptedId}}">
                    <input name="page_id" hidden value="{{$id}}">
                    @endif
                        
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Page Content Reference Edit @else Page Content Reference Add @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Page Reference Name</label>
                                            <input type="text" name="content_ref" value="{{@$details['content_ref']}}" class="form-control" id="name" placeholder="Page Reference Name"> @if ($errors->has('content_ref'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('content_ref') }}
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
                        </div>
                        <!-- /.card -->
                        <!-- general form elements -->
                        @if(@$details['id'] != '')
                        <div class="card card-primary">
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        @else
                        <div class="card card-primary">
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        @endif
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