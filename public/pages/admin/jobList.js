var Post = {
    init: function(){
        Post.changeStatus();
        Post.List();
    },
    changeStatus:function(){
        $(document).ready(function() {
            //FOR JOB AND COMPANY CHANGE STATUS
            $( ".status" ).on( "click", function() {
                var status = $(this).data("val");
                var id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/job-change-status",
                    data: { 'status': status,'id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        location. reload();
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

            var arrCompany= new Array();
            $.each( companyList, function(key, obj){
                arrCompany.push(obj.company_name);
            });
            $( "#company_name" ).autocomplete({
              source: arrCompany
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
                    url: BASE_URL+"/admin/candidate-get-state",
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
            // $('#searchBtn').on("click", function() {
            //     var name = $('#name').val();
            //     var email = $('#email').val();
            //     var country = $('#country_id').val();
            //     var state = $('#state_id').val();
            //     var status = $('#status').val();
            //     var company = $('#company_name').val();
            //     $('#errCountryId').html('');
            //     $('#errId').html('');
            //     $('#searchId').html('');
            //     if(country != ''){
            //         var arr = new Array();
            //         $.each( countryList, function(key, obj){
            //             arr.push(obj.name);
            //         });
            //         if(jQuery.inArray(country, arr) === -1){
            //             $('#errCountryId').html('Please enter country name.');
            //             return false;
            //         }
            //     }else{
            //         $('#cntrId').val('');
            //     }
            //     //Valid Email Checking
            //     var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
            //     if ((email != '') && (!re.test(email))){
            //         $('#errId').html('Please enter valid email address.');
            //         return false;
            //     }
            //     if((name == '') && (email == '') && (country == '') && (state == '') && (status == '') && (company == '')){
            //         $('#searchId').html('Please enter any search value.');
            //         return false;
            //     } 
            //  });
              
        });
       
    }
}

//Post.init();