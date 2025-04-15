@extends('layouts.admin')
@section('content')
<script type="text/javascript">
    const countryList = '';
</script>
<script src="{{asset('pages/admin/subscription.js')}}"></script>
<script>
    Post.list();
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>View Subscription Details</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/subscription-list')}}">Service List</a></li>
                    <li class="breadcrumb-item active">Subscription Details</li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <?php if($details['status'] == 1){?>
                    <button type="button" class="btn btn-danger mr-3 status" data-id="{{$details['id']}}" data-val="0">Inactive</button>
                <?php }else{?>
                    <button type="button" class="btn btn-info mr-3 status" data-id="{{$details['id']}}" data-val="1">Active</button>
                <?php }?>
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('admin/subscription-list')}}" title="Back to List"> Back</a>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Subscription Details</h3>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                   <p>Service Name : </p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                   <p class="discription-p">{{$details['title']}} </p>
                               </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Subscription Details :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                   <p class="discription-p"> {{($details['description']?$details['description']:'N/A')}} </p>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Subscription Instruction :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                   <p class="discription-p"> {{($details['instruction']?strip_tags($details['instruction']):'N/A')}} </p>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Subscription Price :</p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                   <p class="discription-p"> ${{($details['price']?$details['price']:'N/A')}} </p>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-2 pr-0">
                                    <p>Status : </p>
                                </div>
                                <div class="col-12 col-sm-9 col-lg-10">
                                <p class="discription-p"> @if($details['status'] == 1) Active @else Inactive @endif </p>
                                </div>
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
