@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/training.js')}}"></script>
<script>
    Post.videoList();
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
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Video list</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Video List</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/training-video-add')}}" title="Add"> Add</a>
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
                        <form action="{{url('/admin/training-video-list')}}" method="get">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="usr">Title:</label>
                                    <input class="form-control" type="text" name="title" id="title" placeholder="Title" value="{{@$search['title']}}" />
                                    <span id="searchId" class="error"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="usr">Category Name:</label> 
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="">Select Category Name</option>
                                        @if(count($categoryList) > 0)
                                        @foreach($categoryList as $key=>$val)
                                        <option value="{{$val['id']}}" <?php if($val['id'] == @$search['category_id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                    <?php if(!empty(@$search)){?>
                                    <a class="btn btn-info" href="{{url('admin/training-video-list')}}" title="Back"> Back</a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    @if(count($videos) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category Name</th>
                                        <th>Video Title</th>
                                        <th>Video Url</th>
                                        <th>Description</th>
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
                                    @foreach($videos as $key=>$video)
                                    <?php $i++; ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td>{{$video['category']['name']}}</td>
                                        <td>{{$video['title']}}</td>
                                        <td><a href="javascript:void(0);" class="video-open" data-id="{{$video['youtube_video_key']}}">https://www.youtube.com/embed/{{$video['youtube_video_key']}}</a></td>
                                        <td>
                                            {{substr($video['description'],0,35)}}
                                            <?php if(strlen($video['description']) > 35){ ?>
                                                <span id="dots_{{$video['id']}}" data-id="{{$video['id']}}">...</span><span id="more_{{$video['id']}}" style="display: none;"> {{substr($video['description'],35)}}</span>
                                                <a onclick="myFunction('<?php echo $video['id'];?>')" id="myBtn_{{$video['id']}}" data-id="{{$video['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php }
                                            ?>
                                        </td>
                                        <td>
                                        <?php if($video['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($video['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inactive"  data-id="{{$video['id']}}" data-val="{{$video['status']}}">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$video['id']}}" data-val="{{$video['status']}}">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/training-video-edit/'.encrypt($video['id']))}}">Edit</a></li>
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#training-video-{{$video['id']}}">Delete</p></a></li>
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
                    {{ $videos->appends(request()->query())->links() }}
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
@foreach($videos as $video)
    @include('layouts._partials.confirmation-popup', ['resource'=>$video, 'resourceName'=> 'training-video', 'heading'=>'Training Video'])
@endforeach
<!-- Modal -->
<div id="myModal" class="modal fade video-url" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body cmpDetailCls">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/QFaFIcGhPoM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
      
    </div>

  </div>
</div>
@endsection

