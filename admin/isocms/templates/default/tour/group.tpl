<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tour')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('tourgroup')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('tourgroup')} <a class="btn btn-success btnCreateTourGroup" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('System management group tours')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="forums" method="post" class="filterForm" action="">
		<div class="ilterbox">
			<div class="wrap">
				<div class="searchbox">
					<input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					<a class="btn btn-success" href="javascript:void();" id="searchbtn" style=" padding:5px">
						<i class="icon-search icon-white"></i>
					</a>
				</div>
				<div class="group_buttons fr">
					<a href="{$link_page_current_2}" class="btn btn-warning"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
					<a href="{$link_page_current_2}&type_list=Trash" class="btn btn-danger"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span></a>
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="TourGroup" style="display:none">
						<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
					</a>
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
		<input id="list_selected_chkitem" style="display:none" value="0" />
    </form>
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
				</td>
			</tr>
		</table>
	</div>
    <div class="hastable">
		<table cellspacing="0" class="tbl-grid" width="100%">
			<tr>
				<td class="gridheader"><input id="check_all" type="checkbox" /></td>
				<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('listtours')}</strong></td>
				<td class="gridheader" style="width:6%"><strong>Public</strong></td>
				<td class="gridheader" style="width:12%"><strong></strong></td>
				<td class="gridheader" style="width:6%; text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
			</tr>
			{if $allItem[0].tour_group_id ne ''}
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].tour_group_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].tour_group_id}" /></td>
					<td class="index"> {$smarty.section.i.index+1}</td>
					<td><strong style="font-size:14px;">{$clsClassTable->getTitle($allItem[i].tour_group_id)}</strong>
					{if $allItem[i].is_trash eq '1'}
					<span class="fr color_r">{$core->get_Lang('Is Trash')}</span>	
					{/if}
					</td>
					<td><a href="{$PCMS_URL}/index.php?mod={$mod}&tour_group_id={$allItem[i].tour_group_id}" title="Danh sách Tour"><img src="{$URL_IMAGES}/v2/zoom_last.png" align="absmiddle" /> {$core->get_Lang('listtours')}</a></td>
					<td style="text-align:center">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourGroup" pkey="{$pkeyTable}" sourse_id="{$allItem[i].tour_group_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].tour_group_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].tour_group_id) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td style="text-align:right">{$clsClassTable->getOneField('upd_date',$allItem[i].tour_group_id)|date_format:"%m-%d-%Y %H:%M"}</td>
					<td align="center" style="text-align:center; white-space:nowrap">
						<div class="btn-group fr">
							<button class="btn iso-button-standard dropdown-toggle"
									type="button"
									data-bs-toggle="dropdown"
									aria-expanded="false">
								<i class="icon-cog"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '1'}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('restore')}"
									href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&tour_group_id={$core->encryptID($allItem[i].tour_group_id)}">
										<i class="icon-refresh"></i>
										{$core->get_Lang('restore')}
									</a>
								</li>

								<li>
									<a class="dropdown-item confirm_delete"
									title="{$core->get_Lang('delete')}"
									href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tour_group_id={$core->encryptID($allItem[i].tour_group_id)}">
										<i class="icon-remove"></i>
										{$core->get_Lang('delete')}
									</a>
								</li>

								{else}

								<li>
									<a class="dropdown-item btn_edit_tourgroup"
									title="{$core->get_Lang('edit')}"
									href="javascript:void(0)"
									data-id="{$allItem[i].tour_group_id}">
										<i class="icon-edit"></i>
										{$core->get_Lang('edit')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('trash')}"
									href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&tour_group_id={$core->encryptID($allItem[i].tour_group_id)}">
										<i class="icon-trash"></i>
										{$core->get_Lang('trash')}
									</a>
								</li>

								{/if}
							</ul>
						</div>
					</td>
				</tr>
				{/section}
			</tbody>
			{/if}
		</table>  
		<div class="clearfix" style="height:5px"></div>
		{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
	</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', '.btnCreateTourGroup', function(ev){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxFrmTourGroup',
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('52%', 'auto', html, 'box_TourGroup');
				$('#box_TourGroup').css('top','50px');
				var $editorID = $('.textarea_tour_intro_editor').attr('id');
				$('#'+$editorID).isoTextAreaFix();
			}
		});
		return false;
	});
	$(document).on('click', '.btn_edit_tourgroup', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxFrmTourGroup',
			data : {'tour_group_id' : $_this.attr('data')},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('52%', 'auto', html, 'box_TourGroup');
				$('#box_TourGroup').css('top','50px');
				var $editorID = $('.textarea_tour_intro_editor').attr('id');
				$('#'+$editorID).isoTextAreaFix();
			}
		});
		return false;
	});
	$(document).on('click', '.ClickSubmitGroup', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $title = $_form.find('input[name=title]');
		var $editorID = $('.textarea_tour_intro_editor').attr('id');
		var $intro = tinyMCE.get($editorID).getContent();
		var $image = $('#isoman_url_image').val();
		var $image_banner = $('#isoman_url_image_banner').val();
		
		if($title.val()==''){
			$title.focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title' 		: 	$title.val(),
			'intro'	  		: 	$intro,
			'image'	  		: 	$image,
			'banner'	  		: 	$image_banner,
			'tour_group_id' 	: 	$_this.attr('tour_group_id')
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSubmitTourGroup',
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
	});
	$(document).on('click', '.btn-delete-all', function(ev){ 
		var $_this = $(this);
		var $listID = getCheckBoxValueByClass('chkitem');
		var $clsTable = $_this.attr('clsTable');
		if($listID==''){   
			alertify.error(confirm_delete);  
			return false;
		}
		else{   
			if(confirm(confirm_delete)){    
				vietiso_loading(1);
				$.ajax({     
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajDeleteMultiItem',
					data: {
						"listID":$listID.join('|'),
						"clsTable":$clsTable
					},
					dataType: "html",
					success: function(html){
						window.location.reload();
					}    
				});
			}
			return false;  
		}  
		return false; 
	});
});
</script>
{/literal}
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
			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTourGroup", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});	
</script>
{/literal}