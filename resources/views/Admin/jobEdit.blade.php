@extends('layouts.admin')
@section('content')
<script type="text/javascript" src="{{ asset('frontend/js/popper.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/BsMultiSelect.js') }}"></script>
<!-- <link rel="stylesheet" href="{{asset('backend/dist/css/jquery.datetimepicker.min.css')}}">
<script src="{{asset('backend/dist/js/jquery.datetimepicker.js')}}"></script> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    const countryList = <?php echo $country_json; ?>;
</script>
<script src="{{asset('pages/admin/job.js')}}"></script>
<script>
        Post.edit();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Job <?php if(@$id){?>Edit<?php }else{ ?>Add<?php }?></h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/job-list')}}">Job List</a></li>
<li class="breadcrumb-item active">Job <?php if(@$id){?>Edit<?php }else{ ?>Add<?php }?></li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="javascript:history.back()" title="Back to List">  Back</a>
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
                <!-- form start -->
                <form role="form" method="post" id="editJob" action="">
                    <input name="id" hidden value="{{@$details['id']}}">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php if(@$id){?>Edit<?php }else{ ?>Add<?php }?> Job Post</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <!-- /.card-body Account Details-->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">Job Title</label>
                                        <input type="text" name="title" value="{{@$details['title']}}"
                                            class="form-control"
                                            id="title" placeholder="Job Title">
                                            @if ($errors->has('title'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div> 
                                
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Country</label>
                                        <input type ="hidden" value="<?php if(@$details['country']['id'] != ''){ echo @$details['country']['id'];}else{ echo 14;}?>" id="cntrId" name="cntrId"/>
                                        <input id="country_id" name="country_id" class="form-control" type="text" value="<?php if(@$details['country']['name'] != ''){ echo @$details['country']['name'];}else{ echo 'Austria';}?>" autocomplete="off"/>
                                        @if ($errors->has('country_id'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('country_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 
                                <?php $stateArr = []; 
                                if(@$details['postState']){ 
                                    foreach(@$details['postState'] as $key=>$val){
                                        array_push($stateArr,$val['state']['id']);
                                    }
                                }
                                ?>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group multiple-select multi-select-states-area">
                                        <label for="title">State</label>
                                        <select name="state_id[]" data-placeholder="State *" id="state_id" class="form-control multi-select-states"  multiple="multiple"  autocomplete="off">
                                            @if(count($states) > 0)
                                            @foreach($states as $key=>$val)
                                            <option value="{{$val['id']}}" <?php if(in_array($val['id'],$stateArr)){ echo 'selected';}?>>{{$val['name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <label class="error error-state" style="display:none;"></label>
                                        @if ($errors->has('state_id'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('state_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 

                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">City</label>
                                        <input type="text" name="city" value="{{@$details['city']}}"
                                            class="form-control"
                                            id="city" placeholder="City">
                                            @if ($errors->has('city'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div> 
                                <?php 
                                $seniority_id = '';
                                if(@$details['cmsBasicInfo']){ 
                                    foreach(@$details['cmsBasicInfo'] as $key=>$val){
                                        if($val['type'] == 'seniority'){
                                            $seniority_id = $val['masterInfo']['id'];
                                        }
                                    }
                                }
                                ?>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Position</label>
                                        <select class="form-control" name="seniority" id="seniority">
                                            <option value="">Seniority Level *</option>
                                            <?php if($seniority){
                                                foreach($seniority as $key=>$val){?>
                                                <option value="{{$val['id']}}" <?php if($seniority_id == $val['id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                            <?php } }?>
                                            <option value="other">Others</option>
                                        </select>
                                        @if ($errors->has('position_for'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('position_for') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-12 col-sm-6 col-xl-4 seniority_other_open" style="display: none;">
                                    <div class="form-group">
                                        <label for="title">Specify Other</label>
                                        <input type="text" class="form-control" placeholder="Specify Other" name="seniority_other" id="seniority_other" autocomplete="off">
                                            @if ($errors->has('seniority_other'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('seniority_other') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div> 
                                <?php 
                                $employment_type_id = '';
                                if(@$details['cmsBasicInfo']){ 
                                    foreach(@$details['cmsBasicInfo'] as $key=>$val){
                                        if($val['type'] == 'employment_type'){
                                            $employment_type_id = $val['masterInfo']['id'];
                                        }
                                    }
                                }
                                ?>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Job Type</label>
                                        <select class="form-control" name="employment" id="employment">
                                            <option value="">Employment Type *</option>
                                            <?php if($employment){
                                                foreach($employment as $key=>$val){?>
                                                <option value="{{$val['id']}}" <?php if($employment_type_id == $val['id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                            <?php } }?>
                                            <option value="other">Others</option>
                                        </select>
                                        @if ($errors->has('employment_type'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('employment_type') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4 employment_other_open" style="display: none;">
                                    <div class="form-group">
                                        <label for="title">Specify Other</label>
                                        <input type="text" class="form-control" placeholder="Specify Other" name="employment_other" id="employment_other" autocomplete="off">
                                            @if ($errors->has('seniority_other'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('seniority_other') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div> 
                                <?php 
                                $language_id = [];
                                if(@$details['cmsBasicInfo']){ 
                                    foreach(@$details['cmsBasicInfo'] as $key=>$val){
                                        if($val['type'] == 'language'){
                                            array_push($language_id,$val['masterInfo']['id']);
                                        }
                                    }
                                }
                                ?>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Language</label>
                                        <select class="form-control js-example-tags" name="language[]" data-placeholder="Language Known" id="language" multiple="multiple" style="display: none;" autocomplete="off">
                                            <?php if(!empty($language)){
                                                foreach($language as $key=>$val){?>
                                                <option value="{{$val['id']}}" <?php if(in_array($val['id'],$language_id)){ echo 'selected';} ?>>{{$val['name']}}</option>
                                            <?php } }?>
                                            <!-- <option value="other">Others</option> -->
                                        </select>
                                            @if ($errors->has('language'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('language') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>
                                <?php 
                                // SKILL SELECTED IN ARRAY
                                $newArr = [];
                                if(@$details['selectedSkill']){
                                    foreach(@$details['selectedSkill'] as $key1=>$val1){
                                        $newArr[$key1] = $val1['skill_id'];
                                    }
                                }
                                
                                ?>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">Skill</label></br>
                                        <div class="multiple-select">
                                            <select name="skill[]" id="skill" class="js-example-placeholder-multiple js-states form-control select2Cls" multiple="multiple" data-placeholder="Select Skills"> 
                                            <?php foreach($skills as $key=>$value){?>
                                            <option value="<?php echo $key ;?>" <?php if(in_array($key,$newArr)){ echo 'selected';} ?> ><?php echo $value;?><option>
                                            <?php }?>
                                            </select>
                                            <span class="addSkill error"></span>
                                            @if ($errors->has('skill'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('skill') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Job Description</label>
                                        <textarea  name="description"
                                            class="form-control"
                                            id="description" placeholder="Job Description">{{@$details['description']}}</textarea>
                                        @if ($errors->has('description'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <?php $screeningArr = []; if(@$details['questions']){ 
                                    foreach(@$details['questions'] as $key=>$val){
                                    if($val['type'] == 1){ 
                                        array_push($screeningArr,$val['question']);
                                 } } } //echo '<pre>'; print_r($screeningArr);?>
                                    
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Screening Questions One</label>
                                        <textarea class="form-control" placeholder="Question 1" name="screening_1">{{@$screeningArr[0]}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Screening Questions Two</label>
                                        <textarea class="form-control" placeholder="Question 2" name="screening_2">{{@$screeningArr[1]}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Screening Questions Three</label>
                                        <textarea class="form-control" placeholder="Question 3" name="screening_3">{{@$screeningArr[2]}}</textarea>
                                    </div>
                                </div>
                                <?php $setting = 0; $interviewArr = []; if(@$details['questions']){ 
                                    foreach(@$details['questions'] as $key=>$val){
                                    if($val['type'] == 2){ 
                                        $setting = $val['mandatory_setting'];
                                        array_push($interviewArr,$val['question']);
                                 } } } //echo '<pre>'; print_r($interviewArr);?>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Interview Questions One</label>
                                        <textarea class="form-control" placeholder="Question 1" name="interview_1" id="interview_1">{{@$interviewArr[0]}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Interview Questions Two</label>
                                        <textarea class="form-control" placeholder="Question 2" name="interview_2" id="interview_2">{{@$interviewArr[1]}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Interview Questions Three</label>
                                        <textarea class="form-control" placeholder="Question 3" name="interview_3" id="interview_3">{{@$interviewArr[2]}}</textarea>
                                    </div>
                                    <label class="error error-interview" style="display:none;"></label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Mandatory Settings</label>
                                        <select class="form-control"  name="mandatory_setting" id="mandatory_setting">
                                            <option value="">Mandatory Settings</option>
                                            <option value="1" <?php if($setting == 1){ echo 'selected';}?>>All are mandatory </option>
                                            <option value="2" <?php if($setting == 2){ echo 'selected';}?>>Any one is mandatory </option>
                                            <option value="3" <?php if($setting == 3){ echo 'selected';}?>>Any two are mandatory</option>
                                            <option value="0" <?php if($setting == 0){ echo 'selected';}?>>None of them are mandatory </option>
                                        </select>
                                    </div>
                                </div>               
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Start Date</label>
                                        <input type="text" name="start_date" value="<?php if(@$details['start_date'] != ''){ echo date('Y-m-d',strtotime(@$details['start_date']));}else{ echo '';}?>"
                                            class="form-control"
                                            id="start_date" placeholder="Start Date" autocomplete="off">
                                            @if ($errors->has('start_date'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">End Date</label>
                                        <input type="text" name="end_date" value="<?php if(@$details['end_date'] != ''){ echo date('Y-m-d',strtotime(@$details['end_date']));}else{ echo '';}?>"
                                            class="form-control"
                                            id="end_date" placeholder="End Date" autocomplete="off">
                                            @if ($errors->has('end_date'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Applied By</label>
                                        <select class="form-control" name="applied_by" id="applied_by">
                                            <option value="">Select Type</option>
                                            <option value="1" <?php if(@$details['applied_by'] == 1){ echo 'selected';}?>>MyHR</option>
                                            <option value="2" <?php if(@$details['applied_by'] == 2){ echo 'selected';}?>>Company Portal</option>
                                        </select>
                                        @if ($errors->has('applied_by'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('applied_by') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <?php if(@$details['applied_by'] == 2){ ?>
                                <div class="col-12 col-sm-6 col-xl-4 shcls" style= "@if(@$details['applied_by'] == 2) display:block @else display:none @endif" >
                                    <div class="form-group">
                                        <label for="title">Website url</label>
                                        <input type="url" name="website_link" value="{{@$details['website_link']}}"
                                            class="form-control"
                                            id="website_link" placeholder="Website Link">
                                            @if ($errors->has('website_link'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('website_link') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>
                            <?php }else{?>
                            <div class="col-12 col-sm-6 col-xl-4 <?php if(@$details['applied_by'] != 2){ echo 'shcls'; }?>" style= "display:none;" >
                                    <div class="form-group">
                                        <label for="title">Website url</label>
                                        <input type="url" name="website_link"
                                            class="form-control"
                                            id="website_link" placeholder="Website Link" value="{{@$details['website_link']}}">
                                            @if ($errors->has('website_link'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('website_link') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>
                            <?php }?>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Company Name</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            <option value="">Select Company Name</option>
                                            @if(count($companyList) > 0)
                                            @foreach($companyList as $key=>$val)
                                            <option value="{{$val['id']}}" <?php if($val['id'] == @$details['user_id']){ echo 'selected';}?>>{{$val['company_name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('user_id'))
                                        <span class="error" role="alert">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>  
                                
                            </div>

                        </div>
                        <!-- /.card-body Account Details-->
                        <div class="card-footer">
                            @csrf
                            <button type="submit" class="btn btn-primary editClick">Update</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<script type="text/javascript">
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".js-example-tags").select2({tags: true,width:'100%'});
          $(document).ready(function() { 
          $( "#seniority" ).on( "change", function() {
               if($('#seniority').val() == 'other'){
                  $('.seniority_other_open').show();
               }else{
                  $('.seniority_other_open').hide();
               }
               
            });
            $( "#employment" ).on( "change", function() {
               if($('#employment').val() == 'other'){
                  $('.employment_other_open').show();
               }else{
                  $('.employment_other_open').hide();
               }
               
            });
          });
      </script>
@endsection
