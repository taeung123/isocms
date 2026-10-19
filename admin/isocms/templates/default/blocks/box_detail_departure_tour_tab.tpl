<div class="tabbox departureTab" style="display:none; float:left">
	<form method="post" class="tourOption" action="">
		<div class="row-span">
			<div class="fieldlabel"><strong>{$core->get_Lang('Class')}*</strong></div>
			<div class="fieldarea">
				<div id="slb_ContainerTourOption">
					<select name="tour_option[]" id="tour_option" class="slb full required chosen-select" multiple style="width:250px">
						{assign var = selected value = $oneItem.tour_option}
						{$clsTourOption->makeSelectboxOption($selected,'TOUROPTION',0)}
						{$selected}
					</select>
				</div>
			</div>
			<a href="{$PCMS_URL}/?&mod=tour&act=property&type=TOUROPTION" style="line-height:32px; margin-left:10px"> {$core->get_Lang('Manage')}</a>
		</div>
		<div class="row-span">
			<div class="fieldlabel"><strong>{$core->get_Lang('Adult')}</strong> ({$core->get_Lang('group size')})*</div>
			<div class="fieldarea">
				<div id="slb_ContainerAdultSizeGroup">

					<select name="adult_size_group[]" id="adult_size_group" class="slb full required chosen-select" multiple style="width:250px">
						{assign var = selected value = $oneItem.adult_group_size}
						{$clsTourOption->makeSelectboxOption($selected,'SIZEGROUP',$adult_type_id)}
						{$selected}
					</select>
				</div>
			</div>
			<a href="{$PCMS_URL}/?&mod=tour&act=property&type=SIZEGROUP" style="line-height:32px; margin-left:10px"> {$core->get_Lang('Manage')}</a>
		</div>

		<div class="row-span">
			<div class="fieldlabel"><strong>{$core->get_Lang('Children')}</strong> ({$core->get_Lang('group size')})*</div>
			<div class="fieldarea">
				<div id="slb_ContainerChildSizeGroup">
					<select name="child_size_group[]" id="child_size_group" class="slb full required chosen-select" multiple style="width:250px">
						{assign var = selected value = $oneItem.child_group_size}
						{$clsTourOption->makeSelectboxOption($selected,'SIZEGROUP',$child_type_id)}
						{$selected}
					</select>
				</div>
			</div>
			<a href="{$PCMS_URL}/?&mod=tour&act=property&type=SIZEGROUP"style="line-height:32px; margin-left:10px"> {$core->get_Lang('Manage')}</a>
		</div>

		<div class="row-span">
			<div class="fieldlabel"><strong>{$core->get_Lang('Infant')}</strong> ({$core->get_Lang('group size')})*</div>
			<div class="fieldarea">
				<div id="slb_ContainerInfantSizeGroup">
					<select name="infant_size_group[]" id="infant_size_group" class="slb full required chosen-select" multiple style="width:250px">
						{assign var = selected value = $oneItem.infant_group_size}
						{$clsTourOption->makeSelectboxOption($selected,'SIZEGROUP',$infant_type_id)}
						{$selected}
					</select>
				</div>
			</div>
			<a href="{$PCMS_URL}/?&mod=tour&act=property&type=SIZEGROUP" style="line-height:32px; margin-left:10px"> {$core->get_Lang('Manage')}</a>
		</div>
		<div class="row-span">
			<div class="fieldlabel">&nbsp;</div>
			<div class="fieldarea">
				<div class="row-buttons" style="margin-right:0 !important">
					<div class="clear"></div>
					<button type="submit" class="btn-update" id="SaveTourStep11" name="submit" value="Update" style="margin-top:0">
					<i class="iso-update"></i> {$core->get_Lang('Save')}
				  </button>
					<input type="hidden" name="UpdateStep11" value="UpdateStep11" />
				</div>
			</div>
		</div>
	</form>
	<div class="wrap" style="margin-bottom:30px">
		<div class="fl span100">
			<script type="text/javascript" src="{$URL_JS}/MultiDatesPicker/jquery-ui.multidatespicker.js"></script>
			<div class="tabs_content" id="lstTabs">
				<div class="contentTab">
					<input class="text_32 full-width border_aaa" style="width:100%; max-width:692px;" type="text" id="multiDate" placeholder="{$core->get_Lang('Click to select multiple days')}" autocomplete="off" />
					<button type="submit" is_agent=0 class="btn btn-primary clickToAddNewTourGroupStartDate"><i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Add')}</span> </button>
					{if $_LANG_ID eq 'vn'}
					{literal}
					<script type="text/javascript">
						$("#multiDate").multiDatesPicker({
							dateFormat:	'mm/dd/yy',
							numberOfMonths: 3,
							dayNames: $.datepicker.regional["en"].dayNames,
							monthNamesShort: $.datepicker.regional["en"].monthNamesShort,
							monthNames: $.datepicker.regional["en"].monthNames

						});
					</script>
					<style type="text/css">
						.ui-state-highlight .ui-state-default {
							background: #743620 !important;
							color: #fff !important;
						}
					</style>
					{/literal}
					{else}
					{literal}
					<script type="text/javascript">
						$("#multiDate").multiDatesPicker({
							dateFormat:	'mm/dd/yy',
							numberOfMonths: 3,
							dayNames: $.datepicker.regional["en"].dayNames,
							monthNamesShort: $.datepicker.regional["en"].monthNamesShort,
							monthNames: $.datepicker.regional["en"].monthNames

						});
					</script>
					<style type="text/css">
						.ui-state-highlight .ui-state-default {
							background: #743620 !important;
							color: #fff !important;
						}
					</style>
					{/literal}
					{/if}
					 <div id="GroupStartDateHolder"></div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	 loadListPriceTourGroupStartDate();
});
</script>
{/literal}