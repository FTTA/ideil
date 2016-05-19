'use strict';

$(document).ready(function() {

    var uploader_1 = new fileUploader({
        entry_field:  '#user_image',
        container:    '#container',
        name_prefix:  'user_img',
        template:     '#uploader_template',
        handler_file: '/fileuploader/upload',
        counter:      $('.old_image').length,
        limit:        1,
        additionalData: {'_token': $('input[name="_token"]').val()},
        progress_viewer: function(status) {
            /*
            status.bytes.total
            status.bytes.uploaded
            status.percents
            */

            //$('#progress_bar').val(status.percents);
        }
    });

    $('.delete_avatar').click(function() {
        $(this).closest('.old_image').hide();
        $(this).siblings('input').addClass('img_to_send');
        uploader_1.counterDecrement();
    });

    $('#user_image').change(function() {
        uploader_1.uploadFile();
    });

    $('#show_password_form').click(function() {
        $('#password_form').toggle();
    });

    $('#password_form').validate({
        rules: {
            'password':         {required: true, minlength: 6},
            'password_new':     {required: true, minlength: 6},
            'password_confirm': {equalTo: '#password_confirm'},
        },
        messages: {
            'password': {minlength: 'Пароль надто короткий'},
            //'email':    {required: 'Email адреса порожня', email: 'Email адреса хибна'},
            'password': {minlength: 'Пароль надто короткий'},
            'password_confirm': {equalTo: 'Паролі не співпадають'}
        },

        //errorPlacement: function (error, elem) {
        //    errorMarkup(error, elem);
        //},

        errorClass: 'validation_error',

        validClass: 'validation_success',
    });

    $('#change_password').click(function() {
        if (!$('#password_form').valid())
            return;

        var lData = $('#password_form').dataGather('form_to_send');

        lData['_token'] = $('input[name="_token"]').val();

        $(this).simpleSend(
            lData,
            '/ajax/usersajax/changepass',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Ok');
                //location.reload();
            }
        );
    });


    $('#change_data').click(function() {

        var lData = $('#edit_form').dataGather('form_to_send img_to_send');

        lData['_token'] = $('input[name="_token"]').val();

        $(this).simpleSend(
            lData,
            '/ajax/usersajax/edit',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Ok');
                //location.reload();
            }
        );
    });

});
