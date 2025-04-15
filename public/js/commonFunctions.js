/**
 * Developer : Israfil
 * Date : 19/04/2020
 * Object is the container of common & usefull function.So we can use it accross the site
 * We need to intialize this object with commonFunctions.init(); before using this
 *
 */
 const commonFunctions = {
 									base_url : _BASE_URL,
 									init : function(){ 		
 											this.addAdditionalPasswordMethod();//stronpassword									
 											this.validateCandidateLgoinForm();//page login
 											this.validateResetPassword();//email for reseting password
 											this.validateResetPasswordForm();//password & new password validation
 											this.validateCandSignUpForm();//validate sign up form
 											this.addAdditionalPhoneNumber();//phonr numbr validation
 											this.validateCompSignUpForm();//validate company form
 											this.addAdditionalEmail();//validate email format
 											this.addAdditionalPassIncludesNameEmail();//add password validate with name & email
 											this.checkConfirmPasswordMatch();//confirm password matches green tick
 											this.addAdditionalPasswordLowercaseMethod();
											this.addAdditionalPasswordUppercaseMethod();
											this.checkConfirmPasswordMatchEmp();
											this.flashMessage();
											this.addAdditionalPassIncludesNameEmailEmp();
											this.forgotPassIncludesNameEmail();
											this.changeLanguage();
											this.chkUniqueUserEmail();
											this.chkUniqueUserEmailEmp();
											this.subscribeEmail();
 									},
 									//function to add two numbers
 									addTwoNumbers : function (a,b){
										    		   try{
										        			console.log((a+b));
												       }catch(error){
												        	console.log('addNumber gets error:: '+error);
												       } 
									},
									lanFilter : function(str){
										// console.log('str1');
										// console.log(str);
										// console.log('str');
										if(str!= undefined){
										var res = str.split("|");
										if(res[1] != undefined){
											str = str.replace("|","'");
											return str;
										}else{
											return str;
										}
										}
										
										
									},
								    validateCandidateLgoinForm : function(){
													$this = this;
													
								    				   try{
										        			$(document).ready(function(){
										        				 $("#candidate_login").validate({
																		rules: {
																			email: {
																				required: true,
																				email: true
																			},
																			password: {
																				required: true,
																				maxlength: 20																				
																			},
																							
																		},
																		messages: {
																			email: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),
																			password:{
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_PASSWORD),
																				
																			}				
																		}
																	});
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
								    },
								    addAdditionalPasswordLowercaseMethod : function(){
														$this = this;
														var msg = $this.lanFilter(allMsgText.PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_LOWERCASE_LETTER);
								    					$.validator.addMethod("pwcheckLowercase", function(value) {
														   return /[a-z]/.test(value) // has a lowercase letter
														       // && /\d/.test(value) // has a digit
														}, msg);
								    },
								    addAdditionalPasswordUppercaseMethod : function(){
														$this = this;
														var msg = $this.lanFilter(allMsgText.PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_UPPERCASE_LETTER);
								    					$.validator.addMethod("pwcheckUpparcase", function(value) {
														   return /[A-Z]/.test(value) // has a upparcase letter
														       // && /\d/.test(value) // has a digit
														}, msg);
								    },
								    addAdditionalPasswordMethod : function(){
														$this = this;
														var msg = $this.lanFilter(allMsgText.PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_NUMBER);
								    					$.validator.addMethod("pwcheckNumber", function(value) {
														   return /\d/.test(value) // has a digit
														}, msg);
								    },
								    addAdditionalPassIncludesNameEmail : function(){
								    					$.validator.addMethod("pwcNmeEmlChkCandidate", function(value,element, param) {
								    						let elmVal = $(element);
								    						let first_name  = elmVal.parents("#candidate_sign_up").find('input[name=first_name]').val();
								    						first_name = first_name.replace(/ +/g, "");
								    						let email  = elmVal.parents("#candidate_sign_up").find('input[name=email]').val();
								    						let error = true;
								    						let string = value.toLowerCase();
								    						first_name = first_name.toLowerCase();
								    						email = email.toLowerCase();
								    						if(string.includes(first_name)){
								    							error = false;
								    						}
								    						if(string.includes(email)){
								    							error = false;	
								    						}
								    						
														   return error;
														});
								    },
								    addAdditionalPassIncludesNameEmailEmp : function(){
								    					$.validator.addMethod("pwcNmeEmlChk", function(value,element, param) {
								    						let elmVal = $(element);
								    						let first_name  = elmVal.parents("#company_sign_up").find('input[name=first_name]').val();
								    						first_name = first_name.replace(/ +/g, "");
								    						let email  = elmVal.parents("#company_sign_up").find('input[name=email_com]').val();
								    						let error = true;
								    						let string = value.toLowerCase();
								    						first_name = first_name.toLowerCase();
								    						email = email.toLowerCase();
								    						if(string.includes(first_name)){
								    							error = false;
								    						}
								    						if(string.includes(email)){
								    							error = false;	
								    						}
								    						
														   return error;
														});
									},
									chkUniqueUserEmail : function(){
										$this = this;
										$.validator.addMethod("uniqueEmail", function(value,element, param) {
											let elmVal = $(element);
											let email  = $.trim(elmVal.parents("#candidate_sign_up").find('input[name=email]').val());
											let validationStatus = false; 
											$.ajax({
												url: _BASE_URL+"/check-unique-email",
												data:{'email':email},
												method:'POST',
												async: false,
												headers: {
												  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
												},
												success: function(response){
													console.log(response);
													if(response > 0){
														validationStatus = false;
													}else{
														validationStatus = true;
													}
												
												}
											});
											
										    return validationStatus;
										}, 'Email already exist.');
									},
									// chkUniqueUserCnpj : function(){
									// 	$this = this;
									// 	$.validator.addMethod("uniqueCnpj", function(value,element, param) {
									// 		let elmVal = $(element);
									// 		let cnpj  = $.trim(elmVal.parents("#company_sign_up").find('input[name=cnpj]').val());
									// 		let validationStatus = false; 
									// 		$.ajax({
									// 			url: _BASE_URL+"/check-unique-cnpj",
									// 			data:{'cnpj':cnpj},
									// 			method:'POST',
									// 			async: false,
									// 			headers: {
									// 			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									// 			},
									// 			success: function(response){
									// 				console.log(response);
									// 				if(response > 0){
									// 					validationStatus = false;
									// 				}else{
									// 					validationStatus = true;
									// 				}
												
									// 			}
									// 		});
											
									// 	    return validationStatus;
									// 	}, 'CNPJ already exist.');
									// },
									chkUniqueUserEmailEmp : function(){
										$this = this;
										$.validator.addMethod("uniqueEmailEmp", function(value,element, param) {
											let elmVal = $(element);
											let email  = $.trim(elmVal.parents("#company_sign_up").find('input[name=email_com]').val());
											let validationStatus = false; 
											$.ajax({
												url: _BASE_URL+"/check-unique-email",
												data:{'email':email},
												method:'POST',
												async: false,
												headers: {
												  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
												},
												success: function(response){
													console.log(response);
													if(response > 0){
														validationStatus = false;
													}else{
														validationStatus = true;
													}
												
												}
											});
											
										    return validationStatus;
										}, 'Email already exist.');
									},
								    forgotPassIncludesNameEmail : function(){
					    					$.validator.addMethod("pwcNmeEmlChkForgotPass", function(value,element, param) {
					    						let email  = $("#email").val();
					    						let name = '';
					    						$.ajax({
													  url: _BASE_URL+"/get-details",
													  data:{'email':email},
													  method:'POST',
													  async: false,
													  headers: {
								                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								                      },
													  success: function(response){
													  	var detail = JSON.parse(response);
													    name = detail.first_name;
													    name = name.replace(/ +/g, "");
													  }
													});	
					    						let error = true;
					    						let string = value.toLowerCase();
					    						name = name.toLowerCase();
					    						email = email.toLowerCase();
					    						
					    						if(string.includes(name)){
					    							
					    							error = false;
					    						}
					    						if(string.includes(email)){
					    							
					    							error = false;	
					    						}
					    						
											    return error;
					    						
											});
								    },
								    addAdditionalPhoneNumber : function(){
								    					$.validator.addMethod("chkPhone", function(value) {
														   		var phoneno = /^\d{10}$/;
															  	return (value.match(phoneno));
														});
								    },
								    addAdditionalEmail : function(){
														$this = this;
								    					$.validator.addMethod("valEmail", function(value, element) {
													              // allow any non-whitespace characters as the host part
													              var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
													              return this.optional( element ) || re.test( value );
													            }, $this.lanFilter(allMsgText.PLEASE_ENTER_VALID_EMAIL_ADDRESS));
								    },
								    validateResetPassword : function(){
														$this = this;
								    					 try{
										        			$(document).ready(function(){
										        				 $("#email_pass_reset_link").validate({
																		rules: {
																			email: {
																				required: true,
																				valEmail: true
																			},
																						
																		},
																		messages: {
																			email: {
																					required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),
																			}																						
																		}
																	});
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
									},
									
								    validateResetPasswordForm :  function(){
														$this = this;
								    					 try{
										        			$(document).ready(function(){
										        				
																$.validator.addMethod("noSpace", function(value, element) { 
																  return value.indexOf(" ") < 0 && value != ""; 
																}, $this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY));
																$.validator.addMethod("specialChar", function(value, element) {
																	var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
																	return this.optional(element) || value != "" && 
																	value.match(regularExpression);
																}, $this.lanFilter(allMsgText.PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_SPECIAL_CHAR));
										        				$("#reset_password").validate({
										        						onkeyup: function(element) {
																		   var password = $('#password').val();
																	   		var conPassword = $('#password_confirmation').val();
																	   		if(password == conPassword){
																	   			$('.chkPass').prop("disabled", false);
																	   		}else{
																	   			$('.chkPass').prop("disabled", true);
																	   		}
																		},
																		rules: {
																			 	password: {
																					required: true,
																					minlength: 8,
																					maxlength: 20,
																					noSpace: true,
																					pwcNmeEmlChkForgotPass: true,
																					pwcheckUpparcase:true,
																					pwcheckLowercase:true,
																					pwcheckNumber: true,
																					specialChar: true
																					
																				},
																                password_confirmation: {
																                	required: true,
																                    equalTo: "#password"
																                }
																		},
																		messages: {
																			password: {
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_NEW_PASSWORD),
																				minlength: $this.lanFilter(allMsgText.USE_8CHRACTERS_OR_MORE_FOR_YOUR_PASSWORD),
																				pwcNmeEmlChkForgotPass : $this.lanFilter(allMsgText.PASSWORD_MUST_NOT_CONTAIN_NAME_AND_EMAIL),
																				
																			},
																			password_confirmation: {
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_CONFIRM_PASSWORD),
																				equalTo: $this.lanFilter(allMsgText.CONFIRM_PASSWORD_DOES_NOT_MATCH_NEW_PASSWORD)
																			} 

																		}
																	});
										        					
										        				
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
								    },
								     validateCandSignUpForm : function(){
										 				$this = this;
								    					 try{
										        			$(document).ready(function(){
																$(document).on('click','.confirm-submission-candidate',function(){
										        				$.validator.addMethod("noSpace", function(value, element) { 
																  //return value.indexOf(" ") < 0 && value != ""; 
																  if(value != ''){
																	value = $.trim(value);
																	if(value == ''){
																		return false;
																	}else{
																		return true;
																	}	
																}
																}, $this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY));
																$.validator.addMethod("specialChar", function(value, element) {
																	var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
																	return this.optional(element) || value != "" && 
																	value.match(regularExpression);
																}, $this.lanFilter(allMsgText.PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_SPECIAL_CHAR));
										        				var validator = $("#candidate_sign_up").validate({
																		rules: {
																			first_name: {
																				required: true,	
																				noSpace: true,
																				maxlength: 100
																			},
																			email: {
																				required: true,
																				email:true,
																				valEmail: true,
																				maxlength: 100,
																				uniqueEmail: true
																			},
																			password: {
																				required: true,
																				minlength: 8,
																				maxlength: 20,
																				noSpace: true,
																				pwcNmeEmlChkCandidate: true,
																				pwcheckUpparcase: true,
																				pwcheckLowercase: true,
																				pwcheckNumber: true,
																				specialChar: true
																			},
															                password_confirmation: {
															                	required: true,
															                    equalTo: "#password_org"
															                },
																			terms_conditions_status : "required",
																			privacy_policy_status : "required",
																			cookies_policy_status : "required",			
																		},
																		messages: {
																			first_name: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_NAME),
																			},
																			terms_conditions_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_TERMS_AND_CONDITIONS),
																			privacy_policy_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_PRIVACY_POLICY),
																			cookies_policy_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_COOKIES_POLICY),
																			email: {
																					required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),
																			},		
																			password: {
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_PASSWORD),
																				minlength: $this.lanFilter(allMsgText.USE_8CHRACTERS_OR_MORE_FOR_YOUR_PASSWORD),
																				pwcNmeEmlChkCandidate : $this.lanFilter(allMsgText.PASSWORD_MUST_NOT_CONTAIN_NAME_AND_EMAIL),
																			},
																			password_confirmation: {
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_CONFIRM_PASSWORD),
																				equalTo: $this.lanFilter(allMsgText.CONFIRM_PASSWORD_DOES_NOT_MATCH_PASSWORD)
																			}
																					
																		}
																	});
																	
																	if(validator.form()){
																		var $profileBtn = $(".signup-candidate");
																		$profileBtn.text($this.lanFilter(allMsgText.SIGN_UP));
																		$this.freezPagePopupModal($profileBtn);
																		$("#candidate_sign_up").submit();
																	}
																});
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
								    },
								    validateCompSignUpForm : function(){
														$this = this;
								    					 try{
										        			$(document).ready(function(){
										        				$(document).on('click','.confirm-submission',function(){
										        				jQuery.validator.addMethod("exactlength", function(value, element, param) {
																 return this.optional(element) || value.length == param;
																}, $.validator.format($this.lanFilter(allMsgText.PLEASE_ENTER_EXACTLY_12NUMBER)));

																$.validator.addMethod("noSpace", function(value, element) { 
																//   return value.indexOf(" ") < 0 && value != ""; 
																if(value != ''){
																	value = $.trim(value);
																	if(value == ''){
																		return false;
																	}else{
																		return true;
																	}	
																}
																}, $this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY));

																$.validator.addMethod("customNumber", function(value, element) {
																	return this.optional(element) || value != "" && 
																		value.match(/^[0-9./\-]+$/);
																}, $this.lanFilter(allMsgText.PLEASE_ENTER_VALID_CNPJ_NUMBER));

																$.validator.addMethod("customPhnNumber", function(value, element) {
																	return this.optional(element) || value != "" && 
																		value.match(/^[0-9.\()-]+$/);
																}, $this.lanFilter(allMsgText.PLEASE_ENTER_VALID_PHONE_NUMBER));
																$.validator.addMethod("specialChar", function(value, element) {
																	var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
																	return this.optional(element) || value != "" && 
																	value.match(regularExpression);
																}, $this.lanFilter(allMsgText.PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_SPECIAL_CHAR));
																
										        				var validator = $("#company_sign_up").validate({
																		rules: {
																			first_name: {
																				required: true,	
																				noSpace: true,
																				maxlength: 100
																			},
																			company_name: {
																				required: true,	
																				noSpace: true,
																				maxlength: 100
																			},
																			email_com: {
																				required: true,
																				email:true,
																				valEmail: true,
																				maxlength: 100,
																				uniqueEmailEmp: true
																			},
																			cnpj: {
																				required: true,
																				maxlength: 20,
																				//uniqueCnpj: true,
																				customNumber: true
																			},
																			telephone: {
																				required: true,
																				//number:true,
																				customPhnNumber: true,
																				maxlength: 14
																			},
																			password: {
																				required: true,
																				minlength: 8,
																				maxlength: 20,
																				noSpace: true,
																				pwcNmeEmlChk:true,
																				pwcheckUpparcase:true,
																				pwcheckLowercase:true,
																				pwcheckNumber: true,
																				specialChar: true
																			},
															                password_confirmation: {
															                	required: true,
															                    equalTo: "#password_org_c"
															                },
																			terms_conditions_status : "required",
																			privacy_policy_status : "required",
																			cookies_policy_status : "required",				
																		},
																		messages: {
																			first_name: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_CONTACT_NAME),
																				maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_100_CHARACTER),
																			},
																			terms_conditions_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_TERMS_AND_CONDITIONS),
																			privacy_policy_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_PRIVACY_POLICY),
																			cookies_policy_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_COOKIES_POLICY),
																			email: {
																					required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),
																			},	
																			cnpj:{
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_CNPJ_NUMBER),
																				maxlength: $this.lanFilter(allMsgText.PLEASE_ENTER_MAXIMUM_20_CHARACTER)
																			},
																			password: {
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_PASSWORD),
																				minlength: $this.lanFilter(allMsgText.USE_8CHRACTERS_OR_MORE_FOR_YOUR_PASSWORD),
																				pwcNmeEmlChk: $this.lanFilter(allMsgText.PASSWORD_MUST_NOT_CONTAIN_NAME_AND_EMAIL)
																			},
																			password_confirmation: {
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_CONFIRM_PASSWORD),
																				equalTo: $this.lanFilter(allMsgText.CONFIRM_PASSWORD_DOES_NOT_MATCH_PASSWORD)
																			},
																			company_name: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_COMPANY_NAME),
																				maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_100_CHARACTER),
																			},
																			telephone:{
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_PHONE_NUMBER),
																				//minlength : $this.lanFilter(allMsgText.PLEASE_ENTER_AT_LEAST_7_CHARACTER),
																				maxlength : $this.lanFilter(allMsgText.PLEASE_ENTER_MAXIMUM_14_CHARACTER)
																			}
																					
																		}
																	});
										        				 if(validator.form()){
																	// var $profileBtn = $(".signup-company");
																	// $profileBtn.text($this.lanFilter(allMsgText.SIGN_UP));
																	// $this.freezPagePopupModal($profileBtn); 
																	$("#company_sign_up").submit();
																	$('.confirm-submission').css('cursor','default');
								            						$('.confirm-submission').html($this.lanFilter(allMsgText.SUBMIT_YOUR_PROFILE_FOR_APPROVAL));
            													}
										        			});
										        		});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
								    },
	
								    checkConfirmPasswordMatch : function(){
								    				   try{
										        			$(document).ready(function(){
										        				$( "#password_confirmation" ).on( "keyup", function() {
													                var pass = $(".chkPasswordCls").val();
													                var passConf = $("#password_confirmation").val();
													                if((pass!='') && (passConf!='') && (pass == passConf)){
													                  $('.confirm-success').removeClass('d-none');
													                  setTimeout(function(){ $('.confirm-success').addClass('d-none')},5000);
													                }else{
													                  $('.confirm-success').addClass('d-none');
													                }
													            });
													            $( ".chkPasswordCls" ).on( "keyup", function() {
													                var pass = $(".chkPasswordCls").val();
													                var passConf = $("#password_confirmation").val();
													                if((pass!='') && (passConf!='') && (pass == passConf)){
													                  $('.confirm-success').removeClass('d-none');
													                  setTimeout(function(){ $('.confirm-success').addClass('d-none')},5000);
													                }else{
													                  $('.confirm-success').addClass('d-none');
													                }
													            }); 
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
								    },
								    checkConfirmPasswordMatchEmp : function(){
								    				   try{
										        			$(document).ready(function(){
										        				$( ".chkConPasswordEmpCls" ).on( "keyup", function() {
													                var pass = $(".chkPasswordEmpCls").val();
													                var passConf = $(".chkConPasswordEmpCls").val();
													                if((pass!='') && (passConf!='') && (pass == passConf)){
													                  $('.confirm-success').removeClass('d-none');
													                  setTimeout(function(){ $('.confirm-success').addClass('d-none')},5000);
													                }else{
													                  $('.confirm-success').addClass('d-none');
													                }
													            });
													            $( ".chkPasswordEmpCls" ).on( "keyup", function() {
													                var pass = $(".chkPasswordEmpCls").val();
													                var passConf = $(".chkConPasswordEmpCls").val();
													                if((pass!='') && (passConf!='') && (pass == passConf)){
													                  $('.confirm-success').removeClass('d-none');
													                  setTimeout(function(){ $('.confirm-success').addClass('d-none')},5000);
													                }else{
													                  $('.confirm-success').addClass('d-none');
													                }
													            }); 
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Lgoin Form:: '+error);
												       } 
								    },
								    flashMessage : function (){
								    	$(document).ready(function(){
								    		setTimeout(function() {
											    $('.flash_message').delay(20000).fadeOut(1000);
									    	});
								    	});
									},
									changeLanguage : function (){
										$(document).ready(function(){
										$('.change-lang').click(function(){
											var language = $(this).attr("data-id");
											console.log(language);
											$.ajax({
												url: _BASE_URL+"/set-language",
												data:{'language':language},
												method:'GET',
												headers: {
												  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
												},
												success: function(response){
													location.reload();
												}
											});
										});
									});
									},
									subscribeEmail : function(){
										$this = this;
										
										   try{
												$(document).ready(function(){
													 $("#subscribe").validate({
															rules: {
																email: {
																	required: true,
																	valEmail: true
																}
																				
															},
															messages: {
																email:{
																	required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),
																}
																
																			
															}
														});
												});
										   }catch(error){
												console.log('Validate Candidate Lgoin Form:: '+error);
										   } 
									},
									freezPagePopupModal: function($button,text = false){
										
										$('body').css('pointer-events','none');
										document.body.style.cursor = "progress";
										if(text != false){
										   $button.text(text);  
										}
										$button.prop('disabled', true);
									},
									// changeMsgStatus : function (){
									// 	$(document).ready(function(){
									// 	$('.change-status').click(function(){
									// 		var msgId = $(this).attr("data-id");
									// 		alert(msgId);
									// 		// $.ajax({
									// 		// 	url: _BASE_URL+"/set-language",
									// 		// 	data:{'language':language},
									// 		// 	method:'GET',
									// 		// 	headers: {
									// 		// 	  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									// 		// 	},
									// 		// 	success: function(response){
									// 		// 		location.reload();
									// 		// 	}
									// 		// });
									// 	});
									// });
									// }

									    

									
 }
commonFunctions.init();//initilized
