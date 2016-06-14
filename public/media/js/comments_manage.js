'use strict';

$(document).ready(function() {
    $('.blocked').click(function() {

        var lSelf = $(this);
        var lData = {
            'is_blocked': lSelf.data('is-blocked'),
            '_token':     $('#csrf_token').val(),
            '_method':    'PUT'
        };

        lSelf.simpleSend(
            lData,
            '/ajax/commentsajax/blocking/'+lSelf.data('comment-id'),
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }
                alert('Змінено');
                location.reload();
            }
        );
    });
});
