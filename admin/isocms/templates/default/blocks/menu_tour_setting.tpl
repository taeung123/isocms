<div class="menu_setting_box">
	<ul class="ul_menu_setting">
		{assign var=lstTourType value=$clsTourStore->getListType()}
		{foreach from=$lstTourType key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','store','default',$core->encryptID($k))}
		<li class="{if $type==$k}current{/if}">
			<a href="{$PCMS_URL}/?mod=tour&act=store&type={$core->encryptID($k)}">
				<span class="text">{$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','service','default')}
		<li class="{if $mod=='property'&&$act=='service'}current{/if}">
			<a href="{$PCMS_URL}/?&mod=property&act=service">
				<span class="text">{$core->get_Lang('Addon Services')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','category','default')}
		<li class="{if $mod=='tour'&&$act=='category'}current{/if}">
			<a href="{$PCMS_URL}/?&mod=tour&act=category" title="{$core->get_Lang('Travel Styles')}">
				<span class="text">{$core->get_Lang('Travel Styles')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','transport','default')}
		<li class="{if $mod=='property'&&$act=='transport'}current{/if}">
			<a href="{$PCMS_URL}/?mod=property&act=transport" title="{$core->get_Lang('Transportations')}">
				<span class="text">{$core->get_Lang('Transportations')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','activities','default')}
		<li class="{if $mod=='property'&&$act=='activities'}current{/if}">
			<a href="{$PCMS_URL}/?mod=property&act=activities" title="{$core->get_Lang('Type of activity')}">
				<span class="text">{$core->get_Lang('Type of activity')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','MEAL')}
		<li class="{if $type=='MEAL'}current{/if}">
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=MEAL">
				<span class="text">{$core->get_Lang('Meals')}</span>
			</a>
		</li>
		{/if}
		
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','TOUROPTION')}
		<li class="{if $type=='TOUROPTION'}current{/if}">
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=TOUROPTION" title="{$core->get_Lang('Price class')}">
				<span class="text">{$core->get_Lang('Price class')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','group','default')}
		<li class="{if $mod=='tour'&&$act=='group'}current{/if}">
			<a title="{$core->get_Lang('Market')}" href="{$PCMS_URL}/?mod=tour&act=group">
				<span class="text">{$core->get_Lang('Market')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','VISITORTYPE')}
		<li class="{if $type=='VISITORTYPE'}current{/if}">
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=VISITORTYPE">
				<span class="text">{$core->get_Lang('Adults - Children - Infants type')}</span>
			</a>
		</li>
		{/if}
		
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','price_range','default')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=price_range">
				<span class="text">{$core->get_Lang('Price range')}</span>
			</a>
		</li>
		{/if}
		
		
		
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','SIZEGROUP')}
		<li class="{if $type=='SIZEGROUP'}current{/if}">
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=SIZEGROUP" title="{$core->get_Lang('Price for Groups')}">
				<span class="text">{$core->get_Lang('Price for Groups')}</span>
			</a>
		</li>
		{/if}
		
		
		
		
		
		
		
		
		
	</ul>
</div>