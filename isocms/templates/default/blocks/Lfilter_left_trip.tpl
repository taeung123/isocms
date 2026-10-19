<form action="{$clsISO->getLink('search_tour')}" class="simple_form search" id="filters_form" method="post">
    <input type="hidden" name="Hid_Search" value="Hid_Search" />
    <input type="hidden" name="min_duration" id="duration1" value="{$min_duration_value}">
    <input type="hidden" name="max_duration" id="duration2" value="{$max_duration_value}">
    <div class="findBox mt0 pdbt30">
        <h3>{$core->get_Lang('DURATION')}</h3>
        <div id="duration_0" class="inline-block w50 text-left"></div>
        <div id="duration_1" class="inline-block w50 text-right"></div>
        <div id="slider-range"></div>
    </div>
    <div class="findBox">
        <h3>{$core->get_Lang('CHOOSE COUNTRY')}</h3>
        <ul class="filter tour_types common_wrapper_details checkBlock">
            {section name=i loop=$lstCountryEx}
            {if $clsTour->countTourGolobal($lstCountryEx[i].country_id, 0, 0) gt 0}
            <li>
                <input id="c{$lstCountryEx[i].country_id}" class="typeSearch" name="country_id[]" value="{$lstCountryEx[i].country_id}" type="checkbox" {if $clsISO->checkInArray($country_id,$lstCountryEx[i].country_id)}checked="checked"{/if} />
                <label class="twoFilter" for="c{$lstCountryEx[i].country_id}">{$lstCountryEx[i].title}</label>
            </li>
            {/if}
            {/section}
        </ul>
    </div>
    <div class="findBox">
        <h3>{$core->get_Lang('TRAVEL STYLE')}</h3>
        <ul class="filter common_wrapper_details tour_types checkBlock">
            {section name=i loop=$lstCatTour}
            <li>
                <input id="t{$lstCatTour[i].tourcat_id}" class="typeSearch" name="cat_id[]" value="{$lstCatTour[i].tourcat_id}" type="checkbox" {if $clsISO-> checkInArray($cat_id,$lstCatTour[i].tourcat_id)}checked="checked"{/if} />
                <label class="twoFilter" for="t{$lstCatTour[i].tourcat_id}">{$lstCatTour[i].title}</label>
            </li>
            {/section}
        </ul>
    </div>
    {if $clsConfiguration->getValue('SiteHasActivities_Tours')}
    <div class="findBox border_0">
        <h3>{$core->get_Lang('TRAVEL ACTIVITIES')}</h3>
        <ul class="filter common_wrapper_details tour_types checkBlock">
            {section name=i loop=$lstActivities}
            <li>
                <input id="a{$lstActivities[i].activities_id}" class="typeSearch" name="activities_id[]" value="{$lstActivities[i].activities_id}" type="checkbox" {if $clsISO->checkInArray($activities_id,$lstActivities[i].activities_id)}checked="checked"{/if} />
                <label class="twoFilter" for="a{$lstActivities[i].activities_id}">{$lstActivities[i].title}</label>
            </li>
            {/section}
        </ul>
    </div>
    {/if}
</form>
<script >
	var day='{$core->get_Lang("day")}';
	var days='{$core->get_Lang("days")}';
	var cat_id='{$cat_id}';
	var country_id= '{$country_id}';
	var min_duration_value = '{$min_duration_value}';
	var max_duration_value = '{$max_duration_value}';
	var min_duration_search = '{$min_duration_search}';
	var max_duration_search = '{$max_duration_search}';
</script> 
{literal} 
<script >
$(function() {
    $( "#slider-range" ).slider({
		range: true,
		min: parseInt(min_duration_value),
		max: parseInt(max_duration_value),
		values: [min_duration_search, max_duration_search],
		slide: function( event, ui ) {
			$( "#duration_0" ).html(ui.values[0] +' '+ day);
			$( "#duration_1" ).html(ui.values[1] +' '+ days);
			$( "#duration1" ).val(ui.values[0]);
			$( "#duration2" ).val(ui.values[1]);
			$('#filters_form').submit();
		}
    });
    $("#duration_0").html($("#slider-range").slider("values", 0) +' '+ days);
	$("#duration_1").html($("#slider-range").slider("values", 1) +' '+ days);
});
</script> 
{/literal}
{literal}
<style>
.readMoreClass{position:relative}
.readMoreClass .section_expander{position:absolute; width:50px; bottom:0; right:0; color:#f16f30}
.common_wrapper_details{overflow:hidden}
@media (max-width: 991px){
.modal_quick_center{top: 0;width: 100%;text-align: left}
.findTripDestination.display_des{max-height: 100%;overflow-y: hidden}
#filter_search.modal, #modalQuickSearch.modal{padding-right: 0}
.findTripDestination ul li a {
font-size: 22px;
color: #1c1c1c;
font-weight: 500;
margin-bottom: 20px;
display: block;
}
.findTripDestination ul li {
list-style: none;
margin-bottom: 30px;
}
ul#radio li label{font-weight: 400}
.modal-content{border-radius: 0;border: 0}
}
</style>
<script >
$('#filters_form .typeSearch').change(function(){
	$(this).closest('form').submit();
});
</script> 
{/literal}