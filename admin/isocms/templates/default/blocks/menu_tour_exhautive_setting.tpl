
<div class="menu_setting_box">
    <ul class="ul_menu_setting">
        {foreach from=$lstMenuSettingTours key=key item=item}
            <li class="{if (!empty($type) && !empty($item.type) && $type==$item.type) || (empty($item.type) && $mod==$item.mod && $act==$item.act)}current{/if}">
                <a href="{$item.link}" title="{$item.title}">

                    <span class="menu_setting_icon" aria-hidden="true">
                        {if $item.title eq 'Addon Services'}
                            <i class="fa-solid fa-box"></i>
                        {elseif $item.title eq 'Travel Styles'}
                            <i class="fa-solid fa-table-cells"></i>
                        {elseif $item.title eq 'Transportations'}
                            <i class="fa-solid fa-bus"></i>
                        {elseif $item.title eq 'Travel Styles by Countries'}
                            <i class="fa-solid fa-earth-americas"></i>
                        {elseif $item.title eq 'Meals'}
                            <i class="fa-solid fa-utensils"></i>
                        {elseif $item.title eq 'Price class'}
                            <i class="fa-solid fa-tag"></i>
                        {elseif $item.title eq 'Visitor Type'}
                            <i class="fa-solid fa-user"></i>
                        {elseif $item.title eq 'Tour guides'}
                            <i class="fa-solid fa-user-tie"></i>
                        {elseif $item.title eq 'Price range'}
                            <i class="fa-solid fa-sack-dollar"></i>
                        {elseif $item.title eq 'Price for Groups'}
                            <i class="fa-solid fa-users"></i>
                        {elseif $item.title eq 'AI Config'}
                            <i class="fa-solid fa-robot"></i>
                        {else}
                            <i class="fa-solid fa-gear"></i>
                        {/if}
                    </span>

                    <span class="menu_setting_text">
                        <span class="menu_setting_label">{$item.title}</span>
                    </span>

                    {if $item.is_pro}
                        <span class="menu_setting_pro">Pro</span>
                    {else}
                        <span class="menu_setting_arrow" aria-hidden="true">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    {/if}

                </a>
            </li>
        {/foreach}
    </ul>
</div>

{literal}
<style>
.menu_setting_box,
.menu_setting_box * {
    box-sizing: border-box;
}

.menu_setting_box {
    display: block;
    width: 100%;
    min-width: 0;
    margin: 0 0 20px;
    padding: 12px;
    background: #fff;
    border: 1px solid #e1e8f2;
    border-radius: 14px;
    box-shadow: 0 2px 5px rgba(24, 55, 90, .04);
}

.menu_setting_box .ul_menu_setting {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: stretch;
    gap: 6px;
    width: 100%;
    margin: 0;
    padding: 0;
    list-style: none;
}

.menu_setting_box .ul_menu_setting > li {
    display: flex;
    flex: 0 1 auto;
    min-width: 0;
    max-width: 100%;
    margin: 0;
    padding: 0;
    list-style: none;
}

.menu_setting_box .ul_menu_setting > li > a {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 9px;
    width: 100%;
    min-width: 0;
    min-height: 42px;
    padding: 9px 12px;
    border: 1px solid transparent;
    border-radius: 9px;
    background: transparent;
    color: #24364b;
    font-weight: 500;
    line-height: 1.4;
    text-decoration: none;
    overflow-wrap: anywhere;
    transition: background-color .2s ease, color .2s ease;
}

.menu_setting_box .menu_setting_icon {
    display: inline-flex;
    flex: 0 0 17px;
    align-items: center;
    justify-content: center;
    width: 17px;
    color: #8294ac;
    line-height: 1;
}

.menu_setting_box .menu_setting_text {
    display: inline-flex;
    flex: 1 1 auto;
    align-items: center;
    min-width: 0;
}

.menu_setting_box .menu_setting_label {
    display: inline-block;
    min-width: 0;
    overflow-wrap: anywhere;
}

.menu_setting_box .menu_setting_arrow {
    display: inline-flex;
    flex: 0 0 10px;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    color: #9aacc2;
}

.menu_setting_box .menu_setting_pro {
    display: inline-flex;
    flex: 0 0 auto;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    padding: 2px 7px;
    border-radius: 20px;
    background: #ff810d;
    color: #fff;
    font-weight: 700;
    line-height: 1.4;
}

/* Hover */

.menu_setting_box .ul_menu_setting > li > a:hover {
    background: #f8faff;
    color: #f47716;
}

.menu_setting_box .ul_menu_setting > li > a:hover .menu_setting_icon,
.menu_setting_box .ul_menu_setting > li > a:hover .menu_setting_arrow {
    color: #f47716;
}

/* Active */

.menu_setting_box .ul_menu_setting > li.current > a {
    background: #fff1e5;
    border-color: #fff1e5;
    color: #f47716;
    font-weight: 600;
}

.menu_setting_box .ul_menu_setting > li.current > a .menu_setting_icon,
.menu_setting_box .ul_menu_setting > li.current > a .menu_setting_arrow {
    color: #f47716;
}

/* Tablet */

@media (max-width: 1180px) {
    .menu_setting_box {
        padding: 10px;
    }

    .menu_setting_box .ul_menu_setting {
        gap: 5px;
    }
    .menu_setting_box {
        display: block;
        width: 100% !important;

    }
    .menu_setting_box .ul_menu_setting > li > a {
        min-height: 40px;
        padding: 8px 10px;
    }
}

/* ========================================
   MOBILE: TWO-COLUMN MENU
   Similar to reference image 1
======================================== */

@media (max-width: 767px) {
    .menu_setting_box {

        min-width: 0;
        margin: 0 0 14px;
        padding: 9px;
        overflow: hidden;
        border-radius: 12px;
    }

    .menu_setting_box .ul_menu_setting {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-items: stretch;
        gap: 3px 5px;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .menu_setting_box .ul_menu_setting > li {
        display: flex;
        width: 100%;
        min-width: 0;
        max-width: none;
        margin: 0;
        padding: 0;
    }

    .menu_setting_box .ul_menu_setting > li > a {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        gap: 6px;
        width: 100%;
        min-width: 0;
        min-height: 37px;
        padding: 7px 6px;
        border-radius: 7px;
        line-height: 1.35;
    }

    .menu_setting_box .menu_setting_icon {
        flex: 0 0 14px;
        width: 14px;
    }

    .menu_setting_box .menu_setting_text {
        flex: 1 1 auto;
        min-width: 0;
    }

    .menu_setting_box .menu_setting_label {
        display: block;
        min-width: 0;
        overflow-wrap: anywhere;
    }

    .menu_setting_box .menu_setting_arrow {
        flex: 0 0 8px;
        margin-left: auto;
    }

    .menu_setting_box .menu_setting_pro {
        margin-left: auto;
        padding: 2px 5px;
        white-space: nowrap;
    }
}

/* Small phones */

@media (max-width: 360px) {
    .menu_setting_box {
        padding: 7px;
    }

    .menu_setting_box .ul_menu_setting {
        gap: 2px 3px;
    }

    .menu_setting_box .ul_menu_setting > li > a {
        gap: 4px;
        padding: 7px 4px;
    }

    .menu_setting_box .menu_setting_icon {
        flex-basis: 12px;
        width: 12px;
    }

    .menu_setting_box .menu_setting_arrow {
        flex-basis: 7px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .menu_setting_box .ul_menu_setting > li > a {
        transition: none;
    }
}
</style>
{/literal}
