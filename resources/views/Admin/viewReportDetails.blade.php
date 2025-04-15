@extends('layouts.admin')
@section('content')
<style>
.swal-button.swal-button--confirm:not([disabled]):hover{ background-color: #ffc000a6; }
.swal-button.swal-button--cancel:not([disabled]):hover{ background-color: #fbf9f9; }
.swal-button.swal-button--confirm{ background-color : #ffc000; color: #0b0001}
</style>
<script src="{{asset('pages/admin/post.js')}}"></script>
<script type="text/javascript">
    Post.Report();
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Reported Post Details</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/reported-post-list')}}">Reported Post List</a></li>
                    <li class="breadcrumb-item active">Reported Post Details</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-danger abuse ">Abuse</button> 
                <button type="button" class="btn btn-info ignore ml-3">Ignore</button>
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/reported-post-list')}}" title="Back to List"> Back</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
                <!-- left column -->
                <div class="col-12">
                    <!-- general form elements -->
                    <div class="card card-primary report-details-card">
                        <div class="card-header">
                            <h3 class="card-title">Reported Post Details </h3>
                            <!-- <div class="btn-group1 pull-right">
                            
                            </div> -->
                            <input type="hidden" name="post_id" id="post_id" value="{{$details['id']}}"/>
                        </div>

                        <div class="card-body">
                        <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                   <p>Post Type :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                   <p class="discription-p"> 
                                    <?php if($details['category_id'] == 1){ 
                                        echo 'Job';
                                        }else if($details['category_id'] == 2){
                                            echo 'Text';
                                        }else if($details['category_id'] == 3){
                                            echo 'Image';
                                        }else if($details['category_id'] == 4){
                                            echo 'Video';
                                        } 
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                   <p>Post Title :</p> 
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                <p class="discription-p" >{{($details['title']?$details['title']:'N/A')}} </p>
                                </div>
                            </div> 
                            <div class="row">   
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Post Description :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                    <p  class="discription-p" >{{($details['description']?$details['description']:'N/A')}} </p>
                                </div>
                            </div> 
                            <div class="row"> 
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                   <p>Posted By :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                 <p class="discription-p">{{$details['user']['first_name'].' '.$details['user']['last_name']}} </p>
                                </div>                                
                            </div> 
                            <div class="row">    
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Posted On :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                    <p class="discription-p">{{date('Y-m-d H:i a',strtotime($details['created_at']))}} </p>
                                </div>
                            </div> 
                            <div class="row mb-4">     
                                <?php if($details['category_id'] == 3){?>
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Uploaded Image : </p>
                                </div> 
                                <div class="col-12 col-sm-9 col-lg-10">   
                                        <?php if($details['upload']['location']){ ?>
                                        <img src="<?php echo URL::asset($details['upload']['location'].'/'.$details['upload']['name'])?>" class="img-border-rad-5 img-fluid img-thumbnails" height="100" width="100"> <?php }else{ ?> <img src="{{asset('/backend/dist/img/no_avatar.jpg')}}" alr="" height="30" width="30" class="img-border-rad-5"/> <?php } ?> 
                                
                                    </div>
                                </div>    
                                <?php }elseif($details['category_id'] == 4){?>
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Uploaded Video :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                    <div class="video-holder-div">
                                        <video controls>
                                        <source src="<?php echo URL::asset($details['upload']['location'].'/'.$details['upload']['name'])?>">                                           
                                        </video>
                                    </div> 
                                </div>
                                <?php } ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table custom-table" id="candidateList">
                                    <thead class="custom-thead">
                                        <tr>
                                            <th>User Name</th>
                                            <th>User's Current Designation</th>
                                            <th>Reported Comment</th>
                                            <th>User's Profile Image</th>
                                            <th>Report Status</th>
                                            <th>Reported On</th>
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        @foreach($details['report'] as $key=>$value)
                                        <tr>
                                            <td>
                                            {{$value['reporterUser']['first_name'].' '.$value['reporterUser']['last_name']}} 
                                            </td>
                                            <td>{{$value['reporterUser']['profile']['profile_headline']}}</td>
                                            <td> <?php if($value['comment']!=''){?>
                                            {{substr($value['comment'],0,35)}}
                                            <?php if(strlen($value['comment']) > 35){ ?>
                                                <span id="dots_{{$value['id']}}" data-id="{{$value['id']}}">...</span><span id="more_{{$value['id']}}" style="display: none;"> {{substr($value['comment'],35)}}</span>
                                                <a onclick="myFunction('<?php echo $value['id'];?>')" id="myBtn_{{$value['id']}}" data-id="{{$value['id']}}" href="javascript:void(0);">Read more</a>
                                            <?php } }else{ echo 'N/A';}
                                            ?>
                                            </td>
                                            <td><?php if($value['reporterUser']['profileImage']['name']){ ?> <img src="<?php echo URL::asset($value['reporterUser']['profileImage']['location'])?>" alt="" height="100" width="100" class="img-border-rad-5 img-fluid img-thumbnails"/> <?php }else{ ?><img src="{{asset('/backend/dist/img/no_avatar.jpg')}}" alr="" height="30" width="30" class="img-border-rad-5"/><?php } ?></td>
                                            <td>
                                                <?php if($value['status'] == 0){?>
                                                    <button type="button" class="btn order-btn-width btn-success btn-sm disable-cursor">Reported</button>
                                                <?php }elseif($value['status'] == 1){ ?>
                                                    <button type="button" class="btn order-btn-width btn-success btn-sm disable-cursor">Abused</button>
                                                <?php }elseif($value['status'] == 2){?>
                                                    <button type="button" class="btn order-btn-width btn-success btn-sm disable-cursor">Ignored</button>
                                                <?php }
                                                ?>
                                            </td>   
                                            <td>
                                            {{date('Y-m-d H:i a',strtotime($value['created_at']))}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody> 
                                </table>
                            </div>    
                        </div>
                    </div>
                </div>    
            </div> 
        </div>       

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
