<div class="findBox findhotel">
	<div class="container">
        <div class="find-a-trip">
        <form class="form-inline" method="post" action="">
            <div class="form-group text">
                <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
            </div>
            <div class="form-group">
                <select class="selectbox" name="country_id"> 
                    {$clsCountry->getSelectByCountry($country_id)}
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="city_id"> 
                    <option value="0"> -- {$core->get_Lang('Select city')} --</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="star_id"> 
                    <option selected="selected"> -- {$core->get_Lang('Ranking')} --</option>
                    {$clsISO->makeSelectNumberStart(6,$star_id)}
                </select>
            </div>
            {if $lstPriceRange}
            <div class="form-group">
                <select class="form-control bdr0" name="price_range"> 
                   <option value="0">-- {$core->get_Lang('Select price')} --</option>
                   {section name=i loop=$lstPriceRange}
                   <option {if $price_range eq $lstPriceRange[i].hotel_price_range_id}selected="selected"{/if} value="{$lstPriceRange[i].hotel_price_range_id}">{$clsHotelPriceRange->getTitle($lstPriceRange[i].hotel_price_range_id,$lstPriceRange[i])}</option>
                   {/section}
               </select>
            </div>
            {/if}
            <div class="form-group submit fr">
                <input type="hidden" value="searchHotel" name="hid" />
                <button class="btn_submit btn-default form-button btn_main" type="submit">{$core->get_Lang('Find Now')}</button>
            </div>
        </form>
		</div>
	</div>
</div>
<link rel="stylesheet" href="{$URL_JS}/selectric/selectric.css?v={$upd_version}">
<script src="{$URL_JS}/selectric/jquery.selectric.js?v={$upd_version}"></script>
<script>
	var city_id="{$city_id}";
	var Loading="{$core->get_lang('Loading')}....";
</script>
{literal}
<script>
$(function(){
	loadCity();
	$('select[name=country_id]').change(function(){
		loadCity();
	});
});
function loadCity(){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=hotel&act=loadCity&lang='+LANG_ID,
		'data' : {"country_id":$('select[name=country_id]').val(),'city_id':city_id},
		'dataType': 'html',
		'success':function(html){
			$('select[name=city_id]').html(html);
		}
	});
}
</script>
{/literal}
