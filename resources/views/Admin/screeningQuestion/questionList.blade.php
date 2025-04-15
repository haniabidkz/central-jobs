@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/screening.js')}}"></script>
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
                <h1>Screening Questions List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Screening Question List</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/screening-question-add')}}" title="Add"> Add</a>
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
                    @if(count($questions) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Question</th>
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
                                    @foreach($questions as $key=>$question)

                                    <?php $i++; ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td>
                                            <?php if($question['question']!=''){?>
                                            {{substr($question['question'],0,100)}}
                                            <?php if(strlen($question['question']) > 100){ ?>
                                                <span id="dots_{{$question['id']}}" data-id="{{$question['id']}}">...</span><span id="more_{{$question['id']}}" style="display: none;"> {{substr($question['question'],100)}}</span>
                                                <a onclick="myFunction('<?php echo $question['id'];?>')" id="myBtn_{{$question['id']}}" data-id="{{$question['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                        </td>
                                        <td>
                                        <?php if($question['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($question['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inactive"  data-id="{{$question['id']}}" data-val="{{$question['status']}}">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$question['id']}}" data-val="{{$question['status']}}">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/screening-question-edit/'.encrypt($question['id']))}}">Edit</a></li>
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#screening-question-{{$question['id']}}">Delete</p></a></li>
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
                    {{ $questions->appends(request()->query())->links() }}
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
@foreach($questions as $question)
    @include('layouts._partials.confirmation-popup', ['resource'=>$question, 'resourceName'=> 'screening-question', 'heading'=>'Screening Question'])
@endforeach

@endsection

