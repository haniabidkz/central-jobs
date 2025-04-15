@extends('layouts.app_after_login_layout')
@section('content')

    <!--Job Advertisment Section-->
    <section class="job-advertisment-block">
        <div class="container">
           <h2 class="text-center hdr-title">HOW WOULD YOU LIKE TO POST IT?</h2>
           <div class="job-post-block">

              <div class="payment-block">
                 <div class="payment-block-top">
                    <div class="top-left">
                       <h3>FREE!</h3>
                       <p>Unlimited posts for free!</p>
                    </div>
                    <div class="top-right">
                       <div class="post-dispaly-innr">
                          <div class="post-item">
                             <h5 class="job-title">Analyst</h5>
                             <p class="company-name">Tech Europe Bank</p>
                             <div class="ftr-items">
                                <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                             </div>
                          </div>
                          <div class="post-item">
                             <h5 class="job-title">Project Manager</h5>
                             <p class="company-name">Tech Europe Bank</p>
                             <div class="ftr-items">
                                <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="payment-block-bottom">
                    <a href="{{url('company/payment-details/'.base64_encode(0).'')}}" class="btn-select">Select here</a>
                 </div>
              </div>

            @if (count($plans)>0)
                @foreach ($plans as $plan)
                    <div class="payment-block">
                        <div class="payment-block-top">
                            <div class="top-left">
                            <h3>HIGHLIGHT YOUR </h3>
                            <h3>POST!</h3>
                            <p>Only € {{$plan->value}} per post.</p>
                            <h6>DRAW MORE ATTENTION TO YOUR COMPANY!</h6>
                            </div>
                            <div class="top-right">
                            <div class="post-dispaly-innr">
                                <div class="post-item highlighted">
                                    <span class="premium-logo"><img src="{{asset('frontend/images/premium.svg')}}" /></span>
                                    <h5 class="job-title">Analyst</h5>
                                    <p class="company-name">Tech Europe Bank</p>
                                    <div class="ftr-items">
                                        <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                                    </div>
                                </div>
                                <div class="post-item highlighted">
                                    <span class="premium-logo"><img src="{{asset('frontend/images/premium.svg')}}" /></span>
                                    <h5 class="job-title">Project Manager</h5>
                                    <p class="company-name">Tech Europe Bank</p>
                                    <div class="ftr-items">
                                        <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="payment-block-bottom">
                            <a href="{{url('company/payment-details/'.base64_encode($plan->id).'')}}" class="btn-select">Select here</a>
                            <p>For future posts you still have the option to choose it for free!</p>
                        </div>
                    </div>
                @endforeach
            @endif
              
           </div>
        </div>
      </section>
      <!--/Job Advertisment Section-->
@endsection