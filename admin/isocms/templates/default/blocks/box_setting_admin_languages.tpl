<div class="iso_box_setting">
    <div class="iso_box_head">
        <div class="iso_box_head d-flex justify-content-between">
            <div class="iso_box_title">
                <h1> {$core->get_Lang('Admin languages')} </h1>
                <span>{$core->get_Lang('Edit language details. The translation will be automatically saved when you are done.')}</span>
             </div>
        </div>
    </div>
    {if $lang_permission ne '0777'}
    <h2 style="color:red; text-align:center; border:1px dashed red; margin-bottom:20px; padding:10px;margin-top: 15px;">File này chưa CMOD 777!</h2>
    {/if}
</div>
<div class="iso_languages_body">
    <form method="post" action="">
        <input value="UpdateAdminLang" name="submit" type="hidden">
        <div class="iso_box_language">
            <div class="iso_lang_item">
                <div class="iso_lang_title d-flex align-items-center">
                    <span>{$core->get_Lang('Use with')}</span>
                    <div class="iso_lang_image">
                        <img src="{$URL_IMAGES}/translate.png" alt="Image">
                    </div>
                </div>
                <div class="iso_lang_body">
                    <div class="iso_lang_body_item iso_setting_languages">
                        <div class="iso_lang_input">
                            <select class="from_language iso_select_lang"></select>
                            <input type="text" class="key_google_translate" placeholder="{$core->get_Lang('Enter the word/paragraph you want to translate')}">
                        </div>
                        <div class="iso_greather_icon">
                            <i class="fa-solid fa-greater-than"></i>
                        </div>
                        <div class="iso_lang_input">
                            <select class="to_language iso_select_lang"></select>
                            <input type="text" class="value_google_translate" placeholder="{$core->get_Lang('Translation')}">
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <button class="iso_save_lang">{$core->get_Lang('Save')}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iso_lang_item">
                <div class="iso_lang_title d-flex align-items-center">
                    <span>{$core->get_Lang('Manual translation')}</span>
                </div>
                <div class="iso_lang_body">
                    <div class="iso_lang_body_item iso_setting_languages">
                        <div class="iso_lang_input">
                            <input type="text" class="key" placeholder="{$core->get_Lang('Key')}">
                        </div>
                        <div class="iso_greather_icon">
                            <i class="fa-solid fa-greater-than"></i>
                        </div>
                        <div class="iso_lang_input">
                            <input type="text" class="value" placeholder="{$core->get_Lang('Value')}">
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <button class="iso_save_lang">{$core->get_Lang('Save')}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iso_languages_content">
            <div class="iso_languages_top d-flex align-items-center justify-content-between">
                <div class="iso_lang_title d-flex align-items-center">
                    <span>{$core->get_Lang('Translated keys')}</span>
                </div>
                <button type="submit" name="button" class="iso_setting_submit">
                    <i class="icon-ok icon-white"></i>
                    <span>{$core->get_Lang('Save')}</span>
                </button>
            </div>
            <div class="iso_lst_languages">
                {foreach from=$lstItem key=key item=item}
                <div class="iso_item_languages iso_setting_languages">
                    <div class="iso_stt">
                        {assign var=iso_stt value=$key+1}
                        {$iso_stt}
                    </div>
                    <div class="iso_languages_inp">
                        <input class="key" type="text" name value="{$item.key}" placeholder="key" style="width:100%;" />
                        <input class="change" type="hidden" name="" value="{$item.key}" />
                        <input class="remove_key_lang" type="hidden" name="" value="{$item.key}" />
                    </div>
                    <div class="iso_greather_icon">
                        <i class="fa-solid fa-greater-than"></i>
                    </div>
                    <div class="iso_languages_inp">
                        <input class="value" type="text" name value="{$item.value}" placeholder="value" style="width:100%;" />
                    </div>
                    <div class="iso_lang_delete">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        {literal}
        <script type="text/javascript">
            $(function(){
                function addNameAttributes(keyInput, valueInput, changeInput) {
                    if (!keyInput.attr('name')) {
                        keyInput.attr('name', 'key[]');
                    }
                    if (!valueInput.attr('name')) {
                        valueInput.attr('name', 'value[]');
                    }
                    if (!changeInput.attr('change')) {
                        changeInput.attr('name', 'change[]');
                    }
                }

                $('.key').on('input', function() {
                    var keyInput = $(this);
                    var valueInput = keyInput.parents('.iso_setting_languages').find('input[placeholder="value"]');
                    var changeInput = keyInput.parents('.iso_setting_languages').find('.change');
                    addNameAttributes(keyInput, valueInput, changeInput);
                });

                $('.value').on('input', function() {
                    var valueInput = $(this);
                    var keyInput = valueInput.parents('.iso_setting_languages').find('input[placeholder="key"]');
                    var changeInput = valueInput.parents('.iso_setting_languages').find('.change');
                    addNameAttributes(keyInput, valueInput, changeInput);
                });

                function replaceHtml( string_to_replace ) 
                {
                    return string_to_replace.replace(/&nbsp;/g, ' ').replace(/<br.*?>/g, '\n');
                }

                $(document).on('click', '.iso_lang_delete', function(){
                    if(confirm(confirm_delete)){
                        $(this).parents('.iso_item_languages').hide();
                        $(this).parents('.iso_item_languages').find('.remove_key_lang').attr('name', 'delete[]')
                    }
                });

                let iso_setting_submit = $('.iso_languages_body .iso_setting_submit');
            });

        </script>
        {/literal}
    </form>
</div>

{literal}
<script>
    $(function(){
        // Lấy tất cả các mã ngôn ngữ
        const allLanguages = languages.getAllLanguageCode();

        // Thêm các ngôn ngữ vào dropdown
        let htmlLang = '';
        let htmlFromLang = `<option value="auto">${txtSelect}</option>`;
        allLanguages.forEach(function (langCode) {
            // Lấy thông tin ngôn ngữ
            const langInfo = languages.getLanguageInfo(langCode);

            // Tạo thẻ <option>
            htmlLang += `<option value="${langCode}">${langInfo.name} (${langInfo.nativeName})</option>`;
        });
        htmlFromLang += htmlLang;
       
        $('.from_language').html(htmlFromLang);
        $('.to_language').html(htmlLang);
        $('.to_language').val('en');
        
        $(document).on('keyup', '.key_google_translate', function(){
            translate(this);
        });

        $(document).on('change', '.iso_select_lang', function(){
            translate(this);
        });

        function translate($_this){
            let iso_lang_body_item = $($_this).parents('.iso_lang_body_item');
            let from_language = iso_lang_body_item.find('.from_language');
            let to_language = iso_lang_body_item.find('.to_language');
            let key_google_translate = iso_lang_body_item.find('.key_google_translate');
            let value_google_translate = iso_lang_body_item.find('.value_google_translate');

            const text = key_google_translate.val();
            const fromLanguage = from_language.val();
            const toLanguage = to_language.val();

            // Sử dụng Google Translate API
            const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${fromLanguage}&tl=${toLanguage}&dt=t&q=${encodeURIComponent(text)}`;

            $.getJSON(url, function (data) {
                const translation = data[0][0][0]; // Kết quả dịch
                value_google_translate.val(translation);
                key_google_translate.attr('name', 'key[]');
                value_google_translate.attr('name', 'value[]');
            }).fail(function (error) {
                console.error(error);
            });
        }
    });
</script> 
{/literal}