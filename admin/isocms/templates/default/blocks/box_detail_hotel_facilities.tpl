<div class="inpt_tour">
	<div class="hot_property_title d-flex justify-content-between">
		<label class="mb30">{$core->get_Lang('Facilities Favorite')}
			{assign var= facilities_hotel value='facilities_hotel'}
			{assign var= help_first value=$facilities_hotel}
			{if $CHECKHELP eq 1}
				<button data-key="{$facilities_hotel}" data-label="{$core->get_Lang('Facilities Favorite')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
			{/if}
		</label>
		<div class="box_right">
			<a href="#" onclick="checkAll(); return false;">{$core->get_Lang('Check All')}</a> |
			<a href="#" onclick="uncheckAll(); return false;">{$core->get_Lang('Uncheck All')}</a>
		</div>
	</div>

	<div class="facilities_box">
		<div class="row d-flex flex-wrap" onClick="loadHelp(this)">
			{section name=i loop=$listHotelFacilitiesFavorite}
				{if $clsProperty->getTitle($listHotelFacilitiesFavorite[i].property_id)}
					<div class="col-sm-4 col-xs-6">
						<div class="facilities_item" hotel_id="{$pvalTable}">
							<input type="checkbox" class="hotel_facilities_checkbox switch" name="list_HotelFacilities[]"
									{if $clsHotel->checkProperty('HotelFacilities', $pvalTable,$listHotelFacilitiesFavorite[i].property_id)} checked {/if}
								   value="{$listHotelFacilitiesFavorite[i].property_id}"/>
							<span class="text">
                                {$clsProperty->getTitle($listHotelFacilitiesFavorite[i].property_id)}
                            </span>
						</div>
					</div>
				{/if}
			{/section}
			<div class="text_help" hidden="">{$clsConfiguration->getValue($facilities_hotel)|html_entity_decode}</div>
		</div>
	</div>
</div>





<!--

<div class="inpt_tour">

	<label class="mb30">{$core->get_Lang('Other Facilities')}

		{assign var= other_facilities_hotel value='other_facilities_hotel'}

		{if $CHECKHELP eq 1}

		<button data-key="{$other_facilities_hotel}" data-label="{$core->get_Lang('Other Facilities')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>

		{/if}

	</label>

	<div class="facilities_other_box">

		<div class="facilities_box">

			<div class="row d-flex flex-wrap" onClick="loadHelp(this)">

				{section name=i loop=$listHotelFacilitiesOther}

				{if $clsProperty->getTitle($listHotelFacilitiesOther[i].property_id)}

				<div class="col-md-3 col-sm-4 col-xs-6">

					<div class="facilities_item" hotel_id="{$pvalTable}"><input type="checkbox" name="list_HotelFacilities[]" {if $clsHotel->checkProperty('HotelFacilities', $pvalTable,$listHotelFacilitiesOther[i].property_id)}checked {/if} value="{$listHotelFacilitiesOther[i].property_id}"/> <span class="text">{$clsProperty->getTitle($listHotelFacilitiesOther[i].property_id)}</span></div>

				</div>

				{/if}

				{/section}

			</div>

			<div class="text_help" hidden="">{$clsConfiguration->getValue($other_facilities_hotel)|html_entity_decode}</div>

		</div>

	</div>

</div>

-->



<div class="inpt_tour">

	<label class="mb30">{$core->get_Lang('Accommodation')}

		{assign var= other_facilities_hotel value='other_facilities_hotel'}

		{if $CHECKHELP eq 1}

			<button data-key="{$other_facilities_hotel}" data-label="{$core->get_Lang('Other Facilities')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>

		{/if}

	</label>

	<div class="facilities_other_box" style="padding: 0 5px">
 
		<div class="facilities_box">

			<div class="row">
				{section name=i loop=$listHotelProperty}

					{assign var="HotelPropertyID" value=$listHotelProperty[i].hotel_property_id}

					{assign var="HotelProperties" value=$clsProperty->getTitleByCatId($HotelPropertyID, $pvalTable)}

					{if $HotelProperties ne ''}

						<div class="col-sm-12">

							<div class="hot_property_title d-flex justify-content-between">

								<span class="fw-bold" style="font-weight: bold">{$listHotelProperty[i].title}</span>

								<div class="box_right">

									<a href="#" onclick="zCheckAll('{$HotelPropertyID}');return false">{$core->get_Lang('Check All')}</a> | <a href="#" onclick="zUncheckAll('{$HotelPropertyID}');return false">{$core->get_Lang('Uncheck All')}</a>

								</div>

							</div>

							<div class="mt-30" id="{$HotelPropertyID}">

								{$HotelProperties}

							</div>

						</div>

					{/if}

				{/section}

			</div>

			<div class="text_help" hidden="">{$clsConfiguration->getValue($other_facilities_hotel)|html_entity_decode}</div>

		</div>

	</div>

</div>

{literal}
	<script>
		function checkAll() {
			var checkboxes = document.querySelectorAll('.hotel_facilities_checkbox');
			checkboxes.forEach(function(checkbox) {
				checkbox.checked = true;
			});
		}

		function uncheckAll() {
			var checkboxes = document.querySelectorAll('.hotel_facilities_checkbox');
			checkboxes.forEach(function(checkbox) {
				checkbox.checked = false;
			});
		}
	</script>

	{/literal}
