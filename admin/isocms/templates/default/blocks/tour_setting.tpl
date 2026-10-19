<fieldset>
	<legend>{$core->get_Lang('selectsetting')}</legend>
	<ul class="rsl-list-link">
		{assign var=lstTourType value=$clsTourStore->getListType()}
		{foreach from=$lstTourType key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','store','default',$core->encryptID($k))}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=store&type={$core->encryptID($k)}">
				<span class="text"><i class="fa fa-cog"></i> {$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','TOUR')}
		<li>
			<a href="{$PCMS_URL}/?mod=promotionpro&type=TOUR">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Best Deals')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','service','default')}
		<li>
			<a href="{$PCMS_URL}/?&mod=property&act=service">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Addon Services')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','category','default')}
		<li>
			<a href="{$PCMS_URL}/?&mod=tour&act=category">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Travel Styles')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','category_country','default')}
		<li>
			<a href="{$PCMS_URL}/?&mod=tour&act=category_country">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Travel Styles by Countries')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','transport','default')}
		<li>
			<a href="{$PCMS_URL}/?mod=property&act=transport">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Transportation')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','activities','default')}
		<li>
			<a href="{$PCMS_URL}/?mod=property&act=activities">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Activities')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','MEAL')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=MEAL">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Meals')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','price_range','default')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=price_range">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Price range')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','TOUROPTION')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=TOUROPTION">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Class')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','group','default')}
		<li>
			<a title="{$core->get_Lang('Group Tours')}" href="{$PCMS_URL}/?mod=tour&act=group">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Group Tours')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','VISITORTYPE')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=VISITORTYPE">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Traveller')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','SIZEGROUP')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=SIZEGROUP">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Group size')}</span>
			</a>
		</li>
		{/if}
	</ul>
</fieldset>