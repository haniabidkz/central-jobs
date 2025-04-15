 <!--footer start-->
 <footer>
   <div class="footy-sec">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="d-flex justify-content-between">
                  <ul>
                     <li><a href="{{url('privacy-policy')}}" title="">{{ __('messages.PRIVACY_POLICY') }}</a></li>
                     <li><a href="{{url('cookies-policy')}}" title="">{{ __('messages.COOKIES_POLICY') }}</a></li>
                     <li><a href="{{url('terms-use')}}" title="">{{ __('messages.TERMS_OF_USE') }}</a></li>
                     <li><a href="{{url('contact-us')}}" title="">{{ __('messages.CONTACT_US') }}</a></li>
                     <!-- <li><a href="{{url('tips')}}" title="">{{ __('messages.TIPS') }}</a></li> -->
                  </ul>
                  <p>© Copyright Central Jobs <?php echo date('Y');?></p>
               </div>
            </div>
         </div>
      </div>
   </div>
   </footer>
      <!--footer end-->
   </div>
   <div class="overlay"></div>
</div>
<!-- main-page -->   
        
      <script type="text/javascript" src="{{ asset('frontend/js/aos.js') }}"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/custom.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
       <!-- Cookies Section -->
               <?php if(!isset($_COOKIE['cookie_consent'])){?>
               <div class="accept-cookies-holder">
                  <div class="container">
                        <div class="d-flex justify-content-between">  
                           <div class="text-holder">
                              <p>{{ __('messages.COOKIES_ACCEPT_POLICY') }} <a class="cookie-anchor" href="{{(url('cookies-policy'))}}"><b>{{ __('messages.COOKIES_POLICY') }}</b></a>.
                               
                              {{ __('messages.COOKIES_ACCEPT_POLICY_2') }}</p>
                           </div>
                           <div class=""> 
                              <div class="d-flex">
                                 <button class="btn coockies_consent site-btn-color mr-3 coockies-accept"> {{ __('messages.COOKIES_ACCEPT_POLICY_BUTTON') }} </button>
                                 <!-- <button class="btn site-btn" id="cookies-close"> Reject </button> -->
                              </div>
                           </div>   
                        </div> 
                  </div>       
               </div>
            <?php } ?>
               <script type="text/javascript">
                  $(document).on('click','.coockies_consent',function(){
                       Cookies.set('cookie_consent', 'yes' , { expires: 365 });
                       $('.accept-cookies-holder').hide();
                  });
               
               </script>
            <!-- Cookies Section -->
   </body>
</html>