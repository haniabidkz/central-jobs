@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{ asset('frontend/js/trackJob.js')}}"></script>
<main>
      <section class="section section-track-job">
         <div class="container">
         <input type="hidden" name="page" id="page" value="1"/>
         
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <div class="select-newstyle">
                        <div class="list-inline-item">
                              <label class="check-style">
                              {{ __('messages.APPLIED') }}
                              <input type="radio" name="company" id="appliedCheck" value="2" <?php if($search['status'] == 2){ echo 'checked'; }?>>
                              <span class="checkmark"></span>
                              </label>
                        </div>
                        <div class="list-inline-item">
                              <label class="check-style">
                              {{ __('messages.SAVE_AS_DRAFT') }}
                              <input type="radio" name="company"  id="positionCheck" onclick="check_positionFunction()" value="1" <?php if($search['status'] == 1){ echo 'checked'; }?>>
                              <span class="checkmark"></span>
                              </label>
                        </div>
                        <div class="list-inline-item">
                              <label class="check-style">
                              {{ __('messages.SAVED') }}
                              <input type="radio" name="company" id="companyCheck" value="0" <?php if($search['status'] == 0){ echo 'checked'; }?>>
                              <span class="checkmark"></span>
                              </label>
                        </div>
                     </div>
                  </div>                                      
               </div> 
            </div>   
            <div class="row" id="post-data">

            @include('frontend.candidate.trackJobAjaxData')
                                    
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
      </section>
   </main>
   <script>
$(document).ready(function() {

   $('#page').val(1);
            
});
</script> 
@endsection