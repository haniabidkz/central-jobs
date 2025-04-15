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
                        <a href="{{ url('company/payment-details/' . base64_encode(0) . '') }}" class="btn-select">Select
                            here</a>
                    </div>
                </div>
<!-- to hide -->
                @if (1 !=1 ) 
                    @foreach ($plans as $plan)
                        <form name="post_payment_job" id="post_payment_job"
                            action="{{ url('company/payment-details/' . base64_encode($plan->id) . '') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="postId" id="postId" value="{{ $postID }}" />
                            <div class="payment-block">
                                <div class="payment-block-top">
                                    <div class="top-left">
                                        {{-- <h3>HIGHLIGHT YOUR </h3>
                            <h3>POST!</h3>
                            <p>Only € {{$plan->value}} per post.</p>
                            <h6>DRAW MORE ATTENTION TO YOUR COMPANY!</h6> --}}
                                        <h3>Heben Sie Ihr Stellenangebot hervor!</h3>
                                        <p>Nur €30 pro Anzeige</p>
                                        <h6>Stellen Sie bessere Mitarbeiter schneller ein!</h6>
                                    </div>
                                    <div class="top-right">
                                        <div class="post-dispaly-innr">
                                            <div class="post-item highlighted">
                                                <span class="premium-logo"><img
                                                        src="{{ asset('frontend/images/premium.svg') }}" /></span>
                                                <h5 class="job-title">Analyst</h5>
                                                <p class="company-name">Tech Europe Bank</p>
                                                <div class="ftr-items">
                                                    <p><i class="fa fa-calendar"
                                                            aria-hidden="true"></i><span>2021-06-24</span></p>
                                                    <p><i class="fa fa-map-marker"
                                                            aria-hidden="true"></i><span>Vienna</span></p>
                                                </div>
                                            </div>
                                            <div class="post-item highlighted">
                                                <span class="premium-logo"><img
                                                        src="{{ asset('frontend/images/premium.svg') }}" /></span>
                                                <h5 class="job-title">Project Manager</h5>
                                                <p class="company-name">Tech Europe Bank</p>
                                                <div class="ftr-items">
                                                    <p><i class="fa fa-calendar"
                                                            aria-hidden="true"></i><span>2021-06-24</span></p>
                                                    <p><i class="fa fa-map-marker"
                                                            aria-hidden="true"></i><span>Vienna</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- <h4 class="qus-title">{{ __('messages.SCREENING_QUESTION') }} <span> ({{ __('messages.SCREENING_QUESTION_TEXT') }}) </span> -->
                                    <h4 class="qus-title">Stellen Sie 3 Fragen, welche <strong
                                            style="border: 2px solid #ffc000;padding: 2px;">SCHRIFTLICH</strong> beantwortet
                                        werden*:
                                    </h4>
                                    <div class="interview-question-holder">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 1" name="screening_1"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 2" name="screening_2"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 3" name="screening_3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- <h4 class="qus-title">{{ __('messages.INTERVIEW_QUESTIONS') }} <span> ({{ __('messages.INTERVIEW_QUESTIONS_TEXT') }}) </span>
                                  </h4> -->
                                    <h4 class="qus-title">Sie können auch eine Frage stellen, welche per <strong
                                            style="border: 2px solid #ffc000;padding: 2px;">VIDEO</strong> beantwortet
                                        wird*:</h4>
                                    <div class="interview-question-holder">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 1" name="interview_1" id="interview_1"></textarea>
                                        </div>
                                        {{-- <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 2" name="interview_2" id="interview_2"></textarea>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 3" name="interview_3" id="interview_3"></textarea>
                              </div> --}}
                                        <label class="error error-interview" style="display:none;"></label>
                                    </div>
                                    <div>(One-way video)</div>
                                    <div class="one-way-video-sec1">
                                        <img class="one-way-video-sec1-img1"
                                            src="{{ asset('frontend/images/one-way-video-img-1.png') }}" />
                                        <img class="one-way-video-sec1-img2"
                                            src="{{ asset('frontend/images/one-way-video-img-2.png') }}" />

                                    </div>
                                    <div class="one-way-video-sec2">
                                        <div class="one-way-video-sec2-title">DER BESTE KANDIDAT HAT VIELLEICHT NICHT DEN
                                            BESTEN LEBENSLAUF!</div>
                                        <div class="one-way-video-sec2-desc">Mit Hilfe neuester Videotechnologien, bringen
                                            wir Arbeitgeber und Arbeitssuchende näher zueinander und machen so Ihre
                                            Interviews zu einem gemeinschaftlicheren und effektiveren Prozess. </div>
                                    </div>
                                    <div class="one-way-video-sec3">
                                        *Fragen für die Kandidaten werden nicht verpflichtend sein
                                    </div>
                                </div>
                                <div class="payment-block-bottom">
                                    <div>
                                        <div class="premium-lable">PREMIUM</div>
                                        <button type="submit" class="btn-select">Select here</button>
                                    </div>
                                    {{-- <p>For future posts you still have the option to choose it for free!</p> --}}
                                    <p style="width:50%">Für zukünftige Stellenausschreibungen haben Sie weiterhin die Möglichkeit gratis auszuwählen</p>
                                </div>
                            </div>
                        </form>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!--/Job Advertisment Section-->
@endsection
