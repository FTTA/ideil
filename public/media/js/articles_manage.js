'use strict';

$(document).ready(function() {
    $('.published').click(function() {

        var lSelf = $(this);
        var lData = {
            'is_published': lSelf.data('is-published'),
            '_token':       $('input[name="_token"]').val(),
            '_method':      'PUT'
        };

        lSelf.simpleSend(
            lData,
            '/ajax/articlesajax/published/'+lSelf.data('article-id'),
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Статус публікації змінено');
                location.reload();
            }
        );
    });
});
