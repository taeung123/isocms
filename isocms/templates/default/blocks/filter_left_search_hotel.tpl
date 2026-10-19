<div class="filter_left_search">
    <div class="filter_left_title">
        {$core->get_Lang('Filter')}
    </div>
    <form action="" method="post" id="search_hotel_left">
        <input type="hidden" name="search_hotel_left" value="search_hotel_left"/>
        {if $act eq 'default'}
			{if $lstCountryHotel}
				<div class="find_Box">
					<div class="box_body_filter_title">
						{$core->get_Lang('Country')}
					</div>
					<div class="box_filter_body">
						<div class="filter_list_item">
							{section name=i loop=$lstCountryHotel}
								{assign var=check value=$clsISO->checkInArray($country_id,$lstCountryHotel[i].country_id)}
								<div class="check_ipt">
									<a class="filter_link" href="{$clsCountryEx->getLink($lstCountryHotel[i].country_id,'Hotel',$lstCountryHotel[i])}" title="{$lstCountryHotel[i].title}"><label>{$lstCountryHotel[i].title}</label></a>
								</div>
							{/section}

						</div>
						<span class="readmore">{$core->get_Lang('More')}</span>
					</div>
				</div>
			{/if}
        {else}
			{if $lstCity}
				<div class="find_Box">
					<div class="box_body_filter_title">
						{$core->get_Lang('City')}
					</div>
					<div class="box_filter_body">
						<div class="filter_list_item">
							{section name=i loop=$lstCity}
								{assign var=check value=$clsISO->checkInArray($city,$lstCity[i].city_id)}
								<div class="check_ipt">
									<input type="checkbox" name="city[]" class="input_item typeSearch" value="{$lstCity[i].city_id}"{if $check} checked {/if} id="city{$smarty.section.i.iteration}">
									<label for="city{$smarty.section.i.iteration}">{$lstCity[i].title}</label>
								</div>
							{/section}

						</div>
						<span class="readmore">{$core->get_Lang('More')}</span>
					</div>
				</div>
			{/if}
        {/if}
        <div class="find_Box">
            <div class="box_body_filter_title">
                {$core->get_Lang('Price range')}
            </div>
            <div class="box_filter_body">
                <div class="filter_list_item">
                    {section name=i loop=$lstPriceRange}
                        {assign var=check value=$clsISO->checkInArray($price_range,$lstPriceRange[i].hotel_price_range_id)}
                        <div class="check_ipt">
                            <input type="checkbox" name="price_range[]" class="input_item typeSearch" value="{$lstPriceRange[i].hotel_price_range_id}"{if $check} checked {/if} id="priceRange{$smarty.section.i.iteration}">
                            <label for="priceRange{$smarty.section.i.iteration}">{$lstPriceRange[i].title}</label>
                        </div>
                    {/section}
                    
                </div>
                <span class="readmore">{$core->get_Lang('More')}</span>
            </div>
        </div>
        <div class="find_Box">
            <div class="box_body_filter_title">
                {$core->get_Lang('Rank')}
            </div>
            <div class="box_filter_body">
                <div class="filter_list_item">
                    {assign var=stars value=$clsISO->listStar(6)}
                    {section name=i loop=$stars}
                        {assign var=check value=$clsISO->checkInArray($star_id,$stars[i].star_id)}
                        <div class="check_ipt">
                            <input type="checkbox" name="star_id[]" class="input_item typeSearch" value="{$stars[i].star_id}"{if $check} checked {/if} id="star{$smarty.section.i.iteration}">
                            <label for="star{$smarty.section.i.iteration}">{$stars[i].title}</label>
                        </div>
                    {/section}
                    
                </div>
                <span class="readmore">{$core->get_Lang('More')}</span>
            </div>
        </div>
        <div class="find_Box">
            <div class="box_body_filter_title">
                {$core->get_Lang('Type of accommodations')}
            </div>
            <div class="box_filter_body">
                <div class="filter_list_item">
                    {section name=i loop=$listTypeHotel}
                        {assign var=hotel_property_id value=$listTypeHotel[i].property_id}
                        {assign var=hotel_property_title value=$listTypeHotel[i].title}
                        {assign var=check value=$clsISO->checkInArray($type_hotel,$hotel_property_id)}
                        <div class="check_ipt">
                            <input type="checkbox" class="input_item typeSearch" name="type_hotel[]" value="{$hotel_property_id}"{if $check} checked {/if} id="typeHotel{$smarty.section.i.iteration}">
                            <label for="typeHotel{$smarty.section.i.iteration}">{$hotel_property_title}</label>
                        </div>
                    {/section}

                </div>
                <span class="readmore">{$core->get_Lang('More')}</span>
            </div>
        </div>
    </form>
</div>
{literal}
    <script>
        $(function(){			
			$('.filter_list_item').each(function(index,elm){
				var $_this = $(elm);
				var number_list = $(elm).find(".check_ipt").length;
				if(number_list > 5){
					$(elm).addClass("short");
					$_this.closest(".find_Box").find(".readmore").show();
				}else{
					$_this.closest(".find_Box").find(".readmore").hide();
				}
			});
			$(document).on("click",".readmore",function(){
				var $_this = $(this);
				if(!$_this.hasClass("less")){
					$_this.addClass("less");
					$_this.closest(".find_Box").find(".filter_list_item").removeClass("short");
					$_this.html('{/literal}{$core->get_Lang("Less")}{literal}');
				}
				else{
					$_this.removeClass("less");
					$_this.closest(".find_Box").find(".filter_list_item").addClass("short");
					$_this.html('{/literal}{$core->get_Lang("More")}{literal}');
				}
			});
        });

        $(function () {
            $('#search_hotel_left .typeSearch').change(function () {
                $(this).closest('form').submit();
            });
        });
    </script>
{/literal}
