var
    data_id = null,
    objFunctions={
        prepareModal:function(insert,params){
            objFunctions.resetModal();
            $('#mdlForm .modal-title').html(insert ? 'New category' : 'Edit categoty');
            $('#mdlForm #name').focus();
            var url = path;

            if(!insert){
                $('#mdlForm #name').val(params.name);
                $('#mdlForm #description').val(params.description).trigger('keydown');
                $('#frmSave').append('<input type="hidden" name="_method" value="PUT">');
                $('#frmSave').append('<input type="hidden" name="id" value="'+data_id+'">');
            }
            else{
                $('#frmSave').attr('action',url+'/categories');
            }
        },
        resetModal:function(){
            $("#frmSave")[0].reset();
            $('#mdlForm #name').val('');
            $('#mdlForm #description').val('');
            $('#frmSave input[name="_method"]').remove();
            $('#frmSave input[name="id"]').remove();
            $('#frmSave').attr('action','#').validate(objFunctions.formValidation).resetForm();
            $('#mdlForm #status').val("1");
        },
        formValidation: {
            rules:{
                name:{required:true},
                description:{required:true,maxlength:255}
            },
            messages:{
                name:{
                    required: "Name is required"
                },
                email:{
                    required: "Description is required",
                    maxlength: "Description must be 255 characters maximum"
                }
            }
        }
    };

$(function(){
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
        title = "Delete category",
        text = "Really want to delete this category?",
        confirm = "Delete",
        params = {
            _token: $('input[name="_token"]').val(),
            id: $(this).data('id'),
            _method: 'DELETE',
        },
        url = path+'/categories';

    lib.showConfirmAlert($(this),title,text,null,confirm,'Cancel',params,url,del);
});
$('#mdlForm').on('hidden.bs.modal', function (e) {objFunctions.resetModal();});


$(document).on('click','.btnBooks',function(){
    var
        list = $(this).data('info'),
        category = list.name,
        $objTable = "";

    if((list.category_books.length)>0){
        $.each(list.category_books,function(i,val){
            $objTable += "<tr>";
            $objTable += "<td>"+val.name+"</td>"
            $objTable += "<td>"+category+"</td>"
            $objTable += "<td class=\"text-center\">"+val.publication_date+"</td>"
            $objTable += "</tr>";
        });

    }
    $('#tblcategoryBooks tbody').html($objTable);

});


$(document).on('click','#btnSave',function(){
    $('#saveTrigger').trigger('click');
});
