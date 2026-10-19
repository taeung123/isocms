<link rel="stylesheet" href="{$URL_CSS}/homepagenew.css?v={$upd_version}"/>
<main id="signin_main">
    <section class="signin_form">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="border_iconi">
                    <i id="icon" class="fa-regular fa-face-smile fa-2xl" style="color: #00818a;"></i>
                    <i id="icon-awesome" class="fa-regular fa-face-hand-peeking fa-2xl"
                       style="display: none;color: #00818a;"></i>
                </div>
            </div>
            <h2 class="txt_signin">{$core->get_Lang('Log in and get exploring')}</h2>
            <h5 class="txt_des_signin">{$core->get_Lang('One single account to explore everywhere and manage your bookings')}.
                <br>
                {$core->get_Lang('Quick andeasy')} !
            </h5>
            <div class="form_email_pass d-flex justify-content-center align-items-center"
                 style="flex-direction: column">
                <form id="signformM_form" method="post" class="w-100" action="" enctype="multipart/form-data"
                      class="AppForm signformM_form" style="max-width: 530px">
                    <div class="form-group form_mailpass">
                        <div class="addon_form inner-addon left-addon">
                            <input type="text" name="USER" autocomplete="off" id="emaillogin" class="form-control"
                                   placeholder=" " required
                                   onblur="resetIcon()">
                            <label for="email" class="form-label txt_emailpass">{$core->get_Lang('Email')}</label>
                        </div>
                        <div class="error_tip" id="error_email" style="display: none;"></div>
                    </div>
                    <div class="form-group form_mailpass">
                        <div class="addon_form inner-addon left-addon">
                            <input type="password" name="PASSWORD" autocomplete="off" class="form-control" id="pwd"
                                   placeholder=" " required
                                   onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()">
                            <label for="password"
                                   class="form-label txt_emailpass">{$core->get_Lang('Enter password')}</label>
                            <span class="toggle-password" onclick="togglePassword()">
                                <i id="toggleIcon" class="fa-regular fa-eye"></i>
                            </span>
                        </div>
                        <div class="error_tip" id="error_password" style="display: none;"></div>
                    </div>
                    <button type="submit"
                            class="btn w-100 btn_login btn-cmd-submit">{$core->get_Lang('Sign in')}</button>
                    <input type="hidden" id="return_url" name="return_url" value="{$return_url}"/>
                    <input type="hidden" name="submit" value="Login"/>
                    <div id="error_tip" class="error_tip"></div>

                    <div class="mt-4 mb-3 {if $deviceType !="phone"}d-flex justify-content-between flex-wrap{/if}">
                        <div class="button_forgot">
                            <a id="ForgotPassLink" href="javascript:void(0);" data-bs-toggle="modal"
                               data-bs-target="#exampleModal"
                               class="txt_forgotpass" title="{$core->get_Lang('Forgot Your Password')}">
                                {$core->get_Lang('Forgot Your Password')}
                            </a>
                        </div>
                        <h5 class="txt_doaccount">{$core->get_Lang("Don't have account?")}
                            <a href="{$extLang}/signup_new" class="text-info txt_signup ms-2"
                               title="{$core->get_Lang('Sign up')}">
                                {$core->get_Lang('Sign up')}
                            </a>
                        </h5>
                    </div>

                

                    <div class="connectsocial">
                        <!-- <div class="row justify-content-center align-items-center">
                            <div class="col-md-4">
                                <hr class="my-1">
                            </div>
                            <div class="col-md-4 text-center">
                                <h5 class="txt_continuewith">{$core->get_Lang('or continue with')}</h5>
                            </div>
                            <div class="col-md-4">
                                <hr class="my-1">
                            </div>
                        </div>
                        <div class="button_sociallogin signM_social_section">
                           <div class="d-flex justify-content-center social-channels"
                                {if $deviceType ne "phone"}style="gap:25px"{/if}>
                                {if !empty($googleLoginUrl)}
                                    <div class="col-4 col-md-2"
                                        {if $deviceType ne "phone"}
                                            style="width:100%;max-width:160px"
                                        {/if}>
                                        <a href="{$googleLoginUrl|escape:'html'}"
                                        class="btn btn_sociallogin btn_google d-flex justify-content-center align-items-center"
                                        rel="nofollow">
                                            <img src="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-09-512.png"
                                                alt="Google"
                                                width="28"
                                                height="28">
                                        </a>
                                    </div>
                                {/if}
                                {if !empty($facebookLoginUrl)}
                                    <div class="col-4 col-md-2"
                                        {if $deviceType ne "phone"}
                                            style="width:100%;max-width:160px"
                                        {/if}>
                                        <a href="{$facebookLoginUrl|escape:'html'}"
                                        class="btn btn_sociallogin btn_facebook d-flex justify-content-center align-items-center"
                                        rel="nofollow">
                                            <i class="fa-brands fa-facebook fa-2xl icon-facebook"></i>
                                        </a>
                                    </div>
                                {/if}
                            </div>
                        </div> -->
                        <div class="txt_recommend_login">
                            <h6>{$core->get_Lang('Your account will be remembered and saved on the website until your next visit')}.</h6>
                        </div>
                    </div>
                </form>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="fa fa-times"></span>
                                </button>
                                <div class="modal-body">
                                    <div class="body page-bg round-bottom pal">
                                        <h2 class="mt0">{$core->get_Lang('Password reset')}</h2>
                                        <div class="note size16">
                                            {$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}.
                                        </div>
                                        <form novalidate class="ng-pristine ng-valid">
                                            <div class="mtm mbm">
                                                <input type="email" class="isoTxt required txt350"
                                                       placeholder="{$core->get_Lang('Your Email')}" name="user_email"
                                                       value=""/>
                                                <div id="message_box" class="mb10 mt05" style="display:none"></div>
                                            </div>
                                            <div class="line mt10">
                                                <button type="button" id="forgot_Btn"
                                                        class=" submitClick btn w-100 btn-cmd-submit">
                                                    {$core->get_Lang('Reset')} <i class="fa-light fa-arrow-right"></i>
                                                </button>
                                                <input type="hidden" name="forgotVal" value="forgotVal"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
window.isoLoginMessages = window.isoLoginMessages || {};

window.isoLoginMessages.emailRequired =
    "{$core->get_Lang('Your email should not be empty')|escape:'javascript'}!";

window.isoLoginMessages.emailInvalid =
    "{$core->get_Lang('Please enter a valid email address')|escape:'javascript'}!";

window.isoLoginMessages.passwordRequired =
    "{$core->get_Lang('Your password should not be empty')|escape:'javascript'}!";

window.isoLoginMessages.signinError =
    "{$core->get_Lang('Account or password was incorrect')|escape:'javascript'}!";

window.isoLoginMessages.signinSuccess =
    "{$core->get_Lang('Signin success')|escape:'javascript'}!";
</script>

{literal}
    <script type="text/javascript">
(function ($, window, document) {
    'use strict';

    /*
     * Các hàm này phải được gắn vào window
     * vì đang được gọi trực tiếp từ thuộc tính HTML.
     */
    window.togglePassword = function () {
        var passwordInput = document.getElementById('pwd');
        var toggleIcon = document.getElementById('toggleIcon');

        if (!passwordInput || !toggleIcon) {
            return;
        }

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    };

    window.changeIcon = function () {
        var icon = document.getElementById('icon');
        var iconAwesome = document.getElementById('icon-awesome');

        if (icon) {
            icon.style.display = 'none';
        }

        if (iconAwesome) {
            iconAwesome.style.display = 'inline-block';
        }
    };

    window.resetIcon = function () {
        var icon = document.getElementById('icon');
        var iconAwesome = document.getElementById('icon-awesome');

        if (icon) {
            icon.style.display = 'inline-block';
        }

        if (iconAwesome) {
            iconAwesome.style.display = 'none';
        }
    };

    function isValidEmail(email) {
        email = $.trim(email || '');

        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showLoginMessage(selector, message, isSuccess) {
        $(selector)
            .stop(true, true)
            .removeClass('text-danger text-success')
            .addClass(isSuccess ? 'text-success' : 'text-danger')
            .html(message)
            .fadeIn();
    }

    function getInternalReturnUrl(returnUrl) {
        returnUrl = $.trim(returnUrl || '');

        if (!returnUrl) {
            return '';
        }

        /*
         * Cho phép đường dẫn nội bộ dạng:
         * /shopping-cart
         * /vn/booking
         */
        if (returnUrl.charAt(0) === '/') {
            return returnUrl;
        }

        /*
         * Chỉ cho URL tuyệt đối cùng domain.
         */
        try {
            var targetUrl = new URL(returnUrl, window.location.origin);

            if (targetUrl.origin === window.location.origin) {
                return targetUrl.href;
            }
        } catch (error) {
            return '';
        }

        return '';
    }

    function submitLogin() {
        var messages = window.isoLoginMessages || {};

        var email = $.trim($('#emaillogin').val());
        var password = $('#pwd').val() || '';
        var returnUrl = getInternalReturnUrl(
            $('#return_url').val()
        );

        var submitValue =
            $('#signformM_form input[name="submit"]').val()
            || 'Login';

        var hasError = false;

        $('#error_email, #error_password, #error_tip')
            .stop(true, true)
            .hide()
            .html('');

        if (email === '') {
            showLoginMessage(
                '#error_email',
                messages.emailRequired || 'Email is required',
                false
            );

            $('#emaillogin').focus();
            hasError = true;
        } else if (!isValidEmail(email)) {
            showLoginMessage(
                '#error_email',
                messages.emailInvalid || 'Email is invalid',
                false
            );

            $('#emaillogin').focus();
            hasError = true;
        }

        if (password === '') {
            showLoginMessage(
                '#error_password',
                messages.passwordRequired || 'Password is required',
                false
            );

            if (!hasError) {
                $('#pwd').focus();
            }

            hasError = true;
        }

        if (hasError) {
            return false;
        }

        var $button = $('.btn_login');

        $button
            .prop('disabled', true)
            .addClass('is-loading');

        $.ajax({
            type: 'POST',
            url:
                path_ajax_script
                + '/index.php?mod=member&act=ajSignin_new',

            data: {
                USER: email,
                PASSWORD: password,
                return_url: returnUrl,
                submit: submitValue
            },

            dataType: 'html',
            cache: false,

            success: function (response) {
                response = $.trim(response || '');

                if (response.indexOf('_LOGIN_SUCCESS') !== -1) {
                    showLoginMessage(
                        '#error_tip',
                        messages.signinSuccess || 'Signin success',
                        true
                    );

                    window.setTimeout(function () {
                        if (returnUrl !== '') {
                            window.location.href = returnUrl;
                            return;
                        }

                        var languagePath =
                            typeof extLang !== 'undefined'
                                ? extLang
                                : '';

                        window.location.href =
                            DOMAIN_NAME + languagePath;
                    }, 500);

                    return;
                }

                if (
                    response.indexOf('_USER_EMPTY') !== -1
                    || response.indexOf('_PASSWORD_EMPTY') !== -1
                ) {
                    showLoginMessage(
                        '#error_tip',
                        messages.signinError
                            || 'Email and password are required',
                        false
                    );

                    return;
                }

                showLoginMessage(
                    '#error_tip',
                    messages.signinError
                        || 'Account or password was incorrect',
                    false
                );
            },

            error: function (xhr) {
                console.error(
                    'Signin request error:',
                    xhr.status,
                    xhr.responseText
                );

                showLoginMessage(
                    '#error_tip',
                    messages.signinError
                        || 'Unable to sign in. Please try again.',
                    false
                );
            },

            complete: function () {
                $button
                    .prop('disabled', false)
                    .removeClass('is-loading');
            }
        });

        return false;
    }

    $(function () {
        /*
         * Gỡ handler cũ để tránh gửi request hai lần
         * nếu template được load lại.
         */
        $(document)
            .off('click.isoSignin', '.btn_login')
            .on(
                'click.isoSignin',
                '.btn_login',
                function (event) {
                    event.preventDefault();
                    submitLogin();
                }
            );

        $(document)
            .off(
                'keydown.isoSignin',
                '#emaillogin, #pwd'
            )
            .on(
                'keydown.isoSignin',
                '#emaillogin, #pwd',
                function (event) {
                    if (
                        event.key === 'Enter'
                        || event.which === 13
                    ) {
                        event.preventDefault();
                        submitLogin();
                    }
                }
            );

        /*
         * Ngăn form submit theo cách mặc định.
         */
        $('#signformM_form')
            .off('submit.isoSignin')
            .on('submit.isoSignin', function (event) {
                event.preventDefault();
                submitLogin();
                return false;
            });
    });

})(window.jQuery, window, document);
</script>
    <style>
        .popup {
            display: none; /* Ẩn pop-up theo mặc định */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-content: center;
        }

        .popup-content {
            background-color: white;
            margin: 5% auto; /* Giảm khoảng cách từ trên và dưới cho phù hợp với màn hình nhỏ */
            padding: 20px;
            border: 1px solid #888;
            max-width: 500px; /* Chiều rộng tối đa cho pop-up */
            width: 90%; /* Chiếm 90% chiều rộng của màn hình */
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .button_mailreset {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        #emailInput {
            height: 42px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .error_tip {
            color: var(--primary-18-babd, #18BABD);
            margin-top: 10px;
        }

        .modal-content .isoTxt {
            min-height: 60px;
            height: 100%;
        }

        .modal-dialog .note {
            line-height: 25px;
            margin-bottom: 18px;
        }
        .modal-dialog h2 {
            margin-bottom: 15px;
        }
    </style>
{/literal}

<script type="text/javascript">
window.isoResetMessages = window.isoResetMessages || {};

window.isoResetMessages.emailRequired =
    "{$core->get_Lang('Error &#33; Please enter your email')|escape:'javascript'}.";

window.isoResetMessages.emailInvalid =
    "{$core->get_Lang('Error &#33; Please enter your email valid')|escape:'javascript'}.";

window.isoResetMessages.success =
    "{$core->get_Lang('Submit request successful &#33; Please check your email and reset your new password')|escape:'javascript'}.";

window.isoResetMessages.error =
    "{$core->get_Lang('An error occurred. Please try again')|escape:'javascript'}.";
</script>

{literal}
    <script type="text/javascript">
        (function ($, window, document) {
    'use strict';

    function isValidEmail(email) {
        email = $.trim(email || '');

        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showResetMessage(message, isSuccess) {
        $('#message_box')
            .stop(true, true)
            .removeClass('text-danger text-success')
            .addClass(isSuccess ? 'text-success' : 'text-danger')
            .html(message)
            .show();
    }

    $(document)
        .off('click.isoForgotPassword', '#forgot_Btn')
        .on(
            'click.isoForgotPassword',
            '#forgot_Btn',
            function (event) {
                event.preventDefault();

                var messages = window.isoResetMessages || {};
                var $button = $(this);
                var $modal = $button.closest('#exampleModal');
                var $email = $modal.find(
                    'input[name="user_email"]'
                );

                var email = $.trim($email.val());

                if (email === '') {
                    showResetMessage(
                        messages.emailRequired
                            || 'Please enter your email',
                        false
                    );

                    $email.focus();
                    return false;
                }

                if (!isValidEmail(email)) {
                    showResetMessage(
                        messages.emailInvalid
                            || 'Please enter a valid email',
                        false
                    );

                    $email.focus();
                    return false;
                }

                $button
                    .prop('disabled', true)
                    .addClass('is-loading');

                $.ajax({
                    type: 'POST',

                    url:
                        path_ajax_script
                        + '/index.php?mod=member'
                        + '&act=ajAjaxForgotGlobal',

                    data: {
                        user_email: email,
                        forgotVal: 'forgotVal'
                    },

                    dataType: 'html',
                    cache: false,

                    success: function (response) {
                        response = $.trim(response || '');

                        if (
                            response.indexOf(
                                'email_empty_error'
                            ) >= 0
                        ) {
                            showResetMessage(
                                messages.emailRequired,
                                false
                            );

                            $email.focus();
                            return;
                        }

                        if (
                            response.indexOf(
                                'email_not_correct'
                            ) >= 0
                        ) {
                            showResetMessage(
                                messages.emailInvalid,
                                false
                            );

                            $email.focus();
                            return;
                        }
                        if (
                            response.indexOf('reset_error') >= 0
                            || response.indexOf('send_mail_error') >= 0
                        ) {
                            showResetMessage(
                                messages.error || 'Unable to send reset email. Please try again.',
                                false
                            );

                            return;
                        }
                        if (
                            response.indexOf(
                                'reset_success'
                            ) >= 0
                        ) {
                            showResetMessage(
                                messages.success,
                                true
                            );

                            $email.val('');

                            window.setTimeout(function () {
                                var modalElement =
                                    document.getElementById(
                                        'exampleModal'
                                    );

                                if (
                                    modalElement
                                    && window.bootstrap
                                    && bootstrap.Modal
                                ) {
                                    var modal =
                                        bootstrap.Modal.getInstance(
                                            modalElement
                                        );

                                    if (!modal) {
                                        modal =
                                            new bootstrap.Modal(
                                                modalElement
                                            );
                                    }

                                    modal.hide();
                                }
                            }, 2500);

                            return;
                        }

                        showResetMessage(
                            messages.error
                                || 'An error occurred',
                            false
                        );
                    },

                    error: function (xhr) {
                        console.error(
                            'Forgot password error:',
                            xhr.status,
                            xhr.responseText
                        );

                        showResetMessage(
                            messages.error
                                || 'An error occurred',
                            false
                        );
                    },

                    complete: function () {
                        $button
                            .prop('disabled', false)
                            .removeClass('is-loading');
                    }
                });

                return false;
            }
        );

    $(document)
        .off(
            'keydown.isoForgotPassword',
            '#exampleModal input[name="user_email"]'
        )
        .on(
            'keydown.isoForgotPassword',
            '#exampleModal input[name="user_email"]',
            function (event) {
                if (
                    event.key === 'Enter'
                    || event.which === 13
                ) {
                    event.preventDefault();
                    $('#forgot_Btn').trigger('click');
                }
            }
        );

})(window.jQuery, window, document);
    </script>
{/literal}