'use strict';

$(document).ready(function() {
    $('.blocked').click(function() {

        var lSelf = $(this);
        var lData = {
            'comment_id': lSelf.data('comment-id'),
            'is_blocked': lSelf.data('is-blocked'),
            '_token':     $('#csrf_token').val()
        };

        lSelf.simpleSend(
            lData,
            '/ajax/commentsajax/blocking',
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
