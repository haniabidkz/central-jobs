@extends('layouts.app_after_login_layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('frontend/js/job.js')}}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/BsMultiSelect.js') }}"></script>  
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>     
<main>
               <section class="section section-myjob">
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                        <form name="edit_job" id="edit_job" action="" method="post">
                           {{csrf_field()}}
                           <input name="id" hidden value="{{@$details['id']}}">
                              <div class="section-myprofile">
                                 <div class="login-form">
                                    <div class="row">
                                       <div class="col-12 details-panel-header">
                                             <h4>{{ __('messages.JOB_DETAILS_EDIT') }}</h4>
                                       </div>
                                    </div>
                                    <div class="row">  
                                    <div class="col-12 col-sm-6 col-xl-4">
                                       <div class="form-group required">
                                          <input type="text" class="form-control" placeholder="{{ __('messages.POSITION_NAME') }} *" name="title" id="title" autocomplete="off" value="{{@$details['title']}}">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                       <div class="form-group required">
                                          <select class="form-control" name="country_id" id="country_id" disabled>
                                             <option value=""> {{ __('messages.COUNTRY') }} *</option>
                                             <?php if($countries){
                                             foreach($countries as $key=>$val){
                                             ?>
                                             <option value="{{$val['id']}}" <?php if($val['id'] == @$details['country']['id']){ echo 'selected';} ?>>{{$val['name']}}</option>
                                             <?php } }?>
                                          </select>
                                       </div>
                                    </div>
                                    <?php $stateArr = []; 
                                    if(@$details['postState']){ 
                                          foreach(@$details['postState'] as $key=>$val){
                                             array_push($stateArr,$val['state']['id']);
                                          }
                                    }
                                    ?>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                       <div class="form-group multiple-select multi-select-states-area required">
                                          <select name="state_id[]" data-placeholder="{{ __('messages.STATE') }} *" id="state" class="form-control multi-select-states"  multiple="multiple" style="display: none;" autocomplete="off">
                                          <?php if($states){
                                                foreach ($states as $key => $value) {
                                                ?>
                                             <option value="{{$value['id']}}" <?php if(in_array($value['id'],$stateArr)){ echo 'selected';}?>>{{$value['name']}}</option>
                                             <?php } } ?>
                                          </select>
                                          
                                       </div>
                                       <label class="error error-state" style="display:none;"></label>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                       <!-- <div class="form-group multiple-select multi-select-city-area required">
                                       <select name="city[]" data-placeholder="{{ __('messages.CITY') }} *" id="city" class="form-control multi-select-city"  multiple="multiple" style="display: none;" autocomplete="off">
                                       <?php //if($allCity){
                                               // foreach ($allCity as $key => $value) {
                                                ?>
                                             <option value="{{$value['name']}}" <?php //if(in_array($value['name'],$selectedCity)){ echo 'selected';}?>>{{$value['name']}}</option>
                                             <?php //} } ?>
                                          </select>
                                          </select>
                                               
                                          
                                       </div> -->
                                       <div class="form-group required">
                                      
                                          <input type="text" class="form-control" placeholder="{{ __('messages.CITY') }} *" name="city" id="city" value="{{$details['city']}}" autocomplete="off">
                                       </div>
                                       <label class="error error-city" style="display:none;"></label>   
                                    </div> 
                                       
                                       <?php 
                                       $seniority_id = '';
                                       if(@$details['cmsBasicInfo']){ 
                                             foreach(@$details['cmsBasicInfo'] as $key=>$val){
                                                if($val['type'] == 'seniority'){
                                                   $seniority_id = isset($val['masterInfo']['id']) ? $val['masterInfo']['id'] : '';
                                                }
                                             }
                                       }
                                       ?>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group required">
                                          <select class="form-control" name="seniority" id="seniority">
                                             <option value="">{{ __('messages.SENIORITY_LEVEL') }} *</option>
                                             <?php if($seniority){
                                                foreach($seniority as $key=>$val){?>
                                                   <option value="{{$val['id']}}" <?php if($seniority_id == $val['id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                             <?php } }?>
                                             <option value="other">{{ __('messages.OTHERS') }}</option>
                                          </select>
                                          </div>
                                       </div>
                                        <!-- If select Others -div should be display: block -->
                                        <div class="col-12 col-sm-6 col-xl-4 seniority_other_open" style="display: none;">
                                          <div class="form-group">
                                             <input type="text" class="form-control" placeholder="{{ __('messages.SPECIFY_OTHER') }}" name="seniority_other" id="seniority_other" autocomplete="off">
                                          </div>
                                       </div>
                                       <?php 
                                       $employment_type_id = '';
                                       if(@$details['cmsBasicInfo']){ 
                                             foreach(@$details['cmsBasicInfo'] as $key=>$val){
                                                if($val['type'] == 'employment_type'){
                                                   $employment_type_id = $val['masterInfo']['id'];
                                                }
                                             }
                                       }
                                       ?>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group required">
                                             <select class="form-control" name="employment" id="employment">
                                                <option value="">{{ __('messages.EMPLOYMENT_TYPE') }} *</option>
                                                <?php if($employment){
                                                   foreach($employment as $key=>$val){?>
                                                      <option value="{{$val['id']}}" <?php if($employment_type_id == $val['id']){ echo 'selected';}?>>{{$val['name']}}</option>
                                                <?php } }?>
                                                <option value="other">{{ __('messages.OTHERS') }}</option>
                                             </select>
                                          </div>
                                       </div>
                                       <!-- If select Others -div should be display: block -->
                                       <div class="col-12 col-sm-6 col-xl-4 employment_other_open" style="display: none;">
                                          <div class="form-group">
                                             <input type="text" class="form-control" placeholder="{{ __('messages.SPECIFY_OTHER') }}" name="employment_other" id="employment_other" autocomplete="off">
                                          </div>
                                       </div>
                                       <?php 
                                       $language_id = [];
                                       if(@$details['cmsBasicInfo']){ 
                                             foreach(@$details['cmsBasicInfo'] as $key=>$val){
                                                if($val['type'] == 'language'){
                                                   array_push($language_id,$val['masterInfo']['id']);
                                                }
                                             }
                                       }
                                       ?>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group multiple-select">
                                          <select class="form-control js-example-tags" name="language[]" data-placeholder="{{ __('messages.LANGUAGE_KNOWN') }}" id="language" multiple="multiple" style="display: none;" autocomplete="off">
                                             <?php if(!empty($language)){
                                                foreach($language as $key=>$val){?>
                                                   <option value="{{$val['id']}}" <?php if(in_array($val['id'],$language_id)){ echo 'selected';} ?>>{{$val['name']}}</option>
                                             <?php } }?>
                                             <!-- <option value="other">Others</option> -->
                                          </select>
                                          </div>
                                       </div>
                                       <?php 
                                       // SKILL SELECTED IN ARRAY
                                       $newArr = [];
                                       //dd($details['selectedSkill']);
                                       if(@$details['selectedSkill']){
                                             foreach(@$details['selectedSkill'] as $key1=>$val1){
                                                $newArr[$key1] = $val1['skill_id'];
                                             }
                                       }
                                       ?>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group multiple-select required">
                                             <select name="skill[]" data-placeholder="{{ __('messages.IT_SKILL') }}" id="it-skill" class="form-control js-example-tags selecte-skill-cls"  multiple="multiple" style="display: none;">
                                             <?php if(!empty($itSkill)){ 
                                                   foreach($itSkill as $key=>$val){ ?>
                                                <option value="{{$val['id']}}" <?php if(in_array($val['id'],$newArr)){ echo 'selected';} ?>>{{$val['name']}}</option>
                                                <?php } }?>
                                             </select>
                                          </div>
                                       </div>
                                       <?php $screeningArr = []; if(@$details['questions']){ 
                                          foreach(@$details['questions'] as $key=>$val){
                                          if($val['type'] == 1){ 
                                             array_push($screeningArr,$val['question']);
                                       } } } //echo '<pre>'; print_r($screeningArr);?>
                                       <div class="col-12">
                                          <h4 class="qus-title">{{ __('messages.SCREENING_QUESTION') }} <span> ({{ __('messages.SCREENING_QUESTION_TEXT') }}) </span>
                                          </h4>
                                          <div class="interview-question-holder">
                                             <div class="form-group">
                                                <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 1" name="screening_1">{{@$screeningArr[0]}}</textarea>
                                             </div>
                                             <div class="form-group">
                                                <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 2" name="screening_2">{{@$screeningArr[1]}}</textarea>
                                             </div>
                                             <div class="form-group">
                                                <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 3" name="screening_3">{{@$screeningArr[2]}}</textarea>
                                             </div>                                                                   
                                          </div>
                                       </div> 
                                       <?php $setting = 0; $interviewArr = []; if(@$details['questions']){ 
                                          foreach(@$details['questions'] as $key=>$val){
                                          if($val['type'] == 2){ 
                                             $setting = $val['mandatory_setting'];
                                             array_push($interviewArr,$val['question']);
                                       } } } //echo '<pre>'; print_r($interviewArr);?>
                                       <div class="col-12">
                                          <h4 class="qus-title">{{ __('messages.INTERVIEW_QUESTIONS') }} <span> ({{ __('messages.INTERVIEW_QUESTIONS_TEXT') }}) </span>
                                             </h4>
                                          <div class="interview-question-holder">
                                             <div class="form-group">
                                                <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 1" name="interview_1" id="interview_1">{{@$interviewArr[0]}}</textarea>
                                             </div>
                                             <div class="form-group">
                                                <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 2" name="interview_2" id="interview_2">{{@$interviewArr[1]}}</textarea>
                                             </div>
                                             <div class="form-group">
                                               <textarea class="form-control" placeholder="{{ __('messages.QUESTION') }} 3" name="interview_3" id="interview_3">{{@$interviewArr[2]}}</textarea>
                                             </div> 
                                             <label class="error error-interview" style="display:none;"></label>                                                                  
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group required">
                                          <select class="form-control"  name="mandatory_setting" id="mandatory_setting">
                                             <option value="">{{ __('messages.MANDATORY_SETTINGS') }}</option>
                                             <option value="1" <?php if($setting == 1){ echo 'selected';}?>>{{ __('messages.ALL_ARE_MANDATORY') }} </option>
                                             <option value="2" <?php if($setting == 2){ echo 'selected';}?>>{{ __('messages.ANY_ONE_IS_MANDATORY') }} </option>
                                             <option value="3" <?php if($setting == 3){ echo 'selected';}?>>{{ __('messages.ANY_TWO_ARE_MANDATORY') }}</option>
                                             <option value="0" <?php if($setting == 0){ echo 'selected';}?>>{{ __('messages.NONE_OF_THEM_ARE_MANDATORY') }} </option>
                                          </select>
                                          <label class="error mandatory_setting_error" style="display:none;"></label>  
                                          </div>
                                       </div> 
                                       <div class="col-12 col-sm-12 col-xl-12">
                                          <div class="form-group">
                                             <div class="select-dat">
                                               <label> {{ __('messages.JOB_DESCRIPTION') }} </label>
                                                <!-- <textarea class="form-control" name="description" id="description"> {{@$details['description']}} </textarea> -->
                                                <textarea  id="description" name="description">{{@$details['description']}}</textarea>
                                                <label class="error descErr" style="display:none;"></label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group required">
                                             <div class="select-dat">
                                                <input type="text" class="form-control" placeholder="{{ __('messages.TO_BE_PUBLISHED_ON') }} *" id="start_date" name="start_date" autocomplete="off" value="<?php if(@$details['start_date'] != ''){ echo date('Y-m-d',strtotime(@$details['start_date']));}else{ echo '';}?>">
                                             </div>
                                          </div>   
                                       </div>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group required">
                                             <div class="select-dat">
                                                <input type="text" class="form-control" placeholder="{{ __('messages.LAST_DAY_OF_JOB_POST') }} *" id="end_date" name="end_date" autocomplete="off" value="<?php if(@$details['end_date'] != ''){ echo date('Y-m-d',strtotime(@$details['end_date']));}else{ echo '';}?>">
                                             </div>
                                          </div>   
                                       </div>
                                       <div class="col-12 col-sm-6 col-xl-4">
                                          <div class="form-group required">
                                          <select class="form-control" name="applied_by" id="applied_by">
                                             <option value="">{{ __('messages.APPLY_THROUGH') }} *</option>
                                             <option value="1" <?php if(@$details['applied_by'] == 1){ echo 'selected';}?>>{{ __('messages.MYHR') }}</option>
                                             <option value="2" <?php if(@$details['applied_by'] == 2){ echo 'selected';}?>>{{ __('messages.COMPANY_PORTAL') }}</option>
                                          </select>
                                          </div>
                                       </div>
                                       <!-- If select Company Portal -div should be display: block -->
                                       <?php if(@$details['applied_by'] == 2){ ?>
                                       <div class="col-12 col-sm-6 col-xl-4 company_portal shcls" style="@if(@$details['applied_by'] == 2) display:block @else display:none @endif">
                                          <div class="form-group required">
                                             <input type="text" class="form-control" placeholder="{{ __('messages.WEBSITE_LINK') }}" name="website_link" id="website_link" value="{{@$details['website_link']}}">
                                          </div>
                                       </div>
                                       <?php }else{?>
                                          <div class="col-12 col-sm-6 col-xl-4 company_portal <?php if(@$details['applied_by'] != 2){ echo 'shcls'; }?>"  style="display: none;">
                                          <div class="form-group required">
                                             <input type="text" class="form-control" placeholder="{{ __('messages.WEBSITE_LINK') }}" name="website_link" id="website_link">
                                          </div>
                                       </div>   
                                       <?php }?>

                                       <div class="col-12">
                                          <div class="form-group">
                                             <button class="site-btn btn submit-job-post" type="submit" >{{ __('messages.UPDATE_JOB') }}</button>
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
<script type="text/javascript">
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".multiple-select select.multi-select-city").bsMultiSelect();
          $(".js-example-tags").select2({tags: true,width:'100%'}); 
          var startDate = '<?php echo date('Y/m/d',strtotime($details['start_date']));?>';
          //alert(startDate);
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