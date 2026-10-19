<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}?mod=email_template">{$core->get_Lang('emailtemplate')}</a>
	<!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>
        	{$core->get_Lang('emailtemplate')} 
            {*<a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a>*}
        </h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
    <div class="clearfix"></div>
    <div class="wrap mt30">
    	<table id="list_tour">
			<thead>
				<tr>
					<th style="width:40px; text-align: center"><input id="check_all" type="checkbox" style="margin-top:5px;" /></th>
					<th style="width: 60px; text-align: center">{$core->get_Lang('ID')}</th>
					<th align="left">{$core->get_Lang('Name')}</th>
					<th style="text-align:left; width:180px"><strong>{$core->get_Lang('Category')}</strong></th>
					<th style="width: 106px; text-align: center">{$core->get_Lang('Function')}</th>
				</tr>
			</thead>
			<tbody id="SortAble">
			{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].email_template_id}"
					class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="check_40"><input name="p_key[]" class="chkitem" type="checkbox"
					value="{$allItem[i].email_template_id}"/></td>
					<td class="index hiden767" data-title="ID"><span>{$allItem[i].email_template_id}</span></td>
					<td class="text-left name_service">
					<strong class="title"
					title="{$clsClassTable->getTitle($allItem[i].email_template_id)}">{$clsClassTable->getTitle($allItem[i].email_template_id)}</strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr"
					style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}

					<button type="button" class="toggle-row inline_block767" style="display:none"><i
					class="fa fa-caret fa-caret-down"></i></button>
					</td>
					<td class="block_responsive text-left bold"
					data-title="{$core->get_Lang('travelstyles')}">{$clsEmailTemplateCat->getTitle($allItem[i].cat_id)}</td>
					<td class="block_responsive" align="center"
						style="vertical-align: middle; text-align:center;white-space: nowrap;"
						data-title="{$core->get_Lang('func')}">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button"
									data-toggle="dropdown">
								<i class="icon-cog"></i> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{if $allItem[i].is_trash eq '0'}
								<li><a title="{$core->get_Lang('edit')}"
								href="{$PCMS_URL}/?mod={$mod}&act=edit{if $is_set=='free'}&is_set=free{/if}&email_template_id={$core->encryptID($allItem[i].email_template_id)}"><i
								class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a>
								</li>
								<li><a title="{$core->get_Lang('trash')}"
								href="{$PCMS_URL}/?mod={$mod}&act=trash&email_template_id={$allItem[i].email_template_id}{$pUrl}&page={$currentPage}"><i
								class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a>
								</li>
								{else}
								<li><a title="{$core->get_Lang('restore')}"
								href="{$PCMS_URL}/?mod={$mod}&act=restore&email_template_id={$allItem[i].email_template_id}{$pUrl}&page={$currentPage}"><i
								class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a>
								</li>
								<li style="display: none"><a title="{$core->get_Lang('delete')}" class="confirm_delete"
								href="{$PCMS_URL}/?mod={$mod}&act=delete&email_template_id={$allItem[i].email_template_id}{$pUrl}&page={$currentPage}"><i
								class="icon-remove"></i>
								<span>{$core->get_Lang('delete')}</span></a></li>
								{/if}
							</ul>
						</div>
					</td>
				</tr>
			{/section}
			</tbody>
		</table>
		<script>
		var City='{$core->get_Lang("Category")}';
		var duration='{$core->get_Lang("duration")}';
		</script>
		{literal}
		<script>
		$(document).ready(function(){
			$('#list_tour').DataTable({
				columnDefs: [
				  { orderable: false, targets: '_all' }
				],
				initComplete: function () {
				}
			});

		});
		</script>
		{/literal}
	</div>
</div>