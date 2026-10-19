<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>{$core->get_Lang('slide')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách {$core->get_Lang('slide')} trong hệ thống isoCMS">i</div></h2>
			<p>Chức năng quản lý danh sách các Slide trong hệ thống isoCMS</p>
			<p>This function is intended to manage Slide in isoCMS system</p>			
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_slide" title="{$core->get_Lang('Add')} {$core->get_Lang('service')}">{$core->get_Lang('Add')} {$core->get_Lang('slide')}</a>
		</div>
    </div>
	<div class="container-fluid">
     <div class="filter_box">
		<form id="forums" method="post" action="" name="filter" class="filterForm">
			<div class="form-group form-keyword">
				<input type="text" class="text form-control" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
			</div>
			<div class="form-group form-button">
				<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
				<input type="hidden" name="filter" value="filter">
			</div>				
			<div class="form-group form-button">
				<a class="btn btn-delete-all" id="btn_delete" clsTable="Slide" style="display:none">
					{$core->get_Lang('Delete')}
				</a>
			</div>
		</form>
		<div class="fr group_buttons">
			<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span></a>
			<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger btnNew" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
		</div>
	</div>
	{if $clsConfiguration->getValue('Video_Teaser_Home')}
	<div class="video_teaser mb30">
		<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
			<div class="row-span">
				<div class="fieldlabel bold"><strong>{$core->get_Lang('Video Teaser')}</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<input type="hidden" id="isoman_hidden_video" value="{$clsConfiguration->getValue('video_teaser_page')}">
					<input type="text" id="isoman_url_video" name="video_teaser_page" value="{$clsConfiguration->getValue('video_teaser_page')}" class="text_32 border_aaa" style="width:calc(100% - 110px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="video" isoman_val="{$clsConfiguration->getValue('video_teaser_page')}" isoman_name="video"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					<a class="submit-buttons">
						{$saveBtn}
						<input value="UpdateVideoConfiguration" name="submit" type="hidden">
					</a>
					<div class="clearfix"></div>
					<span style="display:block; margin-top:5px; font-size:12px">
					({$core->get_Lang('ex: file.mp4, file.ogg, file.m4v..., frame width: &gt;=1600px, frame height: &lt;=500px')})
					</span>
				</div>
			</div>
		</form>
	</div>
	{/if}
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
    <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
		<thead>
			<tr>
				<th class="gridheader" style="width:40px;"><input id="check_all" type="checkbox" /></th>
				<th class="gridheader hiden767"><strong>{$core->get_Lang('ID')}</strong></th>
				<th class="gridheader name_responsive text_left"><strong>{$core->get_Lang('Image')}</strong></th>
				<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('titleofarticle')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:6%"><strong>{$core->get_Lang('status')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:12%;" align="center"><strong>{$core->get_Lang('update')}</strong></th>
				<th class="gridheader hiden_responsive"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
		</thead>
		<tbody id="SortAble">
		   {section name=i loop=$allItem}
			<tr style="cursor:move" id="order_{$allItem[i].slide_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].slide_id}" /></th>
                <th class="index hiden767">{$allItem[i].slide_id}</th>
                <td class="name_service full_width_767" style=" text-align:center;width:250px">
                    <img src="{$allItem[i].image}" width="200px" height="80px" />
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
                </td>
                <td data-title="{$core->get_Lang('titleofarticle')}" class="block_responsive border_top_responsive">
                	<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].slide_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].slide_id)}</strong>
                	{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                </td>
                <td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="Slide" pkey="slide_id" sourse_id="{$allItem[i].slide_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].slide_id)}" title="{$core->get_Lang('Click to change status')}">
                        {if $clsClassTable->getOneField('is_online',$allItem[i].slide_id) eq '1'}
                        <i class="fa-solid fa-circle-check green"></i>
                        {else}
                        <i class="fa-solid fa-circle-minus red"></i>
                        {/if}
                    </a>
                </td>
                <td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:center">{$allItem[i].upd_date|date_format:"%d/%m/%Y %H:%M"}</td>
                <td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                    <div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '0'}
							<li>
								<a href="{$PCMS_URL}/slide/insert/{$allItem[i].slide_id}/overview" class="dropdown-item" title="{$core->get_Lang('edit')}">
									<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
								</a>
							</li>
							<li>
								<a href="{$PCMS_URL}/?mod={$mod}&act=trash&slide_id={$core->encryptID($allItem[i].slide_id)}{$pUrl}" class="dropdown-item" title="{$core->get_Lang('trash')}">
									<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
								</a>
							</li>
							{else}
							<li>
								<a href="{$PCMS_URL}/?mod={$mod}&act=restore&slide_id={$core->encryptID($allItem[i].slide_id)}{$pUrl}" class="dropdown-item" title="{$core->get_Lang('restore')}">
									<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
								</a>
							</li>
							<li>
								<a href="{$PCMS_URL}/?mod={$mod}&act=delete&slide_id={$core->encryptID($allItem[i].slide_id)}{$pUrl}" class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}">
									<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
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
	<div class="clearfix"></div>
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/slide/jquery.slide.new.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod=slide&act=ajUpdPosSortListSlide", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}