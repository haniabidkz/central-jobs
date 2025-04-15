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
            <div class="col-sm-6">
                <h1>View Job Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/job-list')}}">Job List</a></li>
                    <li class="breadcrumb-item active">Job Details</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <?php if($details['status'] == 1){?>
                    <button type="button" class="btn btn-danger status" data-id="{{$details['id']}}" data-val="{{$details['status']}}">Inactive</button>
                <?php }else{?>
                    <button type="button" class="btn btn-info mr-3 status" data-id="{{$details['id']}}" data-val="{{$details['status']}}">Active</button>
                <?php }?>
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/job-list')}}" title="Back to List">  Back</a>
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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Job View</h3>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                 <p>Job Title : <b> {{$details['title']}} </b> </p>
                                </div>
                                <div class="col-12 col-md-6"> 
                                <p>Position : <b> <?php 
                                            if($details['cmsBasicInfo']){ 
                                                foreach($details['cmsBasicInfo'] as $key=>$val){
                                                    if($val['type'] == 'seniority'){
                                                        echo $val['masterInfo']['name'];
                                                    }
                                                }
                                            }
                                            ?>
                                  </b> </p>
                                </div>
                                <div class="col-12 col-md-6">
                                <p>Job Type : <b> <?php 
                                            if($details['cmsBasicInfo']){ 
                                                foreach($details['cmsBasicInfo'] as $key=>$val){
                                                    if($val['type'] == 'employment_type'){
                                                        echo $val['masterInfo']['name'];
                                                    }
                                                }
                                            }
                                            ?>
                                 </b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Location : <b> {{$details['country']['name']}},  <?php if(!empty($details['postState'])){ foreach($details['postState'] as $key=>$state){ if($key > 0){ echo ' , ';} echo $state['state']['name'];}}?> , {{$details['city']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Job Start Date : <b> {{date('Y-m-d',strtotime($details['start_date']))}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Job End Date : <b> {{date('Y-m-d',strtotime($details['end_date']))}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Language : <b> <?php $countlang = 0; if($details['cmsBasicInfo']){ $i = 0; foreach($details['cmsBasicInfo'] as $key=>$val){ if($val['type'] == 'language'){ $i++; if($key > 2){ echo ' , '; } echo $val['masterInfo']['name']; $countlang++;} }}if($countlang == 0){echo 'N/A';}?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Skill : <b> <?php $count = count($details['selectedSkill']); if(!empty($details['selectedSkill'])){
                                        $arrSkill = [];
                                        foreach($details['selectedSkill'] as $key=>$value){
                                            $arrSkill[$key] = $value['skill']['name'];
                                        }
                                        end($arrSkill);
                                        $endKey = key($arrSkill);
                                        foreach($arrSkill as $key=>$value){
                                            echo $value;
                                            if($endKey != $key){
                                                echo ' | ';
                                            }
                                        }
                                    }if($count == 0){ echo 'N/A';}?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Specific Question: </br><?php $serial = 0; if($details['questions']){ 
                                            foreach($details['questions'] as $key=>$val){
                                            if($val['type'] == 1){ $serial++?>
                                        <b>{{$serial}}. {{$val['question']}}</b></br>
                                        <?php } } }if($serial == 0){?>
                                            <b class="h5-title">N/A</b>
                                        <?php }?></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Interview questions: </br><?php $serial1 = 0; if($details['questions']){ 
                                        foreach($details['questions'] as $key=>$val){
                                        if($val['type'] == 2){ $serial1++?>
                                    <b>{{$serial1}}. {{$val['question']}}</b></br>
                                    <?php } } }if($serial1 == 0){?>
                                        <b>N/A</b>
                                    <?php }?></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Description : <b>{{$details['description']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Applied By : <b>  
                                    @if($details['applied_by'] == 1)
                                    Meu RH
                                    @elseif($details['applied_by'] == 2)
                                    Company Portal
                                    @endif
                                    </b></p>
                                </div>
                                @if($details['applied_by'] == 2)
                                <div class="col-12 col-md-6">
                                    <p>Website : <b> {{$details['website_link']}} </b></p>
                                </div>
                                @endif
                                <div class="col-12 col-md-6">
                                    <p>Status : <b> @if($details['status'] == 0) Inactive @else Active @endif </b> </p>
                                </div>
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
