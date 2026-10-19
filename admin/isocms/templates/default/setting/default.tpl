{literal}
    <style>
        #clienttabs > ul > li > a {
            padding: 0px 10px !important;
        }
    </style>
{/literal}
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="page_container">
    <div class="page-title d-flex">
        <div class="title">
            <h2><i class="fa fa-wrench"></i> {$core->get_Lang('settings')}
                <div class="info_module" data-toggle="tooltip" data-placement="right"
                     title="Chức năng quản lý danh sách các {$core->get_Lang('settings')} trong hệ thống isoCMS">i
                </div>
            </h2>
            <p>{$core->get_Lang('systemmanagementsettings')}</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="clearfix"></div>
        <div id="clienttabs">
            <ul>
                <li><a><i class="fa fa-cog"></i> {$core->get_Lang('General')}</a></li>
                <li><a><i class="fa fa-wrench"></i> {$core->get_Lang('.htaccess')}</a></li>
                <li style="display: none"><a><i class="fa fa-cogs"></i> {$core->get_Lang('Modules Settings')}</a></li>
            </ul>
        </div>
        <div id="tab_content">
            <div class="tabbox">
                <form method="post" action="" enctype="multipart/form-data" class="validate-form">
                    <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
                        {if $clsISO->getVar('ONLINE_PAYMENT_ENABLE')}
                            <tr>
                                <td class="fieldlabel span20">{$core->get_Lang('ExchangeRate')}</td>
                                <td class="fieldarea">
                                    1USD = <input type="text" class="text fulll priceFormat" name="ExchangeRate"
                                                  value="{$clsConfiguration->getValue('ExchangeRate')}"
                                                  style="width:10%"/> (VNĐ)
                                </td>
                            </tr>
                        {/if}
                        {if $hasAPI}
                            <tr>
                                <td class="fieldlabel span20">{$core->get_Lang('DefaultCurrency')}</td>
                                <td class="fieldarea">
                                    <select name="iso-CurrencyTMS">
                                        {foreach from=$lstCurrency item=item name=item}
                                            <option value="{$item.property_id}"
                                                    {if $clsConfiguration->getValue('CurrencyTMS') eq $item.property_id}selected="selected"{/if}>{$item.title}</option>
                                        {/foreach}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="fieldlabel span20">{$core->get_Lang('decimalMoney')}</td>
                                <td class="fieldarea">
                                    <input type="text" class="text fulll" name="iso-decimal_money"
                                           value="{$clsConfiguration->getValue('decimal_money')}" style="width:10%"/>
                                </td>
                            </tr>
                        {/if}
                        <tr>
                            <td class="fieldlabel span20">{$core->get_Lang('DefaultLanguage')}</td>
                            <td class="fieldarea">
                                <select name="iso-SiteDefaultLanguage" class="login_inputs">
                                    {section name=i loop=$listAppLanguage}
                                        <option value="{$listAppLanguage[i].code}"
                                                {if $clsConfiguration->getValue('SiteDefaultLanguage') eq $listAppLanguage[i].code}selected="selected"{/if}>{$listAppLanguage[i].name}</option>
                                    {/section}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel span20">{$core->get_Lang('Site Template')}</td>
                            <td class="fieldarea">
                                <select name="iso-SiteTemplate" class="login_inputs">
                                    {section name=i loop=$listAppTemplate}
                                        <option value="{$listAppTemplate[i]}"
                                                {if $clsConfiguration->getValue('SiteTemplate') eq $listAppTemplate[i]}selected="selected"{/if}>{$listAppTemplate[i]}</option>
                                    {/section}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel span20">{$core->get_Lang('googleverifykey')}</td>
                            <td class="fieldarea">
                                <input type="text" class="text span40" name="iso-SiteGoogleVerifyKey"
                                       value="{$clsConfiguration->getValue('SiteGoogleVerifyKey')}">
                                <span class="notice-short">&lt;meta name="google-site-verification" value="SiteGoogleVerifyKey" /&gt;</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel span20">{$core->get_Lang('Google Analytics Code')}</td>
                            <td class="fieldarea">
                                <input type="text" class="text span20" name="iso-SiteGoogleAnalyticsCode"
                                       value="{$clsConfiguration->getValue('SiteGoogleAnalyticsCode')}">
                                <div class="highlightbox mt5">
                                    Để tích hợp Google Analytics vào website của bạn, bạn cần thực hiện các bước
                                    sau:<br/>
                                    1) Tạo 1 <a class="underline" href="http://www.google.com/analytics/"
                                                target="_blank">tài khoản Google Analytics</a> và làm theo hướng dẫn để
                                    thêm trang web của bạn.<br/>
                                    2) Sao chép mã theo dõi từ Google Analytics vào ô phía trên (vd: G-WPQ24YQ1RX)<br/>
                                    3) Ấn "<strong>Lưu</strong>" để Google Analytics được tích hợp vào website của bạn
                                </div>
                            </td>
                        </tr>
                    </table>
                    <fieldset class="submit-buttons">
                        {$saveBtn}
                        <input value="UpdateConfiguration" name="submit" type="hidden">
                    </fieldset>
                </form>
            </div>
            <div class="tabbox" style="display:none;">
                <h2>Cài đặt htaccess</h2>
                <p>
                    Apache cung cấp khả năng cấu hình qua những files truy cập siêu văn bản . Những files này cho phép
                    thay đổi tinh chỉnh của Apache (httpd.conf) . Theo mặc định file này có tên .htaccess. Do .httaccess
                    mang những tinh chỉnh quan trọng cho nên, người sử dụng phải đảm bảo file này được ấn định một mức
                    độ bảo mật nhất định, tránh những truy cập bất hợp pháp từ bên ngoài (xem, sửa, xóa) những tinh
                    chỉnh này.
                </p>
                <p>
                    <strong style="color:red;">Chỉ thay đổi khi bạn thực sự hiểu rõ mục này!!!!!!!</strong>
                </p>
                <div class="clearfix"><br/></div>
                {if $htaccess_permission ne '0777'}
                    <div style="color:red; text-align:center; border:1px dashed red; margin-bottom:20px; padding:10px;">
                        File .htaccess chưa CMOD 777!
                    </div>
                {/if}
                <form method="post" action="">
                    <textarea {if $htaccess_permission ne '0777'}disabled="disabled"{/if} name="htaccess" id="htaccess"
                              style="width:100%; height:400px; font-size:12px; line-height:16px;">{$htaccess}</textarea>
                    <div class="clearfix"><br/></div>
                    {if $htaccess_permission eq '0777'}
                        <fieldset class="submit-buttons">
                            {$saveBtn}
                            <input value="Updatehtaccess" name="submit" type="hidden">
                        </fieldset>
                    {/if}
                    {literal}
                        <script type="text/javascript">
                            $(document).ready(function () {
                                function replaceHtml(string_to_replace) {
                                    return string_to_replace.replace(/&nbsp;/g, ' ').replace(/<br.*?>/g, '\n');
                                }

                                var str = $("#htaccess").val();
                                $("#htaccess").val(replaceHtml(str));
                            });
                        </script>
                    {/literal}
                </form>
            </div>
            <div class="tabbox" style="display:none;">
                <form method="post" action="" enctype="multipart/form-data">
                    <div id="clientsummarycontainer">
                        <table width="100%" class="block_full_width_700">
                            <tbody class="block_full_width_700">
                            <tr class="block_full_width_700">
                                <td width="25%" valign="top" class="block_full_width_700">
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('confighomepage')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('homehasmynote')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasNote_Home">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasNote_Home')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('homehasfeedback')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasFeedback_Home">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasFeedback_Home')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('configsitemodlink')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteConfigModLink">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteConfigModLink')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetravelagent')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-HaveTravelAgent">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('HaveTravelAgent')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecustomerlogin')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-HaveCustomerLogin">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('HaveCustomerLogin')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveairticketbook')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-HaveAirTicketBook">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('HaveAirTicketBook')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmoduletour')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetourAPI')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteTourAPI">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteTourAPI')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetourpromotion')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTourPromotion">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTourPromotion')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetourdeparture')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTourDeparture">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTourDeparture')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetourlasthour')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTourLastHour">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTourLastHour')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedeparturepoint')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDeparturePoint_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDeparturePoint_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetourtransport')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTransport_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTransport_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecattoursbycountry')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCatByCountry_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCatByCountry_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecattours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCat_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCat_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havesubcattours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasSubCat_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasSubCat_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegrouptours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGroup_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGroup_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havestartdatetours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasStartDate_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasStartDate_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegeneralpricesystem')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGeneralPriceSystem">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGeneralPriceSystem')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havepricetabletours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPriceTableTours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPriceTableTours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveaddvancedpricetabletours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SitePriceTableType_Tours" style="width:90px">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SitePriceTableType_Tours') eq 1}selected="selected"{/if}>{$core->get_Lang('pricetabletourshasseason')}</option>
                                                        <option value="2"
                                                                {if $clsConfiguration->getValue('SitePriceTableType_Tours') eq 2}selected="selected"{/if}>{$core->get_Lang('pricetabletourshasstartdate')}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveextensiontours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasExtensionTours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasExtensionTours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegalleryimagestours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGalleryImagesTours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGalleryImagesTours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havepricerangetours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPriceRange_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPriceRange_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedestinationtours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDestinationTours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDestinationTours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveitinerarytours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasItineraryTours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasItineraryTours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havehoteltours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotel_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotel_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havereviewtours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasReview_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasReview_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havestoretours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasStore_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasStore_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveservicetours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasService_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasService_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveactivitiestours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasActivities_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasActivities_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecustomfieldtours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCustomContentField_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCustomContentField_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveprogramfiletours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasProgramFile_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasProgramFile_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmodulevoucher')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havevoucherpromotion')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasVoucherPromotion">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasVoucherPromotion')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havevoucherdeparture')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasVoucherDeparture">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasVoucherDeparture')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havevoucherlasthour')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasVoucherLastHour">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasVoucherLastHour')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedeparturepoint')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDeparturePoint_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDeparturePoint_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havevouchertransport')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTransport_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTransport_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecatvoucherbycountry')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCatByCountry_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCatByCountry_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecatvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCat_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCat_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havesubcatvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasSubCat_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasSubCat_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegroupvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGroup_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGroup_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havestartdatevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasStartDate_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasStartDate_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havepricetablevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPriceTableVoucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPriceTableVoucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveaddvancedpricetablevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SitePriceTableType_Voucher" style="width:90px">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SitePriceTableType_Voucher') eq 1}selected="selected"{/if}>{$core->get_Lang('pricetablevoucherhasseason')}</option>
                                                        <option value="2"
                                                                {if $clsConfiguration->getValue('SitePriceTableType_Voucher') eq 2}selected="selected"{/if}>{$core->get_Lang('pricetablevoucherhasstartdate')}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveextensionvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasExtensionVoucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasExtensionVoucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegalleryimagesvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGalleryImagesVoucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGalleryImagesVoucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havepricerangevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPriceRange_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPriceRange_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedestinationvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDestinationVoucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDestinationVoucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveitineraryvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasItineraryVoucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasItineraryVoucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havehotelvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotel_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotel_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havereviewvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasReview_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasReview_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havestorevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasStore_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasStore_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveservicevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasService_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasService_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecustomfieldvoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCustomContentField_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCustomContentField_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveprogramfilevoucher')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasProgramFile_Voucher">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasProgramFile_Voucher')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configslide')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveslidechild')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasChild_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasChild_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveslidehotel')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotel_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotel_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveslidetourcat')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTourCat_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTourCat_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveslidecountry')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCountry_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCountry_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveslidecity')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCity_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCity_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Home')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_Home">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_Home')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Country')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_Country">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_Country')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Region')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_Region">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_Region')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser City')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_City">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_City')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Tour Category')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_TourCategory">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_TourCategory')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Tour')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_Tour">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_Tour')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Cruise Category')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_CruiseCategory">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_CruiseCategory')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Cruise')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_Cruise">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_Cruise')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Video Teaser Hotel')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-Video_Teaser_Hotel">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('Video_Teaser_Hotel')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configtagsmodule')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havenewstags')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTags_News">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTags_News')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetagsblog')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTags_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTags_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmoduleblog')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecatblog')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCat_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCat_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveblogauthor')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasAuthor_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasAuthor_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveblogpublishdate')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPublishDate_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPublishDate_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveblogdestination')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDestination_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDestination_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveblogtourextensions')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasTourExtension_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasTourExtension_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havebloghotelextensions')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotelExtension_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotelExtension_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveblogcruiseextensions')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruiseExtension_Blogs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruiseExtension_Blogs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td width="25%" valign="top" class="block_full_width_700">
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmodulecruise')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisescategory')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesCategory">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesCategory')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisesitinerary')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesItinerary">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesItinerary')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisescabin')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesCabin">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesCabin')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisesservice')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesService">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesService')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedestinationcruises')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDestinationCruises">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDestinationCruises')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegalleryimagescruises')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGalleryImagesCruises">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGalleryImagesCruises')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisestravelas')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesTravelAs">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesTravelAs')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisesproperty')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesProperty">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesProperty')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisesvideo')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCruisesVideo">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCruisesVideo')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetypecruises')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasType_Cruises">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasType_Cruises')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havestartdatecruise')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasStartDate_Cruise">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasStartDate_Cruise')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecustomfieldcruise')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCustomField_Cruise">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCustomField_Cruise')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havestorecruises')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasStore_Cruises">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasStore_Cruises')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisepricesetup')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPriceSetup_Cruise">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPriceSetup_Cruise')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecruisepricerange')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasPriceRange_Cruises">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasPriceRange_Cruises')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('Cruise Price Departure Date')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SitePriceDepartureDate_Cruises">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SitePriceDepartureDate_Cruises')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmodulehotel')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('hotelstopbydestination')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotelToP">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotelToP')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('hotelspricerange')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotelPriceRange">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotelPriceRange')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('hotelfacility')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotelFacility">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotelFacility')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('hotelfreeservice')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasFreeService_Hotel">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasFreeService_Hotel')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('hotelbooking')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotelBooking">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotelBooking')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecustomfieldhotel')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCustomField_Hotel">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCustomField_Hotel')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegalleryimageshotels')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGalleryImagesHotels">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGalleryImagesHotels')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havepropertyhotels')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasHotelsProperty">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasHotelsProperty')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmodulegeo')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecontinent')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteModActive_continent">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteModActive_continent')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecountry')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteModActive_country">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteModActive_country')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveregion')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_region">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_region')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedestination')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_destination">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_destination')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecity')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_city">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_city')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmodulenews')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecatnews')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCat_News">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCat_News')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configmodulegeneral')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedestinationintro')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDestinationIntro">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDestinationIntro')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveguidecategory')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActiveCat_guide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActiveCat_guide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveguide')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_guide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_guide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havetopcity')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_topcity">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_topcity')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedeparturecity')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_departurecity">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_departurecity')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havsettingcity')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteActive_settingcity">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteActive_settingcity')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecatslide')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCat_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCat_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveslidechild')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasChild_slide">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasChild_slide')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havecatfaqs')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasCat_FAQ">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasCat_FAQ')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havedetailfaqs')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDetail_FAQ">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDetail_FAQ')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveblogpagedescription')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteBlogPageDescription">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteBlogPageDescription')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havegroupads')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasGroup_Ads">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasGroup_Ads')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havewhycontent')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasContent_Why">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasContent_Why')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('havewhyicon')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasIcon_Why">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasIcon_Why')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveserviceiconchild')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasIconChild_Service">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasIconChild_Service')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clientssummarybox">
                                        <div class="title">{$core->get_Lang('configduplicatemodule')}</div>
                                        <table class="clientssummarystats" width="100%" border="0" cellspacing="2"
                                               cellpadding="3">
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveduplicatetours')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDuplicate_Tours">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDuplicate_Tours')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveduplicatehotels')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDuplicate_Hotels">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDuplicate_Hotels')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveduplicatenews')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDuplicate_News">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDuplicate_News')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fieldlabel">{$core->get_Lang('haveduplicateblog')}</td>
                                                <td class="fieldarea" style="width:100px">
                                                    <select name="iso-SiteHasDuplicate_Blog">
                                                        <option value="0">OFF</option>
                                                        <option value="1"
                                                                {if $clsConfiguration->getValue('SiteHasDuplicate_Blog')}selected="selected"{/if}>
                                                            ON
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <fieldset class="submit-buttons">
                        {$saveBtn}
                        <input value="UpdateConfigurationGeneral" name="submit" type="hidden">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{$URL_THEMES}/setting/jquery.setting.js"></script>
{literal}
    <script type="text/javascript">
        $(function () {
            $('select[name^=iso]').each(function () {
                var $_this = $(this);
                if ($_this.val() == 1) {
                    $_this.css({'border-color': '#0C0', 'background': '#e9ffd9'});
                }
            });
        });
    </script>
{/literal}