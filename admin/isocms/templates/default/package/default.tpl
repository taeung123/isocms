<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>

<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Our Package')} <a class="btn btn-success" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit" title="{$core->get_Lang('Add new')}"> <i class="icon-plus icon-white"></i> <span></span></a></h2>
        <p>Chức năng quản lý danh sách các Package trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage Package in isoCMS system')}</p>
    </div>
	<div class="clearfix"></div>
    <div id="clienttabs">
        <ul>
            <li class="tabchild"><a href="#">{$core->get_Lang('List our package')}</a></li>
        </ul>
    </div>
	<div id="tab_content">
        <div class="tabbox" style="display:block">
			<form id="forums" method="post" action="" name="filter" class="filterForm">
				<div class="filterbox filterbox-border" style="width:100%">
					<div class="wrap">
						<div class="searchbox">
							<input type="text" class="text search_keyword" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
							<a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
								<i class="icon-search icon-white"></i>
							</a>
						</div>
						<div class="fr group_buttons mt10_767">
							<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
							<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
							<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Package" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
						</div>
					</div>
				</div>
				<input type="hidden" name="filter" value="filter" />
			</form>
			<div class="clearfix"><br /></div>
			{if isset($allItem[0].package_id) && $allItem[0].package_id eq ''}
			{$core->get_Lang('No data. Click Add New to continue.')}
		   
			{else}
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
			<table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
				<thead>
					<tr>
						<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
						<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
						<th class="gridheader name_responsive name_responsive3" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
						
						<th class="gridheader hiden_responsive" style="text-align:center; width:60px"><strong>{$core->get_Lang('Status')}</strong></th>
						<th class="gridheader hiden_responsive" style="width:70px" ><strong>{$core->get_Lang('Func')}</strong></th>
					</tr>
				</thead>
				
				<tbody id="SortAble">
					{foreach from=$allItem item=item name=packageLoop}
						<tr style="cursor:move" id="order_{$item.package_id}" class="{if $smarty.foreach.packageLoop.index % 2 eq 0}row1{else}row2{/if}">
							<th class="check_40">
								<input name="p_key[]" class="chkitem" type="checkbox" value="{$item.package_id}" />
							</th>
							<th class="index hiden767">{$item.package_id}</th>
							<td class="name_service">                
								<a title="Edit" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&package_id={$core->encryptID($item.package_id)}">
								<strong style="font-size:16px;">{$item.title}</strong>
								</a>
								{if $item.is_trash eq 1}<span style="color:#999">[{$core->get_Lang('Trash')}]</span>{/if}
								<button type="button" class="toggle-row inline_block767 top12" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
							</td>
							<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Package" pkey="{$pkeyTable|default:''}" sourse_id="{$item.package_id}" rel="{$clsClassTable->getOneField('is_online',$item.package_id)}" title="{$core->get_Lang('Click to change status')}">
									{if $clsClassTable->getOneField('is_online',$item.package_id) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
									{else}
										<i class="fa-solid fa-circle-minus red"></i>
									{/if}
								</a>
							</td>
							<td data-title="{$core->get_Lang('func')}" class="block_responsive" style="width: 70px; text-align: right; white-space: nowrap;">
								<div class="btn-group">
									<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
									</button>

									<ul class="dropdown-menu dropdown-menu-end">
										{if $item.is_trash eq '0'}
											<li>
												<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&package_id={$core->encryptID($item.package_id)}">
													<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
												</a>
											</li>
											<li>
												<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&package_id={$core->encryptID($item.package_id)}{$pUrl}">
													<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
												</a>
											</li>
										{else}
											<li>
												<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&package_id={$core->encryptID($item.package_id)}{$pUrl}">
													<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
												</a>
											</li>
											<li>
												<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&package_id={$core->encryptID($item.package_id)}{$pUrl}">
													<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
												</a>
											</li>
										{/if}
									</ul>
								</div>
							</td>
						</tr>    
					{/foreach}
				</tbody>
			</table>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
			{/if}
		</div>
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
		$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListPackage", order, 
		function(html){
			vietiso_loading(0);
			location.href = REQUEST_URI;
		});
	}
});
</script>
{/literal}