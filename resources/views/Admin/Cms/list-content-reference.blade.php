@extends('layouts.admin')
@section('content')
<script src="{{asset('pages/admin/cms.js')}}"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Page Content Reference of <b>{{$page['page_name']}}</b></h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/page-list')}}">Page List</a></li>
                    <li class="breadcrumb-item active">Page Content Reference</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/add-page-reference')}}/{{$encryptedId}}" title="Add"> Add</a>
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
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <form action="{{url('/admin/page-content-reference')}}/{{$encryptedId}}" id="search-from" method="get">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="usr">Page Reference Name:</label>
                                        <input class="form-control" type="text" name="content_ref" id="content_ref" placeholder="Page Reference Name" value="{{@$search['content_ref']}}" />
                                        <span id="searchId" class="error"></span>
                                    </div>
                                </div>
                            
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="usr">Status:</label> 
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="1" <?php if(@$search['status'] === '1') echo 'selected'; ?>>Active</option>
                                            <option value="2" <?php if(@$search['status'] === '2') echo 'selected'; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" id="searchBtnCont" class="btn btn-default">Search</button>
                                        <?php if((@$search['status'] != '') || (@$search['content_ref'] != '')){?>
                                        <a class="btn btn-info" href="{{url('/admin/page-content-reference')}}/{{$encryptedId}}" title="Reset">Reset</a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(count($pagesContents) >0)
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>                               
                                        <th>Status</th>
                                        <th width="100px">Action</th>
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
                                    @foreach($pagesContents as $key => $row)
                                    <?php $i++ ;?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$row['content_ref']}}</td>
                                        <td>
                                        <?php if($row['status']==1){?> <button type="button" class="btn tbl-btn-block-active btn-success btn-sm disable-cursor">Active</button><?php }else{ ?> <button type="button" class="btn tbl-btn-block-active btn-danger btn-sm disable-cursor">Inactive</button><?php } ?>
                                        </td>     
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li>
                                                    @if($row['status'] == 1)
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Inactive"  data-id="{{$row['id']}}" data-val="0">Inactive</a>
                                                    @else
                                                    <a class="dropdown-item status"  href="javascript:void(0)" title="Active"  data-id="{{$row['id']}}" data-val="1">Active</a>    
                                                    @endif
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{url('admin/update-page-cont-ref/'.encrypt($row['id']))}}">Edit</a></li>
                                                    <li><a class="dropdown-item" href="{{url('admin/get-page-content-text/'.encrypt($row['id']))}}">Text</a></li>
                                                    <!-- <li>
                                                    @if($row['status'] == 1)
                                                    <a class="dropdown-item opnBlkModal" href="javascript:void(0);"  data-id="{{$row['id']}}">Block</a>
                                                    @else
                                                    <a class="dropdown-item status" href="javascript:void(0);" data-id="{{$row['id']}}" data-val="1">Unblock</a>    
                                                    @endif
                                                    </li>
                                                    -->
                                                    {{-- <li><a  href="javascript:void(0);"><p class="dropdown-item delete_item" data-toggle="modal" data-target="#delete-page-ref-{{$row['id']}}">Delete</p></a></li> --}}
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
                    {{-- {{ $pagesContents->appends(request()->query())->links() }} --}}
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-dark">
                            Sorry! No cms content reference found.
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- Modal -->
<div id="myModal" class="modal fade custom-table" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Company Details</h4>
      </div>
      <div class="modal-body cmpDetailCls">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default mr-1 sbmtCls" data-status="1">Approve</button>
        <button type="button" class="btn btn-default sbmtCls" data-status="2">Reject</button>
      </div>
    </div>

  </div>
</div>

<div id="blkModal" class="modal fade custom-table" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Company Reports</h4>
      </div>
      <div class="modal-body">
        <p>Contact Name: <b><span id="cntactCls"></span></b></p>
        <div class="table-responsive">          
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="id_0"></td>
                        <td class="fname_0"></td>
                        <td class="lname_0"></td>
                        <td class="comm_0"></td>
                    </tr>
                    <tr>
                        <td class="id_1"></td>
                        <td class="fname_1"></td>
                        <td class="lname_1"></td>
                        <td class="comm_1"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">
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
@foreach($pagesContents as $pagesContent)
    @include('layouts._partials.confirmation-popup', ['resource'=>$pagesContent, 'resourceName'=> 'delete-page-ref', 'heading'=>'Page Content'])
@endforeach

@endsection

