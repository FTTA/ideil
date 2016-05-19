'use strict';

$(document).ready(function() {
    $('#category_form').validate({
        rules: {
            'title': {required: true, minlength: 3},
        },
        messages: {
            'title': {required: 'Назва порожня', minlength: 'Назва надто коротка'},
        },

        //errorPlacement: function (error, elem) {
        //    errorMarkup(error, elem);
        //},

        errorClass: 'validation_error',

        validClass: 'validation_success',
    });

    $('#add_category').click(function() {
        if (!$('#category_form').valid())
            return;

        var lData = $('#category_form').dataGather('form_to_send');

        lData['_token'] = $('#csrf_token').val();

        $(this).simpleSend(
            lData,
            '/ajax/categories/add',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Категорія додана успішно');
                //location.reload();
            }
        );
    });

    $('#edit_category').click(function() {
        if (!confirm('Ви впевнені, що хочете виконати дану дію?'))
            return;

        if (!$('#category_form').valid())
            return;

        var lData = $('#category_form').dataGather('form_to_send');

        lData['_token'] = $('#csrf_token').val();

        $(this).simpleSend(
            lData,
            '/ajax/categories/edit',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Категорія була успішно відредаговано');
                location.reload();
            }
        );
    });

    $('#delete_category').click(function() {
        if (!confirm('Ви впевнені, що хочете виконати дану дію?'))
            return;

        var lData = {
            'category_id': $(this).data('category-id'),
            '_token':      $('#csrf_token').val()
        };

        $(this).simpleSend(
            lData,
            '/ajax/categories/delete',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Категорія була успішно видалена');
                //location.reload();
            }
        );
    });
});
