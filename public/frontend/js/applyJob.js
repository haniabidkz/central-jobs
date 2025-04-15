function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

var Post = {
    documentImg : _BASE_URL+'/frontend/images/doc-img.png',
    pdfImg : _BASE_URL+'/frontend/images/pdf-img.png',
    init: function(){
         this.applyJobStepOne();
         this.applyJobStepOneStore();
         this.getState();
         this.getCity();
         this.applyJobStepTwoStore();
         this.applyJob();
         this.uploaRecordedIntroVideo();
         this.checkCvFileOnFileUploadSelect();
         this.chkFirstStepValidationForNext();
         this.updateSelectedVideo();
         this.discardJobDetails();
    },
    
    showSuccessMsg : function(msg){
        let msgBox = $(".alert-holder-success");
        msgBox.addClass('success-block');
        msgBox.find('.alert-holder').html(msg);
        setTimeout(function(){ msgBox.removeClass('success-block')},20000);
    },
    lanFilter : function(str){
        var res = str.split("|");
        if(res[1] != undefined){
            str = str.replace("|","'");
            return str;
        }else{
            return str;
        }
        
    },
    checkCvFileOnFileUploadSelect : function(){
        let $this = this;
        $(document).on('click','.cv_file_upload',function(event){
            setTimeout(function(){
                    $(".media-body").find('.la.la-file-alt').addClass('d-none');
                    $(".media-body").find('.la.la-file-pdf').removeClass('d-none');
                    $(".media-body").find('.media.file-name-image').hide();
                    $(".media-body").find(".cv-name-func").text('');
                    $(".media-body").find('.cv-holder').find('img').attr('src','');
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
                    $(".media-body").find(".cv-name-func").text('');
                    $(".media-body").find('.media.file-name-image').hide();
                    return false;
                }											
                $('.error.upload-error-n').hide();
                
                if(fileType == 'pdf'){
                    $(".media-body").find('.la.la-file-alt').addClass('d-none');
                    $(".media-body").find('.la.la-file-pdf').removeClass('d-none');
                    $(".media-body").find('.media.file-name-image').show();
                    $(".media-body").find(".cv-name-func").text(fileName);	
                    $(".media-body").find('.cv-holder').find('img').attr('src',$this.pdfImg);
                    $('.cv-upload-section-func').fadeIn();
                    $(".old-cv").text('');
                    $("#oldfile").val(fileName);
                }
                else if(fileType == 'doc' || fileType == 'docx'){
                    $(".media-body").find('.la.la-file-alt').removeClass('d-none');
                    $(".media-body").find('.la.la-file-pdf').addClass('d-none');
                    $(".media-body").find('.media.file-name-image').show();
                    $(".media-body").find(".cv-name-func").text(fileName);
                    $(".media-body").find('.cv-holder').find('img').attr('src',$this.documentImg);
                    $('.cv-upload-section-func').fadeIn();
                    $(".old-cv").text('');
                    $("#oldfile").val(fileName);
                }else{
                    $(".media-body").find('.media.file-name-image').hide();
                    $('.cv-upload-section-func').fadeOut();
                    
                }
                
        });
    },
    applyJobStepOne : function(){
        $(document).ready(function() {
            CKEDITOR.replace( 'cover_letter', {
                toolbar: [
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'ExportPdf', 'Preview', 'Print', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                                // Defines toolbar group without name.
                    '/',																					// Line break - next group will be placed in new line.
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ] },
                ],
                removeButtons: 'Source'
            });
        // $('.phone-edit').click( function() {
        //     $(".phone-edit-open").toggleClass("d-none");
        //     return false;
        // });
        // $('.location-edit').click( function() {
        //     $(".location-edit-open").toggleClass("d-none");
        //     return false;
        // });
        // $('.cv-upload').click( function() {
        //     $(".cv-upload-open").toggleClass("d-none");
        //     return false;
        // });
        
    });

}, 
applyJobStepOneStore: function(){
    let $this = this;
    $(document).on('click','.apply-step-one',function(){
        //alert(CKEDITOR.instances['cover_letter'].getData());
        var desc = CKEDITOR.instances['cover_letter'].getData( ).replace( /<[^>]*>/gi, '' ).length;
        if(desc > 2000){
            $('.descErr').css('display','block');
            $('.descErr').text($this.lanFilter(allMsgText.COVER_LETTER_SHOULD_NOT_GREATER_1000_WORDS));
            return false;
        }
           
        var form_profile_info = document.getElementById("step_one");
        var fd = new FormData(form_profile_info);
        fd.append('cover_letter',CKEDITOR.instances['cover_letter'].getData());
        //console.log($('#cover_letter').val());
        $.ajax({
                url: _BASE_URL+"/candidate/apply-job-store-info",
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
                    $this.showSuccessMsg(msg);
                    setTimeout(function(){ window.location.href = _BASE_URL+"/candidate/my-jobs"; }, 10000);
                  
                }else{
                    console.log('111');
                    $('#job_applied_id').val(response);
                    $('.discard_job_app_rmvb_1').remove();
                    var btnName = $this.lanFilter(allMsgText.DISCARD);
                    var html = '<button class="btn site-btn-color discard_job_app discard_job_app_rmvb_1" id="discard_job_app" type="button" data-id="'+response+'">'+btnName+'</button>';
                    $(".discard-aftr-1").after(html);
                    $(".discard-aftr-1").addClass("mr-2");
                    let msg = $this.lanFilter(allMsgText.THIS_JOB_SUCCESSFULLY_SAVED_AS_DRAFT);
                    $this.showSuccessMsg(msg);
                }
                }
            }).done(function() {
                    
        });
          										        				 
    });
},
chkFirstStepValidationForNext: function(){
    let $this = this;
    $(document).on('click','#nextbtn',function(){

   
     //   var desc = CKEDITOR.instances['cover_letter'].getData( ).replace( /<[^>]*>/gi, '' ).length;
        var desc =  CKEDITOR.instances['cover_letter'].document.getBody().getText().length;
        if(desc > 2000){
            $('.descErr').css('display','block');
            $('.descErr').text($this.lanFilter(allMsgText.COVER_LETTER_SHOULD_NOT_GREATER_1000_WORDS));
            return false;
        }else{
            $('#apply-job-company').css("display", "none");
            $('#next-specific-qus').css("display", "block");
        }
        										        				 
    });
    $(document).on('click','#nextbtn2',function(){
       
        //var desc = CKEDITOR.instances['cover_letter'].getData( ).replace( /<[^>]*>/gi, '' ).length;
        var desc =  CKEDITOR.instances['cover_letter'].document.getBody().getText().length;
        if(desc > 2000){
            $('.descErr').css('display','block');
            $('.descErr').text($this.lanFilter(allMsgText.COVER_LETTER_SHOULD_NOT_GREATER_1000_WORDS));
            return false;
        }else{
            $('#apply-job-company').css("display", "none");
            $('#next-specific-qus').css("display", "none");
            $('#next-interview-qus').css("display", "block");
        }
       										        				 
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
getState : function(){     
    let $this = this;   
   $(document).ready(function() {
       //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
       $( "#country" ).on( "change", function() {
           var countryId = $('#country').val();
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
                let stateSelectBox = '<option value=""> '+allMsgText.STATE+' *</option>';
                $.each(jsonStates, function(key, row) {	
                    stateSelectBox += '<option value="' + row.id+ '">' + row.name + '</option>';
                });
                $(".select-states-area").html(stateSelectBox);
               }
           }); 
       }); 
         
   });
}, 
getCity : function(){     
    let $this = this;   
   $(document).ready(function() {
       //UPDATE CITY DRPDOWN ON CHANGE OF STATE
    //    $( "#state" ).on( "change", function() {
    //        var stateId = $('#state').val();
           
    //        if(stateId == ''){
    //         stateId = 0;
    //        }
    //        $.ajax({
    //            method: "GET",
    //            url: _BASE_URL+"/candidate/get-states-city/"+stateId,
    //            dataType:'json',								                  
    //            headers: {
    //                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //            },
    //            success: function(jsonCity) {
    //             let stateSelectBox = '<option value=""> '+allMsgText.CITY+' *</option>';
    //             $.each(jsonCity, function(key, row) {	
    //                 stateSelectBox += '<option value="' + row.id+ '">' + row.name + '</option>';
    //             });
    //             $(".select-city-area").html(stateSelectBox);
    //            }
    //        }); 
    //    }); 
         
   });
}, 
applyJobStepTwoStore: function(){
    let $this = this;
    $(document).on('click','.apply-step-two',function(){
        
        var validator = $("#step_one").validate({
            rules: {
                answer_1: {
                    maxlength: 5000
                },
                answer_2: {
                    maxlength: 5000
                },
                answer_3: {
                    maxlength: 5000
                }
                       
            },
            messages: {
                answer_1:{
                    maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                },
                answer_2:{
                    maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                },
                answer_3:{
                    maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                }
                        
            }
        });
         if(validator.form()){
            var form_profile_info = document.getElementById("step_one");
            var fd = new FormData(form_profile_info);	
            fd.append('cover_letter',CKEDITOR.instances['cover_letter'].getData());
            $.ajax({
                    url: _BASE_URL+"/candidate/apply-job-store-specific-ans",
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
                            $this.showSuccessMsg(msg);
                            setTimeout(function(){ window.location.href = _BASE_URL+"/candidate/my-jobs"; }, 10000);
                            
                        }else{
                            $('#job_applied_id').val(response);
                            $('.discard_job_app_rmvb_2').remove();
                            var btnName = $this.lanFilter(allMsgText.DISCARD);
                            var html = '<button class="btn site-btn-color discard_job_app discard_job_app_rmvb_2" id="discard_job_app" type="button" data-id="'+response+'">'+btnName+'</button>';
                            $(".discard-aftr-2").after(html);
                            $(".discard-aftr-2").addClass("mr-2");
                            let msg = $this.lanFilter(allMsgText.THIS_JOB_SUCCESSFULLY_SAVED_AS_DRAFT);
                            $this.showSuccessMsg(msg);
                        }
                        

                        
                    }
                }).done(function() {
                        
            });
         }
        
            
    });
},
applyJob: function(){
    let $this = this;
    $(document).on('click','.apply-cls',function(){
        var desc = CKEDITOR.instances['cover_letter'].getData( ).replace( /<[^>]*>/gi, '' ).length;
        if(desc > 2000){
            $('.descErr').css('display','block');
            $('.descErr').text($this.lanFilter(allMsgText.COVER_LETTER_SHOULD_NOT_GREATER_1000_WORDS));
            return false;
        }
        var validator = $("#step_one").validate({
            rules: {
                answer_1: {
                    maxlength: 5000
                },
                answer_2: {
                    maxlength: 5000
                },
                answer_3: {
                    maxlength: 5000
                }
                       
            },
            messages: {
                answer_1:{
                    maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                },
                answer_2:{
                    maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                },
                answer_3:{
                    maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
                }
                        
            }
        });
        if(validator.form()){    
        var form_profile_info = document.getElementById("step_one");
        var fd = new FormData(form_profile_info);
        fd.append('cover_letter',CKEDITOR.instances['cover_letter'].getData());
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
                    setTimeout(function(){ window.location.href = _BASE_URL+"/candidate/my-jobs"; }, 10000);
                }
            }).done(function() {
                    
        });
        }
            
    });
},
uploadIntroVideo : async function(type){
    var $this = this;
    // if(typeof introVideoData == 'undefined'){
    // $('.upload-error-n-intro').text('Please select intro video').show();	  
    //       return false;
    // }
//  var $profileBtn = $(".upload-intro-video-func");
//  $profileBtn.text('Uploading...');
//  $this.freezPagePopupModal($profileBtn);
//  await sleep(2000);
try{

        var form_profile_info = document.getElementById("step_one");
        
        var fd = new FormData(form_profile_info);
        fd.append('cover_letter',CKEDITOR.instances['cover_letter'].getData());
        fd.append('file1',introVideoData1);
        fd.append('file2',introVideoData2);
        fd.append('file3',introVideoData3);
        fd.append('type',type);

       $.ajax({
                url: _BASE_URL+"/candidate/store-interview-video-answer",
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
                    let msg ='';
                    if(response.success == 0){
                        window.location.href = _BASE_URL+"/candidate/my-jobs";
                        msg = response.message;
                    }else{
                        //console.log(response.intro_info);
                        $('#job_applied_id').val(response.intro_info);
                        if(type == 1){
                            window.location.href = _BASE_URL+"/candidate/my-jobs";
                            msg = $this.lanFilter(allMsgText.JOB_APPLIED_SUCCESSFULLY);
                        }else{
                            $('.discard_job_app_rmvb_3').remove();
                            var btnName = $this.lanFilter(allMsgText.DISCARD);
                            var html = '<button class="btn site-btn-color discard_job_app enable-disable-cls discard_job_app_rmvb_3" id="discard_job_app" type="button" data-id="'+response.intro_info+'">'+btnName+'</button>';
                            $(".discard-aftr-3").after(html);
                            $(".discard-aftr-3").addClass("mr-2");
                            msg = $this.lanFilter(allMsgText.THIS_JOB_SUCCESSFULLY_SAVED_AS_DRAFT);
                        }
                        
                    }
                    $this.showSuccessMsg(msg);      
                }	
              });										        				 
      
 }catch(error){
      console.log('storeProfileDataAjax function :: '+error);
 }	
},
uploaRecordedIntroVideo : function(){
      let $this = this;
      $(document).on('click','.upload-intro-video-func',function(){
        
        var count = 0;
        var attach1 = $('#count-atteched-1').val();
        var attach2 = $('#count-atteched-2').val();
        var attach3 = $('#count-atteched-3').val();
         
        if((attach1 != undefined) && (attach1 > 0)){
          count++;
        }else if((validationCount1 != undefined) && (validationCount1 > 0)){
          count++;
        }
        
        if((attach2 != undefined) && (attach2 > 0)){
          count++;
        }else if((validationCount2 != undefined) && (validationCount2 > 0)){
          count++;
        }
        
        if((attach3 != undefined) && (attach3 > 0)){
          count++;
        }else if((validationCount3 != undefined) && (validationCount3 > 0)){
          count++;
        }

        var mandetory = '';
        // if(videoRequiredCount == 0){
        //     mandetory = $this.lanFilter(allMsgText.NONE_OF_QUESTION_ARE_MANDATORY);
        // }else if(totalVideo == videoRequiredCount){
        //     mandetory = $this.lanFilter(allMsgText.ALL_QUESTIONS_ARE_MANDATORY);
        // }else if(videoRequiredCount == 1){
        //     mandetory = $this.lanFilter(allMsgText.ANY_ONE_QUESTION_IS_MANDATORY);
        // }else if(videoRequiredCount == 2){
        //     mandetory = $this.lanFilter(allMsgText.ANY_TWO_QUESTION_MANDATORY);
        // } 
        if(mandatoryset == 0){
            mandetory = $this.lanFilter(allMsgText.NONE_OF_QUESTION_ARE_MANDATORY);
        }else if(mandatoryset == 1){
            mandetory = $this.lanFilter(allMsgText.ALL_QUESTIONS_ARE_MANDATORY);
        }else if(mandatoryset == 2){
            mandetory = $this.lanFilter(allMsgText.ANY_ONE_QUESTION_IS_MANDATORY);
        }else if(mandatoryset == 3){
            mandetory = $this.lanFilter(allMsgText.ANY_TWO_QUESTION_MANDATORY);
        }
        var type = $(this).attr("data-id");
        if((type == 1) && (count < videoRequiredCount)){
            $('.upload-error-n-intro').css('display','block');
            $('.upload-error-n-intro').css('color','red');
            setTimeout(function(){ 
              $('.upload-error-n-intro').text(mandetory).delay(3000).fadeOut(600);
            });
            return false;
        }else{
          $this.uploadIntroVideo(type);
        } 
            
      });
},
updateSelectedVideo : function(){
    let $this = this;
      $(document).on('click','.chk-video-cls',function(){
        var attemptId = $(this).attr('data-id');
        var videoNo = $(this).attr('data-no');
        var $that = $(this);
        console.log(videoNo);
        $.ajax({
            url: _BASE_URL+"/candidate/get-selected-video",
            data:{'attempt_id' : attemptId},
            method:'POST',
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                response = JSON.parse(response);
                // console.log(response);
                // console.log(response.location);
                var srcUrl = response.location;
                //console.log(srcUrl);
                $('.checked-video-cls-'+videoNo).attr('src',srcUrl);
               // $('.show_hode_'+videoNo).find("video").eq(1).addClass('vjs-hidden');
                $('.show_hode_'+videoNo).find("video").eq(1).parent().addClass('vjs-hidden');
                $('.show_hode_'+videoNo).find("#divVideo").css('display','block');
                $('.show_hode_'+videoNo).find("#divVideo video").css('display','block');
                $("#divVideo video")[videoNo].load();	
            }
        });
    });
},
discardJobDetails: function(){
    let $this = this;
    $(document).on('click','.discard_job_app',function(){
        var appliedId = $(this).attr('data-id');
        var text = $this.lanFilter(allMsgText.DO_YOU_REALLY_WANT_TO_DELETE_THIS_DRAFT_JOB);
        swal({
              title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
              text: text,
              buttons: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                      $.ajax({
                        url: _BASE_URL+"/candidate/apply-job-discard-info",
                        data:{'applied_id' : appliedId},
                        method:'POST',
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response){
                            console.log(response);
                        let msg = '';
                        if(response == 1){
                            msg = $this.lanFilter(allMsgText.YOU_HAVE_DISCARDED_YOUR_DRAFT_JOB_SUCCESSFULLY);
                            $this.showSuccessMsg(msg);
                            setTimeout(function(){ window.location.href = _BASE_URL+"/candidate/my-jobs"; }, 10000);
                            
                        }else{
                            $('#job_applied_id').val(appliedId);
                            let msg = $this.lanFilter(allMsgText.SORRY_SOMETHING_WENT_WRONG);
                            $this.showSuccessMsg(msg);
                        }
                        }
                    }).done(function() {
                            
                });
              } 
          });
        
    });
},
}

Post.init();

// Dynamically add-on fields

$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]',
        function(e) {
            
            e.preventDefault();
            // $(this).prev('input').val(null);
            if($('.btn-cross').length == 1){
           
                var $el = $('.btn-cross').prev('.wrap-input-container').find('.file-upload');
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
               
                $('.btn-cross').prev('.wrap-input-container').find('.custom-file-upload').removeClass('active').html('<i class="fa fa-cloud-upload"></i>click here to upload your cv');
             
    
                return false;
            }
            $(this).closest('.form-inline').remove();
            
            remove_button();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('label').html('<i class="fa fa-cloud-upload"></i> click here to upload document'); 
            new_field_group.find('label').removeClass('active');
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
            remove_button();
        }
    );
    remove_button();
    function remove_button()
    {
      var length = $( '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]' ).length;
      if(length == 1)
      {
        $( '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]' ).each(function( index ) {
          if(index == 0){
            $(this).prop('disabled', false);
          }
        });
    }
    else{
          $( '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]' ).each(function( index ) {
              $(this).prop('disabled', false);
          });
          
      }
    }
  });
  
  
  
  // file upload
  
  $(document).on('change', '.file-upload', function(){
    var i = $(this).prev('label').clone();
    var file = this.files[0].name;
    $(this).prev('label').text(file);
  });
  $(document).on('click', '#removeCV', function(){
    $(this).prev('input').val(null);
    $("#cv").val(null);
    $("#is_delete_cv").val(1);
    $(this).prev().prev('label').html('<i class="fa fa-cloud-upload"></i>click here to upload your cv');
    $(this).prev().prev('.custom-file-upload').removeClass('active');
  })
