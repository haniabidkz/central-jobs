var Post = {
    init: function(){
        Post.editCms();
        Post.addCms();
        Post.addPage();
        Post.editPage();
        Post.addPageContent();
        Post.editPageContent();
        $(document).ready(function() {
        $('#searchBtn').on("click", function() {
           var page_name = $('#page_name').val();
           var status = $('#status').val();
           if(page_name == '' && status == ''){
                $('#searchId').html('Please enter any search value.');
                return false;
           } 
        });
        $('#searchBtnCont').on("click", function() {
           var content_ref = $('#content_ref').val();
           var status = $('#status').val();
           if(content_ref == '' && status == ''){
                $('#searchId').html('Please enter any search value.');
                return false;
           } 
        });
        $( ".status" ).on( "click", function() {
              var status = $(this).data("val");
              var id = $(this).data("id");
              $(document).find(".loder-holder").removeClass('d-none');
              $.ajax({
                  method: "POST",
                  url: BASE_URL+"/admin/content-ref-change-status",
                  data: { 'status': status,'id':id},
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(res) {
                      //$(document).find(".loder-holder").addClass('d-none');
                      //console.log(res);
                      location. reload();
                  }
              }); 
          });
          $( ".status_page" ).on( "click", function() {
              var status = $(this).data("val");
              var id = $(this).data("id");
              $(document).find(".loder-holder").removeClass('d-none');
              $.ajax({
                  method: "POST",
                  url: BASE_URL+"/admin/page-change-status",
                  data: { 'status': status,'id':id},
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(res) {
                      //$(document).find(".loder-holder").addClass('d-none');
                      //console.log(res);
                      location. reload();
                  }
              }); 
          });
      });
    },
    addCms:function(){
        $(document).ready(function() {
            CKEDITOR.replace( 'text_english');
            CKEDITOR.replace( 'text_french');
            CKEDITOR.replace( 'text_portuguese');

            $( "#addCmsText" ).submit( function( e ) { 
                $('.descErrEng').html("");
                $(".descErrEng").removeClass("error");
                $('.descErrFre').html("");
                $(".descErrFre").removeClass("error");
                $('.descErrPrt').html("");
                $(".descErrPrt").removeClass("error");
                //in case, if didn't worked, remove below comment. This will get the textarea with current status
               //CKEDITOR.instances.textarea_input_name.updateElement( ); 
               var messageLengthEng = CKEDITOR.instances['text_english'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLengthEng )
               {
                   $('.descErrEng').html("Please enter english text.");
                   $(".descErrEng").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   $('html, body').animate({
                        scrollTop: ($('.error').first().offset().top)
                    },500);
                   return false;
               }
               var messageLengthFr = CKEDITOR.instances['text_french'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLengthFr )
               {
                   $('.descErrFre').html("Please enter french text.");
                   $(".descErrFre").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   $('html, body').animate({
                        scrollTop: ($('.error').first().offset().top)
                    },500);
                   return false;
               }
               var messageLengthPr = CKEDITOR.instances['text_portuguese'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLengthPr )
               {
                   $('.descErrPrt').html("Please enter portuguese text.");
                   $(".descErrPrt").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   return false;
               }
                return true;
           } );
        });
    },
    editCms:function(){
        $(document).ready(function() {
            CKEDITOR.replace( 'text');

            $( "#editCmsText" ).submit( function( e ) { 
                $('.descErr').html("");
                $(".descErr").removeClass("error");
                
                //in case, if didn't worked, remove below comment. This will get the textarea with current status
               //CKEDITOR.instances.textarea_input_name.updateElement( ); 
               var messageLength = CKEDITOR.instances['text'].getData( ).replace( /<[^>]*>/gi, '' ).length;
               if( !messageLength )
               {
                   $('.descErr').html("Please enter text.");
                   $(".descErr").addClass("error");
                   //stop form to get submit
                   e.preventDefault( );
                   return false;
               }
                return true;
           } );
        });
    },
    editPage:function(){
        $(document).ready(function() {
            // DELETE IMAGE
            $("#deleteImg").click(function () {
                swal({
                    title: "Are you sure?",
                    text: 'Do you want to delete this banner image?',
                   // icon: "success",
                    buttons: true,
                  //   dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                            var imgId = $(this).data("img-id");
                            var pageId = $(this).data("page-id");
                            $(document).find(".loder-holder").removeClass('d-none');
                            $.ajax({
                                method: "POST",
                                url: BASE_URL+"/admin/banner-img-delete",
                                data: { 'imgId': imgId,'pageId':pageId},
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    $(document).find(".loder-holder").addClass('d-none');
                                    $(".rmv-img").css("display", "none");
                                }
                            }); 
                    } else {
                           return true;
                    }
                });
                
            });
            //VALIDATION ALL FIELD
            $("#editPage").validate({
                rules: {
                    page_name: {
                        required: true,
                        maxlength: 100
                    }
                },
                messages:{
                    page_name:{
                        required: "Please enter your page name.",
                        maxlength: "Page name should not exceed 100 characters."
                    }
                }
            });
           
        });
    },
    addPage:function(){
        $(document).ready(function() {
            //BANNER IMAGE
            var _URL = window.URL || window.webkitURL;

            $("#banner_image").change(function(e) {
                var file, img;
                $('#banner_img').html("");
                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function() {
                        var width = this.width;
                        var height = this.height;
                        if(width > 1920  || height > 498 ){
                          $('#banner_image').val('');
                          $('#banner_img').html('Recommended image width and height is 1920px X 498px.');
                          return false;
                        }
                    };
                    img.onerror = function() {
                        $('#banner_image').val('');
                        $('#banner_img').html('Please insert valid image file with following extensions .jpg .jpeg .png .bmp.');
                        return false;
                    };
                    img.src = _URL.createObjectURL(file);
                    $('#banner_img').html('<img src="'+img.src+'" class="img-fluid img-thumbnails" height="200" width="200">');
                }

            });
            // ADD CATEGORY VALIDATION
            $("#addPage").validate({
                rules: {
                    page_name: {
                        required: true,
                        maxlength: 100
                    }
                },
                messages:{
                    page_name:{
                        required: "Please enter your page name.",
                        maxlength: "Page name should not exceed 100 characters."
                    }
                }
            });
            
        });
    },
    editPageContent:function(){
        $(document).ready(function() {
            //VALIDATION ALL FIELD
            $("#editPageContent").validate({
                rules: {
                    content_ref: {
                        required: true,
                        maxlength: 100
                    }
                },
                messages:{
                    content_ref:{
                        required: "Please enter your page reference name.",
                        maxlength: "Page content reference should not exceed 100 characters."
                    }
                }
            });
           
        });
    },
    addPageContent:function(){
        $(document).ready(function() {
            // ADD  VALIDATION
            $("#addPageContent").validate({
                rules: {
                    content_ref: {
                        required: true,
                        maxlength: 100
                    }
                },
                messages:{
                    content_ref:{
                        required: "Please enter your page reference name.",
                        maxlength: "Page content reference should not exceed 100 characters."
                    }
                }
            });
            
        });
    },
}

Post.init();