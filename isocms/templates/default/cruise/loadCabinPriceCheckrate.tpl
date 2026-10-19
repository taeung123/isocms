{assign var=first_index value=true}
{assign var="no_cabin_items" value=[]}
{assign var="w" value=612}
{assign var="h" value=($deviceType == "computer")?458:200}
{if isset($cruise.cruie_type) && $cruise.cruie_type ne 2 && $lstCruiseCabinID}
    {foreach from=$lstCruiseCabinID item=item name=item}
        {assign var=cruise_cabin_id value=$item.cruise_cabin_id}
        {assign var=title_cabin value=$clsCruiseCabin->getTitle($cruise_cabin_id)}
        {assign var=max_adult value=$clsCruiseCabin->getMaxAdult($cruise_cabin_id)}
        {assign var=cabinSize value=$clsCruiseCabin->getCabinSize($cruise_cabin_id)}
        {assign var=bed_size value=$clsCruiseCabin->getBedOption($cruise_cabin_id)}
        {assign var=arr_price_cabin value = $clsCruiseCabin->getArrayPriceCabinCruise($cruise_cabin_id,$arraycheckrateCabin,$promotion_date,$cruise_id)}
        {assign var=intro_cabin value = $clsCruiseCabin->getIntro($cruise_cabin_id)}
        {assign var=facilities_cabin value = $clsCruiseCabin->getCabinFaci($cruise_cabin_id,$item)}
        {assign var=list_cabin_check value = $item.compare_price}
        {assign var=list_total_price value = $item.total_price}

        {if $item.number_cabin}
            {if $first_index}
                <div class="lowest_price_available"><i class="fa-sharp fa-solid fa-star"></i> {$core->get_Lang("Lowest price available")}!</div>
            {/if}
            <div class="box_item_cabin {if $first_index}box_item_cabin_first{/if}">
                <div class="box_left_item_cabin d-flex flex-wrap">
                    <div class="box_info_cabin">
                        <img class="box_info_cabin_img" src="{$clsCruiseCabin->getImage($cruise_cabin_id,204,173)}">
                        <div>
                            {assign var=total_cabin value=$clsCruiseCabin->getTotalCabin($cruise_cabin_id)}
                            <h3 class="title_cabin">{$title_cabin} {if $total_cabin >0}<span class="text_normal size16">
                                    ({$total_cabin} {$core->get_Lang('Cabin')}{if $total_cabin>1}s{/if})</span>{/if}</h3>
                            <div class="cabin_itinerary">
                                {if $max_adult}
                                    <p class="item_info_cabin icon_cruise_before number_person">{$max_adult} {$core->get_Lang('pax')}</p>{/if}
                                {if $cabinSize}<p class="item_info_cabin icon_cruise_before area_cabin">{$cabinSize} m2</p>{/if}
                                {if $bed_size}<p class="item_info_cabin icon_cruise_before bed_cabin">{$bed_size}</p>{/if}
                            </div>
                            {if $facilities_cabin}<p
                                    class="item_info_cabin icon_cruise_before meals_cabin"><i class="fa-solid fa-check me-1"></i> {$facilities_cabin}</p>{/if}
                            <p class="item_info_cabin icon_cruise_before promotion_cabin"><i class="fa-solid fa-check me-1"></i> {$core->get_Lang('Prices include VAT')}</p>
                            <a class="btn_textCabinDetail collapsed" href="javascript:void(0)" role="button"
                               data-bs-toggle="modal"
                               data-bs-target="#roomModalB{$cruise_cabin_id}"><i class="fa-light fa-circle-plus"></i> {$core->get_Lang('Cabin Detail')}</a>
                        </div>
                    </div>
                    <div class="box_price_cruise">
                        {foreach from=$list_cabin_check item=cabin name=cabinLoop}
                            <div class="box_item_room_cabin">
                                <h4 class="name_room_cabin">
                                    {$core->get_Lang('Cabin')} {$smarty.foreach.cabinLoop.iteration} : {$cabin.bed_type}
                                </h4>

                                <p class="group_size_room_cabin">
                                    {$core->get_Lang('Adult')} {$cabin.number_adult}
                                    {if !$price_by && isset($item.check_contact_total) && !$item.check_contact_total} 
                                        x {$cabin.txt_price_adult}
                                    {/if}
                                </p>

                                {if $number_child gt 0 && isset($cabin.lst_child) && $cabin.lst_child|@count}
                                    {foreach from=$cabin.lst_child item=child}
                                        {if $child.str_age}
                                            <p class="group_size_room_cabin">
                                                {$core->get_Lang('Children')} {$child.number_child} ({$child.str_age})
                                                {if !$price_by && isset($item.check_contact_total) && !$item.check_contact_total} 
                                                    x {$child.txt_price_child}
                                                {/if}
                                            </p>
                                        {/if}
                                    {/foreach}
                                {/if}

                                {if $cabin.is_extra_bed == 1}
                                    <p class="group_size_room_cabin">
                                        {$core->get_Lang('Extra Bed')} {$cabin.txt_price_extra_bed}
                                    </p>
                                {/if}
                            </div>
                        {/foreach}

                    </div>
                    <div class="box_book_cabin">
                        {if isset($item.check_contact_total) && $item.check_contact_total == 1}
                            <p class="total_price">{$core->get_Lang('Contact')}</p>
                        {else}
                            {if $_LANG_ID eq 'vn'}
                                <p class="txt_total_price">{$core->get_Lang("Total price")} {if isset($list_total_price.promotion) && $list_total_price.promotion eq 1}
                                        <del>{$clsISO->formatPrice($list_total_price.total_price)} {$clsISO->getRate()}</del>{/if}
                                </p>
                                <p class="total_price">{$clsISO->formatPrice($list_total_price.total_price_promotion)}<span
                                            class="price_unit"> {$clsISO->getRate()}</span></p>
                            {else}
                                <p class="txt_total_price">{$core->get_Lang("Total price")} {if $list_total_price.promotion eq 1}
                                        <del> {$clsISO->getRate()} {$clsISO->formatPrice2($list_total_price.total_price,2)}</del>{/if}
                                </p>
                                <p class="total_price"><span
                                            class="price_unit">{$clsISO->getRate()} </span>{$clsISO->formatPrice2($list_total_price.total_price_promotion,2)}
                                </p>
                            {/if}
                            <p class="text_vat">{$core->get_Lang('Price includes taxes and fees')}</p>
                        {/if}
                        {if isset($item.check_contact_total) && $item.check_contact_total == 1}
                            <form action="" method="post">
                                <input type="hidden" name="cruise_id" value="{$cruise_id}">
                                <input type="hidden" name="ContactCruise" value="ContactCruise">
                                <button class="btn_contact" type="submit">{$core->get_Lang('Contact')}</button>
                            </form>
                        {else}
                            <button class="btn_book_cabin" type="button">{$core->get_Lang('Book now')}</button>
                        {/if}
                        <p class="txt_contact">{$core->get_Lang('Do you need advice')}?
                            <a href="{$clsISO->getLink("contact")}" class="btn_contact_cabin" type="button">{$core->get_Lang('Contact')}</a>
                        </p>
                        <input type="hidden" name="cruise_id" value="{$cruise_id}">
                        <input type="hidden" name="departure_date" value="{$departure_date}">
                        <input type="hidden" name="cruise_itinerary_id" value="{$cruise_itinerary_id}">
                        <input type="hidden" name="cruise_cabin_id" value="{$cruise_cabin_id}">
                        <input type="hidden" name="number_adult" value="{$number_adult}">
                        <input type="hidden" name="number_child" value="{$number_child}">
                        <input type="hidden" name="number_cabin" value="{$number_cabin}">
                        <input type="hidden" name="children" value='{$str_children}'>
                        <input type="hidden" name="str_total_price" value='{$item.str_total_price}'>
                        <input type="hidden" name="str_compare_price" value='{$item.str_compare_price}'>
                        <input type="hidden" name="discount_type" value="{$discount_type|default:''}">
                        <input type="hidden" name="discount_value" value="{$discount_value|default:0}">
                        <input type="hidden" name="check_contact_total" value="{$item.check_contact_total|default:0}">
                    </div>
                </div>
                <div class="modal fade roomModal" id="roomModalB{$cruise_cabin_id}" tabindex="-1" role="dialog"
                     aria-labelledby="roomModalLabel" aria-hidden="false">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content" id="container-room-detail">
                            <div class="modal-header">
                                <h4 class="modal-title text-uppercase" id="roomModalLabel">{$title_cabin}</h4>
                                <button type="button" class="btn-close c6" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="f-carousel cabinCarousel">
                                            {assign var="cruise_cabin_img" value=$clsCruiseCabin->getImage($cruise_cabin_id,$w,$h)}
                                            <div class="f-carousel__slide"
                                                 data-thumb-src="{$cruise_cabin_img}">
                                                <img alt="{$title_cabin}"
                                                     data-lazy-src="{$cruise_cabin_img}" width="{$w}"
                                                     height="{$h}"/>
                                            </div>
                                            {assign var=listCabinGallery value=$clsCabinImage->getAll("table_id='$cruise_cabin_id'", "cabin_image_id, image")}
                                            {if !empty($listCabinGallery)}
                                                {section name=i loop=$listCabinGallery}
                                                    <div class="f-carousel__slide"
                                                         data-thumb-src="{$clsISO->tripslashImage($listCabinGallery[i].image, $w, $h)}">
                                                        <img width="{$w}" height="{$h}" alt="img" data-lazy-src="{$clsISO->tripslashImage($listCabinGallery[i].image, $w, $h)}"/>
                                                    </div>
                                                {/section}
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="m-item">
                                            <h5><span>{$core->get_Lang('DESCRIPTION')}</span></h5>
                                            <div class="m-content">
                                                {assign var=floor value=$clsCruiseCabin->getOneField('floor',$cruise_cabin_id)}
                                                {if $cabinSize}<p><strong>{$core->get_Lang('Cabin size')}
                                                        :</strong> {$cabinSize} m<sup>2</sup></p>{/if}
                                                {if $bed_size}<p>
                                                    <strong>{$core->get_Lang('Bed options')}:</strong>
                                                    {$bed_size}</p>{/if}
                                                {if $max_adult}<p>
                                                    <strong>{$core->get_Lang('Max Adults')}:</strong>
                                                    {$max_adult} {$core->get_Lang('pax')}</p>{/if}
                                                <p><strong>{$core->get_Lang('Extra Bed')}
                                                        :</strong> {if $clsCruiseCabin->getOneField('extra_bed',$cruise_cabin_id)==1}{$core->get_Lang('Yes')}{else}{$core->get_Lang('No')}{/if}
                                                </p>
                                                {if $floor}<p><strong>{$core->get_Lang('Floor')}:</strong>{$floor}</p>{/if}
                                            </div>
                                        </div>
                                        {assign var=info_cabin value=$clsCruiseCabin->getIntro($cruise_cabin_id)}
                                        {assign var=easy_cancel value=$clsCruiseCabin->getEasyCancel($cruise_cabin_id)}
                                        {assign var=CabinFa value=$clsCruiseCabin->getCabinFa($cruise_cabin_id,$item)}
                                        {if $info_cabin}
                                            <div class="m-item-text">
                                                <h5><span>{$core->get_Lang('Cabin Infor')}</span></h5>
                                                <div class="m-content-text">
                                                    {$info_cabin}
                                                </div>
                                            </div>
                                        {/if}
                                        {if $easy_cancel}
                                            <div class="m-item-text">
                                                <h5><span>{$core->get_Lang('Easy Cancel')}</span></h5>
                                                <div class="m-content-text">
                                                    {$easy_cancel}
                                                </div>
                                            </div>
                                        {/if}
                                        {if $CabinFa}
                                            <div class="m-item mt-3">
                                                <h5><span>{$core->get_Lang('Cabin Facilities')}</span></h5>
                                                <div class="m-content">
                                                    {$clsCruiseCabin->getCabinFa($cruise_cabin_id,$item)}
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {assign var=first_index value=false}
        {else}
            {append var="no_cabin_items" value=$item}
        {/if}
    {/foreach}
    {foreach from=$no_cabin_items item=item}
        {assign var=cruise_cabin_id value=$item.cruise_cabin_id}
        {assign var=title_cabin value=$clsCruiseCabin->getTitle($cruise_cabin_id)}
        {assign var=max_adult value=$clsCruiseCabin->getMaxAdult($cruise_cabin_id)}
        {assign var=cabinSize value=$clsCruiseCabin->getCabinSize($cruise_cabin_id)}
        {assign var=bed_size value=$clsCruiseCabin->getBedOption($cruise_cabin_id)}
        <div class="box_item_cabin no_cabin_item">
            <div class="box_left_item_cabin d-flex">
                <div class="box_info_cabin">
                    <img class="box_info_cabin_img" src="{$clsCruiseCabin->getImage($cruise_cabin_id,204,114)}">
                    <div class="div_title_cabin">
                        <h3 class="title_cabin">{$title_cabin} {if $total_cabin >0}<span class="text_normal size16">
                                ({$total_cabin} {$core->get_Lang('Cabin')}{if $total_cabin>1}s{/if})</span>{/if}</h3>
                        <div class="cabin_itinerary">
                            {if $max_adult}<p
                                    class="item_info_cabin icon_cruise_before number_person">{$max_adult} {$core->get_Lang('pax')}</p>{/if}
                            {if $cabinSize}<p class="item_info_cabin icon_cruise_before area_cabin">{$cabinSize} m2</p>{/if}
                            {if $bed_size}<p class="item_info_cabin icon_cruise_before bed_cabin">{$bed_size}</p>{/if}
                        </div>
                    </div>
                </div>
                <div class="sold_out px-4">
                    <div class="w-100 d-md-block d-none" style="transform: rotate(-14.002deg);"><span class="title_sold_out">{$core->get_Lang("Sold out")}</span></div>
                    <p class="noti_sold_out">{$core->get_Lang("The room is sold out for the period you selected. You can")} <a href="{$clsISO->getLink("contact")}" class="contact_us_span">{$core->get_Lang("Contact Us")}</a> {$core->get_Lang("to reserve this favorite room")}</p>
                </div>
            </div>
        </div>
    {/foreach}
{else}
    <div class="lowest_price_available"><i class="fa-sharp fa-solid fa-star"></i> {$core->get_Lang("Lowest price available")}!</div>
    <div class="box_item_cabin box_item_cabin_first">
        <div class="box_left_item_cabin d-flex flex-wrap">
            <div class="box_info_cabins">
            {foreach from=$cabins item=item name=cabin}
                {assign var=cruise_cabin_id value=$item.cruise_cabin_id}
                {assign var=title_cabin value=$clsCruiseCabin->getTitle($cruise_cabin_id)}
                {assign var=max_adult value=$clsCruiseCabin->getMaxAdult($cruise_cabin_id)}
                {assign var=cabinSize value=$clsCruiseCabin->getCabinSize($cruise_cabin_id)}
                {assign var=bed_size value=$clsCruiseCabin->getBedOption($cruise_cabin_id)}
                {assign var=facilities_cabin value = $clsCruiseCabin->getCabinFaci($cruise_cabin_id,$item)}
                    <div class="box_info_cabin">
                        <img class="box_info_cabin_img" src="{$clsCruiseCabin->getImage($cruise_cabin_id,204,173)}">
                        <div>
                            {assign var=total_cabin value=$clsCruiseCabin->getTotalCabin($cruise_cabin_id)}
                            <h3 class="title_cabin">
                                {$title_cabin}
                                {if $total_cabin > 0}
                                    <span class="text_normal size16">({$total_cabin} {$core->get_Lang('Cabin')}{if $total_cabin>1}s{/if})</span>
                                {/if}
                            </h3>
                            <div class="cabin_itinerary">
                                {if $max_adult}
                                    <p class="item_info_cabin icon_cruise_before number_person">
                                        {$max_adult} {$core->get_Lang('pax')}
                                    </p>
                                {/if}
                                {if $cabinSize}
                                    <p class="item_info_cabin icon_cruise_before area_cabin">
                                        {$cabinSize} m2
                                    </p>
                                {/if}
                                {if $bed_size}
                                    <p class="item_info_cabin icon_cruise_before bed_cabin">
                                        {$bed_size}
                                    </p>
                                {/if}
                            </div>
                            {if $facilities_cabin}
                                <p class="item_info_cabin icon_cruise_before meals_cabin"><i class="fa-solid fa-check me-1"></i>
                                    {$facilities_cabin}
                                </p>
                            {/if}
                            <p class="item_info_cabin icon_cruise_before promotion_cabin">
                                <i class="fa-solid fa-check me-1"></i>
                                {$core->get_Lang('Prices include VAT')}
                            </p>
                            <a class="btn_textCabinDetail collapsed" href="javascript:void(0)" role="button"
                               data-bs-toggle="modal" data-bs-target="#roomModalB{$cruise_cabin_id}">
                                {$core->get_Lang('Cabin Detail')} <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                <div class="modal fade roomModal" id="roomModalB{$cruise_cabin_id}" tabindex="-1" role="dialog"
                     aria-labelledby="roomModalLabel" aria-hidden="false">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content" id="container-room-detail">
                            <div class="modal-header">
                                <h4 class="modal-title text-uppercase" id="roomModalLabel">{$title_cabin}</h4>
                                <button type="button" class="btn-close c6" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="f-carousel cabinCarousel">
                                            {assign var="cruise_cabin_img" value=$clsCruiseCabin->getImage($cruise_cabin_id,$w,$h)}
                                            <div class="f-carousel__slide"
                                                 data-thumb-src="{$cruise_cabin_img}">
                                                <img alt="{$title_cabin}"
                                                     data-lazy-src="{$cruise_cabin_img}" width="{$w}"
                                                     height="{$h}"/>
                                            </div>
                                            {assign var=listCabinGallery value=$clsCabinImage->getAll("table_id='$cruise_cabin_id'", "cabin_image_id, image")}
                                            {if !empty($listCabinGallery)}
                                                {section name=i loop=$listCabinGallery}
                                                    <div class="f-carousel__slide"
                                                         data-thumb-src="{$clsISO->tripslashImage($listCabinGallery[i].image, $w, $h)}">
                                                        <img width="{$w}" height="{$h}" alt="img" data-lazy-src="{$clsISO->tripslashImage($listCabinGallery[i].image, $w, $h)}"/>
                                                    </div>
                                                {/section}
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="m-item">
                                            <h5><span>{$core->get_Lang('DESCRIPTION')}</span></h5>
                                            <div class="m-content">
                                                {assign var=floor value=$clsCruiseCabin->getOneField('floor',$cruise_cabin_id)}
                                                {if $cabinSize}
                                                    <p>
                                                        <strong>{$core->get_Lang('Cabin size')}:</strong>
                                                        {$cabinSize} m<sup>2</sup>
                                                    </p>
                                                {/if}
                                                {if $bed_size}
                                                    <p>
                                                        <strong>{$core->get_Lang('Bed options')}:</strong>
                                                        {$bed_size}
                                                    </p>
                                                {/if}
                                                {if $max_adult}
                                                    <p>
                                                        <strong>{$core->get_Lang('Max Adults')}:</strong>
                                                        {$max_adult} {$core->get_Lang('pax')}
                                                    </p>
                                                {/if}
                                                <p>
                                                    <strong>{$core->get_Lang('Extra Bed')}:</strong>
                                                    {if $clsCruiseCabin->getOneField('extra_bed',$cruise_cabin_id) eq 1}
                                                        {$core->get_Lang('Yes')}
                                                    {else}
                                                        {$core->get_Lang('No')}
                                                    {/if}
                                                </p>
                                                {if $floor}
                                                    <p>
                                                        <strong>{$core->get_Lang('Floor')}:</strong> {$floor}
                                                    </p>
                                                {/if}
                                            </div>
                                        </div>
                                        {assign var=info_cabin value=$clsCruiseCabin->getIntro($cruise_cabin_id)}
                                        {assign var=easy_cancel value=$clsCruiseCabin->getEasyCancel($cruise_cabin_id)}
                                        {assign var=CabinFa value=$clsCruiseCabin->getCabinFa($cruise_cabin_id,$item)}
                                        {if $info_cabin}
                                            {$info_cabin}
                                        {/if}
                                        {if $easy_cancel}
                                            <div class="m-item-text">
                                                <h5><span>{$core->get_Lang('Easy Cancel')}</span></h5>
                                                <div class="m-content-text">
                                                    {$easy_cancel}
                                                </div>
                                            </div>
                                        {/if}
                                        {if $CabinFa}
                                            <div class="m-item mt-3">
                                                <h5><span>{$core->get_Lang('Cabin Facilities')}</span></h5>
                                                <div class="m-content">
                                                    {$clsCruiseCabin->getCabinFa($cruise_cabin_id,$item)}
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
            </div>
            <div class="box_price_cruise">
                <div class="box_item_room_cabin">
                    <h4 class="name_room_cabin">{$core->get_Lang('Cruise')}</h4>
                    <p class="group_size_room_cabin">
                        {$core->get_Lang('Adult')} {$number_adult} {if !$price_by && !empty($total_price)} x {$txt_price_adult}{/if}
                    </p>
                    {if $number_child gt 0}
                        {foreach from=$list_child item=child key=age}
                            <p class="group_size_room_cabin">
                                {$core->get_Lang('Children')} {$child.quantity} ({$age} {$core->get_Lang("year old")})
                                {if !$price_by && !empty($total_price)}x {$child.txt_price_child} {/if}
                            </p>
                        {/foreach}
                    {/if}
                </div>
            </div>
            <div class="box_book_cabin">
                {if isset($item.check_contact_total) && $item.check_contact_total == 1}
                    <p class="total_price">{$core->get_Lang('Contact')}</p>
                {else}
                    {if $_LANG_ID eq 'vn'}
                        <p class="txt_total_price">
                            {$core->get_Lang("Total price")}
                            {if isset($list_total_price.promotion) && $list_total_price.promotion eq 1}
                                <del>{$clsISO->formatPrice($total_price)} {$clsISO->getRate()}</del>
                            {/if}
                        </p>
                        <p class="total_price">
                            {if !empty($total_price)}
                                {$clsISO->formatPrice($total_price)}
                                <span class="price_unit"> {$clsISO->getRate()}</span>
                            {else}
                                {$core->get_Lang("Contact")}
                            {/if}
                        </p>
                    {else}
                        <p class="txt_total_price">
                            {$core->get_Lang("Total price")}
                            {if isset($list_total_price.promotion) && $list_total_price.promotion eq 1}
                                <del> {$clsISO->getRate()} {$clsISO->formatPrice2($total_price, 2)}</del>
                            {/if}
                        </p>
                        <p class="total_price">
                            {if !empty($total_price)}
                                <span class="price_unit">{$clsISO->getRate()} </span>
                                {$clsISO->formatPrice2($total_price,2)}
                            {else}
                                {$core->get_Lang("Contact")}
                            {/if}
                        </p>
                    {/if}
                    <p class="text_vat">{$core->get_Lang('Price includes taxes and fees')}</p>
                {/if}
                
                {if !empty($total_price)}
                    <button class="btn_book_cabin" type="button">{$core->get_Lang('Book now')}</button>
                {else}
                    <form action="" method="post">
                        <input type="hidden" name="cruise_id" value="{$cruise_id}">
                        <input type="hidden" name="ContactCruise" value="ContactCruise">
                        <button class="btn_contact" type="submit">{$core->get_Lang('Contact')}</button>
                    </form>
                {/if}
                <p class="txt_contact">{$core->get_Lang('Do you need advice')}?
                    <a href="{$clsISO->getLink("contact")}" class="btn_contact_cabin" type="button">{$core->get_Lang('Contact')}</a>
                </p>
                <input type="hidden" name="cruise_id" value="{$cruise_id}">
                <input type="hidden" name="departure_date" value="{$departure_date}">
                <input type="hidden" name="cruise_itinerary_id" value="{$cruise_itinerary_id}">
                <input type="hidden" name="cruise_cabin_id" value="{$cruise_cabin_id}">
                <input type="hidden" name="number_adult" value="{$number_adult}">
                <input type="hidden" name="number_child" value="{$number_child}">
                <input type="hidden" name="number_cabin" value="{$number_cabin}">
                <input type="hidden" name="children" value='{$list_child|json_encode}'>
                <input type="hidden" name="str_total_price" value='{$total_price}'>
                <input type="hidden" name="discount_type" value="{$discount_type|default:''}">
                <input type="hidden" name="discount_value" value="{$discount_value|default:0}">
            </div>
        </div>
    </div>

{/if}
<script>
    var itinerary_cruise_id = '{$cruise_itinerary_id}';
    var departure_date = '{$departure_date}';
    var cruise_id = '{$cruise_id}';
</script>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function(){
                $('.cabinCarousel').each(function () {
                    new Carousel(
                        this,
                        {
                            Dots: false,
                            Thumbs: {
                                type: 'classic',
                            },
                        },
                        { Thumbs }
                    );
                });
            });
        })
        
    </script>
{/literal}