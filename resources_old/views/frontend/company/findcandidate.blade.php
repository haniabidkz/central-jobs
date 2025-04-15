@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{ asset('frontend/js/find.candidates.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <!-- main -->
     <main>
               <section class="section company-page">
                  <div class="container">
                     <div class="row whitebg mx-0 mb-4 px-2 pt-4 pb-2">
                        <input type="hidden" name="page" id="page" value="{{$search['page']}}"/>
                        <div class="col-12 d-flex input-search-holder "> 
                           
                           <div class="input-search profile-head-sec">
                             <div class="form-group multiple-select required">
                                 <select name="profile_headline" data-placeholder="{{ __('messages.PROFILE_HEADLINE') }}" id="itskills" class="form-control js-example-tags"  multiple="multiple" style="display: none;">

                                 <?php if(!empty($allProfileHeadline)){ 
                                    foreach($allProfileHeadline as $key=>$val){ ?>
                                  <option value="{{$val}}" <?php if((isset($search['profile_headline'])) && in_array($val,$search['profile_headline'], TRUE)){ echo 'selected';}?>>{{$val}}</option>
                                  <?php } }?>
                                 </select>
                                 <span class="profile-headline-cls" style="color:red;"></span>
                             </div>  
                           </div>  


                           <div class="input-search">
                              <div class="form-group">
                                 <input type="text" class="form-control" placeholder="{{ __('messages.CANDIDATE_NAME') }}" name="candidate_name" id="candidate_name">
                                    <span class="company-name-cls" style="color:red;"></span>
                              </div>  
                           </div> 

                           <div class="input-search">
                              <div class="form-group multiple-select multi-select-states-area">
                                 <select name="state" data-placeholder="{{ __('messages.STATE') }}" id="state" class="form-control multi-select-states"  multiple="multiple" style="display: none;">
                                   <?php if($states){
                                    foreach ($states as $key => $value) {
                                    ?>
                                   <option value="{{$value['id']}}" <?php if((isset($search['state'])) && ($search['state'] != null) && in_array($value['id'],@$search['state'])){ echo 'selected';}?>>{{$value['name']}}</option>
                                   <?php } } ?>
                                 </select>
                              </div>
                           </div>
                           <div class="input-search">
                              <div class="form-group multiple-select">
                                 <select name="language" data-placeholder="{{ __('messages.LANGUAGE') }}" id="language" class="form-control multi-select-language"  multiple="multiple" style="display: none;">
                                   <?php if($language){
                                    foreach($language as $key=>$value){
                                    ?>
                                   <option value="{{$value['id']}}" <?php if((isset($search['language'])) && ($search['language'] != null) &&in_array($value['id'],@$search['language'])){ echo 'selected';}?>>{{$value['name']}}</option>
                                   <?php } } ?>
                                 </select>
                              </div>
                           </div>
                           <div class="input-search">
                              <div class="form-group d-flex">
                                <button class="btn site-btn-color mr-2" id="search-bttn-first"> {{ __('messages.SEARCH') }}</button>
                                <a class="btn site-btn-color src-res" href="{{ url('company/find-candidates') }}" style="display:none;"><i class="fa fa-refresh" aria-hidden="true"></i></a>        
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row mb-5" id="post-data">
                     @include('frontend.company.data')
                      <div class="col-12 ajax-load" style="display:none">
                        <div class="process-comm">
                              <div class="spinner">
                                 <div class="bounce1"></div>
                                 <div class="bounce2"></div>
                                 <div class="bounce3"></div>
                              </div>
                        </div> 
                     </div> 
                     </div> 
                  </div>
               </section>
               <!--messages-page end-->
            </main>
      <!-- main End -->
      <!--footer start-->
      <!-- <script src="{{ asset('frontend/js/dropzone.min.js')}}"></script> -->
      <script src="{{ asset('frontend/js/aos.js')}}"></script>
      <script src="{{ asset('frontend/js/jquery.easing.min.js')}}"></script>
      <script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>
      <script src="{{ asset('frontend/js/tagsinput.js')}}"></script> 
      <script src="{{ asset('frontend/js/swiper.min.js')}}"></script>
      <!--footer end-->

      <script type="text/javascript">
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".multiple-select select.multi-select-language").bsMultiSelect(); 
          $(".js-example-tags").select2({tags: true,width:'100%'});         
      </script>
<div class="modal custom-modal  profile-modal connection-request" id="connection-request">
   <div class="modal-dialog">
      <div class="modal-content">
         <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
         <div class="modal-body">
            <div class="login-form">
            <form id="connect" action="{{url('/send-connection-request')}}" method="post" >
               <div class="row">
                  <div class="col-sm-12 details-panel-header">
                     <h4 class="text-left">{{ __('messages.CONNECTION_REQUEST') }}</h4>
                  </div>
                  <div class="col-sm-12 col-xl-12">
                     <div class="form-group required">
                        <label>{{ __('messages.WRITE_PERSONAL_NOTE') }}</label>
                        <input type="hidden" name="candidate_id" id="candidate_id"/>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                     </div>
                  </div>
                  <div class="col-sm-12 col-xl-12 text-left">
                     <button class="btn site-btn-color conect-btn" type="submit">{{ __('messages.SEND_NOW') }}</button>
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
      <!-- ================profile-modal================ -->


