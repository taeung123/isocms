<div class="tabbox" style="display:none">
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
	<div id="TourPriceGroupNoDeparture"></div>
	<div class="row-span">
		<div class="fieldlabel" style="width:100px">{$core->get_Lang('Deposit')}</div>
		<div class="fieldarea" style="width:auto; float:left">
			<input type="text" class="text fontLarge deposit_tour_group" tour_id="{$pvalTable}" value="{$oneItem.deposit}"/>(%)
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	 loadTourPriceGroupNoDeparture();
});
$(document).on('change', '.deposit_tour_group', function(ev){
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadTourPriceGroup&lang="+LANG_ID,
		data:{
			'tour_id':$_this.attr("tour_id"),
			"deposit":$_this.val(),
			'tp' : 'Save_Deposit'
		},
		dataType: "html",
		success: function(html){
			var htm = html.split('|||');
			$_this.val(htm[1]);
			vietiso_loading(2);
		}
	}); 
});
</script>
{/literal}