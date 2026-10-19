<img style="display: none" src="{$DOMAIN_NAME}/setCookie.php?v={$upd_version}"/>
{if $message eq 'NotPermission' or $message eq 'notPermission'}
    <div id="message">
        <span class="updated">{$core->get_Lang('adminnotallowaccess')}</span>
    </div>
{/if}
{if $message eq 'insertSuccess'}
    <div id="message" class="add">
        <span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/add.png"
                   width="32px"/>{$core->get_Lang('addnewsuccess')}</span>
    </div>
{/if}
{if $message eq 'RestoreSuccess'}
    <div id="message" class="restore">
        <span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/TimeMachine.png"
                   width="32px"/>{$core->get_Lang('restoringsuccess')}</span>
    </div>
{/if}
{if $message eq 'updateSuccess' or $message eq 'UpdateSuccess'}
    <div id="message" class="update">
        <span><img src="{$URL_IMAGES}/icon_admin/iSync.png" width="32px"/>{$core->get_Lang('updatesuccessful')}</span>
    </div>
{/if}
{if $message eq 'TrashSuccess'}
    <div id="message" class="trash">
        <span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/Trash-Full.png"
                   width="32px"/>{$core->get_Lang('movedtotrash')}</span>
    </div>
{/if}
{if $message eq 'titleHasExisted'}
    <div id="message" class="del">
        <span><img src="{$URL_IMAGES}/icon_admin/Del.png" width="32px"/>{$core->get_Lang('Title has Existed')}</span>
    </div>
{/if}
{if $message eq 'keyExist'}
    <div id="message" class="del">
        <span><img src="{$URL_IMAGES}/icon_admin/Del.png" width="32px"/>{$core->get_Lang('Key has Existed')}</span>
    </div>
{/if}
{if $message eq 'DeleteSuccess'}
    <div id="message" class="del">
        <span><img src="{$URL_IMAGES}/icon_admin/Del.png" width="32px"/>{$core->get_Lang('deletesuccess')}</span>
    </div>
{/if}
{if $message eq 'invalidAccess'}
    <div id="message" class="del">
        <span><img src="{$URL_IMAGES}/icon_admin/Lock.png"
                   width="32px"/>{$core->get_Lang('youdonothavepermission')}</span>
    </div>
{/if}
{if $message eq 'PositionSuccess'}
    <div id="message" class="pos">
        <span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/Pos.png"
                   width="32px"/>{$core->get_Lang('positionhasbeenchanged')}</span>
    </div>
{/if}
<header id="header" class="header">
    <div class="logo" id="logo">
        <a href="{$PCMS_URL}" title="{$PAGE_NAME}">
            <img height="43px" src="{$URL_IMAGES}/logo_vietisonew.png" alt="{$PAGE_NAME}"/>
        </a>
    </div>
    <a href="javascript:void(0);" class="sidebar-collapse-click" id="sidebar-collapse-click">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </a>

    <ul class="menu_header">
        <li>
            <a href="{$PCMS_URL}">{$core->get_Lang('Admin Page')}</a>
        </li>
        <li>
            <a href="{$DOMAIN_NAME}{$extLang}" target="_blank">{$core->get_Lang('Customer Page')}</a>
        </li>

        <li>
            <a class="ClickSiteHelp hidden767" href="javascript:void(0);" mod_page="{$mod}" act_page="{$act}"
               area_page="">{$core->get_Lang('Help')}</a>
        </li>
    </ul>
    <div class="header_right">
        <div class="current_time">
            <i class="fa-regular fa-clock"></i>
            <span id="currentTime"></span>
        </div>
        <div class="btn_questionall">
            <div class="btn_notes">
                <a href="javascript:void(0);" class="ClickSiteHelp" mod_page="{$mod}" act_page="{$act}" area_page="">
                    <i class="fa-regular fa-book-open"></i>
                    {$core->get_Lang('Docs')}
                </a>
            </div>
            <div class="question_btn">
                <a href="{$PCMS_URL}/ticket/">
                    <i class="fa-regular fa-circle-question"></i>
                    {$core->get_Lang('Support')}
                </a>
            </div>
        </div>

        {assign var=listLang value=$clsISO->getListLangAdmin()}
        <div class="dropdown menu_lang">
            <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="languageDropdown"
                    data-bs-toggle="dropdown">
                <i class="flag flag-20 flag-20-{$_LANG_ID}"></i>
                {*                <img class="flag-circle" src="https://flagcdn.com/w40/{$_LANG_ID}.png" width="24" alt="{$_LANG_ID}" title="{$_LANG_ID}">*}
                <span class="ms-2 txt_language">{$_LANG_ID}</span>
                <i class="fa fa-angle-down ms-2" aria-hidden="true"></i>
            </button>
            {if $listLang|@count > 1}
                <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                    {section name=i loop=$listLang}
                        {if $listLang[i] ne $_LANG_ID}
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="{if $listLang[i] ne $LANG_DEFAULT}{$PCMS_URL}/homenew2024?lang={$listLang[i]}{else}{$DOMAIN_NAME}{/if}">
                                    <i class="flag flag-20 flag-20-{$listLang[i]}"></i>
                                    {*                                    <img class="flag-circle" src="https://flagcdn.com/w40/{$listLang[i]}.png" width="24" alt="{$clsISO->getFullLanguage($listLang[i])}" title="{$clsISO->getFullLanguage($listLang[i])}">*}
                                    <span class="ms-2">{$clsISO->getFullLanguage($listLang[i])}</span>
                                </a>
                            </li>
                        {/if}
                    {/section}
                </ul>
            {/if}
        </div>
    </div>
</header>

{literal}
    <style>
        .menu_header, .header_right {
            display: none;
        }

        header #sidebar-collapse-click:hover, header #sidebar-collapse-click.closed {
            background: var(--primary-18-babd, #18BABD) !important;
        }

        header #sidebar-collapse-click i:hover {
            color: #FFFFFF;
        }

        .slide_bar_nav {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        /* Hiển thị menu khi nhấn vào icon ở màn hình lớn */
        @media (min-width: 992px) {
            .menu_header, .header_right {
                display: flex;
                align-items: center;
            }
        }

        /* Điều chỉnh cho menu icon */
        .sidebar-collapse-click {
            display: inline-block;
            margin-left: auto;
        }

        @media (max-width: 767px) {
            .sidebar {
                top: 60px;
            }

            .actions_required_box {
                overflow-x: scroll;
                margin-top: 20px !important;
            }

            .dashboard {
                padding: 0px 30px 0 35px;
            }

            .wrapper {
                padding-top: 70px;
            }
        }

    </style>
{/literal}
{if $deviceType ne 'phone'}
{literal}
    <script>
        function updateTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
    <style>
        .header_right .current_time {
            margin-right: 12px;
            color: #464856;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
            text-decoration: unset;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            var $ok = 1;
            if (mod == 'tour_exhautive' || mod == 'combo' || mod == 'hotel' || mod == 'cruise' || mod == 'blog' || mod == 'tour' || mod == 'property') {
                if (!$('#sidebar').hasClass('menu-min')) {
                    /*$('#sidebar').addClass('menu-min');
                    $('#sidebar-collapse-click').addClass('closed');
                    $.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{'val': 0},function(html){
                        console.log(html);
                    });*/
                    $('#sidebar').removeClass('menu-min');
                    $('#sidebar-collapse-click').removeClass('closed');
                    $.post(path_ajax_script + '/index.php?mod=home&act=ajOpenSidebar', {'val': $ok}, function (html) {
                        // console.log(html);
                    });
                }
            } else {
                if ($('#sidebar').hasClass('menu-min')) {
                    $('#sidebar').removeClass('menu-min');
                    $('#sidebar-collapse-click').removeClass('closed');
                    $.post(path_ajax_script + '/index.php?mod=home&act=ajOpenSidebar', {'val': $ok}, function (html) {
                        // console.log(html);
                    });
                }
            }
            $('#sidebar-collapse-click').click(function (ev) {
                ev.preventDefault();
                var $_this = $(this),
                    $_sidebar = $('#' + 'sidebar');
                if (!$_sidebar.hasClass('menu-min')) {
                    $ok = 0;
                    $_sidebar.addClass('menu-min');
                    $_this.addClass('closed');
                } else {
                    $ok = 1;
                    $_sidebar.removeClass('menu-min');
                    $_this.removeClass('closed');
                }
                $.post(path_ajax_script + '/index.php?mod=home&act=ajOpenSidebar', {
                    'val': $ok
                }, function (html) {
                    // Some code
                });
                return false;
            });
            $(window).on('resize', function () {
                var _www = $(window).width(),
                    _sidebar = $('#' + 'sidebar');
                if (_www < 576) { // Extra small
                    if (!_sidebar.hasClass('menu-min')) {
                        _sidebar.addClass('menu-min');
                        $('#sidebar-collapse-click').addClass('closed');
                    }
                }
            });
        });
    </script>
{/literal}
{else}
{literal}
    <script type="text/javascript">
        $(function () {
            var $ok = 1;
            if (!$('#sidebar').hasClass('menu-min')) {
                $('#sidebar').addClass('menu-min');
                $('#sidebar-collapse-click').addClass('closed');
                $.post(path_ajax_script + '/index.php?mod=home&act=ajOpenSidebar', {
                    'val': $ok
                }, function (html) {
                    // Some code
                });
            }
            $('#sidebar-collapse-click').click(function (ev) {
                ev.preventDefault();
                var $_this = $(this),
                    $_sidebar = $('#' + 'sidebar');
                if (!$_sidebar.hasClass('menu-min')) {
                    $ok = 0;
                    $_sidebar.addClass('menu-min');
                    $_this.addClass('closed');
                } else {
                    $ok = 1;
                    $_sidebar.removeClass('menu-min');
                    $_this.removeClass('closed');

                }
                $.post(path_ajax_script + '/index.php?mod=home&act=ajOpenSidebar', {
                    'val': $ok
                }, function (html) {
                    // Some code
                });
                return false;
            });
        });
    </script>
{/literal}
{/if}
<div id="wrapper" class="wrapper">
    <div id="page-body" class="page-body">
        {assign var = SIDEBAR_TOGGLE value = 'SIDEBAR_TOGGLE_'|cat:$_loged_id}
        <div class="sidebar{if $deviceType eq 'phone'} menu-min{else}{if !$clsConfiguration->getValue($SIDEBAR_TOGGLE)} menu-min{/if}{/if}"
             id="sidebar">
            <div id="sidebar_elements">
                <div class="slide_bar_nav">
                    {$core->getBlock('quick_menu2')}
                </div>
            </div>
        </div>
        <div id="page-content" class="page-content">