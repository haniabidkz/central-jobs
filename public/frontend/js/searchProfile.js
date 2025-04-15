function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }
var Post = {
    init: function(){
         this.getState();
         this.listing();
         //this.listingCompany();
         this.followUser();
         this.connectionRequest();
         this.acceptRejectConnection();
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
    getState : function(){     
        let $this = this;   
       $(document).ready(function() {
           //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
           $( "#country_id" ).on( "change", function() {
               var countryId = $('#country_id').val();
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
                       $this.refreshStateDropDown(jsonStates);
                   }
               }); 
           }); 
             
       });
   },
   refreshStateDropDown : function(jsonStates){								    						
	var $this = this;							    														    						
    let stateSelectBox = '<select name="state[]" data-placeholder="'+$this.lanFilter(allMsgText.STATE)+'" id="state" class="form-control multi-select-states" multiple="multiple" style="display:none"></select>';
    stateSelectBox = $(stateSelectBox);
    $.each(jsonStates, function(key, row) {	
        stateSelectBox.append('<option value="' + row.id+ '">' + row.name + '</option>');
     });
    $(".multi-select-states-area").append(stateSelectBox);
    $(".multi-select-states-area").find('select').eq(0).remove();
    $(".multi-select-states-area").find('.dashboardcode-bsmultiselect').eq(0).remove();
    $(".multiple-select select.multi-select-states").bsMultiSelect();

    },
    removeFreezPagePopupModal: function($button){
        document.body.style.cursor = ""; // so it goes back to previous CSS defined value 
        $button.prop('disabled', false);
     },
    freezPagePopupModal: function($button){
        document.body.style.cursor = "progress";
        $button.prop('disabled', true);
    },
    
    listing : function(){
        var $this = this;
        $(document).ready(function() {
            var tag = $('#tag').val();
            $( "#search-bttn-first" ).on( "click", async function() {
                var candidate_name = $('#candidate_name').val();
                var state = $('#state').val();
                if(state == null){
                    state = '';
                }
                var current_company = $('#current_company').val();
                if(current_company == null){
                    current_company = '';
                }
                var itskills = $('#itskills').val();
                
                if(itskills == null){
                    itskills = '';
                }
                // if(itskills == ''){
                //     $('.profile-headline-cls').css('display','block');
                //     setTimeout(function(){ 
                //         $('.profile-headline-cls').text($this.lanFilter(allMsgText.PLEASE_ENTER_PROFILE_HEADLINE_OR_SELECT_FROM_DROPDOWN)).delay(3000).fadeOut(600);
                //     });
                //     return false;
                // }
                var page = 1;
                var $profileBtn = $(".input-search-holder").find("#search-bttn-first");
                $profileBtn.text($this.lanFilter(allMsgText.SEARCHING)+'...');
                $this.freezPagePopupModal($profileBtn);
                await sleep(2000);
                $.ajax(
                    {   
                        url: _BASE_URL+'/candidate/search-profile?page=' + page+'&candidate_name='+candidate_name+'&state='+state+'&current_company='+current_company+'&profile_headline='+itskills+'&flag=1',
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
                            
                                    // let newPageNum = $('#page_num').val();
                                    // $('#page_num').val((newPageNum+1))
                        }
                    })
                    .done(function(data)
                    {
                        
                        if(data.html == 0){
                            $('.ajax-load').html('');
                            return;
                        }
                        $("#post-data").html(data.html);
                        $('.ajax-load').hide();
                        $profileBtn.text('Search');
                        $this.removeFreezPagePopupModal($profileBtn);
                        $('.src-res').show();
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError)
                    {
                        alert('server not responding...');
                    });
            });

            //FOR COMPANY SEARCH
            $( "#search-bttn-second" ).on( "click", async function() {
                var company_name = $('#company_name').val();
                
                if(company_name == ''){
                    $('.company-name-cls').css('display','block');
                    setTimeout(function(){ 
                        $('.company-name-cls').text($this.lanFilter(allMsgText.PLEASE_ENTER_COMPANY_NAME)).delay(3000).fadeOut(600);
                    });
                    return false;
                }
                var page = 1;
                var $profileBtn = $(".input-search-holder-two").find("#search-bttn-second");
                $profileBtn.text($this.lanFilter(allMsgText.SEARCHING)+'...');
                $this.freezPagePopupModal($profileBtn);
                await sleep(2000);
                $.ajax(
                    {   
                        url: _BASE_URL+'/candidate/search-company-profile?page_company=' + page+'&company_name='+company_name+'&flag=1',
                        type: "get",
                        async: false,
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function()
                        {
                            $('.ajax-load-company').show();
                        },
                        success:function(data){
                            
                                    // let newPageNum = $('#page_num').val();
                                    // $('#page_num').val((newPageNum+1))
                        }
                    })
                    .done(function(data)
                    {
                        
                        if(data.html == 0){
                            $('.ajax-load-company').html('');
                            return;
                        }
                        $("#post-data-company").html(data.html);
                        $('.ajax-load-company').hide();
                        $profileBtn.text($this.lanFilter(allMsgText.SEARCH));
                        $this.removeFreezPagePopupModal($profileBtn);
                        $('.src-res-com').show();
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError)
                    {
                        alert('server not responding...');
                    });
            });
            // scroll pagination

            
            var tag = $('#tag').val();
            // if(tag == 0){
            //     var page = $('#page').val();
              
            //     console.log(page+' == 1');
            //     console.log('pageone');

            // }else if(tag == 1){
            //     var page = $('#page_company').val();
              
            //     console.log(page+' == 2');
            //     console.log('pagetwo');
            // }
            
            $(window).scroll(function() {
               
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
                    
                    //search with list
                    $(window).scrollTop($(window).scrollTop()-1);
                    var tag = $('#tag').val();
                   
                    if(tag == 0){
                        $this.loadMoreData((parseInt($('#page').val())+parseInt(1)));
                    }else if(tag == 1){
                        $this.loadMoreCompanyData((parseInt($('#page_company').val())+parseInt(1)));
                    }
                }
            });
           
            
        });
    },
    loadMoreData : function(page){
        $(document).ready(function() {
                    var candidate_name = $('#candidate_name').val();
                    var state = $('#state').val();
                    if(state == null){
                        state = '';
                    }
                    var current_company = $('#current_company').val();
                    if(current_company == null){
                        current_company = '';
                    }
                    var itskills = $('#itskills').val();
                    
                    if(itskills == null){
                        itskills = '';
                    }
                    //$('.ajax-load').show();
                    $.ajax(
                        {   
                            url: _BASE_URL+'/candidate/search-profile?page=' + page+'&candidate_name='+candidate_name+'&state='+state+'&current_company='+current_company+'&profile_headline='+itskills,
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
                            
                            console.log(data);
                            if(data == 0){
                                $(".ajax-load").html('');
                                return;
                            }else{
                                let tmpPage = $('#page').val();
                                tmpPage++;
                                $('#page').val(tmpPage);
                            }
                            $('.ajax-load').hide();
                            $('#post-data').fadeIn();
                            $("#post-data").append(data.html);
                            
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError)
                        {
                            alert('server not responding...');
                        });
        });
},

loadMoreCompanyData : function(page){
    console.log('page');
    console.log(page);
    var $this = this;
    $(document).ready(function() {
        var company_name = $('#company_name').val();
            console.log(company_name);
        if(company_name == '' || company_name == null){
            company_name = '';
            
        }
    $.ajax(
        {   
            url: _BASE_URL+'/candidate/search-company-profile?page_company=' + page+'&company_name='+company_name,
            type: "get",
            async: false,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function()
            {
                $('.ajax-load-company').show();
            },
            success:function(){
                        // let newPageNum = $('#page_num').val();
                        // $('#page_num').val((newPageNum+1))
            }
        })
        .done(function(data)
        {
            console.log(data);
            if(data == 0){
                $('.ajax-load-company').html('');
                return;
            }else{
                let tmpPageCom = $('#page_company').val();
                tmpPageCom++;
                $('#page_company').val(tmpPageCom);
            }
            $('#post-data-company').fadeIn();
            $("#post-data-company").append(data.html);
            $('.ajax-load-company').hide();
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            alert('server not responding...');
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
                            maxlength: $this.lanFilter(allMsgText.THE_TEXT_LESS_5000_CHARACTER)
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
                $('#connect-id-'+candidateId).html($this.lanFilter(allMsgText.REMOVE_CONNECTION));
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
  