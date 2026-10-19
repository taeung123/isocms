<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login to ISOCMS Administrator</title>
    <meta name='robots' content='noindex,nofollow'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="{$PCMS_URL}/favicon.ico?v={$upd_version}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
          integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{$URL_CSS}/font-awesome.min.css?v={$upd_version}" type="text/css" media="all">
    {*    <link rel="stylesheet" href="{$URL_CSS}/admin_login.css" type="text/css" media="all">*}
    <link rel="stylesheet" href="{$URL_CSS}/admin_login_2.css?v={$upd_version}" type="text/css" media="all">
    <script>var path_ajax_script = '{$PCMS_URL}';</script>
</head>
<body>
<div class="wrapper">
    <div class="row">
        <div class="col-lg-7">
            <div class="google-header-bar">
                <div id="logo">
                    <a href="{$PCMS_URL}" title="{$PAGE_NAME}">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAABkCAMAAAAL3/3yAAAAk1BMVEX////1giAjHyAHCAj6wI+sq6yRj4/W1daCgoNZV1fi4uL84MfJyMj4oVj+9/F2dXYxLS72ii7x8fH19fX959XBwcGhoqL70KuDg4P5sXRmZWX2kjz+7+OMjI77yJ35uYKXl5j3mko/Ozzv8PBKSEk2Njbq6ur82Lm2trf4qWbQ0dEXFxeenZ0mJye6ubltbW+xsrKhxl22AAAJGElEQVR42uyaYW+qMBSGT2upAaQC4Q4QIpF5Q3Sb2f//dddtzoKnZS1XJ9l4PhnnEvPs7ek5h8HExMTExMTExO1I/HcSmOijTKsgImeioGpKmFCQVAVRsKmmiF0gWEG0bFIBE5+UOeknYnfRFTucOzAqREUwWBd8O/OaHtnGMB7SiBhR+PDN1PQdF8ZCGRBjKgHfyYKemMM4aCJiwSaBb4TTEwsYBYzYEaWg54fLyok1fbZ+tKx16gvfT6sNsaACLT9a1hnR7Igxa9DxO2TJW/GWJ3HOOffAFI/X9MTWPZKdlIk1Yw3cmzUxxYchZPQNB8xwKGIJR5KIHAnuPn/5ETEjKsGeg9WZ8qiCA4CIZOW8L4lxvwX2rGQ+zGKIWQGk5ATcnZQYwsAal37gmn4a47YawxHsjSpiSHljWcuvZN29aAEI05YrGNwIPJvWdwyXlWIDI8C/2Y0YbylauNidw218zn40glNoMQEVYEu8DGm4jE0/nYW0y+lX1wUhu3G4AhERMxpQ8Ts6+DNscNX6hbKMo4WPwu+TBWzI+iF+5vwAmIWcB+XrDt6Bv+HMDWWVl7OhaFiXFBD+mr3hC7gy5YASP3+vxm7cNw8u5euW4y39pM48nSy02t1JVTk+CRvRNZWTM7sUrktufQ7j082V9cyDjmKhzkN04Sll4SLB0Dyrq6dJcIXnLt5DlmV8/x+9FsMt5EU26tY8uKWXQudbekl4UMrCq5Go/6uKvqKSC7Dj4e/sg5dXQGxs70Pe2aJghy4AyNfy6Cp47pfFOoN0GX3RMgvlKdlY2Xp9mUncx6GbLfjkmSqjVetkSVcYbi5LXzAE+rMPtfXozjr8fRxY4n28fVoq5zsHy/JCqsExkiX6vmeOqu/QHdNexkpnq7DdLy9ltBTBCmMsy5V2apevWuUr9Exk+doTIPeoDZEUQVDY75j2TzPEatimhoEqWjhYGSBZ8oerDxWevBldU1m7sx3WpkHtdcTKj/V9YbljOrrCXFT5hhixg75o1fItLKuW1x++HBeGsgL5PVSwVtJQwc/BhJmKl+5BFNbjIY6W03oHyXI+Xc3REufI0lKWD0oKlRdmFa2ZkmxI8xCAMlooWFjWqlPMUTMRD08WPh6FgDY7i8efe7Wsp260cnNZOFooWFiWfK0ccA5msthlzVq3h79KnbvSYmvyZ6bmAdqkdrJwtOJaXm5Y1kIGq0Msey0TWQnBBA2cCDRbytz8+ZCnkfUCbRJ7WV77iRVw1GRKWTJ2sWaZ7JrJgqCvcdD9b0ZqUbRmGvbQxkIWjtYC4lD2WEiW1OBeEtrJSvr6c11t8tHxtJOFe63AXBaOlouChWTpsJMFaU9/jpxcSRYu8bllnwUdBQcUrFvI0tti10rWP3KudjdxIAZaajaQDYEGwldS5a4EStODu77/050IHDjMejd7atVKmR9toaFFg72M7TG7hy5HfOk/l+a5B4EFZ5YVedtTehDJatpViHT8QWfWViIrAvp9vUcYMI9TJIvTsAqN0GfZhSUUkkWUBUkDXvuVlnfD2sMtsXqQUPlq+Jik0IKYMOusDVnxCJQDWYJLPbnqLHhJM5/p1EIkKySG1KefhaGFZKCCx1n+YDQghhxCy1WtLFkjdc9zEouTkjwkPGLn+XaYEDlCS0lkKdMVesuGHtgQw+YfIua/LkytvrVv20GC9uvSBAQIhcDCrgO+A4zOTOdG7ldTK1nIJb/xfCVmXPt1HSjvlIeB95QVQ0vJZKkbo+pM1TXnzNw3LgkkKws4rumQNswUd7sh4yD19UwtOuVh7GsNwdCKiEPulObT1uMk7rdTJCuwKsA9ExMZUVb4u/GqBxGVozpM12Ucl4lo67wU0Kgl7T34iBQLIRw8XhACWbFD1PzgbD2ltuPWPw8X1uowWbLJpuR1UEJgWac7iv8sOgAjIKsWgx4LkWSN0x3PLo2sSwvLBl1meXE2psByzA03wNUVkY2sRBaAyFbhwxVWPAhRO6QlcQSyP0sJruQIJtI6QsU/srhLc5hI1+7KIvDYBPQ84t+FUroe37cbC9dKpQYS8f4DSz8mEBrgRSPwOuydm2tYPD7H5Idjhz5NYPVSJHhXO71Upw2LqWIuGmlXRXP/TdawtZbV4BpEQcyMNrWFKt9T6wiVgxC2GSG4V0ubd3cOGq8ehSf81iRDs7942t3hVXQbe3OKZctzi57+B5G7XxrfwqrnqH45RfzTJaq/gTv/q/HuFg/NYfn1y2rfAblTPKS4qTbX1E8IYmvOhFZJDFV4esTujfqIaueY47c+sEf/i8Qt9RLgPZLJqFa3a3uaiWa2CDE/tvK0n3hjmSiTUU1A48t4GZAHOhM/e1UzsmDwYn42s08+t0Krq3JFRgyHfybDxelZKzLj52vzVbcfRh0xnA9mN4qHw8ndv1GDu9uXb5o+EhOT0uII/7ZzNiuOwzAA1sVjYQw+GJsQEBh2Y0yH0nn/p9uN8oNSNxOSMjAHf4eSuBKWv1ZqD6Xyuc8vkNTl7suyxNvBNVkyMI83/ntZCD/C1/Pguu//sHkwcCgrJXxwmEdEGd+Pz0Y+LaELvIarX3yVEhw6vsceOVO8HnO8i2J3XK4ixy/Lxs376YJcHC+hgfOwD8mfnRb87ACOZdEojDtOg0fZhxYgmvWYlaw6JZMMXPEuA8NNXYKQJa/EsgegLIrj24uE+86Ej/Jd99fAoSx5cvc0M2yUZ65l1SnFwuIXQWCQ9Jru6UiWiePuRezEmi8T769meCdVBYBzsh5KKRSjxD/ApOkqIj0qWXWK0vLwkkxlXcUjWVptHnAqIeU3dA3VhO/F0GdVJ99Z+j9yDlNWdvlg9K6SVaVUsiTuDVmMRw3XufVz0w1P3yqGDwNwXhZV3V4QGNxrQ3pOYMW1LNm2Jh3I4tEHJWxl8c1bhI5/jyRcDT3PjCuylALY5HpMwKQAWrShd5mDqxSPGTTVXx0sQCGOL+CTXnbn/Ow8azeiKNKQ0W+K01zF29xC4Lbsuo9wOyN6Ks+EMZkvC2IBSbSzhISWQ+ZATaj8qxRDmLwInPAFMU7LCtGK3b1C0nNmFMsJyWyLs4S/7P9PG41Go9FoNBqNRqPRaDQajSv8A4XAoD1g/xZNAAAAAElFTkSuQmCC"
                             width="300" height="100"/>
                    </a>
                </div>
            </div>
        </div>
        {if $hnv_lock_page}
            <div class="col-lg-5">
                <div class="main content clearfix wrapper_item">
                    <div class="sign-in row">
                        <div class="signin-box col-10">
                            <label class="mt0 mb20 hnv_lock_title">
                                {$core->get_Lang('The system is currently under maintenance')}
                            </label>
                            <h2 class="hnv_lock_h2">{$core->get_Lang('Cannot sign in')}</h2>
                            <form id="gaia_loginform" action="#" method="post">
                                <label class="login_label">
                                    <input type="text" name="txtUsername" id="hnv_lock_txtUsername"
                                           value="{$txtUsername|default:''}"
                                           class="form-control-plaintext text-secondary" readonly
                                           style="background-color: #f0f0f0;"/>
                                </label>
                                <label class="login_label">
                                    <input type="password" name="txtPassword" id="hnv_lock_txtPassword"
                                           value="{$txtPassword|default:''}"
                                           class="form-control-plaintext text-secondary" readonly
                                           style="background-color: #f0f0f0;"/>
                                </label>
                                <div>
                                    <input type="submit" class="g-button g-button-submit hnv_lock_btn text-secondary"
                                           name="signIn" id="signIn" value="Login" disabled
                                           style="background-color: #f0f0f0;"/>
                                    <input type="hidden" name="btnLogin" value="btnLogin"/>
                                </div>
                            </form>
                            {if $isValid eq 0}
                                <div id="login_error">
                                    {$core->get_Lang('Login Failed')}! {$core->get_Lang('Please Try Again')}!<br>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        {else}
            <div class="col-lg-5">
                <div class="main content clearfix wrapper_item">
                    <div class="sign-in row">
                        <div class="signin-box col-10">
                            <h2>{$core->get_Lang('Sign in')}</h2>
                                <span class="signup-button">
                                {$core->get_Lang('New to')} {$PAGE_NAME}?
                                <a id="link-signup" class=" create" href="https://www.vietiso.com/">
                                    {$core->get_Lang('Create an account')}
                                </a>
                            </span>
                            <form id="gaia_loginform" action="#" method="post">
                                <label class="login_label">
                                    <input type="text" name="txtUsername" id="txtUsername" value="{$txtUsername|default:''}"/>
                                </label>
                                <label class="login_label">
                                    <input type="password" name="txtPassword" id="txtPassword" value="{$txtPassword|default:''}"/>
                                    <span toggle="#txtPassword" class="icon_eye toggle-password">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                                </label>
                                <div class="form_checkforgot">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">
                                            {$core->get_Lang('Remember account')}
                                        </label>
                                    </div>
                                    <ul>
                                        <li>
                                            <a id="link-forgot-passwd" href="javascript:void(0);"
                                               data-bs-toggle="modal" data-bs-target="#forgotForm">
                                                {$core->get_Lang('Forgot password')}?
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <input type="submit"
                                           class="g-button g-button-submit"
                                           name="signIn" id="signIn"
                                           value="Login"/>
                                    <input type="hidden" name="btnLogin" value="btnLogin"/>
                                </div>
                            </form>
                            {if $isValid eq 0}
                                <div id="login_error">
                                    {$core->get_Lang('Login Failed')}! {$core->get_Lang('Please Try Again')}!<br>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
    <div class="modal fade" id="forgotForm" tabindex="-1" aria-labelledby="forgotFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="body page-bg round-bottom pal">
                        <h2 class="mt0 mb20">{$core->get_Lang('Password reset')}</h2>
                        <div class="note size16">
                            {$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}
                        </div>
                        <form novalidate class="ng-pristine ng-valid">
                            <div class="mtm mbm">
                                <input type="email" class="isoTxt required txt350"
                                       placeholder="{$core->get_Lang('Your Email')}" name="user_email" value=""/>
                                <div id="message_box" class="text-danger mb10 mt05" style="display:none"></div>
                            </div>
                            <div class="line mt10">
                                <button type="button" id="forgotBtn" class="submitClick">
                                    {$core->get_Lang('Reset')} &raquo;
                                </button>
                                <input type="hidden" name="forgotVal" value="forgotVal"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="google-footer-bar">
        <div class="container">
            <div class="google-footer-bar-item">
                <div class="google_footer_item">{$core->get_Lang('Copyright')} &copy; {$current_year|default:''} VietISO</div>
                <div class="google_footer_item">
                    <a href="https://www.vietiso.com/ho-tro/dieu-khoan-huong-dan/dieu-khoan-dich-vu.html">
                        {$core->get_Lang('Term &amp; Conditions')}
                    </a>
                </div>
                <div class="google_footer_item">
                    <a href="https://www.vietiso.com/ho-tro/dieu-khoan-huong-dan/chinh-sach-bao-mat.html">
                        {$core->get_Lang('Privacy Policy')}
                    </a>
                </div>
                <div class="google_footer_item">
                    <a href="https://www.vietiso.com/contact">
                        {$core->get_Lang('Help')}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="ajax_loading" style="display: none;"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
            integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var error_msg_1 = "{$core->get_Lang('Error, you have not entered an email')}";
        var error_msg_2 = "{$core->get_Lang('Error, email is not in correct format')}";
        var error_msg_3 = "{$core->get_Lang('Email does not exist in the system')}";
        var success_msg = "{$core->get_Lang('Request has been sent. Please check your email to change your password')}";
    </script>
    {literal}
        <script type="text/javascript">
            $(document).ready(function () {
                $('input[type=text]:first').focus();
            });
            $(".toggle-password").click(function () {
                $(this).toggleClass("fa fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
            $(document).ready(function () {
                $('#forgotBtn').click(function () {
                    var val_email = $("input[name='user_email']").val();
                    if (val_email == '') {
                        $('#message_box').text(error_msg_1);
                        $('#message_box').show();
                    } else if (!checkValidEmail(val_email)) {
                        $('#message_box').text(error_msg_2);
                        $('#message_box').show();
                    } else {
                        $.ajax({
                            type: "POST",
                            data: {email: val_email},
                            dataType: 'html',
                            async: false,
                            url: path_ajax_script + "/index.php?mod=login&act=ajaxForgotPasswordAdmin",
                            success: function (html) {
                                vietiso_loading(0);
                                if (html.indexOf('reset_success') >= 0) {
                                    $('#message_box').show();
                                    $('#message_box').addClass('text-success');
                                    $('#message_box').removeClass('text-danger');
                                    $('#message_box').text(success_msg);
                                    setTimeout(function () {
                                        location.reload()
                                    }, 3000);
                                } else if (html.indexOf('email_not_correct') >= 0) {
                                    $('#message_box').show();
                                    $('#message_box').text(error_msg_3);
                                } else {
                                    $('#message_box').show();
                                    $('#message_box').text('ERROR!');
                                }
                            },
                            beforeSend: function () {
                                vietiso_loading(1);
                            }
                        });
                    }
                });
            });

            function checkValidEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            function vietiso_loading($show) {
                if ($show == 1) {
                    $('#ajax_loading').fadeIn();
                }
                if ($show == 0) {
                    $('#ajax_loading').fadeOut(1200);
                }
                if ($show == 2) {
                    $('#ajax_loading').fadeOut(100);
                }
                if ($show == 5) {
                    $('#ajax_loading').fadeOut(500);
                }
            }
        </script>
    {/literal}
</div>
</body>

</html>