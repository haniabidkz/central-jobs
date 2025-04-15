const validePostImageType = ['jpeg','png','jpg'];
const validePostVideoType = ['mp4','mpeg','wmv'];

const messagesFunctions = {

                            init : function(){
                                    this.sendMsg();
                                    this.blockUser();
                                    this.deleteChatHistory();
                                    this.imageFileUpload();
                                    this.uploadPhoto();
                                    this.uploadFile();
                                    this.deleteSingleMessage();
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
                            sendMsg : function(){
                                         let $this = this;     
                                         $(document).ready(function() {
                                               $("#msg-sender").validate({
                                                    rules: {
                                                        message: {
                                                            required: true,
                                                            maxlength: 5000
                                                        },
                                                    },
                                                    messages:{
                                                        message :{
                                                                required : $this.lanFilter(allMsgText.PLEASE_ENTER_YOUR_MESSAGE),
                                                                maxlength: $this.lanFilter(allMsgText.YOUR_MESSAGE_SHOULD_LESS_5000CHAR)
                                                        }
                                                    },
                                                    
                                                    
                                                    submitHandler : function(form){  
                                                            let submtbtn = $('#msg-sender').find('.msg-send');                                                                                   
                                                            $this.freezPagePopupModal(submtbtn,'...');                                                                 
                                                            form.submit();
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
                            blockUser : function(){
                                var $this = this;        
                                $(document).on('click','.block-contact',function(){
                                              var messageId = $(this).attr("data-id"); 
                                              var action = $(this).attr("data-action"); 
                                              alert_message = $this.lanFilter(allMsgText.DO_YOU_WANT_TO_UNBLOCK_THIS_CONTACT); 
                                              if(action == 'block'){
                                                  alert_message = $this.lanFilter(allMsgText.DO_YOU_WANT_TO_BLOCK_THIS_CONTACT);
                                              }                      
                                        try{
                                            swal({
                                                    title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                                    text: alert_message,
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: true,
                                            })
                                            .then((willDelete) => {
                                                  if (willDelete) {
                                                       
                                                        $.ajax({
                                                                  url: _BASE_URL+"/block-message-contact",
                                                                  data:{'message_id':messageId},
                                                                  method:'POST',
                                                                  dataType:'json',
                                                                  headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                  },
                                                                  success: function(response){
                                                                    if(response.user_type == '3'){//company
                                                                          window.location = _BASE_URL+'/company/message/'+response.user_id;
                                                                    }else{
                                                                          window.location = _BASE_URL+'/candidate/message/'+response.user_id;
                                                                    }
                                                                           
                                                                   let submtbtn = $('#msg-sender').find('.msg-send');                                                                                   
                                                                   $this.freezPagePopupModal(submtbtn,'...'); 
                                                               },
                                                                  error: function(){
                                                                              alert("Something happend wrong.Please try again");
                                                                  } 
                                                        });    
                                                                                                                                  
                                                  }
                                            }); 
                                                                                               
                                        
                                   }catch(error){
                                        console.log('storeProfileDataAjax function :: '+error);
                                   }
                                });
                            },
                            deleteChatHistory : function(){
                                var $this = this;        
                                $(document).on('click','.delete-contact',function(){
                                              var messageId = $(this).attr("data-id"); 
                                                                      
                                        try{
                                            swal({
                                              title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                              text: $this.lanFilter(allMsgText.DO_YOU_WANT_TO_DELETE_THIS_CHAT_HISTORY),
                                              icon: "warning",
                                              buttons: true,
                                              dangerMode: true,
                                            })
                                            .then((willDelete) => {
                                                  if (willDelete) {
                                                       
                                                        $.ajax({
                                                                  url: _BASE_URL+"/delete-message-from",
                                                                  data:{'message_id':messageId},
                                                                  method:'POST',
                                                                  dataType:'json',
                                                                  headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                  },
                                                                  success: function(response){
                                                                    if(response.user_type == '3'){//company
                                                                          window.location = _BASE_URL+'/company/message/'+response.user_id;
                                                                    }else{
                                                                          window.location = _BASE_URL+'/candidate/message/'+response.user_id;
                                                                    }
                                                                           
                                                                   let submtbtn = $('#msg-sender').find('.msg-send');                                                                                   
                                                                   $this.freezPagePopupModal(submtbtn,'...'); 
                                                               },
                                                                  error: function(){
                                                                              alert("Something happend wrong.Please try again");
                                                                  } 
                                                        });    
                                                                                                                                  
                                                  }
                                            }); 
                                                                                               
                                        
                                   }catch(error){
                                        console.log('storeProfileDataAjax function :: '+error);
                                   }
                                });
                            },
                            imageFileUpload : function(){
                                             var $this = this;
                                             $(document).on('click','.img-upload-message',function(){
                                                      $('.img-upload').trigger('click');
                                             }); 
                                             $(document).on('click','.file-upload-message',function(){
                                                      $('.fileupload-upload').trigger('click');
                                             });                                                                                                                                                                                       

                            },
                            uploadPhoto : function(){
                                          var $this = this;      
                                          $(document).on('change','.img-upload',function(){ 
                                                try{ 
                                                     var msg_img_file_send = document.getElementById("msg-sender");   
                                                     var fd = new FormData(msg_img_file_send);
                                                     let fileSizeImage = fd.get('image').size;
                                                      
                                                      if((fileSizeImage != 0) && fileSizeImage > (1024*(1024*20))){
                                                            swal($this.lanFilter(allMsgText.THE_ALLOWED_MAX_FILE_SIZE_IS_20MB));
                                                            return false;
                                                      }
                                                     $('.file-uploading').show();  
                                                     fd.append('message','message stuff uploads');
                                                     fd.append('selected_user_id',$('.block-contact').attr('data-id'));
                                                     let submtbtn = $('#msg-sender').find('.msg-send');                                                                                   
                                                     $this.freezPagePopupModal(submtbtn,'...'); 
                                                     //image upload
                                                      $.ajax({
                                                              url: _BASE_URL+'/upload-message-data-files',
                                                              data:fd,
                                                              method:'post',
                                                              dataType:'json',
                                                              cache : false,
                                                              processData: false,
                                                              contentType: false,
                                                              headers: {
                                                                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                      },
                                                              success: function(response){
                                                                        
                                                                        location.reload();                                                        
                                                              },
                                                              error: function(){
                                                                      alert("Something happend wrong.Please try again");
                                                                      
                                                              } 
                                                    }).done(function(){
                                                            //$('.file-uploading').hide();
                                                    });
                                                }catch(error){
                                                      console.log('storeProfileDataAjax function :: '+error);
                                                 }
                                             }); 
                            },
                            uploadFile: function(){
                                            var $this = this;      
                                            $(document).on('change','.fileupload-upload',function(){                                                        
                                                try{                                                                                              
                                                     var msg_img_file_send = document.getElementById("msg-sender");   
                                                     var fd = new FormData(msg_img_file_send);

                                                     let fileSizeImage = fd.get('fileupload').size;
                                                      
                                                      if((fileSizeImage != 0) && fileSizeImage > (1024*(1024*20))){
                                                            swal($this.lanFilter(allMsgText.THE_ALLOWED_MAX_FILE_SIZE_IS_20MB));
                                                            return false;
                                                      }
                                                     $('.file-uploading').show(); 
                                                     fd.append('message','message stuff uploads');
                                                     fd.append('selected_user_id',$('.block-contact').attr('data-id'));
                                                     let submtbtn = $('#msg-sender').find('.msg-send');                                                                                   
                                                     $this.freezPagePopupModal(submtbtn,'...'); 
                                                     //image upload
                                                      $.ajax({
                                                              url: _BASE_URL+'/upload-message-data-files',
                                                              data:fd,
                                                              method:'post',
                                                              dataType:'json',
                                                              cache : false,
                                                              processData: false,
                                                              contentType: false,
                                                              headers: {
                                                                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                      },
                                                              success: function(response){
                                                                        
                                                                        location.reload();                                                        
                                                              },
                                                              error: function(){ console.log(error);
                                                                      alert("Something happend wrong.Please try again");
                                                                      
                                                              } 
                                                    }).done(function(){
                                                            //$('.file-uploading').hide();
                                                    });
                                                }catch(error){
                                                      console.log('storeProfileDataAjax function :: '+error);
                                                 }
                                             }); 
                            },
                            deleteSingleMessage:function(){
                                $this = this;
                              $(document).ready(function() {
                                  // DELETE MESSAGE
                                  $(".remove_msg").click(function () {
                                      swal({
                                          title: $this.lanFilter(allMsgText.ARE_YOU_SURE),
                                          text: $this.lanFilter(allMsgText.DO_YOU_WANT_TO_REMOVE_THIS_MESSAGE),
                                          icon: "warning",
                                          buttons: true,
                                          dangerMode: true,
                                        })
                                        .then((willDelete) => {
                                          if (willDelete) {
                                                var messageId = $(this).attr("data-id"); 
                                                  $.ajax({
                                                      method: "POST",
                                                      url: _BASE_URL+'/remove-message',
                                                      data: {'messageId': messageId},
                                                      headers: {
                                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                      },
                                                      success: function(res) {
                                                            $("#remove_msg_"+messageId).remove();  
                                                      }
                                                  }); 
                                          } else {
                                                 return true;
                                          }
                                      });
                                      
                                  });
                              });
                        },
                        

                                               
    
}

messagesFunctions.init();
  