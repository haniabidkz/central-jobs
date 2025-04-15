@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/searchProfile.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<main>

       <section class="section searchprofile-page">
          <div class="container">
          <input type="hidden" name="tag" id="tag" value="0"/>   
             <div class="row">
                <div class="col-12">
                   <div class="custom-tab tab-bg-white" id="tab-2">
                      <ul class="nav nav-tabs" id="myTab2" role="tablist">
                         <li class="nav-item">
                            <a class="nav-link active show tag-cand" id="tab-5-tab" data-toggle="tab" href="#tab-5" role="tab" aria-controls="tab-5" aria-selected="true">
                              <span><i class="fa fa-user" aria-hidden="true"></i></span>{{ __('messages.CANDIDATE') }}</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link tag-comp" id="tab-6-tab" data-toggle="tab" href="#tab-6" role="tab" aria-controls="tab-6" aria-selected="false">
                            <span><i class="fa fa-building" aria-hidden="true"></i></span>{{ __('messages.COMPANY') }}</a>
                         </li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane active show" id="tab-5" role="tabpanel" aria-labelledby="tab-5-tab"> 
                            <div class="row whitebg mx-0 mb-4 px-2 pt-4 pb-2">
                            
                               <div class="col-12 d-flex input-search-holder "> 
                                  <div class="input-search">
                                    <div class="form-group required">
                                    <input type="hidden" name="page" id="page" value="{{$search['page']}}" data-id="{{$search['page']}}"/>
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
                                           <option value="{{$value['id']}}">{{$value['name']}}</option>
                                           <?php } } ?>
                                        </select>
                                     </div>
                                  </div>
                                  <div class="input-search">
                                     <div class="form-group multiple-select multi-select-company-area">
                                        <select name="current_company" data-placeholder="{{ __('messages.CURRENT_COMPANY') }}" id="current_company" class="form-control multi-select-company"  multiple="multiple" style="display: none;">
                                          <?php 
                                          if($companyList){ 
                                             foreach($companyList as $key=>$val){?>
                                                <option value="{{$val}}">{{$val}}</option>
                                           <?php  }
                                          }
                                          ?>
                                        </select>
                                     </div>
                                  </div>
                                  <div class="input-search">
                                     <div class="form-group d-flex">
                                       <button class="btn site-btn-color mr-2" id="search-bttn-first"> {{ __('messages.SEARCH') }}</button>
                                       <a class="btn site-btn-color src-res" href="{{ url('candidate/search-profile') }}" style="display:none;"><i class="fa fa-refresh" aria-hidden="true"></i></a>  
                                     </div>
                                  </div>
                               </div>
                                  
                            </div>
                            <div class="row mb-5" id="post-data">
                            @include('frontend.candidate.searchData')
                               
                            </div> 
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
                         <div class="tab-pane" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
                            <div class="row whitebg mx-0 mb-4 px-2 pt-4 pb-2">
                               <div class="col-12 d-flex input-search-holder input-search-holder-two"> 
                                  <div class="input-search">
                                    <div class="form-group">
                                    <input type="hidden" name="page_company" id="page_company" value="{{$search['page_company']}}"/>   
                                      <input type="text" class="form-control" placeholder="{{ __('messages.COMPANY_NAME') }} *" name="company_name" id="company_name">
                                          <span class="company-name-cls" style="color:red;"></span>
                                    </div>  
                                  </div>    
                                  <div class="input-search">
                                     <div class="form-group d-flex">
                                       <button class="btn site-btn-color mr-2" id="search-bttn-second"> {{ __('messages.SEARCH') }}</button>
                                       <a class="btn site-btn-color src-res-com" href="{{ url('candidate/search-profile') }}" style="display:none;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                     </div>
                                  </div>
                               </div>   
                            </div>
                            <div class="row mb-5" id="post-data-company">
                            @include('frontend.candidate.searchCompanyData')
                               <!-- <div class="col-12"> <h4 class="h4-head">Search Result </h4></div> -->
                            </div> 
                            <div class="col-12 ajax-load-company" style="display:none">
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
                   </div>
                </div>
             </div>  
          </div>
       </section>
       <!--messages-page end-->
    </main>
      <!-- main End -->
      <script type="text/javascript">
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".multiple-select select.multi-select-company").bsMultiSelect();
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
<script>
$(document).ready(function() {
            $( ".tag-comp" ).on( "click", function() {
               $('#tag').val(1);
               var tag = $('#tag').val();
               console.log(tag);
            });
            $( ".tag-cand" ).on( "click", function() {
               $('#tag').val(0);
               var tag = $('#tag').val();
               console.log(tag);
            });

            $('#page').val(1);
            $('#page_company').val(1);
});
</script> 

       @endsection
      <!-- main-page -->
     
     


