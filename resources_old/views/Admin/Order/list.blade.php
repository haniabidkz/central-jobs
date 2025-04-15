@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('pages/admin/order.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    Post.init();   
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Order List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Order List</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('/admin/add-subscription-order')}}" title="Add">Add Subscription Order</a>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" id="addSerh">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/order-list')}}" method="get" >
                            <div class="row">
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Candidate Name</label>
                                        <input type="text" name="candidate_name" value="{{@$search['candidate_name']}}" class="form-control" id="candidate_name" placeholder="Candidate Name" autocomplete = "off">
                                        <span id="searchId" class="error"> </span>
                                    </div>
                                </div> 
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Candidate Email</label>
                                        <input type="text" name="candidate_email" value="{{@$search['candidate_email']}}" class="form-control" id="candidate_email" placeholder="Candidate Email" autocomplete = "off">
                                    </div>
                                </div> 

                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Status:</label> 
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="1" <?php if(@$search['status'] == 1) echo 'selected'; ?>>Requested</option>
                                            <option value="4" <?php if(@$search['status'] == 4) echo 'selected'; ?>>Pending Payment</option>
                                            <option value="2" <?php if(@$search['status'] == 2) echo 'selected'; ?>>Paid</option>
                                            <option value="3" <?php if(@$search['status'] == 3) echo 'selected'; ?>>Subscription Closed</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Proposed  Date From</label>
                                        <input type="text" name="start_date" value="{{@$search['start_date']}}" class="form-control" id="start_date" placeholder="Proposed Date From" autocomplete = "off">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">Proposed Date To</label>
                                        <input type="text" name="end_date" value="{{@$search['end_date']}}" class="form-control" id="end_date" placeholder="Proposed Date To" autocomplete = "off">
                                    </div>
                                </div>
                              
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" id="searchBtn" class="btn btn-default">Search</button>
                                        <?php if(@$search['end_date'] != '' || @$search['start_date'] != '' || @$search['status'] != '' || @$search['candidate_email'] != '' || @$search['candidate_name'] != ''){?>
                                            <a class="btn btn-info" href="{{url('admin/order-list')}}" title="Back"> Reset</a> 
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(count($orders) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Subscription Id</th>
                                        <th>Subscription Date</th>
                                        <th>Candidate Name</th>
                                        <th>Service Name</th>
                                       <!--  <th>Email</th> -->
                                        
                                       <!--  <th>Proposed Date</th> -->
                                        <!-- <th>Additional Info</th> -->
                                        <!-- <th>Created</th> -->
                                        <th>status</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $lastParam = app('request')->input('page');
                                    if($lastParam == '' || $lastParam == 1){
                                        $i = 0; 
                                    }
                                    else{ 
                                        $i= (($lastParam-1) * env('ADMIN_PAGINATION_LIMIT',10));
                                    } ?>
                                    @foreach($orders as $key=>$order)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>
                                            <a style="cursor: pointer;" data-toggle="modal" data-target="#orderDetailsModal-{{$order['id']}}">{{($order['subscription_code'] != NULL)?$order['subscription_code']:'N/A'}}</a>
                                        </td>
                                         <td>{{date('Y-m-d h:i:sa',strtotime($order['created_at']))}}</td>
                                        <td>{{($order['candidate_name'])?$order['candidate_name']:'N/A'}}</td>
                                        <td>{{($order['subscription_history']['title']?$order['subscription_history']['title']:'N/A')}}</td>  
                                       <!--  <td>{{($order['candidate_email'])?$order['candidate_email']:'N/A'}}</td>     -->                          
                                       <!--  <td>{{date('Y-m-d h:i:sa',strtotime($order['service_start_from']))}}</td> -->
                                       <!--  <td>{{($order['additional_info']?substr($order['additional_info'],0,25):'N/A')}}..</td>   -->   
                                        <!-- <td>{{date('Y-m-d h:ia',strtotime($order['created_at']))}}</td> -->                                  
                                        <td>
                                            <?php if($order['status']==1){?> 
                                            <button type="button" class="btn btn-info order-btn-width btn-sm disable-cursor">Requested</button>
                                            <?php }elseif($order['status']==2){ ?> 
                                            <button type="button" class="btn btn-success order-btn-width btn-sm disable-cursor">Paid</button>
                                            <?php }elseif($order['status']==3){ ?> 
                                            <button type="button" class="btn btn-success order-btn-width btn-sm disable-cursor">Subscription Closed</button>
                                            <?php }else{ ?>
                                            <button type="button" class="btn btn-primary order-btn-width btn-sm disable-cursor">Pending Payment</button> 
                                            <?php }?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    @if($order['status'] == 2)
                                                    <li>
                                                        <a class="status dropdown-item" href="javascript:void(0)"  data-id="{{$order['id']}}" data-val="3">Close</a>
                                                    </li> 
                                                    @endif 

                                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#orderDetailsModal-{{$order['id']}}">View</a></li>
                                                    @if($order['status'] == 0)
                                                    <li>
                                                        <a class="status dropdown-item" href="javascript:void(0)"  data-id="{{$order['id']}}" data-val="2">Paid</a>
                                                    </li> 
                                                    <li><a class="dropdown-item" href="{{url('admin/edit-subscription-order/'.encrypt($order['id']))}}">Edit</a></li>
                                                    <li><a  class="dropdown-item delete_item mb-0" data-toggle="modal" data-target="#order-{{$order['id']}}">Delete</a></li>
                                                    @endif 
                                                    @if($order['status'] == 1)
                                                    <li><a class="dropdown-item" href="{{url('admin/edit-subscription-order/'.encrypt($order['id']))}}">Edit</a></li>
                                                    <li><a  class="dropdown-item delete_item mb-0" data-toggle="modal" data-target="#order-{{$order['id']}}">Delete</a></li>
                                                    @endif 
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div>    
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                    {{ $orders->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-dark">
                            Sorry, no data found!
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
@foreach($orders as $order)
    @include('layouts._partials.confirmation-popup', ['resource'=>$order, 'resourceName'=> 'order', 'heading'=>'Service Order'])
@endforeach

<!-- Start Popup details Modal -->
@foreach($orders as $key=>$order)
    <div id="orderDetailsModal-{{$order['id']}}" class="modal fade custom-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-6"><p>Subscription Id: <b>{{($order['subscription_code'] != NULL)?$order['subscription_code']:'N/A'}}</b></p></div>
                        <div class="col-12 col-sm-6"><p>Subscription Date: <b>{{date('Y-m-d h:i:sa',strtotime($order['created_at']))}}</b></p></div>
                        <div class="col-12 col-sm-6"><p>Candidate Name: <b>{{$order['candidate_name']}}</b></p></div>
                        <div class="col-12 col-sm-6"><p>Candidate Email: <b><a href="mailto:{{$order['candidate_email']}}">{{$order['candidate_email']}}</a></b></p></div>
                        <div class="col-12 col-sm-6"><p>Service: <b>{{$order['subscription_history']['title']}}</b> </p></div>
                        <div class="col-12 col-sm-6"><p>Amount: <b>${{$order['amount']}}</b></p></div>
                        <?php if($order['service_start_from'] != NULL){ ?>
                        <div class="col-12 col-sm-6"><p>Proposed Date: <b>{{date('Y-m-d h:ia',strtotime($order['service_start_from']))}}</b> </p></div>
                        <?php } ?>
                        <?php $payment = ["Pending Payment","Requested","Paid","Subscription Closed"]?>
                        <!--     -->
                        <!-- <div class="col-12 col-sm-6"><p>Payment Method: <b>{{$order['payment_method']}}</b></p></div> -->
                        <?php //if($order['status'] == 3){?>
                        <div class="col-12 col-sm-6"><p>Subscriptipn Status: <b>{{$payment[($order['status'])]}}</b> </p></div>
                        <?php //} ?>
                       <!--  <div class="col-12 col-sm-6"><p>Created On: <b>{{date('Y-m-d H:ia',strtotime($order['created_at']))}}</b></p></div> -->
                    </div> 
                    <div class="row">
                        <div class="col-12 col-sm-12"><p>Additional Information: <b><?php echo substr($order['additional_info'],0,250);?><span id="show-hide-{{$key}}" style="display:none;">{{substr($order['additional_info'],250)}}<a href='javascript:void(0);' class="read-less" id="read-less-{{$key}}" data-id={{$key}}> Read Less</a></span> <?php if(strlen($order['additional_info']) > 250){ ?><a href='javascript:void(0);' class="read-more" id="read-more-{{$key}}" data-id={{$key}}>...Read More</a> <?php }?></b> </p></div>
                    </div>                                        
                    <div class="row">
                        <div class="col-md-12 subscription-desc"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- End Popup details Modal -->
<script>
$(document).ready(function() {
 $( ".read-more" ).on( "click", function() {
    var key = $(this).attr("data-id");
    $('#show-hide-'+key).show();
    $('#read-more-'+key).hide();
 });
 $( ".read-less" ).on( "click", function() {
    var key = $(this).attr("data-id");
    $('#show-hide-'+key).hide();
    $('#read-more-'+key).show();
 });
});
</script>

@endsection

