var Post = {
    init: function(){
        Post.list();
    },
    list:function(){
        $(document).ready(function() {
             //DATEPICKER
             $( "#start_date" ).datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: 0,
                onSelect: function(selected) {
                $("#end_date").datepicker("option","minDate", selected)
               }
            });
            $('#end_date').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: 0,
                onSelect: function(selected) {
                $("#start_date").datepicker("option","maxDate", selected)
                }
            });

            //FOR DOWNLOAD XLSX
            $( ".download-payment" ).on( "click", function() {
                $('#paymentId').submit();
            });

            
        });
    }
}

//Post.init();