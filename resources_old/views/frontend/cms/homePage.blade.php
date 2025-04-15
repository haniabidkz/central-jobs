@if (auth()->guest())
        @extends('layouts.app_before_login_layout')
@else
        @extends('layouts.app_after_login_layout')
@endif

@section('content')
 <!-- main -->
<main>
 <section class="banner banner-innerpage">
      <div class="bannerimage">
         <img src="{{ asset('frontend/images/blog-banner.jpg') }}" alt="image">
      </div>
      <div class="bennertext">
          <div class="innertitle">
              <div class="container">
                  <div class="row">
                      <div class="col-12 col-sm-12">
                          <h2>Tips</h2>                
                      </div>
                  </div>
              </div>
          </div>                  
      </div>
  </section>
     <!-- wraper-trams- -->
  <section class="wraper-default-innerpage">
      <div class="container">
          <div class="row">                                
             <div class="col-12">
                <div class="default-main whitebg">
                     <h4 class="list-heading">In hac habitasse platea dictumst. Proin nec lobortis velit, eu luctus erat. Sed eu imperdiet nisl</h4>
                     <p>Nulla mattis varius molestie. Etiam vulputate sagittis consectetur. Integer varius justo quis nibh posuere, quis gravida lectus laoreet. Pellentesque arcu ex, dapibus pharetra sodales ac, vulputate rhoncus nisi. Praesent ullamcorper dictum urna non iaculis. Fusce hendrerit varius bibendum. Nullam ullamcorper ipsum tempor, congue massa vel, pulvinar dui. Nam eleifend, est sit amet euismod dignissim, lectus mi accumsan est, vitae elementum ante diam ut mauris. Sed lacinia tristique neque, id vulputate mi luctus eget. Duis vestibulum faucibus odio nec dictum. Suspendisse vel tincidunt velit, eu tristique turpis. Nullam eget vestibulum dolor. Donec congue non enim in condimentum.</p>
                     <h4 class="list-heading">In hac habitasse platea dictumst. Proin nec lobortis velit, eu luctus erat. Sed eu imperdiet nisl</h4>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus viverra urna ut nunc porttitor maximus. Integer lobortis pharetra convallis. Donec et velit elit. Nulla facilisi. Nulla commodo vel mauris sed blandit. Nunc at mi eu nisi cursus tempus. Nunc placerat ante dui, quis luctus lorem condimentum eu. Sed accumsan accumsan finibus. Nullam porta tristique mi, quis mattis risus elementum non. Praesent blandit aliquam sodales. Nullam commodo id libero id fermentum.</p>
                     <p>Phasellus non tellus nec nibh commodo ullamcorper. Pellentesque aliquet consequat nisl nec ultrices. Aenean vel imperdiet justo. Curabitur nec libero in eros molestie rhoncus vitae id ante. Aliquam eu ullamcorper massa. Nam auctor massa eu suscipit luctus. Duis id cursus odio. Vestibulum ac justo elementum, sollicitudin ligula ut, vulputate ex. Vivamus elit metus, eleifend id est eu, laoreet dictum tellus. Aliquam molestie pharetra vulputate.</p>

                     <h4 class="list-heading">Nulla mattis varius molestie. Etiam vulputate sagittis consectetur. Integer varius justo quis nibh posuerequis gravida lectus laoreet. Pellentesque arcu eapibus pharetra sodales ac.</h4>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus viverra urna ut nunc porttitor maximus. Integer lobortis pharetra convallis. Donec et velit elit. Nulla facilisi. Nulla commodo vel mauris sed blandit. Nunc at mi eu nisi cursus tempus. Nunc placerat ante dui, quis luctus lorem condimentum eu. Sed accumsan accumsan finibus. Nullam porta tristique mi, quis mattis risus elementum non. Praesent blandit aliquam sodales. Nullam commodo id libero id fermentum.</p>
                     <p>Phasellus non tellus nec nibh commodo ullamcorper. Pellentesque aliquet consequat nisl nec ultrices. Aenean vel imperdiet justo. Curabitur nec libero in eros molestie rhoncus vitae id ante. Aliquam eu ullamcorper massa. Nam auctor massa eu suscipit luctus. Duis id cursus odio. Vestibulum ac justo elementum, sollicitudin ligula ut, vulputate ex. Vivamus elit metus, eleifend id est eu, laoreet dictum tellus. Aliquam molestie pharetra vulputate.</p>
                     <p>Nulla mattis varius molestie. Etiam vulputate sagittis consectetur. Integer varius justo quis nibh posuere, quis gravida lectus laoreet. Pellentesque arcu ex, dapibus pharetra sodales ac, vulputate rhoncus nisi. Praesent ullamcorper dictum urna non iaculis. Fusce hendrerit varius bibendum. Nullam ullamcorper ipsum tempor, congue massa vel, pulvinar dui. Nam eleifend, est sit amet euismod dignissim, lectus mi accumsan est, vitae elementum ante diam ut mauris. Sed lacinia tristique neque, id vulputate mi luctus eget. Duis vestibulum faucibus odio nec dictum. Suspendisse vel tincidunt velit, eu tristique turpis. Nullam eget vestibulum dolor. Donec congue non enim in condimentum.</p>
                </div>
             </div>
          </div>
      </div>       
  </section>
</main>
<!-- main End -->
@endsection