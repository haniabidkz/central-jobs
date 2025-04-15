@extends('layouts.admin') @section('content')
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
    //Post.add();
</script>
<?php $last = collect(request()->segments())->last() ;?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if(@$details['id'] != '')
                <h1>Post Edit</h1> @elseif($last == 'job')
                <h1>Job Add</h1> @else
                <h1>Post Add</h1> @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/job-list')}}">Job List</a></li>
                    @if(@$details['id'] != '')
                    <li class="breadcrumb-item active">Post Edit</li> @elseif($last == 'job')
                    <li class="breadcrumb-item active">Job Add</li> @else
                    <li class="breadcrumb-item active">Post Add</li> @endif
                    
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="javascript:history.back()" title="Back to List"> Back</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    
        <!-- form start -->
        @if(@$details['id'] != '')
        <form role="form" method="post" id="editJob" action="" enctype="multipart/form-data">
            <input name="id" hidden value="{{@$details['id']}}">
            <input name="category_id" hidden value="{{@$details['category_id']}}">
            <input name="user_id" hidden value="{{@$details['user_id']}}">
             @else
            <form role="form" method="post" id="addPost" action="{{ url('admin/post-add-post') }}" enctype="multipart/form-data">
                <?php  if($last == 'job'){ ?> <input name="category_id" hidden value="1"> <?php }?>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                            <?php  if($last != 'job'){ ?>  
                            <div class="form-group">
                                <label for="title">Please Select Post Type</label>
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="">Select Post Type</option>
                                    <?php foreach($postCategory as $key=>$value){ ?>
                                        <option value="<?php echo $key;?>" <?php if((@$details['category_id']== $key) || ((@$type == 'job') && ($key == 1))){ echo 'selected';}?> ><?php echo $value;?></option>
                                    <?php } ?>
                                </select>
                                @if ($errors->has('category_id'))
                                <span class="error" role="">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span> @endif
                            </div>
                            <?php }?>
                            @endif

                        <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="showJobCls" <?php if((@$details[ 'category_id']==1) || (@$type == 'job')){ ?> style="display:block;"
                            <?php }else{ ?> style="display:none;"
                                <?php } ?>>
                                <div class="card-header">
                                     @if(@$details['id'] != '')
                    <h3 class="card-title">Edit Post</h3> @elseif($last == 'job')
                    <h3 class="card-title">Add Job Post</h3> @else
                    <h3 class="card-title">Add Post</h3> @endif
                                    
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <!-- /.card-body Account Details-->
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Job Title</label>
                                                <input type="text" name="title_job" value="{{@$details['title']}}" class="form-control" id="title_job" placeholder="Job Title"> @if ($errors->has('title_job'))
                                                <span class="error" role="alert">
                                            <strong>{{ $errors->first('title_job') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Job Description</label>
                                                <textarea name="description_job" class="form-control" id="description_job" placeholder="Job Description">{{@$details['description']}}</textarea>
                                                @if ($errors->has('description_job'))
                                                <span class="error" role="alert">
                                        <strong>{{ $errors->first('description_job') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Country</label>
                                                <input type="hidden" value="<?php if(@$details['country']['id'] !=''){ echo @$details['country']['id'];}else{ echo 14;}?>" id="cntrId" name="cntrId" />
                                                <input id="country_id" name="country_id" class="form-control" type="text" value="<?php if(@$details['country']['name'] != ''){ echo @$details['country']['name'];}else{ echo 'Austria';}?>" placeholder="Country Name"/> @if ($errors->has('cntrId'))
                                                <span class="error" role="alert">
                                                    <strong>{{ $errors->first('cntrId') }}</strong>
                                                </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">State</label>
                                                <select class="form-control" name="state_id" id="state_id">
                                                    <option value="">Select State</option>
                                                    @if(count($states) > 0) @foreach($states as $key=>$val)
                                                    <option value="{{$val['id']}}" <?php if($val[ 'id']==@ $details[ 'state'][ 'id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                                    @endforeach @endif
                                                </select>
                                                @if ($errors->has('state_id'))
                                                <span class="error" role="alert">
                                                    <strong>{{ $errors->first('state_id') }}</strong>
                                                </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">City</label>
                                                <input type="text" name="city" value="{{@$details['city']}}" class="form-control" id="city" placeholder="City"> @if ($errors->has('city'))
                                                <span class="error" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Position</label>
                                                <select class="form-control" name="position_for" id="position_for">
                                                    <option value="">Select Position</option>
                                                    <option value="1" <?php if(@$details[ 'position_for']==1 ){ echo 'selected';}?>>Freshers</option>
                                                    <option value="2" <?php if(@$details[ 'position_for']==2 ){ echo 'selected';}?>>Associate</option>
                                                    <option value="3" <?php if(@$details[ 'position_for']==3 ){ echo 'selected';}?>>Mid-Senior level</option>
                                                    <option value="4" <?php if(@$details[ 'position_for']==4 ){ echo 'selected';}?>>Senior Level</option>
                                                    <option value="5" <?php if(@$details[ 'position_for']==5 ){ echo 'selected';}?>>Manager</option>
                                                    <option value="6" <?php if(@$details[ 'position_for']==6 ){ echo 'selected';}?>>Director</option>
                                                    <option value="7" <?php if(@$details[ 'position_for']==7 ){ echo 'selected';}?>>Vice President</option>
                                                    <option value="8" <?php if(@$details[ 'position_for']==8 ){ echo 'selected';}?>>CEO</option>
                                                    <option value="9" <?php if(@$details[ 'position_for']==9 ){ echo 'selected';}?>>Others</option>
                                                </select>
                                                @if ($errors->has('position_for'))
                                                <span class="error" role="alert">
                                        <strong>{{ $errors->first('position_for') }}</strong>
                                    </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Job Type</label>
                                                <select class="form-control" name="employment_type" id="employment_type">
                                                    <option value="">Select Job Type</option>
                                                    <option value="1" <?php if(@$details[ 'employment_type']==1 ){ echo 'selected';}?>>Full Time</option>
                                                    <option value="2" <?php if(@$details[ 'employment_type']==2 ){ echo 'selected';}?>>Part Time</option>
                                                    <option value="3" <?php if(@$details[ 'employment_type']==3 ){ echo 'selected';}?>>Contract</option>
                                                    <option value="4" <?php if(@$details[ 'employment_type']==4 ){ echo 'selected';}?>>Internship</option>
                                                    <option value="5" <?php if(@$details[ 'employment_type']==5 ){ echo 'selected';}?>>Self-Employed</option>
                                                    <option value="6" <?php if(@$details[ 'employment_type']==6 ){ echo 'selected';}?>>Others</option>
                                                </select>
                                                @if ($errors->has('employment_type'))
                                                <span class="error" role="alert">
                                        <strong>{{ $errors->first('employment_type') }}</strong>
                                    </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Language</label>
                                                <input type="text" name="language" value="{{@$details['language']}}" class="form-control" id="language" placeholder="Job Language" autocomplete="off"> @if ($errors->has('language'))
                                                <span class="error" role="alert">
                                            <strong>{{ $errors->first('language') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Skill</label>
                                                <div class="multiple-select"> 
                                                    <select name="skill[]" id="skill" class="js-example-placeholder-multiple  form-control select2Cls" multiple="multiple" data-placeholder="Select Skills">
                                                    <?php foreach($skills as $key=>$value){?>
                                                    <option value="<?php echo $key ;?>" ><?php echo $value;?><option>
                                                    <?php }?>
                                                    </select>
                                                    <span class="addSkill error"></span>
                                                    @if ($errors->has('skill'))
                                                    <span class="error" role="alert">
                                                        <strong>{{ $errors->first('skill') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Start Date</label>
                                                <input type="text" name="start_date" value="<?php if(@$details['start_date'] != null){ echo date('Y-m-d',strtotime(@$details['start_date']));} ?>" class="form-control" id="start_date" placeholder="Start Date" autocomplete="off"> @if ($errors->has('start_date'))
                                                <span class="error" role="alert">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">End Date</label>
                                                <input type="text" name="end_date" value="<?php if(@$details['end_date'] != null){ echo date('Y-m-d',strtotime(@$details['end_date']));} ?>" class="form-control" id="end_date" placeholder="End Date" autocomplete="off"> @if ($errors->has('end_date'))
                                                <span class="error" role="alert">
                                            <strong>{{ $errors->first('end_date') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Applied By</label>
                                                <select class="form-control" name="applied_by" id="applied_by">
                                                    <option value="">Select Type</option>
                                                    <option value="1" <?php if(@$details[ 'applied_by']==1 ){ echo 'selected';}?>>MyHR</option>
                                                    <option value="2" <?php if(@$details[ 'applied_by']==2 ){ echo 'selected';}?>>Company Portal</option>
                                                </select>
                                                @if ($errors->has('applied_by'))
                                                <span class="error" role="alert">
                                        <strong>{{ $errors->first('applied_by') }}</strong>
                                    </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-xl-4 shcls" style="@if(@$details['applied_by'] == 2) display:block @else display:none @endif">
                                            <div class="form-group">
                                                <label for="title">Website url</label>
                                                <input type="text" name="website_link" value="{{@$details['website_link']}}" class="form-control" id="website_link" placeholder="Website Link"> @if ($errors->has('website_link'))
                                                <span class="error" role="alert">
                                            <strong>{{ $errors->first('website_link') }}</strong>
                                        </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-xl-4">
                                            <div class="form-group">
                                                <label for="title">Company Name</label>
                                                <select class="form-control" name="user_id" id="user_id">
                                                    <option value="">Select Company Name</option>
                                                    @if(count($companyList) > 0)
                                                    @foreach($companyList as $key=>$val)
                                                    <option value="{{$val['id']}}" <?php if($val['id'] == @$details['user_id']){ echo 'selected';}?>>{{$val['first_name'].' '.$val['last_name']}}</option>
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
                        </div>

                        <div class="showTextCls" <?php if(@$details['category_id']==2 ){ ?> style="display:block;"
                            <?php }else{ ?> style="display:none;"
                                <?php } ?>>
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Text Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <!-- /.card-body Account Details-->
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title_text" value="{{@$details['title']}}" class="form-control {{ $errors->has('title_text') ? ' is-invalid' : '' }}" id="title" placeholder="Job Title"> @if ($errors->has('title_text'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('title_text') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="meta_title">Description</label>
                                                    <textarea name="description_text" class="form-control {{ $errors->has('description_text') ? ' is-invalid' : '' }}" id="description_text" placeholder="Job Description">{{@$details['description']}}</textarea>
                                                    @if ($errors->has('description_text'))
                                                    <span class="" role="">
                                                        <strong>{{ $errors->first('description_text') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.card-body Account Details-->
                        </div>

                        <div class="showImgtCls" <?php if(@$details[ 'category_id']==3 ){ ?> style="display:block;"
                            <?php }else{ ?> style="display:none;"
                                <?php } ?>>
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Image Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <!-- /.card-body Account Details-->
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title_img" value="{{@$details['title']}}" class="form-control {{ $errors->has('title_img') ? ' is-invalid' : '' }}" id="title" placeholder="Job Title"> @if ($errors->has('title_img'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('title_img') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="meta_desc">Description</label>
                                                    <textarea name="description_img" class="form-control {{ $errors->has('description_img') ? ' is-invalid' : '' }}" id="description_img" placeholder="Job Description">{{@$details['description']}}</textarea>
                                                    @if ($errors->has('description_img'))
                                                    <span class="error" role="">
                                                        <strong>{{ $errors->first('description_img') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="meta_title">Image</label>
                                                    <input type="file" name="image" id="image" class="form-control">
                                                    </br>
                                                    <?php if(@$details['upload']['name'] != ''){ ?>
                                                    <img src="<?php echo URL::asset('/upload/'.@$details['user_id'].'/'.@$details['upload']['name'])?>" class="img-fluid img-thumbnails">
                                                    <?php } ?>
                                                     @if ($errors->has('image'))
                                                    <span class="error" role="">
                                                        <strong>{{ $errors->first('image') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body Account Details-->
                        </div>

                        <div class="showVdotCls" <?php if(@$details[ 'category_id']==4 ){ ?> style="display:block;"
                            <?php }else{ ?> style="display:none;"
                                <?php } ?>>
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Video Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <!-- /.card-body Account Details-->
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title_vdo" value="{{@$details['title']}}" class="form-control {{ $errors->has('title_vdo') ? ' is-invalid' : '' }}" id="title" placeholder="Job Title"> @if ($errors->has('title_vdo'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('title_vdo') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="meta_desc">Description</label>
                                                    <textarea name="description_vdo" class="form-control {{ $errors->has('description_vdo') ? ' is-invalid' : '' }}" id="description_vdo" placeholder="Job Description">{{@$details['description']}}</textarea>
                                                    @if ($errors->has('description_vdo'))
                                                    <span class="error" role="">
                                                        <strong>{{ $errors->first('description_vdo') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="description">Video</label>
                                                    <textarea name="video" id="video" class="form-control">{{@$details['upload']['name']}}</textarea>
                                                    <strong class="descErr"></strong> @if ($errors->has('video'))
                                                    <span class="error" role="">
                                                        <strong>{{ $errors->first('video') }}</strong>
                                                    </span> @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body Account Details-->
                        </div>

                        <!-- /.card -->

                        <!-- general form elements -->
                        @if(@$details['id'] != '')
                            <div class="card-footer">
                                @csrf
                                <button type="button" class="btn btn-primary addClick">Update</button>
                            </div>
                        @else
                            <div class="card-footer">
                                @csrf
                                <button type="button" class="btn btn-primary addClick">Add</button>
                            </div>
                        @endif

                    </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
            </form>
            <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection