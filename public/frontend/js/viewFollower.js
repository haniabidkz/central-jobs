function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }
var Post = {
    init: function(){
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
  