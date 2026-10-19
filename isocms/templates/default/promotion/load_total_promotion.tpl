{if $type_op eq 'tour'}
    <div class="box_counter_tour">
        <i class="flaticon-009-flag"></i>
        <p class="counter_find_tour"><span class="counter">{$total_item}</span> {$core->get_Lang('Tours')}</p>
    </div>
{elseif $type_op eq 'cruise'}
    <div class="box_counter_cruise">
        <i class="flaticon-040-ship"></i>
        <p class="counter_find_cruise"><span class="counter">{$total_item}</span> {$core->get_Lang('Cruise')}</p>
    </div>
{elseif $type_op eq 'hotel'}
    <div class="box_counter_hotel">
        <i class="flaticon-026-hotel"></i>
        <p class="counter_find_hotel"><span class="counter">{$total_item}</span> {$core->get_Lang('Hotel')}</p>
    </div>
{else}
    <div class="box_counter_tour">
        <i class="flaticon-034-map"></i>
        <p class="counter_find_tour"><span class="counter">{$total_item}</span> {$core->get_Lang('Tours')}</p>
    </div>
    <div class="box_counter_cruise">
        <i class="flaticon-040-ship"></i>
        <p class="counter_find_cruise"><span class="counter">{$total_item}</span> {$core->get_Lang('Cruise')}</p>
    </div>
    <div class="box_counter_hotel">
        <i class="flaticon-026-hotel"></i>
        <p class="counter_find_hotel"><span class="counter">{$total_item}</span> {$core->get_Lang('Hotel')}</p>
    </div>
{/if}