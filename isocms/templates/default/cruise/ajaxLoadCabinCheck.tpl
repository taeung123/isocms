<div class="box_item_check_cabin">
    {if $cruise_type == 1 && $duration_type == 0}
	<p class="txt_cabin">{$core->get_Lang('Cabin')} {$index_cabin}</p>
    {/if}
	<div class="item_check_cabin {if $cruise_type == 2 || $duration_type == 1}d-none{/if}">
		<label>{$core->get_Lang('Bed type')}</label>
		<div class="box_left_check box_left_check_bed_type d-flex flex-wrap">
			{section name=i loop=$lstGroupSize}
				<div class="boxCheckbox boxCheckboxGroupSize">
					<input type="radio" class="check_box_itinerary" data-is_extra_bed="{$lstGroupSize[i].is_extra_bed}" data-max_adult="{$lstGroupSize[i].number_adult}" data-max_child="{$lstGroupSize[i].number_child}" name="group_size[{$index_cabin}]" value="{$lstGroupSize[i].cruise_property_id}" {if $smarty.section.i.first}checked{/if}>
					<p class="text-itinerary checkmark">{$lstGroupSize[i].title}</p>
				</div>
			{/section}
		</div>
	</div>
	<div class="item_check_cabin">
		<label>{$core->get_Lang('Adults')}</label>
		<div class="box_left_check d-flex flex-wrap">
			<div class="right__inputTraveller">
				<a class="unNum text_main disabled" _type="number_adults" href="javascript:void(0);"></a>
				<input min-number="1" max-number="{$lstGroupSize[0].number_adult}" type="number" class="ui-spinner-input number_adults input_number find_select" id="national_visitor_adult" name="number_adult" value="1" readonly/>
				<a class="upNum text_main" _type="number_adults" href="javascript:void(0);"></a>
			</div>
		</div>
	</div>
{*	{if $CheckCruisePriceChild}*}
	<div class="item_check_cabin item_check_cabin_children {if $lstGroupSize[0].number_child==0}hidden{/if}" id="item_check_cabin_children_{$index_cabin}">
		<label>{$core->get_Lang('Children')}</label>
		<div class="box_left_check d-flex flex-wrap">
			<div class="right__inputTraveller">
				<a class="unNum text_main disabled" _type="number_child" href="javascript:void(0);"></a>
				<input min-number="0" max-number="{$lstGroupSize[0].number_child}" id="national_visitor_child" type="number" class="ui-spinner-input number_child input_number find_select" name="number_child" value="0" readonly/>
				<a class="upNum text_main" _type="number_child" href="javascript:void(0);"></a>
			</div>
			<div class="box_group_child" id="box_group_child">

			</div>
		</div>
	</div>
{*	{/if}*}
    <div class="item_check_cabin item_check_extra_bed {if $lstGroupSize[0].is_extra_bed==0}hidden{/if}" id="item_check_cabin_children_{$index_cabin}">
		<label>{$core->get_Lang('Extra Bed')}</label>
        <div class="box_left_check d-flex flex-wrap">
			<input type="checkbox" class="is_extra_bed" name="is_extra_bed[{$index_cabin}]" value="1" />
		</div>
    </div>
</div>	