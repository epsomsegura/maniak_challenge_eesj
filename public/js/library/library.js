objFunctions = {
    formValidation : {
        rules:{
            book_id:{required:true},
            user_id:{required:true}
        },
        messages:{
            book_id:{
                required:"Book is required"
            },
            user_id:{
                required:"Reader is required"
            }
        }
    }
};

$(function(){
    $('#frmSave').validate(objFunctions.formValidation);
});

$(document).on('click','.btnBorrow',function(){
    var info = $(this).data('info');
    $('#mdlBorrow #book_id').val($(this).data('id'));
    $('#mdlBorrow #bookName').html(info.name);
});

$(document).on('click','.btnReturn',function(){
    var info = $(this).data('info');
    $('#mdlReturn #library_id').val($(this).data('id'));
    $('#mdlReturn #bookName').html(info.name);
    $('#mdlReturn #readerName').html(info.book_user.name);
    $('#mdlReturn #borrowedDate').html(info.book_library[0].borrow_date);
});

$(document).on('click','.btnHistory',function(){
    var
        hist = $(this).data('history'),
        book = hist.name,
        category = hist.book_category.name,
        $objTable = "";

    if((hist.book_library.length) > 0){
        $.each(hist.book_library,function(j,val){
            $objTable += "<tr>";
            $objTable += "<td>"+book+"</td>";
            $objTable += "<td class=\"text-center\">"+category+"</td>";
            $objTable += "<td>"+val.library_user.name+"</td>";
            $objTable += "<td class=\"text-center\">"+val.borrow_date+"</td>";
            $objTable += "<td class=\"text-center\">"+(val.return_date == null ? "-" : val.return_date)+"</td>";
            $objTable += "</tr>";
        });

    }
    $("#tblHistory tbody").html($objTable);
});


$('#btnSave').on('click',function(){
    $('#saveTrigger').trigger('click');
});
$('#btnReturn').on('click',function(){
    $('#saveTriggerR').trigger('click');
});
