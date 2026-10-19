<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="box_form_insert_tour_new">
	{$core->getBlock('breadcrumb_tour_settings')}
	<div class="box_info_tour_top box_top_opt_set">
		<div class="info_tour">
			<div class="body_tour">
				<h1 class="table-title" table_id="{$pvalTable}">{$core->get_Lang('Edit Travel Styles by Country')}</h1>
				<p class="p_tripcode">
					<a href="{$PCMS_URL}/?&mod=tour_exhautive&act=category_country"> <i class="fa-solid fa-arrow-left"></i> {$core->get_Lang(' Back to list')}</a></span> 
				</p>
			</div>
		</div>
		<div class="info_button">
			<div class="toggle_opt btn_online action_tour">
				{if $oneItem.is_online ne 1}
				<a class="online_tour private_tour" data-clstable="Category_Country" data-pkey="{$clsClassTable->pkey}" data-val="0" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Public')}"><i class="fa-solid fa-lock"></i> {$core->get_Lang('Private')}</a>
				{else}
				<a class="online_tour" data-clstable="Category_Country" data-pkey="{$clsClassTable->pkey}" data-val="1" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Private')}"><i class="fa-solid fa-house"></i>{$core->get_Lang('Public')}</a>
				{/if}
			</div>
			<div class="action_tour btn_delete " id="is_delete_tour">
				<a class="btn_preview_tour delete_tour_ex" {$pvalTable} type_btn="delete" href="{$PCMS_URL}/?mod={$mod}&act=delete2&category_country_id={$core->encryptID($pvalTable)}{$pUrl|default:''}&page={$currentPage|default:1}" title="{$core->get_Lang('Edit Travel Styles by Country')}"> <i class="fa-regular fa-trash-can"></i> {$core->get_Lang('Delete')}</a>
			</div>
		</div>

	</div>
	<div class="container-fluid bg_fff" style="padding-top: 0;padding-bottom: 0;">
		<div class="box_content_page">
			<div class="row d-flex flex-wrap">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 box_left_opt_set">
					{$core->getBlock('menu_step_category_country')}
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
    var nextstep = '{$nextstep}';
    var continent_id = `{$oneItem.continent_id|default:0}`;
	var country_id = `{$oneItem.country_id|default:0}`;
    var region_id = `{$oneItem.region_id|default:0}`;
    var city_id = `{$oneItem.city_id|default:0}`;
	var map_lo= `{$oneItem.map_lo|default:0}`;
	var map_la= `{$oneItem.map_la|default:0}`;
	var map_zoom = `{$oneItem.map_zoom|default:0}`;
	var map_type = `{$oneItem.map_tyle|default:0}`;
	var Select = 'Select';
</script>
{literal}
<style>
	.box_top_opt_set .info_button .action_tour a{
		display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 9px;
    font-size: 13.8px;
    font-weight: 700;
    padding: 11px 20px;
    cursor: pointer;
    border: 1px solid transparent;
    white-space: nowrap;
    transition: filter .15s, background .15s;

	}
	.box_top_opt_set .info_button .btn_delete a{
		    background: #fff;
    border-color: #f3c9c9;
    color: #e4393c;
	}
@media (max-width: 767px) {
	.box_top_opt_set {

    display: block;
}
}

</style>
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
<script type="text/javascript" src="{$URL_THEMES}/tour_exhautive/js/jquery.category_country.js?v={$upd_version}"></script>
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>
{*<script type="text/javascript" src="{$URL_JS}/bootstrap/js/bootstrap.min.js?v={$upd_version}"></script>*}
<script type="text/javascript" src="{$URL_JS}/html2canvas.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all" />
<!-- Map -->
<link href="{$URL_JS}/mapbox/mapbox.css?v={$upd_version}" rel="stylesheet" />
<script src="{$URL_JS}/mapbox/mapbox.js?v={$upd_version}"></script>
<script src="{$URL_JS}/mapbox/leaflet-heat.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_JS}/mapbox/leaflet.css?v={$upd_version}" />
<script type="text/javascript" src="{$URL_JS}/mapbox/leaflet-image.js?v={$upd_version}"></script>
