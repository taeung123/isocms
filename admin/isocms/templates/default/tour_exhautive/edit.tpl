<script src="{URL_LIBRARY}/fullcalendar/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="box_form_insert_tour_new">
    <div class="box_info_tour_top box_top_opt_set">
        <div class="info_tour">
            <a href="{if $has_parent_id}{$clsTour->linkListTourPackage($parent_id)}{else}{$PCMS_URL}/?mod=tour_exhautive{/if}" class="back_list" title="{$core->get_Lang('tour_list')}"><i
                        class="fa fa-angle-left"></i></a>
            <img class="image_nav_tour isoman_show_image" src="{$clsTour->getImage($pvalTable,80,59)}"
                 alt="{$clsTour->getTitle($pvalTable)}" width="80" height="59">
            <div class="body_tour">
                <h3 class="tour-title" tour_id="{$pvalTable}">{$clsTour->getTitle($pvalTable)}</h3>
                <p class="p_tripcode">
                    {if !$has_parent_id}<a class="go_overview"
                       href="{$PCMS_URL}/tour/edit/{$pvalTable}/overview">{$core->get_Lang('Go to overview')}</a>{/if}
                    <span>{$core->get_Lang('Trip code')}: <span class="trip_code"
                                                                tour_id="{$pvalTable}">{$clsTour->getTripCode($pvalTable)}</span></span>
                    |                                            
                    <span class="duration_tour" tour_id="{$pvalTable}">{$clsTour->getDuration($pvalTable)}</span>
                    {if $clsISO->checkConnTMS() && (!empty($oneItem.yield_id) || !empty($oneItem.tms_code))}
                        <span class="btn_connect is_connect_tms"
                              style="margin-left: 20px">{$core->get_Lang('TravelMaster')}</span>
                    {/if}
                    {if !empty($oneItem.is_for_agent)}<span class="btn_sale_agent" style="margin-left: 12px">{$core->get_Lang('Agent')}</span>{/if}

                </p>
            </div>
        </div>
        <div class="info_button">
            {if !$has_parent_id}
            <div class="toggle_opt btn_online action_tour">
                <div class="box_status_switch">
                    {if $oneItem.is_online ne 1}
                        <span class="txt_status_switch private">{$core->get_Lang('Private')}</span>
                    {else}
                        <span class="txt_status_switch public">{$core->get_Lang('Public')}</span>
                    {/if}
                    <label class="switch_public switch" data-clstable="Tour" data-pkey="{$clsClassTable->pkey}"
                           data-sourse_id="{$pvalTable}">
                        <input type="checkbox" name="is_online" value="1" {if $oneItem.is_online eq 1}checked{/if}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            {/if}
            {if !$has_parent_id}
                <div class="btn_online action_tour">
                    {if $oneItem.has_package eq 1}
                        <a class="is_has_package private_tour" data-pkey="{$clsClassTable->pkey}" data-val="0" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Not Package')}">{$core->get_Lang('Not Package')}</a>
                    {else}
                        <a class="is_has_package" data-pkey="{$clsClassTable->pkey}" data-val="1" data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Package')}">{$core->get_Lang('Package')}</a>
                    {/if}
                </div>
            {/if}
            <div class="action_tour btn_preview">
                {if $has_parent_id}
                    <a class="preview_tour_ex" href="{$clsTour->linkListTourPackage($parent_id)}">{$core->get_Lang('List Tour Package')}</a>
                    {else}
                <a class="btn_preview_tour preview_tour_ex"
                   {if $oneItem.is_trash eq 1}style="pointer-events: none;color: rgb(204, 204, 204);border-color: rgb(204, 204, 204);background-color: rgb(255, 255, 255);cursor: not-allowed;"{/if}
                   data-href="{$clsTour->getLink($pvalTable)}" target="_blank"
                   title="{$clsTour->getTitle($pvalTable)}">{$core->get_Lang('Preview')}</a>
                {/if}
            </div>
            <div class="action_tour btn_delete" id="is_delete_tour">
                <a class="delete_tour_ex" type_btn="delete{if $has_parent_id}_package{/if}" href="javascript:void(0);"
                   title="{$clsTour->getTitle($pvalTable)}">{$core->get_Lang('Delete')}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid bg_fff" style="padding-top: 0;padding-bottom: 0;">
        <div class="box_content_page">
            <div class="row flex-row">
                <div class="col-sm-2 col-md-2 col-lg-2 box_left_opt_set">
                    <div class="list_work_step_insert">
                        <div class="panel-group" id="accordion">
                            {foreach from=$list_menu_tour key=i item=menu}
                                {assign var=icon value=$menu.icon}
                                {assign var=cat_menu value=$menu.cat_menu}
                                {assign var=child_cat_menu value=$menu.child}
                                {if $cat_menu eq 'promotion' && _IS_PROMOTION eq 1}
                                    <div class="panel panel-default panel-sidebar">
                                        <div class="panel-heading" id="heading_{$cat_menu}">
                                            <button id="{$cat_menu}_tg_a" class="btn btn-link iso_tg_a {if $cat_run != $cat_menu && $run_ajax != 'overview'}collapsed{/if}" 
                                                    type="button" data-bs-toggle="collapse" 
                                                    data-bs-target="#{$cat_menu}_tg" 
                                                    aria-expanded="{if $cat_run == $cat_menu || $run_ajax == 'overview'}true{else}false{/if}" 
                                                    aria-controls="{$cat_menu}_tg">
                                                <h4 class="panel-title"><i class="ico ico-{$icon}"></i> {$core->get_Lang($cat_menu)}</h4>
                                            </button>
                                        </div>
                                        <div id="{$cat_menu}_tg" class="panel-collapse collapse {if $cat_run == $cat_menu || $run_ajax == 'overview'}show{/if}" 
                                            aria-labelledby="heading_{$cat_menu}" data-bs-parent="#accordion">
                                            <div class="panel-body">
                                                <ul class="stepbar-list">
                                                    {foreach from=$child_cat_menu key=j item=child}
                                                        <li>
                                                            <a class="load-block" 
                                                            href="/admin/tour/edit/{$pvalTable}/{$cat_menu}/{$child}" 
                                                            id="{$child}">
                                                                {$core->get_Lang($child)}
                                                            </a>
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                {else}
                                    <div class="panel panel-default panel-sidebar">
                                        <div class="panel-heading" id="heading_{$cat_menu}">
                                            <button id="{$cat_menu}_tg_a" class="btn btn-link iso_tg_a {if $cat_run != $cat_menu }collapsed{/if}" type="button" data-bs-toggle="collapse" 
                                                    data-bs-target="#{$cat_menu}_tg" 
                                                    aria-expanded="{if $cat_run == $cat_menu}true{else}false{/if}" 
                                                    aria-controls="{$cat_menu}_tg">
                                                <h4 class="panel-title">
                                                    {$icon}
                                                    {$core->get_Lang($cat_menu)}
                                                </h4>
                                            </button>
                                        </div>
                                        <div id="{$cat_menu}_tg" class="panel-collapse collapse {if $cat_run == $cat_menu}show{/if}" 
                                            aria-labelledby="heading_{$cat_menu}" data-bs-parent="#accordion">
                                            <div class="panel-body">
                                                <ul class="stepbar-list">
                                                    {foreach from=$child_cat_menu key=j item=child}
                                                        <li>
                                                            <a class="load-block" 
                                                            href="/admin/tour/edit/{$pvalTable}/{$cat_menu}/{$child}" 
                                                            id="{$child}">
                                                                {$core->get_Lang($child)}
                                                                {if in_array($child,$list_sync) && $oneItem.yield_id}
                                                                    {$clsISO->makeIcon('compress')}
                                                                {/if}
                                                            </a>
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>

                    </div>
                </div>
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <div class="content_box_insert_tour">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all"/>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css?v={$upd_version}" media="all"/>
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/html2canvas.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js?v={$upd_version}"></script>
<!-- Map -->
<link href="{$URL_JS}/mapbox/mapbox.css?v={$upd_version}" rel="stylesheet"/>
<script src="{$URL_JS}/mapbox/mapbox.js?v={$upd_version}"></script>
<script src="{$URL_JS}/mapbox/leaflet-heat.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_JS}/mapbox/leaflet.css?v={$upd_version}"/>
<script type="text/javascript" src='{$URL_JS}/mapbox/leaflet-image.js?v={$upd_version}'></script>
<script type="text/javascript">
    var path_ajax_datepicker = '{$URL_JS}/vietiso_datepicker/js?v={$upd_version}';
    var aj_search = 0;
    var tour_id = '{$pvalTable|default:0}';
    var $tour_id = '{$pvalTable|default:0}';
    var tour_group_id = '{$tour_group_id|default:0}';
    var $tour_type_id = '{$tour_type_id|default:0}';
    var $listcatID = '{$oneItem.list_cat_id|default:0}';
    var $tourgroup_ID = '{$oneItem.tour_group_id|default:0}';
    var country = "{$core->get_Lang('country')}";
    var regions = "{$core->get_Lang('regions')}";
    var cities = "{$core->get_Lang('cities')}";
    var area = "{$core->get_Lang('Area')}";
    var attractions = "{$core->get_Lang('attractions')}";
    var continents = "{$core->get_Lang('continents')}";
    var required_country = "{$core->get_Lang('required_country')}";
    var identicaltour = "{$core->get_Lang('Error. Please enter a different name and try again tour')}";
    var existedtour = "{$core->get_Lang('This Tour has existed. Please enter a different name and try again tour')}";
    var required_client = "{$core->get_Lang('This tour is not a client type and age choose to participate. Please choose in the table above')}";
    var slug = "{$run_ajax}";
    var exist_success_tour_status = "{$core->get_Lang('exist_success_tour_status')}";
    var exist_success_tour_trash = "{$core->get_Lang('exist_success_tour_trash')}";
    var exist_success_tour_delete = "{$core->get_Lang('exist_success_tour_delete')}";
    var exist_success_tour_restore = "{$core->get_Lang('exist_success_tour_restore')}";
</script>
{literal}
<script>
    $(function () {
        $(window).scroll(function () {
            var sticky = $('.box_top_opt_set'),
                scroll = $(window).scrollTop();
            if (scroll >= 40) {
                sticky.addClass('fixed');
            } else {
                sticky.removeClass('fixed');
            }
        });
    });
    var slug = '{/literal}{$run_ajax}{literal}';

    function content() {
        return tinyMCE.editors[$('.textarea_intro_editor_simple').attr('id')].getContent();
    }
</script>
{/literal}