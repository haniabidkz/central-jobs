var Post = {
    init: function(){
        Post.edit();
        Post.add();
        Post.list();
    },
    edit:function(){
        $(document).ready(function() {
            //VALIDATION ALL FIELD           
            $("#editAdvertise").validate({
                rules: {
                    initial_text: { 
                        required: true 
                    },
                    position: { 
                        required: true 
                    },
                    requirment: { 
                        required: true 
                    },
                    ref_no: { 
                        required: true 
                    }
                },
                messages:{
                    initial_text: { 
                        required: "Please enter advertise initial text."
                    },
                    position: { 
                        required: "Please enter advertise position." 
                    },
                    requirment: { 
                        required: "Please enter companies requirment."
                    },
                    ref_no: { 
                        required: "Please enter reference number." 
                    }
                }
            });
           
        });
    },
    add:function(){
        $(document).ready(function() {
            // ADD CATEGORY VALIDATION           
            $("#addAdvertise").validate({
                rules: {
                    initial_text: { 
                        required: true 
                    },
                    position: { 
                        required: true 
                    },
                    requirment: { 
                        required: true 
                    },
                    ref_no: { 
                        required: true 
                    }
                },
                messages:{
                    initial_text: { 
                        required: "Please enter advertise initial text."
                    },
                    position: { 
                        required: "Please enter advertise position." 
                    },
                    requirment: { 
                        required: "Please enter companies requirment."
                    },
                    ref_no: { 
                        required: "Please enter reference number." 
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
                    url: BASE_URL+"/admin/best-advertise-change-status",
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