<section class="search_box_hotel_detail mb60 phone_mb30">
	<div class="entry_header_box_search bg_main">
		<h2>{$core->get_Lang('Check room rates')}<span class="icon-crd ic-search"></span></h2>
	</div>
	<div class="entry_body_search">
		<p>{$core->get_Lang('Book now to get this fantastic price')}</p>
		<form class="find_a_hotel_box" method="post" action="{$extLang}">
			<div class="form-group input-date">
				<input name="check_in" id="check_in" type="text" value="{$clsISO->formatTimeDate($now_next)}" class="form-control full-width" placeholder="{$core->get_Lang('Check in')}" />
			</div>
			<div class="form-group input-date">
				<input name="check_out" id="check_out" type="text" value="{$clsISO->formatTimeDate($now_next_2_day)}" class="form-control full-width" placeholder="{$core->get_Lang('Check out')}" />
			</div>
			<div class="form-group">
				<div class="select_arow">
					<input id="ip-room" value="1 {$core->get_Lang('Room')}, 2 {$core->get_Lang('Adults')}, 0 {$core->get_Lang('Children')}" class="form-control"/>
					<span id="show_check_rate"></span>
				</div>
				<div class="cd-sub cd-sub-room" style="display: none;"> <span class="fa fa-times cd-sub-close fr"></span>
					<div class="line width100 mb10">
						<label class="control-label">{$core->get_Lang('Room')}</label>
						<select class="form-control form-control-angle-down" name="number_room" id="number_room">
							<option value="1" selected="selected">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
					<div id="listRoom" class="mb20">
						<div class="room-chose">
							<h4 class="text-bold mb10">{$core->get_Lang('Room')} 1</h4>
							<div class="row">
								<div class="col-xs-3 line">
									<label class="control-label-sm">{$core->get_Lang('Adult(s)')}</label>
									<input type="number" class="form-control number_adult" value="1" name="number_adult_1" data-type_number="1" min="1" max="{$max_adult}" />
								</div>
								<div class="col-xs-3 line">
									<label class="control-label-sm">{$core->get_Lang('Child(ren)')}</label>
									<input type="number" class="form-control number_child" value="0" name="number_child_1" data-type_number="1" min="0" max="{$max_child}" />
								</div>
							</div>
						</div>
					</div>
					<div class="room-chose">
						<button class="btn btn-style-1 z_14 text-bold text-center btn_main" type="button" onClick="$('.cd-sub-room').hide();">OK</button>
					</div>
				</div>
			</div>
			<div class="line txC">
				<input type="hidden" name="hotel_id" id="hotel_id" value="{$hotel_id}" />
				<input type="hidden" name="number_adult" id="number_adult" value="1" />
				<input type="hidden" name="number_child" id="number_child" value="0" />
				<input type="hidden" name="hidFind" value="hidHotel" />
				<input id="mrdt_button_submit" name="mrdt_button_submit" class="btn-find_hotel scollspy btn_main" type="button" value="{$core->get_Lang('Make reservations')}"/>
			</div>
		</form>
	</div>
</section>
<script>
var max_adult = "{$max_adult}";
var max_child = "{$max_child}";
var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
var Room='{$core->get_Lang("Room")}';
var Room='{$core->get_Lang("Room")}';
var Adults='{$core->get_Lang("Adults")}';
var Children='{$core->get_Lang("Children")}';
var Child_1_Age='{$core->get_Lang("Child 1 Age")}';
var Child_2_Age='{$core->get_Lang("Child 2 Age")}';
var SelectAgeChild='{$clsISO->makeSelectNumberAgeChild($clsConfiguration->getValue("ChildMaxAgePolicy"))}';
</script>

{if $_LANG_ID=='vn'}
<script>
var dateFormat = "dd/mm/yy";
</script>
{else}
<script>
var dateFormat = "mm/dd/yy";
</script>
{/if}

{literal}
<script>
$(function () {
    $('#check_in').datepicker({
        dateFormat: dateFormat, 
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
            $('#check_out').datepicker('option', {minDate: date}).datepicker('setDate', date); 
        },
        onClose: function(dateText, inst) {
            $('#check_out').focus();
        }
    });
    $("#check_out").datepicker( { 
        dateFormat: dateFormat, 
        minDate: new Date(), maxDate: "+1Y",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOtherMonths: true
    });	
});
</script>
<script >
$(function(){
	loadPriceRoom($('select[name=hotel_id]').val(),$('input[name=check_in]').val(),$('select[name=check_out]').val(),$('input[name=number_adult]').val(),$('select[name=number_room]').val());
	getNumberPerson();
	$(document).on("change",".number_adult",function(){
		if(parseInt($(this).val()) >= 0 && parseInt($(this).val()) <= max_adult){
			getNumberPerson();
			}else{
			alert(Input_data_is_invalid);
			$(this).val(max_adult);
			getNumberPerson();
		}
		
	});
	$(document).on("change",".number_child",function(){
		if(parseInt($(this).val()) >= 0 && parseInt($(this).val()) <= max_child){
			getNumberPerson();
			}else{
			alert(Input_data_is_invalid);
			$(this).val(max_child);
			getNumberPerson();
		}
	});
	$(document).on("change","#number_room",function(){
		appendRoom();
		getNumberPerson();
	});
	$(document).on("change",".number_child",function(){
		var $_this = $(this);
		var $room_index =$_this.attr("data-type_number");
		if($_this.val()==1){
			$('#conchild'+$room_index+'s_1').show();
			$('#conchild'+$room_index+'s_2').hide();
			$('#infant'+$room_index+'s_1').val(0);
			$('#infant'+$room_index+'s_2').val('');
		}else if($_this.val()==2){
			$('#conchild'+$room_index+'s_1').show();
			$('#conchild'+$room_index+'s_2').show();
			$('#infant'+$room_index+'s_2').val(0);
		}else{
			$('#conchild'+$room_index+'s_1').hide();
			$('#infant'+$room_index+'s_1').val('');
			$('#conchild'+$room_index+'s_2').hide();
			$('#infant'+$room_index+'s_2').val('');
		}
	});
	$('#ip-room').click(function(){
		if($(this).hasClass('open')){
			$('.cd-sub-room').hide();
			$(this).removeClass('open');
			$('#show_check_rate').removeClass('open');
		}else{
			$('.cd-sub-room').show();
			$(this).addClass('open');
			$('#show_check_rate').addClass('open');
		}
	});
	$('.cp-dropdown').click(function(){
		if($(this).hasClass('open')){
			$('.child_Police-detail').hide();
			$(this).removeClass('open');
		}else{
			$('.child_Police-detail').toggle(400);
			$(this).addClass('open');
		}
	});
	$('.cd-sub-close').click(function(){
		$('#ip-room').removeClass('open');
		$('#show_check_rate').removeClass('open');
		$('.cd-sub-room').hide();
	});
	$('.cp-detail-close').click(function(){
		$('.cp-dropdown').removeClass('open');
		$('.child_Police-detail').hide();
	});
	$('#mrdt_button_submit').click(function() {
		$('.cd-sub-room').hide();
		$('#show_check_rate').removeClass('open');
		var $hotel_id = $('select[name=hotel_id]').val();
		var $check_in = $('input[name=check_in]').val();
		var $check_out = $('input[name=check_out]').val();
		var $number_adult = $('input[name=number_adult]').val();
		var $number_child = $('input[name=number_child]').val();
		var $number_room = $('select[name=number_room]').val();
		var $ww = $(window).width();
		$('html, body').animate({
			scrollTop: $('#blockCheckRate').offset().top - 10
		 	}, 1200, function(){
		 });
		 loadPriceRoom($hotel_id,$check_in,$check_out,$number_adult,$number_child,$number_room); 
		
	});
	$(".tb-show-price a.scollspy").on('click', function(event) {
		if (this.hash !== "") {
			event.preventDefault();
			var hash = this.hash;
			$('html, body').animate({
				scrollTop: $(hash).offset().top - 70 
				}, 800, function(){
				window.location.hash = hash;
			});
		} 
	});
	var stickyOffsetSearch = $('.box_gallery').offset().top - 150;
	var stickyOffsetOutSearch =$('#show_check_rate').offset().top - 50;
	var $ww = $(window).width();
	var $wc = $('.container').width();
	var $wlf = ($ww - $wc)/2;
	var $width_box_search = $('.search_box_hotel_detail').width();
});
</script>
{/literal}
{literal}
<script>
function loadPriceRoom($hotel_id,$check_in,$check_out,$number_adult,$number_child,$number_room){
	var $_adata = {
		'hotel_id': $hotel_id,
		'check_in' : $check_in,
		'check_out': $check_out,
		'number_adult' : $number_adult,
		'number_child' : $number_child,
		'number_room': $number_room,
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=hotel2&act=loadPriceRoom&lang='+LANG_ID,
		data : $('.find_a_hotel_box').serialize(),
		dataType:'html',
		success: function(html){
			$('#hiddenCheckRate').remove();
			$('#blockCheckRate').html(html);
		}
	});
}

function getNumberPerson(){
	var $totalAdult = 0;
	$('.number_adult').each(function() { 
		$totalAdult += parseInt($(this).val());
	});
	$('#number_adult').val($totalAdult);
	var $totalChild = 0;
	$('.number_child').each(function() { 
		$totalChild += parseInt($(this).val());
	});
	$('#number_child').val($totalChild);
	$('#ip-room').val(+$("#number_room").val()+' '+Room+', ' +$totalAdult+' '+Adults+', ' +$totalChild+' '+Children);
}

function appendRoom(){	
	var x = 0;
	var y = 1;
	$('#listRoom').html('');
	for(i = 1;i <=$('#number_room').val();i++){
		customer = new createCustomerInfo($('#listRoom'));
		x++;
		y++;
	}
}
function createCustomerInfo(obj){
	var $ww = $(window).width();
	this.div=$('<div class="room-chose mb20"><h4 class="text-bold mb10">'+Room+' '+i+'</h4><div class="row"><div class="col-xs-3 line"><label class="control-label-sm">'+Adults+'</label><input type="number" class="form-control number_adult" value="2" name="number_adult_'+i+'" data-type_number="1" min="1" max="'+max_adult+'" /></div><div class="col-xs-3 line"><label class="control-label-sm">'+Children+'</label><input type="number" class="form-control number_child" value="0" name="number_child_'+i+'" data-type_number="'+i+'" min="0" max="2" /></div><div></div>');
	obj.append(this.div);
}
</script>
<style >
.width100{width: 100px !important}
#listRoom{display:inline-block!important;width:100%}
#listRoom .row{margin-left:-6px!important;margin-right:-6px!important}
#listRoom .control-label-sm{font-weight:400!important;font-size:12px!important}
#listRoom .col-xs-3{padding-left:6px!important;padding-right:6px!important}
.find_a_hotel_box .form-group{position:relative}
.find_a_hotel_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:-415px;z-index:3;width:400px;top:-232px;min-height:300px;color:#333;background-color:#f6f8f9;border:1px solid #ccc;-webkit-border-radius:5px;-khtml-border-radius:5px;-moz-border-radius:5px;-ms-border-radius:5px;-o-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);-moz-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);box-shadow:0 6px 13px -4px rgba(24,22,24,0.3)}
.find_a_hotel_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:-415px;z-index:3;width:400px;top:52px;left:0;min-height:300px;color:#333;background-color:#f6f8f9;border:1px solid #ccc;-webkit-border-radius:5px;-khtml-border-radius:5px;-moz-border-radius:5px;-ms-border-radius:5px;-o-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);-moz-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);box-shadow:0 6px 13px -4px rgba(24,22,24,0.3)}
.find_a_hotel_box .cd-sub-room .btn-style-1{width:130px;height:38px;margin-right:10px;}
#show_check_rate{position:absolute;right:0;top:17px}
.search_box_hotel_detail #show_check_rate{position:absolute;right:auto;top:42px;left:50px}
#show_check_rate.open:before,#show_check_rate.open:after{bottom:100%;top:0;right:-16px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:1}
#show_check_rate.open:before{border-right-color:#ccc;border-width:14px;margin-top:-14px}
#show_check_rate.open:after{border-right-color:#f6f8f9;border-width:13px;margin-top:-13px}
.search_box_hotel_detail #show_check_rate.open:before,.search_box_hotel_detail #show_check_rate.open:after{bottom:100%;top:-3px;right:-16px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:4}
.search_box_hotel_detail #show_check_rate.open:before{border-bottom-color:#ccc;border-width:14px;margin-top:-14px}
.search_box_hotel_detail #show_check_rate.open:after{border-bottom-color:#f6f8f9;border-width:14px;margin-top:-13px}
.cd-sub-close,.cp-detail-close{font-size:18px;cursor:pointer}
.search_box_hotel_detail .fixed{position:fixed!important;top:85px!important}
@media (max-width: 991px) {
.find_a_hotel_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:0;z-index:9;width:100%;max-width:400px;top:-313px}
#show_check_rate{position:absolute;right:0;top:0}
#show_check_rate.open:before,#show_check_rate.open:after{bottom:100%;top:3px;right:300px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:10;display:none}
#show_check_rate.open:after{border-top-color:#f6f8f9;border-width:13px;margin-top:-13px}
#show_check_rate.open:before{border-top-color:#ccc;border-width:14px;margin-top:-14px}
.search_box_hotel_detail #show_check_rate.open:before,.search_box_hotel_detail #show_check_rate.open:after{bottom:100%;top:-3px;right:-16px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:4}
.search_box_hotel_detail #show_check_rate.open:before{border-bottom-color:#ccc;border-width:14px;margin-top:-14px}
.search_box_hotel_detail #show_check_rate.open:after{border-bottom-color:#f6f8f9;border-width:14px;margin-top:-13px}
}
@media (max-width:524px) {
.search_box_hotel_detail .find_a_hotel_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:-415px;z-index:3;width:100%;max-width:400px}
}
@media (max-width:430px) {
.entry_body_search{padding:15px 8px}
.search_box_hotel_detail .find_a_hotel_box .form-group .cd-sub-room{padding:15px 6px}
#listRoom .row{margin-left:-3px!important;margin-right:-3px!important}
#listRoom .col-xs-3{padding-left:3px!important;padding-right:3px!important}
}
</style>
{/literal}