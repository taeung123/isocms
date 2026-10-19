{if $cartSessionService}
    {foreach from=$cartSessionService key=_key item=item name=item}
        {assign var=tour_id value=$item.tour_id_z}
        {if $tour_id}
            {assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
            {assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
            {assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
            {assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
            {assign var=image_package value=$clsTour->getImage($item.tour_id_z)}

            {assign var=adult_visitor value="national_visitor"|cat:$adult_type_id}
            {assign var=child_visitor value="national_visitor"|cat:$child_type_id}
            {assign var=infant_visitor value="national_visitor"|cat:$infant_type_id}
            {assign var=adult_price value="people_price"|cat:$adult_type_id}
            {assign var=child_price value="people_price"|cat:$child_type_id}
            {assign var=infant_price value="people_price"|cat:$infant_type_id}

            {assign var=number_adult value=$item.number_adults_z|default:0}
            {assign var=number_child value=$item.number_child_z|default:0}
            {assign var=number_infant value=$item.number_infants_z|default:0}

            {assign var=price_adult value=$item.total_price_adults|default:0}
            {assign var=price_child value=$item.total_price_child|default:0}
            {assign var=price_infant value=$item.total_price_infants|default:0}
            {assign var=number_of_guests value=$number_adult+$number_child|default:0}
            {assign var=parent_id value=$item.parent_id|default:0}
            {if $parent_id}
                {assign var="arr_tour_parent" value=$item.arr_tour_parent}
                {assign var=title_tour value=$arr_tour_parent.title}
                {assign var=link_tour value=$clsTour->getLink($parent_id, $arr_tour_parent.slug)}
            {/if}
            {assign var=row_traveler value=2}
            <div class="hnv_cart_item hnv_cart_item_tour">
                {if $_LANG_ID eq 'vn'}
                    <div class="hnv_cart_item_top">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="hnv_cart_item_image">
                                    <div class="title_package" title="{$title_package}">
                                        <img src="{$image_package}" width="auto" height="auto" alt="{$title_package}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div class="hnv_cart_item_info">
                                    <div class="hnv_cart_item_info_title d-flex align-items-center justify-content-between">
                                        {if $parent_id}
                                            <h3>
                                                {$title_tour} <div class="mb-3 fw-light">{$title_package}</div>
                                            </h3>
                                        {else}
                                            <h3>
                                                {$title_package}
                                            </h3>
                                        {/if}
                                        <div class="iso_hnv_cart_edit">
                                            <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </div>
                                    <div class="hnv_cart_item_info_detail d-flex flex-column">
                                        <div class="hnv_cart_item_info_detail_date">
                                            <i class="fa-light fa-calendar"></i>
                                            <label>{$clsISO->converTimeToText5($departure_date)}</label>
                                            <i class="fa-solid fa-circle-small"></i>
                                            {$clsTour->getLTripDuration($tour_id)}
                                        </div>
                                        <div class="hnv_cart_item_info_detail_customer">
                                            <i class="fa-light fa-user"></i>
                                            {$number_adult} {$core->get_Lang('Adults')}{if $number_child}, {$number_child} {$core->get_Lang('Children')}{/if}{if $number_infant}, {$number_infant} {$core->get_Lang('Infants')}{/if}
                                        </div>
                                        <div class="hnv_cart_item_info_detail_policy">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="hnv_cart_item_info_detail_policy_left">
                                                        <ul class="hnv_cart_item_info_detail_policy_list">
                                                            {if !empty($item.price_deposit) && $item.price_deposit > 0}
                                                                <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                                    <i class="fa-light fa-circle-xmark"></i>
                                                                    <span>{$core->get_Lang('Refundable')}</span>
                                                                </li>
                                                            {/if}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {if $item.number_addon}
                                            <div class="hnv_cart_item_info_addon">
                                                <div class="iso_text_addon d-flex justify-content-start align-items-center">
                                                    <div class="iso_img_addon">
                                                        <img src="{$URL_IMAGES}/square_more.svg" alt="">
                                                    </div>
                                                    <span>
	({$item.number_addon|@count})
	{$core->get_Lang('Retail services')}
</span>
                                                    <a href="javascript:void(0);" title="View detail">
                                                        <i class="fa-light fa-angle-down" data-cruise_id="231" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <ul class="hnv_cart_item_info_addon_list">
                                                    {foreach from=$item.number_addon key=k item=v}
                                                        <li class="hnv_cart_item_info_addon_item">
                                                            <div class="hnv_cart_item_info_addon_item_left">
                                                                <span>{$v}</span> x {$clsAddOnService->getTitle($k)}
                                                            </div>
                                                            {assign var=extra value=$clsAddOnService->getOneField('extra',$k)|default:0}
                                                            {assign var=unit_price_service value=$clsAddOnService->getOneField('price',$k)|default:0}

                                                            {*
                                                                Nếu dữ liệu cũ chưa có price thì mới lấy getStrPrice làm dự phòng.
                                                                Không dùng getStrPrice trực tiếp trong phép nhân.
                                                            *}
                                                            {if $unit_price_service <= 0}
                                                                {assign var=unit_price_service value=$clsAddOnService->getStrPrice($k)|default:0}
                                                            {/if}

                                                            {if $extra == 1}
                                                                {assign var=price_service value=$unit_price_service}
                                                            {else}
                                                                {assign var=price_service value=$v*$unit_price_service}
                                                            {/if}
                                                        <div class="hnv_cart_item_info_addon_item_right">
	<span>
		{$clsISO->formatPrice($price_service)}
		{$clsISO->getShortRate()}
	</span>

	<a
		href="javascript:void(0);"
		class="hnv_cart_item_info_addon_item_right_detail"
	>
		<i class="fa-light fa-circle-info"></i>

		<div class="hnv_cart_item_info_addon_item_right_tooltip">
			<div class="iso_cart_tooltip">
				{$v} {$clsAddOnService->getTitle($k)}
				{if $extra == 1}:{else}x{/if}
				{$clsISO->formatPrice($unit_price_service)}
				{$clsISO->getShortRate()}
			</div>
		</div>
	</a>
</div>
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {else}
                    <div class="hnv_cart_item_top">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="hnv_cart_item_image">
                                    <div class="title_package" title="{$title_package}">
                                        <img src="{$image_package}" width="auto" height="auto" alt="{$title_package}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div class="hnv_cart_item_info">
                                    <div class="hnv_cart_item_info_title d-flex align-items-center justify-content-between">
                                        {if $parent_id}
                                            <h3>
                                                {$title_tour} <div class="mb-3 fw-light">{$title_package}</div>
                                            </h3>
                                        {else}
                                            <h3>
                                                {$title_package}
                                            </h3>
                                        {/if}
                                        <div class="iso_hnv_cart_edit">
                                            <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                                        </div>
                                    </div>
                                    <div class="hnv_cart_item_info_detail d-flex flex-column">
                                        <div class="hnv_cart_item_info_detail_date">
                                            <i class="fa-light fa-calendar"></i>
                                            <label>{$clsISO->converTimeToText5($departure_date)}</label>
                                            <i class="fa-solid fa-circle-small"></i>
                                            {$clsTour->getLTripDuration($tour_id)}
                                        </div>
                                        <div class="hnv_cart_item_info_detail_customer">
                                            <i class="fa-light fa-user"></i>
                                            {$number_adult} {$core->get_Lang('Adults')}{if $number_child}, {$number_child} {$core->get_Lang('Children')}{/if}{if $number_infant}, {$number_infant} {$core->get_Lang('Infants')}{/if}
                                        </div>
                                        <div class="hnv_cart_item_info_detail_policy">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="hnv_cart_item_info_detail_policy_left">
                                                        <ul class="hnv_cart_item_info_detail_policy_list">
                                                            {if !empty($item.price_deposit) && $item.price_deposit > 0}
                                                                <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                                    <i class="fa-light fa-circle-xmark"></i>
                                                                    <span>{$core->get_Lang('Refundable')}</span>
                                                                </li>
                                                            {/if}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {if $item.number_addon}
                                            <div class="hnv_cart_item_info_addon">
                                                <div class="iso_text_addon d-flex justify-content-start align-items-center">
                                                    <div class="iso_img_addon">
                                                        <img src="{$URL_IMAGES}/square_more.svg" alt="">
                                                    </div>
                                                    <span>
	({$item.number_addon|@count})
	{$core->get_Lang('Retail services')}
</span>
                                                    <a href="javascript:void(0);" title="View detail">
                                                        <i class="fa-light fa-angle-down" data-cruise_id="231" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <ul class="hnv_cart_item_info_addon_list">
                                                    {foreach from=$item.number_addon key=k item=v}
                                                        <li class="hnv_cart_item_info_addon_item">
                                                            <div class="hnv_cart_item_info_addon_item_left">
                                                                <span>{$v}</span> x {$clsAddOnService->getTitle($k)}
                                                            </div>
                                                           {assign var=extra value=$clsAddOnService->getOneField('extra',$k)|default:0}
{assign var=unit_price_service value=$clsAddOnService->getOneField('price',$k)|default:0}

{*
	Nếu dữ liệu cũ chưa có price thì mới lấy getStrPrice làm dự phòng.
	Không dùng getStrPrice trực tiếp trong phép nhân.
*}
{if $unit_price_service <= 0}
	{assign var=unit_price_service value=$clsAddOnService->getStrPrice($k)|default:0}
{/if}

{if $extra == 1}
	{assign var=price_service value=$unit_price_service}
{else}
	{assign var=price_service value=$v*$unit_price_service}
{/if}
                                                            <div class="hnv_cart_item_info_addon_item_right">
                                                                <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($price_service)}</span>
                                                                <a href="javascript:void(0);" class="hnv_cart_item_info_addon_item_right_detail">
                                                                    <i class="fa-light fa-circle-info"></i>
                                                                    <div class="hnv_cart_item_info_addon_item_right_tooltip">
                                                                        <label>
                                                                            {$v} {$clsAddOnService->getTitle($k)} {if $extra == 1}:{else}x{/if} {$clsISO->getShortRate()}{$clsAddOnService->getStrPrice($k)}
                                                                        </label>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
               
                <div class="iso_information_booking">
                    {$clsISO->getBlock('iso_primary_traveler', ["type_block"=>"tour", "_key"=> $_key])}
                    {if $number_adult > 1}
                    <div class="iso_information_tour_item">
                        <div class="iso_box_lst_traveler">
                            <div class="iso_box_lst_adults">
                                {section name=loop start=0 loop=$number_adult} 
                                <div class="iso_traveler_item">
                                    <input type="hidden" class="txt_full_name" name="tms-fullname_adult_{$tour_id}_{$smarty.section.loop.index + 1}">
                                    <div class="title d-flex align-items-center justify-content-between">
                                        <span>
                                            {$core->get_Lang('Traveler')} ({$core->get_Lang('Adult')})
                                        </span>
                                        <div class="iso_traveler_delete">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="box_primary_traveler_other">
                                        <div class="iso_item_body_tour iso_input_box">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="iso_input_box_item">
                                                        <label>{$core->get_Lang('First name')}</label>
                                                        <input name="traveler_first_name_adult_{$tour_id}_{$smarty.section.loop.index + 1}" placeholder="" type="text" class="form-booking_input first_name"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="iso_input_box_item">
                                                        <label>{$core->get_Lang('Last Name')}</label>
                                                        <input name="traveler_last_name_adult_{$tour_id}_{$smarty.section.loop.index + 1}" placeholder="" type="text" class="form-booking_input last_name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/section}
                            </div>
                            <div class="iso_box_lst_child">
                                {section name=loop start=0 loop=$number_child} 
                                <div class="iso_traveler_item">
                                    <input type="hidden" class="txt_full_name" name="tms-fullname_child_{$tour_id}_{$smarty.section.loop.index + 1}">
                                    <div class="title d-flex align-items-center justify-content-between">
                                        <span>
                                            {$core->get_Lang('Traveler')} ({$core->get_Lang('Child')})
                                        </span>
                                        <div class="iso_traveler_delete">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="box_primary_traveler_other">
                                        <div class="iso_item_body_tour iso_input_box">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="iso_input_box_item">
                                                        <label>{$core->get_Lang('First name')}</label>
                                                        <input name="traveler_first_name_child_{$tour_id}_{$smarty.section.loop.index + 1}" placeholder="" type="text" class="form-booking_input first_name"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="iso_input_box_item">
                                                        <label>{$core->get_Lang('Last Name')}</label>
                                                        <input name="traveler_last_name_child_{$tour_id}_{$smarty.section.loop.index + 1}" placeholder="" type="text" class="form-booking_input last_name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/section}
                            </div>
                            <div class="iso_box_lst_infants">
                                {section name=loop start=0 loop=$number_infant} 
                                <div class="iso_traveler_item">
                                    <input type="hidden" class="txt_full_name" name="tms-fullname_infant_{$tour_id}_{$smarty.section.loop.index + 1}">
                                    <div class="title d-flex align-items-center justify-content-between">
                                        <span>
                                            {$core->get_Lang('Traveler')} ({$core->get_Lang('Infant')})
                                        </span>
                                        <div class="iso_traveler_delete">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="box_primary_traveler_other">
                                        <div class="iso_item_body_tour iso_input_box">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="iso_input_box_item">
                                                        <label>{$core->get_Lang('First name')}</label>
                                                        <input name="traveler_first_name_infant_{$tour_id}_{$smarty.section.loop.index + 1}" placeholder="" type="text" class="form-booking_input first_name"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="iso_input_box_item">
                                                        <label>{$core->get_Lang('Last Name')}</label>
                                                        <input name="traveler_last_name_infant_{$tour_id}_{$smarty.section.loop.index + 1}" placeholder="" type="text" class="form-booking_input last_name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/section}
                            </div>
                        </div>
                        <div class="add_tourist_information hidden" data-tour_id="{$tour_id}" data-adult="{$number_adult}" data-child="{$number_child}" data-infant="{$number_infant}">
                            + {$core->get_Lang('Add tourist information')}
                        </div>
                    </div>
                    {/if}
                    <div class="iso_information_tour_item">
                        <div class="title">
                            {$core->get_Lang('Special requirements')}
                        </div>
                        <div class="box_primary_traveler_other">
                            <div class="iso_item_body_tour iso_input_box">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="iso_input_box_item_area">
                                            <textarea name="tour_special_{$_key}" rows="3" placeholder="{$core->get_Lang('To type the request to us. E.g. dietary needs, accessibility')}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="iso_button d-flex flex-column">
                                    <button class="iso_cart_button" id="btn_tour_{$_key}">
                                        {$core->get_Lang('Next')}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {/foreach}
    {assign var=row_traveler value=0}
{/if}
