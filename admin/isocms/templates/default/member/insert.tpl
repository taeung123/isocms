<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="box_form_insert_tour_new">
	<div class="box_info_tour_top box_top_opt_set">
		<div class="info_tour">
			<a href="{$PCMS}/admin/?mod=member" class="back_list" title="{$core->get_Lang('member_list')}"><i class="fa fa-angle-left"></i></a>
			 <img class="image_nav_tour isoman_show_image" table_id="{$pvalTable}" src="{if $clsClassTable->getImageAvatar($pvalTable,80,59) ne ''}{$clsClassTable->getImageAvatar($pvalTable,80,59)}{else}{$URL_IMAGES}/member.jpg{/if}" alt="{$oneItem.full_name}" width="80" height="59">
			<div class="body_tour">
				<h3 class="table-title" table_id="{$pvalTable}">{$oneItem.full_name}</h3>
				<p class="p_tripcode">
					<a class="go_overview" href="{$PCMS}/admin/member/insert/{$pvalTable}/overview">{$core->get_Lang('Go to overview')}</a></span> 
				</p>
			</div>
		</div>
		<div class="info_button">
			<div class="toggle_opt btn_online action_tour">
				{if $oneItem.is_online ne 1}
				<a class="online_tour private_tour" data-clstable="Profile" data-pkey="{$clsClassTable->pkey}" data-val="0" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Public')}">{$core->get_Lang('Private')}</a>
				{else}
				<a class="online_tour" data-clstable="Profile" data-pkey="{$clsClassTable->pkey}" data-val="1" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Private')}">{$core->get_Lang('Public')}</a>
				{/if}
			</div>
			<div class="action_tour btn_delete" id="is_delete_tour">
				<a class="btn_preview_tour delete_tour_ex" type_btn="delete" href="javascript:void(0);" title="{$oneItem.full_name}">{$core->get_Lang('Delete')}</a>
			</div>
		</div>

	</div>
	<div class="container-fluid bg_fff" style="padding-top: 0;padding-bottom: 0;">
		<div class="box_content_page">
			<div class="row d-flex flex-wrap">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 box_left_opt_set">
					{$core->getBlock('menu_step_member')}
					
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
    var continent_id = `{$oneItem.continent_id|default:0}`;
	var country_id = `{$oneItem.country_id|default:0}`;
    var region_id = `{$oneItem.region_id|default:0}`;
    var city_id = `{$oneItem.city_id|default:0}`;
	var map_lo= `{$oneItem.map_lo|default:0}`;
	var map_la= `{$oneItem.map_la|default:0}`;
	var map_zoom = `{$oneItem.map_zoom|default:0}`;
	var map_type = `{$oneItem.map_tyle|default:0}`;
	var Select = `{$core->get_Lang('Select')}`;
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
<script type="text/javascript" src="{$URL_THEMES}/member/jquery.member.js?v={$upd_version}"></script>
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
