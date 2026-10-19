<section class="section_quick_contact section_box">
    <div class="container">
        <div class="quick_contact_box">
            <h2 class="section_box-title">{$core->get_Lang('Quick Contact')}</h2>
            <form method="post" action="{$extLang}" id="inquiry_form" class="inquiry_form">
                <div class="d-flex row">
                    <div class="col-md-4">
                        <input type="text" id="fullname" name="fullname" placeholder="* {$core->get_Lang('Full name')}" class="isoTxt txt required" >
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="email"  name="email" placeholder="* {$core->get_Lang('Email')}" class="isoTxt txt required" >
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="phone" name="phone" placeholder="* {$core->get_Lang('Phone number')}" class="isoTxt txt required" >
                    </div>
                </div>
                <div class="d-flex row">
                    <div class="col-lg-8">
                        <textarea type="text" id="description" rows="2" name="description" placeholder="* {$core->get_Lang('Description of your wishes')}" class="isoTxt txt required" ></textarea>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                        </div>
                        <input class="btn_Inquiry" id="submitInquiryHome" type="submit" name="btnSubmit" value="{$core->get_Lang('SUBMIT')}">

                        <input type="hidden" value="Sign me up" name="Submit">
                        <input type="hidden" value="QuickContact" name="QuickContact">
                        <input type="text"  style="display: none" id="input_check" class="input_check" value="">
                    </div>
                </div>
                {if $message}
                    <div class="error inquiry_msg">{$message}</div>
                {/if}
            </form>
            <div id="inquiry_msg" class="inquiry_msg"></div>
        </div>
    </div>
    <script>
        var path_ajax_script = '{$PCMS_URL}';
        var msg_fullname_required = "{$core->get_Lang('Your fullname should not be empty')}!";
        var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
        var msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
        var msg_phone_required = "{$core->get_Lang('Your phone should not be empty')}!";
        var msg_destination_required = "{$core->get_Lang('Your description of your wishes should not be empty')}!";
        var msg_success = "{$core->get_Lang('Send quick Tour inquiry success')}!";
        var msg_exits = "{$core->get_Lang('Email address already exists')}!";
        var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";

    </script>
    {literal}
        <script>
            $(function(){

                $("#submitInquiryHome").click(function(ev){
                    var $fullname = $(".section_quick_contact #fullname").val();
                    var $email = $(".section_quick_contact #email").val();
                    var $phone = $(".section_quick_contact #phone").val();
                    var $description = $(".section_quick_contact #description").val();
                    var $Inquiry_check = $(".section_quick_contact #Inquiry_check").val();
                    if($fullname.trim()==''){
                        $('.section_quick_contact #inquiry_msg').html(msg_fullname_required).fadeIn().delay(3000).fadeOut();
                        $(".section_quick_contact #fullname").focus();
                        return false;
                    }
                    if($email.trim()==''){
                        $('.section_quick_contact #inquiry_msg').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                        $(".section_quick_contact #email").focus();
                        return false;
                    }
                    if(checkValidEmail($email)==false){
                        $('.section_quick_contact #inquiry_msg').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                        $(".section_quick_contact #email").focus();
                        return false;
                    }
                    if($phone.trim()==''){
                        $('.section_quick_contact #inquiry_msg').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
                        $(".section_quick_contact #phone").focus();
                        return false;
                    }
                    if($description.trim()==''){
                        $('.section_quick_contact #inquiry_msg').html(msg_destination_required).fadeIn().delay(3000).fadeOut();
                        $(".section_quick_contact #description").focus();
                        return false;
                    }
                    if(grecaptcha.getResponse() == "") {
                        ev.preventDefault();
                        $('.section_quick_contact #inquiry_msg').html(msg_recapcha).fadeIn().delay(3000).fadeOut();
                        return false;
                    } else {
                        $('#inquiry_form').submit();
                    }

                    /*
                                    var adata = {
                                        'fullname' : $fullname,
                                        'email' : $email,
                                        'phone' : $phone,
                                        'description' : $description,
                                        'Inquiry_check' : $Inquiry_check,
                                        'g-recaptcha-response' : $('#g-recaptcha-response').val(),
                                    };
                                    $.ajax({
                                        type:'POST',
                                        url:path_ajax_script+'/index.php?mod=homepackage&act=ajSubmitInquiry&lang='+LANG_ID,
                                        data : adata,
                                        dataType:'html',
                                        success:function(html){
                                            if(html.indexOf("_SUCCESS") >= 0) {
                                                $('#inquiry_msg').html(msg_success).fadeIn(100, function(){
                                                    $(this).addClass('success');
                                                }).delay(4000).fadeOut(100, function(){
                                                    $(this).removeClass('success');
                                                    $('#inquiry_form')[0].reset();
                                                });
                                            } else {
                                                $('#inquiry_msg').html(msg_exits).fadeIn().delay(3000).fadeOut();
                                            }
                                        }
                                    });
                                    return false;*/
                });
            });
            function checkValidEmail(e) {
                var a = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return a.test(e)
            }
        </script>
        <style>
            .section_quick_contact {
                margin-top: 80px
            }
            .section_quick_contact .quick_contact_box {
                background: rgba(249, 161, 8, 0.05);
                border: 1px solid var(--main-color);
                border-radius: 8px;
                padding: 32px 53px 8px;
            }
            .section_quick_contact .section_box-title {
                font-size: 24px;
                font-weight: 600;
                line-height: 36px;
                letter-spacing: 0em;
                margin-bottom: 25px;
                text-align: center;
            }
            .inquiry_form input,.inquiry_form textarea {
                background: #FFF;
                margin-bottom:32px;
                border: 1px solid rgba(204, 204, 204, 1);
                border-radius: 4px;
                height: 50px;
                width: 100%;
                padding:13px 15px; font-size: 16px; line-height: 24px;
                vertical-align: top;
            }
            .inquiry_form textarea {
                height: 136px;
            }
            .inquiry_form .g-recaptcha {
                margin-bottom: 7px;
            }
            .inquiry_form input.btn_Inquiry {
                background: var(--main-bg-color);
                border-radius: 4px;
                font-weight: 600;
                font-size: 18px;
                text-align: center;
                line-height: 50px;
                color: #FFF;
                border: 0;
                margin-bottom: 0;
                padding: 0;
            }
            .inquiry_form input.btn_Inquiry:hover {
                opacity:0.8;
            }
            .inquiry_msg {
                color: red
            }
            .blog_detail_body .section_box.testimonials__box{background: #fff;padding-top: 50px;}

            @media screen and (max-width:767px) {
                .section_quick_contact{margin-top: 30px;}
                .section_quick_contact .quick_contact_box {
                    background: rgba(249, 161, 8, 0.05);
                    border: 1px solid var(--main-color);
                    border-radius: 8px;
                    padding: 15px 15px 15px;
                }
                .inquiry_form input, .inquiry_form textarea,.inquiry_form .g-recaptcha{margin-bottom: 15px;}
                .blog_detail_body .section_box.testimonials__box{padding: 0 0 80px}
            }
        </style>
    {/literal}
</section>