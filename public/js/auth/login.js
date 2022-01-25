formValidation = {
    rules:{
        email:{required:true,email:true},
        password:{required:true}
    },
    messages:{
        email:{
            required:"Email is required",
            email: "Email field must be a email"
        },
        password:{
            required:"Password is required"
        }
    }
}


$(function(){
    $('#frmLogin').validate(formValidation);
});
