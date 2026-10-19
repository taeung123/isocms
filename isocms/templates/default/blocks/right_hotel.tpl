<div class="serach-list-hotel mt10">
    <form id="filterForm" method="post" action="">
        <input type="hidden" name="Hid_Search" value="Hid_Search" />
        <div class="title">Chọn lọc theo:</div>
        <div class="search-hotel-content">
        	{if $lstCityAreaHotel}
            <dt class="elem-accordion_Items_hotel"> 
                <span class="title1"><i class="fa fa-caret-down"></i> <a title="">Vị trí khu vực</a></span> 
            </dt>
            <dd class="pbm" style="display:block">
                <ul>
                	{section name=i loop=$lstCityAreaHotel}
                    <li>
                        <input id="a{$lstCityAreaHotel[i].area_city_id}" class="checkbox-custom" name="area_city_id" value="{$lstCityAreaHotel[i].area_city_id}" type="checkbox" {if $clsISO->checkInArray($area_city_id,$lstCityAreaHotel[i].area_city_id)}checked="checked"{/if}/>
                        <label for="a{$lstCityAreaHotel[i].area_city_id}" class="checkbox-custom-label">{$lstCityAreaHotel[i].title}</label>	
                        <p>{$clsHotel->countHotelGolobal(0,$city_id,$lstCityAreaHotel[i].area_city_id,0,0,0)}</p>	
                    </li>
                    {/section}			
                </ul>
            </dd>
            {/if}
            <dt class="elem-accordion_Items_hotel"> 
            <span class="title1"><i class="fa fa-caret-down"></i> <a title="">Hạng khách sạn</a></span> 
            </dt>
            <dd class="pbm" style="display:block">
            	<ul>
                	{section name=i loop=$star}
                    <li>
                        <input id="b{$star[i]}" class="checkbox-custom" name="star_id" value="{$star[i]}" type="checkbox" {if $clsISO->checkInArray($star_id,$star[i])}checked="checked"{/if} />
                        <label for="b{$star[i]}" class="checkbox-custom-label"><img src="{$clsHotel->getImageStar($star[i])}" style="vertical-align:text-top" /></label>	
                        <p>{$clsHotel->countHotelGolobal(0,$city_id,$area_city_id,$star[i],$price_range_id)}</p>		
                    </li>
                    {/section}			
                </ul>
            </dd>
            <dt class="elem-accordion_Items_hotel"> 
                <span class="title1"><i class="fa fa-caret-down"></i> <a title="">Giá</a></span> 
            </dt>
            <dd class="pbm" style="display:block">
                <ul>
                	{section name=j loop=$lstPriceRangeSearch}
                    <li>
                        <input id="p{$lstPriceRangeSearch[j].hotel_price_range_id}" class="checkbox-custom" name="hotel_price_range_id" value="{$lstPriceRangeSearch[j].hotel_price_range_id}" type="checkbox" {if $clsISO->checkInArray($hotel_price_range_id,$lstPriceRangeSearch[j].hotel_price_range_id)}checked="checked"{/if}/>
                        <label for="p{$lstPriceRangeSearch[j].hotel_price_range_id}" class="checkbox-custom-label">{$lstPriceRangeSearch[j].min_rate|number_format:"0":".":"."} đ {if $lstPriceRangeSearch[j].max_rate gt '0'}đến {$lstPriceRangeSearch[j].max_rate|number_format:"0":".":"."} đ{/if}</label>		
                        <p>{$clsHotel->countHotelGolobal(0,$city_id,$area_city_id,$star_id,$lstPriceRangeSearch[j].hotel_price_range_id)}</p>
                    </li>
                    {/section}			
                </ul>
            </dd>
            <dt class="elem-accordion_Items_hotel" style="display:none"> 
                <span class="title1"><i class="fa fa-caret-down"></i> <a title="">Tiện ích, dịch vụ khác sạn</a></span> 
            </dt>
            <dd class="pbm" style="display:none;border:none">
                <ul>
                    {section name=j loop=$listHotelFacility}
                    <li>
                       <input id="d{$listHotelFacility[j].property_id}" class="checkbox-custom" name="property_id" value="{$listHotelFacility[j].property_id}" type="checkbox" {if $clsISO->checkInArray($property_id,$listHotelFacility[j].property_id)}checked="checked"{/if}/>
                       <label for="d{$listHotelFacility[j].property_id}" class="checkbox-custom-label">{$listHotelFacility[j].title}</label>	
                       <p>100</p>	
                   </li>
                   {/section}			
                </ul>
            </dd>
         </div>
    </form>
</div>
<script type="text/javascript">var $all = "{$all}";</script>
{literal}
<script type="text/javascript">
$('#filterForm .checkbox-custom').change(function(){
	$(this).closest('form').submit();
});
$('#filterForm select').change(function(){
	$(this).closest('form').submit();
});
if($all == 'all') {
	$('#filterForm .checkbox-custom').attr('checked',true);
}
</script>
{/literal}
