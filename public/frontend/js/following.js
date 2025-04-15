function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }
var Post = {
    init: function(){
         this.listing();
         this.listingCompany();
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
    listing : function(){
        var $this = this;
        $(document).ready(function() {
            // scroll pagination
            var page = $('#page').val();

            $(window).scroll(function() {
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
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
                   
                    $.ajax(
                        {   
                            url: _BASE_URL+'/candidate/following-list?page=' + page,
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
                            $('.ajax-load').hide();
                            if(data == " "){
                                $('.ajax-load').html($this.lanFilter(allMsgText.NO_MORE_RECORD_FOUND));
                                return;
                            }
                            $('#post-data').fadeIn();
                            $("#post-data").append(data.html);
                            
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError)
                        {
                            alert('server not responding...');
                        });
        });
},
listingCompany : function(){
    var $this = this;
    $(document).ready(function() {
        // scroll pagination
        var page = $('#page_company').val();

        $(window).scroll(function() {
            if($(window).scrollTop() == $(document).height() - $(window).height()) {
                page++;
                //search with list
                
                $(window).scrollTop($(window).scrollTop()-1);
                $this.loadMoreCompanyData(page);
                
            }
        });
        
    });
},
loadMoreCompanyData : function(page){
    $(document).ready(function() {
    $.ajax(
        {   
            url: _BASE_URL+'/candidate/company-following-list?page_company=' + page,
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
            $('.ajax-load-company').hide();
            if(data == " "){
                $('.ajax-load-company').html($this.lanFilter(allMsgText.NO_MORE_RECORD_FOUND));
                return;
            }
            $('#post-data-company').fadeIn();
            $("#post-data-company").append(data.html);
            
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            alert('server not responding...');
        });
    });
},
    
}

Post.init();
  