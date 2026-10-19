<fieldset>
	<legend>{$core->get_Lang('selectsetting')}</legend>
	<ul class="rsl-list-link">
		{if $clsConfiguration->getValue('SiteHasStore_Cruises')}
		{assign var=lstCruiseType value=$clsCruiseStore->getListType()}
		{foreach from=$lstCruiseType key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default')}
		<li>
			<i class="fa fa-cog"></i>
			<a href="{$PCMS_URL}/?admin&mod=cruise&act=liststore&type={$core->encryptID($k)}">
				<span class="text"> {$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','Cruise')}
		{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default')}
		<li>
			<i class="fa fa-cog"></i>
			<a title="{$core->get_Lang('Cruise store')}" href="{$PCMS_URL}/?mod=cruise&act=store&type=Q1JVSVNFU1RPUkUtVmlldElTTw">
				<span class="text"> {$core->get_Lang('Cruise store')}</span>
			</a>
		</li>
		<li>
			<i class="fa fa-cog"></i>
			<a title="{$core->get_Lang('Best Deals')}" href="{$PCMS_URL}/?mod=promotionpro&type=CRUISE">
				<span class="text"> {$core->get_Lang('Best Deals')}</span>
			</a>
		</li>

		{/if}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','service','default')}
		<li>
			<i class="fa fa-cog"></i>
			<a title="{$core->get_Lang('Transfer Services')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=service" >
				<span class="text"> {$core->get_Lang('Transfer Services')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','cat','default')}
		<li>
			<i class="fa fa-cog"></i>
			<a title="{$core->get_Lang('Cruise Class')}" href="{$PCMS_URL}/index.php?mod=cruise&act=cat" >
				<span class="text"> {$core->get_Lang('Cruise Class')}</span>
			</a>
		</li>
		{/if}
		{assign var=lstCruiseProperty value=$clsCruiseProperty->getListType()}
		{if $lstCruiseProperty}
		{foreach from=$lstCruiseProperty key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default',$k)}
		<li>
			<i class="fa fa-cog"></i>
			<a title="{$v}" href="{$PCMS_URL}/index.php?mod={$mod}&act=property&type={$k}" >
				<span class="text"> {$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','childpolicy','default')}
		<li>
			<i class="fa fa-cog"></i>
			<a title="{$core->get_Lang('chilpolicy')}" href="{$PCMS_URL}/index.php?mod=cruise&act=childpolicy" >
				<span class="text"> {$core->get_Lang('childpolicy')}</span>
			</a>
		</li>
		{/if}
	</ul>
	</fieldset>