@extends('layouts.app_after_login_layout')
@section('content')

    <!--Job Advertisment Section-->
    <section class="job-advertisment-block">
        <div class="container">
            <h2 class="text-center hdr-title">HOW WOULD YOU LIKE TO POST IT?</h2>
            <div class="job-post-block">

                <div class="sngl-job-post">
                    <div class="post-pic-box ds-flex">
                    <h3>FREE!</h3>
                    <p>Unlimited posts for free!</p>
                    </div>
                    <div class="post-display-block">
                    <h3 class="text-center">Candidates will see it like this:</h3>
                    <div class="post-dispaly-innr">
                        <div class="post-item">
                            <span class="company-logo"><img src="{{asset('frontend/images/open_uni.png')}}" /></span>
                            <h5 class="job-title">Teacher IPC</h5>
                            <p class="company-name">NANA NAME</p>
                            <div class="ftr-items">
                                <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                            </div>
                        </div>
                        <div class="post-item">
                            <span class="company-logo"><img src="{{asset('frontend/images/open_uni.png')}}" /></span>
                            <h5 class="job-title">Teacher IPC</h5>
                            <p class="company-name">ANNA FASHION</p>
                            <div class="ftr-items">
                                <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                            </div>
                        </div>
                        <div class="post-item">
                            <span class="company-logo"><img src="{{asset('frontend/images/open_uni.png')}}" /></span>
                            <h5 class="job-title">Teacher IPC</h5>
                            <p class="company-name">CAPITAL NUMBERS</p>
                            <div class="ftr-items">
                                <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="btn-wrap">

                    <a href="{{url('company/payment-details/'.base64_encode(0).'')}}" class="btn-yellow">Free</a>
                    </div>
                </div>

                @if (count($plans)>0)
                    @foreach ($plans as $plan)
                        <div class="sngl-job-post">
                            <div class="post-pic-box">
                            <h3>{{$plan->name}}</h3>
                            <p>Only € {{$plan->value}} per post!</p>
                            <i class="offer-icon"><img src="public/frontend/images/special-offer.svg" alt="" /></i>
                            </div>
                            <div class="post-display-block">
                            <h3 class="text-center">Candidates will see it like this:</h3>
                            <div class="post-dispaly-innr">
                                <div class="post-item highlighted">
                                    <span class="company-logo"><img src="{{asset('frontend/images/open_uni.png')}}" /></span>
                                    <h5 class="job-title">Teacher IPC</h5>
                                    <p class="company-name">NANA NAME</p>
                                    <div class="ftr-items">
                                        <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                                    </div>
                                </div>
                                <div class="post-item highlighted">
                                    <span class="company-logo"><img src="{{asset('frontend/images/open_uni.png')}}" /></span>
                                    <h5 class="job-title">Teacher IPC</h5>
                                    <p class="company-name">ANNA FASHION</p>
                                    <div class="ftr-items">
                                        <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                                    </div>
                                </div>
                                <div class="post-item highlighted">
                                    <span class="company-logo"><img src="{{asset('frontend/images/open_uni.png')}}" /></span>
                                    <h5 class="job-title">Teacher IPC</h5>
                                    <p class="company-name">CAPITAL NUMBERS</p>
                                    <div class="ftr-items">
                                        <p><i class="fa fa-calendar" aria-hidden="true"></i><span>2021-06-24</span></p>
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>Vienna</span></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="btn-wrap">
                            <a href="{{url('company/payment-details/'.base64_encode($plan->id).'')}}" class="btn-yellow">Pay Now</a>
                            <p>
                                Highlight your post and get more<br>
                                attention from candidates!
                            </p>
                            </div>
                        </div>
                    @endforeach
                    
                @endif
                
                
            </div>
        </div>
    </section>
        <!--/Job Advertisment Section-->
@endsection