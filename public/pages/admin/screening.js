var Post = {
    init: function(){
        Post.list();
        Post.add();
    },
    list:function(){
        $(document).ready(function() {
        //FOR JOB AND COMPANY CHANGE STATUS
        $( ".status" ).on( "click", function() {
            var status = $(this).data("val");
            var id = $(this).data("id");
            $(document).find(".loder-holder").removeClass('d-none');
            $.ajax({
                method: "POST",
                url: BASE_URL+"/admin/screening-change-status",
                data: { 'status': status,'id':id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                   // $(document).find(".loder-holder").addClass('d-none');
                    //console.log(res);
                    location. reload();
                }
            }); 
        });
    });
    },
    add:function(){
        $(document).ready(function() {
            $('input[type="checkbox"]').on( "click", function() {
                if($(this). prop("checked") == true){
                    $('.radio').removeClass('error');
                    var radioValue = '';
                    var radioValue = event.srcElement.value;

                    for (i = 1; i < 4; i++) { 
                        if(radioValue == 1){
                            $("#answer_one_"+i). prop("checked", true);
                            $("#answer_two_"+i). prop("checked", false);
                            $("#answer_three_"+i). prop("checked", false);
                        }else if(radioValue == 2){
                            $("#answer_two_"+i). prop("checked", true);
                            $("#answer_one_"+i). prop("checked", false);
                            $("#answer_three_"+i). prop("checked", false);
                        }else if(radioValue == 3){
                            $("#answer_three_"+i). prop("checked", true);
                            $("#answer_one_"+i). prop("checked", false);
                            $("#answer_two_"+i). prop("checked", false);
                        }
                         
                    }
                    
                }else{
                    for (i = 1; i < 4; i++) { 
                        $("#answer_one_"+i). prop("checked", false);
                        $("#answer_two_"+i). prop("checked", false);
                        $("#answer_three_"+i). prop("checked", false);
                     
                    }
                }
            });
            // ADD  VALIDATION
            $( "#add-qsc" ).on( "click", function() {
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
            var validator = $("#addQuestion").validate({
                rules: {
                    question_english: {
                        required: true,
                        noSpace: true
                    },
                    option_one_english: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    option_two_english: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    option_three_english: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_one_english:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_two_english:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_three_english:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    question_french: {
                        required: true,
                        noSpace: true,
                    },
                    option_one_french: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    option_two_french: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    option_three_french: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_one_french:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_two_french:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_three_french:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    question_portuguese: {
                        required: true,
                        noSpace: true,
                    },
                    option_one_portuguese: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    option_two_portuguese: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    option_three_portuguese: {
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_one_portuguese:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_two_portuguese:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    },
                    reson_three_portuguese:{
                        required:true,
                        noSpace: true,
                        maxlength: 255
                    }

                },
                messages:{
                    question_english:{
                        required: "Please enter your question in english."
                    },
                    option_one_english: {
                        required: "Please enter option one in english."
                    },
                    option_two_english: {
                        required: "Please enter option two in english."
                    },
                    option_three_english: {
                        required: "Please enter option three in english."
                    },
                    reson_one_english:{
                        required: "Please entar reason one in english."
                    },
                    reson_two_english:{
                        required: "Please entar reason two in english."
                    },
                    reson_three_english:{
                        required: "Please entar reason three in english."
                    },
                    question_french:{
                        required: "Please enter your question in french."
                    },
                    option_one_french: {
                        required: "Please enter option one in french."
                    },
                    option_two_french: {
                        required: "Please enter option two in french."
                    },
                    option_three_french: {
                        required: "Please enter option three in french."
                    },
                    reson_one_french:{
                        required: "Please entar reason one in french."
                    },
                    reson_two_french:{
                        required: "Please entar reason two in french."
                    },
                    reson_three_french:{
                        required: "Please entar reason three in french."
                    },
                    question_portuguese:{
                        required: "Please enter your question in portuguese."
                    },
                    option_one_portuguese: {
                        required: "Please enter option one in portuguese."
                    },
                    option_two_portuguese: {
                        required: "Please enter option two in portuguese."
                    },
                    option_three_portuguese: {
                        required: "Please enter option three in portuguese."
                    },
                    reson_one_portuguese:{
                        required: "Please entar reason one in portuguese."
                    },
                    reson_two_portuguese:{
                        required: "Please entar reason two in portuguese."
                    },
                    reson_three_portuguese:{
                        required: "Please entar reason three in portuguese."
                    }

                }
            });
            if(validator.form()){
                var isChecked = $('.radio').is(':checked');
                $('.radio').removeClass('error');
                if(isChecked == false){
                    $('.radio').addClass('error');
                    return false;
                }else{
                    $('.radio').removeClass('error');
                    // $("#add-qsc").prop('disabled', true);
                    $('#addQuestion').submit();
                }
                
            }
        });
            
        });
    }
}

Post.init();