<div class="breadcrumb">
    <strong>{$_ADMINLANG.youarehere}:</strong>
    <a href="{$PCMS_URL}" title="{$_ADMINLANG.home}">{$_ADMINLANG.home}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$_ADMINLANG.popup}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$_ADMINLANG.back}</a>
</div>
<div class="container-fluid">
     <div class="page-title">
        <h2>{$core->get_Lang('Popup Management')}<a href="{$PCMS_URL}/?mod={$mod}&act=edit{$pUrl}" class="btn btn-success" style="color:#fff;display:inline-block;margin-left:10px;"><i class="icon-plus icon-white"></i></a></h2>
    </div>
    <div class="clearfix"><br /></div>							
    <form id="forums" method="post" action="" name="filter" class="filterForm">
        <div class="ui-action">
            <div class="fl fiterbox" style="width:100%">
                <div class="wrap">
                    <div class="searchbox fl">
                        <input type="text" class="text fl mr5" name="keyword" value="{$keyword}" placeholder="Tìm kiếm..." />
                        <a class="btn btn-success" href="javascript:void();" id="searchbtn">
                            <i class="icon-search icon-white"></i>
                        </a>    
                    </div>
                    <div style="float:right;">
                        <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning">
							<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span>
						</a>
                        <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger">
							<i class="icon-warning-sign icon-white"></i>
							<span>{$core->get_Lang('trash')} ({$number_trash})</span>
						</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Popup" style="display:none">
							<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
						</a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
        <tr>
            <td class="gridheader"><input id="check_all" type="checkbox" /></td>
            <td class="gridheader"><strong>{$core->get_Lang('Image')}</strong></td>
            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Popup Title')}</strong></td>
            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Popup Link')}</strong></td>
           	<td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
            <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
        </tr>
		<tbody id="SortAble">
        {section name=i loop=$allItem}
            <tr style="cursor:move" id="order_{$allItem[i].popup_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].popup_id}" /></td>
                <td style=" text-align:center; width:200px">
                    <img src="{if $allItem[i].image eq ''}{$allItem[i].data_image}{else}{$clsClassTable->getImage($allItem[i].popup_id,200,80)}{/if}" width="200px" height="80px" />
                </td>
                <td><strong class="title"><a target="_blank" href="{$DOMAIN_NAME}/{$allItem[i].link}">{$clsClassTable->getTitle($allItem[i].popup_id)}</a></strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
				</td>
                <td><a target="_blank" href="{$clsClassTable->getLinkPopup($allItem[i].popup_id)}">{$clsClassTable->getLinkPopup($allItem[i].popup_id)}</a></td>
				<td style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Popup" pkey="popup_id" sourse_id="{$allItem[i].popup_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].popup_id)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].popup_id) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
                <td style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '1'}
							<li>
								<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&popup_id={$core->encryptID($allItem[i].popup_id)}&mod_page={$mod_page}">
									<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&popup_id={$core->encryptID($allItem[i].popup_id)}{if $mod_page ne ''}&mod_page={$mod_page}{/if}">
									<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
								</a>
							</li>
							{else}
							<li>
								<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&popup_id={$core->encryptID($allItem[i].popup_id)}">
									<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&popup_id={$core->encryptID($allItem[i].popup_id)}&mod_page={$mod_page}">
									<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
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
			$.post(path_ajax_script+"/index.php?mod=popup&act=ajUpdPosSortPopup", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}