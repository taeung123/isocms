<link rel="stylesheet" href="{$URL_CSS}/2025_contact.css?v={$upd_version}" as="style">

<section class="page_contact_new page_container">
    <div class="bg_contact_page">
        <nav class="breadcrumb-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <ol class="breadcrumb hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                                    <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                                <meta itemprop="position" content="1"/>
                            </li>
                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                                class="current">
                                <a itemprop="item" href="{$curl}" title="{$core->get_Lang('Contact us')}">
                                    <span itemprop="name" class="reb">{$core->get_Lang('Contact us')}</span></a>
                                <meta itemprop="position" content="2"/>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </nav>
        <div class="title_desc_contact">
            <div class="container">
                <h1 class="txt_title_contact">{$core->get_Lang('Get In Touch')}</h1>
                <div class="desc_contact_us">
                    <p class="txt_desc_contact">
                        {$core->get_Lang('Please fill your information in the form follow, we will contact again by email or via Phone/WhatsApp within 24 to 48 hours with a suitable itinerary at most reasonable price.')}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="box_information_contact">
        <div class="container">
            <div class="box_bg_information">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="box_contact_us">
                            <div class="txt_title_desc_box_contact">
                                <h2 class="txt_title_box_contact">{$core->get_Lang('Contact Information')}</h2>
                                <div class="txt_desc_contact_box">
                                    <p>{$core->get_Lang('Finding us is easy. Call us now if you are in a hurry')}.</p>
                                </div>
                            </div>
                            <div class="address_box_contact">
                                <div class="address_location_box_contact">
                                    <div class="icon_text_wrap">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <p>
                                            18th Floor, VTC Online Building, 18 Tam Trinh, Hai Ba Trung, Hanoi,
                                            Vietnam
                                        </p>
                                    </div>
                                </div>

                                <div class="address_location_box_contact">
                                    <div class="icon_text_wrap">
                                        <i class="fa-solid fa-phone"></i>
                                        <p>
                                            +84 243 829 3838
                                        </p>
                                    </div>
                                </div>

                                <div class="address_location_box_contact">
                                    <div class="icon_text_wrap">
                                        <i class="fa-solid fa-envelope"></i>
                                        <p>
                                            info@vietiso.com
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="box_contact_with_us">
                                <p>Contact with us</p>
                                <div class="social_contact_with_us">
                                    {if $clsConfiguration->getValue('Facebook_Link')}
                                        <a class="facebook"
                                           href="https://www.facebook.com/{$clsConfiguration->getValue('SiteFacebookLink')}"
                                           target="_blank"
                                           title="{$core->get_Lang('Facebook')}">
                                            <i class="fa-brands fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('Twitter_Link')}
                                        <a class="twitter"
                                           href="https://www.twitter.com/{$clsConfiguration->getValue('SiteTwitterLink')}"
                                           target="_blank" title="{$core->get_Lang('Twitter')}">
                                            <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('Youtube_Link')}
                                        <a class="youtube"
                                           href="https://www.youtube.com/{$clsConfiguration->getValue('SiteYoutubeLink')}"
                                           target="_blank" title="{$core->get_Lang('Youtube')}">
                                            <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('Google_Plus_Link')}
                                        <a class="google"
                                           href="https://plus.google.com/{$clsConfiguration->getValue('SiteGoogleLink')}"
                                           target="_blank" title="{$core->get_Lang('Google +')}">
                                            <i class="fa-brands fa-google-plus-g" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('Instagram_Link')}
                                        <a class="instagram"
                                           href="https://www.instagram.com/{$clsConfiguration->getValue('SiteInstagramLink')}"
                                           target="_blank" title="{$core->get_Lang('Instagram')}">
                                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('Printest_Link')}
                                        <a class="pinterest"
                                           href="https://pinterest.com/{$clsConfiguration->getValue('SitePrintestLink')}"
                                           target="_blank" title="{$core->get_Lang('Printest')}">
                                            <i class="fa-brands fa-pinterest" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('LinkedIn_Link')}
                                        <a class="linkedin"
                                           href="https://www.linkedin.com/{$clsConfiguration->getValue('SiteLinkInLink')}"
                                           target="_blank" title="{$core->get_Lang('LinkedIn')}">
                                            <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                    {if $clsConfiguration->getValue('TripAdvisor_Link')}
                                        <a class="tripadvisor"
                                           href="https://www.tripadvisor.com/{$clsConfiguration->getValue('SiteTripAdvisorLink')}"
                                           target="_blank" title="{$core->get_Lang('TripAdvisor')}">
                                            <i class="fa fa fa-tripadvisor" aria-hidden="true"></i>
                                        </a>
                                    {/if}
                                </div>
                            </div>
                            <div class="circle_decor_box_contact"></div>

                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="box_form_submit">
                            <p class="txt_red_information_contact">{$core->get_Lang('Please enter all information containing')} (*)</p>

                            <form id="form_submit_information" method="post" class="w-100" action="" enctype="multipart/form-data"
                                  class="AppForm form_submit_information">
                                <div class="form-group form_information">
                                    <div class="addon_form inner-addon left-addon">
                                        <input type="text" name="USER" autocomplete="off" id="emaillogin" class="form-control"
                                               placeholder=" " required">
                                        <label for="name" class="form-label txt_emailpass">{$core->get_Lang('Your name')} *</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group form_information">
                                            <div class="addon_form inner-addon left-addon">
                                                <input type="email" name="MAIL" autocomplete="off" id="emaillogin" class="form-control"
                                                       placeholder=" " required">
                                                <label for="email" class="form-label txt_emailpass">{$core->get_Lang('Email')} *</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group form_information">
                                            <div class="addon_form inner-addon left-addon">
                                                <input type="phone" name="PHONE" autocomplete="off" id="emaillogin" class="form-control"
                                                       placeholder=" " required">
                                                <label for="phone" class="form-label txt_emailpass">{$core->get_Lang('Phone')} *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group form_information">
                                            <div class="addon_form inner-addon left-addon">
                                                <label for="email" class="form-label txt_emailpass active">{$core->get_Lang('Country')}</label>
                                                <select name="country" class="form-control select_custom_option">
                                                    <option value="">Select Country</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="USA">USA</option>
                                                    <!-- thêm các quốc gia khác -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group form_information">
                                            <div class="addon_form inner-addon left-addon">
                                                <label for="email" class="form-label txt_emailpass active">{$core->get_Lang('City')}</label>
                                                <select name="country" class="form-control select_custom_option">
                                                    <option value="">Select City</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="USA">USA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form_information">
                                    <div class="addon_form inner-addon left-addon">
                                        <input type="text" name="SUBJECT" autocomplete="off" id="emaillogin" class="form-control"
                                               placeholder="Subject">
                                    </div>
                                </div>

                                <div class="form-group form_information">
                                    <div class="addon_form inner-addon left-addon">
                                        <textarea class="text optional textarea full-width" name="message" id="message" minlength="100" placeholder="Message" rows="4" data-validate="true"></textarea>
                                    </div>
                                </div>
                                <div class="recaptcha_submit">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <div class="button_send">
                                                <button type="submit" class="form-control send_contact btn_main" id="SubmitEnquiry">
                                                    {$core->get_Lang('Send Message')}
                                                </button>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</section>