<div id="hnv_setting_companyprofile" role="tabpanel">
    <div class="hnv_setting_main_right_title">
        <h2>{$core->get_Lang('Company Profile')}</h2>
    </div>
    <div class="hnv_setting_main_right_content">
        <div id="hnv_setting_companyprofile_main">
            <form method="post" id="repeaterForm">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb_24">
                                    {assign var=CompanyName value=CompanyName_|cat:$_LANG_ID}
                                    <label for="fullname_company"
                                           class="form-label">{$core->get_Lang('Full company name')}</label>
                                    <input type="text" class="form-control" id="iso-fullname_company"
                                           name="iso-{$CompanyName}"
                                           value="{$clsConfiguration->getValue($CompanyName)}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb_24">
                                    {assign var=CompanyNameBrief value=CompanyNameBrief_|cat:$_LANG_ID}
                                    <label for="briefname_company"
                                           class="form-label">{$core->get_Lang('Brief company name')}</label>
                                    <input type="text" class="form-control" id="iso-briefname_company"
                                           name="iso-{$CompanyNameBrief}"
                                           value="{$clsConfiguration->getValue($CompanyNameBrief)}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb_24">
                                    <label for="business_license"
                                           class="form-label">{$core->get_Lang('Business license')}</label>
                                    <input type="text" class="form-control" id="iso-business_license" name="iso-GPKD"
                                           value="{$clsConfiguration->getValue('GPKD')}">
                                </div>
                                <div class="mb_24">
                                    <label for="website" class="form-label">{$core->get_Lang('Website')}</label>
                                    <input type="text" class="form-control" id="iso-website" name="iso-CompanyWebsite"
                                           value="{$clsConfiguration->getValue('CompanyWebsite')}">
                                </div>
                                <div class="mb_24">
                                    <label for="phone_number"
                                           class="form-label">{$core->get_Lang('Phone number')}</label>
                                    <input type="text" class="form-control" id="iso-phone_number"
                                           name="iso-CompanyPhone"
                                           value="{$clsConfiguration->getValue('CompanyPhone')}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb_24">
                                    <label for="founder" class="form-label">{$core->get_Lang('Founder')}</label>
                                    <input type="text" class="form-control" id="iso-founder" name="iso-Founder"
                                           value="{$clsConfiguration->getValue('Founder')}">
                                </div>
                                <div class="mb_24">
                                    <label for="email" class="form-label">{$core->get_Lang('Email')}</label>
                                    <input type="email" class="form-control" id="iso-email" name="iso-CompanyEmail"
                                           value="{$clsConfiguration->getValue('CompanyEmail')}">
                                </div>
                                <div class="mb_24">
                                    <label for="hotline" class="form-label">{$core->get_Lang('Hotline')}</label>
                                    <input type="tel" class="form-control" id="iso-hotline" name="iso-CompanyHotline"
                                           value="{$clsConfiguration->getValue('CompanyHotline')}">
                                </div>
                            </div>
                            <div class="hnv_setting_companyprofile_main_times">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="mb_24">
                                            <label for="hours_open"
                                                   class="form-label">{$core->get_Lang('Opening hours')}</label>
                                            <input type="time" class="time_open time_css" id="open_time" />

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="mb_24">
                                            <label for="hours_closing"
                                                   class="form-label">{$core->get_Lang('Closing hours')}</label>
                                            <input type="time" class="time_close time_css" id="close_time" />

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="mb_24">
                                            <label for="iso-currency"
                                                   class="form-label">{$core->get_Lang('Currency')}</label>
                                            <select name="iso-currency" class="form-control form-select">
                                                {assign var=currency value=$clsConfiguration->getValue('Currency')}
                                                {section name=j loop=$allUnitProperty}
                                                    <option value="{$allUnitProperty[j].property_id}"
                                                            {if $currency eq $allUnitProperty[j].property_id}selected{/if}>
                                                        {$allUnitProperty[j].property_code}
                                                        ({$allUnitProperty[j].aliases})
                                                    </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb_24">
                                    <label for="api_google_map" class="form-label">
                                        {$core->get_Lang('API Google Maps')}.
                                        <a href="//developers.google.com/maps/documentation/javascript/get-api-key"
                                           target="_blank" title="{$core->get_Lang('Instructions')}">
                                            ({$core->get_Lang('Instructions')})
                                        </a>
                                    </label>
                                    <input type="text" class="form-control" id="iso-api_google_map"
                                           name="iso-API_GOOGLE_MAPS"
                                           value="{$clsConfiguration->getValue('API_GOOGLE_MAPS')}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb_24">
                                    <label for="check_ip" class="form-label">{$core->get_Lang('Check IP')}</label>
                                    <input type="text" class="form-control" id="iso-check_ip" name="iso-IP_ONLINE"
                                           value="{$clsConfiguration->getValue('IP_ONLINE')}"
                                           placeholder="116.99.35.172,116.99.35.171">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb_24">
                                    <label for="IBEKey_roducts"
                                           class="form-label">{$core->get_Lang('IBEKey Products')}</label>
                                    <input type="text" class="form-control" id="iso-IBEKey_roducts"
                                           value="{$clsConfiguration->getValue('IBEproductKey')}"
                                           placeholder="y62e9p4h0qvnaoi">
                                </div>
                            </div>
                            <div class="hnv_setting_companyprofile_main_logo">
                                <div class="hnv_setting_companyprofile_main_logo_title mb_24">
                                    <h3>{$core->get_Lang('Logo')}</h3>
                                </div>
                                <div class="hnv_setting_companyprofile_main_logo_content">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="hnv_setting_companyprofile_main_logo_content_item mb_30">
                                                <div class="hnv_setting_companyprofile_main_logo_content_left">
                                                    <label>{$core->get_Lang('Header Logo')}</label>
                                                    <p>{$core->get_Lang('W x H')}: 200px x 50px</p>
                                                </div>
                                                <div id="uploadSection"
                                                     class="hnv_setting_companyprofile_main_logo_content_right"
                                                     onclick="document.getElementById('fileInput').click()">
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_image">
                                                        <img id="previewImage" src="/uploads/AdminButton/bi_image.png"
                                                             width="24" height="24" alt="Image">
                                                    </div>
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_text">
                                                        Upload
                                                    </div>
                                                    <!-- Hidden file input -->
                                                    <input type="file" id="fileInput" style="display: none;"
                                                           accept="image/*" onchange="handleFileChange(event)">
                                                </div>

                                                <!-- Display Image and Trash Icon -->
                                                <div id="uploadedImageContainer" style="display:none;">
                                                    <img id="uploadedImage" class="isoman_img_pop" name="iso-HeaderLogo"
                                                         src="{$clsConfiguration->getValue('HeaderLogo')}" width="100"
                                                         height="54" alt="Uploaded Image">
                                                    <button id="HeaderdeleteButton" onclick="deleteImage(event)">
                                                        <a href="javascript:void(0);"
                                                           class="hnv_setting_companyprofile_main_logo_content_right_upload_delete"
                                                           title="Delete">
                                                            <i class="fa-sharp fa-regular fa-trash"></i>                                                        </a>
                                                        </a>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="hnv_setting_companyprofile_main_logo_content_item mb_30">
                                                <div class="hnv_setting_companyprofile_main_logo_content_left">
                                                    <label>{$core->get_Lang('Footer Logo')}</label>
                                                    <p>{$core->get_Lang('W x H')}: 200px x 50px</p>
                                                </div>

                                                <!-- Phần upload Footer Logo -->
                                                <div id="footerUploadSection"
                                                     class="hnv_setting_companyprofile_main_logo_content_right"
                                                     onclick="document.getElementById('footerFileInput').click()">
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_image">
                                                        <img id="footerPreviewImage"
                                                             src="/uploads/AdminButton/bi_image.png" width="24"
                                                             height="24" alt="Image">
                                                    </div>
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_text">
                                                        Upload
                                                    </div>
                                                    <!-- Hidden file input -->
                                                    <input type="file" id="footerFileInput" style="display: none;"
                                                           accept="image/*" onchange="handleFooterFileChange(event)">
                                                </div>

                                                <!-- Display Footer Image and Trash Icon -->
                                                <div id="footerUploadedImageContainer" style="display:none;">
                                                    <img id="footerUploadedImage" class="isoman_img_pop"
                                                         name="iso-FooterLogo"
                                                         src="{$clsConfiguration->getValue('FooterLogo')}" width="108"
                                                         height="54" alt="Uploaded Footer Image">
                                                    <button id="footerDeleteButton" onclick="deleteFooterImage(event)">
                                                        <a href="javascript:void(0);"
                                                           class="hnv_setting_companyprofile_main_logo_content_right_upload_delete"
                                                           title="Delete">
                                                            <i class="fa-sharp fa-regular fa-trash"></i>                                                        </a>
                                                        </a>
                                                    </button>
                                                </div>
                                            </div>


                                            <div class="hnv_setting_companyprofile_main_logo_content_item mb_30">
                                                <div class="hnv_setting_companyprofile_main_logo_content_left">
                                                    <label>{$core->get_Lang('Logo pop-up')}</label>
                                                    <p>{$core->get_Lang('W x H')}: 200px x 50px</p>
                                                </div>

                                                <!-- Phần upload Logo Pop-up -->
                                                <div id="logoPopupUploadSection"
                                                     class="hnv_setting_companyprofile_main_logo_content_right"
                                                     onclick="document.getElementById('logoPopupFileInput').click()">
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_image">
                                                        <img id="logoPopupPreviewImage"
                                                             src="/uploads/AdminButton/bi_image.png" width="24"
                                                             height="24" alt="Image">
                                                    </div>
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_text">
                                                        Upload
                                                    </div>
                                                    <!-- Hidden file input -->
                                                    <input type="file" id="logoPopupFileInput" style="display: none;"
                                                           accept="image/*" onchange="handleLogoPopupFileChange(event)">
                                                </div>

                                                <!-- Display Logo Pop-up Image and Trash Icon -->
                                                <div id="logoPopupUploadedImageContainer" style="display:none;">
                                                    <img id="logoPopupUploadedImage" class="isoman_img_pop"
                                                         name="iso-LogoPopup"
                                                         src="{$clsConfiguration->getValue('PopupLogo')}" width="108"
                                                         height="54" alt="Uploaded Logo Pop-up Image">

                                                    <button id="logoPopupDeleteButton"
                                                            onclick="deleteLogoPopupImage(event)">
                                                        <a href="javascript:void(0);"
                                                           class="hnv_setting_companyprofile_main_logo_content_right_upload_delete"
                                                           title="Delete">
                                                            <i class="fa-sharp fa-regular fa-trash"></i>                                                        </a>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="hnv_setting_companyprofile_main_logo_content_item mb-30">
                                                <div class="hnv_setting_companyprofile_main_logo_content_left">
                                                    <label>{$core->get_Lang('Share Logo')}</label>
                                                    <p>{$core->get_Lang('W x H')}: 500px x 261px</p>
                                                </div>

                                                <!-- Phần upload Share Logo -->
                                                <div id="shareLogoUploadSection"
                                                     class="hnv_setting_companyprofile_main_logo_content_right"
                                                     onclick="document.getElementById('shareLogoFileInput').click()">
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_image">
                                                        <img id="shareLogoPreviewImage"
                                                             src="/uploads/AdminButton/bi_image.png" width="24"
                                                             height="24" alt="Image">
                                                    </div>
                                                    <div class="hnv_setting_companyprofile_main_logo_content_right_text">
                                                        Upload
                                                    </div>
                                                    <!-- Hidden file input -->
                                                    <input type="file" id="shareLogoFileInput" style="display: none;"
                                                           accept="image/*" onchange="handleShareLogoFileChange(event)">
                                                </div>

                                                <!-- Display Share Logo Image and Trash Icon -->
                                                <div id="shareLogoUploadedImageContainer" style="display:none;">
                                                    <img id="shareLogoUploadedImage" class="isoman_img_pop"
                                                         name="iso-ShareLogo"
                                                         src="{$clsConfiguration->getValue('ImageShareSocial')}"
                                                         width="500" height="261" alt="Uploaded Share Logo">
                                                    <button id="shareLogoDeleteButton"
                                                            onclick="deleteShareLogoImage(event)">
                                                        <a href="javascript:void(0);"
                                                           class="hnv_setting_companyprofile_main_logo_content_right_upload_delete"
                                                           title="Delete">
                                                            <i class="fa-sharp fa-regular fa-trash"></i>                                                        </a>
                                                        </a>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hnv_setting_companyprofile_main_address">
                                <div class="hnv_setting_companyprofile_main_address_title mb_24">
                                    <h3>{$core->get_Lang('Company address')}</h3>
                                </div>
                                <div class="hnv_setting_companyprofile_main_address_content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            {assign var=CompanyAddress1 value=CompanyAddress1_|cat:$_LANG_ID}
                                            <div class="mb_20">
                                                <label for="address_main"
                                                       class="form-label">{$core->get_Lang('Address (main)')}</label>
                                                <input type="text" class="form-control" id="iso-address_main" name="iso-{$CompanyAddress1}"
                                                       value="{$clsConfiguration->getValue($CompanyAddress1)}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb_24">
                                                <label for="company_longitude"
                                                       class="form-label">{$core->get_Lang('Longitude')}</label>
                                                <input type="text" class="form-control" id="iso-company_longitude"
                                                       name="iso-CompanyMapLo" id="map_lo"
                                                       value="{$clsConfiguration->getValue('CompanyMapLo')}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="mb_24">
                                                <label for="company_latitude"
                                                       class="form-label">{$core->get_Lang('Latitude')}</label>
                                                <input type="text" class="form-control" id="iso-company_latitude"
                                                       name="iso-CompanyMapLa" id="map_la"
                                                       value="{$clsConfiguration->getValue('CompanyMapLa')}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb_24">
                                                <div style="width:100%; height:206px;" id="map_canvas">
                                                    <iframe width="100%" height="100%" frameborder="0" scrolling="no"
                                                            marginheight="0"
                                                            marginwidth="0"
                                                            src="https://maps.google.it/maps?q=VietISO Company, ÄÆ°á»ng Tam Trinh, Minh Khai, Hai BÃ  TrÆ°ng, HÃ  Ná»™i, Viá»‡t Nam&output=embed"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hnv_setting_companyprofile_main_address_content_other"
                                         data-repeater-list="group-address">
                                        <div data-repeater-item class="mb_24">
                                            <div class="row">
                                                <div class="col-10">
                                                    <label for="input"
                                                           class="form-label">{$core->get_Lang('Address other')}</label>
                                                    <input type="text" class="form-control" name="address_other">
                                                </div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <a href="javascript:void(0);"
                                                       class="hnv_setting_companyprofile_main_address_content_other_delete"
                                                       data-repeater-delete title="{$core->get_Lang('Delete')}">
                                                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);"
                                       class="hnv_setting_companyprofile_main_address_content_other_more"
                                       data-repeater-create>
                                        + {$core->get_Lang('Add address')}
                                    </a>

                                </div>
                            </div>
                        </div>
                        <input type="submit" class="hnv_btn_submit_form" name="hnv_btn_submit_form"
                               value="{$core->get_Lang('Save')}">
                        <input type="hidden" name="hnv_company_setting_profile" value="hnv_company_setting_profile">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
{literal}
    <style>
        .hnv_setting_companyprofile_main_logo {
            border-top: 2px dashed #ccc;
            border-bottom: 2px dashed #ccc;
            padding-top: 24px;
            padding-bottom: 24px;
        }

        .hnv_setting_companyprofile_main_logo_content_item {
            display: flex;
            justify-content: space-between;
        }

        .hnv_setting_companyprofile_main_logo_content_left label {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
            margin-bottom: 3px;
        }

        .hnv_setting_companyprofile_main_logo_content_left p {
            color: var(--chroma-717171, #717171);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .hnv_setting_companyprofile_main_logo_content_right {
            border-radius: 8px;
            border: 2px dashed var(--chroma-dadfe-6, #DADFE6);
            background: var(--secondary-e-8-f-8-f-8, #E8F8F8);
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 15px 11px;
            color: var(--primary-18-babd, #18BABD);
            -webkit-text-stroke-width: 1;
            -webkit-text-stroke-color: var(--chroma-f-6-f-6-fa, #F6F6FA);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 24px */
            cursor: pointer;
        }

        .hnv_setting_companyprofile_main_logo_content_right_upload {
            width: 108px;
            height: 54px;
            border-radius: 8px;
            border: 1px solid var(--chroma-dadfe-6, #DADFE6);
            position: relative;
        }

        .hnv_setting_companyprofile_main_logo_content_right_upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hnv_setting_companyprofile_main_logo_content_right_upload_delete {
            /*position: absolute;*/
            position: relative;
            /*top: 36%;*/
            top: 9px;
            transform: translateY(-50%);
            /*right: -30px;*/
            left: 15px;
            /*padding: 3px;*/
            padding: 9px;
            font-size: 22px;
            fill: #FFF;
            filter: drop-shadow(0px 1px 2px rgba(0, 0, 0, 0.15));
            color: #FF002A !important;
            background: #ffffff;
            border-radius: 50%;
        }

        .hnv_setting_companyprofile_main_address_content_other_delete {
            font-size: 22px;
            color: #FF002A !important;
            margin-top: 25px;
        }

        .hnv_setting_companyprofile_main_address_content_other_more {
            color: #FFF !important;
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 24px */
            display: inline-flex;
            padding: 12px 16px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
        }

        .hnv_setting_companyprofile_main_address_content_other_more:hover {
            text-decoration: unset;
        }

        .hnv_setting_companyprofile_main_address {
            padding: 24px 0;
        }

        .hnv_setting_companyprofile_main_times {
            padding-top: 24px;
            border-top: 2px dashed #ccc;
            border-bottom: 2px dashed #ccc;
            margin-bottom: 24px;
        }


        #HeaderdeleteButton, #footerDeleteButton, #logoPopupDeleteButton, #shareLogoDeleteButton {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        #uploadedImage, #footerUploadedImage, #logoPopupUploadedImage, #shareLogoUploadedImage {
            padding: 5px;
            object-fit: cover;
            width: 108px;
            height: 54px;
            border-radius: 8px;
            border: 1px solid var(--chroma-dadfe-6, #DADFE6);
        }

        .form-control.form-select {
            height: 100%;
        }

        .time_css {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            background: #FFFFFF;
        }


        @media (min-width: 992px) and (max-width: 1199px) {
        }

        @media (min-width: 375px) {
        }

        @media (min-width: 576px) {
        }

        @media (min-width: 768px) {
        }

        @media (min-width: 992px) {
        }

        @media (min-width: 1200px) {
        }

        @media (min-width: 1401px) {
        }

        @media (max-width: 1400px) {
        }

        @media (max-width: 1200px) {
        }

        @media (max-width: 992px) {
        }

        @media (max-width: 768px) {
        }

        @media (max-width: 576px) {
        }

        @media (max-width: 375px) {
        }
    </style>
    <script>
        /*
        $(document).ready(function () {
            $('#repeaterForm').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'foo'
                },
                show: function () {
                    $(this).slideDown(); // slideDown trong jQuery 1.9 vẫn hỗ trợ
                },
                hide: function (deleteElement) {
                    var self = this; // Lưu trữ tham chiếu đến phần tử
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(self).slideUp(function () {
                            if (typeof deleteElement === "function") {
                                deleteElement(); // Gọi callback sau khi hoàn tất
                            }
                        });
                    }
                },
                ready: function (setIndexes) {
                    // Để trống nếu không có logic bổ sung
                }
            });
        });
         */

        $(document).ready(function () {
            // Thêm địa chỉ mới
            $('.hnv_setting_companyprofile_main_address_content_other_more').on('click', function () {
                // Clone phần tử mẫu
                var newItem = $('.hnv_setting_companyprofile_main_address_content_other')
                    .find('[data-repeater-item]')
                    .first()
                    .clone(); // Tạo bản sao từ phần tử mẫu

                // Xóa dữ liệu cũ và thiết lập mặc định
                newItem.find('input').val('');
                newItem.show(); // Hiển thị phần tử mới nếu đang bị ẩn

                // Thêm phần tử mới vào danh sách
                $('.hnv_setting_companyprofile_main_address_content_other').append(newItem);
            });

            // Xóa địa chỉ
            $('.hnv_setting_companyprofile_main_address_content_other').on('click', '[data-repeater-delete]', function () {
                if (confirm('Are you sure you want to delete this address?')) {
                    $(this).closest('[data-repeater-item]').slideUp(function () {
                        $(this).remove(); // Xóa phần tử sau khi ẩn
                    });
                }
            });
        });

        // Logo Header

        function checkImageStatus() {
            // Lấy src của ảnh đã upload
            const uploadedImageSrc = $('#uploadedImage').attr('src');

            // Kiểm tra nếu src là ảnh hợp lệ (không phải ảnh mặc định)
            if (uploadedImageSrc && uploadedImageSrc !== '/uploads/AdminButton/bi_image.png' && uploadedImageSrc !== '') {
                // Ảnh đã có, ẩn phần upload và hiển thị ảnh với nút xóa
                $('#uploadSection').hide(); // Ẩn phần upload
                $('#uploadedImageContainer').show(); // Hiển thị ảnh đã upload
            } else {
                // Nếu không có ảnh, hiển thị phần upload
                $('#uploadSection').show();
                $('#uploadedImageContainer').hide(); // Ẩn ảnh đã upload
            }
        }

        function handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    const base64Image = reader.result;

                    // Cập nhật ảnh preview
                    $('#previewImage').attr('src', base64Image);

                    // Cập nhật ảnh đã upload và hiển thị container ảnh
                    $('#uploadedImage').attr('src', base64Image);
                    $('#uploadedImageContainer').show(); // Hiển thị ảnh đã upload

                    // Ẩn phần upload
                    $('#uploadSection').hide();
                };
                reader.readAsDataURL(file);
            }
        }

        // Hàm xóa ảnh và quay lại phần upload
        function deleteImage() {
            // Ngăn chặn hành động mặc định của thẻ <a> (reload trang)
            event.preventDefault();
            // Hiện hộp thoại xác nhận
            if (confirm("Are you sure you want to delete this image?")) {
                // Nếu người dùng xác nhận, xóa ảnh và hiển thị lại phần upload
                $('#uploadedImageContainer').hide();
                $('#uploadSection').show();

                // Cập nhật lại ảnh mặc định cho preview và ảnh đã upload
                $('#previewImage').attr('src', '/uploads/AdminButton/bi_image.png');
                $('#uploadedImage').attr('src', '/uploads/AdminButton/bi_image.png');
            } else {
                // Nếu người dùng không xác nhận, không làm gì cả
                console.log("Image deletion cancelled.");
            }

        }

        // Kiểm tra nếu có ảnh khi trang tải
        $(document).ready(function () {
            // Kiểm tra khi trang tải để xác định trạng thái ảnh
            checkImageStatus();
        });

        // Logo Footer

        function handleFooterFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    const base64Image = reader.result;

                    // Cập nhật ảnh đã upload và hiển thị container ảnh
                    $('#footerUploadedImage').attr('src', base64Image);
                    $('#footerUploadedImageContainer').show(); // Hiển thị ảnh đã upload

                    // Ẩn phần upload
                    $('#footerUploadSection').hide(); // Ẩn phần upload
                };
                reader.readAsDataURL(file);
            }
        }

        function deleteFooterImage(event) {
            // Ngăn hành động mặc định của thẻ <a>
            event.preventDefault();

            // Hiện hộp thoại xác nhận
            if (confirm("Are you sure you want to delete this footer image?")) {
                // Nếu người dùng xác nhận, xóa ảnh và hiển thị lại phần upload
                $('#footerUploadedImageContainer').hide();
                $('#footerUploadSection').show();

                // Cập nhật lại ảnh mặc định cho preview và ảnh đã upload
                $('#footerPreviewImage').attr('src', '/uploads/AdminButton/bi_image.png');
                $('#footerUploadedImage').attr('src', '/uploads/AdminButton/bi_image.png');
            } else {
                // Nếu người dùng không xác nhận, không làm gì cả
                console.log("Footer image deletion cancelled.");
            }
        }

        function checkFooterImageStatus() {
            const uploadedFooterImageSrc = $('#footerUploadedImage').attr('src'); // Lấy src của ảnh đã upload

            // Kiểm tra nếu src là ảnh hợp lệ (không phải ảnh mặc định)
            if (uploadedFooterImageSrc && uploadedFooterImageSrc !== '/uploads/AdminButton/bi_image.png' && uploadedFooterImageSrc !== '') {
                // Ảnh đã có, ẩn phần upload và hiển thị ảnh với nút xóa
                $('#footerUploadSection').hide(); // Ẩn phần upload
                $('#footerUploadedImageContainer').show(); // Hiển thị ảnh đã upload
            } else {
                // Nếu không có ảnh, hiển thị phần upload
                $('#footerUploadSection').show();
                $('#footerUploadedImageContainer').hide(); // Ẩn ảnh đã upload
            }
        }

        // Kiểm tra khi trang tải để xác định trạng thái ảnh
        $(document).ready(function () {
            // Kiểm tra khi trang tải để xác định trạng thái ảnh
            checkFooterImageStatus();
        });

        // Logo Popup

        function handleLogoPopupFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    const base64Image = reader.result;

                    // Cập nhật ảnh đã upload và hiển thị container ảnh
                    $('#logoPopupUploadedImage').attr('src', base64Image);
                    $('#logoPopupUploadedImageContainer').show(); // Hiển thị ảnh đã upload

                    // Ẩn phần upload
                    $('#logoPopupUploadSection').hide();
                };
                reader.readAsDataURL(file);
            }
        }


        function deleteLogoPopupImage(event) {
            // Ngăn hành động mặc định của thẻ <a>
            event.preventDefault();

            // Hiện hộp thoại xác nhận
            if (confirm("Are you sure you want to delete this popup logo?")) {
                // Nếu người dùng xác nhận, xóa ảnh và hiển thị lại phần upload
                $('#logoPopupUploadedImageContainer').hide();
                $('#logoPopupUploadSection').show();

                // Cập nhật lại ảnh mặc định cho preview và ảnh đã upload
                $('#logoPopupPreviewImage').attr('src', '/uploads/AdminButton/bi_image.png');
                $('#logoPopupUploadedImage').attr('src', '/uploads/AdminButton/bi_image.png');
            } else {
                // Nếu người dùng không xác nhận, không làm gì cả
                console.log("Popup logo deletion cancelled.");
            }
        }

        function checkLogoPopupImageStatus() {
            const uploadedLogoPopupImageSrc = $('#logoPopupUploadedImage').attr('src'); // Lấy src của ảnh đã upload

            // Kiểm tra nếu src là ảnh hợp lệ (không phải ảnh mặc định)
            if (uploadedLogoPopupImageSrc && uploadedLogoPopupImageSrc !== '/uploads/AdminButton/bi_image.png' && uploadedLogoPopupImageSrc !== '') {
                // Ảnh đã có, ẩn phần upload và hiển thị ảnh với nút xóa
                $('#logoPopupUploadSection').hide(); // Ẩn phần upload
                $('#logoPopupUploadedImageContainer').show(); // Hiển thị ảnh đã upload
            } else {
                // Nếu không có ảnh, hiển thị phần upload
                $('#logoPopupUploadSection').show();
                $('#logoPopupUploadedImageContainer').hide(); // Ẩn ảnh đã upload
            }
        }

        // Kiểm tra khi trang tải để xác định trạng thái ảnh
        $(document).ready(function () {
            // Kiểm tra khi trang tải để xác định trạng thái ảnh
            checkLogoPopupImageStatus();
        });

        // Share Logo

        function handleShareLogoFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    const base64Image = reader.result;

                    // Cập nhật ảnh đã upload và hiển thị container ảnh
                    $('#shareLogoUploadedImage').attr('src', base64Image);
                    $('#shareLogoUploadedImageContainer').show(); // Hiển thị ảnh đã upload

                    // Ẩn phần upload
                    $('#shareLogoUploadSection').hide();
                };
                reader.readAsDataURL(file);
            }
        }

        function deleteShareLogoImage(event) {
            // Ngăn hành động mặc định của thẻ <a>
            event.preventDefault();

            // Hiện hộp thoại xác nhận
            if (confirm("Are you sure you want to delete this share logo?")) {
                // Nếu người dùng xác nhận, xóa ảnh và hiển thị lại phần upload
                $('#shareLogoUploadedImageContainer').hide();
                $('#shareLogoUploadSection').show();

                // Cập nhật lại ảnh mặc định cho preview và ảnh đã upload
                $('#shareLogoPreviewImage').attr('src', '/uploads/AdminButton/bi_image.png');
                $('#shareLogoUploadedImage').attr('src', '/uploads/AdminButton/bi_image.png');
            } else {
                // Nếu người dùng không xác nhận, không làm gì cả
                console.log("Share logo deletion cancelled.");
            }
        }


        function checkShareLogoImageStatus() {
            const uploadedShareLogoImageSrc = $('#shareLogoUploadedImage').attr('src'); // Lấy src của ảnh đã upload

            // Kiểm tra nếu src là ảnh hợp lệ (không phải ảnh mặc định)
            if (uploadedShareLogoImageSrc && uploadedShareLogoImageSrc !== '/uploads/AdminButton/bi_image.png' && uploadedShareLogoImageSrc !== '') {
                // Ảnh đã có, ẩn phần upload và hiển thị ảnh với nút xóa
                $('#shareLogoUploadSection').hide(); // Ẩn phần upload
                $('#shareLogoUploadedImageContainer').show(); // Hiển thị ảnh đã upload
            } else {
                // Nếu không có ảnh, hiển thị phần upload
                $('#shareLogoUploadSection').show();
                $('#shareLogoUploadedImageContainer').hide(); // Ẩn ảnh đã upload
            }
        }

        // Kiểm tra khi trang tải để xác định trạng thái ảnh
        $(document).ready(function () {
            // Kiểm tra khi trang tải để xác định trạng thái ảnh
            checkShareLogoImageStatus();
        });

    </script>
{/literal}