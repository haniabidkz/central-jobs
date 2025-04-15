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
                <h1>Job list</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Job List</li>
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
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/job-list')}}" method="get" id="job-search">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Start Date:</label>
                                    <input type="text" class="form-control" placeholder="Start Date" id="start_date" name="start_date" autocomplete="off" value="{{@$search['start_date']}}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">End Date:</label>
                                    <input type="text" class="form-control" placeholder="End Date" id="end_date" name="end_date" autocomplete="off" value="{{@$search['end_date']}}">
                                    <label class="error error-end-date" style="display:none;"></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Title:</label>
                                    <input type="text" class="form-control" placeholder="Job Title" id="title" name="title" value="{{@$search['title']}}">
                                </div>
                            </div>
                            <?php $reset  = app('request')->input('reset'); ?>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                <label for="usr">Country:</label>  
                                <input type ="hidden" value="<?php if(@$search['cntrId'] != ''){ echo @$search['cntrId'];}?>" id="cntrId" name="cntrId"/>
                                <input class="form-control" id="country_id" name="country" type="text" value="<?php if(@$search['country'] != ''){ echo @$search['country'];}?>" placeholder="Country"/>
                                <span id="errCountryId" class="error"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">State:</label> 
                                    <select class="form-control" name="state" id="state_id">
                                        <option value="">Select State</option>
                                        @if(count($states) > 0)
                                        @foreach($states as $key=>$val)
                                        <option value="{{$val['id']}}" <?php if($val['id'] == @$search['state']) echo 'selected'; ?>>{{$val['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Job Id:</label>
                                    <input type="text" class="form-control" placeholder="Job ID" name="job_id" id="job_id" value="{{@$search['job_id']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Status:</label> 
                                    <select class="form-control" name="status" id="status">
                                        <option value=""> Status</option>
                                        <option value="1" <?php if(@$search['status'] == 1){ echo 'selected';}?>>Ongoing</option>
                                        <option value="2" <?php if(@$search['status'] == 2){ echo 'selected';}?>>Closed</option>
                                        <option value="3" <?php if(@$search['status'] == 3){ echo 'selected';}?>>Pending Publication</option>
                                    </select>
                                    <label class="error error-required-search" style="display:none;"></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Company Name:</label>
                                    <input class="form-control" type="text" name="company_name" id="company_name" placeholder="Company Name" value="{{@$search['company_name']}}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                    <?php if(!empty(@$search)){?>
                                        <a class="btn btn-info" href="{{url('admin/job-list?reset=1')}}" title="Back"> Reset</a> 
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    @if(count($jobs) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>JobId</th>
                                        <th>Company</th>
                                        <th>Title</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Position</th>
                                        <th>Type</th>
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
                                        <td>{{$job['job_id']}}</td>
                                        <td>{{$job['user']['company_name']}}</td>
                                        <td>{{$job['title']}}</td>
                                        <td>{{$job['country']['name']}}</td>
                                        <td><?php if(count($job['postState']) > 0){ echo $job['postState'][0]['state']['name'];}?></td>
                                        <td><?php if($job['city'] != ''){ $cityArr = explode(",",$job['city']); echo $cityArr[0];}?> </td>
                                        <td>
                                            
                                            @if(count($job['cmsBasicInfo']) > 1)
                                                @foreach($job['cmsBasicInfo'] as $key=>$val)
                                                    @if($val['type'] == 'seniority')
                                                        echo $val['masterInfo']['name'];
                                                    @endif
                                                @endforeach
                                            @endif
                                        
                                        </td>
                                        <td>
                                        <?php 
                                            if($job['cmsBasicInfo']){ 
                                                foreach($job['cmsBasicInfo'] as $key=>$val){
                                                    if($val['type'] == 'employment_type'){
                                                        echo $val['masterInfo']['name'];
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{date('Y-m-d',strtotime($job['start_date']))}}</td>
                                        <td>{{date('Y-m-d',strtotime($job['end_date']))}}</td>
                                        <td>
                                        <?php if($job['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions </button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($job['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inctive"  data-id="{{$job['id']}}" data-val="{{$job['status']}}">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$job['id']}}" data-val="{{$job['status']}}">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/job-view/'.encrypt($job['id']))}}">View</a></li>
                                                    <!-- <li><a class="dropdown-item" href="{{url('admin/job-edit/'.encrypt($job['id']))}}">Edit</a></li> -->
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
<script>

$(document).ready(function() {
   $( "#start_date" ).datepicker({
         dateFormat: "yy-mm-dd",
         //maxDate: '0',
         onSelect: function(selected) {
         $("#end_date").datepicker("option","minDate", selected)
      }
   });
      
   $('#end_date').datepicker({
         dateFormat: "yy-mm-dd",
         //maxDate: '0',
         onSelect: function(selected) {
         $("#start_date").datepicker("option","maxDate", selected)
         }
   });
});
</script>
@endsection

