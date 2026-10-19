<link rel="stylesheet" href="{$URL_CSS}/style_tour_setting.css?v={$upd_version}" type="text/css" media="all" />

<div class="page-tour_setting iso-module-list">
	<nav class="booking-list-breadcrumb v2-breadcrumb" aria-label="Breadcrumb">
    <a href="https://isocms.com/admin/"><i class="fa fa-home" aria-hidden="true"></i> {$core->get_Lang('Dashboard')}</a>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <span>{$core->get_Lang('Property')}</span>
</nav>
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
	{$core->getBlock('menu_tour_exhautive_setting')}
	<div class="content_setting_box">
    {* PAGE HEADER *}
    <div class="page_detail-title d-flex">
        <div class="title">
            <h2>{$core->get_Lang('Travel Style list')}</h2>
            <p>{$core->get_Lang("This function is intended to manage in isoCMS system")} Travel Styles</p>
        </div>
        <div class="button_right">
            <a class="btn btn-main btn-addnew btnCreateToursCategory btnCreate"
               href="javascript:void(0);"
               data-tour-group-id="{$tour_group_id|default:0}"
               title="{$core->get_Lang('Add new')}">
                {$core->get_Lang('Add new')}
            </a>
        </div>
    </div>
    {* FILTER BAR *}
    <div class="filter_box">

        <form id="forums" method="post" class="filterForm" action="">
            <div class="filterbox">
                <div class="wrap">

                    <div class="searchbox">

                        {* SEARCH LEFT *}
                        <div class="searchbox-left">
                            <i class="fa fa-search" aria-hidden="true"></i>

                            <input type="text"
                                   class="text search_keyword"
                                   name="keyword"
                                   value="{$keyword|default:''}"
                                   placeholder="{$core->get_Lang('Search travel styles by name...')}" />

                            <a class="btn btn-text btn-main"
                               href="javascript:void(0);"
                               id="searchbtn">
                                {$core->get_Lang('Search')}
                            </a>
                                                        	<a class="btn btn-delete-all " id="btn_delete" clstable="TourCategory" style="display: none;">

								{$core->get_Lang('Delete')}

							</a>
                        </div>

                        {* RECORDS PER PAGE RIGHT *}
                        <div class="searchbox-right">
                            <label for="recordperpage">
                                {$core->get_Lang('Record/page')}
                            </label>

                            <select id="recordperpage"
                                    name="recordperpage"
                                    onchange="window.location = this.options[this.selectedIndex].value">

                                <option
                                    {if $recordPerPage eq '20'}selected="selected"{/if}
                                    value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=20">
                                    20
                                </option>

                                {if $totalRecord gt 20}
                                    <option
                                        {if $recordPerPage eq '50'}selected="selected"{/if}
                                        value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=50">
                                        50
                                    </option>
                                {/if}

                                {if $totalRecord gt 50}
                                    <option
                                        {if $recordPerPage eq '100'}selected="selected"{/if}
                                        value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=100">
                                        100
                                    </option>
                                {/if}

                                {if $totalRecord gt 100}
                                    <option
                                        {if $recordPerPage eq '200'}selected="selected"{/if}
                                        value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=200">
                                        200
                                    </option>
                                {/if}

                                {if $totalRecord gt 200}
                                    <option
                                        {if $recordPerPage eq $totalRecord}selected="selected"{/if}
                                        value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage={$totalRecord}">
                                        {$core->get_Lang('All')}
                                    </option>
                                {/if}

                            </select>

                        </div>

                    </div>

                    <input type="hidden" name="filter" value="filter" />

                </div>
            </div>
        </form>

        {* LIST TOUR BUTTON *}
        <!-- <div class="group_buttons">
            <a href="{$PCMS_URL}/index.php?mod=tour_exhautive"
               class="btn btn-warning btnNew">
                <i class="icon-list icon-white" aria-hidden="true"></i>
                <span>{$core->get_Lang('List Tour')}</span>
            </a>
        </div> -->

    </div>

    {* TABLE CARD *}
    <div class="list-table-v2-card booking-table-card v2-table-card">
        <div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">

            <table cellspacing="0"
                   class="list-table-v2 cruise-list-table v2-table"
                   width="100%">

                <thead>
                    <tr>
                        <th class="list-table-v2-check booking-check-cell booking-check-sort"
                            style="width:40px">#</th>

                        <th class="list-table-v2-check booking-check-cell booking-check-sort"
                            style="width:50px">
                            <input id="check_all"
                                   type="checkbox"
                                   class="el-checkbox"
                                   style="cursor:pointer" />
                        </th>

                        <th class="list-table-v2-name name_responsive"
                            style="text-align:left">
                            <strong>{$core->get_Lang('Name')}</strong><i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-name image_responsive"
                            style="text-align:left">
                            <strong>{$core->get_Lang('Image')}</strong><i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-public hiden_responsive"
                            style="width:100px">
                            <strong>{$core->get_Lang('status')}</strong><i class="sort-ico fa-solid fa-sort"></i>
                        </th>


                        <th class="list-table-v2-action is-center list-table-action-cell"
                            style="width:80px"><strong>{$core->get_Lang('Action')}</strong> </th>
                    </tr>
                </thead>

                {if !empty($allItem) && $allItem[0].tourcat_id ne ''}

                    <tbody id="SortAble" class="sortByTd ui-sortable">

                        {foreach $allItem as $item}

                            <tr id="order_{$item.tourcat_id}">

                                {* SORT HANDLE *}
                                <td class="index hiden767 sortable">
                                    <i class="fa fa-arrows" aria-hidden="true"></i>
                                </td>

                                {* CHECKBOX *}
                                <td class="check_40 has-checkbox text-center booking-check-sort">
                                    <input name="p_key[]"
                                           class="chkitem el-checkbox"
                                           type="checkbox"
                                           value="{$item.tourcat_id}"
                                           style="cursor:pointer" />
                                </td>

                                {* TRAVEL STYLE NAME *}
                                <td class="name_service">
                                    <b>{$item.title} </b>
                                <div class="v2-meta list-table-v2-meta tour-meta list-table-meta">
                                    {assign var=regDate value=$clsClassTable->getOneField('reg_date', $item.tourcat_id)}
                                    {$core->get_Lang('Created')}:                                     
                                    {if !empty($regDate)}
                                        {$regDate|date_format:"%m-%d-%Y %H:%M"}
                                    {else}
                                        N/A
                                    {/if}

                            
                                    {assign var=updDate value=$clsClassTable->getOneField('upd_date', $item.tourcat_id)}
                                    &nbsp;|&nbsp; 
                                    {$core->get_Lang('Updated')}:                                     
                                    {if !empty($updDate)}
                                        {$updDate|date_format:"%m-%d-%Y %H:%M"}
                                    {else}
                                        N/A
                                    {/if}
                                </div>
                                 <div class="v2-meta list-table-v2-meta tour-meta list-table-meta">
                                        {$core->get_Lang('Created By')}: 
                                        {if $item.user_id gt 0}
                                            {assign var=firstName value=$clsUser->getOneField('first_name', $item.user_id)}
                                            {assign var=lastName value=$clsUser->getOneField('last_name', $item.user_id)}
                                            {assign var=fullName value="`$firstName|default:''` `$lastName|default:''`"}
                                            {$fullName|trim|default:'N/A'}
                                        {else}
                                            N/A
                                        {/if}
                                 </div>
                        
                                    {if $item.is_trash eq '1'}
                                        <span class="fr" style="color:#CCC">
                                            {$core->get_Lang('intrash')}
                                        </span>
                                    {/if}
                                </td>

                                <td class="list-table-image image_responsive">
                                    <img
                                        src="{$clsClassTable->getImage($item.tourcat_id, 60, 60)}"
                                        width="60"
                                        height="60"
                                        alt="{$item.title|escape:'html'}"
                                        loading="lazy"
                                    />
                                </td>

                                {* STATUS *}
                                <td class="block_responsive"
                                    data-title="{$core->get_Lang('status')}">

                                    <a href="javascript:void(0);"
                                       class="SiteClickPublic"
                                       clsTable="TourCategory"
                                       pkey="{$pkeyTable}"
                                       sourse_id="{$item[$pkeyTable]}"
                                       rel="{$clsClassTable->getOneField('is_online',$item[$pkeyTable])}"
                                       title="{$core->get_Lang('Click to change status')}">

                                        {if $clsClassTable->getOneField('is_online',$item[$pkeyTable]) eq '1'}
                                            <i class="fa-solid fa-circle-check green"
                                               aria-hidden="true"></i>
                                        {else}
                                            <i class="fa-solid fa-circle-minus red"
                                               aria-hidden="true"></i>
                                        {/if}

                                    </a>
                                </td>


                                <td class="block_responsive text-center list-table-action-cell"
                                    style="white-space:nowrap;vertical-align:middle"
                                    data-title="{$core->get_Lang('func')}">

                                    <div class="btn-group">
                                        <div class="dropdown">

                                            <button class="btn btn_dropdown dropdown-toggle"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    title="{$core->get_Lang('func')}">
                                                <i class="fa fa-ellipsis-v"
                                                   aria-hidden="true"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">

                                                {if $item.is_trash eq '1'}

                                                    {* RESTORE *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           title="{$core->get_Lang('restore')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&tourcat_id={$core->encryptID($item.tourcat_id)}{$pUrl}">
                                                            <i class="icon-refresh"
                                                               aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('restore')}</span>
                                                        </a>
                                                    </li>

                                                    {* DELETE PERMANENTLY *}
                                                    <li>
                                                        <a class="dropdown-item confirm_delete"
                                                           title="{$core->get_Lang('delete')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tourcat_id={$core->encryptID($item.tourcat_id)}{$pUrl}">
                                                            <i class="icon-remove"
                                                               aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('delete')}</span>
                                                        </a>
                                                    </li>

                                                {else}

                                                    {* EDIT *}
                                                    <li>
                                                        <a class="dropdown-item btnEditToursCategory"
                                                           title="{$core->get_Lang('edit')}"
                                                           href="javascript:void(0);"
                                                           data="{$item.tourcat_id}">
                                                            <i class="icon-edit"
                                                               aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('edit')}</span>
                                                        </a>
                                                    </li>

                                                    {* MOVE TO TRASH *}
                                                    {if $item.tourcat_id ne 10 && $item.tourcat_id ne 20}
                                                        <li>
                                                            <a class="dropdown-item"
                                                               title="{$core->get_Lang('trash')}"
                                                               href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&tourcat_id={$core->encryptID($item.tourcat_id)}{$pUrl}">
                                                                <i class="icon-trash"
                                                                   aria-hidden="true"></i>
                                                                <span>{$core->get_Lang('trash')}</span>
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

        </div>
    </div>

    {* PAGINATION *}
    <div class="clearfix"></div>

    {$clsISO->getPaginationAdmin(
        $totalRecord,
        $totalPage,
        $currentPage,
        $listPageNumber,
        $link_page_current,
        $type|default:''
    )}

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
<style>
    .dropdown-menu-end li{
        padding: 7px 5px;
    }
@media (max-width: 991px) {
    .container-fluid{
        display: block !important;
    }
}
</style>
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
