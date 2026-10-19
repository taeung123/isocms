<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('tagscloud')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('tagscloud')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>Chức năng quản lý danh sách các tags cloud trong hệ thống isoCMS</p>
			<p>{$core->get_Lang('This function is intended to manage tags cloud in isoCMS system')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew btnCreateTags" title="{$core->get_Lang('Add tag')}">{$core->get_Lang('Add tag')}</a>
		</div>
    </div>
<div class="container-fluid">
	<div class="wrap">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="form-group form-button hidden">
					<button type="button" class="btn btn-export" id="btn_export">Export</button>
				</div>
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="Tag" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
                <div class="fr group_buttons">
                    <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew">
                        <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span>
                    </a>
                    <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger btnNew">
                        <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span>
                    </a>
                </div>
			</form>	
		</div>
		<div class="clearfix"></div>
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
	</div>
    
    <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
        <thead>
            <tr>
				<th class="gridheader" style="width:40px"><input id="check_all" class="el-checkbox" type="checkbox" /></th>
				<th class="gridheader name_responsive3" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
				<th class="gridheader"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
        </thead>
        <tbody id="SortAble">
			{section name=i loop=$allItem}
			<tr style="cursor:move" id="order_{$allItem[i].tag_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<td class="indexcheck_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].tag_id}" /></td>
				<td class="name_responsive" style="padding-left: 8px !important"><strong class="title">{$clsClassTable->getTitle($allItem[i].tag_id)}</strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">[In Trash]</span>{/if}
				</td>
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '0'}
								<li>
									<a class="btnedit_tag dropdown-item" title="{$core->get_Lang('Edit')}" data="{$allItem[i].tag_id}">
										<i class="icon-edit"></i> {$core->get_Lang('Edit')}
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('Trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&tag_id={$core->encryptID($allItem[i].tag_id)}{$pUrl|default:''}" class="dropdown-item">
										<i class="icon-trash"></i> {$core->get_Lang('Trash')}
									</a>
								</li>
							{else}
								<li>
									<a title="{$core->get_Lang('Refresh')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&tag_id={$core->encryptID($allItem[i].tag_id)}{$pUrl|default:''}" class="dropdown-item">
										<i class="icon-refresh"></i> {$core->get_Lang('Refresh')}
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('Delete')}" class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=delete&tag_id={$core->encryptID($allItem[i].tag_id)}{$pUrl|default:''}">
										<i class="icon-remove"></i> {$core->get_Lang('Delete')}
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
	var $is_set= `{$is_set|default:''}`;
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
	var $listcatID  = '';
</script>
{literal}
<script type="text/javascript">
$(function(){
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
			$.post(path_ajax_script+"/index.php?mod=tags&act=ajUpdPosSortTag", order,

			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
	$(document).on('click', '.btnCreateTags', function(ev){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTags',
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('24%', 'auto', html, 'pop_Tags');
			}
		});
		return false;
	});
	$(document).on('click', '.btnedit_tag', function(ev){
		var $_this = $(this);
		var $tag_id = $_this.attr('data');
		/**/
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTags',
			data : {'tag_id' : $tag_id},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('24%', 'auto', html, 'pop_Tags');
			}
		});
		return false;
	});
	$(document).on('click', '.ClickSubmitTags', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $title = $_form.find('input[name=title]');
		if($title.val()==''){
			$title.focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title' 		: 	$title.val(),
			'tag_id' 		: 	$_this.attr('tag_id')
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSubmitTags',
			data:adata,
			dataType:'html',
			success:function(html){
				if(html.indexOf('_SUCCESS') >= 0){
					window.location.reload(true);
				}
				if(html.indexOf('_ERROR') >= 0){
					alertify.error(insert_error);
				}
				if(html.indexOf('_EXIST') >= 0){
					alertify.error(insert_error_exist);
				}
				vietiso_loading(0);
			}
		});
		return false;
	});
});
</script>
{/literal}