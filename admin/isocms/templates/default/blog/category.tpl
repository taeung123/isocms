<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}">{$core->get_Lang('Setting')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$mod}">{$core->get_Lang('blogcategory')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DeleteFailed'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
		<strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicalposts')}
	</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="page_container">

	<div class="filter_box" style="margin-bottom:15px">
		<a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-default">{$core->get_Lang('General settings')}</a>
		<a href="{$PCMS_URL}/?mod={$mod}&act=category" class="btn btn-main">{$core->get_Lang('Category')}</a>
	</div>
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('blogcategory')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('blogcategory')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('systemmanagementblogcategory')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew btnCreateCategoryBlog" title="{$core->get_Lang('Add')} {$core->get_Lang('blogcategory')}">{$core->get_Lang('Add')} {$core->get_Lang('blogcategory')}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="BlogCategory" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/index.php?mod=blog" class="btn btn-warning btnNew">
						<i class="icon-list icon-white"></i> <span>{$core->get_Lang('list blog')}</span>
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}&act={$act}" class="btn btn-warning btnNew" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
					<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&type_list=Trash" class="btn btn-danger btnNew" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
				</div>  
			</form>	
		</div>
		
		<div class="wrap">
			<div class="hastable">
				<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
					<thead>
						<tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
							<th class="gridheader hiden767">{$core->get_Lang('index')}</th>
							<th class="gridheader name_responsive" style="text-align:left">{$core->get_Lang('title')}</th>
							<th class="gridheader hiden767" style="text-align:left">{$core->get_Lang('List Blog')}</th>
							<th class="gridheader hiden767" style="text-align:right">{$core->get_Lang('update')}</th>
							<th class="gridheader hiden767" style="text-align:center">{$core->get_Lang('status')}</th>
							<th class="gridheader hiden767">{$core->get_Lang('func')}</th>
						</tr>
					</thead>
					{if $allItem[0].blogcat_id ne ''}
					<tbody id="SortAble">
				   {section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].blogcat_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<td class="index has-checkbox"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].blogcat_id}" /></td>
						<td class="index hiden767"> {$smarty.section.i.index+1}</td>
						<td class="name_service">
							<a class="title btnEditBlogCat" data="{$allItem[i].blogcat_id}" href="javascript:void(0);" title="{$clsClassTable->getTitle($allItem[i].blogcat_id)}">{$clsClassTable->getTitle($allItem[i].blogcat_id)}</a>
							{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
							<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
						</td>
						<td class="block_responsive" data-title="{$core->get_Lang('List Blog')}"><a href="{$PCMS_URL}/?mod=blog&blogcat_id={$allItem[i].blogcat_id}">
								<i class="fa fa-folder-open"></i> {$core->get_Lang('listofarticles')} <strong style="color:#c00000;">({$clsClassTable->countItemInCat($allItem[i].blogcat_id)})</strong></a>
						</td>
						<td class="block_responsive" data-title="{$core->get_Lang('update')}" style="text-align:right">{$clsClassTable->getOneField('upd_date',$allItem[i].blogcat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
						<td class="block_responsive" data-title="{$core->get_Lang('status')}" style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="BlogCategory" pkey="blogcat_id" sourse_id="{$allItem[i].blogcat_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].blogcat_id)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_online',$allItem[i].blogcat_id) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td class="block_responsive" data-title="{$core->get_Lang('func')}" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="dropdown">
								<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>

								<ul class="dropdown-menu dropdown-menu-end">
									{if $allItem[i].is_trash eq '0'}

									<li>
										<a class="dropdown-item"
										href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].blogcat_id)}"
										target="_blank"
										title="{$core->get_Lang('view')}">
											<i class="icon-eye-open"></i> {$core->get_Lang('view')}
										</a>
									</li>

									<li>
										<a class="dropdown-item btnEditBlogCat"
										href="javascript:void(0);"
										title="{$core->get_Lang('edit')}"
										data="{$allItem[i].blogcat_id}">
											<i class="icon-edit"></i> {$core->get_Lang('edit')}
										</a>
									</li>

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('trash')}"
										href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&blogcat_id={$core->encryptID($allItem[i].blogcat_id)}">
											<i class="icon-trash"></i> {$core->get_Lang('Trash')}
										</a>
									</li>

									{else}

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('restore')}"
										href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&blogcat_id={$core->encryptID($allItem[i].blogcat_id)}">
											<i class="icon-refresh"></i> {$core->get_Lang('restore')}
										</a>
									</li>

									<li>
										<a class="dropdown-item confirm_delete"
										title="{$core->get_Lang('delete')}"
										href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&blogcat_id={$core->encryptID($allItem[i].blogcat_id)}">
											<i class="icon-remove"></i> {$core->get_Lang('delete')}
										</a>
									</li>

									{/if}
								</ul>
							</div>
						</td>
					</tr>
					{/section}
					{/if}
				</table>  
				<div class="clearfix" style="height:5px"></div>
				<div class="pagination_box">
					<div class="wrap holderEvent_tbl" id="dataTable_paginate"> 
						<!-- Ajax Loading pagination --> 
					</div>
				</div> 
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var $SiteHasCat_Blogs = "{$clsConfiguration->getValue('SiteHasCat_Blogs')}";
</script>
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
			$.post(path_ajax_script+"/index.php?mod=blog&act=ajUpdPosSortBlogCategory", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = `${path_ajax_script}/index.php?mod=${mod}&act=${act}`;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/blog/jquery.blog.js?v={$upd_version}"></script>
