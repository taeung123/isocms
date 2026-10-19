{if !isset($msgSubmitForm)}
    {assign var=msgSubmitForm value=''}
{/if}

{if !isset($sid)}
    {assign var=sid value=''}
{/if}

<link rel="stylesheet" href="{$URL_CSS}/homepagenew.css?v={$upd_version}"/>
<link rel="stylesheet" href="{$URL_CSS}/fontawesome/css/all.css?v={$upd_version}"/>
<main id="signin_main">
    <section class="signin_form signup_form">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="border_iconi">
                    <i id="icon" class="fa-solid fa-user-plus fa-2xl" style="color: #00818a;"></i>
                    <i id="icon-awesome" class="fa-regular fa-face-hand-peeking fa-2xl"
                       style="display: none;color: #00818a;"></i>
                </div>
            </div>
            <h2 class="txt_signin">{$core->get_Lang('Sign Up')}</h2>
            <h5 class="txt_des_signin">{$core->get_Lang('Register an account to easily manage your booking')}</h5>
            <div class="form_email_pass d-flex justify-content-center align-items-center">
                <form class="w-100" style="max-width: 530px">
                    <!-- <div class="connectsocial">
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
                                        title="{$core->get_Lang('Sign up with Google')}"
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
                                        title="{$core->get_Lang('Sign up with Facebook')}"
                                        rel="nofollow">
                                            <i class="fa-brands fa-facebook fa-2xl icon-facebook"></i>
                                        </a>
                                    </div>
                                {/if}

                                {if !empty($appleLoginUrl)}
                                    <div class="col-4 col-md-2"
                                        {if $deviceType ne "phone"}
                                            style="width:100%;max-width:160px"
                                        {/if}>
                                        <a href="{$appleLoginUrl|escape:'html'}"
                                        class="btn btn_sociallogin btn_apple d-flex justify-content-center align-items-center"
                                        title="{$core->get_Lang('Sign up with Apple')}"
                                        rel="nofollow">
                                            <img src="https://cdn-icons-png.flaticon.com/512/0/747.png"
                                                alt="Apple"
                                                width="28"
                                                height="28">
                                        </a>
                                    </div>
                                {/if}

                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center" style="margin-bottom: 42px">
                            <div class="col-md-5">
                                <hr class="my-1">
                            </div>
                            <div class="col-md-1 text-center">
                                <h5 class="txt_continuewith">{$core->get_Lang('or')}</h5>
                            </div>
                            <div class="col-md-5">
                                <hr class="my-1">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group form_mailpass">
                        <div class="inner-addon left-addon">
                            <input type="text" class="form-control" id="fullname" name="full_name" required
                                   onblur="resetIcon()">
                            <label for="name" class="form-label txt_emailpass">{$core->get_Lang('Full name')}</label>
                        </div>
                        <div class="error_tip" id="error_fullname" style="display: none;"></div>
                    </div>
                    <div class="form-group form_mailpass">
                        <div class="inner-addon left-addon">
                            <input type="email" class="form-control" id="useremail" name="email" required
                                   onblur="resetIcon()">
                            <label for="email" class="form-label txt_emailpass">{$core->get_Lang('Email')}</label>
                        </div>
                        <div class="error_tip" id="error_email" style="display: none;"></div>
                    </div>
                    <div class="form-group form_mailpass">
                        <div class="inner-addon leftaddon">
                            <input type="password" class="form-control" id="userpass" required  onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()" name="userpass">
                            <label for="enterpassword" class="form-label txt_emailpass">{$core->get_Lang('Enter Password')}</label>
                            <span class="toggle-password" onclick="togglePassword('userpass', 'toggleIcon1')">
                                <i id="toggleIcon1" class="fa-regular fa-eye"></i>
                            </span>
                        </div>
                        <div class="error_tip" id="error_password" style="display: none;"></div>
                    </div>

                    <div class="form-group form_mailpass">
                        <div class="inner-addon leftaddon">
                            <input type="password" class="form-control" id="confirmpass" required onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()" name="confirmpass">
                            <label for="repassword" class="form-label txt_emailpass">{$core->get_Lang('Repeat Password')}</label>
                            <span class="toggle-password" onclick="togglePassword('confirmpass', 'toggleIcon2')">
                                    <i id="toggleIcon2" class="fa-regular fa-eye"></i>
                            </span>
                        </div>
                        <div class="error_tip" id="error_re_password" style="display: none;"></div>
                    </div>
                    <div class="form-group" style="text-align:-webkit-center">
                        {if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
                            <label class=" title" for="secure_code">
                                <abbr class="required" title="required">*</abbr> {$core->get_Lang('securecode')}
                            </label>
                            <div>
                                <input autocomplete="off" type="text" class="form-control security_code required"
                                       name="secure_code" value="" maxlength="5"/>
                                <img src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="36" alt="Secure"/>
                            </div>
                        {else}
                            <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                            {if $msgSubmitForm ne ''}
                                <div class="error text_left">{$msgSubmitForm}</div>
                            {/if}
                        {/if}
                    </div>
                    <input type="hidden" name="submit" value="SignUp">
                    <div id="error_tip" class="error_tip"></div>
                    <button type="button" class="btn-signIn btn w-100 btn_login">{$core->Get_Lang('Sign up')}</button>
                    <div class="mt-4 mb-3 text-end">
                        <h5 class="txt_doaccount">{$core->get_Lang("Already have an account ?")}
                            <a href="{$extLang}/login_new" class="text-info txt_signup ms-2">{$core->get_Lang('Login in here')}
                            </a>
                        </h5>
                    </div>
                    <div class="term_privacy">
                        <h6 class="txt_termprivacy">{$core->get_Lang("By creating an account, you agree to our")}
                            <a href="{$clsISO->getLink('term_condition')}" title="{$core->get_Lang("Terms & Conditions")}">{$core->get_Lang("Terms & Conditions")}
                            </a>,
                            <a href="{$clsISO->getLink('term_security')}" title="{$core->get_Lang('Privacy Policy')}">{$core->get_Lang('Privacy Policy')}
                            </a> {$core->get_Lang('and')}
                            <a href="#" title="{$core->get_Lang('Agreement with isoCMS')}">{$core->get_Lang('Agreement with isoCMS')}.
                            </a>
                        </h6>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
window.msg_fullname_required =
    "{$core->get_Lang('Your fullname should not be empty')|escape:'javascript'}!";

window.msg_email_required =
    "{$core->get_Lang('Your email should not be empty')|escape:'javascript'}!";

window.msg_email_not_valid =
    "{$core->get_Lang('Please enter a valid email address')|escape:'javascript'}!";

window.msg_email_exits =
    "{$core->get_Lang('Email Exits')|escape:'javascript'}!";

window.msg_password_required =
    "{$core->get_Lang('Your password should not be empty')|escape:'javascript'}!";

window.msg_re_password_required =
    "{$core->get_Lang('Your comfirm password should not be empty')|escape:'javascript'}!";

window.msg_match_password_required =
    "{$core->get_Lang('Confirm password do not match')|escape:'javascript'}!";

window.msg_signup_error =
    "{$core->get_Lang('Account or password was incorrect')|escape:'javascript'}!";

window.msg_signup_success =
    "{$core->get_Lang('Signup success')|escape:'javascript'}!";

window.msg_recapcha =
    "{$core->get_Lang('You must check Recaptcha')|escape:'javascript'}";
</script>

{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.togglePassword = function (inputId, iconId) {
    var passwordInput = document.getElementById(inputId);
    var toggleIcon = document.getElementById(iconId);

    if (!passwordInput || !toggleIcon) {
        return;
    }

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
};

window.changeIcon = function () {
    var icon = document.getElementById("icon");
    var iconAwesome = document.getElementById("icon-awesome");

    if (icon) {
        icon.style.display = "none";
    }

    if (iconAwesome) {
        iconAwesome.style.display = "inline";
    }
};

window.resetIcon = function () {
    var icon = document.getElementById("icon");
    var iconAwesome = document.getElementById("icon-awesome");

    if (icon) {
        icon.style.display = "inline";
    }

    if (iconAwesome) {
        iconAwesome.style.display = "none";
    }
};

            $(function () {
                $(".btn-signIn").click(function () {
                    var $fullname = $("#fullname").val();
                    var $email = $("#useremail").val();
                    var $password = $("#userpass").val();
                    var $confirmpass = $("#confirmpass").val();
                    var $submit = $("input[name='submit']").val();
                    var $g_recaptcha_response = $("textarea[name='g-recaptcha-response']").val();

                    if ($fullname == '') {
                        $('#error_fullname').html(msg_fullname_required).fadeIn().delay(3000).fadeOut();
                        $("#fullname").focus();
                        return false;
                    }
                    if ($email == '') {
                        $('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                        $("#useremail").focus();
                        return false;
                    }
                    if (checkValidEmail($email) == false) {
                        $('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                        $("#useremail").focus();
                        return false;
                    }
                    if ($password == '') {
                        $('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
                        $("#userpass").focus();
                        return false;
                    }
                    if ($confirmpass == '') {
                        $('#error_re_password').html(msg_re_password_required).fadeIn().delay(3000).fadeOut();
                        $("#confirmpass").focus();
                        return false;
                    }
                    if ($confirmpass != $password) {
                        $('#error_re_password').html(msg_match_password_required).fadeIn().delay(3000).fadeOut();
                        $("#confirmpass").focus();
                        return false;
                    }
                    var adata = {
                        'full_name': $fullname,
                        'email': $email,
                        'userpass': $password,
                        'g-recaptcha-response': $g_recaptcha_response,
                        'submit': $submit

                    }
                    if ($fullname != '' && $email != '' && $password != '' && $confirmpass != '') {
                        $(".btn-signIn span").hide();
                        $(".btn-signIn .loading-inline-rotate").show();
                    }
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=member&act=ajSignup_new',
                        data: adata,
                        dataType: 'html',
                        success: function (html) {
                            if (html.indexOf("_SIGNUP_SUCCESS") >= 0) {
                                $('#error_tip').html(msg_signup_success).fadeIn().delay(2000).fadeOut();
                                $(".btn-signIn .loading-inline-rotate").hide();
                                $(".btn-signIn span").show();
                                location.href = DOMAIN_NAME + extLang + '/login_new';

                            } else {
                                if (html.indexOf("_CAPTCHA_NOT_CHECK") >= 0) {
                                    $('#error_tip').html(msg_recapcha).fadeIn().delay(2000).fadeOut();
                                } else if (html.indexOf("_EMAIL_EXITS") >= 0) {
                                    $('#error_tip').html(msg_email_exits).fadeIn().delay(2000).fadeOut();
                                } else {
                                    $('#error_tip').html(msg_signup_error).fadeIn().delay(2000).fadeOut();

                                }
                                $(".btn-signIn .loading-inline-rotate").hide();
                                $(".btn-signIn span").show();
                            }
                        }
                    });
                    return false;
                });
            });

            function checkValidEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }
        })
    </script>
    <style>
        .error_tip {
            color: var(--primary-18-babd, #18BABD);
            margin-top: 10px;
        }
    </style>
{/literal}
