<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('featurepackage')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('featurepackage')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit{$recordperpage_Url}" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>Chức năng quản lý danh sách các Faqs trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage Faqs in isoCMS system')}</p>
    </div>
	<div class="clearfix"><br /></div>
    <div class="wrap">
        <form id="forums" method="post" action="" name="filter" class="filterForm">
            <div class="ui-action">
               <div class="fl fiterbox" style="width:100%">
                    <div class="wrap">
                        <div class="searchbox">
							{assign var=lstModule value=$core->getListAdminModule()}
							<select onchange="_reload()" class="medium" name="mod_page">
								<option value="0">Select Module</option>
								{section name=i loop=$lstModule}
								<option {if $mod_page eq $lstModule[i].name}selected="selected"{/if} value="{$lstModule[i].name}">{$lstModule[i].name}</option>
								{/section}
							</select>
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                            <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                            
                        </div>
                        
                        <div class="fr group_buttons">
                            <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                            <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="FeaturePackage" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="filter" value="filter" />
        </form>
        <input id="list_selected_chkitem" style="display:none" value="0" />
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
					</td>
				</tr>
			</table>
		</div>
        <div class="clearfix"></div>
        <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
					<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('No.')}</strong></th>
					<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Name')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left;width:100px"><strong>{$core->get_Lang('Module')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left;width:150px"><strong>{$core->get_Lang('Action Page')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left;width:100px"><strong>{$core->get_Lang('Type Function')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left;width:200px"><strong>{$core->get_Lang('Type Page')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:60px"><strong>{$core->get_Lang('status')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:120px;" align="center"><strong>{$core->get_Lang('update')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:70px"><strong>{$core->get_Lang('func')}</strong></th>
				</tr>
			</thead>
			<tbody id="SortAble">
			   {section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].feature_package_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].feature_package_id}" /></th>
					<th class="index hiden767">{$smarty.section.i.iteration}</th>
					<td class="name_service">
						<strong class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].feature_package_id) eq 0}{$core->get_Lang('Faqs PRIVATE')}{/if}">{$clsClassTable->getTitle($allItem[i].feature_package_id)}</strong>
                {if $clsClassTable->getOneField('is_online',$allItem[i].feature_package_id) eq 0}<span style="color:red;" title="{$core->get_Lang('Faqs PRIVATE')}">[P]</span>{/if}
						{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
						<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
					</td>
					<td data-title="{$core->get_Lang('Module')}" class="block_responsive border_top_responsive">{$allItem[i].mod_page}</td>
					<td data-title="{$core->get_Lang('Action Page')}" class="block_responsive border_top_responsive">{$allItem[i].act_page}</td>
					<td data-title="{$core->get_Lang('Type Function')}" class="block_responsive border_top_responsive">{$allItem[i].type}</td>
					<td data-title="{$core->get_Lang('Type Page')}" class="block_responsive border_top_responsive">{$allItem[i].type_page}</td>
					
					<td data-title="{$core->get_Lang('status')}" class="block_responsive border_top_responsive" style="text-align:center">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="FeaturePackage" pkey="feature_package_id" sourse_id="{$allItem[i].feature_package_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].feature_package_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].feature_package_id) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:center">{$allItem[i].reg_date|date_format:"%d/%m/%Y %H:%M"}</td>
					<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="dropdown">
							<button class="btn btn_dropdown dropdown-toggle"
									type="button"
									data-bs-toggle="dropdown"
									aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '0'}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('edit')}"
									href="{$PCMS_URL}/?mod={$mod}&act=edit&feature_package_id={$core->encryptID($allItem[i].feature_package_id)}{$recordperpage_Url}">
										<i class="icon-edit"></i> {$core->get_Lang('edit')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('trash')}"
									href="{$PCMS_URL}/?mod={$mod}&act=trash&feature_package_id={$core->encryptID($allItem[i].feature_package_id)}{$pUrl}">
										<i class="icon-trash"></i> {$core->get_Lang('trash')}
									</a>
								</li>

								{else}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('restore')}"
									href="{$PCMS_URL}/?mod={$mod}&act=restore&feature_package_id={$core->encryptID($allItem[i].feature_package_id)}{$pUrl}">
										<i class="icon-refresh"></i> {$core->get_Lang('restore')}
									</a>
								</li>

								<li>
									<a class="dropdown-item confirm_delete"
									title="{$core->get_Lang('delete')}"
									href="{$PCMS_URL}/?mod={$mod}&act=delete&feature_package_id={$core->encryptID($allItem[i].feature_package_id)}{$pUrl}">
										<i class="icon-remove"></i> {$core->get_Lang('delete')}
									</a>
								</li>

								{/if}
							</ul>
						</div>
					</td>
				</tr>
				{/section}
			</tbody>
        </table>
        {$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
	</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
			$.post(path_ajax_script+"/index.php?mod=featurepackage&act=ajUpdPosSortListFaqs", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}