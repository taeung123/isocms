<div id="hnv_setting_companymedia" role="tabpanel">
    <div class="hnv_setting_main_right_title">
        <h2>{$core->get_Lang('Media')}</h2>
    </div>
    <div class="hnv_setting_main_right_content">
        <div id="hnv_setting_companymedia_main">
            <form method="post">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" id="facebookSwitch" name="iso-Facebook_Link"
                                               class="form-check-input"
                                               {if $clsConfiguration->getValue('Facebook_Link')}checked{/if}
                                               onclick="toggleFacebookLink(this.checked)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_fb.png" width="28" height="28" alt="Facebook">
                                    </div>
                                    <span>{$core->get_Lang('Facebook Link')}</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                {if $clsConfiguration->getValue('Facebook_Link')}
                                    <div id="facebookInputContainer" class="hnv_setting_companymedia_main_config mb_24"
                                         style="display: {if $clsConfiguration->getValue('Facebook_Link')}block{else}none{/if};">
                                        <input type="text" name="iso-SiteFacebookLink" class="form-control"
                                               value="{if $clsConfiguration->getValue('SiteFacebookLink')}https://fb.com/{$clsConfiguration->getValue('SiteFacebookLink')}{/if}">
                                    </div>
                                {/if}
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="" class="form-check-input" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_x.png" width="28" height="28" alt="X">
                                    </div>
                                    <span>X</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="hnv_setting_companymedia_main_config mb_24">
                                    <input type="text" name="" class="form-control" value="http://www.x.com/vietiso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="" class="form-check-input" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_yt.png" width="28" height="28" alt="Youtube">
                                    </div>
                                    <span>Youtube</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="hnv_setting_companymedia_main_config mb_24">
                                    <input type="text" name="" class="form-control"
                                           value="http://www.youtube.com/vietiso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="" class="form-check-input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_ins.png" width="28" height="28" alt="Instagram">
                                    </div>
                                    <span>Instagram</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="hnv_setting_companymedia_main_config mb_24">
                                    <input type="text" name="" class="form-control"
                                           value="http://www.instagram.com/vietiso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="" class="form-check-input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_pt.png" width="28" height="28" alt="Pinterest">
                                    </div>
                                    <span>Pinterest</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="hnv_setting_companymedia_main_config mb_24">
                                    <input type="text" name="" class="form-control"
                                           value="http://www.pinterest.com/vietiso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="" class="form-check-input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_lin.png" width="28" height="28" alt="LinkedIn">
                                    </div>
                                    <span>LinkedIn</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="hnv_setting_companymedia_main_config mb_24">
                                    <input type="text" name="" class="form-control"
                                           value="http://www.linkedIn.com/vietiso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="hnv_setting_companymedia_main_switch mb_24">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="" class="form-check-input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="hnv_setting_companymedia_main_icon mb_24">
                                    <div class="hnv_setting_companymedia_main_icon_image">
                                        <img src="/uploads/icon/ico_tri.png" width="28" height="28" alt="TripAdvisor">
                                    </div>
                                    <span>TripAdvisor</span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="hnv_setting_companymedia_main_config mb_24">
                                    <input type="text" name="" class="form-control"
                                           value="http://www.tripAdvisor.com/vietiso">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{literal}
    <script>
        function toggleFacebookLink(isChecked) {
            const facebookInputContainer = document.getElementById('facebookInputContainer');
            if (isChecked) {
                facebookInputContainer.style.display = 'block';
            } else {
                facebookInputContainer.style.display = 'none';
            }
        }
    </script>
    <style>
        .form-switch input[type="checkbox"] {
            width: 48px;
            height: 24px;
        }

        .hnv_setting_companymedia_main_icon {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hnv_setting_companymedia_main_icon span {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 24px */
        }

        .hnv_setting_companymedia_main_icon_image {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
        }

        .hnv_setting_companymedia_main_icon_image img {
            width: 100%;
            object-fit: cover;
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
{/literal}