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
            '/ajax/categoriesajax/add',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Категорія додана успішно');
                document.location = '/categories/index';
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
            '/ajax/categoriesajax/edit',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Категорія була успішно відредаговано');
                document.location = '/categories/index';
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
            '/ajax/categoriesajax/delete',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Категорія була успішно видалена');
                document.location = '/categories/index';
                //location.reload();
            }
        );
    });
});
