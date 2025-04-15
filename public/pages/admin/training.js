var Post = {
    init: function(){
        Post.edit();
        Post.add();
        Post.list();
        Post.videoEdit();
        Post.videoAdd();
        Post.videoList();
    },
    edit:function(){
        $(document).ready(function() {
            //VALIDATION ALL FIELD
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
            $("#editCategory").validate({
                rules: {
                    name: {
                        required: true,
                        noSpace: true
                    },
                    course_url: { 
                        required: true ,
                        url: true
                    }
                },
                messages:{
                    name:{
                        required: "Please enter your category name."
                    },
                    course_url: { 
                        required: "Please enter course url." ,
                        url: "Please enter valid url."
                    }
                }
            });
           
        });
    },
    add:function(){
        $(document).ready(function() {
            // ADD CATEGORY VALIDATION
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
            $("#addCategory").validate({
                rules: {
                    name: {
                        required: true,
                        noSpace: true
                    },
                    course_url: { 
                        required: true ,
                        url: true
                    }
                },
                messages:{
                    name:{
                        required: "Please enter your category name."
                    },
                    course_url: { 
                        required: "Please enter course url." ,
                        url: "Please enter valid url."
                    }
                }
            });
            
        });
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
                    url: BASE_URL+"/admin/training-category-change-status",
                    data: { 'status': status,'id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        location. reload();
                    }
                }); 
            });
            //SEARCH FIELD VALIDATION
            $('#searchBtn').on("click", function() {
               var name = $.trim($('#name').val());
               if(name == ''){
                    $('#searchId').html('Please enter category name.');
                    return false;
               } 
            });
        });
    },
    videoEdit:function(){
        $(document).ready(function() {
            //VALIDATION ALL FIELD
            $("#editVideo").validate({
                rules: {
                    category_id: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    description:{
                        required: true,
                        maxlength: 255
                    },
                    youtube_video_key: {
                        required: true
                    }
                },
                messages:{
                    category_id: {
                        required: "Please select project category"
                    },
                    title:{
                        required: "Please enter video title."
                    },
                    description:{
                        required: "Please enter video description.",
                        maxlength: "Description should not exceed 255 characters."
                    },
                    youtube_video_key: {
                        required: "Please enter youtube video key."
                    }
                }
            });
           
        });
    },
    videoAdd:function(){
        $(document).ready(function() {
            // ADD CATEGORY VALIDATION
            $("#addVideo").validate({
                rules: {
                    category_id: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    description:{
                        required: true,
                        maxlength: 255
                    },
                    youtube_video_key: {
                        required: true
                    }
                },
                messages:{
                    category_id: {
                        required: "Please select project category."
                    },
                    title:{
                        required: "Please enter video title."
                    },
                    description:{
                        required: "Please enter video description.",
                        maxlength: "Description should not exceed 255 characters."
                    },
                    youtube_video_key: {
                        required: "Please enter youtube video key."
                    }
                }
            });
            
        });
    },
    videoList:function(){
        $(document).ready(function() {
            
            //FOR JOB AND COMPANY CHANGE STATUS
            $( ".status" ).on( "click", function() {
                var status = $(this).data("val");
                var id = $(this).data("id");
                $(document).find(".loder-holder").removeClass('d-none');
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/training-video-change-status",
                    data: { 'status': status,'id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        location. reload();
                    }
                }); 
            });
            //SEARCH FIELD VALIDATION
            $('#searchBtn').on("click", function() {
               var name = $('#title').val();
               var category_id = $('#category_id').val();
               if(name == '' && category_id == ''){
                    $('#searchId').html('Please enter any search value.');
                    return false;
               } 
            });
            // OPEN MODAL FOR YOUTUBE VIDEO
            $( ".video-open" ).on( "click", function() {
                var key = $(this).data("id");
                let url =  'https://www.youtube.com/embed/'+key;
                $('iframe').attr('src',url); 
                setTimeout(function(){
                    $("#myModal").modal();
                },500);
            });

            //SEARCH FIELD VALIDATION
            $('#searchBtn').on("click", function() {
                var title = $('#title').val();
                var category = $('#category_id').val();
                
                if((title == '') && (category == '')){
                    $('#searchId').html('Please enter any search value.');
                    return false;
                } 
             });
        });
    }
}

Post.init();