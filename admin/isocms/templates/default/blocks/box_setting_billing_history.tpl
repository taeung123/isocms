<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

<div class="page_container page_billing_history">
    <div class="page-title d-flex">
        <div class="title">
            <h2>{$core->get_Lang('Billing History')}
                <div class="icon_txt_pro">
                    <i class="fa-solid fa-crown icon_gradient"></i>
                    <p class="txt_pro">{$core->get_Lang('PRO')}</p>
                </div>
            </h2>
        </div>
            <p>{$core->get_Lang('Here you can find all the important figures regarding your revenue and fees')}</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="filter_box">
            <form id="forums" method="post" class="filterForm" action="">
                <div class="group_buttons fr">
                    <a href="javascript:void(0)" class="btn btn_exportex">
                        <img src="{$URL_IMAGES}/v2/excel.png" style="vertical-align:middle"> {$core->get_Lang('Export')}
                    </a>
                </div>
            </form>
        </div>

        <div class="dateExport dateExport2" style="display:none">
            <form class="form-export" method="post" action="">
                <div class="form-group inline-block">
                    <div class="span50 fl">
                        <label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="from_date">
                            {$core->get_Lang('From')} <span class="color_r">*</span>
                        </label>
                        <div class="col-md-9 col-sm-8 col-xs-8">
                            <input name="from_date" autocomplete="off" maxlength="10" id="from_date"
                                   value="{$clsISO->formatTimeDate($now_day)}" size="15"
                                   class="full-width text_32 border_aaa" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                    <div class="span50 fr">
                        <label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="to_date">
                            {$core->get_Lang('To')} <span class="color_r">*</span>
                        </label>
                        <div class="col-md-9 col-sm-8 col-xs-8">
                            <input name="to_date" autocomplete="off" maxlength="10" id="to_date"
                                   value="{$clsISO->formatTimeDate($now_next)}" size="15"
                                   class="full-width text_32 border_aaa" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                </div>
                <button type="submit" class="buttonExport" id="button_export">{$core->get_Lang('Export')}</button>
                <input type="hidden" name="Export" value="Export"/>
            </form>
        </div>
        <div class="hastable">
            <div class="table_list_booking">
                <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
                    <thead class="table_title">
                    <tr class="title_table">
                        <th class="gridheader hiden767" style="text-align:left">
                            <strong>{$core->get_Lang('ID')}</strong></th>
                        <th class="gridheader hiden767" style="width:10%">
                            <strong>{$core->get_Lang('Payment date')}</strong></th>
                        <th class="gridheader text-left hiden767">
                            <strong>{$core->get_Lang("Service Package")}</strong></th>
                        <th class="gridheader hiden767" style="white-space:nowrap">
                            <strong>{$core->get_Lang('Amount')}</strong></th>
                        <th class="gridheader hiden767">
                            <strong>{$core->get_Lang('Billing Method')}</strong></th>
                        <th class="gridheader hiden767">
                            <strong>{$core->get_Lang('Status')}</strong></th>
                    </tr>
                    <tr class="row_filter">
                        <th></th>
                        <th>
                            <div class="form-group">
                                <input type="text" id="monthYearPicker" class="form-control" placeholder="{$core->get_Lang('Select Month & Year')}">
                            </div>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="form-group form-country">
                                <select id="statusSelect" name="status" class="form-control" data-width="100%">
                                    <option value="">{$core->get_Lang('Status')}</option>
                                    <option value="0"
                                            {if $status eq '0'}selected="selected"{/if}>{$core->get_Lang('Waiting Payment')}</option>
                                    <option value="1"
                                            {if $status eq '1'}selected="selected"{/if}>{$core->get_Lang('Completly payment')}</option>
                                </select>
                            </div>
                        </th>
                    </tr>

                    </thead>

                    {section name=i loop=$listItem}
                        <tr class="row_custom {cycle values="row1,row2"}">
                            <td class="block_responsive td_overflow" data-title="{$core->get_Lang('ID')}">
                                <a href="{$PCMS_URL}/?mod=booking&act=edit&booking_id={$core->encryptID($listItem[i].booking_id)}">
                                    {$clsBooking->getOneField('booking_code',$listItem[i].booking_id)}
                                </a>
                            </td>
                            <td class=" block_responsive"
                                data-title="{$core->get_Lang('Payment date')}">{if $listItem[i].payment_term gt 0}{$listItem[i].payment_term|date_format:"%d/%m/%Y"}{/if}</td>
                            <td class="block_responsive td_overflow" data-title="{$core->get_Lang('Service Package')}">
                                <strong>{$clsBooking->getHTMLServiceNew($listItem[i].booking_id)} </strong>
                            </td>

                            <td class="fieldNumber block_responsive"
                                data-title="{$core->get_Lang('Pay Now')}">{$listItem[i].bill_money|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>

                            <td class="block_responsive" data-title="{$core->get_Lang('Billing Method')}">
                                {if $listItem[i].payment_method eq '1'}
                                    {assign var = SitePay_CashName value = SitePay_CashName_|cat:$_LANG_ID}
                                    {$clsConfiguration->getValue($SitePay_CashName)}
                                {elseif $listItem[i].payment_method eq '2'}
                                    {assign var = SitePay_BankName value = SitePay_BankName_|cat:$_LANG_ID}
                                    {$clsConfiguration->getValue($SitePay_BankName)}
                                {elseif $listItem[i].payment_method eq '3'}
                                    {assign var = ONEPAY_Name value = ONEPAY_Name_|cat:$_LANG_ID}
                                    {$clsConfiguration->getValue($ONEPAY_Name)}
                                {elseif $listItem[i].payment_method eq '4'}
                                    {assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
                                    {$clsConfiguration->getValue($ONEPAY_Visa_Name)}
                                {elseif $listItem[i].payment_method eq '5'}
                                    {assign var = Paypal_Name value = Paypal_Name_|cat:$_LANG_ID}
                                    {$clsConfiguration->getValue($Paypal_Name)}
                                {elseif $listItem[i].payment_method eq '6'}
                                    {assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
                                    {$clsConfiguration->getValue($ONEPAY_Visa_Name)}
                                {elseif $listItem[i].payment_method eq '7'}
                                    {$core->get_Lang('QR code')}
                                {/if}
                            </td>

                            <td class="fieldNumber block_responsive" data-title="{$core->get_Lang('Status')}">
                                <p class="status_payment {if $listItem[i].status eq 1}complete_payment{else}waiting_payment{/if}">
                                    {if $listItem[i].status eq 1}
                                        {$core->get_Lang('Completly payment')}
                                    {else}
                                        {$core->get_Lang('Waiting Payment')}
                                    {/if}
                                </p>
                            </td>
                        </tr>
                    {/section}
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="statistical mb5">
                <table width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                        <td width="50%" align="left">{$core->get_Lang('statistical')}
                            <strong>{$totalRecord}</strong> {$core->get_Lang('records')}
                            /<strong>{$totalPage}</strong> {$core->get_Lang('page')}
                            . {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
                        <td width="50%" align="right">
                            {$core->get_Lang('gotopage')}:
                            <select name="page" onchange="window.location = this.options[this.selectedIndex].value">
                                {section name=i loop=$listPageNumber}
                                    <option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if}
                                            value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{literal}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#from_date, #to_date").flatpickr({
                dateFormat: "d/m/Y", // Định dạng ngày
                allowInput: true, // Cho phép nhập tay
            });

            $("#monthYearPicker").flatpickr({
                dateFormat: "m/Y", // Định dạng tháng/năm
                plugins: [new monthSelectPlugin({ shorthand: true, dateFormat: "m/Y" })]
            });
        });

        $(document).ready(function () {
            $('#from_date').datepicker({
                dateFormat: "dd/mm/yy",

                maxDate: "+1Y",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true,
                onSelect: function (dateStr) {
                    var date = $(this).datepicker('getDate');
                    if (date) {
                        date.setDate(date.getDate() + 30);
                    }
                    $('#to_date').datepicker('option').datepicker('setDate', date);
                },
                onClose: function (dateText, inst) {
                    $('#to_date').focus();
                }
            });
            $("#to_date").datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true
            });
        });
    </script>
    <style>
        .page_container .page-title {
            padding: 0;
        }

        .page_container .container-fluid {
            padding: 33px 0;
        }

        .title h2 {
            color: var(--primary-1-d-2-d-53, #1D2D53) !important;
            font-size: 28px !important;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 42px */
        }

        .title p {
            color: var(--chroma-717171, #717171) !important;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .row_filter th .form-country select {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
            height: auto;
        }

        .table_list_booking .table_responsive thead tr th {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 21px */
            text-transform: uppercase;
        }

        .row_custom .td_overflow a, .row_custom .block_responsive, .row_custom .block_responsive strong, .page_billing_history .complete_payment, .page_billing_history .waiting_payment, .statistical tr td {
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .row_custom .td_overflow a {
            color: var(--secondary-177-fa-4, #177FA4);
        }

        .page_billing_history .status_payment {
            white-space: nowrap;
        }

        .btn_exportex {
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
            display: inline-flex;
            padding: 12px 16px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            color: #FFF !important;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%;
        }

        .btn_exportex:hover {
            background: var(--secondary-177-fa-4, #177FA4);
        }

        .page_billing_history .status_payment {
            padding: 5px 7px;
        }

        .icon_gradient {
            background: linear-gradient(45deg, #FF6100, #FDB82E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            font-size: 20px;
        }

        .page_container .page-title {
            flex-direction: column;
        }
        .page-title.d-flex h2 {
            display: flex;
            gap: 16px;
        }
        .icon_txt_pro {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .icon_txt_pro .txt_pro {
            color: #FF770C !important;
            font-size: 14px !important;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }
    </style>
{/literal}
<link rel="stylesheet" type="text/css" href="{$URL_JS}/datepicker/jquery-ui.css?ver={$upd_version}"/>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js?v={$upd_version}"></script>