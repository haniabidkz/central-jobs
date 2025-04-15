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
                <h1>Company Job List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/company-list')}}">Company List</a></li>
                    <li class="breadcrumb-item active">Company Job List</li>
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
                        <form action="{{url('/admin/company-job-list/'.encrypt($id))}}" method="get">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <input class="form-control" type="text" name="search" id="search" placeholder="Title/Skill" value="{{$search}}" />
                                
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div> -->
                 
                    @if(count($jobs) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table custom-table" id="candidateList">
                            <thead class="custom-thead">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Title</th>
                                    <th>Company</th>
                                    <th>Position</th>
                                    <th>Applied</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Start</th>
                                    <th>End</th>
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
                                @foreach($jobs as $key=>$job)
                                <?php $i++ ;?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td>{{$job['title']}}</td>
                                    <td>{{$job['user']['company_name']}}</td>
                                    <td>
                                        @if($job['position_for'] == 1)
                                        Freshers
                                        @elseif($job['position_for'] == 2)
                                        Associate
                                        @elseif($job['position_for'] == 3)
                                        Mid-Senior level
                                        @elseif($job['position_for'] == 4)
                                        Senior Level
                                        @elseif($job['position_for'] == 5)
                                        Manager
                                        @elseif($job['position_for'] == 6)
                                        Director
                                        @elseif($job['position_for'] == 7)
                                        Vice President
                                        @elseif($job['position_for'] == 8)
                                        CEO
                                        @elseif($job['position_for'] == 9)
                                        Others
                                        @endif
                                    </td>
                                    <td class="text-center">{{count($job['totalAppliedJob'])}}</td>
                                    <td>
                                        @if($job['employment_type'] == 1)
                                        Full Time
                                        @elseif($job['employment_type'] == 2)
                                        Part Time
                                        @elseif($job['employment_type'] == 3)
                                        Contract
                                        @elseif($job['employment_type'] == 4)
                                        Internship
                                        @elseif($job['employment_type'] == 5)
                                        Self-Employed
                                        @elseif($job['employment_type'] == 6)
                                        Others
                                        @endif
                                    </td>
                                    <td>{{$job['country']['name']}}</td>
                                    <td>{{$job['state']['name']}}</td>
                                    <td>{{$job['city']}}</td>
                                    <td>{{date('Y-m-d',strtotime($job['start_date']))}}</td>
                                    <td>{{date('Y-m-d',strtotime($job['end_date']))}}</td>
                                    <td>
                                    <?php if($job['status'] == 1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>    
                                    </td>
                                    <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                            <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                @if($job['status'] == 1)
                                                <a class="dropdown-item status" href="javascript:void(0);"   data-id="{{$job['id']}}" data-val="{{$job['status']}}">Inactive</a>
                                                @else
                                                <a class="dropdown-item status" href="javascript:void(0);"  data-id="{{$job['id']}}" data-val="{{$job['status']}}">Active</a>    
                                                @endif
                                                <li><a class="dropdown-item" href="{{url('admin/job-edit/'.encrypt($job['id']))}}">Edit</a></li>
                                                <li><a class="dropdown-item" href="{{url('admin/job-view/'.encrypt($job['id']))}}">View</a></li>
                                                <li><a class="dropdown-item" href="{{url('admin/users-applied/'.encrypt($job['id']))}}">User Applied</a></li>
                                                <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#job-{{$job['id']}}">Delete</p></a></li>
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
                    {{ $jobs->appends(request()->query())->links() }}
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
@foreach($jobs as $job)
    @include('layouts._partials.confirmation-popup', ['resource'=>$job, 'resourceName'=> 'job', 'heading'=>'Job'])
@endforeach

@endsection

