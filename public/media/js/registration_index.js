'use strict';

$(document).ready(function() {

    $('#registration_form').validate({
        rules: {
            'name':   {required: true, minlength: 2},
            'email':      {required: true, email: true},
            'password':   {required: true, minlength: 6},
            'password_confirm': {required: true, equalTo: '#password'},
        },
        messages: {
            'name': {required: 'Введіть ім\'я користувача будь ласка', minlength: 'Ім\'я закоротке'},
            'email':    {required: 'Email адреса порожня', email: 'Email адреса хибна'},
            'password': {required: 'Insert password please', minlength: 'Password is to short'},
            'password_confirm': {required: 'Repeat password please', equalTo: 'Passwords mismatch'}
        },

        //errorPlacement: function (error, elem) {
        //    errorMarkup(error, elem);
        //},

        errorClass: 'validation_error',

        validClass: 'validation_success',
    });

    $('#registration').click(function() {
        if (!$('#registration_form').valid())
            return;

        var lData       = $('#registration_form').dataGather('form_to_send');
        lData['_token'] = $('#csrf_token').val();

        $('#registration').simpleSend(
            lData,
            '/ajax/generalajax/registration',
            function (data) {
                if (!sys_funcs.responceStatus(data)) {
                    alert(sys_funcs.responceGetError(data))
                    return;
                }

                alert('Успшно. Тепер ви можете здійснити вхід у систему');
                //location.reload();
            }
        );
    });
});
