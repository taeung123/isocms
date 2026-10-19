<div class="page-tour_setting page_container">
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_tour_exhautive_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('tourgroup')}</h2>
					{if $_LANG_ID eq 'en'}
						<p>This function is intended to manage group tour list in isoCMS system</p>
					{else}
						<p>Chức năng quản lý danh sách thị trường tour trong hệ thống isoCMS</p>
					{/if}
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew btnCreateTourGroup" href="javascript:void(0);" title="{$core->get_Lang('Add new')}">{$core->get_Lang('Add new')}</a>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="TourGroup" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
				</form>	
				<div class="record_per_page">
					<label>{$core->get_Lang('Record/page')}</label>
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl|default:'')}
				</div>
			</div>
			
			<div class="hastable">
				<table cellspacing="0" class="tbl-grid full-width table-striped table_responsive" width="100%">
					<thead>
						<tr>
							<th class="gridheader" style="width:40px"></th>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
							<th class="gridheader name_responsive" style="text-align:left;padding-left:15px!important">
								<strong>{$core->get_Lang('No.')} - {$core->get_Lang('title')}</strong>
							</th>
							<th class="gridheader hiden_responsive" style="text-align:left; width:150px"><strong>{$core->get_Lang('listtours')}</strong></th>
							<th class="gridheader hiden_responsive" style="width:100px"><strong>{$core->get_Lang('Public')}</strong></th>
							<th class="gridheader hiden_responsive" style="width:150px;"><strong>{$core->get_Lang('update')}</strong></th>
							<th class="gridheader hiden_responsive" width="60px"><strong>{$core->get_Lang('action')}</strong></th>
						</tr>
					</thead>
					{if !empty($allItem)}
					<tbody id="SortAble" class="sortByTd">
						{section name=i loop=$allItem}
						<tr id="order_{$allItem[i].tour_group_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
							<td class="sortable">
								<i class="fa fa-arrows" aria-hidden="true"></i>
							</td>
							<th class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].tour_group_id}" /></th>
							<td class="name_service">
								<strong style="font-size:14px;">
									{$smarty.section.i.index+1} - 
									{$clsClassTable->getTitle($allItem[i].tour_group_id)}
								</strong>
								{if $allItem[i].is_trash eq '1'}
								<span class="fr color_r">{$core->get_Lang('Is Trash')}</span>	
								{/if}
							</td>
							<td class="block_responsive" data-title="{$core->get_Lang('listtours')}"><a href="{$PCMS_URL}/index.php?mod={$mod}&tour_group_id={$allItem[i].tour_group_id}" title="Danh sách Tour"><img src="{$URL_IMAGES}/v2/zoom_last.png" align="absmiddle" /> {$core->get_Lang('listtours')}</a></td>
							<td class="block_responsive" style="text-align:center" data-title="{$core->get_Lang('Public')}">
								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourGroup" pkey="{$pkeyTable}" sourse_id="{$allItem[i].tour_group_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].tour_group_id)}" title="{$core->get_Lang('Click to change status')}">
									{if $clsClassTable->getOneField('is_online',$allItem[i].tour_group_id) eq '1'}
									<i class="fa-solid fa-circle-check green"></i>
									{else}
									<i class="fa-solid fa-circle-minus red"></i>
									{/if}
								</a>
							</td>
							<td class="block_responsive" style="text-align:left" data-title="{$core->get_Lang('update')}">{$clsClassTable->getOneField('upd_date',$allItem[i].tour_group_id)|date_format:"%m-%d-%Y %H:%M"}</td>
							<td class="block_responsive" align="center" style="text-align:center; white-space:nowrap">
								<div class="btn-group">
									<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										{if $allItem[i].is_trash eq '1'}
											<li>
												<a class="dropdown-item confirm_delete" 
												title="{$core->get_Lang('restore')}" 
												href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&tour_group_id={$core->encryptID($allItem[i].tour_group_id)}">
													<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
												</a>
											</li>
											<li>
												<a class="dropdown-item confirm_delete" 
												title="{$core->get_Lang('delete')}" 
												href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tour_group_id={$core->encryptID($allItem[i].tour_group_id)}">
													<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
												</a>
											</li>
										{else}
											<li>
												<a class="dropdown-item btn_edit_tourgroup" 
												title="{$core->get_Lang('edit')}" 
												data="{$allItem[i].tour_group_id}" href="#">
													<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
												</a>
											</li>
											<li>
												<a class="dropdown-item" 
												title="{$core->get_Lang('trash')}" 
												href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&tour_group_id={$core->encryptID($allItem[i].tour_group_id)}">
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
					{/if}
				</table>  
				<div class="clearfix" style="height:5px"></div>
				{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
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
		items: 'tr',
		handle: 'td.sortable',
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