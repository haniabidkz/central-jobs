@extends('layouts.admin') @section('content')
<link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
<script src="{{asset('backend/dist/js/bootstrap-datetimepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('backend/dist/css/bootstrap-datetimepicker.css')}}">
<script src="{{asset('pages/admin/order.js')}}"></script>
<script>  Post.init();</script>
<!-- Content Header (Page header) -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                @if(@$details['id'] != '')
                <h1>Edit Subscription Order</h1> @else
                <h1>Add Subscription Order</h1> @endif
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin/order-list')}}">Order List</a></li>
                    <li class="breadcrumb-item active">
                        @if(@$details['id'] != '')
                        Edit Subscription Order @else
                        Add Subscription Order @endif
                        </li>
                    <!-- <li class="breadcrumb-item active"> @if(@$details['id'] != '') Edit Subscription @else Add Subscription @endif</li> -->
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('/admin/order-list')}}" title="Back to List">Back</a>
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
            <div class="col-12">
                <!-- form start -->
                @if(@$details['id'] != '')
                <form role="form" method="post" id="subscription-form" action="{{ url('admin/update-subscription-info') }}">
                    <input name="id" hidden value="{{@$details['id']}}">
                    @else
                    <form role="form" method="post" id="subscription-form" action="{{ url('admin/store-subscription-info') }}">
                    @endif
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@if(@$details['id'] != '') Edit Subscription Order  @else Add Subscription Order  @endif</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Select Service <span class="" style="color:red;">* </span></label>
                                            <select class="form-control" name="subscription_id" id="subscription_id">
                                                <option value="">Select Service</option>
                                                @if(count($subscriptions) > 0)
                                                @foreach($subscriptions as $key=>$val)
                                                <option value="{{$val['id']}}" <?php if($val['id'] == @$details['subscription_id']){ echo 'selected';}?>>{{$val['title']}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('subscription_id') }}</strong>
                                            </span> 
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Candidate Name <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="candidate_name" value="{{@$details['candidate_name']}}" class="form-control {{ $errors->has('candidate_name') ? ' is-invalid' : '' }}" id="candidate_name" placeholder="Candidate Name"> @if ($errors->has('candidate_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('candidate_name') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>

                                    

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Candidate Email">Candidate's Email ID <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="candidate_email" value="{{@$details['candidate_email']}}" class="form-control {{ $errors->has('candidate_email') ? ' is-invalid' : '' }}" id="candidate_email" placeholder="Candidate Email" <?php if(@$details['candidate_email'] != ''){?> readonly <?php } ?>> @if ($errors->has('candidate_email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('candidate_email') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Amount">Amount to be paid (R$) <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="amount" value="{{@$details['amount']}}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="amount" placeholder="Amount"> @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>

                                    <div class="col-12 proposed-date" <?php if(@$details['subscription_id'] == 3){?> style="display: block;" <?php }else{ ?> style="display: none;" <?php }?>>
                                        <div class="form-group">
                                            <label for="title">Proposed Date-Time</label>
                                            <input type="hidden" id="date_service" value="{{(!empty($details) && isset($details['service_start_from']))? date('Y-m-d H:i:s',strtotime($details['service_start_from'])):''}}"/>
                                            <input autocomplete="off" type="text" id="service_start_from" name="service_start_from" value="<?php if(((!empty($details) && isset($details['service_start_from']))) && (($details['service_start_from'] != '') || ($details['service_start_from'] != NULL))){ echo date('Y-m-d H:i:s',strtotime($details['service_start_from'])); }?>" class="form-control {{ $errors->has('service_start_from') ? ' is-invalid' : '' }}"  placeholder="Proposed Date-Time" readonly> @if ($errors->has('service_start_from'))
                                            
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('service_start_from') }}</strong>
                                            </span> @endif
                                        </div>
                                        <?php if(@$details['status'] == 1){?>
                                        <button type="button" class="btn btn-primary propose_date_1 mb-2" value="{{date('Y-m-d H:i:s',strtotime($details['service_start_from']))}}">{{date('Y-m-d H:i:s',strtotime($details['service_start_from']))}}</button>
                                        <?php if(isset($details['propose_date_2']) && $details['propose_date_2'] != NULL){?>
                                        <button type="button" class="btn btn-primary propose_date_2 mb-2" value="{{date('Y-m-d H:i:s',strtotime($details['propose_date_2']))}}">{{date('Y-m-d H:i:s',strtotime($details['propose_date_2']))}}</button>
                                        <?php }
                                        if(isset($details['propose_date_3']) && $details['propose_date_3'] != NULL){?>
                                        <button type="button" class="btn btn-primary propose_date_3 mb-2" value="{{date('Y-m-d H:i:s',strtotime($details['propose_date_3']))}}">{{date('Y-m-d H:i:s',strtotime($details['propose_date_3']))}}</button>
                                        <?php } }?>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Payment Url <span class="" style="color:red;">* </span></label>
                                            <input type="text" name="payment_url" value="{{@$details['payment_url']}}" class="form-control" id="payment_url" placeholder="Payment Url"> @if ($errors->has('payment_url'))
                                            <span class="error" role="alert">
                                                <strong>{{ $errors->first('payment_url') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Additional Information</label>                                            
                                            <textarea name="additional_info"  class="form-control {{ $errors->has('additional_info') ? ' is-invalid' : '' }}" id="additional_info" placeholder="Additional Information">{{@$details['additional_info']}}</textarea>
                                            @if ($errors->has('additional_info'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('candidate_email') }}</strong>
                                            </span> @endif
                                        </div>
                                    </div>


                                    <!-- <div class="col-12">
                                        <div class="form-group">
                                             <div class="select-newstyle">
                                                <div class="list-inline-item">
                                                    <label class="check-style">
                                                        Order Placed
                                                        <input type="radio" name="status" value="1" <?php if(((@$details['status'] == 1) && (@$details['status'] != '')) || empty(@$details)){ echo 'checked';} ?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="list-inline-item">
                                                    <label class="check-style">
                                                        Inprogress
                                                        <input type="radio" name="status" value="0" <?php if((!empty(@$details)) && (@$details['status'] == 0)){ echo 'checked';} ?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div> 
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- /.card-body Account Details-->
                            <!-- general form elements -->
                            @if(@$details['id'] != '')
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            @else
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                            @endif
                        </div>
                        <!-- /.card -->
                </form>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
<script>
$(document).ready(function() {
 $( ".propose_date_1" ).on( "click", function() {
    var date_1 = $('.propose_date_1').val();
    $('#date_service').val(date_1);
    $('#service_start_from').val(date_1);
 });

 $( ".propose_date_2" ).on( "click", function() {
    var date_2 = $('.propose_date_2').val();
    $('#date_service').val(date_2);
    $('#service_start_from').val(date_2);
 });
 
 $( ".propose_date_3" ).on( "click", function() {
    var date_3 = $('.propose_date_3').val();
    $('#date_service').val(date_3);
    $('#service_start_from').val(date_3);
 });
});
</script>
@endsection