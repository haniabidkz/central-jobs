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
                <h1>Stripe Products List</h1>
            </div>
            <div class="col-sm-6">
                <div class ="breadcrumb float-sm-right">
                    <a href="{{url('/admin/product-add')}}" class="btn btn-default">Create Product</a>
                </div>
                
            </div>
            {{-- <a href="{{url('adimn/product-add')}}" class="btn btn-default">Create Product</a> --}}
        </div>
        
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" id="addSerh">
                    @if(count($plans) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name </th>
                                        <th>Value</th>
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
                                    @foreach($plans as $key => $plan)
                                    
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $plan['name'] }}</td>
                                        <td>€ {{ $plan['amount']/100 }}</td>
                                       
                                        <td>
                                        <?php if($plan['active']==true){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li><a class="dropdown-item" href="{{url('admin/product-list-edit/'.encrypt($plan['id']))}}">Edit</a></li>
                                                    @if ($plan['active'])
                                                        <li><a class="dropdown-item" href="{{url('admin/product-list-edit-active/'.encrypt($plan['id'])."/false")}}">Set as Inactive</a></li>
                                                    @else
                                                        <li><a class="dropdown-item" href="{{url('admin/product-list-edit-active/'.encrypt($plan['id'])."/true")}}">Set as Active</a></li>
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
                    {{-- {{ $plans->appends(request()->query())->links() }} --}}
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
