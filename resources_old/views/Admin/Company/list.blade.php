@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    const countryList = <?php echo $country_json; ?>;
</script>
<script src="{{asset('pages/admin/company/list.js')}}"></script>
<script type="text/javascript">
    //Post.changeStatus();
   // Post.List();
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Companies</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Company List</li>
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
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/company-list')}}" method="get">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Company Name:</label>
                                        <input class="form-control" type="text" name="company_name" id="company_name" placeholder="Company Name" value="{{@$search['company_name']}}" />
                                        <span id="searchId" class="error"></span>
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Contact Name:</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Name" value="{{@$search['name']}}" />
                                        <span id="searchId" class="error"></span>
                                    </div>
                                </div> -->
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Email:</label>
                                        <input class="form-control" type="text" name="email" id="email" placeholder="Email" value="{{@$search['email']}}" />
                                        <span id="errId" class="error"></span>
                                    </div>
                                </div>
                                <?php $reset  = app('request')->input('reset');?>
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
                                        <label for="usr">Approve Status:</label> 
                                        <select class="form-control" name="approve_status" id="approve_status">
                                            <option value="">Select Status</option>
                                            <option value="1" <?php if(@$search['approve_status'] == 1) echo 'selected'; ?>>Approved</option>
                                            <option value="2" <?php if(@$search['approve_status'] == 2) echo 'selected'; ?>>Rejected</option>
                                            <option value="3" <?php if(@$search['approve_status'] == 3) echo 'selected'; ?>>Pending Approval</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                        <?php if(!empty(@$search)){?>
                                        <a class="btn btn-info" href="{{url('admin/company-list?reset=1')}}" title="Back"> Reset</a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(count($companies) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">  
                        <table class="table custom-table" id="candidateList">
                            <thead class="custom-thead">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>CNPJ</th>
                                    <th>Contact Name</th>
                                    <th>Jobs</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>Approval</th>
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
                                @foreach($companies as $key=>$company)
                                 <?php $i++; ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td>
                                    <a class="dropdown-item" href="{{url('company/profile/'.$company['slug'])}}">{{$company['company_name']}} </a>
                                    </td>
                                    <td>{{$company['email']}}</td>
                                    <td><?php echo ($company['cnpj']?$company['cnpj']:'N/A'); ?></td>
                                    <td>{{$company['first_name'].' '.$company['last_name']}} </td>
                                    <td><?php echo count($company['job']); ?></td>
                                    <td><?php if($company['country'] != null){ echo $company['country']['name']; }else{ echo 'N/A'; }?></td>
                                    <td><?php if($company['state'] != null){ echo $company['state']['name']; }else{ echo 'N/A'; } ?></td>
                                    <td>
                                    @if($company['profile']['approve_status'] == 1)
                                    Approved
                                    @elseif($company['profile']['approve_status'] == 2)
                                    Rejected
                                    @else
                                    Pending Approval
                                    @endif
                                    </td>
                                    <td>
                                    <?php if($company['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }elseif($company['status']==2){?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Deactivated</button> <?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions </button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li><a class="dropdown-item" href="{{url('admin/view-company-details/'.encrypt($company['id']))}}">View</a></li>
                                                    <li>
                                                    @if($company['status'] == 1)
                                                    <a class="dropdown-item opnBlkModal" href="javascript:void(0);"  data-id="{{$company['id']}}">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status" href="javascript:void(0);" data-id="{{$company['id']}}" data-val="1">Active</a>    
                                                    @endif
                                                    </li>
                                                    @if($company['profile']['approve_status'] == 0)
                                                    <li><a class="dropdown-item opnMdlCls"  href="javascript:void(0);" data-id="{{$company['id']}}" data-status="{{$company['profile']['approve_status']}}">Approve/Reject</a></li>
                                                    @elseif($company['profile']['approve_status'] == 2)
                                                    <li><a class="dropdown-item opnMdlCls"  href="javascript:void(0);" data-id="{{$company['id']}}" data-status="{{$company['profile']['approve_status']}}">Approve</a></li>
                                                    @endif
                                                    @if($company['profile']['approve_status'] == 1)
                                                    <li><a class="dropdown-item" href="{{url('admin/company-job-list/'.encrypt($company['id']))}}">View Jobs</a></li>
                                                    @endif
                                                    @if($company['profile']['approve_status'] != 1)
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#company-{{$company['id']}}">Delete</p></a></li>
                                                    @endif
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
                    {{ $companies->appends(request()->query())->links() }}
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
<!-- Modal -->
<div id="myModal" class="modal fade custom-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">&times;</button>
        <h4 class="modal-title">Company Details</h4>
      </div>
      <div class="modal-body cmpDetailCls">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default mr-1 sbmtCls" data-status="1">Approve</button>
        <button type="button" class="btn btn-default sbmtCls rejcls" data-status="2">Reject</button>
      </div>
    </div>

  </div>
</div>

<div id="blkModal" class="modal fade blkModal custom-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">&times;</button>
        <h4 class="modal-title">Company Reports</h4>
      </div>
      <div class="modal-body">
        <p>Employer Name: <b><span id="cntactCls"></span></b></p>
        <div class="table-responsive">          
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="rpt-one">
                        <td class="id_0"></td>
                        <td class="fname_0"></td>
                        <td class="comm_0"></td>
                    </tr>
                    <tr class="rpt-two">
                        <td class="id_1"></td>
                        <td class="fname_1"></td>
                        <td class="comm_1"></td>
                    </tr>
                    <tr class="rpt-no-report rpt" style="display:none;">
                        <td colspan="4"> <div class="" style="text-align: center;"> No report found.</div></td>
                    </tr>

                </tbody>
            </table>
            <div class="addViewMore text-right" style="display:none;"></div>
            
        </div>
        <div class="col-12">
        
            <form method="post" action="" id="">
                <div class="form-group">
                    <label for="usr">Block Reason:</label> 
                    <textarea class="form-control" type="text" name="block" id="block" placeholder="Reason of block"></textarea>
                    <input type="hidden" name="id" id="comp_id" value=""/>
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
@foreach($companies as $company)
    @include('layouts._partials.confirmation-popup', ['resource'=>$company, 'resourceName'=> 'company', 'heading'=>'Company'])
@endforeach


@endsection

