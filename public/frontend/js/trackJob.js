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
 									defaultProfileImg : _BASE_URL+'/frontend/images/user-pro-img-demo.png', 
 									defaultBannerImg : _BASE_URL+'/frontend/images/user-pro-bg-img.jpg',
 									documentImg : _BASE_URL+'/frontend/images/doc-img.png',
 									pdfImg : _BASE_URL+'/frontend/images/pdf-img.png',
 									deafulCvImg : _BASE_URL+'/frontend/images/document.png',
 																		
 									init : function(){ 		
											this.saveJob();
											this.listing();
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
									saveJob : function(){
									$(document).ready(function() {
										$( ".saveJobCls" ).on( "click", function() {
											var $this = this;
											var jobId = $($this).attr("data-id");
											var saveType = $($this).attr("data-type");
											$.ajax({
												method: "POST",
												url: _BASE_URL+"/candidate/save-job",
												data: {'id': jobId, 'saveType' : saveType},
												headers: {
													'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
												},
												success: function(res) {
													// console.log(res);
													if(saveType == 0){
														$("#rmv_job_from_save_"+jobId).remove();
													}
													
												}
											}); 
										}); 
									});
								},
								listing : function(){
									var $this = this;
									$(document).ready(function() {
										$('input[name=company]').click(function() {
											$('.ajax-load').show();
											window.scrollTo(0,0);
											var status = $(this).val(); 
											$('#page').val(1);
											var page = $('#page').val();
											$.ajax(
												{   
													url: _BASE_URL+'/candidate/track-job?page=' + page+'&status='+status+'&flag=1',
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
														
																
													}
												})
												.done(function(data)
												{
													//console.log(data);
													$('.ajax-load').hide();
													if(data.html == 0){
														$('.ajax-load').html('');
														return;
													}
													$("#post-data").html(data.html);
												})
												.fail(function(jqXHR, ajaxOptions, thrownError)
												{
													alert('server not responding...');
												});
										});
										// scroll pagination
										
										
										$(window).scroll(function() {
											if($(window).scrollTop() == $(document).height() - $(window).height()) {
												var page = $('#page').val();
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
												var status = $("input[name='company']:checked").val();
												
														$.ajax(
															{   
																url: _BASE_URL+'/candidate/track-job?page=' + page+'&status='+status,
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
																//console.log(data);
																//$('.ajax-load').hide();
																if(data == 0){
																	$('.ajax-load').html('');
																	return;
																}else{
																	let pageno = $('#page').val();
																	pageno++;
																	$('#page').val(pageno);
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
								
									
 									
}
jobFunctions.init();//initilized
