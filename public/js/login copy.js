$(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();

        $(this).find('input[type=text], input[type=password], input[type=checkbox]').each(function() {
            if($(this).val().length === 0 || ($(this).is(':checkbox') && !$(this).is(':checked'))) {
                $(this).closest('label').addClass('error');
            } else {
                $(this).closest('label').removeClass('error');
            }
        });
    });

    $('input[type=text], input[type=password], input[type=checkbox]').on('focusout', function() {
        if($(this).val().length === 0) {
            $(this).closest('label').addClass('error');
        } else {
            $(this).closest('label').removeClass('error');
        }
    });

    $('form[name=login]').on('submit', function(e) {
        const $email =  $(this).find('input[name=email');
        const $password = $(this).find('input[name=password');
        const email = $email.val();
        const password = $password.val();

        if(email.length === 0 || password.length === 0) {
            return false;
        }

        $.post(
            '?controller=login',
            {
                email: email,
                password: password,
            },
            data => {
                if(data.success === true) {
                    window.location = '?';
                } else {
                    if(data.mustVerify === true) {
                        $('form[name=verify]').data('email', email);

                        showForm('verify-email');
                    } else {
                        $(this).find('p.error').text('The email or password you entered is incorrect.');
                    }
                }
            }
        );
    });

    $('form[name=signup]').on('submit', function(e) {
        const $email =  $(this).find('input[name=email]');
        const $name =  $(this).find('input[name=name]');
        const $password = $(this).find('input[name=password]');
        const $rePassword = $(this).find('input[name=repassword]');
        const $agree = $(this).find('input[name=agree]');
        const email = $email.val();
        const name = $name.val();
        const password = $password.val();
        const rePassword = $rePassword.val();
        const agree = $agree.is(':checked');

        if(email.length === 0 ||
           name.length === 0 ||
           password.length === 0 ||
           rePassword.length === 0 ||
           !agree) {
            return false;
        }

        /*
        if(!email.match(/^.*@amazon.com\s*$/)) {
            $(this).find('p.error').text("You must use your Amazon email address");

            return false;
        }*/

        if(password.length < 6) {
            $(this).find('p.error').text("Password must be at least 8 characters long");

            return false;
        }

        if(password !== rePassword) {
            $(this).find('p.error').text("Passwords don't match");

            return false;
        }

        $.post(
            '?controller=login&action=signup',
            {
                email: email,
                name: name,
                password: password,
            },
            data => {
                console.log(data);
                if(data.success === true) {
                    $('form[name=verify]').data('email', email);

                    showForm('verify-email');
                } else {
                    if(data.emailExists === true) {
                        $(this).find('p.error').text("An account with that email address already exists");
                    }
                }
            }
        );
    });

    $('form[name=verify]').on('submit', function(e) {
        const email = $(this).data('email');
        const code = $(this).find('input[name=code]').val();

        if(email.length === 0 || code.length === 0) {
            return false;
        }

        $.post(
            '?controller=login&action=verify',
            {
                email: email,
                code: code,
            },
            data => {
                console.log(data);
                if(data.success === true) {
                    $(this).addClass('verified');
                } else if(data.hasExpired === true) {
                    window.location = '?';
                } else {
                    $(this).find('p.error').text('The code you entered is incorrect.');
                }
            }
        );
    });

    $('a[name=signup]').click(function() {
        $('main > div').css('display', 'none');
        $('#signup').css('display', 'block');
        clearFields($('#signup'));
    });

    $('a[name=login]').click(function() {
        $('main > div').css('display', 'none');
        $('#login').css('display', 'block');
        clearFields($('#login'));
    });

    $('a[name=forgot-password]').click(function() {
        $('main > div').css('display', 'none');
        $('#forgot-password').css('display', 'block');
        clearFields($('#forgot-password'));
    });

    function showForm(name) {
        $('div.form').css('display', 'none');
        $(`#${name}`).css('display', 'block');
        $(`#${name}`).removeClass();
        clearFields($(`#${name}`));
    }

    function clearFields($form) {
        $form.find('input[type=text], input[type=password]').val('');
        $form.find('input[type=checkbox').prop('checked', false);
        $form.find('label').removeClass('error');
    }
});