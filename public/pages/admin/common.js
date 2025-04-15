var Common = {
    init: function(){
        Post.resetForm();
    },
    resetForm:function(myFormId){
        $( ".reste-form-class" ).on( "click", function() {
            var myForm = document.getElementById(myFormId);
            
            for (var i = 0; i < myForm.elements.length; i++)
            {  
                let type = myForm.elements[i].type;
                if (type == 'text')
                {  
                    myForm.elements[i].value = 'ddddd';
                    //myForm.elements[i].selectedIndex = 0;
                }
            }
        });
        
    }
   
}

Post.init();