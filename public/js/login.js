$(function() {
    $(document).on('submit', 'form', function(e) {
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
                        verify(email)
                        .then(() => {
                            $('form[name=verify]').addClass('verified');
                        })
                        .catch((result) => {
                            if(result.codeExpired) {
                                window.location = window.location;
                            }
                        });
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
                    verify(email)
                    .then(() => {
                        $('form[name=verify]').addClass('verified');
                    })
                    .catch((result) => {
                        if(result.codeExpired) {
                            window.location = window.location;
                        }
                    });
                } else {
                    if(data.emailExists === true) {
                        $(this).find('p.error').text("An account with that email address already exists");
                    }
                }
            }
        );
    });


    $('form[name=forgot-password]').on('submit', function(e) {
        const email = $(this).find('input[name=email]').val();

        if(email.length === 0) {
            return false;
        }

        verify(email)
        .then(() => {
            resetPassword(email);
        })
        .catch((result) => {
            if(result.invalidEmail) {
                $(this).find('p.error').text("Email is invalid");
            } else if(result.codeExpired) {
                window.location = window.location;
            }
        });
    });

    function resetPassword(email) {
        showForm('reset-password');

        $('form[name=reset-password]').off('submit').on('submit', function() {
            const password = $(this).find('input[name=password]').val();
            const rePassword = $(this).find('input[name=repassword]').val();

            if(password.length === 0 || rePassword.length === 0) {
                return false;
            }

            if(password.length < 6) {
                $(this).find('p.error').text("Password must be at least 8 characters long");

                return false;
            }

            if(password !== rePassword) {
                $(this).find('p.error').text("Passwords don't match");

                return false;
            }

            $.post(
                '?controller=login&action=resetPassword',
                {
                    email: email,
                    password: password
                },
                data => {
                    console.log(data);
                    if(data.success === true) {
                        $(this).addClass('reset');
                    }
                }
            );
        });
    }



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
        $form.find('input[type=text], input[type=password], input[type=number]').val('');
        $form.find('input[type=checkbox').prop('checked', false);
        $form.find('label').removeClass('error');
        $form.find('p.error').text('');
    }

    function verify(email) {
        return new Promise((resolve, reject) => {
            $.get(
                '?controller=login&action=verify',
                {email: email},
                data => {
                    if(data.success === true) {
                        resolve();
                    } else {
                        reject({invalidEmail: true});
                    }
                }
            );
        })
        .then(() => {
            return new Promise((resolve, reject) => {
                showForm('verify-email');

                $('#verify-email form').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    const code = $(this).find('input[name=code]').val();

                    if(code.length === 0) {
                        return false;
                    }

                    $.post(
                        '?controller=login&action=verify',
                        {
                            email: email,
                            code: code,
                        },
                        data => {
                            if(data.success === true) {
                                resolve();
                            } else if(data.hasExpired === true) {
                                reject({codeExpired: true});
                            } else {
                                $(this).find('p.error').text('The code you entered is incorrect.');
                            }
                        }
                    );
                });
            });
        });
    }
});