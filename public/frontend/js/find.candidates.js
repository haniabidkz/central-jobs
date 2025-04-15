/**
 * Developer : Israfil
 * Date : 19/04/2020
 * Object is the container of common & usefull function.So we can use it accross the site
 * We need to intialize this object with profileFunctions.init(); before using this
 *
 */
 function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

 const findCandidateFunctions = {
 									base_url : _BASE_URL,
 									defaultProfileImg : _BASE_URL+'/frontend/images/user-pro-img-demo.png', 
 									defaultBannerImg : _BASE_URL+'/frontend/images/user-pro-bg-img.jpg',
 									documentImg : _BASE_URL+'/frontend/images/doc-img.png',
 									pdfImg : _BASE_URL+'/frontend/images/pdf-img.png',
 									deafulCvImg : _BASE_URL+'/frontend/images/document.png',
 																		
 									init : function(){ 		
 											this.addAditionalMethodGroupValidate();
											this.getState();
											this.listing(); 
											this.connectionRequest();
											this.acceptRejectConnection();
											this.blockUnblockUser();
									 },
									 lanFilter : function(str){
										// console.log('str1');
										// console.log(str);
										// console.log('str');
										var res = str.split("|");
										if(res[1] != undefined){
											str = str.replace("|","'");
											return str;
										}else{
											return str;
										}
										
									},
 									addAditionalMethodGroupValidate : function(){
						 										// $(document).ready(function () {
						 										// 		jQuery.validator.addMethod("find_candidate", function (value, element, options) {
																	// 				        var numberRequired = options[0];
																	// 				        var selector = options[1];
																	// 				        var fields = $(selector, element.form);
																	// 				        var filled_fields = fields.filter(function () {
																	// 				            // it's more clear to compare with empty string
																	// 				            return $(this).val() != "";
																	// 				        });
																	// 				        var empty_fields = fields.not(filled_fields);
																	// 				        // we will mark only first empty field as invalid
																	// 				        // if (filled_fields.length < numberRequired && empty_fields[0] == element) {
																	// 				        //     return false;
																	// 				        // }
																	// 				        return true;
																	// 				        // {0} below is the 0th item in the options field
																	// 				    }, jQuery.html("'Please select at least one of field from search field!'"));

						 									
						 										// });
 									},
 									showSuccessMsg : function(msg){
										let msgBox = $(".alert-holder-success");
										msgBox.addClass('success-block');
										msgBox.find('.alert-holder').html(msg);
										setTimeout(function(){ msgBox.removeClass('success-block')},5000);
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
								    						let stateSelectBox = '<select name="state[]" data-placeholder="'+$this.lanFilter(allMsgText.STATE)+'" id="state" class="form-control multi-select-states" multiple="multiple" style="display:none"></select>';
								    						stateSelectBox = $(stateSelectBox);
								    						$.each(jsonStates, function(key, row) {	
															    stateSelectBox.append('<option value="' + row.id+ '">' + row.name + '</option>');
															 });
								    						$(".multi-select-states-area").append(stateSelectBox);
								    						$(".multi-select-states-area").find('select').eq(0).remove();
								    						$(".multi-select-states-area").find('.dashboardcode-bsmultiselect').eq(0).remove();
								    						$(".multiple-select select.multi-select-states").bsMultiSelect();
								    
									},
									listing : function(){
										var $this = this;
										$(document).ready(function() {
											$( "#search-bttn-first" ).on( "click", async function() {
												var name = $('#candidate_name').val();
												var state = $('#state').val();
												if(state == null){
													state = '';
												}
												var language = $('#language').val();
												if(language == null){
													language = '';
												}
												var itskills = $('#itskills').val();
												
												if(itskills == null){
													itskills = '';
												}
												// if(itskills == ''){
												// 	$('.profile-headline-cls').css('display','block');
												// 	setTimeout(function(){ 
												// 		$('.profile-headline-cls').text($this.lanFilter(allMsgText.PLEASE_ENTER_PROFILE_HEADLINE_OR_SELECT_FROM_DROPDOWN)).delay(3000).fadeOut(600);
												// 	});
												// 	return false;
												// }
												var page = 1;
												var $profileBtn = $(".input-search-holder").find("#search-bttn-first");
												$profileBtn.text($this.lanFilter(allMsgText.SEARCHING)+'...');
												$this.freezPagePopupModal($profileBtn);
												await sleep(2000);
												$.ajax(
													{   
														url: _BASE_URL+'/company/find-candidates?page=' + page+'&name='+name+'&state='+state+'&language='+language+'&profile_headline='+itskills+'&flag=1',
														type: "get",
														async: false,
														headers: {
														'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
														},
														beforeSend: function()
														{
															$('.ajax-load').show();
														},
														success:function(data){
															
																	// let newPageNum = $('#page_num').val();
																	// $('#page_num').val((newPageNum+1))
														}
													})
													.done(function(data)
													{
														$('.ajax-load').hide();
														if(data.html == " "){
															$('.ajax-load').html('');
															return;
														}
														$("#post-data").html(data.html);
														$profileBtn.text($this.lanFilter(allMsgText.SEARCH));
														$this.removeFreezPagePopupModal($profileBtn);
														$('.src-res').show();
													})
													.fail(function(jqXHR, ajaxOptions, thrownError)
													{
														alert('server not responding...');
													});
											});
											// scroll pagination

											var page = $('#page').val();

											$(window).scroll(function() {
												if($(window).scrollTop() == $(document).height() - $(window).height()) {
													page++;
													//search with list
													
													$(window).scrollTop($(window).scrollTop()-1);
													$this.loadMoreData(page);
													
												}
											});
											
										});
									},
									loadMoreData : function(page){
												$(document).ready(function() {
															var name = $('#candidate_name').val();
															var state = $('#state').val();
															if(state == null){
																state = '';
															}
															var language = $('#language').val();
															if(language == null){
																language = '';
															}
															var itskills = $('#itskills').val();
															
															if(itskills == null){
																itskills = '';
															}
															//$('.ajax-load').show();
															$.ajax(
																{   
																	url: _BASE_URL+'/company/find-candidates?page=' + page+'&name='+name+'&state='+state+'&language='+language+'&profile_headline='+itskills,
																	type: "get",
																	async: false,
																	headers: {
																	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
																	},
																	beforeSend: function()
																	{
																		$('.ajax-load').show();
																	},
																	success:function(){
																				// let newPageNum = $('#page_num').val();
																				// $('#page_num').val((newPageNum+1))
																	}
																})
																.done(function(data)
																{
																	console.log(data);
																	//$('.ajax-load').hide();
																	if(data == 0){
																		$('.ajax-load').html("");
																		return;
																	}
																	$('#post-data').fadeIn();
																	$("#post-data").append(data.html);
																	$('.ajax-load').hide();
																})
																.fail(function(jqXHR, ajaxOptions, thrownError)
																{
																	alert('server not responding...');
																});
												});
									},
									connectionRequest : function(){
										$(document).on('click','.connect-cls',function(){
											var $this = this;
											var candidateId = $($this).attr("data-id");
											$('#connection-request').modal('show');
											$('#candidate_id').val(candidateId);
										});
										try{
											var $this = this;
											$(document).ready(function(){
													$("#connect").validate({
														rules: {
															comment: { 
																//required: true ,
																maxlength: 5000
															},			
														},
														messages: {
															comment: {
																//required: $this.lanFilter(allMsgText.PLEASE_ENTER_PERSONAL_NOTE),
																maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
															}
		
														},
														submitHandler : function(form){	
															$this.submitConnectionRequest(); 
															return false;  
														}
													});
											});
										}catch(error){
											console.log('Validate Candidate Profile info :: '+error);
										}
									},
									submitConnectionRequest : async function(){
										var $this = this;
										var $profileBtn = $(".connection-request").find(".conect-btn");
										$profileBtn.text('Sending...');
										$this.freezPagePopupModal($profileBtn);
										await sleep(2000);
										var url = _BASE_URL+"/send-connection-request";										   					
										var report = document.getElementById("connect");   
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
													$profileBtn.text('Send Now');
													$this.removeFreezPagePopupModal($profileBtn);
														$("#connection-request").modal('hide');
														let msg = $this.lanFilter(allMsgText.YOU_HAVE_SUCCESSFULLY_SENT_YOUR_CONNECTION_REQUEST);
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
									acceptRejectConnection : function(){
										var $this = this;
										$(document).on('click','.accept-reject-cls',function(event){  
										var candidateId = $(this).attr("data-id");
										var connectionId = $(this).attr("data-connect");
										var tag = $(this).attr("data-tag");
										var url = _BASE_URL+"/accept-reject-connection";
										$.ajax({
												url: url,
												data:{'candidate_id' : candidateId,'tag' : tag, 'connection_id' : connectionId},
												method:'POST',
												async: false,
												dataType:'json',
												headers: {
												'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
												},
												success: function(response){
												   
												   if(tag == 0){
													$('#connect-id-'+candidateId).addClass("connect-cls");
													$('#connect-id-'+candidateId).removeClass("accept-reject-cls");
													$('#connect-id-'+candidateId).html($this.lanFilter(allMsgText.CONNECT));
													$('#connect-id-'+candidateId).attr('data-tag', 1);
												   }else{
													$('#connect-id-'+candidateId).addClass("accept-reject-cls");   
													$('#connect-id-'+candidateId).removeClass("connect-cls");   
													$('#connect-id-'+candidateId).html($this.lanFilter(allMsgText.REMOVE_CONNECTION));
													$('#connect-id-'+candidateId).attr('data-tag', 0);
												   }
												   
												},
												error: function(e){
														alert("Something happend wrong.Please try again");
														
												}	
											}).done(function() {
															
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
 									
}
findCandidateFunctions.init();//initilized
