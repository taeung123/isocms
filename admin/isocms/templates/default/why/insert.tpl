<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="box_form_insert_tour_new">
	<div class="box_info_tour_top box_top_opt_set">
		<div class="info_tour">
			<a href="{$PCMS}/admin/?mod=why{if $type}&type={$type}{/if}{if $cat_id > 0}&whycat_id={$cat_id}{/if}" class="back_list" title="{$core->get_Lang('slide_list')}"><i class="fa fa-angle-left"></i></a>
			<div class="body_tour">
				<h3 class="table-title" table_id="{$pvalTable}">{$oneItem.title}</h3>
				<p class="p_tripcode">
                    {if $type}
					<a class="go_overview" href="{$PCMS}/admin/why/insert/{$pvalTable}/{$type}/overview">{$core->get_Lang('Go to overview')}</a>
                    {else}
                    <a class="go_overview" href="{$PCMS}/admin/why/insert/{$pvalTable}/overview">{$core->get_Lang('Go to overview')}</a>
                    {/if}
                </span> 
				</p>
			</div>
		</div>
		<div class="info_button">
			<div class="toggle_opt btn_online action_tour">
				{if $oneItem.is_online ne 1}
				<a class="online_tour private_tour" data-clstable="Why" data-pkey="{$clsClassTable->pkey}" data-val="0" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Public')}">{$core->get_Lang('Private')}</a>
				{else}
				<a class="online_tour" data-clstable="Why" data-pkey="{$clsClassTable->pkey}" data-val="1" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Private')}">{$core->get_Lang('Public')}</a>
				{/if}
			</div>
			<div class="action_tour btn_delete" id="is_delete_tour">
				<a class="btn_preview_tour delete_tour_ex confirm_delete" type_btn="delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&faq_id={$core->encryptID($pvalTable)}{$pUrl}&page={$currentPage}" title="{$clsClassTable->getTitle($pvalTable)}">{$core->get_Lang('Delete')}</a>
			</div>
		</div>

	</div>
	<div class="container-fluid bg_fff" style="padding-top: 0;padding-bottom: 0;">
		<div class="box_content_page">
			<div class="row d-flex flex-wrap">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="main_step_box" id="frmMainStep_{$pvalTable}">

					</div>
				</div>

			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
    var table_id = '{$pvalTable}';
    var panel = '{$panel}';
    var currentstep = '{$currentstep}';
    var nextstep = '{$nextstep}';
	var Select = 'Select';	
</script>
{literal}
<script>
	$(function () {
		
		$(window).scroll(function() {
			var sticky = $('.box_top_opt_set'),
				scroll = $(window).scrollTop();
			if (scroll >= 40) {
				sticky.addClass('fixed');
			}else {
				sticky.removeClass('fixed');
			}
		});
		loadMainFormStep(table_id,currentstep,nextstep);
	});
	
</script>
{/literal}
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/bootstrap/js/bootstrap.min.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/html2canvas.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all" />
<!-- Map -->
<link href="{$URL_JS}/mapbox/mapbox.css?v={$upd_version}" rel="stylesheet" />
<script src="{$URL_JS}/mapbox/mapbox.js?v={$upd_version}"></script>
<script src="{$URL_JS}/mapbox/leaflet-heat.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_JS}/mapbox/leaflet.css?v={$upd_version}" />
<script type="text/javascript" src="{$URL_JS}/mapbox/leaflet-image.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/why/jquery.why.new.js?v={$upd_version}"></script>
