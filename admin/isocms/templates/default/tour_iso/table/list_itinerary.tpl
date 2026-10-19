{if !empty($txt_warning)}
    <p style="font-size: 14px; color: #856404; background: #fff3cd; border: #ffeeba; padding: 5px; line-height: 150%;"><i
            class="fa-solid fa-triangle-exclamation"></i>
        {$core->get_Lang('The dates in the itinerary have not yet been entered')}: {$txt_warning}</p>
{/if}
{if !empty($lstItem)}
    {foreach from=$lstItem key=key item=item}
        <article id="order_{$item.tour_itinerary_id}" day2="{$item.day2}"
            class="tm-day-card {if $key%2 == 0}row1{else}row2{/if}">
            {* <button type="button" class="tm-day-card__handle" aria-label="Drag to reorder Day 4"><i
                    class="fa-solid fa-grip-vertical"></i></button> *}
            <div class="tm-day-card__number">
                <div class="tm-day-card__number-label">Day</div>
                <div class="tm-day-card__number-value">
                    {if $tourItem.duration_type == 0}
                        {if $tourItem.number_day == 1 && $tourItem.number_night <= 1}
                            <span class="day"><span>{$core->get_Lang('Full day')}</span></span>
                        {elseif $item.day==0}
                            <span class="day index">{$core->get_Lang('Setting')}</span>
                        {else}
                            <span class="day index">
                                <span>
                                    {$item.day}{if $item.day2 neq $item.day}-{$item.day2}{/if}
                                </span>
                            </span>
                        {/if}
                    {/if}
                </div>
                {* <div class="tm-day-card__date"><strong>15 Mar 2026</strong>Sun</div> *}
            </div>
            <div class="tm-day-card__image {if $item.is_show_image != 1}image_hidden{/if}">
                <img src="{$clsISO->tripslashImage($item.image, 60, 40)}" style="margin-right:5px" />
            </div>
            <div class="tm-day-card__body">
                <h3 class="tm-day-card__title">
                    <a href="javascript:void(0);" data="{$item.tour_itinerary_id}" class="clickEditItinerary">
                        {$item.title}
                    </a>
                </h3>
                <div class="tm-day-card__meals">
                    <i class="fa-solid fa-utensils"></i>
                    {$clsTourItinerary->getMeal($item.tour_itinerary_id, 1)}
                </div>
                {if $clsISO->getCheckActiveModulePackage($package_id, 'tour', 'hotel', 'customize') && $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default') && $clsTourItinerary->getItineraryHotel($tour_id, $item.tour_itinerary_id, 1)}
                    <div class="tm-day-card__meals">
                        <i class="fa-solid fa-hotel"></i>
                        {$clsTourItinerary->getItineraryHotel($tour_id, $item.tour_itinerary_id)}
                    </div>
                {/if}
                <p class="tm-day-card__desc">{$clsTourItinerary->getContent($item.tour_itinerary_id, 20)}</p>
            </div>
            <div class="tm-day-card__side">
                <div class="btn-group">
                    <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item clickEditItinerary" title="{$core->get_Lang('edit')}" href="#"
                                data="{$item.tour_itinerary_id}">
                                <i class="icon-edit"></i> {$core->get_Lang('edit')}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item clickDeleteItinerary" title="{$core->get_Lang('delete')}" href="#"
                                data="{$item.tour_itinerary_id}">
                                <i class="icon-remove"></i> {$core->get_Lang('delete')}
                            </a>
                        </li>
                    </ul>
                </div>
                {* <button type="button" class="tm-day-card__expand" aria-label="Expand Day 4 description"
                    aria-expanded="false"><i class="fa-solid fa-chevron-down"></i></button> *}
            </div>
        </article>
    {/foreach}
    <!-- ADD ANOTHER DAY -->
    <a class="tm-add-day" href="javascript:void(0);" id="clickToAddItinerary">
        <span class="tm-add-day__label"><i class="fa-solid fa-circle-plus"></i> {$core->get_Lang('Add another day')}</span>
        <span class="tm-add-day__hint">{$core->get_Lang('Continue building your itinerary with more experiences')}</span>
    </a>
{else}

    <!--
        EMPTY STATE (hidden by default — show only when the backend
        returns zero itinerary days; do not fake data)
        -->
    <div class="tm-itinerary-empty" id="itineraryEmptyState">
        <i class="fa-regular fa-calendar-xmark" aria-hidden="true"></i>
        <h3>{$core->get_Lang('No itinerary days yet')}</h3>
        <p>{$core->get_Lang('Start building your journey by adding the first day.')}</p>
        <a class="tm-btn tm-btn--add-day" href="javascript:void(0);" id="clickToAddItinerary">
            <i class="fa-solid fa-plus"></i> {$core->get_Lang('Add first day')}
        </a>
    </div>
{/if}