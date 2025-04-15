
@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    const countryList = <?php echo $country_json; ?>;
    const companyList = <?php echo $company_json; ?>;
</script>
<script src="{{asset('pages/admin/candidate/list.js')}}"></script>
<script src="{{asset('pages/admin/common.js')}}"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Candidates</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Candidate List</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/candidate-list')}}" method="get" id="candidate-search">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Name:</label>
                                    <input class="form-control" type="text" name="name" id="name" placeholder="Name" value="{{@$search['name']}}" />
                                    <span id="searchId" class="error"></span>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label for="usr">Email:</label>
                                    <input class="form-control" type="text" name="email" id="email" placeholder="Email" value="{{@$search['email']}}" />
                                    <span id="errId" class="error"></span>
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
                                    <label for="usr">Status:</label> 
                                    <select class="form-control" name="status" id="status">
                                        <option value="">Select Status</option>
                                        <option value="1" <?php if(@$search['status'] == 1) echo 'selected'; ?>>Active</option>
                                        <!-- <option value="2" <?php // if(@$search['status'] == 2) echo 'selected'; ?>>Deactivated</option> -->
                                        <option value="3" <?php if(@$search['status'] == 3) echo 'selected'; ?>>Inactive</option>
                                    </select>
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
                                        <a class="btn btn-info" href="{{url('admin/candidate-list?reset=1')}}" title="Back"> Reset</a> 
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    @if(count($candidates) >0)
                    <!-- /.card-header -->
                    <div class="card-body  overflow-none">
                      <div class="table-responsive"> 
                        <table class="table custom-table" id="candidateList">
                            <thead class="custom-thead">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <!-- <th>City</th> -->
                                    <th>Company</th>
                                    <!-- <th>Total Applied Jobs</th> -->
                                    <th>Highlighted CV</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <?php $lastParam = app('request')->input('page');
                                    if($lastParam == '' || $lastParam == 1){
                                        $i = 0; 
                                    }
                                    else{ 
                                        $i= (($lastParam-1) * env('ADMIN_PAGINATION_LIMIT'));
                                    } ?>
                                @foreach($candidates as $key=>$candidate) 
                                <?php $i++;?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><a href="{{url('candidate/profile/'.$candidate['slug'])}}">
                                    {{$candidate['first_name'].' '.$candidate['last_name']}} 
                                    </a>
                                    </td>
                                    <td>{{$candidate['email']}}</td>
                                    <td>@if(!empty($candidate['country']) && $candidate['country']['name'] != '') {{$candidate['country']['name']}} @else N/A @endif</td>
                                    <td>@if(isset($candidate['state']['name']) && $candidate['state']['name'] != '') {{$candidate['state']['name']}} @else N/A @endif</td>
                                    
                                    <td>@if(!empty($candidate['currentCompany']) && $candidate['currentCompany']['company_name'] != ''){{$candidate['currentCompany']['company_name']}} @else N/A @endif</td>
                                    <!-- <td><a href="{{url('admin/job-list/'.encrypt($candidate['id']))}}">{{count($candidate['appliedJob'])}}</a></td> -->
                                    <td>
                                    <?php if($candidate['highlight_cv']==1){?> Yes <?php }else{ ?> No <?php } ?>
                                    </td>
                                    <td>
                                    <?php if($candidate['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }elseif($candidate['status']==2){?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Deactivated</button> <?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                    </td>
                                    <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                            <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                <li><a class="dropdown-item" href="{{url('admin/view-candidate-details/'.encrypt($candidate['id']))}}">View</a></li>
                                                <li>
                                                @if($candidate['status'] == 1)
                                                <a class="dropdown-item opnBlkModal" href="javascript:void(0);"  data-id="{{$candidate['id']}}">Inactive</a>
                                                @else
                                                <a class="dropdown-item status" href="javascript:void(0);" data-id="{{$candidate['id']}}" data-val="1">Active</a>    
                                                @endif
                                                </li>
                                                <li>
                                                @if($candidate['highlight_cv'] == 1)
                                                    <a class="dropdown-item" href="{{url('admin/highlight/'.$candidate['id'].'/0')}}">Remove Highlight</a>
                                                @else
                                                    <a class="dropdown-item" href="{{url('admin/highlight/'.$candidate['id'].'/1')}}">Highlight CV</a>    
                                                @endif
                                                </li>
                                                <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#candidate-{{$candidate['id']}}">Delete</p></a></li>
                                            </ul>
                                    </div>
                                        
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                    {{ $candidates->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-dark">
                            Sorry! No profile found.
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
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
<!-- /.content -->
@foreach($candidates as $candidate)
    @include('layouts._partials.confirmation-popup', ['resource'=>$candidate, 'resourceName'=> 'candidate', 'heading'=>'Candidate'])
@endforeach
<script type="text/javascript">
    //Post.changeStatus();
    Post.List();
    Common.resetForm('candidate-search');    
</script>
@endsection
