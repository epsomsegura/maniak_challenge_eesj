var
    data_id = null,
    objFunctions={
        prepareModal:function(insert,params){
            objFunctions.resetModal();
            $('#mdlForm .modal-title').html(insert ? 'New book' : 'Edit book');
            $('#mdlForm #name').focus();
            var url = path;

            if(!insert){
                $('#mdlForm #name').val(params.name);
                $('#mdlForm #category_id').val(params.category_id);
                $('#mdlForm #publication_date').datepicker('setDate',params.publication_date);
                $('#frmSave').append('<input type="hidden" name="_method" value="PUT">');
                $('#frmSave').append('<input type="hidden" name="id" value="'+data_id+'">');
            }
            else{
                $('#frmSave').attr('action',url+'/books');
            }
        },
        resetModal:function(){
            $("#frmSave")[0].reset();
            $('#mdlForm #name').val('');
            $('#mdlForm #category_id').val('');
            $('#mdlForm #publication_date').val('');
            $('#frmSave input[name="_method"]').remove();
            $('#frmSave input[name="id"]').remove();
            $('#frmSave').attr('action','#').validate(objFunctions.formValidation).resetForm();
            $('#mdlForm #status').val("0");
        },
        formValidation: {
            rules:{
                name:{required:true},
                category_id:{required:true},
                publication_date:{required:true,date:true}
            },
            messages:{
                name:{
                    required: "Name is required"
                },
                category_id:{
                    required: "Category is required"
                },
                publication_date:{
                    required: "Publication date is required",
                    date: "This is no a date format"
                }
            }
        }
    };

$(function(){
    $('#category_id').select2({placeholder:'Select category',dropdownParent:$('#mdlForm')});
    $('.datepicker').datepicker({format:'yyyy-mm-dd'});
    $('#frmSave').validate(objFunctions.formValidation);
});

$(document).on('click','#btnNew',function(){
    data_id = null;
    objFunctions.prepareModal(true,null);
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
        title = "Delete book",
        text = "Really want to delete this book?",
        confirm = "Delete",
        params = {
            _token: $('input[name="_token"]').val(),
            id: $(this).data('id'),
            _method: 'DELETE',
        },
        url = path+'/books';

    lib.showConfirmAlert($(this),title,text,null,confirm,'Cancel',params,url,del);
});
$('#mdlForm').on('hidden.bs.modal', function (e) {objFunctions.resetModal();});

function match(value){
}


$(document).on('click','#btnSave',function(){
    $('#saveTrigger').trigger('click');
});
