<div class="page-tour_setting page_container">

	{$core->getBlock('header_title_tour_setting')}

	<div class="container-fluid container-fluid-2 d-flex">

		{$core->getBlock('menu_tour_exhautive_setting')}

		<div class="content_setting_box">	

			<div class="page_detail-title d-flex">

				<div class="title">

					<h2>{$core->get_Lang('Travel Style list')} </h2>

					<p>{$core->get_Lang("This function is intended to manage in isoCMS system")} Travel Styles</p>

				</div>

				<div class="button_right">

					<a class="btn btn-main btn-addnew btnCreateToursCategory"
					   href="javascript:void(0);"
					   data-tour-group-id="{$tour_group_id|default:0}"
					   title="{$core->get_Lang('Add new')}">{$core->get_Lang('Add new')}</a>

				</div>

			</div>

			<div class="clearfix"></div>			

			<div class="filter_box">

				<form id="forums" method="post" class="filterForm" action="">

						<div class="form-group form-keyword">

							<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}">

						</div>

						{*{if $SiteHasGroup_Tours}

							<div class="form-group">

								<select class="slb form-control" data-width="100%"  onchange="_reload()" name="tour_group_id">

								{$clsTourGroup->makeSelectboxOption($tour_group_id)}

								</select>

							</div>

						{/if}*}

						<div class="form-group form-button">

							<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>

							<input type="hidden" name="filter" value="filter">

						</div>

						<div class="form-group form-button">

							<a class="btn btn-delete-all " id="btn_delete" clstable="TourCategory" style="display: none;">

								{$core->get_Lang('Delete')}

							</a>

						</div>

				</form>

				<div class="group_buttons fr">

					<a href="{$PCMS_URL}/index.php?mod=tour_exhautive" class="btn btn-warning btnNew">

						<i class="icon-list icon-white"></i> <span>{$core->get_Lang('List Tour')}</span>

					</a>

				</div>

			</div>

			

			<div class="clearfix"></div>

			<div class="statistical mb5">

				<table width="100%" border="0" cellpadding="3" cellspacing="0">

					<tr>

						<td width="50%" align="left">&nbsp;</td>

						<td width="50%" align="right">

							{$core->get_Lang('Record/page')}:

							<select name="recordperpage" onchange="window.location = this.options[this.selectedIndex].value">

								<option {if $recordPerPage eq '20'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=20">20</option>

								{if $totalRecord gt 20}

								<option {if $recordPerPage eq '50'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=50">50</option>

								{/if}

								{if $totalRecord gt 50}

								<option {if $recordPerPage eq '100'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=100">100</option>

								{/if}

								{if $totalRecord gt 100}

								<option {if $recordPerPage eq '200'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=200">200</option>

								{/if}

								{if $totalRecord gt 200}

								<option {if $recordPerPage eq '{$totalRecord}'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage={$totalRecord}">{$core->get_Lang('All')}</option>

								{/if}

							</select>

						</td>

					</tr>

				</table>

			</div>

			<div class="hastable">

				<table cellspacing="0" class="table table-striped tbl-grid table_responsive" width="100%">

                   <thead>

						<tr>

							<th class="gridheader hiden767" style="width:40px"></th>

							<th class="gridheader" style="width:40px">

								<input id="check_all" type="checkbox" class="el-checkbox" style="cursor: pointer" />

							</th>

							<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>

							<th class="gridheader hiden_responsive"><strong>{$core->get_Lang('status')}</strong></th>

							<th class="gridheader text-left hiden_responsive" width="200px"><strong>{$core->get_Lang('update')}</strong></th>

							<th class="gridheader text-center hiden_responsive" width="74px"></th>

						</tr>

					</thead>

					{if !empty($allItem) && $allItem[0].tourcat_id ne ''}

					<tbody id="SortAble" class="sortByTd">

						{foreach $allItem as $item}

						<tr id="order_{$item.tourcat_id}">

							<td class="index hiden767 sortable">

								<i class="fa fa-arrows" aria-hidden="true"></i>

							</td>

							<td class="check_40 has-checkbox text-center">

								<input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$item.tourcat_id}" style="cursor: pointer" />

							</td>

							<td class="text-left name_service">

								<b><span class="title">{$item.tourcat_id}</span> - {$item.title}</b>

								{if $item.is_trash eq '1'}

									<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>

								{/if}

							</td>

							<td style="text-align:center">

								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourCategory" pkey="{$pkeyTable}" sourse_id="{$item[$pkeyTable]}" rel="{$clsClassTable->getOneField('is_online',$item[$pkeyTable])}" title="{$core->get_Lang('Click to change status')}">

									{if $clsClassTable->getOneField('is_online',$item[$pkeyTable]) eq '1'}

										<i class="fa-solid fa-circle-check green"></i>

									{else}

										<i class="fa-solid fa-circle-minus red"></i>

									{/if}

								</a>

							</td>

							<td class="block_responsive" data-title="{$core->get_Lang('update')}">

								{assign var=updDate value=$clsClassTable->getOneField('upd_date', $item.tourcat_id)}

								{if !empty($updDate)}

									{$updDate|date_format:"%m-%d-%Y %H:%M"}

								{else}

									N/A

								{/if}

							</td>

							<td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">

								<div class="btn-group">

									<div class="dropdown">

										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

										</button>

										<ul class="dropdown-menu dropdown-menu-end">

											{if $item.is_trash eq '1'}

												<li>

													<a class="dropdown-item" title="{$core->get_Lang('restore')}"

														href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&tourcat_id={$core->encryptID($item.tourcat_id)}{$pUrl}">

														<i class="icon-refresh"></i> {$core->get_Lang('restore')}

													</a>

												</li>

												<li>

													<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}"

														href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tourcat_id={$core->encryptID($item.tourcat_id)}{$pUrl}">

														<i class="icon-remove"></i> {$core->get_Lang('delete')}

													</a>

												</li>

											{else}

												<li>

													<a class="dropdown-item btnEditToursCategory" title="{$core->get_Lang('edit')}" 

														href="javascript:void(0)" data="{$item.tourcat_id}">

														<i class="icon-edit"></i> {$core->get_Lang('edit')}

													</a>

												</li>

												{if $item.tourcat_id ne 10 && $item.tourcat_id ne 20}

													<li>

														<a class="dropdown-item" title="{$core->get_Lang('trash')}"

															href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&tourcat_id={$core->encryptID($item.tourcat_id)}{$pUrl}">

															<i class="icon-trash"></i> {$core->get_Lang('trash')}

														</a>

													</li>

												{/if}

											{/if}

										</ul>

									</div>

								</div>

							</td>

						</tr>

						{/foreach}

					</tbody>

				{/if}



				</table>  

				<div class="clearfix"></div>
				{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
				

			</div>



		</div>

	</div>

</div>

<script type="text/javascript">

		var $SiteHasGroup_Tours = parseInt(
			'{$clsConfiguration->getValue("SiteHasGroup_Tours")}',
			10
		) || 0;

		var $SiteHasSubCat_Tours = parseInt(
			'{$clsConfiguration->getValue("SiteHasSubCat_Tours")}',
			10
		) || 0;

	</script>

{literal}

<script type="text/javascript">

$(document).ready(function(){

	$(document)
		.off('click.siteTourCategoryCreate', '.btnCreateToursCategory')
		.on('click.siteTourCategoryCreate', '.btnCreateToursCategory', function(ev){
		ev.preventDefault();
		ev.stopImmediatePropagation();
		var $_this = $(this);
		var tourGroupId = parseInt(
			$_this.attr('data-tour-group-id'),
			10
		) || 0;

		vietiso_loading(1);

		$.ajax({

			type:'POST',

			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteTourCategory',

			data : {'tour_group_id' : tourGroupId, 'tp' : 'F'},

			dataType:'html',

			success:function(html){

				vietiso_loading(0);

				makepopupnotresize('55%', 'auto', html, 'box_TourCategory');

				var $popup = $('#box_TourCategory');

				$popup.css('top','50px');

				var $editorID = $popup.find('.textarea_tour_intro_editor').attr('id');

				var $editorbannerID = $popup.find('.textarea_tour_intro_banner_editor').attr('id');

				if ($editorID) {
					$('#'+$editorID).isoTextAreaFix();
				}

				if ($editorbannerID) {
					$('#'+$editorbannerID).isoTextAreaFix();
				}

			}

		});

		return false;

	});

	$(document)
		.off('click.siteTourCategoryEdit', '.btnEditToursCategory')
		.on('click.siteTourCategoryEdit', '.btnEditToursCategory', function(ev){
		ev.preventDefault();
		ev.stopImmediatePropagation();

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

				var $popup = $('#box_TourCategory');

				$popup.css('top','50px');

				var $editorID = $popup.find('.textarea_tour_intro_editor').attr('id');

				var $editorbannerID = $popup.find('.textarea_tour_intro_banner_editor').attr('id');

				if ($editorID) {
					$('#'+$editorID).isoTextAreaFix();
				}

				if ($editorbannerID) {
					$('#'+$editorbannerID).isoTextAreaFix();
				}

			}

		});

		return false;

	});

	$(document)
		.off('click.siteTourCategorySave', '.btnClickToSubmitCategory')
		.on('click.siteTourCategorySave', '.btnClickToSubmitCategory', function(ev){

		ev.preventDefault();
		ev.stopImmediatePropagation();

		var $_this = $(this);

		if ($_this.data('saving') === 1) {
			return false;
		}

		var $_popup = $_this.closest('#box_TourCategory, .frmPop');

		var $_form = $_popup.find('#frmForm').first();

		if (!$_form.length) {
			$_form = $('#frmForm').last();
		}

		var $title = $_form.find('input[name=title]');

		var $editorID = $_form.find('.textarea_tour_intro_editor').attr('id');

		var $editorbannerID = $_form.find('.textarea_tour_intro_banner_editor').attr('id');

		

		var $image = $_form.find('#isoman_url_image').val() || '';

		var $icon = $_form.find('#isoman_url_icon').val() || '';

		var $image_banner = $_form.find('#isoman_url_image_banner').val() || '';

		var $video_teaser = $_form.find('#isoman_url_video_teaser').val() || '';

		var $background = $_form.find('input[name=iso-background]').val() || '';

		var $link_banner = $_form.find('input[name=iso-link_banner]').val() || '';

		

		if($.trim($title.val())==''){

			$title.addClass('error').focus();

			alertify.error(field_is_required);

			return false;

		}

		var $tour_group_id = parseInt(
			$_form.find('[name=tour_group_id]').val(),
			10
		) || 0;

		if($SiteHasGroup_Tours && LANG_ID == "vn"){

			var $slb_TourGroup = $_form.find('#slb_TourGroup');

			if(
				$slb_TourGroup.length &&
				parseInt($slb_TourGroup.val(), 10) === 0
			){

				$slb_TourGroup.focus();

				setSelectOpen($slb_TourGroup);

				alertify.error(field_is_required);

				return false;

			}

			if ($slb_TourGroup.length) {
				$tour_group_id = parseInt(
					$slb_TourGroup.val(),
					10
				) || 0;
			}

		}

		var $parent_ID = 0;

		if($SiteHasSubCat_Tours){

			var $slb_TourCategory = $_form.find('#slb_TourCategory');

			$parent_ID = parseInt($slb_TourCategory.val(), 10) || 0;

		}

		

		var editor = tinyMCE.get($editorID);

		var intro = editor
			? editor.getContent()
			: ($_form.find('.textarea_tour_intro_editor').val() || '');

		var introBanner = '';

		if ($editorbannerID) {
			var bannerEditor = tinyMCE.get($editorbannerID);

			introBanner = bannerEditor
				? bannerEditor.getContent()
				: ($_form.find('.textarea_tour_intro_banner_editor').val() || '');
		}



		let frag = document.createElement('div');

		frag.innerHTML = intro;

		let itemsBase64 = [...frag.querySelectorAll('img')]

	  .filter(img => (img.getAttribute('src') || '').startsWith('data:'))

	  .map(img => img.getAttribute('src'));

		if(itemsBase64.length){

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



		var adata = {

			'title' 		: 	$title.val(),

			'intro'	  		: 	intro,

			'intro_banner'	: 	introBanner,

			'link_banner'	  		: 	$link_banner,

			'background'	  		: 	$background,

			'image'	  		: 	$image,

			'icon'			: 	$icon,

			'image_banner'	: 	$image_banner,

			'video_teaser'	: 	$video_teaser,

			'parent_id'		: 	$parent_ID,

			'tour_group_id'	: 	$tour_group_id,

			'tourcat_id' 	: 	parseInt($_this.attr('tourcat_id'), 10) || 0,

			'tp' 			: 	'S'

		};

		$_this.data('saving', 1).prop('disabled', true);

		vietiso_loading(1);

		$.ajax({

			type:'POST',

			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteTourCategory',

			data:adata,

			dataType:'html',

			success:function(html){

				html = $.trim(String(html || ''));

				if(html.indexOf('_SUCCESS') >= 0){

					window.location.reload(true);

					return;

				}

				if(html.indexOf('_EXIST') >= 0){

					alertify.error(insert_error_exist);

					return;

				}

				console.error('SiteTourCategory response:', html);

				alertify.error(insert_error);

			},

			error:function(xhr){

				console.error(
					'SiteTourCategory AJAX error:',
					xhr.status,
					xhr.responseText
				);

				alertify.error(insert_error);

			},

			complete:function(){

				$_this.data('saving', 0).prop('disabled', false);

				vietiso_loading(0);

			}

		});

		return false;

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

			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTourCategory", order, 

			

			function(html){

				vietiso_loading(0);

			});

		}

	});

</script>

{/literal}
