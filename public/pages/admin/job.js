var Post = {
    init: function(){
        Post.edit();
        Post.add();
    },
    edit:function(){
        // SKILL MULTISELECT FOR THE JOB
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select a state"
        });
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
            //WEBSITE URL SHOW HIDE FOR APPLY BY
            $( "#applied_by" ).on( "change", function() {
                var id = $('#applied_by').val();
                if(id == 2){
                    $('.shcls').show();
                }else{
                    $('.shcls').hide();
                }
            });
            //DATEPICKER
            $( "#start_date" ).datepicker({
                dateFormat:'yy-mm-d',
                minDate : 0,
                onSelect: function(selected) {
                $("#end_date").datepicker("option","minDate", selected)
               }
            });
            $('#end_date').datepicker({
                dateFormat:'yy-mm-d',
                minDate: 0,
                onSelect: function(selected) {
                $("#start_date").datepicker("option","maxDate", selected)
                }
            });
            //VALIDATION ALL FIELD
            
                $('.error-state').text('');
                $.validator.addMethod("noSpace", function(value, element) { 
                    if(value != ''){
                        value = $.trim(value);
                        if(value == ''){
                            return false;
                        }else{
                            return true;
                        }	
                    }
                    //return value.indexOf(" ") < 0 && value != ""; 
                  }, 'No space please and do not leave it empty.');
                    $("#editJob").validate({
                        rules: {
                            title: { 
                                required: true ,
                                noSpace: true,
                                maxlength: 255
                            },
                            country_id: { 
                                required: true 
                            },
                            city: { 
                                required: true ,
                                noSpace: true,
                                maxlength: 255
                            },
                            seniority: { 
                                required: true 
                            },
                            seniority_other: {
                                required: function(element){
                                    if(($("#seniority").val() != '') && $("#seniority").val() == "other"){
                                        return true;
                                    }
                                }
                            },
                            employment: { 
                                required: true 
                            },
                            employment_other: {
                                required: function(element){
                                    if(($("#employment").val() != '') && $("#employment").val() == "other"){
                                        return true;
                                    }
                                }
                            },
                            screening_1: { 
                                maxlength: 1000
                            },
                            screening_2: { 
                                maxlength: 1000
                            },
                            screening_3: { 
                                
                                maxlength: 1000
                            },
                            interview_1: { 
                                maxlength: 1000
                            },
                            interview_2: {
                                maxlength: 1000
                            },
                            interview_3: { 
                                maxlength: 1000
                            },
                            description: { 
                                required: true,
                                noSpace: true,
                                maxlength: 5000 
                            },
                            start_date: { 
                                required: true 
                            },	
                            end_date: { 
                                required: true 
                            },
                            applied_by: { 
                                required: true 
                            },
                            website_link: { 
                                required: true ,
                                url: true
                            },
                            user_id: { 
                                required: true 
                            }	
                        },
                        messages: {
                            title: {
                                required: "Please enter position name"
                            },
                            country_id: { 
                                required: "Please select country" 
                            },
                            city: { 
                                required: "Please enter city" 
                            },
                            seniority: { 
                                required: "Please select seniority level" 
                            },
                            seniority_other: {
                                required: function(element){
                                    if(($("#seniority").val() != '') && $("#seniority").val() == "other"){
                                        return "Please enter seniority level";
                                    }
                                },
                                noSpace: true
                            },
                            employment: { 
                                required: "Please select employment type" 
                            },
                            employment_other: {
                                required: function(element){
                                    if(($("#employment").val() != '') && $("#employment").val() == "other"){
                                        return "Please enter employment level";
                                    }
                                },
                                noSpace: true
                            },
                            
                            description: { 
                                required: "Please enter description"
                            },
                            start_date: { 
                                required: "Please select start date" 
                            },	
                            end_date: { 
                                required: "Please select end date" 
                            },
                            applied_by: { 
                                required: "Please select apply through" 
                            },
                            website_link: { 
                                required: "Please enter website link" ,
                                url: "Please enter valid url"
                            },
                            user_id: { 
                                required: "Please select company name" 
                            }

                        },
                        submitHandler : function(form){	
                            var state = $('#state_id').val();
                            if(state != ''){
                                var mandatory = $('#mandatory_setting').val();
                                var one = $.trim($('#interview_1').val());
                                var two = $.trim($('#interview_2').val());
                                var three = $.trim($('#interview_3').val());
                                
                                if((mandatory == 1) && (one == '') && (two == '') && (three == '')){
                                    $('.error-interview').css('display','block');
                                    $('.error-interview').text('Please enter any one interview question');
                                    return false;
                                }
                                else if((mandatory == 2) && (one == '') && (two == '') && (three == '')){
                                    $('.error-interview').css('display','block');
                                    $('.error-interview').text('Please enter any one interview question');
                                    return false;
                                }else if(mandatory == 3 && (((one != '') && ((two == '') && (three == ''))) || ((two != '') && ((one == '') && (three == ''))) || ((three != '') && ((one == '') && (two == ''))))){
                                    $('.error-interview').css('display','block');
                                    $('.error-interview').text('Please enter any two interview question');
                                    return false;
                                }else{
                                    form.submit();
                                }
                                
                            }else{
                                $('.error-state').css('display','block');
                                $('.error-state').text('Please select state');
                                return false;
                            }
                            
                        }
                    });
            
            //UPDATE STATE DRPDOWN ON CHANGE OF COUNTRY
            $( ".ui-autocomplete" ).on( "click", function() {
                let $this = this;
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
                    method: "GET",
                    url: BASE_URL+"/candidate/get-country-states/"+countryId,
					dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(jsonStates) {
                        let stateSelectBox = '<select name="state_id[]" data-placeholder="State *" id="state_id" class="form-control multi-select-states" multiple="multiple" style="display:none"></select>';
                        stateSelectBox = $(stateSelectBox);
                        $.each(jsonStates, function(key, row) {	
                            stateSelectBox.append('<option value="' + row.id+ '">' + row.name + '</option>');
                        });
                        $(".multi-select-states-area").append(stateSelectBox);
                        $(".multi-select-states-area").find('select').eq(0).remove();
                        $(".multi-select-states-area").find('.dashboardcode-bsmultiselect').eq(0).remove();
                        $(".multiple-select select.multi-select-states").bsMultiSelect();
                    }
                }); 
            });    
           
        });
    },
    
    add:function(){
        $(document).ready(function() {
            $(".js-example-placeholder-multiple").select2({
                placeholder: "Select a state"
            });
            $( "#category_id" ).on( "change", function() {
                var postType = $('#category_id').val();
                if(postType == 1){
                    $(".showJobCls").css("display", "block");
                    $(".showTextCls").css("display", "none");
                    $(".showVdotCls").css("display", "none");
                    $(".showImgtCls").css("display", "none");
                }else if(postType == 2){
                    $(".showTextCls").css("display", "block");
                    $(".showVdotCls").css("display", "none");
                    $(".showJobCls").css("display", "none");
                    $(".showImgtCls").css("display", "none");
                }else if(postType == 3){
                    $(".showImgtCls").css("display", "block");
                    $(".showVdotCls").css("display", "none");
                    $(".showJobCls").css("display", "none");
                    $(".showTextCls").css("display", "none");
                }else if(postType == 4){
                    $(".showVdotCls").css("display", "block");
                    $(".showJobCls").css("display", "none");
                    $(".showTextCls").css("display", "none");
                    $(".showImgtCls").css("display", "none");
                }
            });
            // ADD POST VALIDATION
            $( ".addClick" ).on( "click", function() {
            $.validator.addMethod("noSpace", function(value, element) { 
                if(value != ''){
                    value = $.trim(value);
                    if(value == ''){
                        return false;
                    }else{
                        return true;
                    }	
                }
                //return value.indexOf(" ") < 0 && value != ""; 
                }, 'No space please and do not leave it empty.');    
            var validat = $( "#addPost" ).validate({
                rules: {
                    category_id: {
                        required: true
                    },
                    title_job: {
                        required: true,
                        noSpace: true
                    },
                    description_job:{
                        required: true,
                        noSpace: true,
                        maxlength: 255
                    },
                    description_text:{
                        required: true,
                        maxlength: 255
                    },
                    description_img:{
                        required: true
                    },
                    description_vdo:{
                        required: true
                    },
                    country_id: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    city: {
                        required: true,
                        noSpace: true
                    },
                    position_for: {
                        required: true
                    },
                    employment_type: {
                        required: true
                    },
                    language: {
                        required: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    applied_by: {
                        required: true
                    },
                    website_link: {
                        required: true
                    },
                    user_id: {
                        required: true
                    },
                    video: {
                        required: true
                    }
                    
                },
                messages:{
                    category_id:{
                        required: "Please select post type."
                    },
                    title:{
                        required: "Please enter job title."
                    },
                    description_job:{
                        required: "Please enter job description.",
                        maxlength: "Description should not exceed 255 characters."
                    },
                    description_text:{
                        required: "Please Write something to share.",
                        maxlength: "Description should not exceed 255 characters."
                    },
                    description_img:{
                        required: "Please Write something to share."
                    },
                    description_vdo:{
                        required: "Please Write something to share."
                    },
                    country_id: {
                        required: "Please select country."
                    },
                    state_id: {
                        required: "Please select state."
                    },
                    city: {
                        required: "Please enter city."
                    },
                    position_for: {
                        required: "Please select position."
                    },
                    employment_type: {
                        required: "Please selete job type."
                    },
                    language: {
                        required: "Please enter language."
                    },
                    start_date: {
                        required: "Please select start date."
                    },
                    end_date: {
                        required: "Please select end date."
                    },
                    applied_by: {
                        required: "Please select apply process."
                    },
                    applied_by: {
                        required: "Please select apply process."
                    },
                    user_id: {
                        required: "Please select company name."
                    },
                    video: {
                        required: "Please select video."
                    }
                }
            });
            
            if(validat.form()){
                var skill = $.trim($('#skill').val());
                if(skill == ''){
                    $('.addSkill').html('Please select skill.');
                    return false;
                }else{
                    $('#addPost').submit();
                }
            }
        });

        });
    }
}

Post.init();