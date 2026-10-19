{if $mod eq 'home'}
<div class="findTripDestination">		
	<form class="form-inline search_tour" method="post" action="{$extLang}">
		<div class="form-group slb_destination">
			<select class="w100" name="destination_ID" id="destination_ID">
				 {$html_CountryEx}
			</select>
		</div>	
		<div class="form-group slb_keyword hidden991">
			<input class="w100 searchText" type="text" name="key" value="{$keyword}" placeholder="{$core->get_Lang('Search for Activities, Tours and Experiences')}..." />
		</div>	
		<div class="form-group submit">
			<button type="submit" class="w100 btn_search amplitude_search_btn"><span class="hidden-600">{$core->get_Lang('Search')}</span> <i class="fa fa-search"></i></button>
			<input type="hidden" name="hid_s" value="hid_s" />
		</div>
	</form>
</div>
{else}
<div class="findTripDestination display_des">
    <div class="findtrip">		
        <form class="form-inline form_search_city search_bar" method="post" action="{$clsISO->getLink('search_tour')}">
			<input type="hidden" name="Hid_Search2" value="Hid_Search2" />
			<input type="hidden" name="city_id" value="{$city_id}" id="city_id"/>
            <div class="form-group ">
            	<ul id="p7">
                {section name=i loop=$lstCountryEx}
                <li><a  href="{$clsCountryEx->getLink($lstCountryEx[i].country_id)}">{$clsCountryEx->getTitle($lstCountryEx[i].country_id)}</a>
                    <ul id="radio">
						{assign var=listCityByCountry value=$clsCountryEx->getCityTourByCountry($lstCountryEx[i].country_id)}
						{section name=j loop=$listCityByCountry}
							<li>
								<input type="radio" id="{$listCityByCountry[j].city_id}" name="city_id[]" class="typeSearch" value="{$listCityByCountry[j].city_id}" {if $clsISO->checkInArray($city_id,$listCityByCountry[j].city_id)}checked="checked"{/if}>
								
								<label for="{$listCityByCountry[j].city_id}">{$clsCity->getTitle($listCityByCountry[j].city_id)}</label>
								<div class="check"></div>
							</li>
						{/section}
                    </ul>
                </li>
                {/section}
                </ul>
            </div>	
        </form>
    </div>
</div>
{/if}

<script >
	var country_id= '{$country_id}';
	var cat_id= '{$cat_id}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
	//thtech
</script>
{literal}
<style>
.findTripDestination{max-width:1140px; margin:0 auto;padding: 45px 35px;background-color: white;}
.findTripDestination .search_tour{width:100%; background:#fff; height:46px; /*border:1px solid #ccc*/}
.findTripDestination .search_tour .slb_destination{width:305px; float:left;margin-right: 25px;position: relative;}
.findTripDestination .search_tour select {width:100%; height:44px; line-height:39px; padding:0 10px; border:0; border:1px solid #ccc;/*padding-left: 45px;*/text-indent: 45px;}
.findTripDestination .search_tour .slb_destination:after{content: "\e92c";font-family: 'Vietisofontsymbol';position: absolute;top: 7px;left: 20px;font-size: 20px;color: #f58220;}
.findTripDestination .slb_keyword{width: 50%;width:calc(100% - 515px); float:left;}
.findTripDestination .slb_keyword input{    width: 100%;
	height: 44px;
	line-height: 30px;
	padding: 5px 20px;
	border: 1px solid #ccc;
	outline: none;}
.findTripDestination .submit{width:165px; float:right;}
.findTripDestination .submit button{width:100%; height:44px; line-height:44px; border:0; background:#f16f30; outline:none; font-size:20px; color:#fff;border-radius: 50px;}
.findTripDestination .submit button i{font-size: 22px;}
@media screen and (max-width: 991px){
.findTripDestination .search_tour .slb_destination{width: 70%;width: calc(100% - 195px); border-right:0;}

}
@media screen and (max-width: 480px){
.findTripDestination{width:95%; max-width:850px; margin:0 auto;}
}
@media screen and (min-width: 992px) and (max-width: 1199px){
	.findTripDestination .slb_keyword{width: 340px;width:calc(100% - 515px); float:left;}
}
</style>
<script>
$('.form_search_city .typeSearch').change(function(){
	$(this).closest('form').submit();
	$( "#quick_search" ).hide();		
});
</script>
<script>
$(function(){
	$(document).on('change', 'select[name=destination_ID]', function(ev){
		var $_this = $(this);
		var $destination_ID = $_this.val();
	});
});
function makeSelectDestination($country_id,$city_id){
	$('select[name=destination_ID]').html('<option value="">'+Loading+'</option>');
	var $_adata = {
		'country_id': $country_id,
		'city_id' : $city_id
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDestination',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=destination_ID]').html(html);
		}
	});
}
</script>
{/literal}