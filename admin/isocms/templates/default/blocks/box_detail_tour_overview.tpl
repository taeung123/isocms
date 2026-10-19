<!-- READINESS -->
<section class="tm-readiness" aria-label="Tour readiness">
  <span class="tm-readiness__icon" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
  <div class="tm-readiness__text">
    <h3>{$core->get_Lang("Great! Your tour is ready")}</h3>
    <p>
      {$core->get_Lang("Complete the remaining sections below to make your tour more attractive and drive more bookings.")}
    </p>
  </div>
  <div class="tm-readiness__settings" id="visibilitySettings">
    <div class="tm-readiness__setting" id="publicSetting">
      {$core->get_Lang("Public")}
      <label class="tm-toggle"><span class="visually-hidden">Toggle public</span>
        <input type="checkbox" class="SiteClickPublic togglePublicTop" clsTable="Tour" pkey="tour_id"
          sourse_id="{$pvalTable}" rel="{$oneItem.is_online}" {if $oneItem.is_online ne 0}checked{/if}>
      </label>

    </div>
    <div class="tm-readiness__setting" id="topTripSetting">
      {$core->get_Lang("Top trip")}
      <label class="tm-toggle">
        <span class="visually-hidden">Toggle top trip</span>
        <input type="checkbox" {if $is_top_trip==1}checked{/if} value="1" id="id_top_des" class="iso_radio_switch"
          data-type="TOPTOUR">
      </label>
      <span class="tm-disabled-note">{$core->get_Lang("Requires Public")}</span>
    </div>
    <div class="tm-readiness__setting">
      {$core->get_Lang("Tour departure")}
      <label class="tm-toggle">
        <span class="visually-hidden">Toggle tour departure</span>
        <input type="checkbox" {if $is_tour_departure==1}checked{/if} value="1" id="id_departure_point"
          class="iso_radio_switch" data-type="DEPARTURE">
    </div>
  </div>
</section>

<!-- RECOMMENDATIONS -->
<section class="tm-card" aria-label="Tour information recommendations">
  <div class="tm-card__header">
    <div class="tm-card__heading">
      <span class="tm-card__icon" aria-hidden="true"><i class="fa-solid fa-lightbulb"></i></span>
      <div class="tm-card__titles">
        <h3>{$core->get_Lang("Tour information recommendations")} <i class="fa-regular fa-circle-question"
            title="Complete every section to maximize visibility"></i></h3>
        <p>{$core->get_Lang("Fill out the following sections to make your tour complete and attractive")}</p>
      </div>
    </div>
    <div class="tm-progress-meta">
      <span class="tm-progress-meta__label">{$successCount}/{$totalCount} {$core->get_Lang("completed")}</span>
      <div class="tm-progress-bar">
        <div class="tm-progress-bar__fill" style="width:{$successPercent}%"></div>
      </div>
      <span class="tm-progress-note">{$core->get_Lang("Good progress!")}</span>
    </div>
  </div>
  {assign var="check_targets" value=$list_check_target|@json_decode}


  <div class="tm-recommend-grid">
    {foreach from=$check_targets item=item}
      {if $item->result == 'check_caution'}
        <a class="tm-recommend-item"
          href="{$clsTour->getLinkEditAdmin($pvalTable, $item->cat|escape:'html', $item->target|escape:'html')}">
          <span class="tm-recommend-item__label">
            <span class="tm-recommend-item__icon">
              <i class="fa-solid fa-circle-exclamation"></i>
            </span>

            {$item->name|escape:'html'}
          </span>

          <i class="fa-solid fa-chevron-right"></i>
        </a>
      {/if}
    {/foreach}

  </div>
</section>

<!-- ROW: Tour style / Media / Description -->
<div class="tm-tour-grid">
  <section class="tm-card" aria-label="Tour style">
    <div class="tm-card__header">
      <div class="tm-card__heading">
        <span class="tm-card__icon tm-card__icon--blue"><i class="fa-solid fa-compass"></i></span>
        <div class="tm-card__titles">
          <h3>{$core->get_Lang("Tour style")}</h3>
        </div>
      </div>
    </div>
    <dl class="tm-deflist">
      <div class="tm-deflist__row">
        <dt><a href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/option-tour">{$core->get_Lang("Travel style")}</a>
        </dt>
        {if $lst_travel_style_overview }
          <dd>
            {section name=i loop=$lst_travel_style_overview}
              {$clsTourCategory->getTitle($lst_travel_style_overview[i])}{if !$smarty.section.i.last};{/if}
            {/section}
          </dd>
        {else}
          <dd>{$core->get_Lang('No Travel style selected')}</dd>
        {/if}
      </div>
      <div class="tm-deflist__row">
        <dt><a href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/option-tour">{$core->get_Lang("Tag")}</a></dt>
        {if $lst_tag_overview }
          <dd>
            {section name=i loop=$lst_tag_overview}
              {$clsTag->getTitle($lst_tag_overview[i])}{if !$smarty.section.i.last};{/if}
            {/section}
          </dd>
        {else}
          <dd>{$core->get_Lang('No Tag selected')}</dd>
        {/if}
      </div>
      <div class="tm-deflist__row">
        <dt><a href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/option-tour">{$core->get_Lang("Departure point")}</a>
        </dt>
        {if $lst_departure_point_overview }
          <dd>
            {section name=i loop=$lst_departure_point_overview}
              {$clsCity->getTitle($lst_departure_point_overview[i])}{if !$smarty.section.i.last};{/if}
            {/section}
          </dd>
        {else}
          <dd>{$core->get_Lang('No Departure point selected')}</dd>
        {/if}
      </div>
      {if $clsISO->getCheckActiveModulePackage($package_id,'property','activities','default')}
        <div class="tm-deflist__row">
          <dt><a href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/activities-tour">{$core->get_Lang("Activities level")}</a>
          </dt>
          {if $lst_activities_overview }
            <dd>
              {section name=i loop=$lst_activities_overview}
                {$clsActivities->getTitle($lst_activities_overview[i])}{if !$smarty.section.i.last};{/if}
              {/section}
            </dd>
          {else}
            <dd>{$core->get_Lang('No Activities tour selected')}</dd>
          {/if}
        </div>
      {/if}
      <div class="tm-deflist__row">
        <dt> <a href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/duration-tour">{$core->get_Lang("Duration")}</a>
        </dt>
        {if $oneItem.number_day>0 || $oneItem.number_night>0 || $oneItem.dra_hours>0 || $oneItem.dra_min>0}
          <dd>{$oneItem.number_day} {$core->get_Lang('days')} {$oneItem.number_night} {$core->get_Lang('nights')}
            {if $oneItem.dra_hours>0}{$oneItem.dra_hours} {$core->get_Lang('Hours')}{/if}
            {if $oneItem.dra_min>0}{$oneItem.dra_min} {$core->get_Lang('Minutes')}{/if}</dd>
        {else}
          <dd>{$core->get_Lang('No Duration selected')}</dd>
        {/if}

      </div>
      <div class="tm-deflist__row">
        <dt><a
            href="{$PCMS_URL}/tour/edit/{$pvalTable}/configuration/related_tours">{$core->get_Lang("Tour related")}</a>
        </dt>
        {if $count_relate>0}
          <dd>{$count_relate} {$core->get_Lang('tour related for this tour')}</dd>
        {else}
          <dd>{$core->get_Lang('No tour related selected')}</dd>
        {/if}
      </div>
    </dl>
  </section>

  <section class="tm-card" aria-label="Media">
    <div class="tm-card__header">
      <div class="tm-card__heading">
        <span class="tm-card__icon tm-card__icon--blue"><i class="fa-regular fa-image"></i></span>
        <div class="tm-card__titles">
          <h3>{$core->get_Lang('Media')}</h3>
        </div>
      </div>
    </div>
    <p class="tm-media-label">{$core->get_Lang('Cover image')}</p>
    <div class="tm-media-cover">
      {if $oneItem.image}
        <a href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/image-file-tour"><img
            src="{$clsClassTable->getImage($oneItem.tour_id,253,168)}" alt="{$clsTour->getTitle($oneItem.tour_id)}"></a>
      {else}
        <p>{$core->get_Lang('No cover image selected')}</p>
      {/if}
    </div>
    <p class="tm-media-label">{$core->get_Lang('Gallery')}</p>
    <div class="tm-gallery-grid">
      {if $lstItemGalleryn}
        {assign var="totalGallery" value=$lstItemGalleryn|@count}
        {assign var="remainingGallery" value=$totalGallery-3}
        {section name=i loop=$lstItemGalleryn max=3}
          <div class="tm-gallery-item">
            <img src="{$clsTourImage->getImage($lstItemGalleryn[i].tour_image_id,146,97)}"
              alt="{$lstItemGalleryn[i].title}">
          </div>
        {/section}
      {/if}
      {if $remainingGallery > 0}
        <a class="tm-gallery-item tm-gallery-item--more"
          href="{$PCMS_URL}/tour/edit/{$pvalTable}/configuration/image-gallery" aria-label="View 2 more photos">
          <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=200&h=200&fit=crop" alt="">
          <span>+{$remainingGallery}</span>
        </a>
      {/if}
    </div>
  </section>

  <section class="tm-card" aria-label="Description tour">
    <div class="tm-card__header">
      <div class="tm-card__heading">
        <span class="tm-card__icon tm-card__icon--blue"><i class="fa-regular fa-file-lines"></i></span>
        <div class="tm-card__titles">
          <h3>{$core->get_Lang('Description Tour')}</h3>
        </div>
      </div>
    </div>
    <div class="tm-checklist">
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/overview-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang('Highlight')}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/inclusion-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang('Inclusions')}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/exclusion-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang('Exclusions')}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/whatcarry-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang("What's to carry")}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/cancellation_policy-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang('Cancellation policy')}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/refund-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang('Refund')}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
      <a class="tm-checklist-item" href="{$PCMS_URL}/tour/edit/{$pvalTable}/basic/confirmation-policy-tour">
        <span class="tm-checklist-item__label"><i
            class="fa-solid fa-circle-check tm-state-icon tm-state-icon--done"></i>
          {$core->get_Lang('Confirmation Policy')}</span>
        <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>
  </section>
</div>

<!-- ROW: Itinerary / Destination / Service -->
<div class="tm-tour-grid tm-tour-grid--row2">
  <section class="tm-card" aria-label="Itinerary">
    <div class="tm-card__header">
      <div class="tm-card__heading">
        <span class="tm-card__icon tm-card__icon--blue"><i class="fa-solid fa-map"></i></span>
        <div class="tm-card__titles">
          <h3>Itinerary</h3>
        </div>
      </div>
      <a href="{$PCMS_URL}/tour/edit/{$pvalTable}/itinerary/itinerary" class="tm-btn tm-btn--neutral"
        id="btnItineraryDetail">View detail</a>
    </div>
    <div class="table-responsive" style="overflow-x:auto;">
      {if $lstItemIti}
        <table class="tm-itinerary-table">
          <thead>
            <tr>
              <th class="col-day">Day</th>
              <th>Title</th>
            </tr>
          </thead>
          <tbody>


            {section name=i loop=$lstItemIti}
              <tr>
                <td><span class="tm-day-badge">{$clsTourItinerary->getTripDay($lstItemIti[i].tour_itinerary_id)}</span></td>
                <td class="tm-itinerary-title">{$clsTourItinerary->getTitle($lstItemIti[i].tour_itinerary_id)}</td>
              </tr>

            {/section}

          </tbody>
        </table>

      {else}
        <p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>

      {/if}
    </div>
  </section>

  <section class="tm-card" aria-label="Destination">
    <div class="tm-card__header">
      <div class="tm-card__heading">
        <span class="tm-card__icon tm-card__icon--blue"><i class="fa-solid fa-location-dot"></i></span>
        <div class="tm-card__titles">
          <h3>{$core->get_Lang('Destination')}</h3>
        </div>
      </div>
    </div>
    <div class="list-group tm-destination-list" id="lstDestination">
    </div>
    <a href="{$PCMS_URL}/tour/edit/{$pvalTable}/destination/destination" class="tm-btn-block" id="btnAddDestination"><i
        class="fa-solid fa-plus"></i> {$core->get_Lang('Add destination')}</a>
  </section>
  {if $clsISO->getCheckActiveModulePackage($package_id,'property','service','default')}
    <section class="tm-card" aria-label="Service">
      <div class="tm-card__header">
        <div class="tm-card__heading">
          <span class="tm-card__icon tm-card__icon--blue"><i class="fa-solid fa-gears"></i></span>
          <div class="tm-card__titles">
            <h3>{$core->get_Lang('Service')}</h3>
          </div>
        </div>
      </div>
      <p class="tm-service-label">{$core->get_Lang('All service select in this tour')}</p>
      {if $lst_service_overview}
        <table class="tm-itinerary-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>price</th>
            </tr>
          </thead>
          <tbody>
            {section name=i loop=$lst_service_overview}
              <tr>
                <td>{$clsAddOnService->getTitle($lst_service_overview[i])}</td>
                {if $_LANG_ID == 'en'}
                  <td style="width:70px">{$clsISO->getShortRate()}{$clsAddOnService->getPrice($lst_service_overview[i])}
                  </td>
                {elseif $_LANG_ID == 'vn' }
                  <td style="width:70px">{$clsAddOnService->getPrice($lst_service_overview[i])}{$clsISO->getShortRate()}
                  </td>
                {/if}
              </tr>
            {/section}

          </tbody>
        </table>
      {else}
        <div class="tm-empty-state">
          <i class="fa-solid fa-circle-info"></i>
          <span>{$core->get_Lang('No service selected')}</span>
        </div>
      {/if}

      <a href="{$PCMS_URL}/tour/edit/{$pvalTable}/configuration/add-on-services" class="tm-btn-block"
        id="btnAddService"><i class="fa-solid fa-plus"></i> {$core->get_Lang('Add service')}</a>
    </section>
  {/if}
</div>
<script type="text/javascript">
  var pcsm_ovv = `{$PCMS|default:''}`;
  var pvalTable_ovv = {$pvalTable};
  var list_check_target = {$list_check_target};
</script>
{literal}
  <script type="text/javascript">
    $(function() {
      loadListDestination({/literal}{$pvalTable}{literal},"overview");
      $("#tour_info_re").hide();
      jQuery.each(list_check_target, function(i, val) {
        if (val['result'] == 'check_success') {} else if (val['result'] == 'check_caution') {
          if (val['target'] == 'promotion') {
            $(".link_caution_up .list_link").append('<li><a href="' + pcsm_ovv +
              '/admin/?mod=discount" data-type="promotion">' + val['name'] +
              ' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');
          } else {
            $(".link_caution_up .list_link").append('<li><a href="' + pcsm_ovv + '/admin/tour/edit/' +
              pvalTable_ovv + '/' + val['cat'] + '/' + val['target'] + '">' + val['name'] +
              ' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');
          }

          $("#tour_info_re").show();
        } else {
          $("#tour_info_re").hide();
        }
      });
      $(document).on('click', '.extend', function(ev) {
        var _this = $(this);
        _this.addClass('unextend').removeClass('extend').find('.fa-plus').addClass('fa-minus').removeClass(
          'fa-plus');
        _this.closest('.box_notice').find('.box_title_action').addClass('open');
        _this.closest('.box_notice').find('.box_content_overview').addClass('in');
      });
      $(document).on('click', '.unextend', function(ev) {
        var _this = $(this);
        _this.addClass('extend').removeClass('unextend').find('.fa-minus').addClass('fa-plus').removeClass(
          'fa-minus');
        _this.closest('.box_notice').find('.box_title_action').removeClass('open');
        _this.closest('.box_notice').find('.box_content_overview').removeClass('in');
      })
    })
  </script>
{/literal}
