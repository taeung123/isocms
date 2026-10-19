{assign var="duration_custom" value=$clsCruiseItinerary->getDurationCustom($cruise_itinerary_id)}
{assign var="duration_type" value=$clsCruiseItinerary->getDurationType($cruise_itinerary_id)}
{if $cruise_type eq 2}
<div class="table-wrapper mb-half radius-3">
	<table class="table table-iloocal table-bordered mb-0 radius-3">
		<tbody>
			<tr class="bg-gray">
				<td colspan="{if $priceByLow eq 0}3{else}2{/if}" class="text-left bg-gray">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<strong>{$core->get_Lang('Low season')} ({$html_low_season})</strong>
							<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="{$core->get_Lang('Low season')} ({$html_low_season})">i
							</div>
						</div>
						<div class="box_price_by">
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_low" value="1" season="low" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByLow eq 1}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Cabin')}</label>
							</div>
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_low" value="0" season="low" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByLow eq 0}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Person')}</label>
							</div>
						</div>
					</div>
				</td>
			</tr>
			{if $priceByLow eq 0}
				{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
				{foreach from=$listGroupCabin item=cabin}
					{math equation="x+1" x=$cabin.number_adult assign="total_adult_group_size"}
					{section loop=$cabin.number_adult name=j}
						{assign var=number_adult value=$smarty.section.j.iteration}
						<tr>
							{if $smarty.section.j.index eq 0}
								<td width="25%" class="text-left" rowspan="{$cabin.number_adult}">
									<span>{$cabin.title}</span>
								</td>
							{/if}
							<td width="55%" class="text-left" >
								<div class="d-flex justify-content-between align-items-center">
									{if $number_adult gt 1}
										<span>{$number_adult} {$core->get_Lang('adults')}</span>
									{else}
										<span>{$number_adult} {$core->get_Lang('adult')}</span>
									{/if}
									<div class="input-group input-group_price d-flex align-items-center">
										<input class="text full price-In cruise_season_price overnight fontLarge" group_size_id="{$cabin.cruise_property_id}" season="low" cruise_id="{$cruise_id}"
										cruise_itinerary_id="{$cruise_itinerary_id}" value="{if !empty($config_price_overnight[$cabin.cruise_property_id].low.person[$number_adult])}{$config_price_overnight[$cabin.cruise_property_id].low.person[$number_adult]}{/if}" number_adult="{$number_adult}" type="text">
										<span class="input-group-addon">{$clsISO->getRate()}</span>
									</div>
								</div>
							</td>
						</tr>
					{/section}
				{/foreach}
			{else}
				{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
				{foreach from=$listGroupCabin item=cabin}
					<tr>
						<td width="80%" class="text-left">
							<div class="d-flex justify-content-between align-items-center">
								<div class="box_left_group">
									<span>{$cabin.title}</span>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<div class="input-group input-group_price d-flex align-items-center">
										<input class="text full price-In cruise_season_price overnight fontLarge" group_size_id="{$cabin.cruise_property_id}" season="low" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{if !empty($config_price_overnight[$cabin.cruise_property_id].low.carbin)}{$config_price_overnight[$cabin.cruise_property_id].low.carbin}{/if}" type="text">
										<span class="input-group-addon">{$clsISO->getRate()}</span>
									</div>
								</div>
							</div>
						</td>
					</tr>
				{/foreach}
			{/if}
		</tbody>
	</table>
</div>
<div class="table-wrapper mb-half radius-3">
	<table class="table table-iloocal table-bordered mb-0 radius-3">
		<tbody>
			<tr class="bg-gray">
				<td  colspan="{if $priceByHigh eq 0}3{else}2{/if}" class="text-left bg-gray">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<strong>{$core->get_Lang('High season')} ({$html_high_season})</strong>
							<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="{$core->get_Lang('High season')} ({$html_high_season})">i
							</div>
						</div>
						<div class="box_price_by">
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_high" value="1" season="high" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByHigh eq 1}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Cabin')}</label>
							</div>
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_high" value="0" season="high" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByHigh eq 0}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Person')}</label>
							</div>
						</div>
					</div>
				</td>
			</tr>
			{if $priceByHigh eq 0}
				{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
				{foreach from=$listGroupCabin item=cabin}
					{math equation="x+1" x=$cabin.number_adult assign="total_adult_group_size"}
					{section loop=$cabin.number_adult name=j}
						{assign var=number_adult value=$smarty.section.j.iteration}
						<tr>
							{if $smarty.section.j.index eq 0}
								<td width="25%" class="text-left" rowspan="{$cabin.number_adult}">
									<span>{$cabin.title}</span>
								</td>
							{/if}
							<td width="55%" class="text-left" >
								<div class="d-flex justify-content-between align-items-center">
									{if $number_adult gt 1}
										<span>{$number_adult} {$core->get_Lang('adults')}</span>
									{else}
										<span>{$number_adult} {$core->get_Lang('adult')}</span>
									{/if}
									<div class="input-group input-group_price d-flex align-items-center">
										<input class="text full price-In cruise_season_price overnight fontLarge" group_size_id="{$cabin.cruise_property_id}" season="high" cruise_id="{$cruise_id}"
										cruise_itinerary_id="{$cruise_itinerary_id}" value="{if !empty($config_price_overnight[$cabin.cruise_property_id].high.person[$number_adult])}{$config_price_overnight[$cabin.cruise_property_id].high.person[$number_adult]}{/if}" number_adult="{$number_adult}" type="text">
										<span class="input-group-addon">{$clsISO->getRate()}</span>
									</div>
								</div>
							</td>
						</tr>
					{/section}
				{/foreach}
			{else}
				{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
				{foreach from=$listGroupCabin item=cabin}
					<tr>
						<td width="80%" class="text-left">
							<div class="d-flex justify-content-between align-items-center">
								<div class="box_left_group">
									<span>{$cabin.title}</span>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<div class="input-group input-group_price d-flex align-items-center">
										<input class="text full price-In cruise_season_price overnight fontLarge" group_size_id="{$cabin.cruise_property_id}" season="high" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{if !empty($config_price_overnight[$cabin.cruise_property_id].high.carbin)}{$config_price_overnight[$cabin.cruise_property_id].high.carbin}{/if}" number_adult="0" type="text">
										<span class="input-group-addon">{$clsISO->getRate()}</span>
									</div>
								</div>
							</div>
						</td>
					</tr>
				{/foreach}
			{/if}
		</tbody>
	</table>
</div>
{elseif $cruise_type == 1 && $duration_type == 1}
<div class="table-wrapper mb-half radius-3">
	<table class="table table-iloocal table-bordered mb-0 radius-3">
		<tbody>
			<tr class="bg-gray">
				<td colspan="{if $priceByLow eq 0}3{else}2{/if}" class="text-left bg-gray">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<strong>{$core->get_Lang('Low season')} ({$html_low_season})</strong>
							<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="{$core->get_Lang('Low season')} ({$html_low_season})">i
							</div>
						</div>
						<div class="box_price_by">
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_low" value="0" season="low" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByLow eq 0}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Person')}</label>
							</div>
						</div>
					</div>
				</td>
			</tr>
			{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
			{foreach from=$listGroupCabin item=cabin}
				{math equation="x+1" x=$cabin.number_adult assign="total_adult_group_size"}
				{section loop=$cabin.number_adult name=j}
					{assign var=number_adult value=$smarty.section.j.iteration}
					<tr>
						{if $smarty.section.j.index eq 0}
							<td width="25%" class="text-left" rowspan="{$cabin.number_adult}">
								<span>{$cabin.title}</span>
							</td>
						{/if}
						<td width="55%" class="text-left" >
							<div class="d-flex justify-content-between align-items-center">
								{if $number_adult gt 1}
									<span>{$number_adult} {$core->get_Lang('adults')}</span>
								{else}
									<span>{$number_adult} {$core->get_Lang('adult')}</span>
								{/if}
								<div class="input-group input-group_price d-flex align-items-center">
									<input class="text full price-In cruise_season_price overnight fontLarge" group_size_id="{$cabin.cruise_property_id}" season="low" cruise_id="{$cruise_id}"
									cruise_itinerary_id="{$cruise_itinerary_id}" value="{if !empty($config_price_overnight[$cabin.cruise_property_id].low.person[$number_adult])}{$config_price_overnight[$cabin.cruise_property_id].low.person[$number_adult]}{/if}" number_adult="{$number_adult}" type="text">
									<span class="input-group-addon">{$clsISO->getRate()}</span>
								</div>
							</div>
						</td>
					</tr>
				{/section}
			{/foreach}
		</tbody>
	</table>
</div>
<div class="table-wrapper mb-half radius-3">
	<table class="table table-iloocal table-bordered mb-0 radius-3">
		<tbody>
			<tr class="bg-gray">
				<td  colspan="{if $priceByHigh eq 0}3{else}2{/if}" class="text-left bg-gray">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<strong>{$core->get_Lang('High season')} ({$html_high_season})</strong>
							<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="{$core->get_Lang('High season')} ({$html_high_season})">i
							</div>
						</div>
						<div class="box_price_by">
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_high" value="0" season="high" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByHigh eq 0}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Person')}</label>
							</div>
						</div>
					</div>
				</td>
			</tr>
			{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
			{foreach from=$listGroupCabin item=cabin}
					{math equation="x+1" x=$cabin.number_adult assign="total_adult_group_size"}
					{section loop=$cabin.number_adult name=j}
						{assign var=number_adult value=$smarty.section.j.iteration}
						<tr>
							{if $smarty.section.j.index eq 0}
								<td width="25%" class="text-left" rowspan="{$cabin.number_adult}">
									<span>{$cabin.title}</span>
								</td>
							{/if}
							<td width="55%" class="text-left" >
								<div class="d-flex justify-content-between align-items-center">
									{if $number_adult gt 1}
										<span>{$number_adult} {$core->get_Lang('adults')}</span>
									{else}
										<span>{$number_adult} {$core->get_Lang('adult')}</span>
									{/if}
									<div class="input-group input-group_price d-flex align-items-center">
										<input class="text full price-In cruise_season_price overnight fontLarge" group_size_id="{$cabin.cruise_property_id}" season="high" cruise_id="{$cruise_id}"
										cruise_itinerary_id="{$cruise_itinerary_id}" value="{if !empty($config_price_overnight[$cabin.cruise_property_id].high.person[$number_adult])}{$config_price_overnight[$cabin.cruise_property_id].high.person[$number_adult]}{/if}" number_adult="{$number_adult}" type="text">
										<span class="input-group-addon">{$clsISO->getRate()}</span>
									</div>
								</div>
							</td>
						</tr>
					{/section}
				{/foreach}
		</tbody>
	</table>
</div>
{elseif $lstCruiseCabin}
<div class="table-wrapper mb-half radius-3">
	<table class="table table-iloocal table-bordered mb-0 radius-3">
		<tbody>
			<tr class="bg-gray">
				<td colspan="{if $priceByLow eq 0}3{else}2{/if}" class="text-left bg-gray">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<strong>{$core->get_Lang('Low season')} ({$html_low_season})</strong>
							<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="{$core->get_Lang('Low season')} ({$html_low_season})">i
							</div>
						</div>
						<div class="box_price_by">
							{if $duration_type == 0}
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_low" value="1" season="low" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByLow eq 1}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Cabin')}</label>
							</div>
							{/if}
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_low" value="0" season="low" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByLow eq 0}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Person')}</label>
							</div>
						</div>
					</div>
				</td>
			</tr>
			{if $priceByLow eq 0}
				{foreach from=$lstCruiseCabin item=cabin key=k}
					{assign var=list_group_size value=$clsISO->makeSlashByArray($cabin.list_group_size,'|',',')}
					{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
					{assign var=total_group_size value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size)",'SUM(number_adult) AS total_group_size')}
					{math equation="x+1" x=$total_group_size[0].total_group_size assign="total_group_size"}
					<tr>
						<td width="20%" class="text-left" rowspan="{$total_group_size}">
						   <strong>{$clsCruiseCabin->getTitle($cabin.cruise_cabin_id)}</strong>
						</td>
					</tr>
					{section name=i loop=$listGroupCabin}
						{math equation="x+1" x=$listGroupCabin[i].number_adult assign="total_adult_group_size"}
						{section loop=$listGroupCabin[i].number_adult name=j}
							{assign var=number_adult value=$smarty.section.j.iteration}
							<tr>
								{if $smarty.section.j.index eq 0}
									<td width="25%" class="text-left" rowspan="{$listGroupCabin[i].number_adult}">
										<span>{$listGroupCabin[i].title}</span>
									</td>
								{/if}
								<td width="55%" class="text-left" >
									<div class="d-flex justify-content-between align-items-center">
										{if $number_adult gt 1}
											<span>{$number_adult} {$core->get_Lang('adults')}</span>
										{else}
											<span>{$number_adult} {$core->get_Lang('adult')}</span>
										{/if}
										<div class="input-group input-group_price d-flex align-items-center">
											<input class="text full price-In cruise_season_price fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="low" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'low',$number_adult)}" number_adult="{$number_adult}" type="text">
											<span class="input-group-addon">{$clsISO->getRate()}</span>
										</div>
									</div>
									{if $listGroupCabin[i].is_extra_bed}
									<div class="d-flex justify-content-between mt10">
										<div class="box_left_group">
											<span style="color: var(--main-color);">{$core->get_Lang('Extra Bed')}</span>
										</div>
										<div class="d-flex justify-content-between align-items-center">
											<div class="input-group input-group_price d-flex align-items-center">
												<input class="text full price-In cruise_season_price_extra_bed fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="low" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceExtraBedDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'low')}" number_adult="0" type="text">
												<span class="input-group-addon">{$clsISO->getRate()}</span>
											</div>
										</div>
									</div>
									{/if}
								</td>
							</tr>
						{/section}
					{/section}
				{/foreach}
			{else}
				{foreach from=$lstCruiseCabin item=cabin key=k}
					{assign var=list_group_size value=$clsISO->makeSlashByArray($cabin.list_group_size,'|',',')}
					{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
					{math equation="x+1" x=$listGroupCabin|@count assign="total_group_size"}
					<tr>
						<td width="20%" class="text-left" rowspan="{$total_group_size}">
						   <strong>{$clsCruiseCabin->getTitle($cabin.cruise_cabin_id)}</strong>
						</td>
					</tr>
					{section name=i loop=$listGroupCabin}
						<tr>
							<td width="80%" class="text-left">
								<div class="d-flex justify-content-between">
									<div class="box_left_group">
										<span>{$listGroupCabin[i].title}</span>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="input-group input-group_price d-flex align-items-center">
											<input class="text full price-In cruise_season_price fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="low" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'low')}" number_adult="0" type="text">
											<span class="input-group-addon">{$clsISO->getRate()}</span>
										</div>
									</div>
								</div>
								{if $listGroupCabin[i].is_extra_bed}
                                <div class="d-flex justify-content-between mt10">
									<div class="box_left_group">
										<span style="color: var(--main-color);">{$core->get_Lang('Extra Bed')}</span>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="input-group input-group_price d-flex align-items-center">
											<input class="text full price-In cruise_season_price_extra_bed fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="low" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceExtraBedDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'low')}" number_adult="0" type="text">
											<span class="input-group-addon">{$clsISO->getRate()}</span>
										</div>
									</div>
								</div>
                                {/if}
							</td>
						</tr>
					{/section}
				{/foreach}
			{/if}
		</tbody>
	</table>
</div>
<div class="table-wrapper mb-half radius-3">
	<table class="table table-iloocal table-bordered mb-0 radius-3">
		<tbody>
			<tr class="bg-gray">
				<td  colspan="{if $priceByHigh eq 0}3{else}2{/if}" class="text-left bg-gray">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<strong>{$core->get_Lang('High season')} ({$html_high_season})</strong>
							<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="{$core->get_Lang('High season')} ({$html_high_season})">i
							</div>
						</div>
						<div class="box_price_by">
							{if $duration_type == 0}
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_high" value="1" season="high" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByHigh eq 1}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Cabin')}</label>
							</div>
							{/if}
							<div class="boxCheckbox">
								<input type="radio" class="check_box_price_by" name="price_by_high" value="0" season="high" cruise_id="{$cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" {if $priceByHigh eq 0}checked{/if}>
								<label class="checkmark">/{$core->get_Lang('Person')}</label>
							</div>
						</div>
					</div>
				</td>
			</tr>
			{if $priceByHigh eq 0}
				{foreach from=$lstCruiseCabin item=cabin key=k}
					{assign var=list_group_size value=$clsISO->makeSlashByArray($cabin.list_group_size,'|',',')}
					{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
					{assign var=total_group_size value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size)",'SUM(number_adult) AS total_group_size')}
					{math equation="x+1" x=$total_group_size[0].total_group_size assign="total_group_size"}
					<tr>
						<td width="20%" class="text-left" rowspan="{$total_group_size}">
						   <strong>{$clsCruiseCabin->getTitle($cabin.cruise_cabin_id)}</strong>
						</td>
					</tr>
					{section name=i loop=$listGroupCabin}
						{math equation="x+1" x=$listGroupCabin[i].number_adult assign="total_adult_group_size"}
						{section loop=$listGroupCabin[i].number_adult name=j}
							{assign var=number_adult value=$smarty.section.j.iteration}
							<tr>
								{if $smarty.section.j.index eq 0}
									<td width="25%" class="text-left" rowspan="{$listGroupCabin[i].number_adult}">
										<span>{$listGroupCabin[i].title}</span>
									</td>
								{/if}
								<td width="55%" class="text-left" >
									<div class="d-flex justify-content-between">
										{if $number_adult gt 1}
											<span>{$number_adult} {$core->get_Lang('adults')}</span>
										{else}
											<span>{$number_adult} {$core->get_Lang('adult')}</span>
										{/if}
										<div class="input-group input-group_price d-flex align-items-center">
											<input class="text full price-In cruise_season_price fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="high" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'high',$number_adult)}" number_adult="{$number_adult}" type="text">
											<span class="input-group-addon">{$clsISO->getRate()}</span>
										</div>
									</div>
									{if $listGroupCabin[i].is_extra_bed}
									<div class="d-flex justify-content-between mt10">
										<div class="box_left_group">
											<span style="color: var(--main-color);">{$core->get_Lang('Extra Bed')}</span>
										</div>
										<div class="d-flex justify-content-between align-items-center">
											<div class="input-group input-group_price d-flex align-items-center">
												<input class="text full price-In cruise_season_price_extra_bed fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="high" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceExtraBedDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'high')}" number_adult="0" type="text">
												<span class="input-group-addon">{$clsISO->getRate()}</span>
											</div>
										</div>
									</div>
									{/if}
								</td>
							</tr>
						{/section}
					{/section}
				{/foreach}
			{else}
				{foreach from=$lstCruiseCabin item=cabin key=k}
					{assign var=list_group_size value=$clsISO->makeSlashByArray($cabin.list_group_size,'|',',')}
					{assign var=listGroupCabin value=$clsCruiseProperty->getAll("type='GroupSize' AND cruise_property_id  IN($list_group_size) order by order_no ASC")}
					{math equation="x+1" x=$listGroupCabin|@count assign="total_group_size"}
					<tr>
						<td width="20%" class="text-left" rowspan="{$total_group_size}">
						   <strong>{$clsCruiseCabin->getTitle($cabin.cruise_cabin_id)}</strong>
						</td>
					</tr>
					{section name=i loop=$listGroupCabin}
						<tr>
							<td width="80%" class="text-left">
								<div class="d-flex justify-content-between">
									<div class="box_left_group">
										<span>{$listGroupCabin[i].title}</span>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="input-group input-group_price d-flex align-items-center">
											<input class="text full price-In cruise_season_price fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="high" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'high')}" number_adult="0" type="text">
											<span class="input-group-addon">{$clsISO->getRate()}</span>
										</div>
									</div>
								</div>
								{if $listGroupCabin[i].is_extra_bed}
                                <div class="d-flex justify-content-between mt10">
                                    <div class="box_left_group">
                                        <span style="color: var(--main-color);">{$core->get_Lang('Extra Bed')}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="input-group input-group_price d-flex align-items-center">
                                            <input class="text full price-In cruise_season_price_extra_bed fontLarge" cruise_cabin_id="{$cabin.cruise_cabin_id}" group_size_id="{$listGroupCabin[i].cruise_property_id}" season="high" cruise_id="{$cabin.cruise_id}" cruise_itinerary_id="{$cruise_itinerary_id}" value="{$clsCruiseSeasonPrice->getPriceExtraBedDefault($cruise_itinerary_id,$cabin.cruise_cabin_id,$listGroupCabin[i].cruise_property_id,'high')}" number_adult="0" type="text">
                                            <span class="input-group-addon">{$clsISO->getRate()}</span>
                                        </div>
                                    </div>
                                </div>
                                {/if}
							</td>
						</tr>
					{/section}
				{/foreach}
			{/if}
		</tbody>
	</table>
</div>
{/if}