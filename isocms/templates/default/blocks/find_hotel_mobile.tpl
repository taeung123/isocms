{if $mod eq 'hotel' && $act eq 'search'}
<section class="findTrip">
    <h2 class="head">Find vacation<i class="icon_search"></i></h2>
    <div class="findtrip">		
        <form class="form-inline" method="post" action="" role="form">
            <div class="find-a-box" style="display:none">
                <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
            </div>
            <div class="find-a-box">
                <select class="form-control" name="city_id"> 
                    <option value="0"> -- {$core->get_Lang('Select city')} --</option>
                </select>
            </div>
            <div class="find-a-box">
                <select class="form-control" name="star_id"> 
                    <option selected="selected"> -- {$core->get_Lang('Ranking')} --</option>
                    {$clsISO->makeSelectNumber2(6,$star_id,'star,stars')}
                </select>
            </div>
            {if $clsConfiguration->getValue('SiteHasHotelPriceRange')}
            <div class="find-a-box">
                 <select class="form-control bdr0" name="price_range"> 
                   <option value="0">-- {$core->get_Lang('Select price')} --</option>
                   {section name=i loop=$lstPriceRange}
                   <option {if $price_range eq $lstPriceRange[i].hotel_price_range_id}selected="selected"{/if} value="{$lstPriceRange[i].hotel_price_range_id}">{$clsHotelPriceRange->getTitle($lstPriceRange[i].hotel_price_range_id)}</option>
                   {/section}
               </select>
            </div>
            {/if}
            <div class="find-a-box">
                <input type="hidden" value="searchHotel" name="hid" />
                <button class="btn_submit searchHotel" type="submit">{$core->get_Lang('Find Now')}</button>
            </div>
        </form>
    </div>
</section>
{else}
<div class="findBox mobile" style="display:none">
    <h2 class="head head_show">Find vacation<i class="icon_search"></i></h2>
    	<div class="find-a-trip"  style="display:none">	
        <form class="form-inline" method="post" action="" role="form">
            <div class="slb">
                <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
            </div>
            <div class="slb" style="display:none">
                <select class="selectbox" name="country_id"> 
                    {$clsCountry->getSelectByCountry($country_id)}
                </select>
            </div>
            <div class="slb">
                <select class="form-control" name="city_id"> 
                    <option value="0"> -- {$core->get_Lang('Select city')} --</option>
                </select>
            </div>
            <div class="slb">
                <select class="form-control" name="star_id"> 
                    <option selected="selected"> -- {$core->get_Lang('Ranking')} --</option>
                    {$clsISO->makeSelectNumber2(6,$star_id,'star,stars')}
                </select>
            </div>
            {if $clsConfiguration->getValue('SiteHasHotelPriceRange')}
            <div class="slb">
                <select class="form-control bdr0" name="price_range"> 
                   <option value="0">-- {$core->get_Lang('Select price')} --</option>
                   {section name=i loop=$lstPriceRange}
                   <option {if $price_range eq $lstPriceRange[i].hotel_price_range_id}selected="selected"{/if} value="{$lstPriceRange[i].hotel_price_range_id}">{$clsHotelPriceRange->getTitle($lstPriceRange[i].hotel_price_range_id)}</option>
                   {/section}
               </select>
            </div>
            {/if}
            <div class="slb">
                <input type="hidden" value="searchHotel" name="hid" />
                <button class="btn_submit btn-default form-button" type="submit">{$core->get_Lang('Find Now')}</button>
            </div>
        </form>
		</div>
	</div>
</div>
{/if}
<script type="text/javascript">
	var city_id="{$city_id}";
</script>
{literal}
<style>
.findform .isoTxt{width:160px;height:22px;padding:0 4px;border:1px solid #BABABA}
</style>
<script type="text/javascript">
$(function(){
	loadCity();
	$('select[name=country_id]').change(function(){
		$('select[name=city_id]').html('<option value="">Loading...</option>').selectric({});
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=hotel&act=loadCity',
			'data' : {"country_id":$(this).val()},
			'dataType': 'html',
			'success':function(html){
				$('select[name=city_id]').html(html).selectric({});
			}
		});
	});
});
function loadCity(){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=hotel&act=loadCity',
		'data' : {"country_id":$('select[name=country_id]').val(),'city_id':city_id},
		'dataType': 'html',
		'success':function(html){
			$('select[name=city_id]').html(html).selectric({});
		}
	});
}
</script>
{/literal}
