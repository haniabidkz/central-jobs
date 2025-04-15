var Post = {
    init: function(){
        Post.edit();
        Post.add();
        Post.list();
    },
    edit:function(){
        $(document).ready(function() {
            var _URL = window.URL || window.webkitURL;

            $("#image_name").change(function(e) {
                var file, img;
                $('#banner_img').html("");
                if ((file = this.files[0])) {
                    img = new Image();
                    // img.onload = function() {
                    //     var width = this.width;
                    //     var height = this.height;
                    //     if(width > 500  || height > 400 ){
                    //       $('#image_name').val('');
                    //       $('#banner_img').html('Recommended image width and height is 1920px X 498px.');
                    //       return false;
                    //     }
                    // };
                    img.onerror = function() {
                        $('#image_name').val('');
                        $('#banner_img').html('Please insert valid image file with following extensions .jpg .jpeg .png .bmp.');
                        return false;
                    };
                    img.src = _URL.createObjectURL(file);
                    $('#banner_img').html('<img src="'+img.src+'" class="img-fluid img-thumbnails" height="200" width="200">');
                }

            });
            //VALIDATION ALL FIELD
           
            $("#editAdvertise").validate({
                rules: {
                    url: { 
                        required: true ,
                        url: true
                    }
                },
                messages:{
                    url: { 
                        required: "Please enter advertise url." ,
                        url: "Please enter valid url."
                    }
                }
            });
           
        });
    },
    add:function(){
        $(document).ready(function() {
            //BANNER IMAGE
            var _URL = window.URL || window.webkitURL;

            $("#image_name").change(function(e) {
                var file, img;
                $('#banner_img').html("");
                if ((file = this.files[0])) {
                    img = new Image();
                    // img.onload = function() {
                    //     var width = this.width;
                    //     var height = this.height;
                    //     if(width > 500  || height > 400 ){
                    //       $('#image_name').val('');
                    //       $('#banner_img').html('Recommended image width and height is 1920px X 498px.');
                    //       return false;
                    //     }
                    // };
                    img.onerror = function() {
                        $('#image_name').val('');
                        $('#banner_img').html('Please insert valid image file with following extensions .jpg .jpeg .png .bmp.');
                        return false;
                    };
                    img.src = _URL.createObjectURL(file);
                    $('#banner_img').html('<img src="'+img.src+'" class="img-fluid img-thumbnails" height="200" width="200">');
                }

            });

            // ADD CATEGORY VALIDATION
           
            $("#addAdvertise").validate({
                rules: {
                    url: { 
                        required: true ,
                        url: true
                    },
                    image_name: { 
                        required: true 
                    }
                },
                messages:{
                    url: { 
                        required: "Please enter advertise url." ,
                        url: "Please enter valid url."
                    },
                    image_name: { 
                        required: "Please select image." 
                    }
                }
            });
            
        });
    },
    list:function(){
        $(document).ready(function() {
            //FOR CHANGE STATUS
            $( ".status" ).on( "click", function() {
                var status = $(this).data("val");
                var id = $(this).data("id");
                $(document).find(".loder-holder").removeClass('d-none');
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/advertise-change-status",
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
}

Post.init();