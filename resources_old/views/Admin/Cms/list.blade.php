@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/cms.js')}}"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Page List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Page List</li>
                    <!-- <li class="breadcrumb-item active">Pages list</li> -->
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/add-page')}}" title="Add"> Add</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" id="addSerh">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/page-list')}}" id="search-from" method="get">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="usr">Page Name:</label>
                                        <input class="form-control" type="text" name="page_name" id="page_name" placeholder="Page Name" value="{{@$search['page_name']}}" />
                                        <span id="searchId" class="error"></span>
                                    </div>
                                </div>
                            
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="usr">Status:</label> 
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="1" <?php if(@$search['status'] === '1') echo 'selected'; ?>>Active</option>
                                            <option value="2" <?php if(@$search['status'] === '2') echo 'selected'; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                        <?php if((@$search['status'] != '') || (@$search['page_name'] != '')){?>
                                        <a class="btn btn-info" href="{{url('/admin/page-list')}}" title="Reset">Reset</a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(count($pages) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Banner Image</th>
                                        <th>Name</th>                               
                                        <th>Status</th>
                                        <th>Text</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lastParam = app('request')->input('page');
                                    if($lastParam == '' || $lastParam == 1){
                                        $i = 0; 
                                    }
                                    else{ 
                                        $i= (($lastParam-1) * env('ADMIN_PAGINATION_LIMIT'));
                                    } ?>
                                    @foreach($pages as $key => $row)
                                    <?php $i++ ;?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <th><?php if($row['upload'] != ''){?> <img src="<?php echo URL::asset('/upload/banner_image/'.@$row['upload']['name'])?>" class="img-thumbnails img-border-rad-5" height="70" width="100"> <?php }else{ ?> 
                                            <img src="{{asset('/backend/dist/img/no-image.jpeg')}}" alr="" height="70" width="100" class="img-border-rad-5"/>
                                            <?php } ?></th>
                                        <td>{{$row['page_name']}}</td>
                                        <td>
                                        <?php if($row['status']==1){?> <button type="button" class="btn btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td style="width:200px;">
                                            <a href="{{url('admin/page-content-reference/'.encrypt($row['id']))}}" class="btn btn-primary pull-left">Content Reference</a>
                                        </td>         
                                        <td width="100px">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions </button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($row['status'] == 1)
                                                    <a class="dropdown-item status_page"  href="javascript:void(0)" title="Inactive"  data-id="{{$row['id']}}" data-val="0">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status_page"  href="javascript:void(0)" title="Active"  data-id="{{$row['id']}}" data-val="1">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/update-page/'.encrypt($row['id']))}}">Edit</a></li>
                                                    
                                                    <?php if(empty($row['pageContents']->toArray())){?>
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#page-{{$row['id']}}">Delete</p></a></li>
                                                    <?php }?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                <tbody>   
                            </table>
                        </div> 
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- $pages->appends(request()->query())->links() --}}
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-dark">
                            Sorry! No cms page found.
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- Modal -->

@foreach($pages as $page)
    @include('layouts._partials.confirmation-popup', ['resource'=>$page, 'resourceName'=> 'page', 'heading'=>'Page'])
@endforeach

@endsection
