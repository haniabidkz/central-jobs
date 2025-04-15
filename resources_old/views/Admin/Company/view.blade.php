@extends('layouts.admin')
@section('content')

<script type="text/javascript">
    const countryList = '';
</script>
<script src="{{asset('pages/admin/company/list.js')}}"></script>
<script type="text/javascript">
    //Post.changeStatus();
    //Post.List();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Company Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/company-list')}}">Company List</a></li>
                    <li class="breadcrumb-item active">Company Details</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <?php if(($details['profile']['approve_status'] == 0) || ($details['profile']['approve_status'] == 2)){ ?>
                    <button type="button" class="btn btn-info mr-2 opnMdlCls"  data-id="{{$details['id']}}" data-status="{{$details['profile']['approve_status']}}">Approve</button>
                <?php } ?> 
                <?php if($details['status'] == 1){?>
                    <button type="button" class="btn btn-danger mr-2 opnBlkModal" data-id="{{$details['id']}}">Inactive</button>
                <?php }else{?>
                    <button type="button" class="btn btn-info mr-2 status" data-id="{{$details['id']}}" data-val="1">Active</button>
                <?php }?>
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/company-list')}}" title="Back to List">  Back</a>
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
                            <h3 class="card-title">Company Details</h3>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                 <p>Contact Name : <b>{{$details['first_name']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                 <p>Company Name : <b> {{$details['company_name']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Company Business : <b> {{$details['profile']['business_name']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Company Email : <b> {{$details['email']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Company CNPJ : <b> <?php echo ($details['cnpj']?$details['cnpj']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Phone Number : <b> {{$details['telephone']}}</b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Address Line1 : <b> <?php echo ($details['address1']?$details['address1']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Address Line2 : <b> <?php echo ($details['address2']?$details['address1']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Country : <b> <?php echo ($details['country']['name']?$details['country']['name']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>State : <b> <?php echo ($details['state']['name']?$details['state']['name']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>City : <b> <?php echo ($details['city_id']?$details['city_id']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Zip Code : <b> <?php echo ($details['postal']?$details['postal']:'N/A'); ?></b></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>Approve Status : <b> @if($details['profile']['approve_status'] == 0) Pending @elseif($details['profile']['approve_status'] == 1) Approved @else Rejected @endif </b></p>
                                </div>
                                <?php if($details['profile']['approve_status'] == 2){?>
                                   <div class="col-12 col-md-6">
                                    <p>Reason : <b> {{$details['profile']['reason']}} </b></p>
                                </div> 
                                <?php }?>
                                <div class="col-12 col-md-6">
                                    <p>Status : <b>@if($details['status'] == 0) Inactive @elseif($details['status'] == 2) Deactivated @else Active @endif </b></p>
                                </div>
                                <?php if($details['status'] != 1){?>
                                    <div class="col-12 col-md-6">
                                    <p>Reason : <b> {{$details['block_reason']}}</b></p>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>    
            </div> 
        </div>       

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
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

<div id="blkModal" class="modal fade custom-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">&times;</button>
        <h4 class="modal-title">Company Reports</h4>
      </div>
      <div class="modal-body">
        <p>Employer Name:  <b><span id="cntactCls"></span></b> </p>
        <div class="table-responsive">          
            <table class="table custom-table">
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
        </div>
        <div class="col-md-12">
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
@endsection
