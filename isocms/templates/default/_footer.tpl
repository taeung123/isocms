{assign var=Copyright value=Copyright_|cat:$_LANG_ID}
{assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
{assign var=CompanyName value=CompanyName_|cat:$_LANG_ID}
{assign var=CompanyAddress1 value=CompanyAddress1_|cat:$_LANG_ID}
{assign var = DescriptionZoneFooter value = DescriptionZoneFooter_|cat:$_LANG_ID}

{if $lstPartner}
    <section class="company_truspilot">
        <div class="container">
            <div class="row">
                {assign var = TitlePartner value = TitlePartner_|cat:$_LANG_ID}
                <div class="col-md-12 col-sm-12">
                    <div class="item_partner">
                        <h3>{$clsConfiguration->getValue($TitlePartner)}</h3>
                        <div id="boxPress" class="boxPress partner-logos">
                            <div class="slideMain" style="height:85px">
                                <ul class="slide1" style="height:85px;padding:0">
                                    <li>
                                        {section name=i loop=$lstPartner}
                                            {assign var=title value=$lstPartner[i].title}
                                            <div class="item">
                                                <a href="https://{$lstPartner[i].url}" title="{$lstPartner[i].url}"
                                                   target="_blank">
                                                    <img title="{$title}"
                                                         src="{$clsPartner->getUrlImage($lstPartner[i].partner_id,$lstPartner[i])}"
                                                         style="max-width: 100%; height: auto;" loading="lazy"/>
                                                </a>
                                            </div>
                                        {/section}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        var $width_slide_panner = '{$width_slide_panner}';
    </script>
{literal}
    <style type="text/css">
    </style>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $(function () {
                var $ww = $(window).width();
                $('#boxPress .slide1').width($width_slide_panner);
                $('#boxPress .slide2').width($width_slide_panner);
                $("#boxPress").rotate({
                    speed: 20
                });
            });
        })
    </script>
{/literal}
{/if}

{if $mod ne 'member'}
    <section class="company_support">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="txt_listcompany">
                        <h4 class="txt_company">{$clsConfiguration->getValue($CompanyName)}</h4>
                        <p class="txt_companyaddr">
                            <a target="_blank"
                               href="https://maps.google.it/maps?q={$clsConfiguration->getValue($CompanyAddress)}"
                               title="{$clsConfiguration->getValue($CompanyAddress)}">{$clsConfiguration->getValue($CompanyAddress)}</a>
                        </p>
                        <p class="txt_companyaddr">
                            <a href="mailto:{$clsConfiguration->getValue('CompanyEmail')}"
                                                       title="{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}
                            </a>
                        </p>
                        <p class="txt_companyaddr"><a href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                                       title="{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
                        </p>
                        <h4 class="txt_paymentt1">{$core->get_Lang('Payment Methods')}</h4>
                        <div class="img_payment">
                            <img src="/uploads/visa.png"
                                    alt="Visa"
                                    width="40"
                                    height="24"
                                    loading="lazy">
                            <img src="https://www.logo.wine/a/logo/Mastercard/Mastercard-Logo.wine.svg" alt="MasterCard"
                                 width="40" height="24" loading="lazy">
                            <img src="https://1000logos.net/wp-content/uploads/2016/10/American-Express-Color.png"
                                 alt="American Express" width="40" height="24" loading="lazy">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Paypal_2014_logo.png"
                                 alt="PayPal"
                                 width="40" height="24" loading="lazy">
                        </div>
                        {*                    <div class="fb_likepage">*}
                        {*                    </div>*}
                    </div>
                </div>

                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="txt_companyterm">
                        <h4>{$core->get_Lang('Company')}</h4>
                        <div class="list-unstyled lisst-compt">
                            {if $clsISO->getCheckActiveModulePackage($package_id,'page','about','default')}
                                <p><a href="{$clsISO->getLink('about')}"
                                       title="{$core->get_Lang('About Us')}"> {$core->get_Lang('About Us')}</a></p>
                            {/if}
                            {if $clsISO->getCheckActiveModulePackage($package_id,'testimonial','default','default')}
                                <p><a href="{$clsISO->getLink('testimonial')}"
                                       title="{$core->get_Lang('Testimonials')}"> {$core->get_Lang('Testimonials')}</a>
                                </p>
                            {/if}
                            <p><a href="{$clsISO->getLink('news')}">{$core->get_Lang('Travel News')}</a></p>
                            {if $clsISO->getCheckActiveModulePackage($package_id,'blog','default','default')}
                                <p><a href="{$clsISO->getLink('blog')}"
                                       title="{$core->get_Lang('Blog')}"> {$core->get_Lang('Blogs')}</a></p>
                            {/if}
                            {*                            <h5><a href="#">Partner</a></h5>*}
                            {*                            <h5><a href="#">Careers</a></h5>*}
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="txt_companyterm">
                        <h4>{$core->get_Lang('Term of use')}</h4>
                        <div class="list-unstyled lisst-compt">
                          {if isset($listAllpage) && $listAllpage|@count gt 0}

                                {foreach from=$listAllpage item=item}

                                    {if $item.title|default:'' ne ''}
                                        <p>
                                            <a
                                                href="{$item.link|default:'#'|escape:'html'}"
                                                title="{$item.title|strip_tags|escape:'html'}"
                                            >
                                                {$item.title|strip_tags}
                                            </a>
                                        </p>
                                    {/if}

                                {/foreach}

                            {/if}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="txt_companyterm">
                        <h4>{$core->get_Lang('Support')}</h4>
                        <div class="list-unstyled lisst-compt">
                            <p><a href="{$clsISO->getLink('contact')}"
                                   title="{$core->get_Lang('Contact')}"> {$core->get_Lang('Contact')}</a></p>
                            <p><a href="{$clsISO->getLink('faqs')}">{$core->get_Lang('Help center')}</a></p>
                            <p>
                                <a href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$core->get_Lang('Hotline')}
                                    : {$clsConfiguration->getValue('CompanyHotline')}</a></p>
                            {*<p><a href="{$clsISO->getLink('agent_signin')}"
                                  title="{$core->get_Lang('Agent login')}"> {$core->get_Lang('Agent login')}</a></p>*}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
<a id="backTop" class="bg_cust" role="link" href="javascript:void(0);">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</a>
{* Icon Social *}
<footer id="footer">
    <div id="icon-fixed">
        <div class="social_icons">
            <ul class="list_social">
            {if $clsConfiguration->getValue('SiteFacebookLink') ne ''}
                <li><a class="facebook social-icon social_fb" href="https://www.facebook.com/{$clsConfiguration->getValue('SiteFacebookLink')}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SiteTwitterLink') ne ''}
                <li><a class="twitter social-icon social_twitter" href="https://www.twitter.com/{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SiteYoutubeLink') ne ''}
                <li><a class="youtube social-icon social_ytb" href="https://www.youtube.com/{$clsConfiguration->getValue('SiteYoutubeLink')}" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SiteWhatsappLink') ne ''}
                <li><a class="whatsapp social-icon social_whatsapp" href="https://wa.me/{$clsConfiguration->getValue('SiteWhatsappLink')}" target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SiteGoogleLink') ne ''}
                <li><a class="google-plus social-icon social_google" href="https://plus.google.com/{$clsConfiguration->getValue('SiteGoogleLink')}" target="_blank"><i class="fa-brands fa-google-plus-g"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SiteInstagramLink') ne ''}
                <li><a class="instagram social-icon social_instagram" href="https://www.instagram.com/{$clsConfiguration->getValue('SiteInstagramLink')}" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SiteLinkInLink') ne ''}
                <li><a class="linkedin social-icon social_linkedin" href="https://www.linkedin.com/{$clsConfiguration->getValue('SiteLinkInLink')}" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
            {/if}

            {if $clsConfiguration->getValue('SitePrintestLink') ne ''}
                <li><a class="pinterest social-icon social_printest" href="https://pinterest.com/{$clsConfiguration->getValue('SitePrintestLink')}" target="_blank"><i class="fa-brands fa-pinterest"></i></a></li>
            {/if}

            {*{if $clsConfiguration->getValue('SiteTripAdvisorLink') ne ''}
                <li><a class="tripadvisor social-icon social_tripadvisor" href="https://www.tripadvisor.com/{$clsConfiguration->getValue('SiteTripAdvisorLink')}" target="_blank"><i class="fa fa-tripadvisor"></i></a></li>
            {/if}*}
        </ul>
        </div>
    </div>

    <div class="cookie-banner" style="display: none">
        <p>
            {$core->get_Lang('This website uses cookies. We use cookies to analyse our traffic, enhance our websites functionality and performance and better experience for our users. If you require more information, please view our')}
            <a href="{$clsISO->getLink('term_cookie')}" target="_blank">{$core->get_Lang('Cookie Policy')}</a>.
        </p>
        <button id="accept-cookie">{$core->get_Lang('GOT IT')}</button>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="btn_footeriso">
                <div class="logo_footer">
                    <img src="{$clsConfiguration->getValue('FooterLogo')}" width="98" height="51" alt="logo"
                         title="logo" loading="lazy">
                </div>
                <div class="footer_company_link">
                    <h6>{$clsConfiguration->getCopyRight()}
                        <a title="{$core->get_Lang('Travel website design')}"
                           href="https://www.vietiso.com/thiet-ke-website-du-lich.html"
                           class="">{$core->get_Lang('Travel website design')}</a> {$core->get_Lang('by')}
                        <a class="" href="https://www.vietiso.com" title="VIETISO">Viet<span
                                    class="color_f58220">ISO</span></a>
                    </h6>
                </div>
                  <div class="social-icons">
                                {if $clsConfiguration->getValue('SiteFacebookLink') ne ''}
                                    <a class="facebook" href="https://www.facebook.com/{$clsConfiguration->getValue('SiteFacebookLink')}" target="_blank" title="{$core->get_Lang('Facebook')}">
                                        <i class="fa-brands fa-facebook" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteTwitterLink') ne ''}
                                    <a class="twitter" href="https://www.twitter.com/{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank" title="{$core->get_Lang('Twitter')}">
                                        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteYoutubeLink') ne ''}
                                    <a class="youtube" href="https://www.youtube.com/{$clsConfiguration->getValue('SiteYoutubeLink')}" target="_blank" title="{$core->get_Lang('Youtube')}">
                                        <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteWhatsappLink') ne ''}
                                    <a class="whatsapp" href="https://wa.me/{$clsConfiguration->getValue('SiteWhatsappLink')}" target="_blank" title="{$core->get_Lang('Whatsapp')}">
                                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteGoogleLink') ne ''}
                                    <a class="google" href="https://plus.google.com/{$clsConfiguration->getValue('SiteGoogleLink')}" target="_blank" title="{$core->get_Lang('Google +')}">
                                        <i class="fa-brands fa-google-plus-g" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteInstagramLink') ne ''}
                                    <a class="instagram" href="https://www.instagram.com/{$clsConfiguration->getValue('SiteInstagramLink')}" target="_blank" title="{$core->get_Lang('Instagram')}">
                                        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SitePrintestLink') ne ''}
                                    <a class="pinterest" href="https://pinterest.com/{$clsConfiguration->getValue('SitePrintestLink')}" target="_blank" title="{$core->get_Lang('Printest')}">
                                        <i class="fa-brands fa-pinterest" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteLinkInLink') ne ''}
                                    <a class="linkedin" href="https://www.linkedin.com/{$clsConfiguration->getValue('SiteLinkInLink')}" target="_blank" title="{$core->get_Lang('LinkedIn')}">
                                        <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                                    </a>
                                {/if}

                                {if $clsConfiguration->getValue('SiteTripAdvisorLink') ne ''}
                                    <a class="tripadvisor" href="https://www.tripadvisor.com/{$clsConfiguration->getValue('SiteTripAdvisorLink')}" target="_blank" title="{$core->get_Lang('TripAdvisor')}">
                                        <i class="fa fa-tripadvisor" aria-hidden="true"></i>
                                    </a>
                                {/if}
                            </div>

            </div>
        </div>
    </div>
</footer>

{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
             $(document).ready(function () {
                const isCookieAccepted = localStorage.getItem('cookieAccepted');
                // Chỉ hiển thị banner nếu chưa chấp nhận cookie
                if (!isCookieAccepted) {
                    setTimeout(function () {
                        $('.cookie-banner').css('display', 'flex'); // Hiển thị banner
                    }, 8000); // Delay lâu hơn sau khi DOM đã được tải 8 giây
                }
                $('#accept-cookie').on('click', function () {
                    $('.cookie-banner').css('display', 'none'); // Ẩn banner ngay khi nhấn nút
                    localStorage.setItem('cookieAccepted', 'true'); // Lưu trạng thái chấp nhận cookie
                });
            });
        })
    </script>
{/literal}
{if $agentLoggedIn && $deviceType=="computer"}
    {literal}
        <style>
            .page_container {
                margin-top: 65px !important;
            }
        </style>
    {/literal}
{/if}