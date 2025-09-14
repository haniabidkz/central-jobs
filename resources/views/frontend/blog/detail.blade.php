@extends('layouts.app_after_login_layout')

@section('content')
<div class="container mb-5">


    <main>
        <!-- Banner -->
        <section class="banner banner-innerpage">
            <div class="bannerimage">
                <img src="{{ asset($blog->featured_image) }}" alt="Blog Banner">
            </div>
        </section>

        <!-- Blog Detail -->
        <section class="section-padding mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted">
                            Published on {{ $blog->updated_at->format('d M, Y') }}
                        </p>
                        <h2>{{ $blog->title }}</h2>
                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </main>
</div>
@endsection