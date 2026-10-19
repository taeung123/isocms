<div class="menu_setting_box">
	<ul class="ul_menu_setting">
		<li class="{if $act=='setting'}current{/if}">
			<a href="{$PCMS_URL}/?mod=hotel&act=setting">
				<span class="text">{$core->get_Lang('Module Setting')}</span>
			</a>
		</li>
		{if $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_packages', 'customize')}
		<li class="{if $act=='hotel_packages'}current{/if}">
			<a href="{$PCMS_URL}/?mod=hotel&act=hotel_packages" title="{$core->get_Lang('Hotel Packages')}">
				<span class="text">{$core->get_Lang('Hotel Packages')}</span>
			</a>
		</li>
		{/if}

		{assign var=lstProperty value=$clsProperty->getListType()}
		{foreach from=$lstProperty key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,hotel,'property','default',$k)}
		<li class="{if $type|default:''==$k}current{/if}">
			<a title="{$v}" href="{$PCMS_URL}/index.php?mod=hotel&act=property&type={$k}" >
				<span class="text">{$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
        {if $clsISO->getCheckActiveModulePackage($package_id,hotel,'price_range','default')}
		<li class="{if $act=='price_range'}current{/if}">
			<a href="{$PCMS_URL}/?mod=hotel&act=price_range">
				<span class="text">{$core->get_Lang('Price range')}</span>
			</a>
		</li>
        {/if}
	</ul>
</div>
