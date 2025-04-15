@extends('layouts.app_after_login_layout')
@section('content')
 <!-- main -->
<main>
<section class="banner banner-innerpage">
        <div class="bannerimage">
            <img src="{{asset(@$data[0]['page_content']['page_info']['banner_image']['location'])}}" alt="image">
        </div>
        <div class="bennertext">
            <div class="innertitle">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <h2>{{strip_tags(@$data[1]['text'])}}</h2>                
                        </div>
                    </div>
                </div>
            </div>                  
        </div>
    </section>
<?php echo @$data[0]['text']; ?>
</main>
<!-- main End -->
@endsection
