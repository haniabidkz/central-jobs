@extends('layouts.app_after_login_layout')
@section('content')

    <style>
        .job-post-success-block {
            padding: 60px 0;
        }

        .job-post-success-block .success-card {
            max-width: 860px;
            margin: 0 auto;
            border: 1px solid #dbe2ea;
            border-radius: 4px;
            background: #fff;
            padding: 45px 50px;
        }

        .job-post-success-block .success-title {
            color: #ffc000;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .job-post-success-block .success-text {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .job-post-success-block .btn-select {
            display: inline-block;
            margin-top: 15px;
        }

        @media (max-width: 575px) {
            .job-post-success-block .success-card {
                padding: 30px 20px;
            }
        }
    </style>

    <!--Job Post Success Section-->
    <section class="job-post-success-block">
        <div class="container">
            <div class="success-card">
                <h2 class="success-title">{{ __('messages.JOB_POST_SUCCESS_TITLE') }} &#127881;</h2>
                <p class="success-text">
                    {!! __('messages.JOB_POST_SUCCESS_MESSAGE', [
                        'successfully' => '<strong>' . __('messages.JOB_POST_SUCCESS_SUCCESSFULLY') . '</strong>',
                    ]) !!}
                </p>
                <p class="success-text">{{ __('messages.JOB_POST_SUCCESS_EMAIL_INFO') }}</p>
                <a href="{{ url('company/my-jobs') }}" class="btn-select">{{ __('messages.MANAGE_YOUR_JOB_POST') }}</a>
            </div>
        </div>
    </section>
    <!--/Job Post Success Section-->
@endsection
