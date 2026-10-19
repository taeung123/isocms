<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tour')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}">{$core->get_Lang('Travel Styles')}</a>
	 <!-- Back-->
    <a href="javascript:window.history.back();" title="{$core->get_Lang('back')}" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
<div class="page-tour_setting page_container">
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_tour_exhautive_setting')}
		<div class="content_setting_box">
			<div class="page-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('Travel Style list')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Travel Style list')} trong hệ thống isoCMS">i</div>
					</h2>
					<p>{$core->get_Lang('Chức năng quản lý danh sách các Travel Styles phục vụ cho việc phân loại tour du lịch trong hệ thống isoCMS')}</p>
					<p>{$core->get_Lang('This function is intended to manage Travel Styles in isoCMS system')}</p>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew btnCreateToursCategory" title="{$core->get_Lang('Add')} {$core->get_Lang('Travel Style list')}">{$core->get_Lang('Add')} {$core->get_Lang('Travel Style list')}</a>
				</div>
			</div>
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					{if $clsConfiguration->getValue("SiteHasGroup_Tours")}
					<div class="form-group form-category">
						<select onchange="_reload()" name="tour_group_id" class="form-control">
							{$clsTourGroup->makeSelectboxOption($tour_group_id)}
						</select>
					</div>
					{/if}
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="TourCategory" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
				</form>	
				<div class="group_buttons fr">
					<a href="{$PCMS_URL}/index.php?mod=tour" class="btn btn-warning btnNew">
						<i class="icon-list icon-white"></i> <span>{$core->get_Lang('listtours')}</span>
					</a>
				</div>
			</div>
			<div class="record_per_page fr mb5">
				<label>{$core->get_Lang('Record/page')}</label>
				{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
			</div>
			<div class="hastable">
				<table cellspacing="0" class="tbl-grid" width="100%">
					<tr>
						<td class="gridheader"><input id="check_all" type="checkbox" /></td>
						<td class="gridheader"><strong>{$core->get_Lang('ID')}</strong></td>
						<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
						{if $clsConfiguration->getValue("SiteHasGroup_Tours")}
						<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('tourgroup')}</strong></td>
						{/if}
				{if $clsConfiguration->getValue('SiteHasTourCat_slide')}<td class="gridheader"></td>{/if}
						<td class="gridheader" style="width:55px"><strong>{$core->get_Lang('status')}</strong></td>
						<td class="gridheader" style="width:120px"><strong>{$core->get_Lang('update')}</strong></td>
						<td class="gridheader" style="width:74px; text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
					</tr>
					{if $allItem[0].tourcat_id ne ''}
					<tbody id="SortAble">
						{section name=i loop=$allItem}
						<tr style="cursor:move" id="order_{$allItem[i].tourcat_id}" class="{cycle values="row1,row2"}">
							<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].tourcat_id}" /></td>
							<td class="index"> {$allItem[i].tourcat_id}</td>
							<td><strong style="font-size:14px;">{$allItem[i].title}</strong>
								{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
							</td>
							{if $clsConfiguration->getValue("SiteHasGroup_Tours")}
							<td><a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&tour_group_id={$allItem[i].tour_group_id}"><img src="{$URL_IMAGES}/v2/node-select-child.png" align="absmiddle" /> {$clsTourGroup->getTitle($allItem[i].tour_group_id)}</a></td>
							{/if}
							{if $clsConfiguration->getValue('SiteHasTourCat_slide')}
							<td>
								<a href="{$PCMS_URL}/index.php?mod=slide&mod_page={$mod}&act_page={$act}&target_id={$allItem[i].tourcat_id}&clsTable=TourCategory" title="{$core->get_Lang('listslide')}">
								<i class="fa fa-folder-open"></i>  {$core->get_Lang('listslide')} <strong style="color:#c00000;">({$clsISO->countTotalSlide($mod,$act,$allItem[i].tourcat_id)})</strong>
								</a>
							</td>
							{/if}
							<td style="text-align:center">
								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourCategory" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
									{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
									<i class="fa-solid fa-circle-check green"></i>
									{else}
									<i class="fa-solid fa-circle-minus red"></i>
									{/if}
								</a>
							</td>
							<td style="text-align:center">{$clsClassTable->getOneField('upd_date',$allItem[i].tourcat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
							<td align="center" style="text-align:center;">
								<div class="btn-group">
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
												href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&tourcat_id={$core->encryptID($allItem[i].tourcat_id)}{$pUrl}">
													<i class="icon-refresh"></i>
													{$core->get_Lang('restore')}
												</a>
											</li>

											<li>
												<a class="dropdown-item confirm_delete"
												title="{$core->get_Lang('delete')}"
												href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tourcat_id={$core->encryptID($allItem[i].tourcat_id)}{$pUrl}">
													<i class="icon-remove"></i>
													{$core->get_Lang('delete')}
												</a>
											</li>
										{else}

											<li>
												<a class="dropdown-item btnEditToursCategory"
												title="{$core->get_Lang('edit')}"
												href="javascript:void(0)"
												data-id="{$allItem[i].tourcat_id}">
													<i class="icon-edit"></i>
													{$core->get_Lang('edit')}
												</a>
											</li>

											{if $allItem[i].tourcat_id ne 10 && $allItem[i].tourcat_id ne 20}
											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('trash')}"
												href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&tourcat_id={$core->encryptID($allItem[i].tourcat_id)}{$pUrl}">
													<i class="icon-trash"></i>
													{$core->get_Lang('trash')}
												</a>
											</li>
											{/if}

										{/if}
									</ul>
								</div>
							</td>
						</tr>
						{/section}
					</tbody>
					{/if}
				</table>  
				<div class="clearfix"></div>
				<div class="statistical mb5">
					<table width="100%" border="0" cellpadding="3" cellspacing="0">
						<tr>
							<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
							{if $totalPage gt '1'}
							<td width="50%" align="right">
								{$core->get_Lang('gotopage')}:
								<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
									{section name=i loop=$listPageNumber}
									<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
									{/section}
								</select>

							</td>
							{/if}
						</tr>
					</table>
				</div>
			</div>
			{*<div class="wrap mt20">
				<form method="post" action="" enctype="multipart/form-data">
					<div class="page-title bold">{$core->get_Lang('OnPage description')}</div>
					<table class="form" cellpadding="3" cellspacing="3">
						{if $_DEV}
						<tr>
							<td class="fieldlabel" style="width:40px">{$core->get_Lang('link')}</td>
							<td class="fieldarea">
								{assign var=site_tours_link value=site_tours_link_|cat:$_LANG_ID}
								<input class="text full required" name="iso-{$site_tours_link}" value="{$clsConfiguration->getValue($site_tours_link)}" maxlength="255" type="text" />
							</td>
						</tr>
						{/if}
						<tr>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td class="fieldarea" colspan="2">
								{assign var=site_tour_intro value=site_tour_intro_|cat:$_LANG_ID}
								<textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_tour_intro}" style="width:100%">{$clsConfiguration->getValue($site_tour_intro)}</textarea>
							</td>
						</tr>
					</table>
					<div class="clearfix mt10"></div>
					<fieldset class="submit-buttons">
						{$saveBtn}
						<input value="UpdateConfiguration" name="submit" type="hidden">
					</fieldset>
				</form>
			</div>*}
		</div>
	</div>
</div>
<script type="text/javascript">
	var $SiteHasGroup_Tours = '{$clsConfiguration->getValue("SiteHasGroup_Tours")}';
	var $SiteHasSubCat_Tours = '{$clsConfiguration->getValue("SiteHasSubCat_Tours")}';
	var $tour_group_id = '{$tour_group_id}';
</script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', '.btnCreateToursCategory', function(ev){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteTourCategory',
			data : {'tour_group_id' : $tour_group_id, 'tp' : 'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('55%', 'auto', html, 'box_TourCategory');
				$('#box_TourCategory').css('top','50px');
				var $editorID = $('.textarea_tour_intro_editor').attr('id');
				var $editorbannerID = $('.textarea_tour_intro_banner_editor').attr('id');
				$('#'+$editorID).isoTextAreaFix();
				$('#'+$editorbannerID).isoTextAreaFix();
			}
		});
		return false;
	});
	$(document).on('click', '.btnEditToursCategory', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteTourCategory',
			data : {'tourcat_id' : $_this.attr('data'), 'tp' : 'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('55%', 'auto', html, 'box_TourCategory');
				$('#box_TourCategory').css('top','50px');
				var $editorID = $('.textarea_tour_intro_editor').attr('id');
				var $editorbannerID = $('.textarea_tour_intro_banner_editor').attr('id');
				$('#'+$editorID).isoTextAreaFix();
				$('#'+$editorbannerID).isoTextAreaFix();
			}
		});
		return false;
	});
	$(document).on('click', '.btnClickToSubmitCategory', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $title = $_form.find('input[name=title]');
		var $editorID = $('.textarea_tour_intro_editor').attr('id');
		var $editorbannerID = $('.textarea_tour_intro_banner_editor').attr('id');
		
		var $image = $('#isoman_url_image').val();
		var $image_banner = $('#isoman_url_image_banner').val();
		var $video_teaser = $('#isoman_url_video_teaser').val();
		var $background = $('input[name=iso-background]').val();
		var $link_banner = $('input[name=iso-link_banner]').val();
		
		if($title.val()==''){
			$title.addClass('error').focus();
			alertify.error(field_is_required);
			return false;
		}
		$tour_group_id = 0;
		if($SiteHasGroup_Tours){
			var $slb_TourGroup = $('#slb_TourGroup');
			if(parseInt($slb_TourGroup.val())==0){
				$slb_TourGroup.focus();
				setSelectOpen($slb_TourGroup);
				alertify.error(field_is_required);
				return false;
			}
			$tour_group_id = $slb_TourGroup.val();
		}
		var $parent_ID = 0;
		if($SiteHasSubCat_Tours){
			var $slb_TourCategory = $('#slb_TourCategory');
			$parent_ID = $('#slb_TourCategory').val();
		}
		
		var intro = tinyMCE.get($editorID).getContent();

		var _async = true;
		let frag = document.createElement('div');
		frag.innerHTML = intro;
		let itemsBase64 = [...frag.querySelectorAll('img')]
	  .filter(img => img.getAttribute('src').startsWith('data'))
	  .map(img => img.getAttribute('src'));
		console.log(itemsBase64);
		if(itemsBase64.length){
			_async = false;
			$.ajax({
				type: "POST",
				url: PCMS_URL + '/index.php?mod=ajax&act=convertBase64toImage',
				data: {
					intro : intro
				},
				async:false,
				dataType : 'json',
				success: function (res) {
					intro = res.intro;
				}
			});
		}
		console.log(intro);

		var adata = {
			'title' 		: 	$title.val(),
			'intro'	  		: 	intro,
			'link_banner'	  		: 	$link_banner,
			'background'	  		: 	$background,
			'image'	  		: 	$image,
			'image_banner'	: 	$image_banner,
			'video_teaser'	: 	$video_teaser,
			'parent_id'		: 	$parent_ID,
			'tour_group_id'	: 	$tour_group_id,
			'tourcat_id' 	: 	$_this.attr('tourcat_id'),
			'tp' 			: 	'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteTourCategory',
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
});
</script>
{/literal}
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
			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTourCategory", order, 
			
			function(html){
				vietiso_loading(0);
			});
		}
	});
</script>
{/literal}