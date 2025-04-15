@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/post.js')}}"></script>
<script type="text/javascript">
    Post.List();
    Post.CommentReport();
</script>
<script>
function myFunction(id) {
  var dots = document.getElementById("dots_"+id);
  var moreText = document.getElementById("more_"+id);
  var btnText = document.getElementById("myBtn_"+id);

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Reported Comment List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Reported Comment List</li>
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
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    @if(count($reportedComments) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Comment</th>
                                        <!-- <th>Image</th> -->
                                        <th>Commented By</th>
                                        <th>Commented On</th>
                                        <th>Total Report</th>
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
                                    @foreach($reportedComments as $key=>$comment)
                                    <?php //echo '<pre>'; print_r($comment); exit;?>
                                    <input type="hidden" name="comment_id" id="comment_id" value="{{$comment['comment']['id']}}"/>
                                    <?php $i++ ;?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        
                                        <td> <?php if($comment['comment']['comment']!=''){?>
                                            {{substr($comment['comment']['comment'],0,35)}}
                                            <?php if(strlen($comment['comment']['comment']) > 35){ ?>
                                                <span id="dots_{{$comment['comment']['id']}}" data-id="{{$comment['comment']['id']}}">...</span><span id="more_{{$comment['comment']['id']}}" style="display: none;"> {{substr($comment['comment']['comment'],35)}}</span>
                                                <a onclick="myFunction('<?php echo $comment['comment']['id'];?>')" id="myBtn_{{$comment['comment']['id']}}" data-id="{{$comment['comment']['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                            </td>
                                        <!-- <td><?php if($comment['comment']['profile']['profile_image']){ ?> <img src="{{$comment['comment']['profile']['profile_image']['location']}}" alt="" height="" width="" /> <?php }else{ ?><img src="{{asset('/backend/dist/img/no_avatar.jpg')}}" alr="" height="30" width="30" class="img-border-rad-5"/><?php } ?></td> -->
                                        <td><a target="_blank" href="{{url('/admin/view-candidate-details/'.encrypt($comment['comment']['user']['id']))}}">{{$comment['comment']['user']['first_name'].' '.$comment['comment']['user']['last_name']}}</a></td>
                                        <td>{{date('Y-m-d H:i a',strtotime($comment['comment']['created_at']))}}</td>
                                        <td>{{$comment['total']}}</td>
                                        <td><?php if($comment['comment']['status']==1){?> <button type="button" class="btn btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn btn-danger btn-sm disable-cursor">Inactive</button><?php } ?></td>
                                        <td>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                        <a class="dropdown-item abuse" data-id="{{$comment['comment']['id']}}" href="javascript:void(0)" title="Abuse">Abuse</a>
                                                    </li>
                                                    <li> 
                                                        <a class="dropdown-item ignore" data-id="{{$comment['comment']['id']}}" href="javascript:void(0)" title="Ignore">Ignore</a>   
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/view-comment-report-details/'.encrypt($comment['comment']['id']))}}">View</a></li>
                                                    <!-- <button onClick="return window.location.href = '{{url('admin/view-comment-report-details/'.encrypt($comment['comment']['id']))}}'" class="btn btn-primary btn-sm">View</button>  -->
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
                        {{ $reportedComments->appends(request()->query())->links() }}
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
<div id="myModal" class="modal fade custom-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Report Details</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">          
            <table class="table">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Name</th>
                        <th>Comment</th>
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

