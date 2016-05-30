'use strict';

$(document).ready(function() {
    $('#sign_in').click(function() {
        if (!$('#login_form').valid())
            return;

        var lData = $('#login_form').dataGather('form_to_send');

        lData['_token'] = $('#csrf_token').val();

        $('#sign_in').simpleSend(
            lData,
            '/ajax/generalajax/signin',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }

                location.reload();
                return;
            }
        );
    });

    $('#sign_out').click(function() {

        var lData = {'_token': $('#csrf_token').val()};

        $('#sign_out').simpleSend(
            lData,
            '/ajax/generalajax/signout',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }

                location.reload();
                return;
            }
        );
    });
});