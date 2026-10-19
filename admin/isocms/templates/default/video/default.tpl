<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}{if $type eq '_CHILD_SLIDE'}&type=_CHILD_SLIDE{/if}" title="{$mod}">{$core->get_Lang('video')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
     <div class="page-title">
        <h2>
        	{$core->get_Lang('video')}
            <a href="{$PCMS_URL}/?mod={$mod}&act=edit{$pUrl}" class="btn btn-success" style="color:#fff;display:inline-block;margin-left:10px;"><i class="icon-plus icon-white"></i></a>
        </h2>
		<p>Chức năng quản lý danh sách các Video trong hệ thống isoCMS</p>
		<p>This function is intended to manage Video in isoCMS system</p>
    </div>
    <div class="clearfix"><br /></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
		<div class=" filterbox">
			<div class="wrap">
				<div class="searchbox fl">
					<input type="text" class="text fl mr5" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
					<a class="btn btn-success" href="javascript:void();" id="searchbtn">
						<i class="icon-search icon-white"></i>
					</a>    
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span></a>
					<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Video" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
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
				<th class="gridheader name_responsive text_left"><strong>{$core->get_Lang('Background video')}</strong></th>
				<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('Title Video')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:12%;" align="center"><strong>{$core->get_Lang('status')}</strong></th>
				<th class="gridheader hiden_responsive"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
		</thead>
		<tbody id="SortAble">
		   {section name=i loop=$allItem}
			<tr style="cursor:move" id="order_{$allItem[i].video_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].video_id}" /></th>
                <th class="index hiden767">{$allItem[i].video_id}</th>
                <td class="name_service full_width_767" style=" text-align:center;width:250px">
                    <img src="{$allItem[i].image}" width="200px" height="80px" />
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
                </td>
                <td data-title="{$core->get_Lang('titleofarticle')}" class="block_responsive border_top_responsive">
                	<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].video_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].video_id)}</strong>
                	{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                </td>
                <td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="Video" pkey="video_id" sourse_id="{$allItem[i].video_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].video_id)}" title="{$core->get_Lang('Click to change status')}">
                        {if $clsClassTable->getOneField('is_online',$allItem[i].video_id) eq '1'}
                        <i class="fa-solid fa-circle-check green"></i>
                        {else}
                        <i class="fa-solid fa-circle-minus red"></i>
                        {/if}
                    </a>
                </td>

                <td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                    <div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle"
								type="button"
								data-bs-toggle="dropdown"
								aria-expanded="false">
							<i class="fa fa-ellipsis-v"></i>
						</button>

						<ul class="dropdown-menu dropdown-menu-end">

							{if $allItem[i].is_trash eq '0'}

							<li>
								<a class="dropdown-item"
								title="{$core->get_Lang('edit')}"
								href="{$PCMS_URL}/?mod={$mod}&act=edit&video_id={$core->encryptID($allItem[i].video_id)}{if $clsTable}&clsTable={$clsTable}{/if}">
									<i class="fa fa-edit"></i>
									{$core->get_Lang('edit')}
								</a>
							</li>

							<li>
								<a class="dropdown-item"
								title="{$core->get_Lang('trash')}"
								href="{$PCMS_URL}/?mod={$mod}&act=trash&video_id={$core->encryptID($allItem[i].video_id)}{$pUrl}">
									<i class="fa fa-trash"></i>
									{$core->get_Lang('trash')}
								</a>
							</li>

							{else}

							<li>
								<a class="dropdown-item"
								title="{$core->get_Lang('restore')}"
								href="{$PCMS_URL}/?mod={$mod}&act=restore&video_id={$core->encryptID($allItem[i].video_id)}{$pUrl}">
									<i class="fa fa-undo"></i>
									{$core->get_Lang('restore')}
								</a>
							</li>

							<li>
								<a class="dropdown-item confirm_delete"
								title="{$core->get_Lang('delete')}"
								href="{$PCMS_URL}/?mod={$mod}&act=delete&video_id={$core->encryptID($allItem[i].video_id)}{$pUrl}">
									<i class="fa fa-times"></i>
									{$core->get_Lang('delete')}
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
			$.post(path_ajax_script+"/index.php?mod=video&act=ajUpdPosSortListVideo", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}