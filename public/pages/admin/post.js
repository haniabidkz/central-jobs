var Post = {
    init: function(){
        Post.List();
        Post.Report();
        Post.CommentReport();
    },
    List:function(){
        $(document).ready(function() {
            // OPEN MODAL FOR VELIDATION OF COMPANY
            $( ".opnMdlCls" ).on( "click", function() {
                var id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/get-report-details",
                    data: {'id':id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('.tblData').html('');
                        $.each(res,function(index,row){
                            var status = '';
                            if(row['status'] == 0){
                                status = 'Reported';
                            }else if(row['status'] == 1){
                                status = 'Abused';
                            }else if(row['status'] == 2){
                                status = 'Ignored';
                            }
                           $('.tblData').append('<tr><td>'+(index+1)+'</td><td>'+row['reporter_user']['first_name']+' '+row['reporter_user']['last_name']+'</td><td>'+row['comment']+'</td><td>'+status+'</td><td>'+row['created_at']+'</td></tr>');
                        })
                        $("#myModal").modal();
                    }
                }); 
            });
            //FOR JOB AND COMPANY CHANGE STATUS
            $( ".status" ).on( "click", function() {
                var status = $(this).data("val");
                var id = $(this).data("id");
                $(document).find(".loder-holder").removeClass('d-none');
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/post-change-status",
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
    Report:function(){
        $(document).ready(function() {
            $('.abuse').on("click", function() {
                swal({
                    title: "Are you sure?",
                    text: 'Post will be marked as "Abuse" and Post will be removed from the dashboard of all front end user.All child posts will also be marked as "Abuse" Post will not come again to the admins Reported Post List.',
                   // icon: "success",
                    buttons: true,
                  //   dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                            var postId = $('#post_id').val();
                            $(document).find(".loder-holder").removeClass('d-none');
                            $.ajax({
                                method: "POST",
                                url: BASE_URL+"/admin/reported-post-abuse",
                                data: {'postId':postId},
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    window.location.href = BASE_URL+"/admin/reported-post-list";
                                }
                            }); 
                    } else {
                           return true;
                    }
                });
                
            });

            $('.ignore').on("click", function() {
                swal({
                    title: "Are you sure?",
                    text: 'Reported flag will be removed from that post.Post will not come again to the admins Reported Post List.',
                   // icon: "success",
                    buttons: true,
                  //   dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                            var postId = $('#post_id').val();
                            $(document).find(".loder-holder").removeClass('d-none');
                            $.ajax({
                                method: "POST",
                                url: BASE_URL+"/admin/reported-post-ignore",
                                data: {'postId':postId},
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    window.location.href = BASE_URL+"/admin/reported-post-list";
                                }
                            }); 
                    } else {
                           return true;
                    }
                });
                
            });
        });
    },
    CommentReport:function(){
        $(document).ready(function() {
            $('.abuse').on("click", function() {
                swal({
                    title: "Are you sure?",
                    text: 'Comment will be marked as "Abuse" and Comment will remove from the dashboard of all front end user. All comments also be marked as "Abused" and will not come again to the admins Reported Comment List.',
                   // icon: "success",
                    buttons: true,
                  //   dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                            var commentId = $(this).data("id");
                            $(document).find(".loder-holder").removeClass('d-none');
                            $.ajax({
                                method: "POST",
                                url: BASE_URL+"/admin/reported-comment-abuse",
                                data: {'commentId':commentId},
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    window.location.href = BASE_URL+"/admin/reported-comment-list";
                                }
                            }); 
                    } else {
                           return true;
                    }
                });
            });

            $('.ignore').on("click", function() {
                swal({
                    title: "Are you sure?",
                    text: 'Reported flag will be removed from that comment. Comment will not come again to the admins Reported Comment List.',
                   // icon: "success",
                    buttons: true,
                  //   dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                            var commentId = $(this).data("id");
                            $(document).find(".loder-holder").removeClass('d-none');
                            $.ajax({
                                method: "POST",
                                url: BASE_URL+"/admin/reported-comment-ignore",
                                data: {'commentId':commentId},
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    window.location.href = BASE_URL+"/admin/reported-comment-list";
                                }
                            }); 
                    } else {
                           return true;
                    }
                });
            });
        });
    }
}

// Post.init();