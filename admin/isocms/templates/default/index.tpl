{if (isset($act_image) && $act_image eq 'act_image') or $mod eq 'editor' or $act eq 'license'}
    {$core->getModule($mod,$act)}
{elseif $act eq 'print'}
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>isoCMS Administrator</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name='robots' content='noindex,nofollow'/>
        <!-- Style -->
        <link rel="stylesheet" type="text/css" href="{$URL_CSS}/print.css" media="screen"/>
        <link rel="stylesheet" href="{$URL_CSS}/fonts.min.css?v={$upd_version}" type="text/css" media="all">

        <!-- Script-->
        <script type="text/javascript" src="{$URL_JS}/jquery-3.6.0.min.js?v={$upd_version}"></script>
        <script type="text/javascript" src="{$URL_JS}/ui/jquery-ui-1.11.2.custom.min.js?v={$upd_version}"></script>
        <script type="text/javascript" src="{$URL_JS}/jquery-migrate-1.4.1.min.js?v={$upd_version}"></script>
    </head>
    <body>
    {$core->getModule($mod,$act)}
    </body>
    </html>
{else}
    {if $mod ne 'login'}
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html ng-app="myapp" xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>isoCMS Administrator</title>
                <!-- META TAG -->
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name='robots' content='noindex,nofollow'/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="shortcut icon" href="//www.vietiso.com/favicon.ico" type="image/x-icon"/>

                <link rel="stylesheet" href="{$URL_LIBRARY}/bootstrap5/bootstrap.min.css?v={$upd_version}" type="text/css"
                        media="screen">

                <link rel="stylesheet" href="{$URL_JS}/ui/jquery-ui-1.8.18.custom.css?v={$upd_version}" type="text/css"
                    media="all">
                <link rel="stylesheet" href="{$URL_JS}/dataTable/dataTables.jqueryui.min.css?v={$upd_version}">
                <link rel="stylesheet" href="{$URL_JS}/alertify/alertify.core.css?v={$upd_version}" type="text/css"
                    media="all">
                <link rel="stylesheet" href="{$URL_CSS}/utilities.min.css?v={$upd_version}" type="text/css" media="all">
                <link rel="stylesheet" href="{$URL_JS}/select2/select2.min.css?v={$upd_version}" type="text/css"
                    media="all"/>
                <link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
                <link rel="stylesheet" href="{$URL_CSS}/animate.min.css?v={$upd_version}" type="text/css" media="all">
                <link rel="stylesheet" href="{$URL_CSS}/font-awesome.min.css?v={$upd_version}" type="text/css" media="all">
                <link rel="stylesheet" href="{$URL_CSS}/layout.css?v={$upd_version}" type="text/css" media="all">
                <link rel="stylesheet" href="{$URL_CSS}/admin.css?v={$upd_version}" type="text/css" media="all">
                {if $mod eq "ticket"}
                    <link rel="stylesheet" href="{$URL_CSS}/ticket.css?v={$upd_version}" type="text/css" media="all">
                {/if}
                <link rel="stylesheet" href="{$URL_CSS}/jquery-confirm.min.css?v={$upd_version}" type="text/css"
                    media="all">
                {if $use_browser eq 'Chrome'}
                    <link rel="stylesheet" href="{$URL_CSS}/chrome.css?v={$upd_version}" type="text/css" media="all">{/if}
                <!-- Scipt CSS File -->
                {$clsISO->getScript($mod, $act, 'css')}
                <!-- End Scipt CSS File -->
                {if $mod eq 'homenew2024'}
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

                    <!-- CSS Admin 2024 -->
                    <link rel="stylesheet" href="{$URL_CSS}/admin2024.css?v={$upd_version}" type="text/css" media="all">

                    <link rel="stylesheet" href="{$URL_CSS}/fontawesome/css/all.css?v={$upd_version}"/>
                {/if}
                <link rel="stylesheet" href="{$URL_CSS}/fontawesome/css/all.css?v={$upd_version}"/>
                <link rel="stylesheet" href="{$URL_LIBRARY}/fontawesome-pro-6.7.2/css/fontawesome.min.css?v={$upd_version}"/>
                <link rel="stylesheet" href="{$URL_CSS}/iso_setting.css?v={$upd_version}" type="text/css" media="all">

                <link rel="stylesheet" href="{$URL_CSS}/header_sidebar_v2.css?v={$upd_version}" type="text/css" media="all">

                <link rel="stylesheet" href="{$URL_CSS}/font_global.css?v={$upd_version}" type="text/css" media="all">

                <!--Style-->
                <script type="text/javascript" src="{$URL_JS}/jquery-3.6.0.min.js?v={$upd_version}"></script>
                <script type="text/javascript"
                        src="{$URL_JS}/ui/jquery-ui-1.11.2.custom.min.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery-migrate-1.4.1.min.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/alertify/alertify.min.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery.form.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery.price_format.1.8.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/switchbutton/jquery.switchbutton.min.js?v={$upd_version}"></script>

                <script type="text/javascript" src="{$URL_JS}/admin.js?v={$upd_version}"></script>

                <script type="text/javascript" src="{$URL_JS}/list_filter_auto_submit.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_LIBRARY}/bootstrap5/bootstrap.bundle.min.js?v={$upd_version}"></script>

                {if $mod eq 'homenew2024'}
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core/dist/umd/popper.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
                {/if}
                <script type="text/javascript">var $_document = $(document), $Core = {ldelim}{rdelim};</script>
                {$core->getBlock('var_javascript')}
                <script type="text/javascript" src="{$URL_JS}/store.min.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/select2/select2.min.js?v={$upd_version}"></script>

                <script type="text/javascript" src="{$URL_TINYMCE}/tinymce.min.js?v={$upd_version}"></script>

                <script type="text/javascript" src="{$URL_JS}/isoTextArea.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/ticket.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery.slimscroll.min.js?v={$upd_version}"></script>

                <script type="text/javascript" src="{$URL_JS}/header_sidebar_v2.js?v={$upd_version}"></script>

                <!-- Script Language -->
                {$scriptlang}
                <!-- End Language -->
                {literal}
                    <script type="text/javascript">
                        $.datepicker.regional['vi'] = {
                            closeText: 'Đóng',
                            prevText: '&#x3c;Trước',
                            nextText: 'Tiếp&#x3e;',
                            currentText: 'Hôm nay',
                            monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                                'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
                            monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                            dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
                            dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                            weekHeader: 'Tu',
                            dateFormat: 'mm/dd/yy',
                            firstDay: 0,
                            isRTL: false,
                            showMonthAfterYear: false,
                            yearSuffix: ''
                        };
                        $.datepicker.setDefaults($.datepicker.regional['vi']);
                        $(function () {
                            if ($(".validate-form").length) {
                                $(".validate-form").each(function (_i, _elem) {
                                    $(_elem).validate();
                                });
                            }
                            $(document).on('click', '.ClickSiteHelp', function (ev) {
                                $.popup.show('http://docs.vietiso.com/website', {
                                    wposition: 'left',
                                    wwidth: 560,
                                    wheight: 700
                                });
                            });
                            if (mod != 'login') {
                                loginAgain();
                            }
                        });

                        function loginAgain() {
                            $.post(path_ajax_script + "/?mod=home&act=loginAgain", {}, function () {
                                setTimeout(() => {
                                    loginAgain();
                                }, 300000);
                            });
                        }
                    </script>
                {/literal}
                <script type="text/javascript" src="{$URL_JS}/jquery.core.js?v={$upd_version}"></script>
                {if $mod eq "booking" || $mod eq "ticket"}
                    <link rel="stylesheet" href="{$URL_JS}/jquery-easyui/themes/gray/easyui.css?v={$upd_version}"
                        type="text/css" media="screen">
                    <link rel="stylesheet" href="{$URL_CSS}/toggle-switch.css?v={$upd_version}" type="text/css"
                        media="screen">
                    <script type="text/javascript"
                            src="{$URL_JS}/jquery-easyui/jquery.easyui.min.js?v={$upd_version}"></script>
                    {if $mod eq "booking"}
                        <script type="text/javascript" src="{$URL_JS}/jquery.booking.js?v={$upd_version}"></script>
                    {/if}
                {/if}
                <script type="text/javascript" src="{$URL_JS}/jquery.smartTab.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery.promotion.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>
                <!-- ISOMAN -->
                <link rel="stylesheet" href="{$DOMAIN_NAME}/inc/isoman/css/skin.css?v={$upd_version}" type="text/css"
                    media="all">
                <script type="text/javascript"
                        src="{$DOMAIN_NAME}/inc/isoman/js/jquery.cookie.js?v={$upd_version}"></script>
                <script type="text/javascript" src="{$DOMAIN_NAME}/inc/isoman/js/man.js?v={$upd_version}"></script>
                <script type="text/javascript"
                        src="//maps.googleapis.com/maps/api/js?key={$API_GOOGLE_MAPS}&libraries=places"></script>
                {if $mod ne 'home'}
                    <script src="{$URL_JS}/dataTable/jquery.dataTables.min.js?v={$upd_version}"></script>
                    <script src="{$URL_JS}/dataTable/dataTables.jqueryui.min.js?v={$upd_version}"></script>
                {/if}
                <!-- Tag -->
                <link rel="stylesheet" href="{$URL_JS}/bootstrap-tagsinput/src/bootstrap-tagsinput.css?v={$upd_version}"
                    type="text/css" media="all">
                <script type="text/javascript"
                        src="{$URL_JS}/bootstrap-tagsinput/src/bootstrap-tagsinput.js?v={$upd_version}"></script>

                <!-- End -->
            </head>
            <body class="ltr iso-admin-shell-v2 iso-sidebar-initializing" id="wrapper">
                {$core->getHeader($mod,'_header')}
                {$core->getModule($mod,$act)}
                {$core->getHeader($mod,'_footer')}
                <!-- Script JS File -->
                {$clsISO->getScript($mod, $act, 'js')}
                <!-- End Script -->
                <div id="modal" class="modal fade" style="z-index:5">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="loader pt10 pb10"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {literal}
                    <script id="modal-message" type="text/template">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h5 class="modal-title">{{title}}</h5></div>
                        <div class="modal-body"><p>{{message}}</p></div></script>
                {/literal}
                {literal}
                    <script id="modal-success" type="text/template">
                        <div class="modal-body text-center">
                            <div class="big-icon success"><i class="fa fa-thumbs-o-up fa-3x"></i></div>
                            <h4>{{title}}</h4>
                            <p class="mt20">{{message}}</p></div></script>
                {/literal}
                {literal}
                    <script id="modal-error" type="text/template">
                        <div class="modal-body text-center">
                            <div class="big-icon error"><i class="fa fa-times fa-3x"></i></div>
                            <h4>{{title}}</h4>
                            <p class="mt20">{{message}}</p></div></script>
                {/literal}
                {literal}
                    <script id="modal-confirm" type="text/template">
                        <div class="modal-header"><h5 class="modal-title">{{title}}</h5></div>
                        <div class="modal-body"><p>{{message}}</p></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Trở lại</button>
                            <button type="button" class="btn btn-primary" id="modal-confirm-ok">Xác Nhận</button>
                        </div></script>
                {/literal}
            </body>
        </html>
    {else}
        {$core->getModule($mod,$act)}
    {/if}
{/if}
