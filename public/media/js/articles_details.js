'use strict';
$(document).ready(function() {
    $('#comment_form').validate({
        rules: {
            'text':  {required: true, minlength: 5}
        },
        messages: {
            'text': {required: 'Коментар порожній', minlength: 'Коментар надто короткий'},
        },

        //errorPlacement: function (error, elem) {
        //    errorMarkup(error, elem);
        //},

        errorClass: 'validation_error',

        validClass: 'validation_success',
    });

    $('#add_comment').click(function() {
        if (!$('#comment_form').valid())
            return;

        var lData = $('#comment_form').dataGather('form_to_send');

        lData['_token'] = $('input[name="_token"]').val();

        $(this).simpleSend(
            lData,
            '/ajax/commentsajax/add',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Коментарій доданий успішно');
                location.reload();
            }
        );
    });
});
