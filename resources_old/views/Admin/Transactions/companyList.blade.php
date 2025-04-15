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
                <h1>Company Transaction History</h1>
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
                    @if(count($companies) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name </th>
                                        <th>Email</th>
                                        <th>Company Name</th>
                                        <th>Payment Id</th>
                                        <th>Amount</th>
                                        <th>Balance Transaction</th>
                                        <th>Receipt</th>
                                        <th>Paid At</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $key => $company)
                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ base64_decode($company->user->first_name) }} {{ base64_decode($company->user->last_name) }}</td>
                                        <td>{{ base64_decode($company->user->email) }}</td>
                                        <td>{{ $company->user->company_name }}</td>
                                        <td>{{ $company->payment_id }}</td>
                                        <td>€ {{ number_format($company->amount,'2','.','') }}</td>
                                        <td>{{ $company->balance_transaction }}</td>
                                        <td><a href="{{ $company->receipt_url }}" target="_blank">View Receipt</a></td>
                                        <td>{{ date('d-m-Y : h:i:s',strtotime($company->created_at)) }}</td>
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
                    {{ $companies->links() }}
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