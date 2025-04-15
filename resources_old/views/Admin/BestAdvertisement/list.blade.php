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
                <h1>Best Advertisement List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Best Advertisement list</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/best-advertise-add')}}" title="Add"> Add</a>
                </div>
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
                    @if(count($advertises) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Initial Text</th>
                                        <th>Position</th>
                                        <th>Requirment</th>
                                        <th>Ref no</th>
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
                                    @foreach($advertises as $key => $advertise)
                                    
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $advertise['initial_text'] }}</td>
                                        <td>{{ $advertise['position'] }}</td>
                                        <td>{{ $advertise['requirment'] }}</td>
                                        <td>{{ $advertise['ref_no'] }}</td>
                                       
                                        <td>
                                        <?php if($advertise['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($advertise['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inactive"  data-id="{{$advertise['id']}}" data-val="{{$advertise['status']}}">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$advertise['id']}}" data-val="{{$advertise['status']}}">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/best-advertise-edit/'.encrypt($advertise['id']))}}">Edit</a></li>
                                                    <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#best-advertise-{{$advertise['id']}}">Delete</p></a></li>
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
                    {{ $advertises->appends(request()->query())->links() }}
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
@foreach($advertises as $advertise)
    @include('layouts._partials.confirmation-popup', ['resource'=>$advertise, 'resourceName'=> 'best-advertise', 'heading'=>'Best Advertisement'])
@endforeach

@endsection
