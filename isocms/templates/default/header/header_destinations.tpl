<div class="dropdown-menu dropdown-menu-end" aria-labelledby="iso_dropdown_destinations" id="iso_header_destinations">
    <div class="iso_header_destinations">
        <div class="row">
            <div class="col-lg-8 iso_col">
                <div class="row iso_header_destinations_body">
                    <div class="col-lg-5 iso_col iso_col_pc">
                        <div class="iso_box_destination d-flex flex-column">
                            {foreach from=$listCountryDestination key=key item=item}
                                {assign var=title_country value=$item.title}
                                {assign var=country__id value=$item.country_id}
                                <a class="iso_box_destination_item d-flex align-items-center justify-content-between"
                                    href="{$clsCountryEx->getLink($country__id, 'Destination_new', $item)}"
                                    data-id="iso_country_{$item.country_id}">
                                    <span>{$title_country}</span>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            {/foreach}
                        </div>
                    </div>
                    <div class="col-lg-7 iso_col iso_col_city">
                        {foreach from=$listCountryDestination key=key item=item}
                            {assign var=country__id value=$item.country_id}
                            {assign var=title_country value=$item.title}
                            {assign var=cities value=$item.cities}
                            <div class="iso_lst_city {if $key eq 0}show{/if}"
                                    id="iso_country_{$item.country_id}">
                                <a href="{$clsCountryEx->getLink($country__id, 'Destination_new')}" class="iso_city_title">
                                    {$title_country}
                                </a>
                                {if $cities}
                                <div class="iso_city_item row">
                                    {foreach from=$cities key=k item=i}
                                        {assign var=title_category_country value=$i.title}
                                        <a class="item col-lg-6 iso_col"
                                            href="{$clsCity->getLink($i.city_id)}">
                                            {$title_category_country}
                                        </a>
                                    {/foreach}
                                </div>
                                {/if}
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 iso_col">
                {foreach from=$listCountryDestination key=key item=item}
                    {assign var=title_country value=$item.title}
                    {assign var=country__id value=$item.country_id}
                    <div class="box_collapse_item {if $key eq 0}active{/if}"
                            data-id="iso_country_{$country__id}">
                        <div class="box_collapse_img">
                            <img src="{$clsCountryEx->getBanner($country__id, 360, 430)}"
                                    width="360" height="430" alt="{$title_country}" loading="lazy">
                        </div>
                        <a href="{$clsCountryEx->getLink($country__id, 'Destination_new')}"
                            class="iso_link_country">
                            {$core->get_Lang('See all')} {$title_country} {$core->get_Lang('tours')}
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>