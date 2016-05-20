'use strict';
$(document).ready(function() {
    $('#article_form').validate({
        rules: {
            'title': {required: true, minlength: 3},
            'text':  {required: true, minlength: 20}
        },
        messages: {
            'title': {required: 'Назва порожня', minlength: 'Назва надто коротка'},
            'text': {required: 'Текст статті порожній', minlength: 'Текст статті надто короткий'},
        },

        //errorPlacement: function (error, elem) {
        //    errorMarkup(error, elem);
        //},

        errorClass: 'validation_error',

        validClass: 'validation_success',
    });

    $('#add_article').click(function() {
        if (!$('#article_form').valid())
            return;

        var lData = $('#article_form').dataGather('form_to_send');

        lData['_token'] = $('#csrf_token').val();

        $(this).simpleSend(
            lData,
            '/ajax/articlesajax/add',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Стаття додана успішно');
                //location.reload();
            }
        );
    });

    $('#edit_article').click(function() {
        if (!confirm('Ви впевнені, що хочете виконати дану дію?'))
            return;

        if (!$('#article_form').valid())
            return;

        var lData = $('#article_form').dataGather('form_to_send');

        lData['_token'] = $('#csrf_token').val();

        $(this).simpleSend(
            lData,
            '/ajax/articlesajax/edit',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Стаття була успішно відредаговано');
                location.reload();
            }
        );
    });

    $('#delete_article').click(function() {
        if (!confirm('Ви впевнені, що хочете виконати дану дію?'))
            return;

        var lData = {
            'article_id': $(this).data('article-id'),
            '_token':     $('#csrf_token').val()
        };

        $(this).simpleSend(
            lData,
            '/ajax/articlesajax/delete',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Стаття була успішно видалена');
                //location.reload();
            }
        );
    });
});
