<script src="{URL_LIBRARY}/fullcalendar/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="box_form_insert_tour_new iso-tour-basicinfo">
  <!-- HEADER (shared component) -->
  <header class="tm-tour-header">
    <div class="tm-header-decor-svg" aria-hidden="true">
      <svg viewBox="0 0 400 90" width="100%" height="100%" preserveAspectRatio="xMaxYMid meet">
        <path d="M0,90 L60,40 L110,70 L170,20 L230,60 L290,30 L350,65 L400,25 L400,90 Z" fill="#DCE6F5" />
      </svg>
    </div>
    <span class="tm-tour-header__decor" aria-hidden="true">Turn trips into amazing journeys ✈</span>

    <div class="tm-tour-thumb-wrap">
      <img src="{$clsTour->getImage($pvalTable,80,59)}" alt="">
      <span class="tm-tour-thumb-badge" aria-hidden="true"><i class="fa-regular fa-image"></i></span>
    </div>

    <div class="tm-tour-identity">
      <div class="tm-tour-identity__meta-row">
        <span class="tm-tour-id">#{$pvalTable}</span>
        {if $oneItem.is_online ne 1}
          <span class="tm-status-pill tm-status-pill--inactive">
            <i class="fa-solid fa-circle-minus"></i>
            <span class="tm-status-text">{$core->get_lang('Private')}</span>
          </span>
        {else}
          <span class="tm-status-pill tm-status-pill--active">
            <i class="fa-solid fa-circle-check"></i>
            <span class="tm-status-text">{$core->get_lang('Public')}</span>
          </span>
        {/if}
        </span>
      </div>
      <h1 class="tm-tour-title">{$clsTour->getTitle($pvalTable)}</h1>
      <div class="tm-tour-metadata">
        <span><i class="fa-regular fa-clock"></i> {$clsTour->getDuration($pvalTable)}</span>
        <span><i class="fa-solid fa-tag"></i>{$clsTourCategory->getListTitle($oneItem.list_cat_id)}</span>
        <span><i class="fa-regular fa-calendar"></i> Created:
          {$clsISO->formatDateTime($oneItem.reg_date, "d/m/Y", 0)}</span>
        <span><i class="fa-solid fa-rotate"></i> Updated:
          {$clsISO->formatDateTime($oneItem.upd_date, "d/m/Y", 0)}</span>
      </div>
    </div>

    <div class="tm-tour-actions">
      <div class="tm-tour-actions__toggle">
        <span>{$core->get_lang('Public')}</span>
        <label class="tm-toggle">
          <span class="visually-hidden">Toggle public visibility</span>
          <input type="checkbox" class="SiteClickPublic togglePublicTop" clsTable="Tour" pkey="tour_id"
            sourse_id="{$pvalTable}" rel="{$oneItem.is_online}" {if $oneItem.is_online ne 0}checked{/if}>
        </label>

      </div>
      <div class="tm-actions-row" role="group" aria-label="Tour actions">
        <a class="tm-btn tm-btn--neutral btn_preview_tour preview_tour_ex"
          {if $oneItem.is_trash eq 1}style="pointer-events: none;color: rgb(204, 204, 204);border-color: rgb(204, 204, 204);background-color: rgb(255, 255, 255);cursor: not-allowed;"{/if}
          data-href="{$clsTour->getLink($pvalTable)}" target="_blank"
          title="{$clsTour->getTitle($pvalTable)}">
          <i class="fa-regular fa-eye"></i>{$core->get_Lang('Preview')}
        </a>
        {* {if !$has_parent_id}
                    <div class="btn_online action_tour">
                        {if $oneItem.has_package eq 1}
                            <a class="tm-btn tm-btn--danger-outline is_has_package private_tour"
                                data-pkey="{$clsClassTable->pkey}" data-val="0" data-sourse_id="{$pvalTable}"
                                data-text_last="{$core->get_Lang('Not Package')}">
                                <i class="fa-solid fa-box-archive"></i>
                                {$core->get_Lang('Not Package')}
                            </a>
                        {else}
                            <a class="tm-btn tm-btn--primary is_has_package" data-pkey="{$clsClassTable->pkey}" data-val="1"
                                data-sourse_id="{$pvalTable}" data-text_last="{$core->get_Lang('Package')}">
                                <i class="fa-solid fa-box-archive"></i>
                                {$core->get_Lang('Package')}
                            </a>
                        {/if}
                    </div>
                {/if} *}
        {* <a class="tm-btn tm-btn--neutral ajDuplicateTour" id="btnClone"
                    data-name_services="{$clsTour->getTitle($pvalTable)}" tour_id="{$pvalTable}"
                    href="javascript:void(0);" data-confirm="{$core->get_lang('Confirm duplicate')}">
                    <i class="fa-regular fa-copy"></i>
                    {$core->get_Lang('Clone')}
                </a>
                <a class="tm-btn tm-btn--danger-outline confirm_delete" id="btnDelete"
                    data-confirm="{$core->get_lang('Confirm delete')}"
                    href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_id={$core->encryptID($pvalTable)}{$pUrl}">
                    <i class="fa-regular fa-trash-can"></i>
                    {$core->get_Lang('Delete')}
                </a> *}
      </div>
    </div>
  </header>
  <div class="tm-tour-workspace">

    <!-- TOUR SETUP NAV -->
    <aside class="tm-tour-setup" aria-label="Tour setup navigation">
      {* ======TOUR SETUP HEADER ======= *}
      <button type="button" class="tm-tour-setup__mobile-toggle" aria-expanded="false"> <span
          class="tm-tour-setup__mobile-title"> <i class="fa-solid fa-sliders"></i>
          <span>{$core->get_Lang('Tour Setup')}</span> </span> <i
          class="fa-solid fa-chevron-down tm-tour-setup__mobile-arrow"></i>
      </button>
      {* Desktop title *}
      <p class="tm-tour-setup__title"> {$core->get_Lang('Tour Setup')} </p>

      <nav class="tm-setup-nav">

        {foreach from=$list_menu_tour key=i item=menu}


          {assign var=icon value=$menu.icon}

          {assign var=cat_menu value=$menu.cat_menu}

          {assign var=child_cat_menu value=$menu.child}

          {* Kiểm tra menu cha có child đang active hay không *}

          {assign var=parent_active value=false}


          {foreach from=$child_cat_menu item=child_check}

            {if $child_check.id == $run_ajax}

              {assign var=parent_active value=true}

            {/if}

          {/foreach}

          <div class="tm-setup-group 
        {if $parent_active}is-open
        {/if}">

            {* ================= MENU CHA ================= *}
            <button type="button" class="tm-setup-parent" aria-expanded="
        {if $parent_active}true
        {else}false
        {/if}">
              <span class="tm-setup-parent__label">
                <i class="fa-solid {$icon} tm-setup-icon"></i>
                <span>{$core->get_Lang($cat_menu)}</span>
              </span>

              <i class="fa-solid fa-chevron-down tm-setup-parent__arrow"></i>
            </button>

            {* ================= MENU CON ================= *}
            <div class="tm-setup-submenu">


              {foreach from=$child_cat_menu key=j item=child}


                {assign var=check_result value=$checkTargetMap[$child.id]|default:'check_success'}

                <a class="tm-setup-item load-block 
          {if $child.id == $run_ajax}is-current
          {/if}" href="{$clsTour->getLinkEditAdmin($pvalTable, $cat_menu, $child.id)}" id="{$child.id}"
                  {if $child.id == $run_ajax}aria-current="page" {/if}>
                  <span class="tm-setup-item__label">
                    <i class="fa-solid {$child.icon} tm-setup-icon"></i>
                    <span>{$core->get_Lang($child.id)}</span>
                  </span>


                  {if $check_result == 'check_caution'}
                    <i class="fa-solid fa-triangle-exclamation tm-state-icon tm-state-icon--warning"></i>

                  {else}
                    <i class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>

                  {/if}
                </a>


              {/foreach}

            </div>

          </div>


        {/foreach}

      </nav>
    </aside>



    <!-- CONTENT -->
    <main class="tm-tour-content" id="overview">
      <div class="content_box_insert_tour">

      </div>
    </main>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all" />
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css?v={$upd_version}"
  media="all" />
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/html2canvas.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
{* <script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js?v={$upd_version}"></script> *}
<!-- Map -->
<link href="{$URL_JS}/mapbox/mapbox.css?v={$upd_version}" rel="stylesheet" />
<script src="{$URL_JS}/mapbox/mapbox.js?v={$upd_version}"></script>
<script src="{$URL_JS}/mapbox/leaflet-heat.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_JS}/mapbox/leaflet.css?v={$upd_version}" />
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
  <script type="text/javascript">
    $(function() {
      loadListDestination({/literal}{$pvalTable}{literal},"overview");
      $(window).scroll(function() {
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