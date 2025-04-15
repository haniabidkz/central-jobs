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
                <h1>View Post Details</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Post Details</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <?php if($details['status'] == 1){?>
                    <button type="button" class="btn btn-danger status" data-id="{{$details['id']}}" data-val="{{$details['status']}}">Inactive</button>
                <?php }else{?>
                    <button type="button" class="btn btn-info ml-3 status" data-id="{{$details['id']}}" data-val="{{$details['status']}}">Active</button>
                <?php }?>
                <div class="float-sm-right">
                    <a class="btn btn-info" href="javascript:history.back()" title="Back to List"> Back</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Post View</h3>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                        @if($details['post_category']['title'] == 'Job')
                            <div class="col-12 col-md-6">
                                <!-- <?php //echo '<pre>'; print_r($details); exit;?> -->
                                <p>Job Title : <b> {{$details['title']}}</b></p>
                            </div>
                            <div class="col-12 col-md-6"> 
                                <p>Position : <b> @if($details['position_for'] == 1)
                                    Freshers
                                    @elseif($details['position_for'] == 2)
                                    Associate
                                    @elseif($details['position_for'] == 3)
                                    Mid-Senior level
                                    @elseif($details['position_for'] == 4)
                                    Senior Level
                                    @elseif($details['position_for'] == 5)
                                    Manager
                                    @elseif($details['position_for'] == 6)
                                    Director
                                    @elseif($job['position_for'] == 7)
                                    Vice President
                                    @elseif($details['position_for'] == 8)
                                    CEO
                                    @elseif($details['position_for'] == 9)
                                    Others
                                    @endif
                                    </b>
                                </p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Job Type : <b> @if($details['employment_type'] == 1)
                                    Full Time
                                    @elseif($details['employment_type'] == 2)
                                    Part Time
                                    @elseif($details['employment_type'] == 3)
                                    Contract
                                    @elseif($details['employment_type'] == 4)
                                    Internship
                                    @elseif($details['employment_type'] == 5)
                                    Self-Employed
                                    @elseif($details['employment_type'] == 6)
                                    Others
                                    @endif 
                                </b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Location : <b> {{$details['country']['name']}},  {{$details['state']['name']}}, {{$details['city']}} </b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Job Start Date : <b> {{date('Y-m-d',strtotime($details['start_date']))}} </b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Job End Date : <b> {{date('Y-m-d', strtotime($details['end_date']))}} </b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Language : <b> {{$details['language']}} </b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Skill : <b> {{$details['skill']}} </b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Applyed By : <b> 
                                @if($details['applyed_by'] == 1)
                                MyHR
                                @elseif($details['applyed_by'] == 2)
                                Company Portal
                                @endif
                                </b></p>
                            </div>
                            @if($details['applyed_by'] == 2)
                            <div class="col-12 col-md-6">
                                <p>Website : <b> {{$details['website_link']}} </b></p>
                            </div>
                            @endif
                            @elseif($details['post_category']['title'] == 'Image')
                            <div class="col-12 col-md-6">
                                <p> Image : <b> <img src="<?php echo URL::asset('/upload/'.@$details['user_id'].'/'.@$details['upload']['name'])?>" class="img-border-rad-5 img-fluid img-thumbnails" height="100" width="100"> </b></p>
                            </div>
                            @elseif($details['post_category']['title'] == 'Video')
                            <div class="col-12 col-md-6">
                                <p>Video : <b> <?php echo $details['upload']['name']; ?></b></p>
                            </div>    
                            @endif
                            <div class="col-12 col-md-6">
                                <p>Description : <b> {{$details['description']}}</b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Posted By : <b> {{$details['user']['first_name'].' '.$details['user']['last_name']}}</b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Posted On : <b> {{date('Y-m-d',strtotime($details['created_at']))}}</b></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>Status : <b> @if($details['status'] == 0) Inactive @else Active @endif </b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>       
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
