{if $template eq '_form'}
<div class="modal-dialog">
	<div class="modal-content bootstrap">
		<div class="modal-header version-xs">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">{$core->get_Lang('TypeOfTravel')}</h4>
		</div>
		<form method="post" id="frmItinerary" class="frmform" enctype="multipart/form-data">
			<div class="modal-body version-xs">
				<div class="form-group">
					<label class="col-form-label">{$core->get_Lang('CategoryName')}</label>
					<input type="text" class="form-control titleTourCategory" name="title" placeholder="Tên" value="{$oneCat.title}" />
				</div>
			</div>
			<div class="modal-footer version-xs">
				<button type="button" class="btn btn-primary saveTourCategory" tour_id="{$tour_id}" cat_id="{$cat_id}">
					<i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Save')}</span>
				</button>
			</div>
		</form>
	</div>
</div>
{else}
<div class="modal-dialog modal-md">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">{$core->get_Lang('TypeOfTravel')}</h4>
		</div>
		<div class="modal-body">
			<div class="hastable table-wrapper">
				<table border="0" class="table table-striped  table-iloocal m-0" cellpadding="0" cellspacing="0" width="100%">
					<thead><tr>
						<th class="text-center" width="5%">No.</th>
						<th class="text-left">{$core->get_Lang('Name')}</th>
						<th class="text-center" width="120px">{$core->get_Lang('Action')}</th>
					</tr></thead>
					<tbody class="tbodyTourCat" tour_id="{$tour_id}">
					{section name=i loop=$list_category}
					<tr>
						<td class="text-center">{$smarty.section.i.iteration}</td>
						<td id="TourCategory_{$list_category[i].tourcat_id}">{$list_category[i].title}</td>
						<td class="text-center">
							<a class="btn btn-xs btn-default editTourCategory" href="javascript:void(0)" title="{$core->get_Lang('Edit')}" tour_id="{$tour_id}" cat_id="{$list_category[i].tourcat_id}">{$clsISO->makeIcon('pencil')}</a>
							<a class="btn btn-xs btn-default mx-2 deleteTourCategory" href="javascript:void(0)" title="{$core->get_Lang('Delete')}" tour_id="{$tour_id}" cat_id="{$list_category[i].tourcat_id}">{$clsISO->makeIcon('trash')}</a>
						</td>
					</tr>
					{/section}
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal-footer version-xs">
			<button type="button" class="btn btn-danger" data-dismiss="modal">
				<span>{$core->get_Lang('Close')}</span>
			</button>
		</div>
	</div>
</div>
{/if}