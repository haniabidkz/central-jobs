var Post = {
    init: function(){
         Post.list();
         this.validateSubscriptionData();
         this.submitValidateForm();
         let $thisClass = this;
         //propose date hide show
          $(document).on("change",'#subscription_id',function(){
              let $this = $(this);
              $thisClass.makeVisibleProposeDate($this);
          });
         //DATEPICKER
         $(function () {    
             //custom date filter 
            jQuery.validator.addMethod(
                "dateTime",
        
            function (value, element, params) {
                if (!/Invalid|NaN/.test(new Date(value))) {
                    return true;
                }
        
                return false;
            },
                'Must be in YYYY-MM-DD HH:mm format.');
            //end custom date filter
            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), nowDate.getHours(),  nowDate.getMinutes(), nowDate.getSeconds());
            //$('#service_start_from').datepicker({  format: 'yyyy/mm/dd' , startDate : today });
            $("#service_start_from").datetimepicker({
              format: 'yyyy-mm-dd hh:ii:ss', 
              startDate : today,
              autoclose: true
            });
        });
    },
    list:function(){
        $(document).ready(function() {
          //SEARCH FIELD VALIDATION
            $('#searchBtn').on("click", function() {
               var candidate_name = $.trim($('#candidate_name').val());
               var candidate_email = $('#candidate_email').val();
               var status = $('#status').val();
               var start_date = $('#start_date').val();
               var end_date = $('#end_date').val();
               if(candidate_name == '' && candidate_email == '' && status == '' && start_date == '' && end_date == ''){
                    $('#searchId').html('Please enter any search value.');
                    return false;
               } 
            });
             //DATEPICKER
             $( "#start_date" ).datepicker({
                dateFormat: "yy-mm-dd",
                //minDate: +1,
                onSelect: function(selected) {
                $("#end_date").datepicker("option","minDate", selected)
               }
            });
             
            $('#end_date').datepicker({
                dateFormat: "yy-mm-dd",
                //minDate: +1,
                onSelect: function(selected) {
                $("#start_date").datepicker("option","maxDate", selected)
                }
            });
            //FOR JOB AND COMPANY CHANGE STATUS
            $( ".show-order-details" ).on( "click", function() {
                var id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    url: BASE_URL+"/admin/view-order-details",
                    data: {'id':id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                       console.log(res);
                       $('.subscription-name').html('<p><b>Subscription Name : </b>'+ res['subscription']['title'] +'</p>');
                       $('.subscription-date').html('<p><b>Subscription Date : </b>'+ res['created_date'] +'</p>');
                       $('.candidate-name').html('<p><b>Candidate Name : </b>'+ res['user']['first_name']+' '+ res['user']['last_name'] +'</p>');
                       $('.candidate-email').html('<p><b>Candidate Email : </b>'+ res['user']['email'] +'</p>');
                       $('.subscription-amount').html('<p><b>Amount : </b>$'+ res['subscription']['price'] +'</p>');
                       $('.subscription-desc').html('<p><b>Subscription Description :</b>'+ res['subscription']['description'] +'</p>');
                       if(res['status'] == 1){
                       $('.orde-status').html('<p><b>Status : </b>Inprogress</p>');
                       }else if(res['status'] == 2){
                        $('.orde-status').html('<p><b>Status : </b>Paid</p>');
                       }else if(res['status'] == 3){
                        $('.orde-status').html('<p><b>Status : </b>Subscription Closed</p>');
                       }else{
                        $('.orde-status').html('<p><b>Status : </b>Order Placed</p>');
                       }
                       $("#myModal").modal();
                    }
                }); 
            });
            //ORDER STATUS CHANGE
            $('.status').on("click", function() {
                let $this = $(this);
                let id = $this.attr("data-id");
                let status = $this.attr("data-val");
                if(status == 3){
                    var text = "Do you really want to close this subscription?";
                }else if(status == 2){
                    var text = "Do you really want to change status to paid of this subscription?";
                }
                
                // code strat to change status
                  //confirm
                        swal({
                            title: "Are you sure?",
                            text: text,
                           // icon: "success",
                            buttons: true,
                          //   dangerMode: true,
                          })
                          .then((willDelete) => {
                            if (willDelete) {
                                    
                                    $(document).find(".loder-holder").removeClass('d-none');
                                    $.ajax({
                                        method: "POST",
                                        url: BASE_URL+"/admin/order-change-status",
                                        data: {'id':id,'status':status},
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function(res) {
                                           // console.log(res);
                                            location.reload();
                                        }
                                    }); 
                            } else {
                                  $(document).find(".loder-holder").addClass('d-none');
                                   //window.location.href = BASE_URL+'/admin/dashboard';
                            }
                          });
                  //end section
                //end code to end change status code
            });
        });
    },
    //validation to add subscription data
    validateSubscriptionData : function()
    {
        $(document).ready(function(){
            //VALIDATION ALL FIELD
            jQuery.validator.addMethod("laxEmail", function(value, element) {
              // allow any non-whitespace characters as the host part
              var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
              return this.optional( element ) || re.test( value );
            }, 'Please enter a valid email address.');
            jQuery.validator.addMethod("noSpace", function(value, element) { 
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
            $("#subscription-form").validate({
                submitHandler: function(form) {
                       //confirm
                        swal({
                            title: "Are you sure?",
                            text: "Do you really want to submit this record?",
                           // icon: "success",
                            buttons: true,
                          //   dangerMode: true,
                          })
                          .then((willDelete) => {
                            if (willDelete) {
                                    $(document).find(".loder-holder").removeClass('d-none');
                                    form.submit();
                            } else {
                                   window.location.href = BASE_URL+'/admin/order-list';
                            }
                          });
                          //end section
                  },
                   rules: {
                       candidate_name: {
                           required: true,
                           noSpace: true
                       },  
                       subscription_id: {
                           required: true
                       }, 
                       candidate_email: {
                           required: true,
                           laxEmail: true
                       }, 
                       amount: {
                           required: true,
                           min: 1,
                           number: true
                       },  
                       service_start_from: {
                           required: true,
                           dateTime: true
                       },
                       payment_url: { 
                        required: true,   
                        url: true
                       }
                               
                   },
                   messages:{
                       // candidate_name:{
                       //     required: "Please enter candidate name."
                       // },
                       subscription_id:{
                           required: "Please select service."
                       },
                       candidate_email:{
                           required: "Please enter valid email.",
                           email: "Please enter valid email."
                       },
                       amount:{
                           required: "Please enter amount.",
                           min: "Amount must be greater than 0"
                       },
                       service_start_from:{
                           required: "Please select date from calendar."
                       },
                       payment_url: { 
                        required: "Please enter payment url.",   
                        url: "Please enter valid url."
                       }
                    
                   }
               });
       });
    },
    submitValidateForm : function()
    {        
        $(document).on('click','.confirm-submission',function(){ console.log('submit');
            $("#subscription-form").submit();
        });
    },
    makeVisibleProposeDate : function($this)
    {
        let simulateId = 3;
        let selectedService = $this.val();
        var date = $('#date_service').val();
        $('#service_start_from').prop('readonly',false);
        $('#service_start_from').val('');
        $('#service_start_from').prop('readonly',true);
        if(simulateId == selectedService){
            $('#service_start_from').val(date);
            $('.proposed-date').fadeIn();
        }else{
            $('.proposed-date').fadeOut();
        }
    }
}

//Post.init();
  