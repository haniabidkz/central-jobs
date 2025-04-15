/**
 * Developer : Rumpa
 * Date : 09/06/2020
 * Object is the container of common & usefull function.So we can use it accross the site
 * We need to intialize this object with profileFunctions.init(); before using this
 *
 */
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
  
   const jobFunctions = {
                                       base_url : _BASE_URL,
                                       defaultProfileImg : _BASE_URL+'/frontend/images/user-pro-img-demo.png', 
                                       defaultBannerImg : _BASE_URL+'/frontend/images/user-pro-bg-img.jpg',
                                       documentImg : _BASE_URL+'/frontend/images/doc-img.png',
                                       pdfImg : _BASE_URL+'/frontend/images/pdf-img.png',
                                       deafulCvImg : _BASE_URL+'/frontend/images/document.png',
                                                                           
                                       init : function(){ 		
                                              this.getState();
                                              this.postJob();
                                              this.jobDetails();
                                              this.jobSearch();
                                              this.jobAlert();
                                              this.saveJob();
                                              this.jobAlertDelete();
                                              this.CopyLink();
                                              this.SharePost();
                                              this.ReportPost();
                                              this.EditJob();
                                              this.getCountryOnCountrySelect();
                                              this.getCity();
                                              this.blockUnblockUser();
                                              this.getCityOnSelect();
                                              this.applyJob();
  
                                       },
                                       lanFilter : function(str){
                                          // console.log('str1');
                                          // console.log(str);
                                          // console.log('str');
                                          if(str != undefined){
                                          var res = str.split("|");
                                          if(res[1] != undefined){
                                              str = str.replace("|","'");
                                              return str;
                                          }else{
                                              return str;
                                          }
                                          }
                                          
                                      },
                                       getState : function(){     
                                           let $this = this;   
                                          $(document).ready(function() {
                                              //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
                                              $( "#country_id" ).on( "change", function() {
                                                  var countryId = $('#country_id').val();
                                                  if(countryId == ''){
                                                      countryId = 0;
                                                  }
                                                  $.ajax({
                                                      method: "GET",
                                                      url: _BASE_URL+"/candidate/get-country-states/"+countryId,
                                                      dataType:'json',								                  
                                                      headers: {
                                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                      },
                                                      success: function(jsonStates) {
                                                          $this.refreshStateDropDown(jsonStates);
                                                          var jsonCity = [];
                                                          $this.refreshCityDropDown(jsonCity);
                                                      }
                                                  }); 
                                              }); 
                                                
                                          });
                                      },
                                      removeFreezPagePopupModal: function($button){
                                          document.body.style.cursor = ""; // so it goes back to previous CSS defined value 
                                          $button.prop('disabled', false);
                                       },
                                      freezPagePopupModal: function($button){
                                          document.body.style.cursor = "progress";
                                          $button.prop('disabled', true);
                                       },
                                      refreshStateDropDown : function(jsonStates){								    						
                                          $this = this;													    						
                                          let stateSelectBox = '<select name="state_id[]" data-placeholder="'+$this.lanFilter(allMsgText.STATE)+' *" id="state" class="form-control multi-select-states" multiple="multiple" style="display:none"></select>';
                                          stateSelectBox = $(stateSelectBox);
                                          $.each(jsonStates, function(key, row) {	
                                              stateSelectBox.append('<option value="' + row.id+ '">' + row.name + '</option>');
                                          });
                                          $(".multi-select-states-area").append(stateSelectBox);
                                          $(".multi-select-states-area").find('select').eq(0).remove();
                                          $(".multi-select-states-area").find('.dashboardcode-bsmultiselect').eq(0).remove();
                                          $(".multiple-select select.multi-select-states").bsMultiSelect();
                                      
                                      },
                                      getCityOnSelect : function(){
                                          var $this = this;
                                          $(document).on('click','.custom-control',function(){
                                              let mainSelect = $(this).parents('.multi-select-states-area').find('select');
                                              var stateArr = [];
                                              $.each(mainSelect.find('option'),function(key, row) {
                                                  if($(this).is(':selected')){
                                                      //console.log($(this).val());
                                                      stateArr.push($(this).val());
                                                      console.log(stateArr);
                                                      $.ajax({
                                                          method: "POST",
                                                          url: _BASE_URL+"/get-multistates-multicity",
                                                          data: {'state_id': stateArr},
                                                          dataType:'json',								                  
                                                          headers: {
                                                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                          },
                                                          success: function(jsonCity) {
                                                              $this.refreshCityDropDown(jsonCity);
                                                              
                                                          }
                                                      }); 
                                                  }
                                                  
                                              });
  
                                          });
  
                                          $(document).on('click','.multi-select-states-area .close',function(){
                                              //console.log('gfgdgdfg');
                                              var $that = $(this);
                                              setTimeout(function(){
                                                  let mainSelect = $('.badge .close').parents('.multi-select-states-area').find('select');
                                              var stateArr1 = [];
                                              var isStateAvailable = false;
                                              $.each(mainSelect.find('option'),function(key, row) {
                                                  if($(this).is(':selected')){
                                                      isStateAvailable = true;
                                                      //console.log($(this).val());
                                                      stateArr1.push($(this).val());
                                                      $.ajax({
                                                          method: "POST",
                                                          url: _BASE_URL+"/get-multistates-multicity",
                                                          data: {'state_id': stateArr1},
                                                          dataType:'json',								                  
                                                          headers: {
                                                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                          },
                                                          success: function(jsonCity) {
                                                              $this.refreshCityDropDown(jsonCity);
                                                              
                                                          }
                                                      }); 
                                                  }
                                                  
                                              });
                                              if(!isStateAvailable){
                                                  $this.refreshCityDropDown([]);
                                              }
                                              console.log(stateArr1);
                                              },500);
  
                                          });
  
                                      },
                                      refreshCityDropDown : function(jsonCity){								    						
                                          $this = this;													    						
                                          let citySelectBox = '<select name="city[]" data-placeholder="'+$this.lanFilter(allMsgText.CITY)+' *" id="city" class="form-control multi-select-city" multiple="multiple" style="display:none"></select>';
                                          citySelectBox = $(citySelectBox);
                                          $.each(jsonCity, function(key, row) {	
                                              citySelectBox.append('<option value="' + row.name+ '">' + row.name + '</option>');
                                          });
                                          $(".multi-select-city-area").append(citySelectBox);
                                          $(".multi-select-city-area").find('select').eq(0).remove();
                                          $(".multi-select-city-area").find('.dashboardcode-bsmultiselect').eq(0).remove();
                                          $(".multiple-select select.multi-select-city").bsMultiSelect();
                                      
                                      },
                                      postJob : function(){
                                          try{
                                              var $this = this;
                                              $(document).ready(function(){
  
                                                  $('#description').summernote({
                                                      height: 250,
                                                      
                                                  });
                                                  
                                                  // CKEDITOR.on('dialogDefinition', function(ev)
                                                  // 		{
                                                  // 			var dialogName = ev.data.name;
                                                  // 			var dialogDefinition = ev.data.definition;
                                                  // 			if (dialogName == 'image')
                                                  // 			{
                                                  // 				dialogDefinition.contents[2].elements[0].label = 'Upload File';
                                                  // 				dialogDefinition.contents[2].elements[1].label = 'Upload';
                                                  // 			}
  
                                                  // 			if (dialogName == 'image') {
                                                  // 				dialogDefinition.removeContents( 'Link' );
                                                  // 				dialogDefinition.removeContents( 'info' );
                                                  // 			}
                                                  // 			if (dialogName == 'image') {
                                                  // 				dialogDefinition.removeContents( 'Info' );
                                                  // 			}
                                                  // });
                                                                                          
                                                  //CKEDITOR.replace( 'description');
                                                  $('.descErr').text('');
                                                  $('.error-state').text('');
                                                  $.validator.addMethod("noSpace", function(value, element) { 
                                                      if(value != ''){
                                                          value = $.trim(value);
                                                          if(value == ''){
                                                              return false;
                                                          }else{
                                                              return true;
                                                          }	
                                                      }
                                                      //return value.indexOf(" ") < 0 && value != ""; 
                                                    }, $this.lanFilter($this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY)));
                                                      $("#post_job").validate({
                                                          rules: {
                                                              title: { 
                                                                  required: true ,
                                                                  noSpace: true,
                                                                  maxlength: 255
                                                              },
                                                              country_id: { 
                                                                  required: true 
                                                              },
                                                           
                                                              seniority: { 
                                                                  required: true 
                                                              },
                                                              seniority_other: {
                                                                  required: function(element){
                                                                      if(($("#seniority").val() != '') && $("#seniority").val() == "other"){
                                                                          return true;
                                                                      }
                                                                  },
                                                                  noSpace: true
                                                              },
                                                              employment: { 
                                                                  required: true 
                                                              },
                                                              employment_other: {
                                                                  required: function(element){
                                                                      if(($("#employment").val() != '') && $("#employment").val() == "other"){
                                                                          return true;
                                                                      }
                                                                  },
                                                                  noSpace: true
                                                              },
                                                              screening_1: {
                                                                  maxlength: 1000,
                                                              },
                                                              screening_2: { 
                                                                  maxlength: 1000
                                                              },
                                                              screening_3: { 
                                                                  maxlength: 1000
                                                              },
                                                              interview_1: { 
                                                                  maxlength: 1000
                                                              },
                                                              interview_2: { 
                                                                  maxlength: 1000
                                                              },
                                                              interview_3: { 
                                                                  maxlength: 1000
                                                              },
                                                              description: { 
                                                                  required: true,
                                                                  noSpace: true,
                                                                  maxlength: 5000 
                                                              },
                                                              start_date: { 
                                                                  required: true 
                                                              },	
                                                              end_date: { 
                                                                  required: true 
                                                              },
                                                              applied_by: { 
                                                                  required: true 
                                                              },
                                                              website_link: { 
                                                                  required: true ,
                                                                  url: true
                                                              }	
                                                          },
                                                          messages: {
                                                              title: {
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_POSITION_NAME),
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_255_CHARACTER),
                                                              },
                                                              country_id: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_COUNTRY) 
                                                              },
                                                           
                                                              seniority: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_SENIORITY_LEVEL) 
                                                              },
                                                              seniority_other: {
                                                                  required: function(element){
                                                                      if(($("#seniority").val() != '') && $("#seniority").val() == "other"){
                                                                          return $this.lanFilter(allMsgText.PLEASE_ENTER_SENIORITY_LEVEL);
                                                                      }
                                                                  }
                                                              },
                                                              employment: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_EMPLOYMENT_TYPE) 
                                                              },
                                                              employment_other: {
                                                                  required: function(element){
                                                                      if(($("#employment").val() != '') && $("#employment").val() == "other"){
                                                                          return $this.lanFilter(allMsgText.PLEASE_ENTER_EMPLOYMENT_LEVEL);
                                                                      }
                                                                  }
                                                              },
                                                              screening_1: {
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              screening_2: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              screening_3: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              interview_1: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              interview_2: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              interview_3: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              description: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_DESCRIPTION)
                                                              },
                                                              start_date: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_START_DATE)
                                                              },	
                                                              end_date: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_END_DATE) 
                                                              },
                                                              applied_by: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_APPLY_THROUGH) 
                                                              },
                                                              website_link: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_WEBSITE_LINK) ,
                                                                  url: $this.lanFilter(allMsgText.PLEASE_ENTER_VALID_URL)
                                                              }
                          
                                                          },
                                                          submitHandler : function(form){	
                                                              var state = $('#state').val();
                                                              // var desc = CKEDITOR.instances['description'].getData( ).replace( /<[^>]*>/gi, '' ).length;
                                                              //alert(state);
  
                                                              var desc = $('#description').val();
                                                              if(!desc){
                                                                  $('.descErr').css('display','block');
                                                                  $('.descErr').text($this.lanFilter(allMsgText.PLEASE_ENTER_DESCRIPTION));
                                                                  return false;
                                                              }
                                                              form.submit();
                                                              // if(state != null){
                                                              // 	// var city = $('#city').val();
                                                              // 	// if(city != null){
                                                              // 		var mandatory = $('#mandatory_setting').val();
                                                              // 		var one = $.trim($('#interview_1').val());
                                                              // 		var two = $.trim($('#interview_2').val());
                                                              // 		var three = $.trim($('#interview_3').val());
                                                                      
                                                              // 		if((mandatory == 1) && (one == '') && (two == '') && (three == '')){
                                                              // 			$('.error-interview').css('display','block');
                                                              // 			$('.error-interview').text($this.lanFilter(allMsgText.PLEASE_ENTER_ANY_ONE_QUESTION));
                                                              // 			return false;
                                                              // 		}else if((mandatory == 2) && (one == '') && (two == '') && (three == '')){
                                                              // 			$('.error-interview').css('display','block');
                                                              // 			$('.error-interview').text($this.lanFilter(allMsgText.PLEASE_ENTER_ANY_ONE_QUESTION));
                                                              // 			return false;
                                                              // 		}else if(mandatory == 3 && (((one == '') && (two == '') && (three == '')) || ((one != '') && ((two == '') && (three == ''))) || ((two != '') && ((one == '') && (three == ''))) || ((three != '') && ((one == '') && (two == ''))))){
                                                              // 			$('.error-interview').css('display','block');
                                                              // 			$('.error-interview').text($this.lanFilter(allMsgText.PLEASE_ENTER_ANY_TWO_QUESTION));
                                                              // 			return false;
                                                              // 		}else{
                                                              // 			var $profileBtn = $(".section-myprofile").find(".submit-job-post");
                                                              // 			$profileBtn.text($this.lanFilter(allMsgText.SUBMITTING)+'...');
                                                              // 			$this.freezPagePopupModal($profileBtn);
                                                              // 			//await sleep(2000);
                                                              // 			form.submit();
                                                              // 		}
                                                              // 	// }else{
                                                              // 	// 	$('.error-city').css('display','block');
                                                              // 	// 	$('.error-city').text($this.lanFilter(allMsgText.PLEASE_SELECT_CITY));
                                                              // 	// 	return false;
                                                              // 	// }
                                                              // }else{
                                                              // 	$('.error-state').css('display','block');
                                                              // 	$('.error-state').text($this.lanFilter(allMsgText.PLEASE_SELECT_STATE));
                                                              // 	return false;
                                                              // }
                                                              
                                                          }
                                                      });
                                              });
                                          }catch(error){
                                              console.log('Validate Candidate Profile info :: '+error);
                                          }
                                      },
                                      jobDetails : function(){
                                          $(document).ready(function() {
                                          $( ".open_details" ).on( "click", function() {
                                              var $this = this;
                                              var jobId = $($this).attr("data-id");
                                              var type = $('#user').val();
                                                  if(type == 2){
                                                      type = 'candidate';
                                                  }else{
                                                      type = 'company';
                                                  }
                                              $.ajax({
                                                  method: "GET",
                                                  url: _BASE_URL+"/"+type+"/job-details",
                                                  data: {'id': jobId},
                                                  headers: {
                                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                  },
                                                  success: function(res) {
                                                      var div = $('.mCustomScrollbar').find('.active');
                                                      div.removeClass('active');
                                                      $("#open_details_"+jobId).addClass("active");
                                                      $('#job_details').html(res);
                                                  }
                                              }); 
                                          }); 
                                      });
                                      },
                                      jobSearch : function(){
                                           let $this = this;  
                                          $(document).ready(function() {
                                              //FOR COMPANY
                                              $( ".search-cls" ).on( "click", function() {
                                                  var startDate = $('#start_date').val(); 
                                                  var endDate = $('#end_date').val(); 
                                                  var title = $('#title').val(); 
                                                  //var countryId = $('#country_id_search').val(); 
                                                  var stateId = $('#state').val(); 
                                                  var jobId = $('#job_id').val(); 
                                                  var status = $('#status').val(); 
                                                  
                                                  if((startDate != '') && (endDate == '')){
                                                      $('.error-end-date').css('display','block');
                                                      $('.error-end-date').text($this.lanFilter(allMsgText.PLEASE_SELECT_END_DATE)).delay(3000).fadeOut(600);
                                                      return false;
                                                  }
                                                  if((startDate == '') && (endDate == '') && (title == '') && (stateId == '') && (status == '') && (jobId == '')){
                                                      $('.error-required-search').css('display','block');
                                                      $('.error-required-search').text($this.lanFilter(allMsgText.PLEASE_SELECT_ANY_ONE_SEARCH_VALUE)).delay(3000).fadeOut(600);
                                                      return false;
                                                  }
                                              });
                                              //FOR CANDIDATE
                                              $( ".search-job-cls" ).on( "click", function() {
                                                  var radioValue = $("input[name='company']:checked").val();
                                                  if(radioValue == 1){
                                                      var position_name = $('#position_name').val(); 
                                                      var jobid = $('#job_id').val();
                                                      var state = $('#state').val();
                                                      var city = $('#city').val();
                                                      if((position_name == '' || position_name == null) && (jobid == '' || jobid == null) && (state == '' || state == null) && (city == '' || city == '')){
                                                          $('.error-position-name').css('display','block');
                                                          $('.error-position-name').css('color','red');
                                                          $('.error-position-name').text($this.lanFilter(allMsgText.PLEASE_SELECT_ANYONE_SEARCH_CRITERIA)).delay(3000).fadeOut(600);
                                                          return false;
                                                      }
                                                  }
                                                  else if(radioValue == 2){
                                                      var company_name = $('#company_name').val(); 
                                                      if(company_name == '' || company_name == null){
                                                          $('.error-company-name').css('display','block');
                                                          $('.error-company-name').css('color','red');
                                                          $('.error-company-name').text($this.lanFilter(allMsgText.PLEASE_SELECT_COMPANY_NAME)).delay(3000).fadeOut(600);
                                                          return false;
                                                      }
                                                  }
                                                  
                                                  
                                              });
                                              //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
                                              $( "#country_id_search" ).on( "change", function() {
                                                  var countryId = $('#country_id_search').val();
                                                  if(countryId == ''){
                                                      countryId = 0;
                                                  }
                                                  var type = $('#user').val();
                                                  if(type == 2){
                                                      type = 'candidate';
                                                  }else{
                                                      type = 'company';
                                                  }
                                                  $.ajax({
                                                      method: "GET",
                                                      url: _BASE_URL+"/"+type+"/get-country-states/"+countryId,
                                                      dataType:'json',								                  
                                                      headers: {
                                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                      },
                                                      success: function(jsonStates) {
                                                          let stateSelectBox = '<select name="state"  id="state" class="form-control">';
                                                          stateSelectBox = $(stateSelectBox);
                                                          stateSelectBox.append('<option value=""> '+$this.lanFilter(allMsgText.STATE)+' </option>');
                                                          $.each(jsonStates, function(key, row) {	
                                                              stateSelectBox.append('<option value="' + row.id+ '">' + row.name + '</option>');
                                                          });
                                                          $(".multi-select-states-area").append(stateSelectBox);
                                                          $(".multi-select-states-area").find('select').eq(0).remove();
                                                      }
                                                  }); 
                                              }); 
                                              
                                              //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
                                              $( "#country_id_search_company" ).on( "change", function() {
                                                  var type = $('#user').val();
                                                  var countryId = $('#country_id_search_company').val();
                                                  if(countryId == ''){
                                                      countryId = 0;
                                                  }
                                                  if(type == 2){
                                                      type = 'candidate';
                                                  }else{
                                                      type = 'company';
                                                  }
                                                  $.ajax({
                                                      method: "GET",
                                                      url: _BASE_URL+"/"+type+"/get-country-states/"+countryId,
                                                      dataType:'json',								                  
                                                      headers: {
                                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                      },
                                                      success: function(jsonStates) {
                                                          let stateSelectBox = '<select name="state_comp"  id="state_comp" class="form-control">';
                                                          stateSelectBox = $(stateSelectBox);
                                                          stateSelectBox.append('<option value=""> '+$this.lanFilter(allMsgText.STATE)+' </option>');
                                                          $.each(jsonStates, function(key, row) {	
                                                              stateSelectBox.append('<option value="' + row.id+ '">' + row.name + '</option>');
                                                          });
                                                          $(".multi-select-states-area-company").append(stateSelectBox);
                                                          $(".multi-select-states-area-company").find('select').eq(0).remove();
                                                      }
                                                  }); 
                                              }); 
                                                
                                          });
                                      },
                                      jobAlert : function(){
                                          
                                          $this = this;
                                          $(document).on('click','#start',function(){
                                                  var isSelected = '';
                                                  var text = '';
                                                  if($(this).prop('checked')) {
                                                      isSelected = 1;
                                                      text = $this.lanFilter(allMsgText.ALERT_SETTING_START);
                                                  } else {
                                                      isSelected = 0;
                                                      text = $this.lanFilter(allMsgText.ALERT_SETTING_STOP);
                                                  }
                                                  
                                                  swal({
                                                      title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                                      text: text,
                                                      icon: "warning",
                                                      buttons: true,
                                                      dangerMode: true,
                                                  })
                                                  .then((willConfirm) => {
                                                      if (willConfirm) {
                                                          if(isSelected == 0){
                                                              $(this).prop("checked", false);
                                                              $.ajax({
                                                                  method: "POST",
                                                                  url: _BASE_URL+"/candidate/job-alert",
                                                                  data: {'isSelected': isSelected},
                                                                  headers: {
                                                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                  },
                                                                  success: function(res) {
                                                                      
                                                                  }
                                                              }); 
                                                          }else if(isSelected == 1){
                                                              var radioValue = $("input[name='company']:checked").val();
                                                              if(radioValue == 1){
                                                                  var position_name = $('#position_name').val(); 
                                                                  var jobid = $('#job_id').val();
                                                                  var state = $('#state').val();
                                                                  var city = $('#city').val();
                                                                  var datas = {'isSelected': isSelected,'position_name':position_name,'job_id':jobid,'state':state,'city':city,'company':radioValue};
                                                              }else if(radioValue == 2){
                                                                  var company_name = $('#company_name').val(); 
                                                                  var state_comp = $('#state_comp').val();
                                                                  var city_comp = $('#city_comp').val();
                                                                  var datas = {'isSelected': isSelected,'company_name':company_name,'state_comp':state_comp,'city_comp':city_comp,'company':radioValue};
                                                              }
  
                                                              $.ajax({
                                                                  method: "POST",
                                                                  url: _BASE_URL+"/candidate/set-job-alert-history",
                                                                  data: datas,
                                                                  headers: {
                                                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                  },
                                                                  success: function(res) {
                                                                      console.log(res);
                                                                  }
                                                              }); 
                                                          }
                                                      
                                                      }else{
                                                          if(isSelected == 1){
                                                              $(this).prop("checked", false);
                                                          }else{
                                                              $(this).prop("checked", true);
                                                          }
                                                          
                                                      }
                                                  });
                                              
                                          });
                                      },
                                      saveJob : function(){
                                          $this = this;
                                          $(document).on('click','.saveJobCls',function(){
                                              var jobId = $(this).attr("data-id");
                                              var saveType = $(this).attr("data-type");
                                              $.ajax({
                                                  method: "POST",
                                                  url: _BASE_URL+"/candidate/save-job",
                                                  data: {'id': jobId, 'saveType' : saveType},
                                                  headers: {
                                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                  },
                                                  success: function(res) {
                                                      if(saveType == 1){
                                                          $("#save-job-"+jobId).text($this.lanFilter(allMsgText.SAVED));
                                                          $('#save-job-'+jobId).attr('data-type', 0);
                                                      }else{
                                                          $("#save-job-"+jobId).text($this.lanFilter(allMsgText.SAVE_JOB));
                                                          $('#save-job-'+jobId).attr('data-type', 1);
  
                                                      }
                                                      
                                                  }
                                              }); 
                                           
                                      });
                                      },
                                      showSuccessMsg : function(msg){
                                          let msgBox = $(".alert-holder-success");
                                          msgBox.addClass('success-block');
                                          msgBox.find('.alert-holder').html(msg);
                                          setTimeout(function(){ msgBox.removeClass('success-block')},5000);
                                      },
                                      jobAlertDelete : function()
                                      {
                                      var $this = this;
                                      $(document).on('click','#alert-delete-id',function(){
                                          var alertId = $(this).attr("data-id");                                
                                          swal({
                                              title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                              text: $this.lanFilter(allMsgText.DO_YOU_REALLY_WANT_TO_DELETE_THIS_ALERT),
                                              icon: "warning",
                                              buttons: true,
                                              dangerMode: true,
                                              })
                                              .then((willDelete) => {
                                              if (willDelete) {
                                                  $.ajax({
                                                  url: _BASE_URL+"/candidate/delete-job-alert",
                                                  data:{'id': alertId},
                                                  method:'POST',
                                                  headers: {
                                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                          },
                                                  success: function(response){
                                                          $("#alert_row_"+alertId).fadeOut(function(){
                                                              $(this).remove();
                                                              if(response == 0){
                                                                  var nodataHtml = '<div class="col-12"><div class="nodata-found-holder"><img src="'+_BASE_URL+'/frontend/images/warning-icon.png" alt="notification" class="img-fluid"/><h4>'+$this.lanFilter(allMsgText.SORRY_NO_JOBS_FOUND)+'</h4></div></div>';
                                                                  $(".followers-list").html(nodataHtml);
                                                              }
                                                          });
                                                          let msg = $this.lanFilter(allMsgText.YOUR_JOB_ALERT_IS_REMOVED_SUCCESSFULLY);
                                                          $this.showSuccessMsg(msg);
                                                  },
                                                  error: function(){
                                                          alert("Something happend wrong.Please try again");
                                                          
                                                  }	
                                                  })
                                              }
                                              });										
                                          
                                          });
                                      },
                                      CopyLink : function() 
                                      {
                                          var $this = this;
                                          $(document).on('click','#copyButton',function(e){
                                              e.preventDefault();
                                              //var $this = this;
                                              var postId = $(this).attr("data-id");
                                              var copyText = $('.copy_link_id_'+postId).attr('href');
                                              document.addEventListener('copy', function(e) {
                                                  e.clipboardData.setData('text/plain', copyText);
                                                  e.preventDefault();
                                              }, true);
                                              document.execCommand('copy');  
                                              let msg = $this.lanFilter(allMsgText.LINKED_COPIED_SUCCESSFULLY);
                                              $this.showSuccessMsg(msg);
                                          });
                                          
                                      },
                                      SharePost : function(){
                                          var $this = this;
                                          $(document).on('click','#share-post-modal-id',function(){
                                              var postId = $(this).attr("data-id");
                                              var url = _BASE_URL+"/post-share-data";
                                          $.ajax({
                                                  url: url,
                                                  data:{'post_id' : postId},
                                                  method:'POST',
                                                  dataType:'json',
                                                  headers: {
                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                  },
                                                  success: function(response){
                                                     
                                                      $('#share-post-modal').modal('show');
                                                      $('#share-post-modal').find('#post_id').val(postId);
                                                      if(response != 1){
                                                          $('#share-post-modal').find('.post_no_data').html(response.html);
                                                      }else{
                                                          var nodata = '<div class="post-block mb-0"><i class="fa fa-lock fa-lg" aria-hidden="true" ></i><h6 class="total-sub-title">'+$this.lanFilter(allMsgText.POST_NOT_AVAILABLE)+'</h6><p class="mb-0">'+$this.lanFilter(allMsgText.POST_NOT_AVAILABLE)+'</p></div>';
                                                          $('#share-post-modal').find('.post_no_data').html(nodata);
                                                      }
                                                          
                                                  },
                                                  error: function(e){
                                                      
                                                          alert("Something happend wrong.Please try again");
                                                          
                                                  }	
                                              }).done(function() {
                                                              
                                              });	
                                              
                                              
                                          });
                                          
                                      },
                                      ReportPost : function(){
                                          $(document).on('click','#report-post-id',function(){
                                              var $this = this;
                                              var postId = $($this).attr("data-id");
                                              $('#report-modal').modal('show');
                                              $('#report-modal').find('#post_id').val(postId);
                                          });
                                          try{
                                              var $this = this;
                                              $(document).ready(function(){
                                                      $("#reportPost").validate({
                                                          rules: {
                                                              comment: { 
                                                                  required: true ,
                                                                  maxlength: 5000
                                                              },			
                                                          },
                                                          messages: {
                                                              comment: {
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_A_COMMENT),
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                                                              }
          
                                                          },
                                                          submitHandler : function(form){	
                                                              $this.submitReportPost(); 
                                                              return false;  
                                                          }
                                                      });
                                              });
                                          }catch(error){
                                              console.log('Validate Candidate Profile info :: '+error);
                                          }
                                      },
                                      submitReportPost : function(){
                                          var $this = this;
                                          var url = _BASE_URL+"/report-post";										   					
                                          var report = document.getElementById("reportPost");   
                                          var fd = new FormData(report);
                                          $.ajax({
                                                  url: url,
                                                  data:fd,
                                                  method:'POST',
                                                  dataType:'json',
                                                  cache : false,
                                                  processData: false,
                                                  contentType: false,
                                                  headers: {
                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                  },
                                                  success: function(response){
                                                          let msg = $this.lanFilter(allMsgText.YOUR_REPORT_COMMENT_SUBMITTED_SUCCESSFULLY);
                                                          $this.showSuccessMsg(msg);
                                                  },
                                                  error: function(){
                                                          alert("Something happend wrong.Please try again");
                                                          
                                                  }	
                                              }).done(function() {
                                                 // $("#report-modal-open").modal('hide');
                                                 location.reload(true);             
                                              });	
          
                                      }, 
                                      EditJob : function(){
                                          try{
                                              var $this = this;
                                              $(document).ready(function(){
  
                                                  $('#description').summernote({
                                                      height: 250,
                                                  });
  
                                                  // CKEDITOR.replace( 'description', {
                                                  // 	toolbar: [
                                                  // 		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'ExportPdf', 'Preview', 'Print', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                                                  // 					// Defines toolbar group without name.
                                                  // 		'/',																					// Line break - next group will be placed in new line.
                                                  // 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },
                                                  // 		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ] },
                                                  // 	]
                                                  // });
                                                  $('.descErr').text('');
                                                  $('.error-state').text('');
                                                  $.validator.addMethod("noSpace", function(value, element) { 
                                                      if(value != ''){
                                                          value = $.trim(value);
                                                          if(value == ''){
                                                              return false;
                                                          }else{
                                                              return true;
                                                          }	
                                                      }
  
                                                      //return value.indexOf(" ",1) < 0 && value != ""; 
                                                    }, $this.lanFilter($this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY)));
                                                      $("#edit_job").validate({
                                                          rules: {
                                                              title: { 
                                                                  required: true,
                                                                  noSpace: true,
                                                                  maxlength: 255
                                                              },
                                                              country_id: { 
                                                                  required: true 
                                                              },
                                                              seniority: { 
                                                                  required: true 
                                                              },
                                                              seniority_other: {
                                                                  required: function(element){
                                                                      if(($("#seniority").val() != '') && $("#seniority").val() == "other"){
                                                                          return true;
                                                                      }
                                                                  }
                                                              },
                                                              employment: { 
                                                                  required: true 
                                                              },
                                                              employment_other: {
                                                                  required: function(element){
                                                                      if(($("#employment").val() != '') && $("#employment").val() == "other"){
                                                                          return true;
                                                                      }
                                                                  }
                                                              },
                                                              screening_1: {
                                                                  maxlength: 1000,
                                                              },
                                                              screening_2: { 
                                                                  maxlength: 1000
                                                              },
                                                              screening_3: { 
                                                                  maxlength: 1000
                                                              },
                                                              interview_1: { 
                                                                  maxlength: 1000
                                                              },
                                                              interview_2: { 
                                                                  maxlength: 1000
                                                              },
                                                              interview_3: { 
                                                                  maxlength: 1000
                                                              },
                                                              description: { 
                                                                  required: true,
                                                                  noSpace: true,
                                                                  maxlength: 5000 
                                                              },
                                                              start_date: { 
                                                                  required: true 
                                                              },	
                                                              end_date: { 
                                                                  required: true 
                                                              },
                                                              applied_by: { 
                                                                  required: true 
                                                              },
                                                              website_link: { 
                                                                  required: true ,
                                                                  url: true
                                                              }	
                                                          },
                                                          messages: {
                                                              title: {
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_POSITION_NAME),
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_255_CHARACTER),
                                                              },
                                                              country_id: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_COUNTRY) 
                                                              },
                                                              seniority: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_SENIORITY_LEVEL) 
                                                              },
                                                              seniority_other: {
                                                                  required: function(element){
                                                                      if(($("#seniority").val() != '') && $("#seniority").val() == "other"){
                                                                          return $this.lanFilter(allMsgText.PLEASE_ENTER_SENIORITY_LEVEL);
                                                                      }
                                                                  }
                                                              },
                                                              employment: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_EMPLOYMENT_TYPE) 
                                                              },
                                                              employment_other: {
                                                                  required: function(element){
                                                                      if(($("#employment").val() != '') && $("#employment").val() == "other"){
                                                                          return $this.lanFilter(allMsgText.PLEASE_ENTER_EMPLOYMENT_LEVEL);
                                                                      }
                                                                  }
                                                              },
                                                              screening_1: {
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              screening_2: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              screening_3: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              interview_1: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              interview_2: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              interview_3: { 
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_1000_CHARACTER),
                                                              },
                                                              description: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_DESCRIPTION),
                                                                  maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                                              },
                                                              start_date: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_START_DATE) 
                                                              },	
                                                              end_date: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_END_DATE) 
                                                              },
                                                              applied_by: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_SELECT_APPLY_THROUGH) 
                                                              },
                                                              website_link: { 
                                                                  required: $this.lanFilter(allMsgText.PLEASE_ENTER_WEBSITE_LINK) ,
                                                                  url: $this.lanFilter(allMsgText.PLEASE_ENTER_VALID_URL)
                                                              }
                          
                                                          },
                                                          submitHandler : function(form){	
                                                              // var desc = CKEDITOR.instances['description'].getData( ).replace( /<[^>]*>/gi, '' ).length;
                                                              //var desc = $('#description').val();
                                                              var desc = $('#description').val();
                                                              //alert(desc);
                                                              if(!desc){
                                                                  $('.descErr').css('display','block');
                                                                  $('.descErr').text($this.lanFilter(allMsgText.PLEASE_ENTER_DESCRIPTION));
                                                                  return false;
                                                              }
                                                              /* var state = $('#state').val();
                                                              //alert(state);
                                                              if(state != null){ */
                                                                  var city = $('#city').val();
                                                                  if(city != null){
                                                                      var mandatory = $('#mandatory_setting').val();
                                                                      var one = $.trim($('#interview_1').val());
                                                                      var two = $.trim($('#interview_2').val());
                                                                      var three = $.trim($('#interview_3').val());
                                                                      if(((one != '') || (two != '') || (three != '')) && (mandatory == '')){
                                                                          $('.mandatory_setting_error').css('display','block');
                                                                          $('.mandatory_setting_error').text($this.lanFilter(allMsgText.PLEASE_SELECT_MANDATORY_SETTING));
                                                                          return false;
                                                                      }
                                                                      if((mandatory == 1) && (one == '') && (two == '') && (three == '')){
                                                                          $('.error-interview').css('display','block');
                                                                          $('.error-interview').text($this.lanFilter(allMsgText.PLEASE_ENTER_ANY_ONE_QUESTION));
                                                                          return false;
                                                                      }else if((mandatory == 2) && (one == '') && (two == '') && (three == '')){
                                                                          $('.error-interview').css('display','block');
                                                                          $('.error-interview').text($this.lanFilter(allMsgText.PLEASE_ENTER_ANY_ONE_QUESTION));
                                                                          return false;
                                                                      }else if(mandatory == 3 && (((one == '') && (two == '') && (three == '')) || ((one != '') && ((two == '') && (three == ''))) || ((two != '') && ((one == '') && (three == ''))) || ((three != '') && ((one == '') && (two == ''))))){
                                                                          $('.error-interview').css('display','block');
                                                                          $('.error-interview').text($this.lanFilter(allMsgText.PLEASE_ENTER_ANY_TWO_QUESTION));
                                                                          return false;
                                                                      }else{
                                                                          var $profileBtn = $(".section-myprofile").find(".submit-job-post");
                                                                          $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
                                                                          $this.freezPagePopupModal($profileBtn);
                                                                          //await sleep(2000);
                                                                          form.submit();
                                                                      }
                                                                  }else{
                                                                      $('.error-city').css('display','block');
                                                                      $('.error-city').text($this.lanFilter(allMsgText.PLEASE_SELECT_CITY));
                                                                      return false;
                                                                  }
                                                              /* }else{
                                                                  $('.error-state').css('display','block');
                                                                  $('.error-state').text($this.lanFilter(allMsgText.PLEASE_SELECT_STATE));
                                                                  return false;
                                                              } */
                                                              
                                                              
                                                              
                                                          }
                                                      });
                                              });
                                          }catch(error){
                                              console.log('Validate Candidate Profile info :: '+error);
                                          }
                                      },
                                      
                                      getCountryOnCountrySelect: function(){
                                          let $this = this;
                                          $(document).on("change","#country_id",function(){
                                                  let country_id = $(this).val();
                                                  if(country_id != ''){
                                                      $this.getCountryStates(country_id);									  								
                                                  }
                                                  
                                          });
                                      },
                                      getCountryStates : function(countryId){
                                          let $this = this;
                                          var user_type = $('#user').val();
                                              if(user_type == 3){
                                                  var url_store = _BASE_URL+"/company/get-country-states/"+countryId;
                                              }else{
                                                  var url_store = _BASE_URL+"/candidate/get-country-states/"+countryId;
                                              }
                                          $.ajax({
                                                      url: url_store,																  
                                                      method:'GET',
                                                      dataType:'json',
                                                      cache : false,
                                                      processData: false,
                                                      contentType: false,
                                                      headers: {
                                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                      },
                                                      success: function(response){
                                                          console.log(response);
                                                                  $this.populateStatesByCountry(response);																  			
                                                      },
                                                      error: function(){
                                                              alert("Something happend wrong.Please try again");
                                                      }	
                                              });
                                          },		
                                          populateStatesByCountry: function(jsStates){							
                                              let $this = this;
                                              let dropdown = $('#state_id');console.log(dropdown);
                                              dropdown.empty();
                                              
                                              //dropdown.parent('.multiple-select').find('.dashboardcode-bsmultiselect').remove();
                                              dropdown.append($('<option></option>').attr('value',"").text("State"));
                                              $.each(jsStates, function (key, entry) {
                                                      dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                                              });
                                              // setTimeout(function(){
                                              // 		$this.bsMultiselectInitialise();
                                              // },1500);
                                          },
                                          getCity : function(){     
                                              let $this = this;   
                                              $(document).ready(function() {
                                                  //UPDATE CITY DRPDOWN ON CHANGE OF STATE
                                                  $( "#state_id" ).on( "change", function() {
                                                      var stateId = $('#state_id').val();
                                                      
                                                      if(stateId == ''){
                                                          stateId = 0;
                                                      }
                                                      var user_type = $('#user').val();
                                                      if(user_type == 3){
                                                          var url_store = _BASE_URL+"/company/get-states-city/"+stateId;
                                                      }else{
                                                          var url_store = _BASE_URL+"/candidate/get-states-city/"+stateId;
                                                      }
                                                      
                                                      $.ajax({
                                                          method: "GET",
                                                          url: url_store,
                                                          dataType:'json',								                  
                                                          headers: {
                                                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                          },
                                                          success: function(jsonCity) {
                                                          let stateSelectBox = '<option value=""> '+$this.lanFilter(allMsgText.CITY)+' </option>';
                                                          $.each(jsonCity, function(key, row) {	
                                                              stateSelectBox += '<option value="' + row.id+ '">' + row.name + '</option>';
                                                          });
                                                          $(".select-city-area").html(stateSelectBox);
                                                          }
                                                      }); 
                                                  }); 
                                                      
                                              });
                                          },
                                          blockUnblockUser : function(){
                                              var $this = this;
                                              $(document).on('click','.block_user',function(event){  
                                              var userId = $(this).attr("data-id");
                                              var tag = $(this).attr("data-block");
                                              var url = _BASE_URL+"/block-unblock-user";
                                              if(tag == 1){
                                                  var msg = $this.lanFilter(allMsgText.ONCE_BLOCK_THIS_USER);
                                              }else{
                                                  var msg = $this.lanFilter(allMsgText.ONCE_UNBLOCK_THIS_USER);
                                              }
                                              
                                              swal({
                                                  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                                  text: msg,
                                                  icon: "warning",
                                                  buttons: true,
                                                  dangerMode: true,
                                              })
                                              .then((willDelete) => {
                                                  if (willDelete) {
                                                      $.ajax({
                                                          url: url,
                                                          data:{'user_id' : userId,'tag' : tag},
                                                          method:'POST',
                                                          async: false,
                                                          dataType:'json',
                                                          headers: {
                                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                          },
                                                          success: function(response){
                                                              location.reload();
                                                              let msg = '';
                                                              if(tag == 1){
                                                                  msg = $this.lanFilter(allMsgText.USER_HAS_BLOCKED_SUCCESSFULLY);
                                                              }else{
                                                                  msg = $this.lanFilter(allMsgText.USER_HAS_UNBLOCKED_SUCCESSFULLY);
                                                              }
                                                              
                                                              let msgBox = $(".alert-holder-success");
                                                              msgBox.addClass('success-block');
                                                              msgBox.find('.alert-holder').html(msg);
                                                              setTimeout(function(){ msgBox.removeClass('success-block')},5000);
                                                                  
                                                          },
                                                          error: function(e){
                                                                  alert("Something happend wrong.Please try again");
                                                                  
                                                          }	
                                                      }).done(function() {
                                                                      
                                                      });	
                                                  }
                                              });			
                                              
                                          
                                              });
                                          
                                          },
                                          applyJob: function(){
                                              let $this = this;
                                              $(document).on('click','.apply-cls',function(){
                                          
                                                  var form_profile_info = document.getElementById("step_one");
                                                  var fd = new FormData(form_profile_info);
                                              
                                                  $.ajax({
                                                          url: _BASE_URL+"/candidate/apply-job-store-all-info",
                                                          data:fd,
                                                          method:'POST',
                                                          dataType:'json',
                                                          cache : false,
                                                          processData: false,
                                                          contentType: false,
                                                          headers: {
                                                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                          },
                                                          success: function(response){
                                                              let msg = '';
                                                              if(response.success == 0){
                                                                  msg = response.message;
                                                              }else{
                                                                  msg = $this.lanFilter(allMsgText.JOB_APPLIED_SUCCESSFULLY);
                                                              }
                                                              $this.showSuccessMsg(msg);
                                                              location.reload();
                                                              //window.location.href = _BASE_URL+"/candidate/my-jobs";
                                                          }
                                                      }).done(function() {
                                                              
                                                  });
                                                      
                                              });
                                          },
                                       
  }
  jobFunctions.init();//initilized
  
