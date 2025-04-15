function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }
var Post = {
    init: function(){
         this.acceptRejectConnection();
         this.followUser();
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
acceptRejectConnection : function(){
    $(document).on('click','.accept-reject-cls',function(event){  
    var $this = this;
    var candidateId = $($this).attr("data-id");
    var connectionId = $($this).attr("data-connect");
    var tag = $($this).attr("data-tag");
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
               
                location.reload(true); 
               
            },
            error: function(e){
                    alert("Something happend wrong.Please try again");
                    
            }	
        }).done(function() {
                        
        });	
    });

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

Post.init();
  