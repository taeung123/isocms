<div class="tabbox departureTab" style="display:none; float:left">
	<div class="wrap" style="margin-bottom:30px">
		<div class="fl span100">
			<script type="text/javascript" src="{$URL_JS}/MultiDatesPicker/jquery-ui.multidatespicker.js"></script>
			<div class="tabs_content" id="lstTabs">
				<div class="contentTab">
					<input class="text_32 full-width border_aaa" style="width:100%; max-width:692px;" type="text" id="multiDate" placeholder="{$core->get_Lang('Click to select multiple days')}" autocomplete="off" />
					<button type="submit" is_agent=0 class="btn btn-primary clickToAddNewComboGroupStartDate"><i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Add')}</span> </button>
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
	 loadListPriceComboGroupStartDate();
});
</script>
{/literal}