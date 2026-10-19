{if $type eq 'TypeOfTrip' or $type eq 'VehicleType'}

{else}
<fieldset>
	<legend>{$core->get_Lang('selectsetting')}</legend>
	<ul class="rsl-list-link">
		{if $type eq 'TypeRoom'}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','RoomFacilities')}
		<li>
			<a title="Room Facilities" href="{$PCMS_URL}/?mod=property&type=RoomFacilities">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Room Facilities')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','HotelFacilities')}
		<li>
			<a title="Hotel Facilities" href="{$PCMS_URL}/?mod=property&type=HotelFacilities">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Hotel Facilities')}</span>
			</a>
		</li>
		{/if}
		{elseif $type eq 'RoomFacilities'}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','TypeRoom')}
		<li>
			<a title="Room Type" href="{$PCMS_URL}/?mod=property&type=TypeRoom">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Room Type')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','RoomFacilities')}
		<li>
			<a title="Room Facilities" href="{$PCMS_URL}/?mod=property&type=RoomFacilities">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Room Facilities')}</span>
			</a>
		</li>
		{/if}
		{elseif $type eq 'HotelFacilities'}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','TypeRoom')}
		<li>
			<a title="Room Type" href="{$PCMS_URL}/?mod=property&type=TypeRoom">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Room Type')}</span>
			</a>
		</li>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','RoomFacilities')}
		<li>
			<a title="Room Facilities" href="{$PCMS_URL}/?mod=property&type=RoomFacilities">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Room Facilities')}</span>
			</a>
		</li>
		{/if}
		{else}
		{assign var=lstTourType value=$clsTourStore->getListType()}
		{foreach from=$lstTourType key=k item=v}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','store','default',$k)}
		<li>
			<a href="{$PCMS_URL}/?admin&mod=tour&act=store&type={$core->encryptID($k)}">
				<span class="text"><i class="fa fa-cog"></i> {$v}</span>
			</a>
		</li>
		{/if}
		{/foreach}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','store','default',$k)}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=TOUROPTION">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Class')}</span>
			</a>
		</li>
		{/if}
		{if $clsConfiguration->getValue('SiteHasCat_Tours')}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','category','default')}
		<li>
			<a href="{$PCMS_URL}/?&mod=tour&act=category">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Travel Styles')}</span>
			</a>
		</li>
		{/if}
		{/if}
		{if $clsConfiguration->getValue('SiteHasCatByCountry_Tours')}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','category_country','default')}
		<li>
			<a href="{$PCMS_URL}/?&mod=tour&act=category_country">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Travel Styles by Countries')}</span>
			</a>
		</li>
		{/if}
		{/if}
		{if $clsConfiguration->getValue('SiteHasService_Tours')}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','service','default')}
		<li>
			<a href="{$PCMS_URL}/?&mod=property&act=service">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Addon Services')}</span>
			</a>
		</li>
		{/if}
		{/if}
		{if $clsConfiguration->getValue('SiteHasTransport_Tours')}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','transport','default')}
		<li>
			<a href="{$PCMS_URL}/?mod=property&act=transport">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Transportation')}</span>
			</a>
		</li>
		{/if}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','property','default','SIZEGROUP')}
		<li>
			<a href="{$PCMS_URL}/?mod=tour&act=property&type=SIZEGROUP">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Group size')}</span>
			</a>
		</li>
		{/if}
		{if $clsConfiguration->getValue('SiteHasActivities_Tours')}
		{if $clsISO->getCheckActiveModulePackage($package_id,'property','activities','default')}
		<li>
			<a href="{$PCMS_URL}/?mod=property&act=activities">
				<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Activities')}</span>
			</a>
		</li>
		{/if}
		{/if}
		{/if}
	</ul>
</fieldset>
{/if}