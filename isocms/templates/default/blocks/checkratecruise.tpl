<form action="" method="post" style="position: relative;" class="check-rooms bg-f6">
    <div class="form-group has-feedback wf1">
    <label class="control-label control-label-xs">{$core->get_Lang('Cruise Duration')}:</label>
    <select class="form-control" name="cruise_itinerary_id">
        {section name=i loop=$lstItineray}
        <option {if $num_day_price eq $lstItineray[i].number_day} selected="selected" {/if} value="{$lstItineray[i].cruise_itinerary_id}">{$clsCruiseItinerary->getTitle($lstItineray[i].cruise_itinerary_id)}</option>
        {/section}
    </select>
    
    </div>
    <div class="form-group has-feedback wf01">
    <label class="control-label control-label-xs">{$core->get_Lang('Check-in')}:</label>
    <input id="departure_date" name="departure_date" value="{$clsISO->formatTimeDateEn($now_next)}" autocomplete="off" maxlength="10" size="10" class="form-control isoshortdatepicker" placeholder="mm/dd/yyyy" />
    </div>
    
    
    <div class="form-group has-feedback wf01">
    <label class="control-label control-label-xs">{$core->get_Lang('Cabin Type')}:</label>
    <select class="form-control" name="cruise_property_id">
        {section name=i loop=$listTypeRoom}
        <option value="{$listTypeRoom[i].cruise_property_id}">{$clsCruiseProperty->getTitle($listTypeRoom[i].cruise_property_id)}</option>
        {/section}
    </select>
    </div>
    <div class="form-group has-feedback wf01">
    <label class="control-label control-label-xs">{$core->get_Lang('Adult(s)')}:</label>
    <select class="form-control" name="num_adult">
        {$clsISO->getSelect(1,10,$adult.$cruise_cabin_id)}
    </select>
    </div>
   <!-- <div class="form-group has-feedback wf001">
    <label class="control-label control-label-xs">{$core->get_Lang('Child(ren)')}:</label>
    <select class="form-control" name="num_child">
        {$clsISO->getSelect(0,10,$child.$cruise_cabin_id)}
    </select>
    </div>-->
    
    
    <input id="mrdt_button_submit" class="btn btn-style-2a z_16 text-bold" type="button" value="{$core->get_Lang('Check Rates')}" name="mrdt_button_submit" />
    <input type="hidden" name="cruise_id" value="{$cruise_id}" />
</form>


{literal}
<script type="text/javascript">
$(function(){
	$('#mrdt_button_submit').click(function() {
		
		
		var $cruise_itinerary_id = $('select[name=cruise_itinerary_id]').val();
		var $departure_date = $('input[name=departure_date]').val();
		var $cruise_property_id = $('select[name=cruise_property_id]').val();
		var $num_adult = $('input[name=number_adult_1]').val();
		var $num_child = $('input[name=number_child_1]').val();
		var $ww = $(window).width();
		if($ww>992){
		loadPriceCabin($cruise_itinerary_id,$departure_date,$cruise_property_id,$num_adult,$num_child);
		}else{
		loadPriceCabinMobile($cruise_itinerary_id,$departure_date,$cruise_property_id,$num_adult,$num_child);
		}
	});
	
});
</script>
{/literal}
{literal}
<script type="text/javascript">
function loadPriceCabin($cruise_itinerary_id,$departure_date,$cruise_property_id,$num_adult,$num_child){
	var $_adata = {
		'cruise_id': $cruise_id,
		'cruise_itinerary_id': $cruise_itinerary_id,
		'departure_date' : $departure_date,
		'cruise_property_id': $cruise_property_id,
		'num_adult' : $num_adult,
		'num_child': $num_child
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=loadPriceCabin',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('#hiddenCheckRate').hide();
			$('#blockCheckRate').html(html);
		}
	});
}
function loadPriceCabinMobile($cruise_itinerary_id,$departure_date,$cruise_property_id,$num_adult,$num_child){
	var $_adata = {
		'cruise_id': $cruise_id,
		'cruise_itinerary_id': $cruise_itinerary_id,
		'departure_date' : $departure_date,
		'cruise_property_id': $cruise_property_id,
		'num_adult' : $num_adult,
		'num_child': $num_child
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=loadPriceCabinMobile',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('#hiddenCheckRateMobile').hide();
			$('#blockCheckRateMobile').html(html);
		}
	});
}

</script>
{/literal}