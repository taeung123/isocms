<div class="menu_setting_box">
	<ul class="ul_menu_setting">
        {*<li class="{if $act=='setting'}current{/if}">
			<a href="{$PCMS_URL}/?mod=cruise&act=setting">
				<span class="text">{$core->get_Lang('Module Setting')}</span>
			</a>
		</li>*}
		{assign var=lstCruiseType value=$clsCruiseStore->getListType()}
		{foreach from=$lstCruiseType key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default',$k)}
		<li class="{if $type|default:''==$k}current{/if}">
			<a title="{$v}" href="{$PCMS_URL}/index.php?mod=cruise&act=liststore&type={$core->encryptID($k)}" >
				<span class="text">{$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','Cruise')}
		{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default')}
		{*<li class="{if $act=='store'}current{/if}">
			<a title="{$core->get_Lang('Cruise store')}" href="{$PCMS_URL}/?mod=cruise&act=store&type=Q1JVSVNFU1RPUkUtVmlldElTTw">
				<span class="text"> {$core->get_Lang('Cruise store')}</span>
			</a>
		</li>*}
		{*<li class="{if $act=='promotion'}current{/if}">
			<a title="{$core->get_Lang('Best Deals')}" href="{$PCMS_URL}/?mod=cruise&act=promotion">
				<span class="text"> {$core->get_Lang('Best Deals')}</span>
			</a>
		</li>*}

		{/if}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','service','default')}
		<li class="{if $act=='service'}current{/if}">
			<a title="{$core->get_Lang('Transfer Services')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=service" >
				<span class="text"> {$core->get_Lang('Transfer Services')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','cat','default')}
		<li class="{if $act=='cat'}current{/if}">
			<a title="{$core->get_Lang('Cruise Class')}" href="{$PCMS_URL}/index.php?mod=cruise&act=cat" >
				<span class="text"> {$core->get_Lang('Cruise Category')}</span>
			</a>
		</li>
		{/if}
		{assign var=lstCruiseProperty value=$clsCruiseProperty->getListType()}
		{if $lstCruiseProperty}
		{foreach from=$lstCruiseProperty key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default',$k)}
		<li class="{if $act=='property' && $type|default:'' == $k}current{/if}">
			<a title="{$v}" href="{$PCMS_URL}/index.php?mod={$mod}&act=property&type={$k}" >
				<span class="text"> {$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','childpolicy','default')}
		<li class="{if $act=='childpolicy'}current{/if}">
			<a title="{$core->get_Lang('chilpolicy')}" href="{$PCMS_URL}/index.php?mod=cruise&act=childpolicy" >
				<span class="text"> {$core->get_Lang('childpolicy')}</span>
			</a>
		</li>
		{/if}
		
	</ul>
</div>