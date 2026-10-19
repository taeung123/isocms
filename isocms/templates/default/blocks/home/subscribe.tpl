{if $clsISO->getCheckActiveModulePackage($package_id,'subscription','default','default')}
    <section class="signup_mail">
        <div class="container">
            <div class="signup-section">
                <div class="signup-image col-lg-6 col-md-12 col-sm-12">
                    <img class="img100" src="{$clsConfiguration->getValue('ImageSubscribe')}" alt="Subscribe" loading="lazy">
                </div>
                <div class="signup-content col-lg-6 col-md-12 col-sm-12">
                    {assign var=TitleSubscribe value=TitleSubscribe_|cat:$_LANG_ID}
                    {assign var=DescriptionSubscribe value=DescriptionSubscribe_|cat:$_LANG_ID}
                    <h2>{$clsConfiguration->getValue($TitleSubscribe)}</h2>
                    <p>{$clsConfiguration->getValue($DescriptionSubscribe)}</p>
                    <div class="form_btnsignup">
                        <form method="post" action="{$extLang}" class="subscribe__form">
                            <input type="hidden" class="via_key_h" name="via_key" value="">
                            <input type="hidden" class="via_key_h" name="via_from_time" value="{$from_time|escape}">
                            <input type="hidden" class="via_key_h" name="via_signature" value="{$signature|escape}">
                            <input type="hidden" class="via_key_h" name="via_js_token" value="{$js_token|escape}">
                            <input type="hidden" class="via_key_h" name="via_spam_csrf" value="{$spam_csrf|escape}">

                            <input type="email" id="email_subscribe" class="form-control me-2 isoTxt txt required"
                                   placeholder="{$core->get_Lang('Your email')}">
                            <input type="text" id="subscribe_check" class="subscribe_check" value="">
                            <input class="btn btn-signup btn_Subscribe" id="submitSubscribeHome" type="button"
                                   name="btnSubmit" value="{$core->get_Lang('Sign up')}">
                            <input type="hidden" value="Sign me up" name="Submit">
                        </form>
                        <div id="subcribe_msg" class="subcribe_msg"></div>
                    </div>
                </div>
            </div>
            <p class="disclaimer">
                {assign var=NoteSubscribe value=NoteSubscribe_|cat:$_LANG_ID}
                {$clsConfiguration->getValue($NoteSubscribe)}
            </p>
        </div>
    </section>
{/if}
{$clsISO->getTemplate('alert/index')}
{literal}
<link rel="stylesheet" href="{/literal}{$URL_CSS}{literal}/iso.alert.css?v={/literal}{$upd_version}{literal}" as="style" onload="this.rel='stylesheet'">
<script src="{/literal}{$URL_JS}{literal}/iso.alert.js?v={/literal}{$upd_version}{literal}"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(function () {
                $("#submitSubscribeHome").click(function () {
                    var $subscribe_email = $("#email_subscribe").val();
                    var $subscribe_check = $("#subscribe_check").val();


                    if ($("#email_subscribe").val() == '') {
                        $('#subcribe_msg').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                        $("#email_subscribe").focus();
                        return false;
                    }
                    if (checkValidEmail($subscribe_email) == false) {
                        $('#subcribe_msg').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                        $("#email_subscribe").focus();
                        return false;
                    }
                    
                    $.post(`${path_ajax_script}index.php?mod=home&act=ajGetSubs_totalSe&lang=${LANG_ID}`, (res) => {
                        let a_se_subs = res.a_se_subs;
                        let b_se_subs = res.b_se_subs;
                        let subs_totalSe = res.subs_totalSe;
                        
                        Alert.question({
                            layout: 'modern',
                            message: `${text_question}: ${a_se_subs} + ${b_se_subs}`,
                            input: "text",
                            showCancelButton: true,
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (parseInt(result.value) === parseInt(subs_totalSe)) {
                                    let adata = {
                                        'email': $subscribe_email,
                                        'subscribe_check': $subscribe_check,
                                        'subs_totalSe': result.value,
                                        'subs_uid': res.subs_uid,

                                        'via_key': $('[name="via_key"]').val(),
                                        'via_from_time': $('[name="via_from_time"]').val(),
                                        'via_signature': $('[name="via_signature"]').val(),
                                        'via_js_token': $('[name="via_js_token"]').val(),
                                        'via_spam_csrf': $('[name="via_spam_csrf"]').val()
                                    };
                                    $.ajax({
                                        type: 'POST',
                                        url: `${path_ajax_script}/index.php?mod=home&act=ajSubmitSubscribe&lang=${LANG_ID}`,
                                        data: adata,
                                        dataType: 'json',
                                        success: function (res) {
                                            const type = Object.keys(res)[0];
                                            const title = Object.values(res)[0];

                                            Alert[type]({
                                                title,
                                                timer: 3000,
                                                timerProgressBar: true
                                            }).then(() => {
                                                location.reload();
                                            });
                                            $("#email_subscribe").val('');
                                        }
                                    });
                                } else {
                                    Alert.error({
                                        title: wrong_answer,
                                        confirmButtonText: "OK",
                                        timer: 3000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            }
                        });
                    }, "json")
                });
                // Bắt sự kiện nhấn phím Enter trong trường email
                $("#email_subscribe").keypress(function (e) {
                    if (e.which === 13) { // 13 là mã của phím Enter
                        $("#submitSubscribeHome").click();
                    }
                });
            });

            function checkValidEmail(e) {
                var a = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return a.test(e)
            }
        });
    </script>
    <style>

        .signup_mail .signup-section {
            display: flex;
            border-radius: var(--border-radius-card);
            overflow: hidden;
            max-height: 316px;
            height: 100%;
        }

        .signup_mail .signup-image img {
            width: 100%;
            height: 100%;
        }

        .signup_mail .signup-content {
            flex: 1;
            background-color: var(--secondary-light-color);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 16px;
        }

        .signup_mail .signup-content .form-control {
            border-radius: var(--border-radius-button);
            border: 1px solid var(--border-grey-color);
            background: var(--chroma-ffffff, #FFF);
        }

        .signup_mail .btn-signup {
            border-radius: var(--border-radius-button);
            background: var(--primary-18-babd);
            color: var(--chroma-ffffff);
            font-weight: var(--font-weight-normal);
        }

        .signup_mail .btn-signup:hover {
            background: var(--secondary-177-fa-4);
        }

        .form_btnsignup .form-control {
            flex: 1;
            min-width: 0;
            margin-right: 10px;
        }

        .signup_mail .signup-content .btn-primary {
            border-radius: var(--border-radius-circle);
            padding-left: 30px;
            padding-right: 30px;
        }

        .signup_mail .disclaimer {
            margin-top: 20px;
            color: var(--chroma-717171);
            font-size: var(--font-size-small);
        }

        #subcribe_msg {
            color: var(--primary-18-babd);
            margin-top: 10px;
        }
        .subscribe__form {
            max-width: 100%;
            display: flex;
        }

        @media (max-width: 991px) {
            .signup_mail .signup-section {
                display: block !important;
                max-height: unset !important;
            }
            .signup-image {
                padding: 0;
            }
        }
    </style>
{/literal}
