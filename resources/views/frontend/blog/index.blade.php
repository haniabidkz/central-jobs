@extends('layouts.app_after_login_layout')

@section('content')

<style>
    /* Fix equal height/width images */
    .blog-thumb {
        width: 100%;
        height: 220px;
        /* set desired fixed height */
        object-fit: cover;
        /* crop images nicely */
    }

    /* Make all cards the same height */
    .card {
        display: flex;
        flex-direction: column;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        text-align: center;
        /* center text */
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .blog-date {
        font-size: 0.9rem;
        margin-bottom: 8px;
        color: #555;
    }

    .blog-desc {
        font-size: 0.95rem;
        color: #333;
    }
</style>

<main>
    <!-- Banner -->
    <section class="banner banner-innerpage">
        <div class="bannerimage">
            <img src="{{ asset('frontend/images/blog-banner.jpg') }}" alt="Blog Banner">
        </div>
        <div class="bennertext">
            <div class="innertitle">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2>Our Blog</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Listing -->
    <section class="section-padding mt-5">
        <div class="container">
            <div class="row">
                @forelse($data as $row)
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card shadow-sm flex-fill">
                        @if($row->featured_image)
                        <img src="{{ asset($row->featured_image) }}" class="card-img-top blog-thumb" alt="{{ $row->title }}">
                        @else
                        <img src="{{ asset('frontend/images/no-image.jpg') }}" class="card-img-top blog-thumb" alt="No Image">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $row->title }}</h5>
                            <p class="blog-date">
                                {{ $row->updated_at->format('d.m.Y') }}
                            </p>
                            <p class="blog-desc flex-grow-1">
                                {!! $row->content !!}
                            </p>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p>No blogs found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection