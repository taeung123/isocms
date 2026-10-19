<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="box_form_insert_tour_new">
	<div class="box_info_tour_top box_top_opt_set">
		<div class="info_tour">
			<a href="{$PCMS}/admin/?mod=city" class="back_list" title="{$core->get_Lang('city_list')}"><i class="fa fa-angle-left"></i></a>
			 <img class="image_nav_tour isoman_show_image" table_id="{$pvalTable}" src="{$clsClassTable->getImage($pvalTable,80,59)}" alt="{$clsClassTable->getTitle($pvalTable)}" width="80" height="59">
			<div class="body_tour">
				<h3 class="table-title" table_id="{$pvalTable}">{$clsClassTable->getTitle($pvalTable)}</h3>
				<p class="p_tripcode">
					<a class="go_overview" href="{$PCMS}/admin/city/insert/{$pvalTable}/overview">{$core->get_Lang('Go to overview')}</a></span> 
				</p>
			</div>
		</div>
		<div class="info_button">
			<div class="toggle_opt btn_online action_tour">
				<div class="box_status_switch">
					{if $oneItem.is_online ne 1}
						<span class="txt_status_switch private">{$core->get_Lang('Private')}</span>
					{else}
						<span class="txt_status_switch public">{$core->get_Lang('Public')}</span>
					{/if}
					<label class="switch_public switch" data-clstable="City" data-pkey="{$clsClassTable->pkey}" data-sourse_id="{$pvalTable}">
						<input type="checkbox" name="is_online" value="1" {if $oneItem.is_online eq 1}checked{/if}>
						<span class="slider round"></span>
					</label>
				</div>
			</div>
			<div class="action_tour btn_preview">
				<a class="btn_preview_tour preview_tour_ex" {if $oneItem.is_trash eq 1}style="pointer-events: none;color: rgb(204, 204, 204);border-color: rgb(204, 204, 204);background-color: rgb(255, 255, 255);cursor: not-allowed;"{/if} href="{$clsClassTable->getLink($pvalTable)}" target="_blank" title="{$clsClassTable->getTitle($pvalTable)}">{$core->get_Lang('Preview')}</a>
			</div>
			<div class="action_tour btn_delete" id="is_delete_tour">
				<a class="btn_preview_tour delete_tour_ex" type_btn="delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&{$clsClassTable->pkey}={$core->encryptID($pvalTable)}{$pUrl|default:''}" title="{$clsClassTable->getTitle($pvalTable)}">{$core->get_Lang('Delete')}</a>
			</div>
			<button class="btn action_tour" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
				<i class="fa-solid fa-gear"></i>
			</button>
		</div>
	</div>
	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
		<div class="offcanvas-header border_bottom">
			<h5 id="offcanvasRightLabel">{$core->get_Lang('Setting')}</h5>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body">
			<div class="d-flex flex-column">
				<div class="form-group">
					<div class="toggle_opt btn_online action_tour">
						<div class="box_status_switch">
							<label class="switch_public switch" for="id_top_des">
								<input type="checkbox" value="1" {if $is_top_des==1}checked{/if} id="id_top_des" class="iso_radio_switch" data-type="TOP">
								<span class="slider round"></span>
							</label>
							<span class="txt_status_switch" style="margin-left: 15px;">{$core->get_Lang('Top destination')}</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="toggle_opt btn_online action_tour">
						<div class="box_status_switch">
							<label class="switch_public switch" for="id_departure_point">
								<input type="checkbox" value="1" {if $is_departure_time==1}checked{/if} id="id_departure_point" class="iso_radio_switch" data-type="DEPARTUREPOINT">
								<span class="slider round"></span>
							</label>
							<span class="txt_status_switch" style="margin-left: 15px;">{$core->get_Lang('Departure point')}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid bg_fff" style="padding-top: 0;padding-bottom: 0;">
		<div class="box_content_page">
			<div class="row d-flex flex-wrap">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 box_left_opt_set">
					{$core->getBlock('menu_step')}
					
				</div>
				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
					<div class="main_step_box" id="frmMainStep_{$pvalTable}">

					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    var table_id = `{$pvalTable|default:0}`;
    var panel = `{$panel|default:''}`;
    var currentstep = `{$currentstep|default:''}`;
    var nextstep = `{$nextstep|default:[]}`;
    var $continent_id = `{$oneItem.continent_id|default:0}`;
	var $country_id = `{$oneItem.country_id|default:0}`;
    var $region_id = `{$oneItem.region_id|default:0}`;
    var $city_id = `{$oneItem.city_id|default:0}`;
	var map_lo= `{$oneItem.map_lo|default:0}`;
	var map_la= `{$oneItem.map_la|default:0}`;
	var map_zoom = `{$oneItem.map_zoom|default:0}`;
	var map_type = `{$oneItem.map_tyle|default:0}`;
	var Select = `{$core->get_Lang('Select')}`;
	var title_exit = '{$core->get_Lang("City name has existed")}';
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
<script type="text/javascript" src="{$URL_THEMES}/city/jquery.city.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/city/jquery.city.new.js?v={$upd_version}"></script>
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
