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
                                 <h2>{{ __('messages.TRAINING') }}</h2>                
                           </div>
                        </div>
                     </div>
               </div>                  
            </div>
         </section>
         <section class="section section-training">
            <div class="container">
               <div class="row">
                  <div class="col-12 col-sm-12 col-lg-12 mb-5 pb-3">
                     <h2 class="h3-head ft-big text-center">{{ __('messages.TRAINING_PAGE_HEADLINE') }}</h2>
                     <h2 class="h3-head ft-big text-center">{{ __('messages.TRAINING_PAGE_HEADLINE_2') }}</h2>
                  </div>
 

                  <?php if(!empty($categoryList)){ foreach($categoryList as $key=>$val){?>
                        <div class="col-12 col-md-12 col-lg-6">
                           <div class="media training-listing-holder justify-content-between">
                              <div class="training-icon"><img src="{{ asset('frontend/images/logo.png')}}" alt=""></div>
                              <div class="fvg-logo"> <a href=""> <img src="{{ asset('frontend/images/open_uni.png')}}" alt=""> </a></div>
                              <div class="media-body">
                                 <h4 class="h4-head">{{$val['name']}}</h4>
                                 <p class="mb-0"> <?php echo substr($val['description'],0,80);if(strlen($val['description']) > 80){ echo '...';}?></p>
                              </div> 
                           <a href="{{($val['course_url']?$val['course_url']:'javascript:void(0)')}}" <?php if($val['course_url'] != ''){?>target="_blank"<?php }?> class="btn site-btn">{{ __('messages.CLICK_HERE') }}</a>
                           </div>
                        </div>
               
                  <?php } ?>
                  <!-- <a href="{{$categoryList->previousPageUrl()}}">
                     <
                  </a>
                  @for($i=1;$i<=$categoryList->lastPage();$i++)
                   
                     <a href="{{$categoryList->url($i)}}">{{$i}}</a>
                  @endfor
                  <a href="{{$categoryList->nextPageUrl()}}">
                    >
                  </a> -->
                  {{ $categoryList->links('pagination::bootstrap-4') }}
                  <?php }else if(count($categoryList) == 0){?>
                     <div class="col-12 col-sm-12 col-lg-12">
                           <div class="nodata-found-holder">
                              <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
                              <h4>{{ __('messages.SORRY_NO_RESULT_FOUND') }}</h4> 
                           </div>
                     </div> 
                  <?php }?>
             
               </div>
               

            </div>
         </section>
   </main>
<!-- main End -->
@endsection