<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="box_form_insert_tour_new">
	<div class="box_info_tour_top box_top_opt_set">
		<div class="info_tour">
			<a href="{$PCMS}/admin/?mod=combo" class="back_list" title="{$core->get_Lang('Combo list')}"><i class="fa fa-angle-left"></i></a>
			 <img class="image_nav_tour isoman_show_image" table_id="{$pvalTable}" src="{$clsClassTable->getImage($pvalTable,80,59)}" alt="{$clsClassTable->getTitle($pvalTable)}" width="80" height="59">
			<div class="body_tour">
				<h3 class="table-title" table_id="{$pvalTable}">{$clsClassTable->getTitle($pvalTable)}</h3>
				<p class="p_tripcode">
					<a class="go_overview" href="{$PCMS}/admin/combo/insert/{$pvalTable}/overview">{$core->get_Lang('Go to overview')}</a> <span>{$core->get_Lang('Combo code')}: <span class="table_code" table_id="{$pvalTable}">{$clsClassTable->getCode($pvalTable)}</span></span> 
				</p>
			</div>
		</div>
		<div class="info_button">
			<div class="toggle_opt btn_online action_tour">
				{if $oneItem.is_online eq 1}
				<a class="online_tour private_tour" data-val="0">{$core->get_Lang('Private')}</a>
				{else}
				<a class="online_tour" data-val="1">{$core->get_Lang('Public')}</a>
				{/if}
			</div>
			<div class="action_tour btn_preview">
				<a class="btn_preview_tour preview_tour_ex" {if $oneItem.is_trash eq 1}style="pointer-events: none;color: rgb(204, 204, 204);border-color: rgb(204, 204, 204);background-color: rgb(255, 255, 255);cursor: not-allowed;"{/if} href="{$clsClassTable->getLink($pvalTable)}" target="_blank" title="{$clsClassTable->getTitle($pvalTable)}">{$core->get_Lang('Preview')}</a>
			</div>
			<div class="action_tour btn_delete" id="is_delete_tour">
				<a class="btn_preview_tour delete_combo" data-combo_id="{$pvalTable}" type_btn="delete" href="javascript:void(0);" title="{$core->get_Lang('Delete')}">{$core->get_Lang('Delete')}</a>
			</div>
		</div>

	</div>
	<div class="container-fluid bg_fff" style="padding-top: 0;padding-bottom: 0;">
		<div class="box_content_page">
			<div class="row d-flex">
				<div class="col-sm-2 col-md-2 col-lg-2 box_left_opt_set">
					{$core->getBlock('menu_step_hotel')}
					
				</div>
				<div class="col-sm-10 col-md-10 col-lg-10">
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
    var continent_id = "{$oneItem.continent_id}";
	var country_id = "{$oneItem.country_id}";
    var region_id = "{$oneItem.region_id}";
    var city_id = "{$oneItem.city_id}";
	var map_lo="{$oneItem.map_lo}";
	var map_la="{$oneItem.map_la}";
	var map_zoom = '{$oneItem.map_zoom}';
	var map_type = '{$oneItem.map_tyle}';
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
<script type="text/javascript" src="{$URL_THEMES}/combo/jquery.combo.js?v={$upd_version}"></script>
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/bootstrap/js/bootstrap.min.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/html2canvas.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all" />
<!-- Map -->
<link href="https://api.tiles.mapbox.com/mapbox.js/v2.4.0/mapbox.css?v={$upd_version}" rel="stylesheet" />
<script src="https://api.tiles.mapbox.com/mapbox.js/v2.4.0/mapbox.js?v={$upd_version}"></script>
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-heat/v0.1.0/leaflet-heat.js?v={$upd_version}"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css?v={$upd_version}" />
<script type="text/javascript" src='{$URL_JS}/leaflet-image.js?v={$upd_version}'></script>
