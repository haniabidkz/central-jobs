@extends('layouts.admin')
@section('content')
<script type="text/javascript">
   const countryList = '';
</script>
<script src="{{asset('pages/admin/candidate/list.js')}}"></script>
<script type="text/javascript">
   Post.changeStatus();
   Post.List();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>View Candidate Details</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{url('admin/candidate-list')}}">Candidate List</a></li>
               <li class="breadcrumb-item active">Candidate Details</li>
            </ol>
         </div>
      </div>
      <div class="row mb-2">
         <div class="col-sm-12">
            <?php if($details['status'] == 1){?>
            <button type="button" class="btn btn-danger opnBlkModal" data-id="{{$details['id']}}">Inactive</button>
            <?php }else{?>
            <button type="button" class="btn btn-info ml-3 status" data-id="{{$details['id']}}" data-val="1">Active</button>
            <?php }?>
            <div class="float-sm-right">
               <a class="btn btn-info" href="{{url('admin/candidate-list')}}" title="Back to List"> Back </a>
            </div>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
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
                  <h3 class="card-title">Candidate Details</h3>
               </div>
               <div class="card-body ">
                  <div class="myprofile-holder">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="total-title"> Personal Info </h5>
                        </div>
                        <div class="col-md-6">
                            <p>Name : <b>{{base64_decode($details['first_name']).' '.$details['last_name']}}</b></p>
                        </div>
                        <div class="col-md-6">
                            <p>Profile Headline : <b>{{$details['profile']['profile_headline']}}</b></p>
                        </div>
                        <div class="col-md-6">
                            <p>Email : <b>{{base64_decode($details['email'])}}</b></p>
                        </div>
                        <!-- <div class="col-md-6">
                            <p>Address Line1 : <b> @if($details['address1'] != '') {{$details['address1']}} @else N/A @endif </b></p>
                        </div>
                        <div class="col-md-6">
                            <p>Address Line2 : <b> @if($details['address2'] != '') {{$details['address2']}} @else N/A @endif</b></p>
                        </div> -->
                        <div class="col-md-6">
                            <p>Country : <b> @if($details['country']['name'] != '') {{$details['country']['name']}} @else N/A @endif</b></p>
                        </div>
                        <div class="col-md-6">
                            <p>State : <b> @if($details['state']['name'] != '') {{$details['state']['name']}} @else N/A @endif </b></p>
                        </div>
                        <div class="col-md-6">
                            <p>City : <b> @if($details['city_id'] != '') {{$details['city_id']}} @else N/A @endif </b></p>
                        </div>
                        <!-- <div class="col-md-6">
                            <p>Zip Code : <b> @if($details['postal'] != '') {{$details['postal']}} @else N/A @endif</b></p>
                        </div> -->
                        <div class="col-md-6">
                            <p>Status : <b> @if($details['status'] == 1) Active @elseif($details['status'] == 2) Deactivated @else Inactive @endif</b></p>
                        </div>
                        <?php if($details['status'] == 0){?>
                        <div class="col-md-6">
                            <p>Reason : <b> {{$details['block_reason']}}</b></p>
                        </div>
                        <?php }?>

                      </div>
                   </div>
                   <div class="myprofile-holder">
                      <div class="row">    

                        <!---   START COMPANY DETAILS   ------>
                        <div class="col-md-12">
                            <h5 class="total-title">Company Details</h5>
                        </div>
                        <?php if(!empty($details['professionalInfo'])){ 
                            foreach($details['professionalInfo'] as $key=>$value){
                            ?>
                        <div class="col-md-6">
                            <p>Title :
                            <b>{{($value['title']?$value['title']:'')}}</b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Type of Employment :<b>
                            <?php if($value['type_of_employment'] == 1){?>
                            Full Time
                            <?php }else if($value['type_of_employment'] == 2){?>
                            Part Time
                            <?php }else if($value['type_of_employment'] == 3){?>
                            Contract
                            <?php }else if($value['type_of_employment'] == 4){?>
                            Internship
                            <?php }else if($value['type_of_employment'] == 5){?>
                            Self-Employed
                            <?php }?></b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Company Name :
                            <b>{{($value['company_name']?$value['company_name']:'')}}</b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Currently Working Here :
                            <b><?php if($value['currently_working_here'] == 1){?>
                            Yes
                            <?php }else{?>
                            No
                            <?php }?></b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Start Date :
                            <b>{{($value['start_date']?date('Y-m-d',strtotime($value['start_date'])):'')}}</b>
                            </p>
                        </div>
                        <!-- if  Currently Working Here no this shuld be show -->
                        <div class="col-md-6">
                            <p>End Date :
                            <b>{{($value['end_date']?date('Y-m-d',strtotime($value['end_date'])):'')}}</b>
                            </p>
                        </div>
                        <?php } }?>


                      </div>
                   </div>
                   <!---   END COMPANY DETAILS   ------>
                    <!---   START EDUCATION DETAILS   ------>
                   <div class="myprofile-holder">
                      <div class="row">  
                        <div class="col-md-12">
                            <h5 class="total-title">Educational Details</h5>
                        </div>
                        <?php if(!empty($details['educationalInfo'])){ 
                            foreach($details['educationalInfo'] as $key=>$value){
                            ?>
                        <div class="col-md-6">
                            <p>School :
                            <b>{{($value['school_name']?$value['school_name']:'')}}</b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Degree :
                            <b>{{($value['degree']?$value['degree']:'')}}</b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Field of study :
                            <b>{{($value['subject']?$value['subject']:'')}}</b>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>Start Year :
                            <b>{{($value['start_year']?$value['start_year']:'')}}</b>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p>End Year :
                            <b>{{($value['end_year']?$value['end_year']:'')}}</b>
                            </p>
                        </div>
                        <?php }} ?> 

                        </div>
                   </div>
                   <!---   END EDUCATION DETAILS   ------>
                   <div class="myprofile-holder">
                      <div class="row"> 
                        
                        <!---   START LANGUAGE DETAILS   ------>
                        <div class="col-md-12">
                            <h5 class="total-title">Language Details</h5>
                        </div>
                        <div class="col-md-6">
                            <?php if(!empty($details['cmsBasicInfo'])){
                            foreach($details['cmsBasicInfo'] as $key=>$lang){
                                if($lang['language'] != null){
                            ?>
                            <div class="col-md-6">
                            <p>Language:
                                <b>{{$lang['language']['name']}}</b>
                            </p>
                            <p>Proficiency Level:
                                <b>{{($lang['language']['fluency']['fluencyLabel']['name']?$lang['language']['fluency']['fluencyLabel']['name']:'')}}</b>
                            </p>
                            </div>
                            <?php } } }?>
                        </div>

                        </div>
                   </div>
                   <!----   END LANGUAGE DETAILS   ------>
                   <!----   START SKILL DETAILS   ------>
                   <div class="myprofile-holder">
                      <div class="row"> 
                        
                        <div class="col-md-12">
                            <h5 class="total-title">Skill</h5>
                        </div>
                        <div class="col-md-12">
                            <p>Skill : <b> <?php if(!empty($details['selectedSkill'])){ 
                            $endVal = count($details['selectedSkill']);
                            $i=0;
                            foreach($details['selectedSkill'] as $key=>$val){ 
                            $i++;
                            echo $val['skill']['name'];
                            if($i < $endVal){
                                echo ', ';
                            }
                            } }?></b>
                            </p>
                        </div>

                      </div>
                   </div>
                   <!----   END SKILL DETAILS   ------>
                   <!----   START HOBBY DETAILS   ------>
                   <div class="myprofile-holder">
                      <div class="row"> 
                        <div class="col-md-12">
                            <h5 class="total-title">Hobby</h5>
                        </div>
                        <div class="col-md-12">
                            <p>Hobby : <b>
                            <?php if(!empty($details['cmsBasicInfo'])){
                                foreach($details['cmsBasicInfo'] as $key=>$lang){
                                    if($lang['hobby'] != null){
                                        echo $lang['hobby']['name'].' ';
                                } } }?></b>
                            </p>
                        </div>

                      </div>
                   </div>
                      <!----   END HOBBY DETAILS   ------>
                      <!----   START CV SUMMARY DETAILS   ------>
                   <div class="myprofile-holder">
                      <div class="row"> 
                        
                        <div class="col-md-12">
                            <h5 class="total-title">Resume </h5>
                            <p>Cv Summary : 
                            <b> @if($details['profile']['cv_summary'] != '') {{$details['profile']['cv_summary']}} @else N/A @endif</b>
                            </p>
                        </div>
                        
                        <!-- <div class="col-md-12">
                            <p>Uploaded cv : </p>   
                            <div class="cv-holder">
                            @if(!empty($details['uploadedCV']))
                            <a class="uploadprofile-new" href="{{asset($details['uploadedCV']['location'])}}" download>
                                <?php
                                    // $filename = explode('.',$details['uploadedCV']['name']);  
                                    // $fileType = $filename[(count($filename)-1)];
                                    ?>
                                <?php //if($fileType == 'pdf'){ ?>
                                <img src="<?php// echo url('/');?>/frontend/images/pdf-img.png" alt="{{$details['uploadedCV']['name']}}" class="cv">
                                <?php// }else{ ?>
                                <img src="<?php// echo url('/');?>/frontend/images/doc-img.png" alt="{{$details['uploadedCV']['name']}}" class="cv">
                                <?php //} ?>
                               
                            </a>
                            @else
                            
                            <img src="<?php  //echo url('/');?>/frontend/images/document.png" alt="" class="cv">
                            @endif
                            </div>
                        </div> -->

                     </div>
                   </div>
                      <!----   END CV DETAILS   ------>
                        <!----   START VIDEO DETAILS   ------>
                   <div class="myprofile-holder">
                      <div class="row"> 
                        
                        <div class="col-md-12">
                            <h5 class="total-title">Intro Video</h5>
                            <div class="intro-video">
                            <video   controls class="video-js vjs-default-skin" >
                                @if(!empty($details['introVideo']))
                                <source src="{{asset($details['introVideo']['location'])}}" type="video/mp4">
                                @else
                                <source src="<?php echo url('/');?>/frontend/images/video.mp4" type="video/mp4">
                                @endif
                            </video>
                            </div>
                        </div>
                        <!----   END VIDEO DETAILS   ------>
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
<div id="blkModal" class="modal fade custom-modal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">&times;</button>
            <h4 class="modal-title">Candidate Block Reason</h4>
         </div>
         <div class="modal-body">
            <div class="col-md-12">
               <form method="post" action="" id="">
                  <div class="form-group">
                     <label for="usr">Block Reason:</label> 
                     <textarea class="form-control" type="text" name="block" id="block" placeholder="Reason of block"></textarea>
                     <input type="hidden" name="id" id="candidate_id" value=""/>
                     <span id="errBlkReason" class="error"></span>
                  </div>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default sbmtBlkCls" data-status="0">Block</button>
         </div>
      </div>
   </div>
</div>
@endsection