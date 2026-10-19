<div class="box_filter_cruise">
<div class="txt_filter">
	<label for="" class="lbl_filter">{$core->get_Lang('Filter')}</label>
</div>
	<form action="" method="post" id="form_filter_cruise">
		<input type="hidden" value="filter_cruise" name="filter_cruise">
		<div class="box_form">
{*			<div class="form_input">*}
{*				<select class="slb" name="place">*}
{*					<option value="">{$core->get_Lang('Start from')}</option>*}
{*					{$clsCruiseItinerary->getSelectTripAround($place)}*}
{*				</select>*}
{*				<i class="fa fa-angle-down" aria-hidden="true"></i>*}
{*			</div>*}

			<div class="item_sort_check form_radiocheck">
				<div class="txt_checkform">
					<span>{$core->get_Lang('Start from')}</span>
				</div>
				<div class="box_checkboxcheck">
					{$clsCruiseItinerary->getRadioTripAround($place)}
				</div>
			</div>

{*			<div class="form_input">*}
{*				<select class="slb" name="star_number">*}
{*					<option value="">{$core->get_Lang('Star rating')}</option>*}
{*					{$clsISO->makeSelectNumberStart(5,$star_number)}*}
{*				</select>*}
{*				<i class="fa fa-angle-down" aria-hidden="true"></i>*}
{*			</div>*}

			<div class="item_sort_check form_radiocheck">
				<div class="txt_checkform mt-3">
					<span>{$core->get_Lang('Star rating')}</span>
				</div>
				<div class="box_checkboxcheck">
				{$clsISO->makeCheckboxNumberStart(5,$star_number)}
				</div>
			</div>

{*			<div class="form_input">*}
{*				<select class="find_select" name="price_range_ID" id="price_range_ID"> *}
{*					<option value="">{$core->get_Lang('Price')}</option>*}
{*					{$clsCruisePriceRange->getSelectPriceRange($price_range_ID)}*}
{*				</select>*}
{*				<i class="fa fa-angle-down" aria-hidden="true"></i>*}
{*			</div>*}

			<div class="item_sort_check form_radiocheck">
				<div class="txt_checkform mt-3">
					<span>{$core->get_Lang('Price')}</span>
				</div>
				<div class="box_checkboxcheck">
					{$clsCruisePriceRange->getCheckboxPriceRange($price_range_ID)}
				</div>
			</div>

{*			{if $act eq 'default'}*}
{*				<div class="form_input">*}
{*					<select class="find_select" name="cat_ID" id="cat_ID"> *}
{*						<option value="">{$core->get_Lang('Category Cruise')}</option>*}
{*						{section name=i loop=$lstCruiseCatSearch}*}
{*							<option value="{$lstCruiseCatSearch[i].cruise_cat_id}" {if $cat_ID eq $lstCruiseCatSearch[i].cruise_cat_id}selected{/if}>{$lstCruiseCatSearch[i].title}</option>*}
{*						{/section}*}
{*					</select>*}
{*					<i class="fa fa-angle-down" aria-hidden="true"></i>*}
{*				</div>*}
{*			{/if}*}

				<div class="item_sort_check form_radiocheck">
					<div class="txt_checkform mt-3">
						<span>{$core->get_Lang('Category Cruise')}</span>
					</div>
					<div class="box_checkboxcheck">
						{section name=i loop=$lstCruiseCatSearch}
							<label>
								<input type="checkbox" name="cruise_cat_id" value="{$lstCruiseCatSearch[i].cruise_cat_id}" {if $cat_ID eq $lstCruiseCatSearch[i].cruise_cat_id}checked{/if} style="margin-right:16px">
								{$lstCruiseCatSearch[i].title}
							</label>
						{/section}
					</div>
				</div>


		</div>
	</form>
</div>

{literal}
	<script>
		$(document).ready(function() {
			/*$('input[name=cruise_cat_id]').change(function() {
				if ($(this).is(':checked')) {
					$('input[name=cruise_cat_id]').not(this).prop('checked', false);
				}
			});*/
			$('input').change(function() {
				$(this).closest("form").submit();
			});
		});

	</script>
	<style>
		.txt_filter {
			border-bottom: 1px solid #d3dce1;
			margin-bottom: 15px;
		}
		.txt_filter .lbl_filter {
			margin-bottom: 10px;
		}

		.txt_checkform {
			margin-bottom: 11px;
		}
		.box_filter_cruise {
			display: unset;
			border-bottom: 1px solid #d3dce1;
		}

		.item_sort_check {
			border-bottom: 1px solid #d3dce1;
		}

		.box_checkboxcheck {
			display: flex;
			flex-direction: column;
			gap: 16px;
			margin-bottom: 15px;
		}
		.lbl_filter {
			color: #1C1C1C;
			font-size: 18px;
			font-style: normal;
			font-weight: 600;
			line-height: 23px;
		}
	.box_filter_cruise .box_form {
		flex-wrap: unset;
		flex-direction: column;
	}

	.txt_checkform span {
		color: #1C1C1C;
		font-size: 16px;
		font-style: normal;
		font-weight: 600;
		line-height: 23px; /* 143.75% */
	}
</style>
{/literal}