<div class="searchBox">
	<p class="title_box sỉze15">{$core->get_Lang('Order combo to get the most attractive price')}!</p>
	<form class="find__trip--form" id="form_avaiable" method="post" action="">
		<h3 class="title_details size18">
			{$core->get_Lang('Hotel details')}
		</h3>
		<div class="form_search">
			{if $act ne 'detail'}
			<div class="input_key_word">
				<label>{$core->get_Lang('Destination')}</label>
				<input type="search" class="form-control destination" name="keyword" autocomplete="off" role="presentation" id="searchkey" value="{if $hotel_id}{$clsHotel->getTitle($hotel_id)}{else}{$clsCity->getTitle($city_id)}{/if}" placeholder="{$core->get_Lang('Điểm đến, thành phố')}....">
				<div class="autosugget" id="autosugget" style="display: none">
					<ul class="HTML_sugget"></ul>
				</div>
			</div>
			{/if}
			<div class="form-group">
				<label>{$core->get_Lang('Check in')}</label>
				<input readonly id="checkin" type="text" value="{$clsISO->converTimeToText5($now)}" class="form-control" placeholder="{$core->get_Lang('Check in')}" />
			</div>
			<div class="form-group">
				<label>{$core->get_Lang('Check out')}</label>
				<input readonly id="checkout" type="text" value="{$clsISO->converTimeToText5($now_next)}" class="form-control" placeholder="{$core->get_Lang('Check in')}" />
			</div>
			<div class="form-group form-passenger">
				<label>{$core->get_Lang('Passenger')}</label>
				<select class="passenger" name="passenger">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</div>
			<div class="form-group form-room">
				<label>{$core->get_Lang('Room')}</label>
				<select class="room_number" name="room_number">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</div>
		</div>
		<div class="btn_submit">
			<button type="submit" class="btn btn_find_trip" id="findtBtn">{$core->get_Lang('Find savings combos')}</button>
			<input type="hidden" name="hid_search" value="Search_Combo" />
			<input type="hidden" name="keywordType" id="keywordType" value="" />
			<input type="hidden" name="checkin" id="check_in" value="{$clsISO->formatDateAPI($now)}" />
			<input type="hidden" name="checkout" id="check_out" value="{$clsISO->formatDateAPI($now_next)}" />
		</div>
	</form>
</div>
<script>
	var duration= '{$duration_1}';
	var number_room= '{$clsHotel->getOneField("number_stay",$hotel_id)}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
	var Loading = '{$core->get_Lang("Loading")}';
	var night='{$core->get_Lang("night")}';
	var nights='{$core->get_Lang("nights")}';
	var Today='{$core->get_Lang("Today")}';
	var Adult='{$core->get_Lang("Adult")}';
    var Child='{$core->get_Lang("Children")}';
    var Infant='{$core->get_Lang("Infant")}';
    var room='{$core->get_Lang("room")}';
	var checkin='{$checkin}';
	var checkout='{$checkout}';
	var checkin1='{$checkin1}';
	var checkout1='{$checkout1}';
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
</script>
{literal}
<script>
$(document).ready(function(){
	getNumberPerson();
	$('#checkin').datepicker({
		dateFormat: 'DD, dd/mm/yy',
		minDate: "+0D", maxDate: "+1Y",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		onSelect: function(dateStr) { 
			var date = $(this).datepicker('getDate'); 
			if(date){ 
				date.setDate(date.getDate() + 1); 
			} 
			loadTextDayCheckIn($(this).val());
			$('#checkout').datepicker('option', {minDate: date}).datepicker('setDate', date); 
		},
		onClose: function(dateText, inst) {
			$('#checkout').focus();
		}
	});
	$("#checkout").datepicker( { 
		dateFormat: 'DD, dd/mm/yy',
		minDate: new Date(), maxDate: "+1Y",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		onSelect: function(dateStr) { 
			loadTextDayCheckOut($(this).val());
		},
	});	
	$('#searchkey').click(function() { 
		search_place();
		$('.bg-black').show();
		if($('#pick_travellers').hasClass('open')){
			$('#check_number_travellers').hide();
			$('#pick_travellers').removeClass('open');
		}
	});
	
	$("#searchkey").on('keyup', delay(function(){
		var $_this=$(this),
			keySearch = $.trim($_this.val());
			search_place();
	},600));

	
	$('#pick_travellers').click(function(){
		$('.bg-black').show();
		$('#autosugget').hide();
		var  $_this=$(this);
		if($_this.hasClass('open')){
			$('#check_number_travellers').hide();
			$_this.removeClass('open');
		}else{
			$('#check_number_travellers').show();
			$_this.addClass('open');
		}
	});
	$('.bg-black').click(function () {
        $('.bg-black').hide();
		if($('#pick_travellers').hasClass('open')){
			$('#check_number_travellers').hide();
			$('#pick_travellers').removeClass('open');
		}
		$('#autosugget').hide();
    });
	
	$(document).on('click', ".select_item", function(ev) {	
		var keyword = $(this).data('name');
		var keywordType = $(this).data('type');
		$('#searchkey').val(keyword);
		$('#keywordType').val(keywordType);
		$('#autosugget').hide();
	});
});
</script>
<script>

function delay(callback, ms) {
	var timer = 0;
	return function() {
	var context = this, 
		args = arguments;
	clearTimeout(timer);
	timer = setTimeout(() => {
		callback.apply(context, args); 
	}, ms || 2);
  }
}
function loadTextDayCheckIn(date){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod='+mod+'&act=loadCheckDate&lang='+LANG_ID,
		'data' : {"date":date},
		'dataType': 'html',
		'success':function(html){
			$("#check_in").val(html);
		}
	});
}
function loadTextDayCheckOut(date){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod='+mod+'&act=loadCheckDate&lang='+LANG_ID,
		'data' : {"date":date},
		'dataType': 'html',
		'success':function(html){
			$("#check_out").val(html);
		}
	});
}
function search_place(){
	$.ajax({
		type:'POST',
		url:path_ajax_script+'/index.php?mod=combo&act=ajGetSearchPlace&lang='+LANG_ID,
		data:{"keyword":$("#searchkey").val()},
		dataType:'html',
		success:function(html){
			if(html.indexOf('_EMPTY')>=0){
				$('#autosugget').hide();
			}else{
				$('#autosugget').stop(false,true).slideDown();
				$('#autosugget').find('.HTML_sugget').html(html);
			}
		}	
	});
}

function loadMaxPeople(homestay_id,number_adult,number_child,number_room){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=homestay&act=loadMaxPeople&lang='+LANG_ID,
		'data' : {"homestay_id":homestay_id,"number_adult":number_adult,"number_child":number_child,"number_room":number_room},
		'dataType': 'html',
		'success':function(html){
			var htm = html.split('|||');
			$("#number_adult").attr("max",htm[1]);
			$("#number_child").attr("max",htm[2]);
			
		}
	});
}
function getNumberPerson(){
	var number_adult=$('#number_adult').val();
	var number_child=$('#number_child').val();
	var number_infant=$('#number_infant').val();
	var number_room=$('#number_room').val();
	if(act=='detail'){
	   loadMaxPeople($hotel_id,number_adult,number_child,number_room);
	}
	
	$('#people_text').html( number_adult + ' ' +Adult+', ' +number_child+' '+Child);
	$('#room_text').html( number_room + ' ' +room);
}
function loadTablePrice(){
	$('#TablePrice').html('<div class="lazy_loading text-center"><img src="{/literal}{$URL_IMAGES}/icon/lazy_load_100_pink.svg{literal}" alt=""></div>');
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=loadTablePrice&lang='+LANG_ID,
		data : $('#form_avaiable').serialize(),
		dataType:'html',
		success: function(html){
			$('#TablePrice').html(html);
			$('[data-toggle="popover"]').popover();
		}
	});
}

</script>
<style>
.ComboPlacePage .searchBox{background: #fff;border-radius: 5px;max-width: 1062px;margin: 0 auto;margin-top: -185px;position: relative;margin-bottom: 100px;box-shadow: 0 2px 7px 0 #e1e1e1;}
.searchBox .title_box{
background: #fdd835;
font-size: 15px;
font-weight: 700;
padding: 12px 28px;
border-radius: 5px 5px 0 0;margin-bottom: 0;
}
.find__trip--form .title_details {
margin-bottom: 17px;
}
.find__trip--form .form-control .destination{
}
.form_search .form-group{margin-right: 18px}
.form_search .form-group:last-child{margin-right: 0}
.form-group select{
width: 165px;
height: 41px;
padding: 6px 12px;
border: 1px solid #ebebeb;
border-radius: 2px;
background: #f5f5f5;
}
button.btn_find_trip{
height: 41px;
display: inline-block;
float: right;
width: 100%;
max-width: 225px;
background: #fdd835;
font-size: 18px;
font-weight: 700;
border-radius: 30px;margin-top: 15px;
}
.btn_submit{display: inline-block;width: 100%}
.form_search label{margin-bottom: 10px;font-size: 15px}
/*-------------*/
.banner img{min-height: 200px;max-height: 447px}
.hotel_detail_box .box_check_rates{display: inline-block; width: 100%; background: #f8f8f8; padding: 18px 18px 25px;}
.hotel_detail_box .searchBox{background: #f8f8f8;}
.hotel_detail_box .searchBox .container{width: 100%; padding: 0}
.find__trip--form{width:100%;padding: 30px 28px 20px; position: relative; z-index: 10;background: #fff;}
.find__trip--form .form_search{display: flex}
.hotel_detail_box .find__trip--form{padding:0;}
.box_search_home{position:absolute;width:100%;bottom:-32px;z-index:1}
#autosugget{width:270px; position: absolute; z-index: 99}
#autosugget:before{
display: block;
width: 0;
height: 0;
border-left: 11px solid transparent;
border-right: 11px solid transparent;
border-bottom: 11px solid #fff;
margin-left: 168px;
content: "";
transition: margin-left .3s ease-out;
}
#autosugget .listRoomDetail,#autosugget .totalRoom{font-size: 13px;color: #666}
.HTML_sugget {
position: relative;
z-index: 9;
background: #f5f5f5;
color: #333;
display: inline-block;
width: 100%;
margin: 0;
padding-left: 0;
border-radius: 5px;
}
.HTML_sugget .select_item{display: inline-block; width: 100%; cursor: pointer;padding: 12px 15px 0;}
.HTML_sugget .select_item .location{display: inline-block; width: 100%;}
.select_item  .icon-Location{font-size: 24px; line-height: 24px; display: inline-block;color: rgb(128, 128, 128); vertical-align: middle}
.HTML_sugget .select_item .location .name_location{display: inline-block; float: left}
.HTML_sugget .select_item .location .type_location{display: inline-block; float: right}
.name_location .text_name{display: inline-block; line-height: 24px; font-weight: bold}
.type_location .text_type{color: #173d8f; font-size: 12px; line-height: 24px;}
.parent_location .text_parent{font-size: 12px;color: rgb(128, 128, 128)}
.find__trip--form .form-control{height:41px;background:#fff;color:#1c1c1c; border: 1px solid #ebebeb;width: 165px;background: #f5f5f5;    box-shadow: none;border-radius: 2px}
.find__trip--form .form-control.destination{width: 270px}
.find__trip--form .form-control#searchkey:focus{ border-color:#ec1c47;}
.input_key_word{width:100%;max-width:270px;margin-right:18px;position: relative}
.input_key_word:before{position: absolute;content: "";background: url("/isocms/templates/default/skin/images/icon/sprite_icon_form_search.png") no-repeat;width: 30px;height: 25px;top: 15px;left: 20px}
.input_key_word .fa-search{position: absolute;top: 15px;left: 20px;color: #ccc;font-size: 22px}
.form_select{width:100%;margin-right:5px;height: 41px;max-width:350px;display: flex;}
.hotel_detail_box .form_select{margin-right: 10px;max-width:350px}
.date_local{background: #fff; border-radius: 4px;}
.form_select.form_select_people{max-width:285px;display: block;position: relative; background: #fff; border-radius: 4px; border: 1px solid #ccc}
.hotel_detail_box .form_select.form_select_people{max-width:calc(100% - 510px);display: block;position: relative; background: #fff; border-radius: 4px; border: 1px solid #ccc;}
.pick_travellers{display: inline-block;width: 100%;padding: 6px 12px;height: 41px;position: relative;border-radius: 4px;}
.pick_travellers.open{border: 1px solid #ec1c47;}
.pick_travellers:before {
width: 33px;
height: 26px;
content: "";
background: url(/isocms/templates/default/skin/images/icon/sprite_icon_form_search.png) no-repeat;
background-position: 0 -28px;
position: absolute;
left: 20px;
top: 14px;
}
@media only screen and (max-width: 1400px){
.ComboPlacePage .searchBox{margin-top: -100px}
}
@media only screen and (max-width: 1199px){
.form_search .form-group{width: 20%}
.input_key_word{width: 25%}
.find__trip--form .form-control.destination{width: 100%}
.form_search .form-group.form-passenger{width: 15.25%}
.form_search .form-group.form-room{width: 15.25%}
.form-group.form-passenger select{width: 100%}
.form-group.form-room select{width: 100%}
.ComboPlacePage .searchBox{margin-top: -100px;}
}
@media only screen and (max-width:1024px){

}
@media only screen and (max-width:991px){
.ComboPlacePage .searchBox{margin-top: -45px;}
.find__trip--form .form_search{display: block}
.input_key_word {
width: 100%;max-width: 100%;margin-bottom: 15px
}
.form_search .form-group {
width: 50%;
float: left;margin-right: 0
}
.form_search .form-group.form-passenger{width: 50%}
.form_search .form-group.form-room{width: 50%}
.form-group.form-passenger select {
width: 100%;
}
.form-group.form-room select {
width: 100%;
}
.find__trip--form .form-control{width: 100%}
}
@media (max-width:767px){
.ComboPlacePage .searchBox {
margin-top: 25px;
margin-bottom: 50px;
}
.find__trip--form{
padding: 30px 5px 20px;
}
}
@media (max-width:500px){
	.form_search .form-group{width: 100%}
	.form_search .form-group.form-passenger{width: 100%}
	.form_search .form-group.form-room{width: 100%}
}
</style>
{/literal}