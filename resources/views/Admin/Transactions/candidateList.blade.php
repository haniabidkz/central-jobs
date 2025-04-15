@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/bestAdvertise.js')}}"></script>
<script>
    Post.edit();
    Post.add();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Candidate Transaction History</h1>
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
                    @if(count($candidates) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name </th>
                                        <th>Email</th>
                                        <th>Subscription Id</th>
                                        <th>Subscribed Plan</th>
                                        <th>Amount</th>
                                        <th>Customer Id</th>
                                        <th>Card Id</th>
                                        <th>Paid At</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidates as $key => $candidate)
                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ base64_decode($candidate->user->first_name) }} {{ base64_decode($candidate->user->last_name) }}</td>
                                        <td>{{ base64_decode($candidate->user->email) }}</td>
                                        <td>{{ $candidate->subscription_id }}</td>
                                        <td>{{ $candidate->plan['name'] }}</td>
                                        <td>€ {{ number_format(($candidate->plan['amount']/100),'2','.','') }}</td>
                                        <td>{{ $candidate->customer_id }}</td>
                                        <td>{{ $candidate->card_id }}</td>
                                        <td>{{ date('d-m-Y : h:i:s',$candidate->plan['created']) }}</td>
                                        {{-- <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li><a class="dropdown-item" href="{{url('admin/payment-cms-edit/'.encrypt($payment['id']))}}">Edit</a></li>
                                                </ul>
                                        </div>
                                        
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div>    
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                    {{ $candidates->links() }}
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-dark">
                            Nothing Found
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
