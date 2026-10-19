
{foreach from=$list_combo_related item=v}
<tr class="{cycle values="row1,row2"}" style="cursor: move" id="order_{$v}">
	<td class="text-left">
		{$v}
	</td>
	<td class="text-left">{$clsCombo->getTitle($v)}</td>
	<td class="text-left td_price">
		{$clsCombo->getOneField('number_day',$v)} {$core->get_Lang('Days')}
	</td>
	<td align="center" style="vertical-align: middle; text-align:center; width:60px; white-space: nowrap;">
		<div class="btn-group-ico text-right">
			<a class="clickDeleteComboRelated" title="{$core->get_Lang('delete')}" href="javascript:void(0);" data-combo_id="{$combo_id}" data-combo_related_id="{$v}"><i class="ico ico-remove"></i></a>
		</div>
	</td>
</tr>
{/foreach}
{literal}
<script type="text/javascript">
	$("#tblComboExtension").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var order = $(this).sortable("serialize")+'&update=update&combo_id='+table_id;
			$.post(path_ajax_script+"/index.php?mod=combo&act=ajUpdPosSortComboExtension", order, 

			function(html){
				vietiso_loading(0);
				if (html.indexOf('_SUCCESS') >= 0) {
					window.location.reload(true);
				} else {
					alertify.error(error);
				}
			});
		}
	});
</script>
{/literal}