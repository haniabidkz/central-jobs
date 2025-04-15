@extends('layouts.admin')
@section('content')
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
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Page Content Text of <b>{{$details['content_ref']}}</b></h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/page-list')}}">Page List</a></li>
                    <li class="breadcrumb-item"><a href="{{url('admin/page-content-reference/'.encrypt($idRf))}}">Page Content Reference
</a></li>
                    <li class="breadcrumb-item active">Page Content Text</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/page-content-reference/'.encrypt($idRf))}}" title="Back to List">Back</a>
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
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                       
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table" id="candidateList">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Text</th>                               
                                        <th>Language</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    @foreach($textList as $key => $row)
                                
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <?php if($row['text']!=''){?>
                                            {{substr(strip_tags($row['text']),0,150)}}
                                            <?php if(strlen(strip_tags($row['text'])) > 150){ ?>
                                                <span id="dots_{{$row['id']}}" data-id="{{$row['id']}}">...</span><span id="more_{{$row['id']}}" style="display: none;"> {{substr(strip_tags($row['text']),150)}}</span>
                                                <a class="readmore" onclick="myFunction('<?php echo $row['id'];?>')" id="myBtn_{{$row['id']}}" data-id="{{$row['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                        </td>
                                        <td>
                                       {{$row['language_type']}}
                                        </td>     
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">Actions</button>
                                                <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                                    <li><a class="dropdown-item" href="{{url('admin/edit-page-content-text/'.encrypt($row['id']))}}">Edit</a></li>
                                                   
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

                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection

