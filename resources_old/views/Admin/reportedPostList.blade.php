@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/post.js')}}"></script>
<script type="text/javascript">
    Post.List();
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Reported Post List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Reported Post List</li>
                </ol>
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
                    <!-- <div class="card-header"> <h3 class="card-title"></h3> </div> -->
                    @if(count($reportedPosts) >0)
                   <!--  <?php //echo '<pre>'; print_r($reportedPosts); exit;?> -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">  
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Posted By</th>
                                        <th>Posted On</th>
                                        <th>Post Type</th>
                                        <th>Total Reports</th>
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
                                    @foreach($reportedPosts as $key=>$post)
                                    <?php $i++ ;?>
                                    <tr>
                                        <td><a class="opnMdlCls" href="javascript:void(0);" data-id="{{$post['post']['id']}}">{{$i}}</a></td>
                                        <td><a target="_blank" href="{{url('/admin/view-candidate-details/'.encrypt($post['post']['user']['id']))}}">{{$post['post']['user']['first_name'].' '.$post['post']['user']['last_name']}}</a></td>
                                        <td>{{date('Y-m-d H:i a',strtotime($post['post']['created_at']))}}</td>
                                        <td>
                                            <?php 
                                            if($post['post']['category_id'] == 1){
                                                echo 'Job';
                                            }elseif($post['post']['category_id'] == 2){
                                                echo 'Text';
                                            }elseif($post['post']['category_id'] == 3){
                                                echo 'Image';
                                            }elseif($post['post']['category_id'] == 4){
                                                echo 'Video';
                                            }
                                            ?>
                                        </td>
                                        <td>{{$post['total']}}</td>
                                        <td><?php if($post['post']['status']==1){?> <button type="button" class="btn btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn btn-danger btn-sm disable-cursor">Inactive</button><?php } ?></td>
                                        <td>
                                        <button onClick="return window.location.href = '{{url('admin/view-report-details/'.encrypt($post['post']['id']))}}'" class="btn btn-primary btn-sm">View</button>    
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                    {{ $reportedPosts->appends(request()->query())->links() }}
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
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reported Post Details</h4>
      </div>
      <div class="modal-body">
      <div class="table-responsive">          
        <table class="table">
            <thead>
            <tr>
                <th>Sl No</th>
                <th>User Name</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Commented On</th>
            </tr>
            </thead>
            <tbody class="tblData">
            
            </tbody>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default mr-1 sbmtCls" data-status="1">Approve</button>
        <button type="button" class="btn btn-default sbmtCls" data-status="2">Reject</button> -->
      </div>
    </div>

  </div>
</div>

@endsection

