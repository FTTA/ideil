'use strict';

$(document).ready(function() {
    $('.published').click(function() {

        var lSelf = $(this);
        var lData = {
            'article_id':   lSelf.data('article-id'),
            'is_published': lSelf.data('is-published'),
            '_token':       $('input[name="_token"]').val()
        };

        lSelf.simpleSend(
            lData,
            '/ajax/articlesajax/published',
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
