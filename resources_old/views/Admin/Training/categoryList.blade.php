@extends('layouts.admin')
@section('content')

<script src="{{asset('pages/admin/training.js')}}"></script>
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
            <div class="col-sm-6">
                <h1>Training Category list</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Training Category List</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/training-category-add')}}" title="Add"> Add</a>
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
                        <form action="{{url('/admin/training-category-list')}}" method="get">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="usr">Category Name:</label>
                                    <input class="form-control" type="text" name="name" id="name" placeholder="Category Name" value="{{@$search['name']}}" />
                                    <span id="searchId" class="error"></span>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                    <?php if(!empty($search)){?>
                                    <a class="btn btn-info" href="{{url('admin/training-category-list')}}" title="Back"> Back</a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    @if(count($trainings) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th>Course Url</th>
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
                                    @foreach($trainings as $key=>$training)
                                    <?php $i++; ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td>{{$training['name']}}</td>
                                        <td> <?php if($training['description']!=''){?>
                                            {{substr($training['description'],0,35)}}
                                            <?php if(strlen($training['description']) > 35){ ?>
                                                <span id="dots_{{$training['id']}}" data-id="{{$training['id']}}">...</span><span id="more_{{$training['id']}}" style="display: none;"> {{substr($training['description'],35)}}</span>
                                                <a onclick="myFunction('<?php echo $training['id'];?>')" id="myBtn_{{$training['id']}}" data-id="{{$training['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                        </td>
                                        <td><a href="<?php echo $training['course_url'];?>" target="_blank"><?php echo $training['course_url'];?></a></td>
                                        <td>
                                        <?php if($training['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($training['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inactive"  data-id="{{$training['id']}}" data-val="{{$training['status']}}">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$training['id']}}" data-val="{{$training['status']}}">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/training-category-edit/'.encrypt($training['id']))}}">Edit</a></li>
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#training-category-{{$training['id']}}">Delete</p></a></li>
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
                    {{ $trainings->appends(request()->query())->links() }}
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
@foreach($trainings as $training)
    @include('layouts._partials.confirmation-popup', ['resource'=>$training, 'resourceName'=> 'training-category', 'heading'=>'Training Category'])
@endforeach

@endsection

