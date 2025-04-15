const validePostImageType = ['jpeg','png','jpg'];
const validePostVideoType = ['mp4','mpeg','wmv','mpg'];
const validePostType = ['jpeg','png','jpg','mp4','mpeg','wmv','mpg'];
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }
const dashboardFunctions = {

                            init : function(){
                                // this.imageUploadInitialisation();
                                 this.creatPostValidation();
                                 this.PostDelete();
                                 this.CopyLink();
                                 this.ReportComment();
                                 this.ListComment();
                                 this.createImagePost();
                                 this.createVideoPost();
                                 this.flushModalPopup();
                                 this.PostComment();
                                 this.likePost();
                                 this.ReportPost();
                                 this.ReportCompany();
                                 this.SharePost();
                                 this.CommentDelete();
                                 this.createAnyPost();
                                 this.showMessageFromLocalStoreage();
                                
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
                            imageUploadInitialisation : function()
                            {      
                                let $this = this;          
                                $(document).on('change','#post_image_upload',function(event){               
                                        let fileSelected = this.files[0];                                        
                                        if($this.isValidPostImage(fileSelected.name)){
                                            $('.post_image_upload_div').find('.error-text').hide();
                                        }else{
                                            $('.post_image_upload_div').find('.error-text').show();
                                            $('.post_image_upload_div').find('.error-text').text($this.lanFilter(allMsgText.ONLY_JPEG_PNG_IMAGE_ALLOWED));
                                        }
                                });
                                $(document).on('change','#post_video_upload',function(event){               
                                        let fileSelected = this.files[0];                                        
                                        if($this.isValidPostVideo(fileSelected.name)){
                                            $('.post_image_upload_div').find('.error-text').hide();
                                        }else{
                                            $('.post_image_upload_div').find('.error-text').show();
                                            $('.post_image_upload_div').find('.error-text').text($this.lanFilter(allMsgText.ONLY_MP4_MPEG_WMV_VIDEO_ALLOWED));
                                        }
                                });
                                $(document).on('click','.post_image_upload_area',function(event){                                                                                             
                                       $('#post_image_upload').trigger('click');
                                });
                                $(document).on('click','.post_video_upload_area',function(event){                                                                                             
                                       $('#post_video_upload').trigger('click');
                                });
                            },
                            isValidPostImage : function(fileName){                                            
                                                let extension = fileName.split('.');
                                                extension = extension[(extension.length - 1)];
                                                extension = extension.toLowerCase();                                                                                                            
                                                if(validePostImageType.includes(extension)){//if extension found
                                                   return true;
                                                }else{
                                                    
                                                   return false;
                                                }
                            },
                             isValidPostVideo : function(fileName){                                            
                                                let extension = fileName.split('.');
                                                extension = extension[(extension.length - 1)];
                                                extension = extension.toLowerCase();                                                                                                            
                                                if(validePostVideoType.includes(extension)){//if extension found
                                                   return true;
                                                }else{
                                                   return false;
                                                }
                            },
                            isValidPost : function(fileName){                                            
                                let extension = fileName.split('.');
                                extension = extension[(extension.length - 1)];
                                extension = extension.toLowerCase();                                                                                                            
                                if(validePostType.includes(extension)){//if extension found
                                   return true;
                                }else{
                                   return false;
                                }
                            },
                            creatPostValidation : function()
                            {        
                                $this = this;
                                $(document).ready(function() {
                                   $("#text_post").validate({
                                        rules: {
                                            description: {
                                                required: true,
                                                maxlength: 5000
                                            }
                                        },
                                        messages:{
                                            description:{
                                                required: $this.lanFilter(allMsgText.PLEASE_WRITE_SOMETHING_TO_SHARE),
                                                maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                            }
                                        },
                                        submitHandler : function(form){  
                                                let submtbtn = $('#text_post').find('.btn.site-btn-color');                                                                                   
                                                $this.freezPagePopupModal(submtbtn,'Posting...');                                                                 
                                                form.submit();
                                        }
                                    });
                                      
                                });
                            },
                            showSuccessMsg : function(msg){
                                                let msgBox = $(".alert-holder-success");
                                                msgBox.addClass('success-block');
                                                msgBox.find('.alert-holder').html(msg);
                                                setTimeout(function(){ msgBox.removeClass('success-block')},20000);
                            },
                            PostDelete : function()
                            {
                            var $this = this;
                            $(document).on('click','.post-remove-data',function(){
                                var postId = $(this).attr("data-id");                                
                                var userType = $('#user').val();
                                if(userType == 2){
                                    var $url = _BASE_URL+"/candidate/delete-user-post";
                                }else if(userType == 3){
                                    var $url = _BASE_URL+"/company/delete-user-post";
                                }
                                swal({
                                    title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                    text: $this.lanFilter(allMsgText.DO_YOU_REALLY_WANT_TO_DELETE_YOUR_POST),
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                    })
                                    .then((willDelete) => {
                                    if (willDelete) {
                                        $.ajax({
                                        url: $url,
                                        data:{'id': postId},
                                        method:'POST',
                                        headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                        success: function(response){
                                                $("#rmv-post-"+postId).fadeOut(function(){
                                                    $(this).remove();
                                                });
                                                
                                                let msg = $this.lanFilter(allMsgText.YOUR_POST_IS_REMOVED_SUCCESSFULLY);
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

                            freezPagePopupModal: function($button,text = false){
                                                   //$('.custom-modal').addClass('freez_page');
                                                   $('body').css('pointer-events','none');
                                                   document.body.style.cursor = "progress";
                                                   if(text != false){
                                                      $button.text(text);  
                                                   }
                                                   $button.prop('disabled', true);
                            },
                            removeFreezPagePopupModal: function($button,text=false){
                                      $('body').css('pointer-events','');
                                       document.body.style.cursor = ""; // so it goes back to previous CSS defined value 
                                       if(text != false){
                                                      $button.text(text);  
                                        }
                                       $button.prop('disabled', false);
                            },
                            ListComment : function (){
                                var $this = this;
                                $(document).on('click','#comment-post-modal-id',function(){
                                    $('.comment-list-not-found').css('display','none');
                                    $('#comment-error').css('display','none');
                                    //var $this = this;
                                    $('#commentListApp').html('');
                                    var postId = $(this).attr("data-id");
                                    var userType = $('#user').val();
                                    var userId = $('#chkrpt').val();
                                    
                                    if(userType == 2){
                                        var typ = 'candidate';
                                        var url = _BASE_URL+"/candidate/list-user-post-comment";
                                    }else if(userType == 3){
                                        var typ = 'company';
                                        var url = _BASE_URL+"/company/list-user-post-comment";
                                    }
                                    
                                    $.ajax({
                                        url: url,
                                        data:{'id': postId},
                                        method:'GET',
                                        dataType:'json',
                                        headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                        success: function(response){
                                            //console.log(response.length);
                                            //var $this = this;
                                            $('#comment-post-modal').find('#post_id').val(postId);
                                            $('#comment-post-modal').modal('show');
                                            $("#no-data").css('display','block');
                                            $('.comment-list-not-found').css('display','none');
                                            var flagfor = 0;
                                            
                                            if(response.length > 0){
                                                //console.log(response.length);
                                                jQuery.each(response, function(i, val) {
                                                    
                                                    var reprtUser = 0;
                                                    if(val.reported.length > 0){
                                                        jQuery.each(val.reported, function(i, user) {
                                                            var userIds = user.user_id;
                                                            if(userIds == userId){
                                                                reprtUser++;
                                                            }
                                                        });
                                                    }
                                                    // console.log(reprtUser);
                                                    // console.log(userId);
                                                    // console.log(reprtUser.indexOf(userId));
                                                    if((val.reported.length == 0) || (reprtUser == 0)){
                                                        flagfor++;
                                                        var commentId = val.id;
                                                        var slug = val.active_user.slug;
                                                        if(val.active_user.user_type == 2){
                                                            var name = val.active_user.first_name;
                                                        }else if(val.active_user.user_type == 3){
                                                            var name = val.active_user.company_name;
                                                        }

                                                        var position = '';
                                                        var positionAt = '';
                                                        if(val.active_user.current_company != null){
                                                            position = val.active_user.current_company.title;
                                                        }
                                                        
                                                        if(val.active_user.current_company != null){
                                                            var current_company = val.active_user.current_company.company_name;
                                                        }else{
                                                            var current_company = '';
                                                        }
                                                        var comment = val.comment;
                                                        var profileImg = val.active_user.profile_image;
                                                        if(profileImg != null){
                                                            var profileImgLocation = val.active_user.profile_image.location;
                                                        }else{
                                                            var profileImgLocation = '';
                                                        }
                                                        if(position != ''){
                                                            positionAt = 'at';
                                                        }
                                                        var html = '';
                                                        var reportHtml = '';
                                                        if(val.active_user.id != userId){
                                                            reportHtml = '<div class="dropdown msg-dropdown"> <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i> </button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> <a class="dropdown-item" href="#" data-toggle="modal" id="report-modal-id" data-id="'+commentId+'">'+allMsgText.REPORT+'</a></div></div>';
                                                        }else{
                                                            reportHtml = '<div class="dropdown msg-dropdown"> <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i> </button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> <a class="dropdown-item comment-remove-data" href="javascript:void(0);" id="comment-delete-id" data-id="'+commentId+'">Delete</a></div></div>';
                                                        }
                                                        html = '<div class="comment-list-inner" id="rmv-cmnt-'+commentId+'"><div class="media"><div class="user-profile"> <a href="'+_BASE_URL+'/'+typ+'/profile/'+slug+'">' ;
                                                        if(profileImg != null){ html += '<img src="'+_BASE_URL+'/'+profileImgLocation+'" alt="">' ;}
                                                        else{ html += '<img src="'+_BASE_URL+'/frontend/images/user-pro-img-demo.png" alt="">' ;} 
                                                        html += '</a></div><div class="media-body"><h5 class="post-name">'+name+'</h5><p class="post-location">'+position+' '+positionAt+' '+current_company+'</p></div>'+reportHtml+'</div><div class="post-body"><p>'+comment+'</p></div></div>';
                                                        $('#commentListApp').append(html);
                                                    }
                                                    
                                                });

                                                if(flagfor == 0){
                                                    $("#no-data").css('display','none');
                                                    $('.comment-list-not-found').css('display','block');
                                                    $('.comment-list-not-found').html($this.lanFilter(allMsgText.NO_COMMENT_FOUND));
                                                }
                                            }else{
                                                $("#no-data").css('display','none');
                                                $('.comment-list-not-found').css('display','block');
                                                $('.comment-list-not-found').html($this.lanFilter(allMsgText.NO_COMMENT_FOUND));
                                            }
                                                
                                        },
                                        error: function(){
                                                alert("Something happend wrong.Please try again");
                                                
                                        }	
                                    })									
                                
                                });
                            }, 
                            CopyLink : function() 
                            {
                                var $this = this;
                                $(document).on('click','#copyButton',function(e){
                                    e.preventDefault();
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

                            ReportComment : function(){
                                $(document).on('click','#report-modal-id',function(){
                                    var $this = this;
                                    var commentId = $($this).attr("data-id");
                                    $('#comment-post-modal').modal('hide');
                                    $('#report-modal-open').modal('show');
                                    $('#report-modal-open').find('#comment_id').val(commentId);
                                });
                                try{
                                    var $this = this;
                                    $(document).ready(function(){
                                            $("#report").validate({
                                                rules: {
                                                    comment: { 
                                                        required: true ,
                                                        maxlength: 5000
                                                    },			
                                                },
                                                messages: {
                                                    comment: {
                                                        required: $this.lanFilter(allMsgText.PLEASE_ENTER_A_COMMENT),
                                                        maxlength: $this.lanFilter(allMsgText.MAXIMUM_CHARACTER_LENGTH_LESS_THAN5000)

                                                    }

                                                },
                                                submitHandler : function(form){	
                                                    $this.submitReport(); 
                                                    return false;  
                                                }
                                            });
                                    });
                                }catch(error){
                                    console.log('Validate Candidate Profile info :: '+error);
                                }
                            },
                            submitReport : async function(){
                                var $this = this;
                                var $profileBtn = $("#report-modal-open").find(".post-comment-report-cls");
                                $profileBtn.text($this.lanFilter(allMsgText.SUBMITTING)+'...');
                                $this.freezPagePopupModal($profileBtn);
                                await sleep(2000);
                                var userType = $('#user').val();
                                if(userType == 2){
                                    var url = _BASE_URL+"/candidate/report-comment";
                                }else if(userType == 3){
                                    var url = _BASE_URL+"/company/report-comment";
                                }												   					
                                var report = document.getElementById("report");   
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
                                                $profileBtn.text($this.lanFilter(allMsgText.SUBMIT));
                                                $this.removeFreezPagePopupModal($profileBtn);
                                                $("#report-modal-open").modal('hide');
                                                let msg = $this.lanFilter(allMsgText.YOUR_REPORT_COMMENT_SUBMITTED_SUCCESSFULLY);
                                                $this.showSuccessMsg(msg);
                                                
                                        },
                                        error: function(){
                                                alert("Something happend wrong.Please try again");
                                                
                                        }	
                                    }).done(function() {
                                        //$("#report-modal-open").modal('hide');
                                        location.reload(true);         
                                    });	

                            },    
                            createImagePost : function()
                            {        
                                                $this = this;
                                                var url = _BASE_URL+'/store-image-post';
                                                $(document).ready(function() {
                                                    
                                                    Dropzone.options.postImageUpload = {
                                                              paramName: "file", // The name that will be used to transfer the file
                                                              maxFilesize: 2, // MB
                                                              maxFiles: 1,
                                                              clickable: true, 
                                                              addRemoveLinks: true, 
                                                              acceptedFiles: ".jpeg,.jpg,.png",
                                                              autoProcessQueue: false,                                           
                                                              thumbnailWidth:null, 
                                                              thumbnailHeight:null,                                         
                                                              dictDefaultMessage: '<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>',
                                                              url: url, 
                                                              headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              },  
                                                              init: function() {
                                                                  
                                                                   this.on('removedfile', function(file) {
                                                                            $('#image_post').find('#file').val('');                                                  
                                                                   });


                                                             },                                 
                                                              accept: function(file, done) {
                                                                         let fileReader = new FileReader();
                                                                         fileReader.readAsDataURL(file);
                                                                         fileReader.onloadend = function() {
                                                                            let content = fileReader.result;                                                    
                                                                            $('#image_post').find('#file').val(content);
                                                                            
                                                                         }
                                                                        if (file.name == "justinbieber.jpg") {
                                                                          done("Naha, you don't.");
                                                                        }
                                                                        else { done(); }
                                                              },
                                                               complete: function(file) {
                                                                      //console.log('completed and file removed');
                                                                      this.removeFile(file);
                                                                  },
                                                              error: function(file, response) {  // and then can you have your error callback

                                                                              this.removeFile(file);
                                                                              $("#postImageUpload").html('<div class="dz-default dz-message"><span>'+allMsgText.DROP_FILE_HERE+'</span></div>');   
                                                                              let isValidImg = $this.isValidPostImage(file.name);                                                 
                                                                              if(!isValidImg){
                                                                                  swal($this.lanFilter(allMsgText.POST_AN_IMAGE),$this.lanFilter(allMsgText.ONLY_JPEG_PNG_FILE_ARE_ALLOWED));
                                                                              }else{
                                                                                  swal($this.lanFilter(allMsgText.POST_AN_IMAGE),response);
                                                                              }                                                              
                                                                              
                                                               },

                                                               transformFile: function(file, done) { 
                                                                                 
                                                                                 
                                                                }
                                                    };
                                                   $("#image_post").validate({
                                                        rules: {
                                                            title: {
                                                                required: true,
                                                                maxlength: 5000
                                                            }
                                                        },
                                                        messages:{
                                                            title:{
                                                                required: $this.lanFilter(allMsgText.PLEASE_WRITE_SOMETHING_TO_SHARE),
                                                                maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                                            }
                                                        },
                                                        submitHandler : function(form){  
                                                                let submtbtn = $('#image_post').find('.btn.site-btn-color');
                                                                let fileSelected = $('#image_post').find('#file').val();
                                                                if(fileSelected == ''){
                                                                    swal($this.lanFilter(allMsgText.POST_AN_IMAGE),$this.lanFilter(allMsgText.PLEASE_SELECT_AN_IMAGE)); 
                                                                    return false; 
                                                                }                                                                                                                                 
                                                                $this.freezPagePopupModal(submtbtn,$this.lanFilter(allMsgText.POSTING)+'...');                                                                 
                                                                form.submit();
                                                        }
                                                    });
                                                     
                                                });
                            }, 
                             createVideoPost : function()
                            {        
                                                $this = this;
                                                var url = _BASE_URL+'/store-image-post';
                                               
                                                $(document).ready(function() {

                                                    Dropzone.options.postVideoUpload = {
                                                              paramName: "file", // The name that will be used to transfer the file
                                                              maxFilesize: 20, // MB
                                                              maxFiles: 1,
                                                              clickable: true, 
                                                              addRemoveLinks: true, 
                                                              acceptedFiles: ".mp4,.mpeg,.wmv,.mpg",
                                                              autoProcessQueue: false,                                           
                                                              thumbnailWidth:null, 
                                                              thumbnailHeight:null,                                         
                                                              dictDefaultMessage: '<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>',
                                                              url: url, 
                                                              headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              },  
                                                              init: function() {
                                                                  
                                                                   this.on('removedfile', function(file) {
                                                                            $('#video_post').find('#file').val('');                                                  
                                                                            $("#postVideoUpload").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_HERE)+'</span></div>');   
                                                                   });
                                                                   this.on('addedfile', function(file) {
                                                                        var fileURL = URL.createObjectURL(file);                                                                        
                                                                        $("#postVideoUpload").find('.dz-default.dz-message').html('<video id="preview" controls autoplay></video>');   
                                                                        $("#postVideoUpload").find('video#preview').attr('src',fileURL);
                                                                   });
                                                                    

                                                             },                                 
                                                              accept: function(file, done) {

                                                                         let fileReader = new FileReader();
                                                                         fileReader.readAsDataURL(file);
                                                                         fileReader.onloadend = function() {
                                                                            let content = fileReader.result;  
                                                                                                                          
                                                                            $('#video_post').find('#file').val(content);
                                                                            
                                                                         }
                                                                        if (file.name == "justinbieber.jpg") {
                                                                          done("Naha, you don't.");
                                                                        }
                                                                        else { done(); }
                                                              },
                                                               complete: function(file) {                                                                      
                                                                      this.removeFile(file);
                                                                },
                                                              error: function(file, response) {  // and then can you have your error callback
                                                                              $("#postVideoUpload").html('<div class="dz-default dz-message"><span>'+allMsgText.DROP_FILE_HERE+'</span></div>');   
                                                                              let isValidImg = $this.isValidPostVideo(file.name);                                                 
                                                                              if(!isValidImg){
                                                                                  swal($this.lanFilter(allMsgText.POST_A_VIDEO),$this.lanFilter(allMsgText.ONLY_MP4_MPEG_WMV_VIDEO_ALLOWED));
                                                                              }else{
                                                                                  swal($this.lanFilter(allMsgText.POST_A_VIDEO),response);
                                                                              }                                                              
                                                                              
                                                               },

                                                               transformFile: function(file, done) { 
                                                                                 
                                                                                 
                                                                }
                                                    };
                                                   $("#video_post").validate({
                                                        rules: {
                                                            title: {
                                                                required: true,
                                                                maxlength: 5000
                                                            }
                                                        },
                                                        messages:{
                                                            title:{
                                                                required: $this.lanFilter(allMsgText.PLEASE_WRITE_SOMETHING_TO_SHARE),
                                                                maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                                            }
                                                        },
                                                        submitHandler : function(form){  
                                                                let submtbtn = $('#video_post').find('.btn.site-btn-color');
                                                                let fileSelected = $('#video_post').find('#file').val();
                                                                if(fileSelected == ''){
                                                                    swal($this.lanFilter(allMsgText.POST_A_VIDEO),$this.lanFilter(allMsgText.PLEASE_SELECT_A_VIDEO)); 
                                                                    return false; 
                                                                }                                                                                                                                 
                                                                $this.freezPagePopupModal(submtbtn,$this.lanFilter(allMsgText.POSTING)+'...');                                                                 
                                                                form.submit();
                                                        }
                                                    });
                                                     
                                                });
                            },   

                            createAnyPost : function()
                            {        
                                                $this = this;
                                                var url = _BASE_URL+'/store-any-post';
                                               
                                                $(document).ready(function() {

                                                    Dropzone.options.postVideoUpload = {
                                                              paramName: "file", // The name that will be used to transfer the file
                                                              maxFilesize: 20, // MB
                                                              maxFiles: 1,
                                                              clickable: true, 
                                                              addRemoveLinks: true, 
                                                              acceptedFiles: ".jpeg,.jpg,.png,.mp4,.mpeg,.wmv,.mpg",
                                                              autoProcessQueue: false,                                           
                                                              thumbnailWidth:null, 
                                                              thumbnailHeight:null,                                         
                                                              dictDefaultMessage: '<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_OR_VIDEO_HERE)+'</span></div>',
                                                              url: url, 
                                                              headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              },  
                                                              init: function() {
                                                                  
                                                                   this.on('removedfile', function(file) {
                                                                            $('#any_post').find('#file').val('');                                                  
                                                                            $("#postVideoUpload").html('<div class="dz-default dz-message"><span>'+$this.lanFilter(allMsgText.DROP_FILE_OR_VIDEO_HERE)+'</span></div>');   
                                                                   });
                                                                   this.on('addedfile', function(file) {
                                                                        var fileURL = URL.createObjectURL(file);                                                                        
                                                                        $("#postVideoUpload").find('.dz-default.dz-message').html('<video id="preview" controls autoplay></video>');   
                                                                        $("#postVideoUpload").find('video#preview').attr('src',fileURL);
                                                                   });
                                                                    

                                                             },                                 
                                                              accept: function(file, done) {

                                                                         let fileReader = new FileReader();
                                                                         fileReader.readAsDataURL(file);
                                                                         fileReader.onloadend = function() {
                                                                            let content = fileReader.result;  
                                                                                                                          
                                                                            $('#any_post').find('#file').val(content);
                                                                            
                                                                         }
                                                                        if (file.name == "justinbieber.jpg") {
                                                                          done("Naha, you don't.");
                                                                        }
                                                                        else { done(); }
                                                              },
                                                               complete: function(file) {                                                                      
                                                                      this.removeFile(file);
                                                                },
                                                              error: function(file, response) {  // and then can you have your error callback
                                                                console.log(response);
                                                                              $("#postVideoUpload").html('<div class="dz-default dz-message"><span>'+allMsgText.DROP_FILE_HERE+'</span></div>');   
                                                                              let isValidImg = $this.isValidPost(file.name);                                                 
                                                                              if(!isValidImg){
                                                                                  swal($this.lanFilter(allMsgText.POST_A_IMAGE_OR_VIDEO),$this.lanFilter(allMsgText.FILE_TYPE_NOT_ALLOWED));
                                                                              }else{
                                                                                  swal($this.lanFilter(allMsgText.POST_A_IMAGE_OR_VIDEO),response);
                                                                              }                                                              
                                                                              
                                                               },

                                                               transformFile: function(file, done) { 
                                                                                 
                                                                                 
                                                                }
                                                    };
                                                   $("#any_post").validate({
                                                        rules: {
                                                            title: {
                                                                required: true,
                                                                maxlength: 5000
                                                            }
                                                        },
                                                        messages:{
                                                            title:{
                                                                required: $this.lanFilter(allMsgText.PLEASE_WRITE_SOMETHING_TO_SHARE),
                                                                maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                                            }
                                                        },
                                                        submitHandler : function(form){  
                                                                let submtbtn = $('#any_post').find('.btn.site-btn-color');
                                                                let fileSelected = $('#any_post').find('#file').val();
                                                                // if(fileSelected == ''){
                                                                //     swal($this.lanFilter(allMsgText.POST_A_VIDEO),$this.lanFilter(allMsgText.PLEASE_SELECT_A_VIDEO)); 
                                                                //     return false; 
                                                                // }                                                                                                                                 
                                                                $this.freezPagePopupModal(submtbtn,$this.lanFilter(allMsgText.POSTING)+'...');                                                                 
                                                                form.submit();
                                                        }
                                                    });
                                                     
                                                });
                            },

                            flushModalPopup : function(){
                                                
                                                $(document).on('click','.create-post',function(){
                                                        $("#description").val('');
                                                        $(".post-title-data").each(function(index,element){
                                                                $(this).val('');
                                                        });
                                                });
                            },
                            PostComment : function(){
                                try{
                                    var $this = this;
                                    $(document).ready(function(){
                                            $("#post_comment").validate({
                                                rules: {
                                                    comment: { 
                                                        required: true ,
                                                        maxlength: 5000
                                                    },			
                                                },
                                                messages: {
                                                    comment: {
                                                        required: $this.lanFilter(allMsgText.PLEASE_ENTER_A_COMMENT),
                                                        maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                                    }

                                                },
                                                submitHandler : function(form){	
                                                    $this.submitPostComment(); 
                                                    return false;  
                                                }
                                            });
                                    });
                                }catch(error){
                                    console.log('Validate Candidate Profile info :: '+error);
                                }
                            }, 
                            submitPostComment : function(){
                                var $this = this;
                                var url = _BASE_URL+"/post-comment";
                                var comment = document.getElementById("post_comment");   
                                var fd = new FormData(comment);
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
                                                $("#comment-post-modal").modal('hide');
                                                $("#post_comment").trigger("reset");
                                                let msg = $this.lanFilter(allMsgText.YOUR_COMMENT_SUBMITTED_SUCCESSFULLY);
                                                $this.showSuccessMsg(msg);
                                                localStorage.setItem("message_local", "submit_comment");
                                        },
                                        error: function(){
                                                alert("Something happend wrong.Please try again");
                                                
                                        }	
                                    }).done(function() {
                                        //$("#comment-post-modal").modal('hide');
                                        location.reload(true);           
                                    });	

                            },
                            likePost : function(){
                                $(document).on('click','#like-post-id',function(event){  
                                var $this = this;
                                var postId = $($this).attr("data-id");
                                var total = $($this).attr("data-like");
                                var url = _BASE_URL+"/post-like";
                                $.ajax({
                                        url: url,
                                        data:{'post_id' : postId,'like' : total},
                                        method:'POST',
                                        dataType:'json',
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function(response){
                                            // console.log(postId);
                                            // console.log(total);
                                            // console.log(response);
                                           $('#total-like-'+postId).html(response);
                                           $('.like-post-'+postId).attr('data-like', response);
                                           if(response < total){
                                            $('.like-post-'+postId).removeClass('addlike');
                                           }else{
                                            $('.like-post-'+postId).addClass('addlike');
                                           }
                                                
                                        },
                                        error: function(){
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
                                    $('#post_id').val(postId);
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
                                                        maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
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
                            submitReportPost : async function(){
                                var $this = this;
                                var $profileBtn = $("#report-modal").find(".report-post-cls");
                                $profileBtn.text($this.lanFilter(allMsgText.SUBMITTING)+'...');
                                $this.freezPagePopupModal($profileBtn);
                                await sleep(2000);
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
                                                $profileBtn.text($this.lanFilter(allMsgText.SUBMIT));
                                                $this.removeFreezPagePopupModal($profileBtn);
                                                let msg = $this.lanFilter(allMsgText.THANK_YOU_FOR_REPORTING_TO_US);
                                                $this.showSuccessMsg(msg);
                                                localStorage.setItem("message_local", "report_post");
                                        },
                                        error: function(){
                                                alert("Something happend wrong.Please try again");
                                                
                                        }	
                                    }).done(function() {
                                        $("#report-modal").modal('hide');
                                       location.reload();             
                                    });	

                            }, 
                            ReportCompany : function(){
                                $(document).on('click','#report-company-id',function(){
                                    var $this = this;
                                    var companyId = $($this).attr("data-id");
                                    $('#report-company-modal').modal('show');
                                    $('#company_id').val(companyId);
                                });
                                try{
                                    var $this = this;
                                    $(document).ready(function(){
                                            $("#report_company").validate({
                                                rules: {
                                                    comment: { 
                                                        required: true ,
                                                        maxlength: 5000
                                                    },			
                                                },
                                                messages: {
                                                    comment: {
                                                        required:  $this.lanFilter(allMsgText.PLEASE_ENTER_A_COMMENT),
                                                        maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER),
                                                    }

                                                },
                                                submitHandler : function(form){	
                                                    $this.submitReportCompany(); 
                                                    return false;  
                                                }
                                            });
                                    });
                                }catch(error){
                                    console.log('Validate Candidate Profile info :: '+error);
                                }
                            },
                            submitReportCompany : async function(){
                                var $this = this;
                                var $profileBtn = $("#report-company-modal").find(".report-company-cls");
                                $profileBtn.text($this.lanFilter(allMsgText.SUBMITTING)+'...');
                                $this.freezPagePopupModal($profileBtn);
                                await sleep(2000);
                                var url = _BASE_URL+"/candidate/report-company";										   					
                                var report = document.getElementById("report_company");   
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
                                                $profileBtn.text($this.lanFilter(allMsgText.SUBMIT));
                                                $this.removeFreezPagePopupModal($profileBtn);
                                                $("#report-company-modal").modal('hide');
                                                let msg = $this.lanFilter(allMsgText.THANK_YOU_FOR_REPORTING_TO_US);
                                                $this.showSuccessMsg(msg);
                                                localStorage.setItem("message_local", "report_company");
                                        },
                                        error: function(){
                                                alert("Something happend wrong.Please try again");
                                                
                                        }	
                                    }).done(function() {
                                       // $("#report-modal-open").modal('hide');
                                       location.reload();             
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
                                                var nodata = '<div class="post-block mb-0"><i class="fa fa-lock fa-lg" aria-hidden="true" ></i><h6 class="total-sub-title">'+$this.lanFilter(allMsgText.POST_NOT_AVAILABLE)+'</h6><p class="mb-0">'+$this.lanFilter(allMsgText.POST_DELETED_TEXT)+'</p></div>';
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
                            CommentDelete : function()
                            {
                            var $this = this;
                            $(document).on('click','.comment-remove-data',function(){
                                var commentId = $(this).attr("data-id");                                
                                var userType = $('#user').val();
                                if(userType == 2){
                                    var $url = _BASE_URL+"/candidate/delete-user-comment";
                                }else if(userType == 3){
                                    var $url = _BASE_URL+"/company/delete-user-comment";
                                }
                                swal({
                                    title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                    text: $this.lanFilter(allMsgText.DO_YOU_REALLY_WANT_TO_DELETE_YOUR_COMMENT),
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                    })
                                    .then((willDelete) => {
                                    if (willDelete) {
                                        $.ajax({
                                        url: $url,
                                        data:{'id': commentId},
                                        method:'POST',
                                        headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                        success: function(response){
                                                $("#rmv-cmnt-"+commentId).fadeOut(function(){
                                                    $(this).remove();
                                                });
                                                $('#comment-post-modal').modal('hide');
                                                //let msg = $this.lanFilter(allMsgText.YOUR_COMMENT_IS_REMOVED_SUCCESSFULLY);
                                                let msg = $this.lanFilter(allMsgText.YOUR_COMMENT_REMOVED_SUCCESSFULLY);
                                                $this.showSuccessMsg(msg);
                                                location.reload();  
                                        },
                                        error: function(){
                                                alert("Something happend wrong.Please try again");
                                                
                                        }	
                                        })
                                    }
                                    });										
                                
                                });
                            },
                            showMessageFromLocalStoreage : function(){
                                                            var $this = this;
                                                            var message_local = localStorage.getItem("message_local");
                                                            switch(message_local){
                                                                    case 'report_company' :
                                                                            let report_company = $this.lanFilter(allMsgText.THANK_YOU_FOR_REPORTING_TO_US);
                                                                            $this.showSuccessMsg(report_company);
                                                                            localStorage.removeItem("message_local");    
                                                                    break;
                                                                    case 'submit_comment' :
                                                                            let submit_comment = $this.lanFilter(allMsgText.YOUR_COMMENT_SUBMITTED_SUCCESSFULLY);
                                                                            $this.showSuccessMsg(submit_comment);
                                                                            localStorage.removeItem("message_local");    
                                                                    break;
                                                                     case 'report_post' :
                                                                            let report_post = $this.lanFilter(allMsgText.THANK_YOU_FOR_REPORTING_TO_US);
                                                                            $this.showSuccessMsg(report_post);
                                                                            localStorage.removeItem("message_local");    

                                                                    break;
                                                                    default :

                                                            }
                            }
};

dashboardFunctions.init();
  