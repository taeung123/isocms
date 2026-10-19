{foreach from=$list_hotel key=k item=v}
{assign var=hotel_check value=$clsCombo->checkListHotelRoomCheck($combo_id,$k)}
<div class="hotel_item" combo_id="{$combo_id}">
	<table class="table_hotel_price full-width">
		<thead>
			
			<tr>
				<th class="text_center" style="width:40px">
				<input {if $hotel_check==1}checked{/if} data-hotel_id="{$k}" type="checkbox" class="check_all_room"/>
				</th>
				<th class="title" colspan="2">{$clsHotel->getTitle($k)}</th>
			</tr>
		</thead>
		{assign var=listRoom value=$clsHotel->getRoomHotel($k)}
		{assign var=list_hotel_room_id value=$clsCombo->getListRoomCheck($combo_id,$k)}
		
		<tbody>
			{section name=i loop=$listRoom}
			{assign var=number_adult value=$clsHotelRoom->getNumberAdult($listRoom[i].hotel_room_id)}
			{assign var=number_child value=$clsHotelRoom->getNumberChild($listRoom[i].hotel_room_id)}
			
			<tr>
				<td class="text_center"><input hotel_id="{$k}" {if in_array($listRoom[i].hotel_room_id, $list_hotel_room_id)} checked{/if}  data-hotel_id="{$k}" data-hotel_room_id="{$listRoom[i].hotel_room_id}" type="checkbox" class="room-checkbox"/></td>
				<td class="border_right_0">
				<p class="room_name mb0">{$clsHotelRoom->getTitle($listRoom[i].hotel_room_id)}</p>
				<p class="note_people">({$core->get_Lang('Max')} {$number_adult} {$core->get_Lang('Adults')}{if $number_child},{$number_child} {$core->get_Lang('Child')}{/if})</p>
				</td>
				{if in_array($listRoom[i].hotel_room_id, $list_hotel_room_id)}
				<td class="td_price" style="width: 270px">
					<div class="price_hotel_room"><input type="text" data-hotel_id="{$k}" data-hotel_room_id="{$listRoom[i].hotel_room_id}" value="{$clsCombo->getPriceHotelRoom($combo_id,$k,$listRoom[i].hotel_room_id)}" class="price_room price-In"/><span class="price_text">{$clsISO->getRate()}</span></div>
				</td>
				{else}
				<td class="border_left_0" style="width: 0">
				</td>
				{/if}
			</tr>
			{/section}
		</tbody>
	</table>
</div>
{/foreach}
{literal}
<script>
$(document).on('click', '.check_all_room', function(ev){
	var _this=$(this),
		hotel_id=_this.data('hotel_id'),
		tp=		'ALL_ROOM',
		val 	 =  _this.is(':checked')?1:0;
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveComboPriceTable",
		data: {"combo_id":table_id,"hotel_id":hotel_id,"tp":tp,"val":val},
		dataType: "html",
		success: function(html){
			loadComboPriceTable(table_id);
		}
	});
});
$(document).on('click', '.room-checkbox', function(ev){
	var _this = $(this),
		combo_id =  table_id,
		hotel_id 	 =  _this.data('hotel_id'),
		hotel_room_id 	 =  _this.data('hotel_room_id'),
		tp				= 	'CHOOSE',
		val 	 =  _this.is(':checked')?1:0;
		
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveComboPriceTable",
		data: {"combo_id":combo_id,"hotel_id":hotel_id,"hotel_room_id":hotel_room_id,"val":val,"tp":tp},
		dataType: "html",
		success: function(html){
			loadComboPriceTable(combo_id);
		}
	});
});
$(document).on('change', '.price_room', function(ev){
	var _this = $(this),
		combo_id =  table_id,
		hotel_id 	 =  _this.data('hotel_id'),
		hotel_room_id 	 =  _this.data('hotel_room_id'),
		price_room 	 =  _this.val(),
		tp = 'PRICE';
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveComboPriceTable",
		data: {"combo_id":combo_id,"hotel_id":hotel_id,"hotel_room_id":hotel_room_id,"price_room":price_room,"tp":tp},
		dataType: "html",
		success: function(html){
			loadComboPriceTable(combo_id);
		}
	});
});
$(document).on('click', '.clickEditHotel', function(ev) {
	var _this = $(this),
		combo_id =  _this.data('combo_id'),
		hotel_id =  _this.data('hotel_id');
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxGetBoxHotelCombo',
		dataType: "html",
		data: {"table_id":combo_id,"hotel_id":hotel_id,"tp":'EDIT'},
		success: function(html) {
			makepopup('700px', 'auto', html, 'pop_HotelCombo');
			$('#pop_HotelCombo').css('top', '30px');
			vietiso_loading(0);
		}
	});
	return false;
});
</script>
{/literal}