@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/jobList.js')}}"></script>
<script type="text/javascript">
    Post.changeStatus();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Post List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Post List</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-sm-12">
                <div class="float-sm-right">
                <a class="btn btn-info" href="{{url('admin/post-add')}}" title="Add"> Add</a>
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
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    @if(count($posts) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Posted By</th>
                                        <th>Posted On</th>
                                        <th>Post Type</th>
                                        <th>Status</th>
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
                                    @foreach($posts as $key=>$post)
                                    <?php $i++ ;?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{($post['title']?$post['title']:'N/A')}}</td>
                                        <td>{{($post['description']?substr($post['description'],0,20):'N/A')}}</td>
                                        <td>{{$post['user']['first_name'].' '.$post['user']['last_name']}}</td>
                                        <td>{{date('Y-m-d',strtotime($post['created_at']))}}</td>
                                        <td>{{($post['postCategory']['title']?$post['postCategory']['title']:'N/A')}}</td>
                                        <td>
                                        <?php if($post['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        <!-- @if($post['status'] == 1)
                                        <a class="status"  href="javascript:void(0)" title="Inctive"  data-id="{{$post['id']}}" data-val="{{$post['status']}}"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        @else
                                        <a class="status"  href="javascript:void(0)" title="Active"  data-id="{{$post['id']}}" data-val="{{$post['status']}}"><i class="fa fa-times" aria-hidden="true"></i></a>    
                                        @endif -->
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($post['status'] == 1)
                                                    <a class="status dropdown-item" href="javascript:void(0)"  data-id="{{$post['id']}}" data-val="{{$post['status']}}">Inactive</a>
                                                    @else
                                                    <a class="status dropdown-item" href="javascript:void(0)"  data-id="{{$post['id']}}" data-val="{{$post['status']}}">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/post-view/'.encrypt($post['id']))}}">View</a></li>
                                                    <li><a class="dropdown-item" href="{{url('admin/post-edit/'.encrypt($post['id']))}}">Edit</a></li>
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#post-{{$post['id']}}">Delete</p></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                    {{ $posts->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-dark">
                            Nothing Found
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@foreach($posts as $post)
    @include('layouts._partials.confirmation-popup', ['resource'=>$post, 'resourceName'=> 'post', 'heading'=>'Post'])
@endforeach

@endsection

