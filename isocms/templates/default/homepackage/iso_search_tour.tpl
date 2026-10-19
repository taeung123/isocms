{assign var=TitleSearchTours value=TitleSearchTours_|cat:$_LANG_ID}
<div class="iso_box_search">
    <div class="container">
        <div class="button_search_choose">
        
            {if $package_id==3 || $package_id==4}
                <!-- <div class="button_category_choose">
                    <button class="category_btnt txt_btntcate iso_button_search active" data-id="tour">
                        <i class="fa-light fa-compass"></i>
                        <span>{$core->get_Lang('Tours')}</span>
                    </button>
                    <button class="category_btnt txt_btntcate iso_button_search" data-id="hotel">
                        <i class="fa-light fa-hotel"></i>
                        <span>{$core->get_Lang('Hotels')}</span>
                    </button>
                    <button class="category_btnt txt_btntcate iso_button_search" data-id="cruise">
                        <i class="fa-sharp fa-light fa-ship"></i>
                        <span>{$core->get_Lang('Cruises')}</span>
                    </button>
                </div> -->
            {/if} 

        </div>

        <div class="txt_h1tour">{$clsConfiguration->getValue($TitleSearchTours)}</div>
        <div class="search-bar" id="iso_form_tour">
            <form class="search_btntour iso_header_form d-flex" method="POST">
                <input type="hidden" name="search_tour" value="search_tour">
                <div class="row iso_header_form_row">
                    <!-- Where do you want to go -->
                    <div class="col-12 col-md-12 col-xl-4 iso_header_form_item">
                        <div class="iso_form_floating relative">
                            <label for="destination">{$core->get_Lang('Where do you want to go')}?</label>
                            {if $package_id != 3 && $package_id != 4}
                                <input type="text" name="key" id="departure_point_id"
                                        placeholder="{$core->get_Lang('Find a destination')}">
                            {else}
                                <select name="departure_point_id" id="departure_point_id"
                                        placeholder="{$core->get_Lang('Find a destination')}"
                                        data-search="true" class="hidden">
                                    <option value=""
                                            disabled>{$core->get_Lang('Find a destination')}</option>
                                    {$clsCountryEx->getSelectCountryCitySearch()}
                                </select>
                            {/if}
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 iso_header_form_item">
                        <div class="iso_form_floating date_picker_group relative">
                            <label for="header_departure_date">{$core->get_Lang('When')}?</label>
                            <input name="departure_date" id="header_departure_date" type="text" value=""
                                    placeholder="{$core->get_Lang('Tour departure time')}"/>
                            <div class="iso_icon_svg iso_icon_date">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                        viewBox="0 0 18 20" fill="none">
                                    <path d="M1 7V17C1 17.5304 1.21071 18.0391 1.58579 18.4142C1.96086 18.7893 2.46957 19 3 19H15C15.5304 19 16.0391 18.7893 16.4142 18.4142C16.7893 18.0391 17 17.5304 17 17V7M1 7V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H5M1 7H17M17 7V5C17 4.46957 16.7893 3.96086 16.4142 3.58579C16.0391 3.21071 15.5304 3 15 3H13M5 3H13M5 3V1M13 3V1"
                                            stroke="#26456E" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 iso_header_form_item">
                        <div class="iso_form_floating relative">
                            <label for="iso_select_custom">{$core->get_Lang('Duration')}</label>
                            <select name="duration_id" id="duration_id" class="iso_header_select2 hidden"
                                    placeholder="{$core->get_Lang('Tour departure time')}"
                                    data-search="true">
                                <option value="" disabled>{$core->get_Lang('Tour departure time')}</option>
                                {$DURATION_HTML}
                            </select>
                            <div class="iso_icon_svg iso_icon_date">
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Search button -->
                </div>
                <div class="iso_search_btn">
                    <button type="submit" class="iso_btn_search">
                        <i class="fa-solid fa-magnifying-glass"></i> {$core->get_Lang('Search')}
                    </button>
                </div>
            </form>
        </div>
        <div class="choosen_tour_loaction">
            <div class="box_item">
                <div class="txt_destinationchoosen">{$core->get_Lang("Some destinations are highly chosen")}</div>
                <div class="select_locationdes">
                    {if $ShowFeaturedDestinations == 1}
                        {foreach from=$listCountryDestination key=key item=item}
                            {assign var=title_country value=$item.title}
                            {assign var=country__id value=$item.country_id}
                            {assign var=lstCountryCat value=$clsCategory_Country->getListCatCountry($country__id)}
                            <a href="{$clsCountryEx->getLink($country__id, 'Destination_new')}" class="txt_locationdes"
                            title="{$title_country}">{$title_country}</a>
                        {/foreach}
                    {else}
                        {foreach from=$lstOffersFeatured key=key item=country}
                            {assign var=lst_child value=$country.lst_child}
                            {if !empty($lst_child)}
                                {foreach from=$lst_child key=kc item=city} 
                                    <a href="{$city.link}" class="txt_locationdes"
                                title="{$city.city_title}">{$city.city_title}</a>
                                {/foreach}
                            {/if}
                        {/foreach}
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <style>
        .iso_box_search {
            padding: 40px 0;
            position: absolute;
            width: 100%;
            bottom: 0;
            top: auto;
        }
        @media(min-width: 768px) {
            .iso_box_search {
                bottom: auto;
                top: 50%;
                transform: translateY(-50%);
            }
        }
    </style>
{/literal}
