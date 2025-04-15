@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('pages/admin/payment.js')}}"></script>
<script>
    Post.list();
</script>
<script>
function myFunction(id) {
  var dots = document.getElementById("dots_"+id);
  var moreText = document.getElementById("more_"+id);
  var btnText = document.getElementById("myBtn_"+id);

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>
<script>
    function submitForm(action)
    {
        $('#searchId').html('');
        if(action == 'payment-list'){
            //SEARCH FIELD VALIDATION
            var serviceId = $('#service_id').val();
           var serviceName = $.trim($('#subscription_id').val());
           var start = $('#start_date').val();
           var end = $('#end_date').val();
           var status = $('#status').val();
           if(serviceName == '' && start == '' && end== '' && status== '' && serviceId== ''){
                $('#searchId').html('Please enter any search value.');
                return false;
           } else{
                document.getElementById('paymentId').action = action;
                document.getElementById('paymentId').submit();
           }
        }else{
            document.getElementById('paymentId').action = action;
            document.getElementById('paymentId').submit();
        }                
    }
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Download Payment Reports</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active"><a href="{{url('/admin/order-list')}}">Order Management</a> / Download Payment Reports</li>
                </ol>
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
                        <form action="" method="get" id="paymentId">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">From Date:</label>
                                        <input type="text" name="start_date" value="{{@$search['start_date']}}" class="form-control" id="start_date" placeholder="From Date" autocomplete = "off" readonly>
                                        <span class="error" id="searchId"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="title">To Date:</label>
                                        <input type="text" name="end_date" value="{{@$search['end_date']}}" class="form-control" id="end_date" placeholder="To Date" autocomplete = "off" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Subscription Id:</label>
                                        <input class="form-control" type="text" name="subscription_id" id="subscription_id" placeholder="Subscription Id" value="{{@$search['subscription_id']}}" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <label for="usr">Service Name:</label> 
                                        <select class="form-control" name="service_id" id="service_id">
                                            <option value="">Select Service Name</option>
                                            @if(count($serviceList) > 0)
                                            @foreach($serviceList as $key=>$val)
                                            <option value="{{$val['id']}}" <?php if($val['id'] == @$search['service_id']){ echo 'selected';}?>>{{$val['title']}}</option>
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
                                        <option value="1" <?php if(@$search['status'] == 1) echo 'selected'; ?>>Requested</option>
                                        <option value="4" <?php if(@$search['status'] == 4) echo 'selected'; ?>>Pending Payment</option>
                                        <option value="2" <?php if(@$search['status'] == 2) echo 'selected'; ?>>Paid</option>
                                        <option value="3" <?php if(@$search['status'] == 3) echo 'selected'; ?>>Subscription Closed</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="form-group">
                                        <button type="button" id="searchBtn" onclick="submitForm('<?php echo "payment-list";?>')" class="btn btn-default">Search</button>
                                        <?php if(@$search['status'] != '' || @$search['end_date'] != '' || @$search['start_date'] != '' || @$search['subscription_id'] != '' || @$search['service_id'] != ''){?>
                                            <a class="btn btn-info" href="{{url('admin/payment-list')}}" title="Back"> Reset</a> 
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(count($payments) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                          <div class="xlsx-download">  
                              <a class="" onclick="submitForm('<?php echo "payment-details-download";?>')" href="javascript:void(0);">
                                  <img src="{{asset('backend/dist/img/dl-icon.png ')}}" alt="" title="Export to Excel">
                              </a>
                        </div>
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Subscription Id</th>
                                        <th>Subscription Date</th>
                                       <!--  <th>Payment Date</th> -->
                                        <th>Candidate Name</th>
                                        <th>Candidate Email</th>
                                        <th>Service Name</th>
                                        <th>Amount(R$)</th>
                                        <th>Additional Information</th>
                                        <th>status</th>
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
                                    @foreach($payments as $key=>$payment)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{($payment['subscription_code']?$payment['subscription_code']:'N/A')}}</td>
                                        <!-- <td>{{($payment['created_at']?date('Y-m-d',strtotime($payment['created_at'])):'N/A')}}</td> -->
                                        <td>{{($payment['created_at']?date('Y-m-d',strtotime($payment['created_at'])):'N/A')}}</td>
                                        <td><?php if($payment['candidate_name']){?>
                                            {{$payment['candidate_name']}}
                                            <?php }else{?>
                                                N/A
                                            <?php }?>
                                        </td>
                                        <td><?php if($payment['candidate_email'] != ''){ echo $payment['candidate_email']; }else{ echo 'N/A';} ?></td>
                                        <td>{{($payment['subscription_history']['title']?$payment['subscription_history']['title']:'N/A')}}</td>
                                        <td>{{($payment['amount']?$payment['amount']:'N/A')}}</td>
                                        <td>
                                             <?php if($payment['additional_info']!=''){?>
                                            {{substr($payment['additional_info'],0,35)}}
                                            <?php if(strlen($payment['additional_info']) > 35){ ?>
                                                <span id="dots_{{$payment['id']}}" data-id="{{$payment['id']}}">...</span><span id="more_{{$payment['id']}}" style="display: none;"> {{substr($payment['additional_info'],35)}}</span>
                                                <a onclick="myFunction('<?php echo $payment['id'];?>')" id="myBtn_{{$payment['id']}}" data-id="{{$payment['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                        </td>
                                        <td>
                                      <?php $paymentArr = ["Pending Payment","Requested","Paid","Subscription Closed"];?>
                                            <button type="button" class="btn order-btn-width  btn-sm disable-cursor {{($payment['status'] == 3 || $payment['status'] == 2)? 'btn-success':'btn-primary'}}">{{$paymentArr[($payment['status'])]}}</button> 
                                          
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div> 
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                    {{ $payments->appends(request()->query())->links() }}
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

@endsection

