{literal}
    <script type="text/javascript">
        $(function () {
            /*$.lockfixed("#sidebar_elements", {offset: {top:0, bottom:61}});*/
            $(document).on('click', '.dropdown-toggle', function (ev) {
                var $_this = $(this);
                var $_sub = $_this.parent().find('.submenu');
                if ($_sub.is(':visible')) {
                    $_sub.stop(false, true).slideUp();
                    $_this.find('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
                    $_this.parent().removeClass('active');
                } else {
                    $('.submenu:visible').stop(false, true).slideUp();
                    $('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
                    $_sub.stop(false, true).slideDown();
                    $_this.find('.arrow').removeClass('fa-angle-down').addClass('fa-angle-up');
                    $_this.parent().addClass('active');

                }
                return false;
            });
            var $ww = $(window).width(),
                stickyOffset = $('#sidebar').offset().top;
            $(window).scroll(function () {
                var sticky = $('#sidebar');
                scroll = $(window).scrollTop();
                if (scroll >= stickyOffset || scroll >= 35) {
                    sticky.addClass('fixed');
                } else {
                    sticky.removeClass('fixed');
                }
            });
        });
    </script>
{/literal}
<ul id="sidebar-nav" class="nav nav-list">
    <li class="{if $mod eq 'homenew2024'} active{/if}">
        <a class="nav-header" href="{$PCMS_URL}" title="{$PAGE_NAME}">
            <div class="ico"><i class="fa fa-home"></i></div>
            <span class="menu-text bold">{$core->get_Lang('Dashboard')}</span>
        </a>
    </li>
    {assign var=lstAdminButtonLeft value=$clsAdminButton->getAll('is_active=1 and parent_id=0 and _type="_LEFT" order by order_no asc')}
    {section name=k loop=$lstAdminButtonLeft}
        {assign var=id value=$lstAdminButtonLeft[k].adminbutton_id}
        {assign var=lstAdminButtonLeftChild value=$clsAdminButton->getChild($id)}
        {if $clsAdminButton->checkPackage($id,$package_id)}
            {if $core->checkAccess($lstAdminButtonLeft[k].mod_page)}
                <li class="{if $mod eq $lstAdminButtonLeft[k].mod_page}active{/if}" package_id="{$package_id}">
                    <a data-toggle="ripple" {if $lstAdminButtonLeftChild}href="javascript:void(0);"
                       class="nav-header dropdown-toggle {$lstAdminButtonLeft[k].class_page}" {else}class="nav-header"
                       href="{$clsAdminButton->getURL($lstAdminButtonLeft[k].adminbutton_id)}"{/if}>
                        <div class="ico"><i class="{$lstAdminButtonLeft[k].class_iconpage}"></i></div>
                        <span class="menu-text"> {$core->get_Lang($lstAdminButtonLeft[k].title_page)}</span>
                        {if $lstAdminButtonLeftChild}<b class="arrow fa fa-angle-down"></b>{/if}
                    </a>
                    <div class="submenu" {if $mod == $lstAdminButtonLeft[k].mod_page}style="display:block;"
                         {else}style="display:none;"{/if}>
                        <ul class="nav-list sublist">
                            {section name=i loop=$lstAdminButtonLeftChild}
                                {assign var=sub_id value=$lstAdminButtonLeftChild[i].adminbutton_id}
                                {if $clsAdminButton->checkPackage($sub_id,$package_id)}
                                    {if $core->checkAccess($lstAdminButtonLeftChild[i].mod_page) and $clsAdminButton->checkConfiguration($lstAdminButtonLeftChild[i].adminbutton_id)}
                                        <li class="{$lstAdminButtonLeftChild[i].class_page}" {$lstAdminButtonLeftChild[i].mod_page}>
                                            <a data-toggle="ripple"
                                               title="{$core->get_Lang($lstAdminButtonLeftChild[i].title_page)}"
                                               href="{$clsAdminButton->getURL($lstAdminButtonLeftChild[i].adminbutton_id)}"><span><i
                                                            class="fa fa-angle-right"></i> {$core->get_Lang($lstAdminButtonLeftChild[i].title_page)} {if $lstAdminButtonLeftChild[i].mod_page=='cruise' || $lstAdminButtonLeftChild[i].mod_page=='discount'|| $lstAdminButtonLeftChild[i].mod_page=='hotel'|| $lstAdminButtonLeftChild[i].mod_page=='voucher'|| ($lstAdminButtonLeftChild[i].mod_page=='tour_exhautive' && $lstAdminButtonLeftChild[i].act_page=='store')}
                                                        <span class="badge s_pro label-warning">Pro</span>
                                                    {/if}</span>
                                            </a>
                                        </li>
                                    {/if}
                                {/if}
                            {/section}
                        </ul>
                    </div>
                </li>
            {/if}
        {/if}
    {/section}
</ul>
<div class="user_menu">
    <div class="user_right dropdown dropright">
        <a class="dropdown-toggle color_333" href="#" id="dropdownMenuButton" role="button" data-bs-toggle="dropdown"
           aria-expanded="false">
            <div class="user_name">
                <img src="https://img.pikbest.com/wp/202345/male-avatar-image-in-the-circle_9588978.jpg!sw800"
                     alt="User Avatar" title="User avatar" class="user_avatar" width="40" height="40"/>
                <div class="name_realip">
                    <span class="user_fullname">{$clsUser->getOneField('first_name',$_loged_id)} {$clsUser->getOneField('last_name',$_loged_id)}</span>
                    <span class="ip">IP: {$clsISO->getRealIP()}</span>
                </div>
            </div>
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item"
                   href="{$PCMS_URL}/index.php?mod=user&act=edit&user_id={$core->encryptID($core->_USER.user_id)}">{$core->get_Lang('myacount')}</a>
            </li>
            <li><a class="dropdown-item" href="{$PCMS_URL}/?mod=login&act=logout">{$core->get_Lang('logout')}</a></li>
        </ul>
    </div>
</div>


{literal}
    <style>
        .user_menu {
            background-color: #3B414E;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
            width: 100%;
            margin-top: 20px;
        }

        .user_name {
            display: flex;
            align-items: center;
        }

        .user_avatar {
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .user_fullname {
            font-size: 16px;
            font-weight: bold;
        }

        .ip {
            font-size: 14px;
            color: #B0B3B8;
        }

        .name_realip {
            display: flex;
            flex-direction: column;
        }

        .user_right a {
            color: #FFF;
            text-decoration: none;
        }

        .user_name .dropdown-toggle span:hover {
            text-decoration: underline;
        }

        .user_right a:hover .user_fullname {
            text-decoration: underline;
        }

        .user_menu .dropdown-menu:after, .user_menu .dropdown-menu:before {
            content: unset;
        }
    </style>
{/literal}