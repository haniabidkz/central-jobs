@extends('layouts.app_after_login_layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('frontend/js/job.js')}}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/BsMultiSelect.js') }}"></script>  
{{-- <script src="{{asset('ckeditor/ckeditor.js')}}"></script>    --}}


<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>

    <style>
      .note-dropdown-menu.dropdown-menu.note-check.dropdown-fontname.show{
         font-size:inherit !important;
      }

      .note-btn.btn.btn-light.btn-sm[title="Video"] {
         display: none !important;
      }

    </style>


<main>
<section class="section-myprofile-outer">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <form name="post_job" id="post_job" action="{{url('company/post-job-post')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id" value = "{{$id}}">
               <div class="section-myprofile">
                  <div class="login-form">
                     <div class="row">
                        <div class="col-12 details-panel-header">
                           <h4>{{ __('messages.POST_JOB') }}</h4>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <input type="text" class="form-control" placeholder="{{ __('messages.POSITION_NAME') }} *" name="title" id="title" autocomplete="off">
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="country_id" id="country_id" disabled>
                                 <option value=""> {{ __('messages.COUNTRY') }} *</option>
                                 <?php if($countries){
                                   foreach($countries as $key=>$val){
                                   ?>
                                 <option value="{{$val['id']}}" <?php if($val['id'] == $selectedCountry){ echo 'selected';} ?>>{{$val['name']}}</option>
                                 <?php } }?>
                              </select>
                           </div>
                        </div>
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group multiple-select multi-select-states-area required">
                              <select name="state_id[]" data-placeholder="{{ __('messages.STATE') }} *" id="state" class="form-control multi-select-states"  multiple="multiple" style="display: none;" autocomplete="off">
                              <?php if($states){
                                    foreach ($states as $key => $value) {
                                    ?>
                                   <option value="{{$value['id']}}">{{$value['name']}}</option>
                                   <?php } } ?>
                              </select>
                              
                           </div>
                           <label class="error error-state" style="display:none;"></label>
                        </div> -->
                        <div class="col-12 col-sm-6 col-xl-4">
                           <!-- <div class="form-group multiple-select multi-select-city-area required">
                           <select name="city[]" data-placeholder="{{ __('messages.CITY') }}" id="city" class="form-control multi-select-city"  multiple="multiple" style="display: none;" autocomplete="off">
                                   
                              </select>
                                      
                              
                           </div> -->
                           <div class="form-group">
                              <select class="form-control" name="city" id="city">
                                    <option value=""> {{ __('messages.CITY') }}</option>
                                    <?php if($cities){
                                    foreach($cities as $key=>$val){
                                    ?>
                                    <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    <?php } }?>
                              </select>
                                      
                  
                           </div>
                           <label class="error error-city" style="display:none;"></label>
                        </div>



                        <div class="col-12 col-sm-6 col-xl-4">
                           
                           <div class="form-group required">
                              <select class="form-control" name="type" id="type">
                                    <option value=""> {{ __('messages.TYPE') }} *</option>
                                    <option>Hybrid</option>
                                    <option>Onsite</option>
                                    <option>Remote</option>
                              </select>
                                      
                  
                           </div>
                           <label class="error error-city" style="display:none;"></label>
                        </div>

                        
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="seniority" id="    ">
                                 <option value="">{{ __('messages.SENIORITY_LEVEL') }} *</option>
                                 <?php if($seniority){
                                    foreach($seniority as $key=>$val){?>
                                       <option value="{{$val['name']}}">{{$val['name']}}</option>
                                 <?php } }?>
                                 {{-- <option value="other">{{ __('messages.OTHERS') }}</option> --}}
                              </select>
                           </div>
                        </div> -->
                           <!-- If select Others -div should be display: block -->
                        <div class="col-12 col-sm-6 col-xl-4 seniority_other_open" style="display: none;">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="{{ __('messages.SPECIFY_OTHER') }}" name="seniority_other" id="seniority_other" autocomplete="off">
                           </div>
                        </div>
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="employment" id="employment">
                                 <option value="">{{ __('messages.EMPLOYMENT_TYPE') }} *</option>
                                 <?php if($employment){
                                    foreach($employment as $key=>$val){?>
                                       <option value="{{$val['id']}}">{{$val['name']}}</option>
                                 <?php } }?>
                                 {{-- <option value="other">{{ __('messages.OTHERS') }}</option> --}}
                              </select>
                           </div>
                        </div> -->
                        <!-- If select Others -div should be display: block -->
                        <div class="col-12 col-sm-6 col-xl-4 employment_other_open" style="display: none;">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="{{ __('messages.SPECIFY_OTHER') }}" name="employment_other" id="employment_other" autocomplete="off">
                           </div>
                        </div>
                       
                        <!-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Language Known">
                           </div>
                        </div> -->
                        {{-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control js-example-tags" name="language[]" data-placeholder="{{ __('messages.LANGUAGE_KNOWN') }}" id="language" multiple="multiple" style="display: none;" autocomplete="off">
                                 <?php if(!empty($language)){
                                    foreach($language as $key=>$val){?>
                                       <option value="{{$val['id']}}">{{$val['name']}}</option>
                                 <?php } }?>
                              </select>
                           </div>
                        </div> --}}
                        <!-- If select Others -div should be display: block -->
                        <!-- <div class="col-12 col-sm-6 col-xl-4 language_other_open" style="display: none;">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Specify Other Language" name="language_other" id="language_other">
                           </div>
                        </div> -->
                        {{--  <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group multiple-select required">
                              <select name="itskill[]" data-placeholder="{{ __('messages.IT_SKILL') }}" id="it-skill" class="form-control js-example-tags selecte-skill-cls"  multiple="multiple" style="display: none;">
                              <?php if(!empty($itSkill)){ 
                                    foreach($itSkill as $key=>$val){ ?>
                                  <option value="{{$val['id']}}" >{{$val['name']}}</option>
                                  <?php } }?>
                              </select>
                           </div>
                        </div> --}}
                        <!-- <div class="col-12">
                           <div class="form-group selected-skill-cls">
                              Selected Skill List
                              <textarea class="form-control" placeholder=""></textarea>
                           </div>
                        </div> -->

                        <!-- <div class="col-12">
                           <h4 class="qus-title">{{ __('messages.SCREENING_QUESTION') }} <span> ({{ __('messages.SCREENING_QUESTION_TEXT') }}) </span>
                           </h4>
                           <div class="interview-question-holder">
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 1" name="screening_1"></textarea>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 2" name="screening_2"></textarea>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 3" name="screening_3"></textarea>
                              </div>                                                                   
                           </div>
                        </div>  -->
                        <!-- <div class="col-12">
                           <h4 class="qus-title">{{ __('messages.INTERVIEW_QUESTIONS') }} <span> ({{ __('messages.INTERVIEW_QUESTIONS_TEXT') }}) </span>
                              </h4>
                           <div class="interview-question-holder">
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 1" name="interview_1" id="interview_1"></textarea>
                              </div>
                              {{-- <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 2" name="interview_2" id="interview_2"></textarea>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 3" name="interview_3" id="interview_3"></textarea>
                              </div> --}}
                              <label class="error error-interview" style="display:none;"></label>                                                                 
                           </div>
                        </div> -->
                        {{--<div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control"  name="mandatory_setting" id="mandatory_setting">
                                 <option value="">{{ __('messages.MANDATORY_SETTINGS') }}</option>
                                 <option value="1">{{ __('messages.ALL_ARE_MANDATORY') }} </option>
                                 <option value="2">{{ __('messages.ANY_ONE_IS_MANDATORY') }} </option>
                                 <option value="3">{{ __('messages.ANY_TWO_ARE_MANDATORY') }}</option>
                                 <option value="0" selected>{{ __('messages.NONE_OF_THEM_ARE_MANDATORY') }} </option>
                              </select>
                           </div>
                        </div>       --}}                              
                        <div class="col-12 col-sm-12 col-xl-12">
                           <h4 class="qus-title">{{ __('messages.JOB_DESCRIPTION') }} <span> ({{ __('messages.JOB_DESCRIPTION_TEXT') }}) </span></h4>

                           <div class="form-group required">
                              <!-- <textarea class="form-control" placeholder="{{ __('messages.JOB_DESCRIPTION') }} *" name="description" id="description"></textarea> -->
                              {{-- <textarea  id="description" name="description"></textarea> --}}

                              <textarea id="description" name="description"></textarea>

                              <label class="error descErr" style="display:none;"></label>
                              <br>
                              <label for="gdpr-consent">
                                 <input type="checkbox" id="gdpr-consent" name="gdprConsent" required>
                                 I consent to the processing of my personal data in accordance with the 
                                 <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                               </label>
                           </div>
                           
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required"> Start Date:
                              <div class="select-dat">
                                 <input type="text" class="form-control" placeholder="{{ __('messages.TO_BE_PUBLISHED_ON') }} *" id="start_date" name="start_date" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required"> End Date:

                              <div class="select-dat">
                                    <input type="text" class="form-control" placeholder="{{ __('messages.LAST_DAY_OF_JOB_POST') }} *" id="end_date" name="end_date" autocomplete="off">
                              </div>
                           </div>   
                        </div>
                        {{-- <div class="col-12 col-sm-6 col-xl-4">
                           <div class="form-group required">
                              <select class="form-control" name="applied_by" id="applied_by">
                                 <option value="">{{ __('messages.APPLY_THROUGH') }} *</option>
                                 <option value="1">{{ __('messages.MYHR') }}</option>
                                 <option value="2">{{ __('messages.COMPANY_PORTAL') }}</option>
                              </select>
                           </div>
                        </div> --}}
                        <!-- If select Company Portal -div should be display: block -->
                        <div class="col-12 col-sm-6 col-xl-4 company_portal" style="display: none;">
                           <div class="form-group required">
                              <input type="text" class="form-control" placeholder="{{ __('messages.WEBSITE_LINK') }}" name="website_link" id="website_link">
                           </div>
                        </div>
                        <div class="col-12 mt-3">
                           <div class="form-group">
                              <button class="site-btn btn submit-job-post" type="submit" >{{ __('messages.SUBMIT') }}</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
</main>
<script>
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".multiple-select select.multi-select-city").bsMultiSelect();
          $(".js-example-tags").select2({tags: true,width:'100%'});
          var startDate = '<?php echo date('Y/m/d');?>';

          $(document).ready(function() {
            $( "#start_date" ).datepicker({
                  dateFormat: "yy-mm-dd",
                  minDate: new Date(startDate),
                  onSelect: function(selected) {
                  $("#end_date").datepicker("option","minDate", selected)
               }
            });
               
            $('#end_date').datepicker({
                  dateFormat: "yy-mm-dd",
                  minDate: 0,
                  onSelect: function(selected) {
                  $("#start_date").datepicker("option","maxDate", selected)
                  }
            });
            $( "#seniority" ).on( "change", function() {
               if($('#seniority').val() == 'other'){
                  $('.seniority_other_open').show();
               }else{
                  $('.seniority_other_open').hide();
               }
               
            });
            $( "#employment" ).on( "change", function() {
               if($('#employment').val() == 'other'){
                  $('.employment_other_open').show();
               }else{
                  $('.employment_other_open').hide();
               }
               
            });
            // $( ".selecte-skill-cls" ).on( "change", function() {
            //    //alert();
            //    var skill = $('.selecte-skill-cls').val();
            //    console.log(skill);
            //    // if($('#language').val() == 'other'){
            //    //    $('.language_other_open').show();
            //    // }else{
            //    //    $('.language_other_open').hide();
            //    // }
               
            // });
            $( "#applied_by" ).on( "change", function() {
               if($('#applied_by').val() == 2){
                  $('.company_portal').show();
               }else{
                  $('.company_portal').hide();
               }
               
            });
         });
      </script>
@endsection
