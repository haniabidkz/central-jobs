@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('pages/admin/subscription.js')}}"></script>
<script>
    Post.list();
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
            <div class="col-12 col-sm-6">
                <h1>Service List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Service List</li>
                </ol>
            </div>
        </div>
        <!-- <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('/admin/add-subscription')}}" title="Add">Add Subscription</a>
                </div>
            </div>
        </div> -->
    </div><!-- /.container-fluid -->
</section>
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" id="addSerh">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/subscription-list')}}" method="get">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Service Name:</label>
                                        <input class="form-control" type="text" name="title" id="title" placeholder="Service Name" value="{{@$search['title']}}" />
                                        <span id="searchId" class="error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Status:</label> 
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="2" <?php if(@$search['status'] == 2) echo 'selected'; ?>>Inactive</option>
                                            <option value="1" <?php if(@$search['status'] == 1) echo 'selected'; ?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                        <?php if((@$search['title'] != '') || (@$search['status'] != '')){?>
                                            <a class="btn btn-info" href="{{url('admin/subscription-list')}}" title="Back"> Reset</a> 
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(count($subscriptions) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Service Name</th>
                                        <th>Subscription Details</th>
                                        <th>Subscription Price</th>
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
                                    @foreach($subscriptions as $key=>$subscription)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{($subscription['title']?$subscription['title']:'N/A')}}</td>
                                        <td>
                                        <?php if($subscription['description']!=''){?>
                                            {{substr($subscription['description'],0,150)}}
                                            <?php if(strlen($subscription['description']) > 150){ ?>
                                                <span id="dots_{{$subscription['id']}}" data-id="{{$subscription['id']}}">...</span><span id="more_{{$subscription['id']}}" style="display: none;"> {{substr($subscription['description'],150)}}</span>
                                                <a onclick="myFunction('<?php echo $subscription['id'];?>')" id="myBtn_{{$subscription['id']}}" data-id="{{$subscription['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                        </td>
                                        <td>${{$subscription['price']}}</td>
                                        <td>
                                        <?php if($subscription['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions </button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li><a class="dropdown-item" href="{{url('admin/view-subscription-details/'.encrypt($subscription['id']))}}">View</a></li>
                                                    <li>
                                                    @if($subscription['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inactive"  data-id="{{$subscription['id']}}" data-val="0">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$subscription['id']}}" data-val="1">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/edit-subscription/'.encrypt($subscription['id']))}}">Edit</a></li>
                                                    <!-- <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#subscription-{{$subscription['id']}}">Delete</p></a></li> -->
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
                    {{ $subscriptions->appends(request()->query())->links() }}
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
@foreach($subscriptions as $subscription)
    @include('layouts._partials.confirmation-popup', ['resource'=>$subscription, 'resourceName'=> 'subscription', 'heading'=>'Subscription'])
@endforeach

@endsection

