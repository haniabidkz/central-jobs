var Post = {
    init: function(){
         this.validateSubscriptionData();
         this.submitValidateForm();
    },
    //validation to add subscription data
    validateSubscriptionData : function()
    {
        $(document).ready(function(){
            
            $("#manage-form").validate({
                submitHandler: function(form) {
                        //var value = $("input[name='acc']:checked").val();
                        // if(value == 1){
                        //   var text = allMsgText.DO_YOU_REALLY_WANT_TO_ACTIVE_ACCOUNT;
                        // }
                        // else if(value == 2){
                        //   var text = allMsgText.DO_YOU_REALLY_WANT_TO_DEACTIVATE_ACCOUNT;
                        // }
                        // else if(value == 3){
                        //   var text = allMsgText.DO_YOU_REALLY_WANT_TO_DELETE_ACCOUNT;
                        // }
                       // alert(value);
                       var text = allMsgText.DO_YOU_REALLY_WANT_TO_DELETE_ACCOUNT;
                        //if(value != undefined && value != 1){
                          //confirm
                            swal({
                              title: allMsgText.ARE_YOU_SURE,
                              text: text,
                            // icon: "success",
                              buttons: true,
                            //   dangerMode: true,
                            })
                            .then((willDelete) => {
                              if (willDelete) {
                                      $(document).find(".loder-holder").removeClass('d-none');
                                      form.submit();
                              } else {
                                    //$("input[name='acc']").prop("checked", false);
                                    window.location.href = BASE_URL+'/candidate/dashboard';
                              }
                          });
                          //end section
                        //}
                       
                  }
                   
               });
       });
    },

    submitValidateForm : function()
    {        
        $(document).on('click','.confirm-submission',function(){ console.log('submit');
            $("#manage-form").submit();
        });
    },
    
}

Post.init();
  