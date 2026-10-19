<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="box_form_insert_tour_new">
	<div class="box_info_tour_top box_top_opt_set">
		<div class="info_tour">
			<a href="{$PCMS}/admin/?mod=meta" class="back_list" title="{$core->get_Lang('meta_list')}"><i class="fa fa-angle-left"></i></a>
			<div class="body_tour">
				<h3 class="table-title" table_id="{$pvalTable}">{$clsClassTable->getMetaTitle($pvalTable)}</h3>
				<p class="p_tripcode">
					<a class="go_overview" href="{$PCMS}/admin/meta/insert/{$pvalTable}/overview">{$core->get_Lang('Go to overview')}</a></span> 
				</p>
			</div>
		</div>
		<div class="info_button">
			<div class="action_tour btn_delete" id="is_delete_tour">
				<a class="btn_preview_tour delete_tour_ex confirm_delete" type_btn="delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&meta_id={$core->encryptID($pvalTable)}{$pUrl}&page={$currentPage}" title="{$clsClassTable->getMetaTitle($pvalTable)}">{$core->get_Lang('Delete')}</a>
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
<script type="text/javascript" src="{$URL_THEMES}/meta/jquery.meta.new.js?v={$upd_version}"></script>
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
