@extends('layouts.app_after_login_layout')

@section('content')
<main>
   <section class="banner banner-innerpage">
         <div class="bannerimage">
            <img src="{{asset('frontend/images/blog-banner.jpg')}}" alt="image">
         </div>
         <div class="bennertext">
            <div class="innertitle">
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                              <h2>Service</h2>                
                        </div>
                     </div>
                  </div>
            </div>                  
         </div>
      </section>
      <section class="Company-overview">
         <div class="container">
            <div class="row">
                  <div class="col-12 col-lg-6 d-flex align-items-center">
                     <div>
                     <h2 class="title">Our Services</h2>
                     <p> We support candidates offering some special services in order to help them to find a good job opportunity and be better prepared for an interview.
                     </p>
                     </div>  
                  </div>
                  <div class="col-12 col-lg-6">
                     <div class="img-holder ml-0 ml-lg-5">
                        <img src="{{asset('frontend/images/service.jpg')}}" alt="image">
                     </div>         
                  </div>
            </div>
         </div>
      </section>
      <section class="section section-service">
         <div class="container">
            <div class="row">
                  <div class="col-md-12 col-12 headline-box text-center">
                     <h2 class="title">List of Services </h2>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean felis massa, commodo sed fringilla id,</p>
                  </div>
                  <!-- <div class="col-lg-4 col-12 mb-4">
                     <div class="services-box">
                        <div class="services-text-holder">
                           <h3 class="h3-head"> Translate your Curriculum </h3>
                           <div class="services-text"> 
                              <div class="services-para">
                                 <p>Native experienced translators will do that for you! <span>(all languages)</span> </p>
                              </div>
                              <ul> 
                                 <li>  Send your CV to <a href="mailto:cv@myhr.com"> cv@myhr.com </a> </li>
                                 <li>  Tell which language you need </li> 
                                 <li>  In up to 24hs you will receive the price and deadline.</li> 
                                 <li>  If you agree to the price, you can pay in the link that you received via e-mail</li>
                              </ul>
                           </div>
                        </div>  
                     </div>
                  </div> -->
                  <!-- <div class="col-lg-4 col-12 mb-4">
                     <div class="services-box">
                        <div class="services-text-holder">
                           <h3 class="h3-head"> Review your Curriculum </h3>
                           <div class="services-text"> 
                           <div class="services-para">
                              <p>Experts will review your CV and send you a new version (with explanations for the changes) </p>
                              <button class="btn">From EUR 30 to 100</button>
                           </div>  
                           <ul> 
                              <li> Send your CV to <a href="mailto:review@myhr.com">review@myhr.com</a> </li>
                              <li> In up to 24hs you will receive the price and deadline. </li>
                              <li> If you agree to the price, you can pay in the link that you received via email.</li>
                              </ul>
                           </div>
                        </div>  
                     </div>
                  </div> -->
                  <?php if(!empty($subscriptions)){ foreach($subscriptions as $key=>$val){?>
                  <div class="col-lg-8 col-12 mb-4 mx-auto">
                     <div class="services-box">
                        <div class="services-text-holder">
                           <h3 class="h3-head"> {{$val['title']}} </h3>
                           <div class="services-text"> 
                           <div class="services-para">
                              <p>Experts will act as recruiters and you will have a 40 min interview simulated. <span>After that you will receive your feedback.</span> </p>
                              <?php if($val['price'] != null){?>
                              <button class="btn">EUR 50,00</button>
                              <?php }?>
                           </div>   
                          
                              <?php echo $val['instruction']; ?>
                              <!-- <li> Send your CV to <a href="mailto:interview@myhr.com">interview@myhr.com </a> </li>
                              <li> In up to 48hs you will receive an e-mail with the time slots available</li> 
                              <li> If you agree to the date/time, you can pay in the link that you have received via e-mail.</li>  -->
                             
                           </div>
                        </div>  
                     </div>
                  </div>                            
                  <?php } }?>
            </div>
         </div>
      </section>                
      <!-- <section class="section section-contacted">
         <div class="container">
            <div class="row">
            <div class="col-12 col-md-12 text-center"> 
               <h2 class="title">How can we be contacted  </h2>
               <a href="" class="btn site-btn-color">Get Started</a>
            </div>               
            </div>
         </div>
      </section>
      <section class="section section-services">
         <div class="container">
            <div class="row">
            <div class="col-12 col-md-12 text-center"> 
               <h2 class="title">What services we provide What services we provide  </h2>
               <a href="" class="btn site-btn-color">Get Started</a>
            </div>               
            </div>
         </div>
      </section> -->

</main>

@endsection

