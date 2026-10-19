<div class="menu_setting_box">
    <ul class="ul_menu_setting">
        <li class="{if $mod=='voucher' && $act=='setting'}current{/if}">
            <a href="{$PCMS_URL}/?mod=voucher&act=setting">
                <span class="text">{$core->get_Lang('Module Setting')}</span>
            </a>
        </li>
        <li class="{if $mod=='property' && $act=='default' && $type =='Unit'}current{/if}">
            <a href="{$PCMS_URL}/?mod=property&type=Unit" title="{$core->get_Lang('Unit')}">
                <span class="text">{$core->get_Lang('Unit')}</span>
            </a>
        </li>
    </ul>
</div>