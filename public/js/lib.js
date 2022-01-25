/****** GLOBAL VARS ******/
var
    timeOut;
/****** GLOBAL VARS ******/

lib = {
    /****** ANIMATIONS ******/
    // LOADER
    loader: {
        hide: function () {
            setTimeout(() => { $('.loaderContainer').fadeOut(); }, 1000);

        },
        show: function () {
            $('.loaderContainer').css({ 'display': 'flex' });
        },
    },

    // ALERTS
    showSuccessAlert: function (title, message, reload = false) {
        Swal.fire({
            icon: "success",
            title: title,
            text: message,
            confirmButtonText: "Ok",
            confirmButtonColor: '#007bff'
        }).then((res) => {
            if (reload && res.isConfirmed) {
                window.location.reload();
            }
        });
    },
    showErrorAlert: function (title, message) {
        Swal.fire({
            icon: "warning",
            title: title,
            text: message,
            confirmButtonText: "Ok",
            confirmButtonColor: '#dc3545'
        });
    },
    showConfirmAlert: function (el, title, text, html, confirm, cancel, params, url, proc) {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            html: html,
            showCancelButton: true,
            cancelButtonText: cancel,
            cancelButtonColor: '#dc3545',
            confirmButtonText: confirm,
            confirmButtonColor: '#007bff'
        }).then((res) => {
            proc(params, url, el, res.isConfirmed);
        });
    },
    /****** ANIMATIONS ******/




    /****** FUNCTIONS ******/
    // Datatables
    createDataTables: function () {
        if ($('table').length > 0) {
            if ($.fn.dataTable.isDataTable('table')) { $('table').DataTable().destroy(); }

            tblExceptions = ["tblHistory", "tblcategoryBooks"];

            $.each($('table'), function (i, val) {
                if (tblExceptions.indexOf($(this).prop('id')) == -1) {
                    $($(this)).DataTable({
                        "scrollX": true
                    });
                }
            });
        }
    },
    // Textareas
    textAreaCounter: function () {
        $.each($('textarea'), function (i, val) {
            if (!$(this).hasClass('swal2-textarea')) {
                $textCounter = '<div class="textCounterContainer text-right">' +
                    '<small>' +
                    '<span class="textCounter">0</span>/' +
                    '<span class="maxTextCounter">' + $(this).attr('maxlength') + '</span>' +
                    '</small>' +
                    '</div>';
                $(this).parent().append($textCounter);
            }
        });
    },
    /****** FUNCTIONS ******/



};






/****** LIBS SETTINGS ******/
// JQUERY VALIDATION
$.validator.addMethod("regex", function (value, element, regexp) {
    return this.optional(element) || regexp.test(value);
}, "Verify data structure");
$.validator.addMethod("date", function (value, element) {
    var
        check = false,
        regex = /^\d{4}\-\d{1,2}\-\d{1,2}$/;
    if (regex.test(value)) {
        var
            date = value.split('-'),
            d = parseInt(date[2], 10),
            m = parseInt(date[1], 10),
            a = parseInt(date[0], 10),
            dateFormat = new Date(a, m - 1, d);
        check = ((dateFormat.getFullYear() === a) && (dateFormat.getMonth() === (m - 1)) && (dateFormat.getDate() === d));
    }

    return this.optional(element) || check;
}, "This is no a date format");

// AJAX
$.ajaxSetup({
    beforeSend: function () { lib.loader.show(); },
    complete: function () { lib.loader.hide(); },
    error: function () { lib.loader.hide(); }
});
/****** LIBS SETTINGS ******/





/****** EVENTS ******/
// On DOM ready
$(function () {
    lib.loader.hide();
    lib.textAreaCounter();
    lib.createDataTables();
});

// On submit forms show loader
$('form').on('submit', function () { lib.loader.show(); });

// On keypress update text length
$(document).on('keydown', 'textarea', function () {
    var len = $(this).val().length;
    $(this).parent().find('.textCounterContainer').find('small').find('.textCounter').html(len);
});

$(document).on('focus', '.select2-selection', function () {
    $(".select2-container").siblings('select:enabled').select2('open');
    $('.select2-search__field').focus();
});
/****** EVENTS ******/

