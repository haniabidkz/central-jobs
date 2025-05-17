@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    const countryList = <?php echo $country_json; ?>;
    const companyList = <?php echo $company_json; ?>;
</script>
<script src="{{asset('pages/admin/jobList.js')}}"></script>
<script type="text/javascript">
    Post.changeStatus();
    Post.List();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Jobs</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Jobs</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <!-- <div class="float-sm-right">  <a class="btn btn-info" href="{{url('admin/job-add')}}" title="Add"> Add</a> </div> -->
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

                    @if(isset($jobs) && $jobs != NULL && count($jobs) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Name of Company</th>
                                        <th>Position Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($jobs as $job)
                                  
                                    <tr>
                                        <td>{{ $job->user->company_name ?? $job->user->first_name ?? '-' }}
</td>
                                        <td><a href="{{route('detail_job',encrypt($job['id']))}}">{{$job->title}}</a></td>
                                        <td>{{date('Y-m-d',strtotime($job['start_date']))}}</td>
                                        <td>{{date('Y-m-d',strtotime($job['end_date']))}}</td>
                                        <td>
                                            @if($job->job_status == 0)
                                            {{-- Pending --}}
                                            <button type="button" class="btn tbl-btn-block-active btn-warning btn-sm disable-cursor">
                                                Pending
                                            </button>
                                            @elseif($job->job_status == 1)
                                            {{-- Approved/Active --}}
                                            <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">
                                                Active
                                            </button>
                                            @elseif($job->job_status == 2)
                                            {{-- Closed --}}
                                            <button type="button" class="btn tbl-btn-block-active btn-secondary btn-sm disable-cursor">
                                                Closed
                                            </button>
                                            @elseif($job->job_status == 3)
                                            {{-- Rejected --}}
                                            <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">
                                                Rejected
                                            </button>
                                            @endif


                                        </td>
                                        <td>
                                            <!-- Reject Job (POST) -->
                                            <form action="{{ route('accept_job', $job->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to accept this job?');">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                            </form>

                                            <!-- Delete Job (DELETE) -->
                                            <form action="{{ route('reject_job', $job->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to reject this job?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">

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


@endsection