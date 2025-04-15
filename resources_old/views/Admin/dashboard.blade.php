@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
               <li class="breadcrumb-item active">Dashboard</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         {{--
         <div class="col-6 col-sm-3 col-md-6 col-xl-3">
            <!-- small box -->
            <div class="small-box bg-site-color dash-box">
               <div class="inner">
                  <h3>150</h3>
                  <p>New Orders</p>
               </div>
               <div class="icon">
                  <i class="ion ion-bag"></i>
               </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
         </div>
         --}}
         <!-- ./col -->
         <div class="col-6 col-sm-3 col-md-6 col-xl-3">
            <!-- small box -->
            <div class="small-box bg-site-color dash-box crce-point" onClick="return window.location.href='company-list'">
               <div class="inner">
                  <h3>{{$totalPendingCompany}}<sup style="font-size: 20px"></sup></h3>
                  <p>Pending Validation</p>
               </div>
               <div class="icon">
                  <i class="fa fa-users"></i>
               </div>
               <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
         </div>
         <!-- ./col -->
         <div class="col-6 col-sm-3 col-md-6 col-xl-3">
            <!-- small box -->
            <div class="small-box bg-site-color dash-box crce-point" onClick="return window.location.href='company-list'">
               <div class="inner">
                  <h3>{{$reportedEmployerCount}}</h3>
                  <p>Reported Employer</p>
               </div>
               <div class="icon">
                  <i class="fa fa-building"></i>
               </div>
               <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
         </div>
         
         <!-- ./col -->
         <div class="col-6 col-sm-3 col-md-6 col-xl-3">
            <!-- small box -->
            <div class="small-box bg-site-color dash-box crce-point" onClick="return window.location.href='reported-post-list'">
               <div class="inner">
                  <h3>{{$totalReportedPostCount}}</h3>
                  <p>Reported Post</p>
               </div>
               <div class="icon">
                  <i class="fa fa-bug"></i>
               </div>
               <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
         </div>
         <!-- ./col -->
         <!-- ./col -->
         <div class="col-6 col-sm-3 col-md-6 col-xl-3">
            <!-- small box -->
            <div class="small-box bg-site-color dash-box crce-point" onClick="return window.location.href='reported-comment-list'">
               <div class="inner">
                  <h3>{{$totalReportedCommentCount}}</h3>
                  <p>Reported Comment</p>
               </div>
               <div class="icon">
                  <i class="fa fa-comments"></i>
               </div>
               <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
         </div>
         <!-- ./col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
   <div class="container-fluid">
      <div class="row ">
         <div class="col-12 col-xl-6">
            <div class="dash-box-base ">
               <div class="row h-100">
                  <div class="col-12 col-sm-4 crce-point" onClick="return window.location.href='candidate-list'">
                     <div class="left-block">
                        <div class="dash-left-info">
                           <div class="dash-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                           <h3><?php echo $totalCandidates;?></h3>
                           <p class="">Candidates</p>
                        </div>
                        <div class="dash-group-info">
                           <div class="group-info blue-bg">Active: <span class="info-val"><?php echo $activeCandidate;?></span></div>
                           <div class="group-info mb-0">Blocked: <span class="info-val"><?php echo $blockedCandidate;?></span></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-8">
                     <div id="chartdiv" class="chart"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-6">
            <div class="dash-box-base ">
               <div class="row h-100">
                  <div class="col-12 col-sm-4 crce-point" onClick="return window.location.href='company-list'">
                     <div class="left-block">
                        <div class="dash-left-info">
                           <div class="dash-icon"><i class="fa fa-building" aria-hidden="true"></i></div>
                           <h3><?php echo $totalCompanies;?></h3>
                           <p class="">Companies</p>
                        </div>
                        <div class="dash-group-info">
                           <div class="group-info blue-bg">Active: <span class="info-val"><?php echo $activeCompany;?></span></div>
                           <div class="group-info mb-0">Blocked: <span class="info-val"><?php echo $blockedCompany;?></span></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-8">
                     <div id="chartdiv1" class="chart"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-6">
            <div class="dash-box-base h-100">
               <div class="row h-100">
                  <div class="col-12 col-sm-4 crce-point" onClick="return window.location.href='job-list'">
                     <div class="left-block">
                        <div class="dash-left-info">
                           <div class="dash-icon"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
                           <h3><?php echo $totalJobs;?></h3>
                           <p class="">Jobs</p>
                        </div>
                        <div class="dash-group-info">
                           <div class="group-info blue-bg">Ongoing: <span class="info-val"><?php echo $ongoingJob;?></span></div>
                           <div class="group-info mb-3">Closed: <span class="info-val"><?php echo $closedJob;?></span></div>
                           <div class="group-info blue-bg scheduled-job">Scheduled: <span class="info-val"><?php echo $scheduledJob;?></span></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-8">
                     <div id="chartdiv2" class="chart"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-6">
            <div class="dash-box-base h-100 d-flex flex-wrap align-items-bottom justify-contents-center">
               <div class="div-chart w-100">
                  <div id="barChart" class="chart"></div>
               </div>
            </div>
         </div>
      </div>
   </div>

</section>
<!-- /.content -->
<!-- Resources -->
<script src="{{asset('backend/dist/js/pie-chart/core.js')}}"></script>
<script src="{{asset('backend/dist/js/pie-chart/charts.js')}}"></script>
<script src="{{asset('backend/dist/js/pie-chart/animated.js')}}"></script>
<script src="{{asset('backend/dist/js/pie-chart/maps.js')}}"></script>
<script src="{{asset('backend/dist/js/pie-chart/kelly.js')}}"></script>
<script type="text/javascript">
   const activeCandidate = <?php echo $activeCandidate; ?>;
   const blockedCandidate = <?php echo $blockedCandidate; ?>;
   const activeCompany = <?php echo $activeCompany; ?>;
   const blockedCompany = <?php echo $blockedCompany; ?>;
   const ongoingJob = <?php echo $ongoingJob; ?>;
   const scheduledJob = <?php echo $scheduledJob; ?>;
   const closedJob = <?php echo $closedJob; ?>;
   const dataChart = <?php echo $dataChart; ?>;
</script>
<script src="{{asset('pages/admin/dashboard.js')}}"></script>
<script type="text/javascript">
   Post.List();
</script>
@endsection