@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Blog list</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Blog List</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right"> <a class="btn btn-info" href="{{url('admin/blogs/add')}}" title="Add"> Add</a> </div>
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>

                    </div>
                    @if(isset($data) && $data != NULL && count($data) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Posted By</th>
                                        <th>Slug</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lastParam = app('request')->input('page');
                                    if ($lastParam == '' || $lastParam == 1) {
                                        $i = 0;
                                    } else {
                                        $i = (($lastParam - 1) * env('ADMIN_PAGINATION_LIMIT'));
                                    } ?>
                                    @foreach($data as $key=>$row)
                                    <?php $i++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>

                                        <td>{{$row->user->getAttributes()['first_name'] ?? '-'}}</td>
                                        <td>{{$row['slug']}}</td>
                                        <td>{{$row['title']}}</td>
                                        <td>{{$row['status']}}</td>
                                        <td>
                                            <a href="{{ url('admin/blogs/edit', $row->id) }}" class="mr-1">Edit</a>

                                            <form action="{{ url('admin/blogs/delete', $row->id) }}" method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline">Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">

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




@endsection