var
    data_id = null,
    objFunctions={
        prepareModal:function(insert,params){
            objFunctions.resetModal();
            $('#mdlForm .modal-title').html(insert ? 'New user' : 'Edit user');
            $('#mdlForm #name').focus();
            var url = path;

            if(!insert){
                $('#mdlForm #status').val("1");
                $('#mdlForm #profile_id').val(params.profile_id);
                $('#mdlForm #name').val(params.name);
                $('#mdlForm #email').val(params.email);
                $('#chngPassword').prop('checked',false);
                $('#chngPasswordContainer').show();
                $('#passwordContainer').hide();
                $('#frmSave').append('<input type="hidden" name="_method" value="PUT">');
                $('#frmSave').append('<input type="hidden" name="id" value="'+data_id+'">');
            }
            else{
                $('#chngPassword').prop('checked',true);
                $('#chngPasswordContainer').hide();
                $('#passwordContainer').show();
                $('#frmSave').attr('action',url+'/users');
            }
        },
        resetModal:function(){
            $("#frmSave")[0].reset();
            $('#mdlForm #name').val('');
            $('#mdlForm #email').val('');
            $('#mdlForm #profile_id').val('');
            $('#mdlForm #password').val('');
            $('#mdlForm #repeat_password').val('');
            $('#mdlForm #chngPassword').prop('checked',false);
            $('#frmSave input[name="_method"]').remove();
            $('#frmSave input[name="id"]').remove();
            $('#frmSave').attr('action','#').validate(objFunctions.formValidation).resetForm();
            $('#mdlForm #status').val("1");
        },
        formValidation: {
            rules:{
                profile_id:{required:true},
                name:{required:true},
                email:{required:true,email:true},
                password:{required:'#chngPassword:checked',minlength:8},
                repeat_password:{required:'#chngPassword:checked',minlength:8,equalTo:'#password'}
            },
            messages:{
                profile_id:{
                    required:"Profile type is required"
                },
                name:{
                    required: "Name is required"
                },
                email:{
                    required: "Email is required",
                    email: "This is no a email"
                },
                password:{
                    required:"Password is required",
                    minlength:"The password must be at least 8 characters long"
                },
                repeat_password:{
                    required: "Repeat password is required",
                    minlength: "The repeat password must be at least 8 characters long",
                    equalTo: "Passwords are not equals"
                }
            }
        }
    };

$(function(){
    $('#frmSave').validate(objFunctions.formValidation);
});

$(document).on('change','#chngPassword',function(){
    if($(this).is(':checked') && data_id != null){
        $('#passwordContainer').show();
    }
    else{
        $('#passwordContainer').hide();
    }
});

$(document).on('click','#btnNew',function(){
    data_id = null;
    objFunctions.prepareModal(true,null);
});
function status(params,url,el,confirmed){
    if(confirmed){
        $.post(url,params)
        .done(function(resp){
            if(params.status == 1){
                el.html('Active').removeClass('btn-danger').addClass('btn-success');
                el.closest('tr').find('td:eq(3)').find('.btnEdit').removeClass('disabled');
                el.closest('tr').find('td:eq(3)').find('.btnDelete').removeClass('disabled');
                el.closest('tr').find('td:eq(3)').find('.btnReports').removeClass('disabled');
            }
            else{
                el.html('Inactive').removeClass('btn-success').addClass('btn-danger');
                el.closest('tr').find('td:eq(3)').find('.btnEdit').addClass('disabled');
                el.closest('tr').find('td:eq(3)').find('.btnDelete').addClass('disabled');
                el.closest('tr').find('td:eq(3)').find('.btnReports').addClass('disabled');
            }
            el.data('estatus',params.status);

            lib.showSuccessAlert("Status updated","Status changed successfully");
        })
        .fail(function(error){ lib.showErrorAlert(error.errors,""); });
    }
    else{
        if(params.estatus == 1)
            el.html('Inactive').removeClass('btn-success').addClass('btn-danger').attr('data-estatus',1);
        else
            el.html('Active').removeClass('btn-danger').addClass('btn-success').attr('data-estatus',0);
    }
}
$(document).on('click','.btnStatus',function(){
    var
        title = ($(this).data('estatus') == 0) ? "Activate user" : "Deactivate user",
        text = ($(this).data('estatus') == 0) ? "Really want to activate this user?" : "Really want to deactivate this user?",
        confirm = ($(this).data('estatus') == 0) ? 'Activate' : 'Deactivate',
        params = {
            _token: $('input[name="_token"]').val(),
            _method: 'PATCH',
            id: $(this).data('id'),
            status: ($(this).data('estatus') == 1) ? 0 : 1
        },
        url = path+'/users';

    lib.showConfirmAlert($(this),title,text,null,confirm,'Cancel',params,url,status);
});
$(document).on('click','.btnEdit',function(){
    data_id = $(this).data('id');
    objFunctions.prepareModal(false,$(this).data('all'));
});
// Al hacer clic en el botón Eliminar
function del(params,url,el,confirmed){
    if(confirmed){
        $.post(url,params)
        .done(function(resp){
            el.closest('tr').remove();
            lib.showSuccessAlert("Data deleted successfully","Data deleted successfully");
        })
        .fail(function(error){ lib.showErrorAlert(error.errors,""); });
    }
}
$(document).on('click','.btnDelete',function(){
    var
        title = "Delete user",
        text = "Really want to delete this user?",
        confirm = "Delete",
        params = {
            _token: $('input[name="_token"]').val(),
            id: $(this).data('id'),
            _method: 'DELETE',
        },
        url = path+'/users';

    lib.showConfirmAlert($(this),title,text,null,confirm,'Cancel',params,url,del);
});
$('#mdlForm').on('hidden.bs.modal', function (e) {objFunctions.resetModal();});


$(document).on('click','.btnHistory',function(){
    var
        hist = $(this).data('history'),
        $objTable = "";
    if((hist.user_library.length) > 0){
        $.each(hist.user_library,function(j,val){
            $objTable += "<tr>";
            $objTable += "<td>"+val.library_book.name+"</td>";
            $objTable += "<td class=\"text-center\">"+val.library_book.book_category.name+"</td>";
            $objTable += "<td class=\"text-center\">"+val.borrow_date+"</td>";
            $objTable += "<td class=\"text-center\">"+(val.return_date == null ? "-" : val.return_date)+"</td>";
            $objTable += "</tr>";
        });

    }
    $("#tblHistory tbody").html($objTable);
});


$(document).on('click','#btnSave',function(){
    $('#saveTrigger').trigger('click');
});
