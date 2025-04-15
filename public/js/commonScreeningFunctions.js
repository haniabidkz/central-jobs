/**
 * Developer : Israfil
 * Date : 19/04/2020
 * Object is the container of common & usefull function.So we can use it accross the site
 * We need to intialize this object with commonFunctions.init(); before using this
 *
 */
 const commonScreeningFunctions = {
 									base_url : _BASE_URL,
 									init : function(){ 		
 											this.validateMcqForm();//page login
 									},
								    validateMcqForm : function(){
								    				   try{
										        			$(document).ready(function(){
										        				// Check the radio button value. 
														        $('.mcqAnsCls').on('click', function() { 
														        	var total = $('#total').val();
														        	var i = 0;
														        	var j = 0;
														        	for(i=0; i<total; i++){
														        		$('#secAns_'+i).html('');
														        		var output1 = $("input:radio[name='check_"+i+"']").is(":checked");
														        		if(output1 == false){
														            		$('#secAns_'+i).html(allMsgText.PLEASE_SELECT_CORRECT_ANSWER);
														            	}else{
														            		j++;
														            	}
														        	}
														        	if(j == total){
														        		$('#mcqAns').submit();
														        	}
														        	
														        }); 
										        			});
												       }catch(error){
												        	console.log('Validate Screening Question Form:: '+error);
												       } 
								    },
 }
commonScreeningFunctions.init();//initilized