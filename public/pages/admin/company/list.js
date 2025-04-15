var Post = {
    init: function(){
        Post.changeStatus();
        Post.List();
    },
    changeStatus:function(){
        $(document).ready(function() {
            //OPEN BLOCK UNBLOCK MODAL
            $( ".opnBlkModal" ).on( "click", function() {
                var id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/company-report-details",
                    data: {'id':id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if(res != ''){
                            var contactName = res[0]['company_name'];
                            var compId = res[0]['id'];
                            $('#cntactCls').html(contactName);
                            $('#comp_id').val(compId);
                            if(res[0]['report'] != ''){
                                
                                var data = res[0]['report'];
                                $.each(data, function (i,v)
                                {
                                    if (i>1) {
                                        $('.addViewMore').show();
                                        $('.addViewMore').html('<a class="site-btn site-btn-color btn" href="'+BASE_URL+'/admin/company-report-list/'+compId+'" target="_blank">View More</a>');
                                        return false;
                                    }
                                    $('.id_'+i).html(i+1);
                                    if(v['reporter_user'] != null){
                                        $('.fname_'+i).html(v['reporter_user']['first_name']);
                                    }
                                    if(v['comment'].length > 160){
                                        var commentSub = v['comment'].substr(0, 160)+'...<a href="'+BASE_URL+'/admin/company-report-list/'+compId+'" target="_blank">Read More</a>';
                                    }else{
                                        var commentSub = v['comment'];
                                    }
                                    
                                    $('.comm_'+i).html(commentSub);
                                });
                            }else{
                                $('.rpt-one').remove() 
                                $('.rpt-two').remove() 
                                $('.rpt').show();
                            }
                        }
                        
                        $("#blkModal").modal();
                    }
                }); 
            });
            //FOR COMPANY BLOCK
            $( ".sbmtBlkCls" ).on( "click", function() {
                var status = $(this).data("status");
                var id = $('#comp_id').val();
                var reason = '';
                var reason = $.trim($('#block').val());
                var reason_length = $("#block").val().length;
                if(reason == ''){
                    $('#errBlkReason').html('Please enter block reason.');
                    return false;
                }else if(reason_length > 150){
                    $('#errBlkReason').html('Reason should not exceed 150 characters.');
                    return false;
                }
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/company-change-status",
                    data: { 'status': status,'id':id, 'reason':reason},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        window.location.href = BASE_URL+"/admin/company-list";
                    }
                }); 
            });
            //FOR JOB AND COMPANY CHANGE STATUS TO ACTIVE
            $( ".status" ).on( "click", function() {
                var status = $(this).data("val");
                var id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/company-change-status",
                    data: { 'status': status,'id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        window.location.href = BASE_URL+"/admin/company-list";
                    }
                }); 
            });
        
        });
    },
    List:function(){
        //AUTOCOMPLETE COUNTRY DROPDOWN
        $( function() {
            var arr= new Array();
            $.each( countryList, function(key, obj){
                arr.push(obj.name);
            });
            $( "#country_id" ).autocomplete({
              source: arr
            });
        });
        $(document).ready(function() {
            //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
            $( ".ui-autocomplete" ).on( "click", function() {
                var countryName = $('#country_id').val();
                var countryId = null;
                var i = null;
                for (i = 0; countryList.length > i; i += 1) {
                    if (countryList[i].name === countryName) {
                        var countryId = countryList[i].id;
                        $('#cntrId').val(countryId);
                    }
                }
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/company-get-state",
                    data: {'id': countryId},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('#state_id').html(res);
                    }
                }); 
            }); 

            //SEARCH FIELD VALIDATION
            $('#searchBtn').on("click", function() {
               var company_name = $.trim($('#company_name').val());
               var email = $('#email').val();
               var country = $('#country_id').val();
               var state = $('#state_id').val();
               var status = $('#status').val();
               var approveStatus = $('#approve_status').val();
               $('#errCountryId').html('');
                $('#errId').html('');
                $('#searchId').html('');
               if(country != ''){
                    var arr = new Array();
                    $.each( countryList, function(key, obj){
                        arr.push(obj.name);
                    });
                    if(jQuery.inArray(country, arr) === -1){
                        $('#errCountryId').html('Please enter country name.');
                        return false;
                    }
                }else{
                    $('#cntrId').val('');
                }
               //Valid Email Checking
               var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
               if ((email != '') && (!re.test(email)))
                {
                    $('#errId').html('Please enter valid email address.');
                    return false;
                }
               if( (company_name == '') && (email == '') && (country == '') && (state == '') && (status == '') && (approveStatus == '') ){
                    $('#searchId').html('Please enter any search value.');
                    return false;
               } 
            });

            //FOR COMPANY APPROVE
            $( ".sbmtCls" ).on( "click", function() {
                var status = $(this).data("status");
                var id = $('#id').val();
                var reason = '';
                if(status == 2){
                    var reason = $('#reject').val();
                    var reason_length = $("#reject").val().length;
                    if(reason == ''){
                        $('#errReason').html('Please enter rejection reason.');
                        return false;
                    }else if(reason_length > 255){
                        $('#errReason').html('Reason should not exceed 255 characters.');
                        return false;
                    }
                }
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/company-approve-status",
                    data: { 'status': status,'id':id, 'reason':reason},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        window.location.href = BASE_URL+"/admin/company-list";
                    }
                }); 
            });

            // OPEN MODAL FOR VELIDATION OF COMPANY
            $( ".opnMdlCls" ).on( "click", function() {
                var id = $(this).data("id");
                var dataStatus = $(this).data("status");
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/company-get-details",
                    data: {'id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('.cmpDetailCls').html(res);
                        if(dataStatus == 2){
                            $('.rejcls').hide();
                        }else{
                            $('.rejcls').show();
                        }
                        $("#myModal").modal();
                    }
                }); 
            });
        });
    }
}

Post.init();