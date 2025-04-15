@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/following.js')}}"></script>
<!-- main -->
<main>
   <section class="section company-page">
      <div class="container">
         <div class="row">
         <input type="hidden" name="page" id="page" value="{{$search['page']}}"/>
          <input type="hidden" name="page_company" id="page_company" value="{{$search['page_company']}}"/>
            <div class="col-12">
               <div class="custom-tab tab-bg-white" id="tab-2">
                  <ul class="nav nav-tabs" id="myTab2" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active show" id="tab-5-tab" data-toggle="tab" href="#tab-5" role="tab" aria-controls="tab-5" aria-selected="true">
                           <span><i class="fa fa-user" aria-hidden="true"></i></span>{{ __('messages.CANDIDATE') }} </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="tab-6-tab" data-toggle="tab" href="#tab-6" role="tab" aria-controls="tab-6" aria-selected="false">
                        <span><i class="fa fa-building" aria-hidden="true"></i></span>{{ __('messages.EMPLOYER') }}</a>
                     </li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane active show" id="tab-5" role="tabpanel" aria-labelledby="tab-5-tab"> 
                        <div class="row mb-2">
                              <div class="col-12">
                              <h3 class="total-title">{{ __('messages.FOLLOWING_CANDIDATE') }} </h3>
                              </div>
                        </div>
                        <div class="row" id="post-data">
                        @include('frontend.candidate.candidateFollowingList')
                        <div class="col-12 ajax-load" style="display:none">
                           <div class="process-comm">
                                 <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                 </div>
                           </div> 
                        </div>
                        </div> 
                     </div>
                     <div class="tab-pane" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
                        <div class="row mb-2">
                              <div class="col-12">
                              <h3 class="total-title">{{ __('messages.FOLLOWING_EMPLOYER') }} </h3>
                              </div>
                        </div>
                        <div class="row" id="post-data-company">
                        @include('frontend.candidate.companyFollowingList')
                               <div class="col-12 ajax-load-company" style="display:none">
                                   <div class="process-comm">
                                        <div class="spinner">
                                           <div class="bounce1"></div>
                                           <div class="bounce2"></div>
                                           <div class="bounce3"></div>
                                        </div>
                                   </div> 
                               </div>
                        </div> 
                     </div> 
                  </div> 
               </div>
            </div>
         </div>                  
      </div>
   </section>
   <!--messages-page end-->
</main>
<!-- main End -->
@endsection