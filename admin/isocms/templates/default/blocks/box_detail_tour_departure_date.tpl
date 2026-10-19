<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-12">
			<div class="fill_data_box">
				<h3 class="title_box mb05">{$core->get_Lang('Departure Schedule')}</h3>
				<p class="help-block text-muted ">{$core->get_Lang('Departure_Schedule_Notes')}</p>
				<div class="admin-toolbar-action">
					<a href="javascript:void(0)" class="iso_btn_active iso_btn_item btn btn-success mr-2" title="{$core->get_Lang('Active')}">{$core->get_Lang('Active')}</a>
					<a href="javascript:void(0)" class="iso_btn_delete iso_btn_item btn btn-error mr-2" title="{$core->get_Lang('Delete')}">{$core->get_Lang('Delete')}</a>
					<a href="javascript:void(0)" class="btn btn-warning mr-2" onClick="open_departure_date(this)" openFrom="general" tour_id="{$pvalTable}" date_id="0" title="{$core->get_Lang('Add Departure')}">{$clsISO->makeIcon('plus', $core->get_Lang('Add Departure'))}</a>
				</div>
				<div class="form_option_tour mt-40">
					<div class="calendar" id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
<style>
	.iso_departure_date_delete {
		width: 100%;
		text-align: left;
		padding-left: 4px;
		margin-top: -3px;
	}

	.iso_departure_date_delete input {
		cursor: pointer;
	}

	.iso_btn_item{
		display: none;
	}

	.iso_btn_item.active{
		display: block;
	}

	.iso_btn_delete{
		border: 1px solid;
	}
	.fc-h-event .fc-event-main{
		color: #000 !important;
	}
</style> 
{/literal}