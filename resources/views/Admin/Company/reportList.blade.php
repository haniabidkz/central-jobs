@extends('layouts.admin')
@section('content')
<script type="text/javascript">
    Post.changeStatus();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Company Report List</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/company-list')}}">Company List</a></li>
                    <li class="breadcrumb-item active">Company Report List</li>
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
                 
                    @if(count($list) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table custom-table" id="candidateList">
                            <thead class="custom-thead">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    
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
                                @foreach($list as $key=>$val)
                                <?php $i++ ;?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td>{{$val['reporterUser']['first_name']}}</td>
                                    <td>{{$val['comment']}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>    
                        </table>
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                    {{ $list->appends(request()->query())->links() }}
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

