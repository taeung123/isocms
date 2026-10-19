<div class="search-bar {if $mod ne 'cruise'} hidden {/if}" id="iso_form_cruise">
    {if $package_id==3 || $package_id==4}
        <form  class="search_btntour iso_header_form d-flex"
              method="POST">
            <input type="hidden" name="search_cruise" value="search_cruise">
            <div class="row iso_header_form_row">
                <div class="col-12 col-xl-7 iso_header_form_item">
                    <div class="iso_form_floating ">
                        <label for="destination">{$core->get_Lang('Choose your cruise')}</label>
                        <input type="text" name="key"
                               placeholder="{$core->get_Lang('Find a cruise')}">
                    </div>
                </div>
                <div class="col-12 col-xl-5 iso_header_form_item">
                    <div class="iso_form_floating date_picker_group relative">
                        <label for="destination">{$core->get_Lang('Travel date')}</label>
                        <input name="departure_date" id="header_cruise_date" type="text" value=""
                               placeholder="{$core->get_Lang('Travel date')}"/>
                        <div class="iso_icon_svg iso_icon_date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                 viewBox="0 0 18 20" fill="none">
                                <path d="M1 7V17C1 17.5304 1.21071 18.0391 1.58579 18.4142C1.96086 18.7893 2.46957 19 3 19H15C15.5304 19 16.0391 18.7893 16.4142 18.4142C16.7893 18.0391 17 17.5304 17 17V7M1 7V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H5M1 7H17M17 7V5C17 4.46957 16.7893 3.96086 16.4142 3.58579C16.0391 3.21071 15.5304 3 15 3H13M5 3H13M5 3V1M13 3V1"
                                      stroke="#26456E" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
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
    {/if}
</div>