<div class="tabbox" style="display:none">
	<div id="ComboPriceGroupNoDeparture"></div>
	<div class="row-span">
		<div class="fieldlabel" style="width:100px">{$core->get_Lang('Deposit')}</div>
		<div class="fieldarea" style="width:auto; float:left">
			<input type="text" class="text fontLarge deposit_combo_group" combo_id="{$pvalTable}" value="{$oneItem.deposit}"/>(%)
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	 loadComboPriceGroupNoDeparture();
});
$(document).on('change', '.deposit_combo_group', function(ev){
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadComboPriceGroup&lang="+LANG_ID,
		data:{
			'combo_id':$_this.attr("combo_id"),
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