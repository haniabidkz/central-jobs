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
 var profileImage = [];
 var dropZoneFileUploaded = true;
 var dropZoneFileUploadedBanner = true;
 
 const profileFunctions = {
 									base_url : _BASE_URL,
 									defaultProfileImg : _BASE_URL+'/frontend/images/user-pro-img-demo.png', 
 									defaultBannerImg : _BASE_URL+'/frontend/images/user-pro-bg-img.jpg',
 									documentImg : _BASE_URL+'/frontend/images/doc-img.png',
 									pdfImg : _BASE_URL+'/frontend/images/pdf-img.png',
 									deafulCvImg : _BASE_URL+'/frontend/images/document.png',
 																		
 									init : function(){ 		
 											this.deleteBannerImageNew();
 											this.openUplaodProfileImage(); 											
 											this.cropUploadProfileImg();//upload images profile 	
 											this.cropUploadBannerImg();//upload banner img										
 											this.openUplaodBannerImage();
 											this.storeProfileInfo();
 											this.getCountryOnCountrySelect();
 											this.storeHobbies();
 											this.storeCvSummary();
 											this.storeCompanyProfileInfo();
 											this.uploadCv();
 											this.addAdditionalPhoneNumber();
 											this.deleteProfileImg();
 											this.deleteBannerImg();
 											this.checkCvFileOnFileUploadSelect();
 											this.storeSkills();
 											this.removeCV();
 											this.profesionalInfoUpdate();
 											this.storeProfessionalInfo();
 											this.openCvUploader();
 											this.uploaRecordedIntroVideo();
 											this.storeProfessionalInfoAdd();
 											this.educationInfoUpdate();
 											this.storeEducationalInfo();
 											this.storeEducationalInfoAdd();
 											this.languageInfoUpdate();
 											this.storeLanguageInfo();
 											this.storeLanguageInfoAdd();
 											this.removeIntroVideo();
 											this.openIntroVideoModal();
 											this.uploadIntroVideoFromDevice();
 											this.dragIntroFileToUpload();
 											this.deleteLanguage();
 											this.deleteProfessionalInfo();
 											this.deleteEducationalInfo();
 											this.uniqueChkCompanyName();
 											this.initialiseFuntionOnLibImgSelect();
 											this.validateImageSelectProfile();
											this.validateBannerImgSelect();
											this.getCity();
											this.refreshIntroVideo();
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
 									//function to close old popup and open new image popup
								    openUplaodProfileImage : function()
								    {
								    	$(document).on('click',".upload-images-func",function(){								    		
								    		$('#change-image').modal('hide');
								    	});
								    },
								    //function to close old banner popup and open new banner image popup
								    openUplaodBannerImage : function()
								    {
								    	$(document).on('click',".upload-images-banner-func",function(){								    		
								    		$('#change-image-banner').modal('hide');
								    	});
								    },
								    //initialize drop zone for upload profile image
								    initialiseProfileImgUploader : function()
								    {
										var $this = this;
								    	$(document).ready(function(){
								    		  Dropzone.options.myAwesomeDropzone = {
											    maxFiles: 1,
											    maxFilesize: 2, // MB
											    addRemoveLinks: true,
											    autoQueue:false,
											    clickable: true,											    
											    dictDefaultMessage: " <h2>"+$this.lanFilter(allMsgText.CLICK_DRAG_DROP_THE_IMAGE_FILE_TO_UPLOAD)+"</h2> <h5>"+$this.lanFilter(allMsgText.YOU_CAN_UPLOAD_JPEG_OR_PNG_IMAGE_UPTO_2MB)+"</h5>",
											    accept: function(file, done) {
											    	 	profileImage.push(file);
											      		done();
											    },
											    error: function(file, response) {  // and then can you have your error callback
										           
										              swal($this.lanFilter(allMsgText.PROFILE_IMAGE_UPLOAD),response);
										        },
											    init: function() {
												   this.on('addedfile', function(file) {
													    if (this.files.length > 1) {
													     this.removeFile(this.files[0]);
													     
													    }
												   });

												   this.on('removedfile', function(file) {
													   	profileImage.pop();													   	
												   });


											 }
											}
								    	});
								    },
								    uploadProfileImg: function()
								    {
								    	$(document).on('click','.upload-profile-img-func',function(){
								    		//console.log(profileImage);
								    	});
								    },
								    cropUploadProfileImg : function(){ 
								    	 var $this = this;
								    	 $(document).ready(function(){
								    	 	  var user_type = $('#user_type').val();
								    	 	  if(user_type == 3){
								    	 	  	var url = _BASE_URL+'/company/upload-profille-img';
								    	 	  }else{
								    	 	  	var url = _BASE_URL+'/candidate/upload-profille-img';
								    	 	  }
								    	 	  Dropzone.options.myDropzone = {
								    	 	  // maxFiles: 1,
								    	 	  maxFilesize: 2, // MB
								    	 	  acceptedFiles: ".jpeg,.jpg,.png",
								    	 	  url: url,
											  method : "POST",
											  dictDefaultMessage: '<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>',
											  headers: {
						                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						                      },
						                      error: function(file, response) {  // and then can you have your error callback
										              $("#myDropzone").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>');
													  $this.initiliseProfileImg();
										              swal($this.lanFilter(allMsgText.PROFILE_IMAGE_UPLOAD), response);
										      },
						                      init: function () {
												    this.on("complete", function (file) {
												      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
												           dropZoneFileUploaded = true;
												      }
												    });
												    this.on("addedfile", function (file) {
												    	let fileName  = file.upload.filename;
												    	let extension = fileName.split('.');
												    		extension = extension[(extension.length - 1)];
												    		extension = extension.toLowerCase();
														let allowedExtension = ['jpeg','jpg','png'];												    		
												    		if(allowedExtension.includes(extension)){//if extension found
												    			dropZoneFileUploaded = false;

												    		}else{
												    			dropZoneFileUploaded = true;
												    			$("#myDropzone").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>');
																$this.initiliseProfileImg();
																swal($this.lanFilter(allMsgText.PROFILE_IMAGE_UPLOAD), $this.lanFilter(allMsgText.ONLY_JPEG_PNG_FILE_ARE_ALLOWED));
												    			
												    		}
												     	
												    });

											  },
											  transformFile: function(file, done) { 
												// Create the image editor overlay
												var editor = document.createElement('div'); 
												editor.style.zIndex = 9999;
												editor.style.backgroundColor = '#000';
												$("#myDropzone").html(editor);
											
												// Create image preview
												var image = new Image();  
												image.src = URL.createObjectURL(file);
												editor.appendChild(image);  
											
												// Handle upload button click (without cropping)
												$(document).on("click", "#upload_image_now", function() {
													if (dropZoneFileUploaded) {
														return false;
													}
											
													// Convert file to Data URL for preview
													var reader = new FileReader();
													reader.onload = function(event) {
														let dataUrl = event.target.result;
											
														// Update image preview
														$("#profile-image-src").attr("src", dataUrl);
														$(".profile-image-src-menu").attr("src", dataUrl);
														$("#myDropzone").html('<div class="dz-default dz-message"><span>' + 
															$this.lanFilter(allMsgText.DROP_FILE_HERE) + '</span></div>');
											
														// Show success message
														let msg = $this.lanFilter(allMsgText.YOUR_PROFILE_IMAGE_CHANGED_SUCCESSFULLY);
														$this.showSuccessMsg(msg);
											
														$this.initiliseProfileImg();
														$("#change-image-banner").find(".close").trigger('click');
											
														// Return the file to Dropzone
														done(file);
													};
											
													reader.readAsDataURL(file); // Convert file to Base64
												});
											}
											
																};

															});
								    	 	  
									},
									initiliseProfileImg:function(){
														let $this = this;
														$(document).on("click",".cam-open",function(){
																$this.cropUploadProfileImg();
														});
														  

									},
								    showSuccessMsg : function(msg){
								    				 let msgBox = $(".alert-holder-success");
								    				 msgBox.addClass('success-block');
								    				 msgBox.find('.alert-holder').html(msg);
								    				 setTimeout(function(){ msgBox.removeClass('success-block')},5000);
								    },
								    // showErrorMsg : function(msg){
								    // 				 let msgBox = $(".alert-holder-success");
								    // 				 msgBox.addClass('success-block');
								    // 				 msgBox.find('.alert-holder').html(msg);
								    // 				 setTimeout(function(){ msgBox.removeClass('success-block')},5000);
								    // },
								    cropUploadBannerImg : function(){ 
								    	 var $this = this;
								    	 $(document).ready(function(){		
								    	 	  var user_type = $('#user_type').val();
								    	 	  if(user_type == 3){
								    	 	  	var url = _BASE_URL+'/company/upload-banner-img';
								    	 	  }else{
								    	 	  	var url = _BASE_URL+'/candidate/upload-banner-img';
								    	 	  }						    	 
								    	 	  Dropzone.options.myBannerDropzone = {
											  url: url,											  
											  method : "POST",
											  dictDefaultMessage: '<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>',
											  headers: {
						                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						                      },
						                      maxFilesize: 2, // MB
								    	 	  acceptedFiles: ".jpeg,.jpg,.png",
								    	 	  error: function(file, response) {  // and then can you have your error callback
										              $("#myBannerDropzone").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>');
													  $this.initiliseBannerImg();
										              swal($this.lanFilter(allMsgText.PROFILE_IMAGE_UPLOAD), response);
										        },
						                       init: function () {
												    this.on("complete", function (file) {
												      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
												           dropZoneFileUploadedBanner = true;
												      }
												    });
												    this.on("addedfile", function (file) {
												    	let fileName  = file.upload.filename;
												    	let extension = fileName.split('.');
												    		extension = extension[(extension.length - 1)];
												    		extension = extension.toLowerCase();
														let allowedExtension = ['jpeg','jpg','png'];												    		
												    		if(allowedExtension.includes(extension)){//if extension found
												    			dropZoneFileUploadedBanner = false;

												    		}else{
												    			dropZoneFileUploadedBanner = true;
												    			$("#myBannerDropzone").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>');
																$this.initiliseBannerImg();
																swal($this.lanFilter(allMsgText.BACKGROUND_IMAGE_UPLOAD), $this.lanFilter(allMsgText.ONLY_JPEG_PNG_FILE_ARE_ALLOWED));
												    			
												    		}
												     	
												    });

											  },
											//   transformFile: function(file, done) { 
												  			    
											//   					 // Create the image editor overlay
											// 					  var editor = document.createElement('div');																
											// 					  editor.style.zIndex = 9999;
											// 					  editor.style.width = "300px";
											// 					  editor.style.height = "200px";
											// 					  editor.style.backgroundColor = '#000';
											// 					  $("#myBannerDropzone").html(editor);

											// 					  var image = new Image();																	  
											// 					image.src = URL.createObjectURL(file);
											// 					editor.appendChild(image);																	  
											// 					// Create Cropper.js
											// 					var cropper = new Cropper(image, {aspectRatio: 1.5 });



											// 					  // Create confirm button at the top left of the viewport
																	  
											// 						  $(document).on("click","#upload_banner_image_now",function(){
																		
											// 						  			// Remove the editor from the view
											// 						    // Get the canvas with image data from Cropper.js
											// 								  if(dropZoneFileUploadedBanner){
											// 								 		//swal("Profile Image Upload", "Select an image first");
											// 								 		return false;
											// 								 }
											// 								  var canvas = cropper.getCroppedCanvas({
											// 								    width: 700,
											// 								    height: 350,
											// 								  });
											// 								  // Turn the canvas into a Blob (file object without a name)
											// 								  canvas.toBlob(function(blob) {
											// 								    // Return the file to Dropzone
											// 								    done(blob);
											// 								  });
											// 								  // Remove the editor from the view
											// 								  let dataUrl = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
											// 								  // $("#myDropzone").html('<img src="'+dataUrl+'"/>');
																			  
											// 								  $("#change-image-banner").find(".close").trigger('click');
											// 								  $("#banner-image-src").attr("src",dataUrl);
											// 								  $("#myBannerDropzone").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>');
											// 								   //show succss msg
											// 								   let msg = $this.lanFilter(allMsgText.YOUR_BACKGROUND_IMAGE_CHANGED_SUCCESSFULLY);
											// 						   		   $this.showSuccessMsg(msg);	
											// 						   		   $this.initiliseBannerImg();
											// 						  });

											// 					// Create an image node for Cropper.js
											// 						//   var image = new Image();																	  
											// 						//   image.src = URL.createObjectURL(file);
											// 						//   editor.appendChild(image);																	  
											// 						//   // Create Cropper.js
											// 						//   var cropper = new Cropper(image, {aspectRatio: 1.5 });

											// 						}
											transformFile: function(file, done) { 
												// Create the image editor overlay
												var editor = document.createElement('div'); 
												editor.style.zIndex = 9999;
												editor.style.width = "300px";
												editor.style.height = "200px";
												editor.style.backgroundColor = '#000';
												$("#myBannerDropzone").html(editor);
											
												// Create image preview
												var image = new Image();  
												image.src = URL.createObjectURL(file);
												editor.appendChild(image);  
											
												// Handle upload button click (without cropping)
												$(document).on("click", "#upload_banner_image_now", function() {
													if (dropZoneFileUploadedBanner) {
														return false;
													}
											
													// Convert file to Data URL for preview
													var reader = new FileReader();
													reader.onload = function(event) {
														let dataUrl = event.target.result;
											
														// Update image preview
														$("#banner-image-src").attr("src", dataUrl);
														$("#myBannerDropzone").html('<div class="dz-default dz-message"><span>' + 
															$this.lanFilter(allMsgText.DROP_FILE_HERE) + '</span></div>');
											
														// Show success message
														let msg = $this.lanFilter(allMsgText.YOUR_BACKGROUND_IMAGE_CHANGED_SUCCESSFULLY);
														$this.showSuccessMsg(msg);
											
														$this.initiliseBannerImg();
														$("#change-image-banner").find(".close").trigger('click');
											
														// Return the file to Dropzone
														done(file);
													};
											
													reader.readAsDataURL(file); // Convert file to Base64
												});
											}
											
																};

															});
									},
									initiliseBannerImg: function(){
														let $this = this;
														$(document).on("click",".cam-banner-open",function(){
																$this.cropUploadBannerImg();
														});
									},
									addAdditionalPhoneNumber : function(){
								    					$.validator.addMethod("chkPhone", function(value) {
														   		var phoneno = /^\d{10}$/;
															  	return (value.match(phoneno));
														});
								    },
									storeProfileInfo: function(){
														var $this = this;
														try{
										        			$(document).ready(function(){
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
										        				 $("#form_profile_info").validate({
																		rules: {
																			first_name: {
																				required: true,
																				noSpace: true																				
																			},
																			profile_headline: {
																				required: true,
																				noSpace: true																				
																			},
																			email: {
																				required: true,
																				email: true
																			},
																			country_id: { required: true},
																			state_id: { required: true},
																			city_id: { 
																				required: true,
																				noSpace: true
																			},
																			// address1: { required: true },
																			// postal: { 
																			// 	required: true ,
																			// 	number: true,
																			// 	maxlength: 100
																			// },			
																		},
																		messages: {
																			first_name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_NAME),
																			profile_headline: $this.lanFilter(allMsgText.PLEASE_PROVIDE_PROFILE_HEADLINE),
																			email: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),	
																			country_id: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_COUNTRY),
																			state_id: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_STATE),
																			city_id: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_CITY),	
																			// address1: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_ADDRESS1),
																			// postal: {
																			// 	required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_ZIP_CODE),
																			// }

																		},
																	   submitHandler : function(form){																	   					
																	   					 $this.storeProfileDataAjax();
																	   		   			 return false;
																	   }
																	});
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Profile info :: '+error);
												       }			
									},
									storeCompanyProfileInfo: function(){
														var $this = this;
														try{
										        			$(document).ready(function(){
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
																  $.validator.addMethod("customPhnNumber", function(value, element) {
																	return this.optional(element) || value != "" && 
																		value.match(/^[0-9.\()-]+$/);
																}, $this.lanFilter(allMsgText.PLEASE_ENTER_VALID_PHONE_NUMBER));
																
										        				 $("#form_company_profile_info").validate({
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
																			business_name: {
																				required: true,
																				noSpace: true,
																				maxlength: 100
																			},
																			telephone:{
																				required: true,
																				//number:true,
																				//minlength:7,
																				customPhnNumber: true,
																				maxlength: 14
																			},
																			email: {
																				required: true,
																				email: true
																			},
																			country_id: { required: true},
																			state_id: { required: true},
																			city_id: { 
																				required: true,
																				noSpace: true
																			},
																			address1: { 
																				required: true,
																				maxlength: 255 
																			},
																			postal: { 
																				required: true ,
																				//number: true,
																				maxlength: 100
																			}			
																		},
																		messages: {
																			first_name: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_CONTACT_NAME),
																			},
																			company_name: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_COMPANY_NAME),
																			},
																			business_name: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_BUSINESS_NAME),
																			},
																			telephone: { 
																				required : $this.lanFilter(allMsgText.PLEASE_PROVIDE_PHONE_NUMBER),
																				minlength : $this.lanFilter(allMsgText.PLEASE_ENTER_AT_LEAST_7_CHARACTER),
																				maxlength : $this.lanFilter(allMsgText.PLEASE_ENTER_MAXIMUM_14_CHARACTER)
																			},
																			email: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_EMAIL),	
																			country_id: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_COUNTRY),
																			state_id: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_STATE),	
																			city_id: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_CITY),	
																			address1: {
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_ADDRESS1),
																			},
																			postal:{
																				required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_ZIP_CODE),
																			} 
																		},
																	   submitHandler : function(form){																	   					
																	   					 $this.storeProfileDataAjax();
																	   		   			 return false;
																	   }
																	});
										        			});
												       }catch(error){
												        	console.log('Validate Candidate Profile info :: '+error);
												       }			
									},
									storeProfileDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#professional-info").find(".submit-prfl-info-btn");
													   $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
										        			
															 var user_type = $('#user').val();
												    	 	  if(user_type == 3){
												    	 	  	var form_profile_info = document.getElementById("form_company_profile_info");
												    	 	  	var url = _BASE_URL+"/company/store-profile-info";
												    	 	  }else{
												    	 	  	var form_profile_info = document.getElementById("form_profile_info");
												    	 	  	var url = _BASE_URL+"/candidate/store-profile-info";
												    	 	  }	
												    	 	  var fd = new FormData(form_profile_info);
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
																	  			console.log(response);
																	  			$this.updateProfilePreview(fd);
																	  			let msg = $this.lanFilter(allMsgText.YOUR_PROFILE_INFORMATION_UPDATED_SUCCESSFULLY);
														   		   			 	$this.showSuccessMsg(msg);
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#professional-info").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
														   					 $this.removeFreezPagePopupModal($profileBtn);	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									},
									updateProfilePreview: function(fd){ 
														let profilePreview = $("#section1");
														let profilePreviewLeftMenu = $("#leftMenu");
														var selectedCountryName = $("#country_id option:selected").html();
														var user_type = $('#user_type').val();
														if(user_type == 3){
															profilePreview.find('.company_name_func').text(fd.get('company_name'));
															profilePreview.find('.business_name_func').text(fd.get('business_name'));
															profilePreview.find('.telephone_func').text(fd.get('telephone'));
															profilePreviewLeftMenu.find('.company_name_func').text(fd.get('company_name'));
															profilePreviewLeftMenu.find('.business_name_func').text(fd.get('business_name'));
															profilePreview.find('.address1_func').text(fd.get('address1'));
															$('.address-data-func').text(fd.get('address1'));
															profilePreview.find('.address2_func').text(fd.get('address2'));
															profilePreview.find('.postal_func').text(fd.get('postal'));
															$("#professional-info").find("#business_name").attr('readonly', true);
														}else{
															profilePreview.find('.profile_headline_func').text(fd.get('profile_headline'));
															$('.user-profession-finc').html(fd.get('profile_headline'));
														}
														profilePreview.find('.first_name_func').text(fd.get('first_name'));
														$('.user-dynamic-name-func').html(fd.get('first_name'));
														profilePreview.find('.email_func').text(fd.get('email'));
														profilePreview.find('.country_id_func').text(selectedCountryName);
														// profilePreview.find('.address1_func').text(fd.get('address1'));
														// $('.address-data-func').text(fd.get('address1'));
														// profilePreview.find('.address2_func').text(fd.get('address2'));
														// profilePreview.find('.postal_func').text(fd.get('postal'));
														profilePreview.find('.city_id_func').text(fd.get('city_id'));
														profilePreview.find('.state_id_func').text($("#state_id option:selected").text());
														profilePreviewLeftMenu.find('.state_id_func_lft').text($("#state_id option:selected").text()+', ');
														profilePreviewLeftMenu.find('.country_id_func').text(selectedCountryName);
														
									},
									bsMultiselectInitialise: function(){
												$(".multiple-select select.multi-select").bsMultiSelect();
												$(".chat-hist, .messages-line , .messages-list").mCustomScrollbar();	
												// messages-line
												// (function($){
												//     $(window).on("load",function(){
												        
												//          axis:"yx"
												//     });
												// });
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
								getCountryOnCountrySelect: function(){
									                    let $this = this;
									  					$(document).on("change","#country_id",function(){
									  							let country_id = $(this).val();
									  							if(country_id != ''){
									  								 $this.getCountryStates(country_id);									  								
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
												let stateSelectBox = '<option value=""> '+$this.lanFilter(allMsgText.SELECT_CITY)+' </option>';
												$.each(jsonCity, function(key, row) {	
													stateSelectBox += '<option value="' + row.id+ '">' + row.name + '</option>';
												});
												$(".select-city-area").html(stateSelectBox);
											   }
										   }); 
									   }); 
										 
								   });
								},
								storeHobbies: function(){
											var $this = this;
											try{
							        			$(document).ready(function(){
							        				$(document).on('click','.hobby-submit-btn',function(){
							        				 var hobby = $('#hobby').val();
							        				 //console.log(hobby);
							        				 $("#form_hobby").validate({
															rules: {
																hobby: {
																	required: true																				
																}		
															},
															messages: {
																hobby: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_HOBBIES)
															},
														   submitHandler : function(form){																	   					
														   					 $this.storeHobbyDataAjax();
														   		   			 return false;
														   }
														});
							        				});
							        			});
									       }catch(error){
									        	console.log('Validate Candidate Hobbies :: '+error);
									       }			
						},
						storeHobbyDataAjax: async function(){
										   var $this = this;
										   var $profileBtn = $("#hobbies").find(".hobby-submit-btn");
										   $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
										   $this.freezPagePopupModal($profileBtn);
										   await sleep(2000);
										  try{
							        			
						        				 var form_profile_info = document.getElementById("form_hobby");
												 var fd = new FormData(form_profile_info);	
												 // console.log(fd); 
												 // return false;
						        				 $.ajax({
														  url: _BASE_URL+"/candidate/store-hobbies",
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
														  			$this.updateHobbyPreview(fd);
														  			let msg = $this.lanFilter(allMsgText.YOUR_HOBBIES_UPDATED_SUCCESSFULLY);
											   		   			 	$this.showSuccessMsg(msg);
														  },
														  error: function(){
														  		 alert("Something happend wrong.Please try again");
														  		 $this.removeFreezPagePopupModal($profileBtn);
														  }	
														}).done(function() {
																 //$('input').val('');
												  				 $("#hobbies").modal('hide');
											   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
											   					 $this.removeFreezPagePopupModal($profileBtn);	
												});										        				 
							        			
									       }catch(error){
									        	console.log('storeProfileDataAjax function :: '+error);
									       }	
						},
						updateHobbyPreview: function(fd){
							var hobbies = fd.get('hobby');
							hobbies = hobbies.split(",");
							var count = hobbies.length;
							var hobbyHtml = '';
							
							for(var i=0; i<count; i++){
								var hobby = hobbies[i].toLowerCase().replace(/\b[a-z]/g, function(letter) {
								    return letter.toUpperCase();
								});
								hobbyHtml += '<li><span>'+hobby+'</span></li>';

							}
							$("#hobbyPrev").html(hobbyHtml);
						},
						storeCvSummary: function(){
											var $this = this;
											try{
							        			$(document).ready(function(){
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
							        				 $("#form_cv_summary").validate({
															rules: {
																cv_summary: {
																	required: true,
																	noSpace: true,
																	maxlength: 600																				
																}		
															},
															messages: {
																cv_summary: {
																	required: $this.lanFilter(allMsgText.PLEASE_PROVIDE_YOUR_CV_SUMMARY)
																}
															},
														   submitHandler : function(form){																	   					
														   					 $this.storeCVSummaryDataAjax();
														   		   			 return false;
														   }
														});
							        			});
									       }catch(error){
									        	console.log('Validate Candidate Cv Summary :: '+error);
									       }			
						},
						storeCVSummaryDataAjax: async function(){
										   var $this = this;
										   var $profileBtn = $("#cv-summary").find(".cv-summary-sub-btn");
										   $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
										   $this.freezPagePopupModal($profileBtn);
										   await sleep(2000);
										  try{
							        			
						        				 var form_profile_info = document.getElementById("form_cv_summary");
												 var fd = new FormData(form_profile_info);	
												 // console.log(fd); 
												 // return false;
						        				 $.ajax({
														  url: _BASE_URL+"/candidate/store-cv-summary",
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
														  			console.log(response);
														  			$this.updateCvSummaryPreview(fd);
														  			let msg = $this.lanFilter(allMsgText.YOUR_CV_SUMMARY_UPDATED_SUCCESSFULLY);
											   		   			 	$this.showSuccessMsg(msg);

														  },
														  error: function(){
														  		 alert("Something happend wrong.Please try again");
														  		 $this.removeFreezPagePopupModal($profileBtn);
														  }	
														}).done(function() {
																 $('input').val('');
												  				 $("#cv-summary").modal('hide');
											   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
											   					 $this.removeFreezPagePopupModal($profileBtn);	
												});										        				 
							        			
									       }catch(error){
									        	console.log('storeCvSummaryDataAjax function :: '+error);
									       }	
						},
						updateCvSummaryPreview: function(fd){
							$("#cvSummaryPrev").html(fd.get('cv_summary'));
						},
						freezPagePopupModal: function($button){
							       //$('.custom-modal').addClass('freez_page');
							       document.body.style.cursor = "progress";
							       $button.prop('disabled', true);
						},
						removeFreezPagePopupModal: function($button){
								   document.body.style.cursor = ""; // so it goes back to previous CSS defined value 
								   $button.prop('disabled', false);
						},
						storeCv : async function(){
											let $this = this;
											var $profileBtn = $("#upload_cv_form").find(".upload_cv_func");											   
											var form_cv = document.getElementById("upload_cv_form");
											var fd = new FormData(form_cv);	
											let allowedFileTypes = ['doc','docx','pdf'];
											var fileName = fd.get('file').name;		
											let fileSize = fd.get('file').size;console.log(fileSize);
											if(fileName == ''){
												$('#upload_cv_form .upload-error-n').text($this.lanFilter(allMsgText.PLEASE_SELECT_YOUR_CV_FIRST_THEN_UPLOAD)).show();												
												return false;
											}					
											let isNotValidFile = $this.validateFileType(allowedFileTypes,fileName);
											if(isNotValidFile){
												$('.error.upload-error-n').text($this.lanFilter(allMsgText.ONLY_DOC_PDF_ALLOWED)).show();												
												return false;
											}		
											if(fileSize > (1024*(1024*2))){console.log(fileSize);
												$('.error.upload-error-n').text($this.lanFilter(allMsgText.THE_ALLOWED_MAX_SIZE_2MB)).show();												
												return false;
											}									
											$('.error.upload-error').hide();
											$profileBtn.text('Uploading...');
											$this.freezPagePopupModal($profileBtn);
											await sleep(2000);
											$.ajax({
													  url: _BASE_URL+"/candidate/store-cv",																  
													  method:'POST',
													  data:fd,
													  dataType:'json',																								 
													  processData: false,
													  async: true,
													  cache: false,
													  contentType: false,
													  headers: {
										                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										              },
													  success: function(response){	
													  					if(fileName.includes('pdf')){
													  						$('.cv-holder-page-section').find('img').attr('src',$this.pdfImg);	
													  					}else{
													  						$('.cv-holder-page-section').find('img').attr('src',$this.documentImg);
													  					}
													  					$('.cv-file-name-image').text(fileName);
													  					$('.Cv-file-name-container').show();
													  					$('.cv-holder-page-section').addClass('cv-holder-upload');	
													  					$('.cv-holder-page-section').find('.downloadprofile').attr('href',(_BASE_URL+response.location));
													  					$('.cv-holder-page-section').find('.uploadprofile-new').attr('href',(response.location));		
													  					
													  					
													  },
													  error: function(){
													  		 alert("Something happend wrong.Please try again");
													  		 $this.removeFreezPagePopupModal($profileBtn);

													  }	
												}).done(function(){
														 $("#cv-update").modal('hide');
														 $('.cv-upload-section-func').fadeOut();
									   					 $profileBtn.text($this.lanFilter(allMsgText.UPLOAD));
									   					 $this.removeFreezPagePopupModal($profileBtn);	
												});
									},
						uploadCv: function(){
									  let $this = this;
								      $(document).on('click','.upload_cv_func',function(){
								      		$this.storeCv();
								      });
						},
						validateFileType:function(allowedFileTypes,fielName){

									let error = false;
									let fileType = fielName.split('.');
									fileType = fileType[(fileType.length-1)];
									if(!allowedFileTypes.includes(fileType)){
										error = true;
									}
									return error;
						},
						deleteProfileImg :  function(){
										let $this = this;										
										$(document).on('click','.remove-old-profile-image-func',function(){
											$this.removeProfileImg();
										});
						},
						removeProfileImg: async function(){
											let $this = this;

											let $buttonImg = $(".remove-old-profile-image-func").find('img');
											let fileName = $('#profile-image-src').attr('src');
												fileName = fileName.split('/');
											if(fileName.includes('user-pro-img-demo.png')){
												swal($this.lanFilter(allMsgText.PROFILE_IMAGE_REMOVAL),$this.lanFilter(allMsgText.YOU_DONT_HAVE_PROFILE_IMAGE));
												return false;
											}
											let msg = $this.lanFilter(allMsgText.YOUR_PROFILE_IMAGE_REMOVED_SUCCESSFULLY);																					
											$this.freezPagePopupModal($buttonImg);
											$("#change-image-remove").html($this.lanFilter(allMsgText.REMOVING_IMAGE)+'...');
											$this.removeUserImg('profile');
											await sleep(2000);
											$("#change-image-remove").html($this.lanFilter(allMsgText.REMOVE_EXISTING_IMAGE));
											$("#profile-image-src").attr("src",$this.defaultProfileImg);
											$(".profile-image-src-menu").attr("src",$this.defaultProfileImg);
											$("#change-image").modal('hide');
											$this.removeFreezPagePopupModal($buttonImg);
											await sleep(500);
											$this.showSuccessMsg(msg);
						},
						deleteBannerImg :  function(){
										let $this = this;
										
										$(document).on('click','.remove-old-banner-image-func',function(){
											$this.removeBannerImg();
										});
						},
						removeBannerImg: async function(){
										
											let $this = this;
											let $buttonImg = $(".remove-old-banner-image-func").find('img');
											let msg = $this.lanFilter(allMsgText.YOUR_BANNER_IMAGE_IS_REMOVED_SUCCESSFULLY);																					
											$this.freezPagePopupModal($buttonImg);
											$("#change-image-remove-banner").html($this.lanFilter(allMsgText.REMOVING_IMAGE)+'...');
											$this.removeUserImg('banner');
											await sleep(2000);
											$("#change-image-remove-banner").html($this.lanFilter(allMsgText.REMOVE_EXISTING_IMAGE));
											$("#banner-image-src").attr("src",$this.defaultBannerImg);
											$("#change-image-banner").modal('hide');
											$this.removeFreezPagePopupModal($buttonImg);
											await sleep(500);
											$this.showSuccessMsg(msg);
						},
						removeUserImg: function(imgType){
										var user_type = $('#user_type').val();
										if(imgType == 'banner'){
											if(user_type == 3){
							    	 	  		dataUrl = _BASE_URL+"/company/remove-banner-img"
							    	 	  	}else{
							    	 	  		dataUrl = _BASE_URL+"/candidate/remove-banner-img";
							    	 	  	}
											
										}else{
							    	 	  	if(user_type == 3){
							    	 	  		dataUrl = _BASE_URL+"/company/remove-prfl-img";
							    	 	  	}else{
							    	 	  		dataUrl = _BASE_URL+"/candidate/remove-prfl-img";
							    	 	  	}
											
										}
										
										var formData = document.getElementById("security_form");
										var fd = new FormData(formData);	
										
										$.ajax({
													  url: dataUrl,																  
													  method:'POST',
													  data:{},
													  dataType:'json',													  
													  processData: false,
													  async: true,
													  cache: false,
													  contentType: false,
													  headers: {
										                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										              },
													  success: function(response){																  	
													  			//console.log(response);																  			
													  },
													  error: function(){
													  		 alert("Something happend wrong.Please try again");													  		
													  }	
												})
						},
						checkCvFileOnFileUploadSelect : function(){
											let $this = this;
											$(document).on('click','.cv_file_upload',function(event){
												setTimeout(function(){
														$("#cv-update").find('.la.la-file-alt').addClass('d-none');
														$("#cv-update").find('.la.la-file-pdf').removeClass('d-none');
														$("#cv-update").find('.media.file-name-image').hide();
														$("#cv-update").find(".cv-name-func").text('');
														$("#cv-update").find('.cv-holder').find('img').attr('src','');
														$('.cv-upload-section-func').fadeOut();
												},1000);
												
											});
											$(document).on('change','.cv_file_upload',function(event){
												
													let input = this;
													if(input.files.length < 1){
														return false;	
													}
												    let fileName = input.files[0].name;
												    let fileType = fileName.split('.');
												    fileType = fileType[(fileType.length-1)]
												    let allowedFileTypes = ['doc','docx','pdf'];					
													let isNotValidFile = $this.validateFileType(allowedFileTypes,fileName);
													
													if(isNotValidFile){
														$('.error.upload-error-n').text($this.lanFilter(allMsgText.ONLY_DOC_PDF_ALLOWED)).show();												
														$("#cv-update").find(".cv-name-func").text('');
														$("#cv-update").find('.media.file-name-image').hide();
														return false;
													}											
													$('.error.upload-error-n').hide();
													
													if(fileType == 'pdf'){
														$("#cv-update").find('.la.la-file-alt').addClass('d-none');
														$("#cv-update").find('.la.la-file-pdf').removeClass('d-none');
														$("#cv-update").find('.media.file-name-image').show();
														$("#cv-update").find(".cv-name-func").text(fileName);	
														$("#cv-update").find('.cv-holder').find('img').attr('src',$this.pdfImg);
														$('.cv-upload-section-func').fadeIn();
													}
													else if(fileType == 'doc' || fileType == 'docx'){
														$("#cv-update").find('.la.la-file-alt').removeClass('d-none');
														$("#cv-update").find('.la.la-file-pdf').addClass('d-none');
														$("#cv-update").find('.media.file-name-image').show();
														$("#cv-update").find(".cv-name-func").text(fileName);
														$("#cv-update").find('.cv-holder').find('img').attr('src',$this.documentImg);
														$('.cv-upload-section-func').fadeIn();
													}else{
														$("#cv-update").find('.media.file-name-image').hide();
														$('.cv-upload-section-func').fadeOut();
													}
													
											});
						},
						storeSkills: function(){
											var $this = this;
											try{
							        			$(document).ready(function(){
							        				$('.skill-submit-btn').on("click", function() {
														var skill = $('#skill').val();
							        					if(skill == null){
							        						$("#errorClsSkill").removeAttr("style")
							        						$('#errorClsSkill').html($this.lanFilter(allMsgText.PLEASE_SELECT_YOUR_SKILL));
							        						return false;
							        					}else{
															$('#errorClsSkill').html('');
							        						$this.storeSkillDataAjax();
							        					}
							        					
							        				});
							       
							        			});
									       }catch(error){
									        	console.log('Validate Candidate Skills :: '+error);
									       }			
						},
						storeSkillDataAjax: async function(){
										   var $this = this;
										   var $profileBtn = $("#others").find(".skill-submit-btn");
										   $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
										   $this.freezPagePopupModal($profileBtn);
										   await sleep(2000);
										  try{
							        			
						        				 var form_profile_info = document.getElementById("form_skill");
												 var fd = new FormData(form_profile_info);	
												 // console.log(fd); 
												 // return false;
						        				 $.ajax({
														  url: _BASE_URL+"/candidate/store-skills",
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
														  			$this.updateskillPreview(response);
														  			let msg = $this.lanFilter(allMsgText.YOUR_SKILLS_ARE_UPDATED_SUCCESSFULLY);
											   		   			 	$this.showSuccessMsg(msg);
														  },
														  error: function(){
														  		 alert("Something happend wrong.Please try again");
														  		 $this.removeFreezPagePopupModal($profileBtn);
														  }	
														}).done(function() {
																 $('input').val('');
												  				 $("#others").modal('hide');
											   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
											   					 $this.removeFreezPagePopupModal($profileBtn);	
												});										        				 
							        			
									       }catch(error){
									        	console.log('storeProfileDataAjax function :: '+error);
									       }	
						},
						updateskillPreview: function(fd){
							var count = fd.length;
							var skillHtml = '';
							$.each(fd, function(key, value) {
								var skill = value['name'].toLowerCase().replace(/\b[a-z]/g, function(letter) {
								    return letter.toUpperCase();
								});
								skillHtml += '<li><span>'+skill+'</span></li>';
							});
							$("#skillPrev").html(skillHtml);
						},

						removeCV : function(){
									var $this = this;
									$(document).on('click','.remove-cv-file-func',function(){
										let $that = $(this);
										swal({
												  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
												  text: $this.lanFilter(allMsgText.ONCE_DELETED_NOTABLE_TO_RECOVER_CV),
												  icon: "warning",
												  buttons: true,
												  dangerMode: true,
												})
												.then((willDelete) => {
												  if (willDelete) {
												      $this.deleteCVFromServer($that);
												  }
												});										
										
									    });
						},
						deleteCVFromServer : async function($clickBtn){
										    let $this = this;
										    $this.freezPagePopupModal($clickBtn);
										    $('#section5').find('.cv-update-section-info').text('Removing...');
										    await sleep(2000);
										    let uploader_section = $('.cv-holder-page-section');
											uploader_section.removeClass('cv-holder-upload');										
											let cvDownloader = uploader_section.find('.downloadprofile'); 
											cvDownloader.attr("href","#");
											$(".cv").attr("src",$this.deafulCvImg);
											$('.cv-file-name-image').html('');
											$('.Cv-file-name-container').hide();

										  try{
							        									        				
						        				 $.ajax({
														  url: _BASE_URL+"/candidate/delete-cv",
														  data:{},
														  method:'POST',
														  dataType:'json',
														  cache : false,
														  processData: false,
														  contentType: false,
														  headers: {
											                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
											              },
														  success: function(response){
														  			let msg = $this.lanFilter(allMsgText.YOUR_CV_REMOVED_SUCCESSFULLY);
											   		   			 	$this.showSuccessMsg(msg);
														  },
														  error: function(){
														  		 alert("Something happend wrong.Please try again");
														  		 
														  }	
														}).done(function() {	
															 $('#section5').find('.cv-update-section-info').text($this.lanFilter(allMsgText.UPDATE_NOW));															
											   				 $this.removeFreezPagePopupModal($clickBtn);	 	
														});										        				 
							        			
									       }catch(error){
									        	console.log('storeProfileDataAjax function :: '+error);
									       }
						},
						profesionalInfoUpdate: function(){
							$(document).on('click','.profEditCls',function(){
								 var profileInfoId = $(this).attr("data-id");
								 $.ajax({
										  url: _BASE_URL+"/candidate/get-professional-info",
										  data:{ 'id': profileInfoId },
										  method:'POST',
										  headers: {
							                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							              },
										  success: function(response){
												var objData = JSON.parse(response);
										  		var startArr = objData.start_date.split(" ");
										  		$('.prfexp #id').val(objData.id);
										  		$('.prfexp #title').val(objData.title);	
										  		$('.prfexp #company_name').val(objData.company_name);
										  		$('#datetimepicker4').val(startArr[0]);console.log(startArr[0]);
										  		if(objData.currently_working_here == 1){
													$('.prfexp #currently_working').val(1);  
										  			$( ".prfexp #myCheck" ).prop( "checked", true );
										  			$('.prfexp .checkWorking-showhide').attr("style", "display:none");
										  		}else{
													$('.prfexp #currently_working').val(0);  
										  			$('.prfexp .checkWorking-showhide').attr("style", "display:block");
										  			var endArr = objData.end_date.split(" ");
										  			$('#datetimepicker5').val(endArr[0]);console.log(endArr[0]);
										  			$( ".prfexp #myCheck" ).prop( "checked", false );
										  		}
										  		$('.prfexp [name=type_of_employment]').val(objData.type_of_employment);
												$('#professional-experience').modal('show');
												 var sDate =  new Date(startArr[0]);
												 $('#datetimepicker5').data("DateTimePicker").minDate(sDate); 
										  }
										});
							});
						},
						storeProfessionalInfo: function(){
										var $this = this;
										try{
						        			$(document).ready(function(){
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
						        				 $("#form_company_info").validate({
														rules: {
															title: {
																required: true,	
																noSpace: true																			
															},
															type_of_employment: {
																required: true,																				
															},
															company_name: {
																required: true,
																noSpace: true	
															},
															start_date:{
																required: true
															},
															end_date:{
																required: true
															}
														},
														messages: {
															title: $this.lanFilter(allMsgText.PLEASE_PROVIDE_TITLE),
															type_of_employment: $this.lanFilter(allMsgText.PLEASE_SELECT_TYPE_OF_EMPLOYMENT),
															company_name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_COMPANY_NAME),
															start_date: $this.lanFilter(allMsgText.PLEASE_SELECT_START_DATE),
															end_date: $this.lanFilter(allMsgText.PLEASE_SELECT_END_DATE),
														},
													    submitHandler : function(form){																	   					
													   			$this.storeProfessionalDataAjax();
													   		   	return false;
													    }
													});
						        			});
								       }catch(error){
								        	console.log('Validate Candidate Profile info :: '+error);
								       }			
									},
						storeProfessionalDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#professional-experience").find(".submit-comp-info-btn");
													   $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("form_company_info");
												    	 	  var fd = new FormData(form_profile_info);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-professional-info",
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
																	  			console.log(response);
																	  			if(response == 0){
																	  				let msg = $this.lanFilter(allMsgText.YOUR_COMPANY_ALREADY_ADDED);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}else{
																					  
																	  				$this.updateProfessionalPreview(fd);
																		  			let msg = $this.lanFilter(allMsgText.YOUR_COMPANY_DETAILS_UPDATED_SUCCESSFULLY);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}
																	  			
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#professional-experience").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
														   					 $this.removeFreezPagePopupModal($profileBtn);	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									},
									updateProfessionalPreview: function(fd){ 
											var $this = this;
											 let profilePreview = $("#edit_company_details_"+fd.get('id'));
											 profilePreview.find('.title_func').text(fd.get('title'));
											 if(fd.get('type_of_employment') == 1){
											 	profilePreview.find('.type_of_employment_func').text($this.lanFilter(allMsgText.FULL_TIME));
											 }else if(fd.get('type_of_employment') == 2){
											 	profilePreview.find('.type_of_employment_func').text($this.lanFilter(allMsgText.PART_TIME));
											 }else if(fd.get('type_of_employment') == 3){
											 	profilePreview.find('.type_of_employment_func').text($this.lanFilter(allMsgText.CONTRACT));
											 }else if(fd.get('type_of_employment') == 4){
											 	profilePreview.find('.type_of_employment_func').text($this.lanFilter(allMsgText.INTERNSHIP));
											 }else if(fd.get('type_of_employment') == 5){
											 	profilePreview.find('.type_of_employment_func').text($this.lanFilter(allMsgText.SELF_EMPLOYED));
											 }
											 profilePreview.find('.company_name_func').text(fd.get('company_name'));
											 if(fd.get('currently_working_here') == 1){
											 	profilePreview.find('.currently_working_here_func').text($this.lanFilter(allMsgText.YES));
											 }else {
											 	profilePreview.find('.currently_working_here_func').text($this.lanFilter(allMsgText.NO));
											 }
											 profilePreview.find('.start_date_func').text(fd.get('start_date'));
											 if(fd.get('currently_working_here') == 1){
												$('.profEditCls').data('edit-chk', 1); 
												currentCompanyArr.push(1);
												console.log(currentCompanyArr);
												$('.deleteProf').data('current-chk', 1);
												profilePreview.find('.endCls').attr("style", "display:none");
											 }else{
												$('.profEditCls').data('edit-chk', 1); 
												$('.deleteProf').data('current-chk', 0);
												profilePreview.find('.endCls').attr("style", "display:block");
												profilePreview.find('.end_date_func').text(fd.get('end_date'));
											 	// profilePreview.find('.start_date_func').text(fd.get('start_date'));
											 }	
											 var currentOrNot = $('.profEditCls').attr("data-edit-chk");
											//  console.log(currentOrNot+' current');
											//  console.log(fd.get('currently_working_here')+' old');
											 
												if(fd.get('currently_working_here') != 1){
													jQuery.each(currentCompanyArr, function(i, val) {
														if(val == 1) // delete index
														{
														   delete currentCompanyArr[i];
													   }
													 });
													 console.log(currentCompanyArr);
												}
											 
											 
									},	
								openCvUploader : function()
								{
									$(document).on('click','.uploadprofile .la.la-upload',function(){
										$('.btn.site-btn-color.editbtn.open-cv-popup').trigger('click');
									});
								},
								uploadIntroVideo : async function(){
											       	   var $this = this;
											       	   if(typeof introVideoData == 'undefined'){
														  $('#intro-video .upload-error-n-intro').text($this.lanFilter(allMsgText.PLEASE_SELECT_INTRO_VIDEO));	  
														  $('.error.upload-error-n-intro').attr("style", "display:block");
															setTimeout(function() {
																$('.error.upload-error-n-intro').delay(3000).fadeOut(600);
															});		
														  return false;
											       	   }
													   var $profileBtn = $(".upload-intro-video-func");
													   $profileBtn.text($this.lanFilter(allMsgText.UPLOADING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("video_intro_form");
												    	 	  var fd = new FormData(form_profile_info);
												    	 	    fd.append('file',introVideoData);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-intro-video",
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
																	  			 var response = response;
																	  			 let promise = new Promise(function(resolve, reject) {
																	  			 		$this.displayIntroVideo(response);
																	  			 });
																	  			 
																	  			 $this.updateProfessionalPreview(fd);
																	  			 let msg = $this.lanFilter(allMsgText.YOUR_INTRO_VIDEO_UPLOADED_SUCCESSFULLY);
														   		    			 $this.showSuccessMsg(msg);
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  			 $("#intro-video").modal('hide');
														   				 $profileBtn.text($this.lanFilter(allMsgText.UPLOAD));
														   				 $this.removeFreezPagePopupModal($profileBtn);	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
								},
								uploaRecordedIntroVideo : function(){
															let $this = this;
															$(document).on('click','.upload-intro-video-func',function(){
																//var $this = this;
																if(typeof introVideoData == 'undefined'){
																$('#intro-video .upload-error-n-intro-vdo').text($this.lanFilter(allMsgText.PLEASE_RECORD_INTRO_VIDEO));	  
																$('.error.upload-error-n-intro-vdo').attr("style", "display:block");
																$('.error.upload-error-n-intro-vdo').css("color", "red");
																  setTimeout(function() {
																	  $('.error.upload-error-n-intro-vdo').delay(3000).fadeOut(600);
																  });		
																return false;
																}else{
																	$this.uploadIntroVideo();
																}
																	
															});
								},
								storeProfessionalInfoAdd: function(){
										var $this = this;
										try{
						        			$(document).ready(function(){
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
						        				 $("#form_company_info_add").validate({
														rules: {
															title: {
																required: true,	
																noSpace: true																			
															},
															type_of_employment: {
																required: true,																				
															},
															company_name: {
																required: true,
																noSpace: true
															},
															start_date:{
																required: true
															},
															end_date:{
																required: true
															}
														},
														messages: {
															title: $this.lanFilter(allMsgText.PLEASE_PROVIDE_TITLE),
															type_of_employment: $this.lanFilter(allMsgText.PLEASE_SELECT_TYPE_OF_EMPLOYMENT),
															company_name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_COMPANY_NAME),
															start_date: $this.lanFilter(allMsgText.PLEASE_SELECT_START_DATE),
															end_date: $this.lanFilter(allMsgText.PLEASE_SELECT_END_DATE),
														},
													    submitHandler : function(form){																	   					
													   			$this.addProfessionalDataAjax();
													   		   	return false;
													    }
													});
						        			});
								       }catch(error){
								        	console.log('Validate Candidate Profile info :: '+error);
								       }			
									},	
									addProfessionalDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#add-professional-experience").find(".submit-comp-info-btn");
													   $profileBtn.text($this.lanFilter(allMsgText.SUBMITTING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("form_company_info_add");
												    	 	  var fd = new FormData(form_profile_info);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-professional-info",
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
																	  			//console.log(response);
																	  			if(response == 0){
																	  				let msg = $this.lanFilter(allMsgText.YOUR_COMPANY_ALREADY_ADDED);
															   		   			 	$this.showSuccessMsg(msg);
															   		   			 	$("#form_company_info_add").trigger("reset");
																	  			}else{
																	  				$this.addProfessionalPreview(fd,response);
																		  			let msg = $this.lanFilter(allMsgText.YOUR_COMPANY_DETAILS_ADDED_SUCCESSFULLY);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}
																	  			
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#add-professional-experience").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.SUBMIT));
														   					 $this.removeFreezPagePopupModal($profileBtn);	
																			 $("#add-professional-experience").find('.checkWorking-showhide').css('display','block');
																	});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									},	
									addProfessionalPreview: function(fd,response){ 
										    
											let profilePreview = $("#section2");
											let $this = this;
											var endDate = fd.get('end_date');
											if(fd.get('type_of_employment') == 1){
											var type = $this.lanFilter(allMsgText.FULL_TIME);
											}else if(fd.get('type_of_employment') == 2){
											var type = $this.lanFilter(allMsgText.PART_TIME);
											}else if(fd.get('type_of_employment') == 3){
											var type = $this.lanFilter(allMsgText.CONTRACT);
											}else if(fd.get('type_of_employment') == 4){
											var type = $this.lanFilter(allMsgText.INTERNSHIP);
											}
											else if(fd.get('type_of_employment') == 5){
											var type = $this.lanFilter(allMsgText.SELF_EMPLOYED);
											}
											if(fd.get('currently_working_here') == 1){
												currentCompanyArr.push(1);
												var woking = $this.lanFilter(allMsgText.YES);
												var current = 1;
												endDate = '';
											}else{
												var current = 0;
											    var woking = $this.lanFilter(allMsgText.NO);
											}
											console.log(currentCompanyArr);  
											var url = _BASE_URL+'/frontend/images/pencil-edit-button.svg';
											var html = '<div class="row section-infodata-item" id="edit_company_details_'+response+'"><div class="col-12"><div class="edit-info-holder"><div class="edit-delete-btn-holder"><button class="btn site-btn-color editbtn profEditCls" id="" data-id="'+response+'"><img src="'+url+'"  alt="Edit-icon"></button><button class="btn site-btn-color editbtn deleteProf" id="" data-id="'+response+'" data-current-chk="'+current+'"><i class="las la-trash"></i></button></div></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Title :</label><span class="title_func">'+fd.get('title')+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Type of Employment :</label><span class="type_of_employment_func">'+type+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Company Name :</label><span class="company_name_func">'+fd.get('company_name')+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Currently Working Here :</label><span class="currently_working_here_func">'+woking+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Start Date :</label><span class="start_date_func">'+fd.get('start_date')+'</span></div></div><div class="col-12 col-sm-12 col-md-6 endCls"><div class="form-view"><label class="label-tag">End Date :</label><span class="end_date_func">'+endDate+'</span></div></div></div>';
												profilePreview.find('#apend_data').append( html );
												$("#form_company_info_add").trigger("reset");
									},
									educationInfoUpdate: function(){
									$(document).on('click','.educationEditCls',function(){
										 var educationInfoId = $(this).attr("data-id");
										 $.ajax({
												  url: _BASE_URL+"/candidate/get-educational-info",
												  data:{ 'id': educationInfoId },
												  method:'POST',
												  headers: {
									                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									              },
												  success: function(response){
												  		var objData = JSON.parse(response);
												  		$('.educationPre #id').val(objData.id);
												  		$('.educationPre #school_name').val(objData.school_name);	
												  		$('.educationPre #degree').val(objData.degree);
												  		$('.educationPre #subject').val(objData.subject);
												  		$('.educationPre #start_year').val(objData.start_year);
												  		$('.educationPre #end_year').val(objData.end_year);
												  		$('#education').modal('show');
												    }
												});
									});
								},
								storeEducationalInfo: function(){
										var $this = this;
										try{
						        			$(document).ready(function(){
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
						        				 $("#form_education_info").validate({
														rules: {
															school_name: {
																required: true,	
																noSpace: true																			
															},
															degree: {
																required: true,	
																noSpace: true																			
															},
															subject: {
																required: true,
																noSpace: true
															},
															start_year:{
																required: true
															},
															end_year:{
																required: true
															}
														},
														messages: {
															school_name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_SCHOOL_NAME),
															degree: $this.lanFilter(allMsgText.PLEASE_PROVIDE_DEGREE),
															subject: $this.lanFilter(allMsgText.PLEASE_PROVIDE_FIELD_OF_STUDY),
															start_year: $this.lanFilter(allMsgText.PLEASE_SELECT_START_YEAR),
															end_year: $this.lanFilter(allMsgText.PLEASE_SELECT_END_YEAR),
														},
													    submitHandler : function(form){	
													    		var i = parseInt($('.addEdu #start_year').val());
												    			var j = parseInt($('.addEdu #end_year').val());	
												    			//console.log(i);
												    			//console.log(j);
												    			if(i > j){
												    				$('.addEdu #end_year_err').html($this.lanFilter(allMsgText.END_YEAR_MUST_GREATER_THAN_START_YEAR));
												    				$('.addEdu #start_year_err').html($this.lanFilter(allMsgText.START_YEAR_MUST_LESS_THAN_END_YEAR));
												    				$('.addEdu #end_year_err').css('display','block');
												    				$('.addEdu #start_year_err').css('display','block');
												    			}else{																   					
														   			$this.storeEducationalDataAjax();
														   		   	return false;
													   		   }
													    }
													});
						        			});
								       }catch(error){
								        	console.log('Validate Candidate Profile info :: '+error);
								       }			
									},
									storeEducationalDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#education").find(".submit-edu-info-btn");
													   $profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("form_education_info");
												    	 	  var fd = new FormData(form_profile_info);
												    	 	 // console.log(form_profile_info);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-educational-info",
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
																	  			//console.log(response);
																	  			$this.updateEducationalPreview(fd);
																	  			let msg = $this.lanFilter(allMsgText.YOUR_EDUCATIONAL_DETAILS_UPDATED_SUCCESSFULLY);
														   		   			 	$this.showSuccessMsg(msg);
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#education").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
														   					 $this.removeFreezPagePopupModal($profileBtn);	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									},
									updateEducationalPreview: function(fd){ 
											 let profilePreview = $("#edit_education_details_"+fd.get('id'));
											 profilePreview.find('.school_name_func').text(fd.get('school_name'));
											 profilePreview.find('.degree_func').text(fd.get('degree'));
											 profilePreview.find('.subject_func').text(fd.get('subject'));
											 profilePreview.find('.start_year_func').text(fd.get('start_year'));
											 profilePreview.find('.end_year_func').text(fd.get('end_year'));
									},
									storeEducationalInfoAdd: function(){
										var $this = this;
										try{
						        			$(document).ready(function(){
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
						        				 $("#form_edu_info_add").validate({
														rules: {
															school_name: {
																required: true,	
																noSpace: true																			
															},
															degree: {
																required: true,	
																noSpace: true																			
															},
															subject: {
																required: true,
																noSpace: true
															},
															start_year:{
																required: true,
															},
															end_year:{
																required: true,
															}
														},
														messages: {
															school_name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_SCHOOL_NAME),
															degree: $this.lanFilter(allMsgText.PLEASE_PROVIDE_DEGREE),
															subject: $this.lanFilter(allMsgText.PLEASE_PROVIDE_FIELD_OF_STUDY),
															start_year: {
																required: $this.lanFilter(allMsgText.PLEASE_SELECT_START_YEAR),
															},
															end_year: {
																required: $this.lanFilter(allMsgText.PLEASE_SELECT_END_YEAR),
															}
														},
													    submitHandler : function(form){	
													    		var i = parseInt($('.addEdu #start_year').val());
												    			var j = parseInt($('.addEdu #end_year').val());	
												    			//console.log(i);
												    			//console.log(j);
												    			if(i > j){
												    				$('.addEdu #end_year_err').html($this.lanFilter(allMsgText.END_YEAR_MUST_GREATER_THAN_START_YEAR));
												    				$('.addEdu #start_year_err').html($this.lanFilter(allMsgText.START_YEAR_MUST_LESS_THAN_END_YEAR));
												    				$('.addEdu #end_year_err').css('display','block');
												    				$('.addEdu #start_year_err').css('display','block');
												    			}else{
												    				$this.storeEducationalAddDataAjax();
													   		   		return false;
												    			}															   					
													   			
													    }
													});
						        			});
								       }catch(error){
								        	console.log('Validate Candidate Profile info :: '+error);
								       }			
									},
									storeEducationalAddDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#add-education").find(".submit-edu-info-btn");
													   $profileBtn.text($this.lanFilter(allMsgText.ADDING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("form_edu_info_add");
												    	 	  var fd = new FormData(form_profile_info);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-educational-info",
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
																	  			//console.log(response);
																	  			$this.addEducationalPreview(fd,response);
																	  			let msg = $this.lanFilter(allMsgText.YOUR_EDUCATIONAL_DETAILS_UPDATED_SUCCESSFULLY);
														   		   			 	$this.showSuccessMsg(msg);
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#add-education").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.ADD));
														   					 $this.removeFreezPagePopupModal($profileBtn);
														   					 $("#form_edu_info_add").trigger("reset");
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									 },
									 addEducationalPreview: function(fd,response){ 
											let profilePreview = $("#section2");
											var url = _BASE_URL+'/frontend/images/pencil-edit-button.svg';
											var html = '<div class="row section-infodata-item" id="edit_education_details_'+response+'"><div class="col-sm-12"><div class="edit-info-holder"><div class="edit-delete-btn-holder"><button class="btn site-btn-color editbtn educationEditCls" data-id="'+response+'"><img src="'+url+'"  alt="Edit-icon"></button><button class="btn site-btn-color editbtn deleteEducation" data-id="'+response+'"><i class="las la-trash"></i></button></div></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">School :</label><span class="school_name_func">'+fd.get("school_name")+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Degree :</label> <span class="degree_func">'+fd.get("degree")+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Field of study :</label><span class="subject_func">'+fd.get("subject")+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Start Year :</label><span class="start_year_func">'+fd.get("start_year")+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">End Year :</label><span class="end_year_func">'+fd.get("end_year")+'</span></div></div></div>';
												profilePreview.find('#apend_education_data').append( html );
												$("#form_company_info_add").trigger("reset");
									},
									languageInfoUpdate: function(){
									$(document).on('click','.langEditCls',function(){
										 var lang = $(this).attr("data-lang");
										 var prof = $(this).attr("data-prof");
										 $('.langClass #master_cms_cat_id').val(lang);
										 $('.langClass #master_fluncy').val(prof);
										 $('.langClass #lang_unique_id').val(lang);
										 $('.langClass #old_lang_id').val(lang);
										 $('.langClass #old_fluency_id').val(prof);	
										 $('#language').modal('show');
									});
								},
								storeLanguageInfo: function(){
										var $this = this;
										try{
						        			$(document).ready(function(){
						        				 
						        				 $("#form_lang_edit").validate({
														rules: {
															master_cms_cat_id: {
																required: true,																				
															},
															master_fluncy: {
																required: true,																				
															}
														},
														messages: {
															master_cms_cat_id: $this.lanFilter(allMsgText.PLEASE_SELECT_LANGUAGE),
															master_fluncy: $this.lanFilter(allMsgText.PLEASE_SELECT_PROFICIANCY_LEVE),
														},
													    submitHandler : function(form){																	   					
													   			$this.storeLangDataAjax();
													   		   	return false;
													    }
													});
						        			});
								       }catch(error){
								        	console.log('Validate Candidate Profile info :: '+error);
								       }			
									},
									storeLangDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#language").find(".submit-lang-info-btn");
													   $profileBtn.text('Updating...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("form_lang_edit");
												    	 	  var fd = new FormData(form_profile_info);
												    	 	  var langId = $('#lang_unique_id').val();

									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-language-info",
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
																	  			if(response == 1){
																	  				let msg = $this.lanFilter(allMsgText.YOU_HAVE_ALREADY_ADDED_THIS_LANGUAGE);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}else{
																	  				//console.log(response);
																		  			$this.updateLanguagePreview(response,langId);
																		  			let msg = $this.lanFilter(allMsgText.YOUR_LANGUAGE_DETAILS_UPDATED_SUCCESSFULLY);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#language").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
														   					 $this.removeFreezPagePopupModal($profileBtn);	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									},
									updateLanguagePreview: function(response,id){ 
										 let profilePreview = $("#edit_language_details_"+id);
										 $.each(response, function(key, value) {
											if(value['type'] == 'proficiency'){
												profilePreview.find('.fluency_func').text(value['name']);
											}
											else if(value['type'] == 'language'){
												profilePreview.find('.lang_name_func').text(value['name']);
											}
										});
										 
									},
									storeLanguageInfoAdd: function(){
										var $this = this;
										try{
						        			$(document).ready(function(){
						        				 
						        				 $("#form_lang_add").validate({
														rules: {
															master_cms_cat_id: {
																required: true,																				
															},
															master_fluncy: {
																required: true,																				
															}
														},
														messages: {
															master_cms_cat_id: $this.lanFilter(allMsgText.PLEASE_SELECT_LANGUAGE),
															master_fluncy: $this.lanFilter(allMsgText.PLEASE_SELECT_PROFICIANCY_LEVE),
														},
													    submitHandler : function(form){																	   					
													   			$this.storeLangAddDataAjax();
													   		   	return false;
													    }
													});
						        			});
								       }catch(error){
								        	console.log('Validate Candidate Profile info :: '+error);
								       }			
									},
									storeLangAddDataAjax: async function(){
													   var $this = this;
													   var $profileBtn = $("#add-language").find(".submit-lang-info-btn-add");
													   $profileBtn.text($this.lanFilter(allMsgText.ADDING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("form_lang_add");
												    	 	  var fd = new FormData(form_profile_info);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-language-info",
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
																	  			if(response == 1){
																	  				let msg = $this.lanFilter(allMsgText.YOU_HAVE_ALREADY_ADDED_THIS_LANGUAGE);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}else{
																	  				//console.log(response);
																		  			$this.addLangAddPreview(response);
																		  			let msg = $this.lanFilter(allMsgText.YOUR_LANGUAGE_DETAILS_ADDED_SUCCESSFULLY);
															   		   			 	$this.showSuccessMsg(msg);
																	  			}
																	  			
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  				 $("#add-language").modal('hide');
														   					 $profileBtn.text($this.lanFilter(allMsgText.ADD));
														   					 $this.removeFreezPagePopupModal($profileBtn);
														   					 $("#form_lang_add").trigger("reset");	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
									 },
									 addLangAddPreview: function(response){ 
									 		var prof_id = '';
									 		var lang_id = '';
									 		var proficiency = '';
									 		var language = '';
									 		$.each(response, function(key, value) {
												if(value['type'] == "proficiency"){
													proficiency = value['name'];
													prof_id = value['id'];
												}
												else if(value['type'] == "language"){
													language = value['name'];
													lang_id = value['id'];
												}
											});
											
											let profilePreview = $("#section2");
											var url = _BASE_URL+'/frontend/images/pencil-edit-button.svg';
											var html = '<div class="row" id="edit_language_details_'+lang_id+'"><div class="col-sm-12"><div class="edit-info-holder"><div class="edit-delete-btn-holder"><button class="btn site-btn-color editbtn langEditCls" data-lang="'+lang_id+'" data-prof="'+prof_id+'"><img src="'+url+'" alt="Edit-icon"></button><button class="btn site-btn-color editbtn deleteLang" data-lang="'+lang_id+'" data-prof="'+prof_id+'"><i class="las la-trash"></i></button></div></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Language</label><span class="lang_name_func">'+language+'</span></div></div><div class="col-12 col-sm-12 col-md-6"><div class="form-view"><label class="label-tag">Proficiency Level</label><span class="fluency_func">'+proficiency+'</span></div></div></div>';
												profilePreview.find('#langAddCls').append( html );
												$("#form_lang_add").trigger("reset");
									},
									removeIntroVideo : function(){
													let $this = this;
													$(document).on('click','.remove-intri-video-func',function(){
														    let $that = $(this);
															swal({
																	  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
																	  text: $this.lanFilter(allMsgText.ONCE_DELETED_NOT_ABLE_TO_RECOVER_INTRO_VIDEO),
																	  icon: "warning",
																	  buttons: true,
																	  dangerMode: true,
																	})
																	.then((willDelete) => {
																	  if (willDelete) {
																	  	  $this.removeIntroVideoFromServer();	
																	  	  																	      
																	  }
																	});	
													});
									},
									removeIntroVideoFromServer : async function(){
													   var $this = this;
													   var $profileBtn = $(".intro-video-msg");
													   $profileBtn.text($this.lanFilter(allMsgText.REMOVING_INTRO_VIDEO)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_security = document.getElementById("security_form");
												    	 	  var fd = new FormData(form_security);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/remove-intro-video",
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
																	  			let msg = $this.lanFilter(allMsgText.YOUR_INTRO_VIDEO_REMOVED_SUCCESSFULLY);
														   		   			 	$this.showSuccessMsg(msg);
																	  },
																	  error: function(){
																	  		 alert("Something happend wrong.Please try again");
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {															  				 
														   					 $profileBtn.text($this.lanFilter(allMsgText.INTRO_VIDEO));
														   					 $this.removeFreezPagePopupModal($profileBtn);	
														   					 $('.intro-video-div-func').fadeOut(function(){
																	  	  	    $('#intro-video-default').addClass('d-flex');
																				$('.intro-video-default').fadeIn();
																				//$("#intro-video").addClass('d-flex');	
																				//$("#intro-video").find('.video-js.vjs-default-skin').find('source').attr("src",'');															  	  		
																				//$this.reinitialiseVideoRecorder();
																				  location.reload();
																	  	     });
																	  	     $('.intro-video-div-func').find('video').trigger('pause');																	  	    																	  	     
														   					 
															});										        				 
										        			
												       }catch(error){
												        	console.log('RemoveIntroVideoFromServer function :: '+error);
												       }
									},
									openIntroVideoModal : function(){
														$(document).on('click','.open-record-intro-popup',function(){
															$('.open-intro-modal-func').trigger('click');
														});
									},
									displayIntroVideo : function(response){
														let $response = response;
														let introVideoUrl = _BASE_URL+$response.intro_info.location;console.log(introVideoUrl);
														$('#intro-video-default').removeClass('d-flex');
														$('#intro-video-default').hide();															
														$('.intro-video-div-func').fadeIn(function(){															
															$(this).find('.video-js.vjs-default-skin').find('source').attr("src",introVideoUrl);

															$(this).find('.video-js.vjs-default-skin')[0].load(); 
															$(this).find('.video-js.vjs-default-skin').trigger('play');
														});

									},
									uploadIntroVideoFromDevice : function(){
											let $this = this;
											$(document).on('change','#intro_video',function(){
													let introVideFile = this.files[0];
													$this.storeIntroVideoFromDevice(introVideFile,false);
											});
									},
									storeIntroVideoFromDevice : async function(introVideFile,isDarg){
											       	   var $this = this;
											       	   var isDarg = isDarg;
											       	   if(typeof introVideFile == 'undefined'){
											       	   	  return false;
											       	   }
											       	    let allowedFileTypes = ['mp4','wmv','mpeg'];
														let fileName = introVideFile.name;	
														let fileSize = 	introVideFile.size;	
														let isNotValidFile = $this.validateFileType(allowedFileTypes,fileName.toLowerCase());
														if(isNotValidFile){
															$('.error.upload-error-n-intro').text($this.lanFilter(allMsgText.ONLY_MP4_MPEG_WMV_VIDEO_ALLOWED));												
															$('.error.upload-error-n-intro').attr("style", "display:block");
															setTimeout(function() {
																$('.error.upload-error-n-intro').delay(3000).fadeOut(600);
															});
															return false;
														}											
														$('.error.upload-error-n-intro').hide();
														if(fileSize > (1024*(1024*20))){
															$('.error.upload-error-n-intro').text($this.lanFilter(allMsgText.THE_ALLOWED_MAX_FILE_SIZE_IS_20MB));												
															$('.error.upload-error-n-intro').attr("style", "display:block");
															setTimeout(function() {
																$('.error.upload-error-n-intro').delay(3000).fadeOut(600);
															});
															return false;
														}
													    var $profileBtn = $("#intro_video_label");
													    $("#intro_video").prop('disabled', true);
														
													   //$profileBtn.text($this.lanFilter(allMsgText.UPLOADING)+'...');
													   $this.freezPagePopupModal($profileBtn);
													   await sleep(2000);
													  try{
												    	 	  var form_profile_info = document.getElementById("video_intro_form");
												    	 	  var fd = new FormData(form_profile_info);
												    	 	    fd.append('file',introVideFile);
									        				 $.ajax({
																	  url: _BASE_URL+"/candidate/store-intro-video",
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
																	  			 if(isDarg){
																	  			 		//Drag and drop Files Here to upload	
																						$('#section6').removeClass('disable-click');																															
																						$('.file-uploding-progress').text($this.lanFilter(allMsgText.DRAG_AND_DROP_FILES_HERE_TO_UPLOAD));
																						$('.btn.site-btn-color.open-record-intro-popup').text($this.lanFilter(allMsgText.OR_SELECT_FILES_TO_UPLOAD));
																	  			 }
																	  			 var response = response;
																			  			 let promise = new Promise(function(resolve, reject) {
																			  			 		$this.displayIntroVideo(response);
																			  			 });
																	  			 
																	  			 let msg = $this.lanFilter(allMsgText.YOUR_INTRO_VIDEO_UPLOADED_SUCCESSFULLY);
														   		    			 $this.showSuccessMsg(msg);
																	  },
																	  error: function(){
																			   alert("Something happend wrong.Please try again");
																			   $("#intro_video").prop('disabled', false);
																	  		 $this.removeFreezPagePopupModal($profileBtn);
																	  }	
																	}).done(function() {
															  			//  $("#intro-video").modal('hide');
																		   //  $profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
																		   $("#intro_video").prop('disabled', false);
														   				 $this.removeFreezPagePopupModal($profileBtn);	
															});										        				 
										        			
												       }catch(error){
												        	console.log('storeProfileDataAjax function :: '+error);
												       }	
								},
								dragIntroFileToUpload : function(){
													let $this = this;
													// drop the files here 
													$('#intro-video-default').on("drag dragstart dragend dragover  dragenter  drop",function(event){
													      event.preventDefault();
													      event.stopPropagation();
													      $(this).css("background-color","#f1f1f1");
													     
													}).on("drop",function(event){
													       $(this).css("background-color","");
													      //loop files  
													      let droppedFiles = event.originalEvent.dataTransfer.files;
		 
													      if(droppedFiles.length){
													      	
													      	    let introVideFile = droppedFiles[0];
													      	    let fileSize = introVideFile.size;
													      	 	let allowedFileTypes = ['mp4','wmv','mpeg'];
																let fileName = introVideFile.name;						
																let isNotValidFile = $this.validateFileType(allowedFileTypes,fileName.toLowerCase());
																if(isNotValidFile){
																	$('.file-upload-error-drop').text($this.lanFilter(allMsgText.ONLY_MP4_MPEG_WMV_VIDEO_ALLOWED)).show();												
																	return false;
																}else if(fileSize > (1024*(1024*20))){
																	$('.file-upload-error-drop').text($this.lanFilter(allMsgText.THE_ALLOWED_MAX_SIZE_2MB)).show();
																	return false;
																}	
																//Drag and drop Files Here to upload	
																$('#section6').addClass('disable-click');									
																$('.file-upload-error-drop').hide();
																$('.file-uploding-progress').text($this.lanFilter(allMsgText.YOUR_VIDEO_BEING_UPLOADED)+'...');
																$('.btn.site-btn-color.open-record-intro-popup').text($this.lanFilter(allMsgText.UPLOADING)+'...');
																$this.storeIntroVideoFromDevice(introVideFile,true);
													      }
													      //end loop and push files
													}).on("dragleave", function() { // drop out side of the div									   
													    $(this).css("background-color","");
													});

													//off drag drop to other section of page
													$('div:not(#intro-video-default)').on('drag dragstart dragend dragover  dragenter  drop',function(event){  									   
													      event.preventDefault();  
													      
													});
								},
								deleteLanguage : function(){
									var $this = this;
									$(document).on('click','.deleteLang',function(){
											var lang = $(this).attr("data-lang");
										 	var prof = $(this).attr("data-prof");
										 	//console.log(lang);
										 	//console.log(prof);
											try{
												swal({
												  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
												  text: $this.lanFilter(allMsgText.DO_YOU_WANT_TO_DELETE_THIS_LANGUAGE),
												  icon: "warning",
												  buttons: true,
												  dangerMode: true,
												})
												.then((willDelete) => {
												  if (willDelete) {
												  	  $.ajax({
													  url: _BASE_URL+"/candidate/delete-language-info",
													  data:{'lang_id':lang, 'prof_id':prof},
													  method:'POST',
													  headers: {
								                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								                      },
													  success: function(response){
													  	//console.log(response);
												  			$("#edit_language_details_"+lang).remove();
												  			let msg = $this.lanFilter(allMsgText.YOUR_LANGUAGE_DELETED_SUCCESSFULLY);
									   		   			 	$this.showSuccessMsg(msg);
													  },
													  error: function(){
													  		 alert("Something happend wrong.Please try again");
													  }	
													}).done(function() {
											  				 
													});			
												  	  																	      
												  }
												});	
					        				  							        				 
						        			
								       }catch(error){
								        	console.log('storeProfileDataAjax function :: '+error);
								       }
									});
								},
								deleteProfessionalInfo : function(){
									var $this = this;
									$(document).on('click','.deleteProf',function(){
											var id = $(this).attr("data-id");
											var currentOrNot = $(this).attr("data-current-chk");
											try{
												swal({
												  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
												  text: $this.lanFilter(allMsgText.DO_YOU_WANT_TO_DELETE_COMPANY_DETAILS),
												  icon: "warning",
												  buttons: true,
												  dangerMode: true,
												})
												.then((willDelete) => {
												  if (willDelete) {
												  	  $.ajax({
													  url: _BASE_URL+"/candidate/delete-professional-info",
													  data:{'id':id},
													  method:'POST',
													  headers: {
								                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								                      },
													  success: function(response){
												  			$("#edit_company_details_"+id).remove();
												  			let msg = $this.lanFilter(allMsgText.YOUR_COMPANY_DETAILS_DELETED_SUCCESSFULLY);
															$this.showSuccessMsg(msg);
															if(currentOrNot == 1){
																console.log(currentCompanyArr);
																jQuery.each(currentCompanyArr, function(i, val) {
																	if(val == 1) // delete index
																	{
																	   delete currentCompanyArr[i];
																   }
																 });
																 console.log(currentCompanyArr);
															}
																   
													  },
													  error: function(){
													  		 alert("Something happend wrong.Please try again");
													  }	
													}).done(function() {
											  				 
													});			
												  	  																	      
												  }
												});	
					        				  							        				 
						        			
								       }catch(error){
								        	console.log('storeProfileDataAjax function :: '+error);
								       }
									});
								},
								deleteEducationalInfo : function(){
									var $this = this;
									$(document).on('click','.deleteEducation',function(){
											var id = $(this).attr("data-id");
											try{
												swal({
												  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
												  text: $this.lanFilter(allMsgText.DO_YOU_WANT_TO_DELETE_EDUCATION_DETAILS),
												  icon: "warning",
												  buttons: true,
												  dangerMode: true,
												})
												.then((willDelete) => {
												  if (willDelete) {
												  	  $.ajax({
													  url: _BASE_URL+"/candidate/delete-educational-info",
													  data:{'id':id},
													  method:'POST',
													  headers: {
								                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								                      },
													  success: function(response){
												  			$("#edit_education_details_"+id).remove();
												  			let msg = $this.lanFilter(allMsgText.YOUR_EDUCATION_DETAILS_DELETE_SUCCESSFULLY);
									   		   			 	$this.showSuccessMsg(msg);
													  },
													  error: function(){
													  		 alert("Something happend wrong.Please try again");
													  }	
													}).done(function() {
											  				 
													});			
												  	  																	      
												  }
												});	
					        				  							        				 
						        			
								       }catch(error){
								        	console.log('storeProfileDataAjax function :: '+error);
								       }
									});
								},
								uniqueChkCompanyName : function(){
									var $this = this;
									$(document).on('keyup','.uniqueChk',function(){
											var company = $('.professionalCls .uniqueChk').val();
										 	
											try{
											  	  $.ajax({
												  url: _BASE_URL+"/company/check-unique-company",
												  data:{'company':company},
												  method:'POST',
												  headers: {
							                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							                      },
												  success: function(response){
												  		if(response > 0){
												  			$('.professionalCls .uniqueChk').val('');
												  			$('.professionalCls .errorCls').html($this.lanFilter(allMsgText.COMPANY_NAME_ALREADY_EXIST));
												  			$('.professionalCls .errorCls').attr("style", "display:block");
												  			setTimeout(function() {
															    $('.professionalCls .errorCls').delay(3000).fadeOut(600);
													    	});
												  		}
											  			
												  },
												  error: function(){
												  		 alert("Something happend wrong.Please try again");
												  }	
												}).done(function() {
										  				 
												});			
											
								       }catch(error){
								        	console.log('storeProfileDataAjax function :: '+error);
								       }
									});
								},
						 uploadBannerImgeFromLibrary : function(id,base64Img) {
											 let $this = this;
											 var user_type = $('#user').val();
											 if(user_type == 3){
											 var url_store = _BASE_URL+"/company/upload-lib-banner-img";
											 }else{
											 var url_store = _BASE_URL+"/candidate/upload-lib-banner-img";
											 }
										  	$.ajax({
													  url: url_store,
													  data:{'id':id},
													  method:'POST',
													  headers: {
								                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								                      },
													  success: function(response){												  			
												  			
													  },
													  error: function(){
													  		 alert("Something happend wrong.Please try again");
													  }	
											}).done(function() {
															$("#change-image-banner").find(".close").trigger('click');
															$("#banner-image-src").attr("src",base64Img);
													  		let msg = $this.lanFilter(allMsgText.YOUR_BACKGROUND_IMAGE_CHANGED_SUCCESSFULLY);
											   		   		$this.showSuccessMsg(msg);	
											   		   		
											   		   		var $profileBtn = $(".upload-lib-banner-func");
															$profileBtn.text($this.lanFilter(allMsgText.UPDATE_JOB));
															$this.removeFreezPagePopupModal($profileBtn);	
															//$('.func-profile-banner-holder.selected-banner').removeClass('selected-banner'); 
															$('#nav-tab').find('.nav-item.nav-link.active').removeClass('show');
															$('#nav-tab').find('.nav-item.nav-link.active').removeClass('active');
															$('#nav-tab').find('#nav-home-tab').trigger('click');															
											});	
						},
						getBase64ImageFromURL: function(url, callback) {

											  var xhr = new XMLHttpRequest();
											  xhr.onload = function() {
											    var reader = new FileReader();
											    reader.onloadend = function() {
											      callback(reader.result);
											    }
											    reader.readAsDataURL(xhr.response);
											  };
											  xhr.open('GET', url);
											  xhr.responseType = 'blob';
											  xhr.send();
											
						},
						initialiseFuntionOnLibImgSelect : function(){
											var $this = this;
											$(document).on('click','.func-profile-banner-holder',function(){
												$('.profile-bg').find('.selected-banner').removeClass('selected-banner');
												$(this).addClass('selected-banner');
											});
											$(document).on('click','.upload-lib-banner-func',function(){
												let selectedImg = $('.profile-bg').find('.selected-banner').length;
												if(selectedImg){
													var $profileBtn = $(".upload-lib-banner-func");
													$profileBtn.text($this.lanFilter(allMsgText.UPDATING)+'...');
													$this.freezPagePopupModal($profileBtn);
													
													let imageSrc = $('.func-profile-banner-holder.selected-banner').find('img').attr('src');
													let libId = $('.func-profile-banner-holder.selected-banner').attr('data-id');												
													$this.getBase64ImageFromURL(imageSrc,function(myBase64){													  
														  $this.uploadBannerImgeFromLibrary(libId,myBase64);													 
													});
												}else{
													swal($this.lanFilter(allMsgText.UPLOAD_FROM_LIBRARY), $this.lanFilter(allMsgText.SELECT_ANY_IMAGE_FROM_LIBRARY));
												}
												
											});
						},
						deleteBannerImageNew :  function(){
												let $this = this;										
												$(document).on('click','.remove-old-banner-img-func',function(){
													let fileName = $('#banner-image-src').attr('src');
													fileName = fileName.split('/');
													if(fileName.includes('user-pro-bg-img.jpg')){
														swal($this.lanFilter(allMsgText.BACKGROUND_IMAGE_REMOVAL),$this.lanFilter(allMsgText.YOU_DONT_HAVE_BACKGROUND_IMAGE_TO_REMOVE));
														return false;
													}
													swal({
													  title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
													  text: $this.lanFilter(allMsgText.ONCE_DELETED_NOT_ABLE_TO_RECOVER_BANNER_IAMAGE),
													  icon: "warning",
													  buttons: true,
													  dangerMode: true,
													})
													.then((willDelete) => {
													  if (willDelete) {
													      $this.removeBannerImg();
													  }
													});	
												});
																					
										
									    
						},
				validateImageSelectProfile: function(){
												var $this = this;
												$(document).on("click","#upload_image_now",function(){
																	  			// Remove the editor from the view
														    // Get the canvas with image data from Cropper.js
																 if(dropZoneFileUploaded){
																 		swal($this.lanFilter(allMsgText.PROFILE_IMAGE_UPLOAD), $this.lanFilter(allMsgText.SELECT_AN_IAMGE_FIRST));
																 		return false;
																 }
												 });
				},
				validateBannerImgSelect: function(){
										var $this = this;
												$(document).on("click","#upload_banner_image_now",function(){
																	  			// Remove the editor from the view
														    // Get the canvas with image data from Cropper.js
																 if(dropZoneFileUploadedBanner){
																 		swal($this.lanFilter(allMsgText.BACKGROUND_IMAGE_UPLOAD), $this.lanFilter(allMsgText.SELECT_AN_IAMGE_FIRST));
																 		return false;
																 }
												 });
				},
				

				createDynamicCalendar : function(idCalendarStart,idCalendarEnd){
										  $('#'+idCalendarStart).datepicker({dateFormat:'yy-mm-d'});
										  $('#'+idCalendarEnd).datepicker({
										            useCurrent: false, //Important! See issue #1075
										            dateFormat:'yy-mm-d',
										  });
										  $("#"+idCalendarStart).on("dp.change", function (e) {
										            $('#'+idCalendarEnd).data("DateTimePicker").minDate(e.date);
										  });
										 $("#"+idCalendarEnd).on("dp.change", function (e) {
										            $('#'+idCalendarStart).data("DateTimePicker").maxDate(e.date);
										  });
				},
				reinitialiseVideoRecorder : function(){
										   player = videojs('myVideo', options, function() {
										    // print version information at startup
										    var msg = 'Using video.js ' + videojs.VERSION +
										        ' with videojs-record ' + videojs.getPluginVersion('record') +
										        ' and recordrtc ' + RecordRTC.version;
										    videojs.log(msg);
										});

										// error handling
										player.on('deviceError', function() {
										   swal("Sorry! no camera or microphone found.")
										   .then((value) => {
										      
										   });
										    console.log('device error:', player.deviceErrorCode);
										});

										player.on('error', function(element, error) {
										    console.error(error);
										});

										// user clicked the record button and started recording
										player.on('startRecord', function() {
										    console.log('started recording!');
										    $("#intro-video").find(".close").attr("disabled", true);
										    $("#intro-video").find(".upload-intro-video-func").attr("disabled", true);
										    $("#intro-video").find("#intro_video").attr("disabled", true);
										    $("#intro-video").find("#intro_video_label").attr("disabled", true);
										    $("#intro-video").modal({
										            backdrop: 'static',
										            keyboard: false
										        });
										});

										// user completed recording and stream is available
										player.on('finishRecord', function() {
										   $("#intro-video").find(".close").attr("disabled", false);
										   $("#intro-video").find(".upload-intro-video-func").attr("disabled", false);
										   $("#intro-video").find("#intro_video").attr("disabled", false);
										   $("#intro-video").find("#intro_video_label").attr("disabled", false);
										    // the blob object contains the recorded data that
										    // can be downloaded by the user, stored on server etc.
										    console.log('finished recording: ', player.recordedData);
										    introVideoData = player.recordedData;
										});
				},
				refreshIntroVideo:  function(){
					let $this = this;										
					$(document).on("click",".delete-intro-video-func",function(){
						$(".refresh-modal-intro").hide();  
						// let msg = $this.lanFilter(allMsgText.YOUR_INTRO_VIDEO_REMOVED_SUCCESSFULLY);
						// $this.showSuccessMsg(msg);
						localStorage.setItem("message_local", "delete_intro");
						localStorage.setItem("myitme", "intro");
						window.location.href = _BASE_URL+"/candidate/my-profile";
						
					});
				
				},


}
profileFunctions.init();//initilized
