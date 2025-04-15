@extends('layouts.app_after_login_layout')
@section('content')
<main>
   <section class="banner banner-innerpage">
      <div class="bannerimage">
         <img src="{{ asset('frontend/images/blog-banner.jpg')}}" alt="image">
      </div>
      <div class="bennertext">
         <div class="innertitle">
               <div class="container">
                  <div class="row">
                     <div class="col-12 col-sm-12">
                           <h2>Training Details</h2>                
                     </div>
                  </div>
               </div>
         </div>                  
      </div>
   </section>
   <section class="section section-training">
      <div class="container">
         <?php if(!empty($main)){?>
         <div class="row">
               <div class="col-12 d-flex align-items-center">
                  <div class="card max-100">
                     <div class="card-video">
                        <iframe src="https://www.youtube.com/embed/{{$main['youtube_video_key']}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                     </div>   
                     <div class="card-body">
                        <h5 class="card-title"><a href="training-details.html"> {{$main['title']}} </a></h5>
                        <p class="card-text">{{$main['description']}}</p>
                     </div>
                  </div> 
               </div>
         </div>
         <div class="row">    
               <div class="col-12 mt-3"> <h4 class="h3-head">Training Category</h4> </div>
                 <?php if(!empty($training)){ foreach($training as $key=>$val){?>          
               <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-center">
                  <div class="card">
                     <div class="card-video">
                        <iframe src="https://www.youtube.com/embed/{{$val['youtube_video_key']}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" controls="0" allowfullscreen></iframe>
                     </div>   
                     <div class="card-body">
                        <h5 class="card-title"><a href="{{url('training-details/'.encrypt($catid).'/'.encrypt($val['id']))}}"> {{$val['title']}} </a></h5>
                        <p class="card-text">{{$val['description']}}</p>
                     </div>
                  </div> 
               </div> 
             
               <?php } }else{ ?> 
                  <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-center">
                  <p>Sorry! No result found.</p>
               </div>
               <?php }?>

         </div>
            <?php }else{?>
               <div class="col-12">
                  <div class="nodata-found-holder">
                     <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
                     <h4>Sorry! No result found.</h4> 
                  </div>
               </div>
            <?php }?>
      </div>
   </section>
</main>
<!-- main End -->
@endsection