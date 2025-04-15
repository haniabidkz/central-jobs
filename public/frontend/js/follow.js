function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }
var Post = {
    init: function(){
         this.followUser();
         this.connectionRequest();
         this.acceptRejectConnection();
    },
    removeFreezPagePopupModal: function($button){
        document.body.style.cursor = ""; // so it goes back to previous CSS defined value 
        $button.prop('disabled', false);
     },
    freezPagePopupModal: function($button){
        document.body.style.cursor = "progress";
        $button.prop('disabled', true);
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
followUser : function(){
    var $this = this;
    $(document).on('click','#follow-unfollow-user',function(event){  
    var userId = $(this).attr("data-id");
    var tag = $(this).attr("data-follow");
    var url = _BASE_URL+"/candidate/follow-unfollow-user";
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
               $('#total-follow-'+userId).html(response);
               if(tag == 1){
                $('.follow-unfollow-user-'+userId).html($this.lanFilter(allMsgText.UN_FOLLOW));
                $('.follow-unfollow-user-'+userId).attr('data-follow', 0);
               }else{
                $('.follow-unfollow-user-'+userId).html($this.lanFilter(allMsgText.FOLLOW));
                $('.follow-unfollow-user-'+userId).attr('data-follow', 1);
               }
               
                    
            },
            error: function(e){
                    alert("Something happend wrong.Please try again");
                    
            }	
        }).done(function() {
                        
        });	
    });

}, 
showSuccessMsg : function(msg){
    let msgBox = $(".alert-holder-success");
    msgBox.addClass('success-block');
    msgBox.find('.alert-holder').html(msg);
    setTimeout(function(){ msgBox.removeClass('success-block')},5000);
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
                $('#connect-id-'+candidateId).html($this.lanFilter(allMsgText.REMOVE));
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
    
}

Post.init();
  