
@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/company/list.js')}}"></script>
<script type="text/javascript">
    Post.changeStatus();
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
                <h1>Candidate applied for jobs</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/job-list')}}">Job List</a></li>
                    <li class="breadcrumb-item active">Candidate applied for jobs</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                <a class="btn btn-info" href="javascript:history.back()" title="Back"> Back</a>
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
                <div class="card">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Candidates</h3>
                        <form action="{{url('/admin/users-applied/'.$jobId)}}" method="get">
                        <input type="text" name="search" id="search" placeholder="Name/Email" value="{{$search}}" />
                        <button type="submit" id="searchBtn">Search</button>
                        </form>
                    </div> -->
                    <!-- <?php //echo '<pre>'; print_r($users); exit;?> -->
                    @if(count($users) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Job Title</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Cover Letter</th>
                                        <th>Applied On</th>
                                        <!-- <th>Status</th>
                                        <th>Action</th> -->
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
                                    @foreach($users as $key=>$candidates)
                                    <?php $i++ ;?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td>{{$candidates['jobPost']['title']}}</td>
                                        <td>{{$candidates['user']['first_name'].' '.$candidates['user']['last_name']}}</td>
                                        <td>{{$candidates['user']['email']}}</td>
                                        <td> <?php if($candidates['appliedUserInfo']['cover_letter']!=''){?>
                                            {{substr(strip_tags($candidates['appliedUserInfo']['cover_letter']),0,35)}}
                                            <?php if(strlen($candidates['appliedUserInfo']['cover_letter']) > 35){ ?>
                                                <span id="dots_{{$candidates['appliedUserInfo']['id']}}" data-id="{{$candidates['appliedUserInfo']['id']}}">...</span><span id="more_{{$candidates['appliedUserInfo']['id']}}" style="display: none;"> {{substr(strip_tags($candidates['appliedUserInfo']['cover_letter']),100)}}</span>
                                                <a onclick="myFunction('<?php echo $candidates['appliedUserInfo']['id'];?>')" id="myBtn_{{$candidates['appliedUserInfo']['id']}}" data-id="{{$candidates['appliedUserInfo']['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                            </td>
                                        <td>{{date('Y-m-d H:i a',strtotime($candidates['apply_date']))}}</td>
                                        <!-- <td>
                                        @if($candidates['user']['status'] == 1)
                                        <a class="btn-success" title="Active" ><i class="fa fa-fw fa-check" style="color: white;" ></i></a>
                                        @else
                                        <a class="btn-danger" title="Inactive" ><i class="fa fa-fw fa-close" style="color: white;" ></i></a>    
                                        @endif
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions <i class="fa fa-angle-double-down"></i></button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li><a class="dropdown-item" href="">View</a></li>
                                                    <li><a class="dropdown-item" href="">Edit</a></li>
                                                </ul>
                                        </div>
                                        
                                        </td> -->
                                    </tr>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div>    
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                    {{ $users->appends(request()->query())->links() }}
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
@foreach($users as $candidate)
    @include('layouts._partials.confirmation-popup', ['resource'=>$candidate, 'resourceName'=> 'candidate', 'heading'=>'Candidate'])
@endforeach
@endsection
