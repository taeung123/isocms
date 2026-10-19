<main class="main_contact page_container">
    <div class="v_contact_title">
        <div class="container">
            <h1 class="title">{$core->get_Lang('Contact')}</h1>
            <p class="intro_contact">
                {$core->get_Lang('If you have any questions and need support, leave your information and we will get back to you')}
            </p>
        </div>
    </div>
    <div class="v_contact_form">
        <div class="container v_contact_container">
            <form method="post" id="EnquiryForm" class="v_contact_box_form" data-parsley-validate>
                <input type="hidden" class="via_key_h" name="via_key" value="">
                <input type="hidden" class="via_key_h" name="via_from_time" value="{$from_time|escape}">
                <input type="hidden" class="via_key_h" name="via_signature" value="{$signature|escape}">
                <input type="hidden" class="via_key_h" name="via_js_token" value="{$js_token|escape}">
                <input type="hidden" class="via_key_h" name="via_spam_csrf" value="{$spam_csrf|escape}">
                
                <input type="text" class="v_contact_hidden" name="v_contact_k" value="">
                <input type="text" class="v_contact_hidden" name="v_contact_c" value="{$clsISO->generateCsrfToken()}">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="v_contact_information">
                            {$core->getBlock('contact/tour')}
                            {$core->getBlock('contact/hotel')}
                            {$core->getBlock('contact/cruise')}
                            <div class="v_info_box">
                                <h2>{$core->get_Lang('Contact Information')}</h2>
                                <p>{$core->get_Lang('Finding us is easy. Call us now if you are in a hurry.')}</p>
                                <div class="v_info">
                                    <div class="v_info_item">
                                        <i class="fa-sharp fa-solid fa-location-dot"></i>
                                        {assign var=CompanyAddress1 value=CompanyAddress1_|cat:$_LANG_ID}
                                        {assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
                                        <a target="_blank" href="https://maps.google.it/maps?q={$clsConfiguration->getValue($CompanyAddress1)}" title="{$clsConfiguration->getValue($CompanyAddress)}">{$clsConfiguration->getValue($CompanyAddress)}</a>
                                    </div>
                                    <div class="v_info_item">
                                        <i class="fa-sharp-duotone fa-solid fa-phone"></i>
                                        <a title="{$clsConfiguration->getValue('CompanyHotline')}" href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
                                    </div>
                                    <div class="v_info_item">
                                        <i class="fa-solid fa-envelope"></i>
                                        <a title="{$clsConfiguration->getValue('CompanyEmail')}" href="mailto:{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <p class="v_contact_txt_red">{$core->get_Lang('Please enter all information containing')} (*)</p>
                        <div class="v_contact_form_info">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="v_form_item">
                                        <label for="title">
                                            {$core->get_Lang('Title')}<span class="red"> *</span>
                                        </label>
                                        <select id="title" name="title" required data-parsley-required-message="{$core->get_Lang('Please select title')}">
                                            {$clsISO->makeSelectTitle($title|default:'Mr')}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="v_form_item">
                                        <label for="fullname">
                                            {$core->get_Lang('Full name')}<span class="red"> *</span>
                                        </label>
                                        <input id="fullname" name="fullname" type="text" value="{$fullname|default:''}" required data-parsley-minlength="3" data-parsley-required-message="{$core->get_Lang('Full name required')}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="v_form_item">
                                        <label for="birthday_contact">
                                            {$core->get_Lang('Date of Birth')}<span class="red"> *</span>
                                        </label>
                                        <input type="text" name="birthday_contact" id="birthday_contact" required data-parsley-pattern-message="DD/MM/YYYY">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="v_form_item">
                                        <label for="country_id">
                                            {$core->get_Lang('Country')}<span class="red"> *</span>
                                        </label>
                                        <select name="country_id" id="country_id" required data-parsley-required-message="{$core->get_Lang('Please select country')}">
                                            <option value="0">{$core->get_Lang('Selected')}</option>
                                            {foreach from=$lstCountryRegion key=key item=item} 
                                                <option {if !empty($country_id) && $country_id == $item.country_id}selected{/if} value="{$item.country_id}">{$item.title}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="v_form_item">
                                         <label for="email">
                                            {$core->get_Lang('Email')}<span class="red"> *</span>
                                        </label>
                                        <input id="email" name="email" type="text" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" value="{$email|default:''}" required data-parsley-type="email">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="v_form_item">
                                        <label for="phone">
                                            {$core->get_Lang('Telephone')}<span class="red"> *</span>
                                        </label>
                                        <input id="phone" name="phone" type="text" value="{$phone|default:''}" required data-parsley-pattern-message="Invalid phone number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="v_form_item">
                                        <label  for="Comments">
                                            {$core->get_Lang('Messager')}
                                        </label>
                                        <textarea id="Comments" name="Comments" rows="2" placeholder="{$core->get_Lang('Enter what you want, ask for')}....">{$Comments|default:''}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center v_contact_form_btn">
                            <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                            <input type="hidden" name="plantrip" value="plantrip" />
                            <input type="hidden" name="hidden_field" value="" />
                            <button type="submit" class="form-control send_contact btn_main" id="SubmitEnquiry">
                                {$core->get_Lang('Send')}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/parsleyjs" defer></script>
{literal}
<script>
document.addEventListener("DOMContentLoaded", function () {
    $(function () {
        $("#birthday_contact").datepicker({
            dateFormat: "dd/mm/yy"
        });
        /* Khởi tạo Parsley */
        let parsleyForm = $('#EnquiryForm').parsley({
            classHandler: function (field) {
                return field.$element.closest('.v_form_item');
            },
            errorsContainer: function (field) {
                return field.$element.closest('.v_form_item');
            }
        });
        /* Khi lỗi */
        $('#EnquiryForm').on('field:error', function (fieldInstance) {
            let parent =
                fieldInstance.$element.closest('.v_form_item');
            parent.addClass('has-error');
        });
        /* Khi hợp lệ */
        $('#EnquiryForm').on('field:success', function (fieldInstance) {
            let parent =
                fieldInstance.$element.closest('.v_form_item');
            parent.removeClass('has-error');
        });
        /* Validate reCAPTCHA */
        $('#EnquiryForm').on('submit', function (e) {
            let response = grecaptcha.getResponse();
            if (response.length === 0) {
                alert("{$core->get_Lang('Please verify captcha')}");
                e.preventDefault();
                return false;
            }
        });

        $('.delete_service').click(function (){
            let type =$(this).data('type');
            $.confirm({
                title: Confirm,
                content: remove_text,
                minHeight: 100,
                maxHeight: 200,
                buttons: {
                    Confirm: {
                        text: Confirm,
                        action: function(){
                            $.ajax({
                                type:'POST',
                                url: path_ajax_script+'/index.php?mod='+mod+'&act=deleteService&lang='+LANG_ID,
                                data:{type:type},
                                dataType:'json',
                                success: function (res){
                                    if(res.msg == 'ok'){
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    },
                    Cancel: {
                        text: Cancel
                    }
                }
            });
        });
    });
});
</script>
<style>
    .v_contact_hidden {
        display: none;
    }
    .v_contact_title {
        padding: 40px 0;
        text-align: center;
        background: var(--main-color);
    }
    .v_contact_title .title,
    .v_contact_title .intro_contact {
        color: var(--light-color);
    }
    .v_contact_form {
        position: relative;
    }
    .v_contact_form::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 20%;
        background: var(--main-color);
    }
    .v_contact_box_form {
        position: relative;
        z-index: 1;
        background: #FFF;
        padding: 20px;
        box-shadow: var(--box-shadow);
        border-radius: var(--border-radius-card-2);
    }
    .v_contact_information {
        padding: 20px;
        background: var(--main-color);
        border-radius: var(--border-radius-card-2);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .v_contact_information::before {
        background: linear-gradient(146.95deg, rgba(255, 255, 255, 0.6) 17.63%, rgba(255, 255, 255, 0) 96.2%);
        content: "";
        position: absolute;
        bottom: -30px;
        right: -30px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        z-index: 0;
        opacity: 0.4;
    }
    .v_contact_information h2 {
        color: var(--light-color);
        margin-bottom: 8px;
    }
    .v_contact_information .v_info_box p {
        color: var(--light-color);
        margin-bottom: 30px;
    }
    .v_contact_information .v_info {
        display: flex;
        flex-direction: column;
        color: var(--light-color);
        gap: 15px;
    }
    .v_contact_information .v_info_item {
        display: flex;
        align-items: start;
        gap: 10px;
    }
    .v_contact_information .v_info i {
        margin-top: 3px;
        width: 20px;
    }
    .v_contact_information .v_info a {
        color: var(--light-color);
    }
    .v_contact_information .infor_tour p {
        margin-bottom: 10px;
    }
    .v_contact_txt_red {
        color: var(--error-color);
        margin-bottom: 15px;
    }
    .v_form_item {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        padding: 5px 10px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-button);
    }
    .v_form_item label {
        font-size: var(--font-size-smaller);
    }
    .v_form_item input, .v_form_item select, .v_form_item textarea {
        border: unset;
    }
    .v_form_item .red { 
        color: var(--error-color);
    }
    .v_contact_form_btn {
        gap: 15px;
    }
    .send_contact {
        width: fit-content;
        padding: 10px 50px;
        font-weight: var(--font-weight-semibold);
    }
    .v_form_item textarea {
        height: 100px;
    }
    .v_form_item.has-error,.v_form_item.parsley-error {
        border-color: var(--error-color);
    }
    .parsley-errors-list {
        display: none;
    }
    .v_contact_information .infor_tour .infor_tour_border {
        padding: 5px 0;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-button);
        margin-bottom: 10px;
    }
    .v_contact_information .infor_tour .infor_tour_border p {
        margin-bottom: 0;
    }
</style> 
{/literal}
