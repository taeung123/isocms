var people,kid,baby,total_tourist,people_price,child_price,baby_price;
var start_time = [];
Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

$(document).on('change','input[name=departure_date]',function(){
	loadPriceTableDepartureGroup($(this).attr('data'),tour_id,$(this).val(),$("#tourclass").val(),$("#national_visitor"+adult_type_id).val(),$("#national_visitor"+child_type_id).val(),$("#national_visitor"+infant_type_id).val());
	loadStartEndDate($(this).val(),tour_id);
});
$(document).on("change", "select[name=pay_deposit]", function(ev){
	var $_this=$(this);
	deposit = $_this.val();
	tinhtoan();
});
			
function GetTourPriceByNumberGroup(type,tour_id,number_person,tour_class_id,departure_date,tour_visitor_type_id){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=tour&act=getTourPriceByNumberGroup&lang='+LANG_ID,
		'data' : {"type":type,"tour_id":tour_id,"number_person":number_person,"tour_class_id":tour_class_id,"departure_date":departure_date,"tour_visitor_type_id":tour_visitor_type_id},
		'dataType': 'html',
		'success':function(html){
			var htm = html.split('|||');
			var price = parseInt(htm[1]);
			$("#people_price_text"+tour_visitor_type_id).html(format_price(price));
			$("#people_price"+tour_visitor_type_id).val(price);
			$("#tour_number_group_id").val(htm[2]);
			if(tour_visitor_type_id==adult_type_id){
				loadMaxChild(htm[2],number_person,child_type_id);
				loadMaxInfant(htm[2],number_person,infant_type_id);
			} 
			tinhtoan();
			addTraveller();
		}
	});
}
function loadPriceTableDepartureGroup(type,tour_id,departure_date,tourclass,adult,child,infant){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=tour&act=loadPriceTableDepartureGroup&lang='+LANG_ID,
		'data' : {"type":type,"tour_id":tour_id,"tour_class_id":tourclass,"departure_date":departure_date,"adult":adult,"child":child,"infant":infant},
		'dataType': 'html',
		'success':function(html){
			$('#priceTableDeparture').html(html);
			GetTourPriceByNumberGroup(type,tour_id,adult,$("#tourclass").val(),departure_date,adult_type_id);
			GetTourPriceByNumberGroup(type,tour_id,child,$("#tourclass").val(),departure_date,child_type_id);
			GetTourPriceByNumberGroup(type,tour_id,infant,$("#tourclass").val(),departure_date,infant_type_id);
		}
	});
}
function loadMaxChild(group_size_id,number_adult,child_type_id){
	var $_adata = {
		'group_size_id':group_size_id,
		'number_adult':number_adult,
		'tour_id':tour_id,
		'type': 'Child',
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=tour&act=ajLoadMaxPeople&lang='+LANG_ID,
		data :$_adata,
		dataType:'html',
		success: function(html){
			var htm = html.split('|||');
			$("#national_visitor"+child_type_id).attr('max-number', htm[1]);
		} 
	});
}
function loadMaxInfant(group_size_id,number_adult,infant_type_id){
	var $_adata = {
		'group_size_id':group_size_id,
		'number_adult':number_adult,
		'tour_id':tour_id,
		'type': 'Infant',
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=tour&act=ajLoadMaxPeople',
		data :$_adata,
		dataType:'html',
		success: function(html){
			var htm = html.split('|||');
			$("#national_visitor"+infant_type_id).attr('max-number', htm[2]);
		} 
	});
}
function loadStartEndDate(departure_date,tour_id){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=tour&act=loadStartEndDate&lang='+LANG_ID,
		'data' : {"tour_id":tour_id,"departure_date":departure_date},
		'dataType': 'html',
		'success':function(html){
			var htm = html.split('|||');
			$("#departure_html").html(htm[1]);
			$("#start_date_html").html(htm[1]);
			$("#end_date_html").html(htm[2]);
			$("#promotion").val(htm[3]);
			$("#promotion").val(htm[3]);
			if(htm[3]==0){
				$("#promotion_box").hide();
			}else{
				$("#promotion_box").show();
			}
		}
	});
}
function tinhtoan(){
	var national_adults = $("#national_visitor"+adult_type_id).val();
	var national_child = parseInt($("#national_visitor"+child_type_id).val());
	var national_infant = parseInt($("#national_visitor"+infant_type_id).val());
	var national_adults_price = parseInt($("#people_price"+adult_type_id).val());
	var national_child_price = parseInt($("#people_price"+child_type_id).val());
	var national_infant_price = parseInt($("#people_price"+infant_type_id).val());
	
	if(promotion_check >0){
		var promotion = parseInt($("#promotion").val());
		var pricePromotion = document.getElementById("pricePromotion");
	}
	
	var price_adult_html = document.getElementById("price_adult");
	var price_adult_post = document.getElementById("price_adult_post");
	
	var price_child_html = document.getElementById("price_child");
	var price_child_post = document.getElementById("price_child_post");
	
	var price_infant_html = document.getElementById("price_infant");
	var price_infant_post = document.getElementById("price_infant_post");
	
	var price_total_traveller = document.getElementById("price_total_traveller");
	var price_total_traveller_post = document.getElementById("price_total_traveller_post");
	
	var price_total_service = document.getElementById("price_total_service");
	var price_total_service_post = document.getElementById("price_total_service_post");
	
	var for_number_traveller = document.getElementById("for_number_traveller");
	
	var price_total_amount = document.getElementById("price_total_amount");
	var price_total_amount_post = document.getElementById("price_total_amount_post");

	var promotion = document.getElementById("promotion");
	var price_promotion = document.getElementById("price_promotion");
	var price_promotion_post = document.getElementById("price_promotion_post");
	
	var deposit = document.getElementById("deposit");
	var price_deposit = document.getElementById("price_deposit");
	var price_deposit_vn = document.getElementById("price_deposit_vn");
	var price_deposit_post = document.getElementById("price_deposit_post");
	var price_paynow = document.getElementById("price_paynow");
	var price_paynow_post = document.getElementById("price_paynow_post");
	
	var price_remaning = document.getElementById("price_remaning");
	var price_remaning_post = document.getElementById("price_remaning_post");

	var national_promotion = document.getElementById("national_promotion");
	
	var surcharge_value_html = document.getElementById("surcharge_value_html");
	var surcharge_value_post = document.getElementById("surcharge_value_post");
	
	var surcharge = $("#surcharge").val();
	var exchange_rate = $("#exchange_rate").val();
	

	var tong = 0;
	if(national_adults >0){
		tong = tong + national_adults;
	}
	if(national_child >0){
		tong = tong + national_child;
	}
	if(national_infant >0){
		tong = tong + national_infant;
	}
		
	var price_adult=parseInt(national_adults) * national_adults_price;
	var price_child=parseInt(national_child) * national_child_price;
	var price_infant=parseInt(national_infant) * national_infant_price;
	
	var national_traveler = 0;
	
	if(price_adult >0){
		national_traveler = national_traveler + price_adult;
	}
	if(price_child >0){
		national_traveler = national_traveler + price_child;
	}
	if(price_infant >0){
		national_traveler = national_traveler + price_infant;
	}
	
	var national = national_traveler + parseInt(price_total_service_post.value);
	var national_service =  parseInt(price_total_service_post.value);
	
	if (!isNaN(tong)){
		$('#adult').val(parseInt(national_adults));
		$('#child').val(parseInt(national_child));
		$('#baby').val(parseInt(national_infant));
		if(national>0){
			national=national
		}else{
			national=0;
		}
		
		price_adult_html.innerHTML = format_price0(price_adult);
		price_adult_post.value = format_price20(price_adult);
		price_child_html.innerHTML = format_price0(price_child);
		price_child_post.value = format_price20(price_child);
		price_infant_html.innerHTML = format_price0(price_infant);
		price_infant_post.value = format_price20(price_infant);
		price_total_traveller.innerHTML = format_price0(national_traveler);
		price_total_traveller_post.value = format_price20(national_traveler);
		
		if(national_adults>1){
			for_number_traveller.innerHTML = national_adults +' '+ adults;
		}else{
			for_number_traveller.innerHTML = national_adults +' '+ adult;
		}
		if(national_child>0){
			for_number_traveller.innerHTML =for_number_traveller.innerHTML +', '+national_child+' '+child;
		}
		if(national_infant>0){
			for_number_traveller.innerHTML =for_number_traveller.innerHTML +', '+national_infant+' '+infant;
		}
		

		if(promotion_check >0){
			var price_promotion_value=promotion.value/100*national_traveler;
			var national_surcharge=national + (surcharge*(national-price_promotion_value)/100);
			price_total_amount.innerHTML = format_price(national_surcharge - price_promotion_value) ;
			price_total_amount_post.value =  format_price2(national_surcharge - price_promotion_value);
			price_promotion.innerHTML =  format_price(price_promotion_value);
			price_promotion_post.value =  format_price2(price_promotion_value);
			
			if(deposit.value >0){
				var price_deposit_value=(deposit.value/100)*(national_surcharge-price_promotion_value);
				price_deposit.innerHTML = format_price(price_deposit_value);
				price_paynow.innerHTML = format_price(price_deposit_value);
				price_paynow_post.value = format_price2(price_deposit_value);
				price_deposit_post.value = format_price2(price_deposit_value);
				
				price_deposit_vn.innerHTML = format_price_vn(price_deposit_post.value*exchange_rate);
				surcharge_value_html.innerHTML =format_price(surcharge*(national-price_promotion_value)/100);
				surcharge_value_post.value =  format_price2(surcharge*(national-price_promotion_value)/100);
				price_remaining.innerHTML = format_price(national_surcharge-price_promotion_value-(price_deposit_value));
				price_remaining_post.value = format_price2(national_surcharge-price_promotion_value-(price_deposit_value));
			}else{
				surcharge_value_html.innerHTML =format_price(surcharge*(national-price_promotion_value)/100);
				surcharge_value_post.value =  format_price2(surcharge*(national-price_promotion_value)/100);
				price_remaining.innerHTML = format_price(national_surcharge-price_promotion_value);
				price_remaining_post.value = format_price2(national_surcharge-price_promotion_value);
				price_deposit_vn.innerHTML = format_price_vn(price_remaining_post.value*exchange_rate);
				price_paynow.innerHTML = format_price(national_surcharge-price_promotion_value);
				price_paynow_post.value = format_price2(national_surcharge-price_promotion_value);
			}
		}else{
			var national_surcharge=national + (surcharge*national/100);
			if(deposit.value >0){
				price_total_amount.innerHTML =  format_price(national_surcharge);
				price_total_amount_post.value =  format_price2(national_surcharge);
				
				var price_deposit_value=(deposit.value/100)*national_surcharge;
				
				price_deposit.innerHTML = format_price(price_deposit_value);
				price_paynow.innerHTML = format_price(price_deposit_value);
				price_paynow_post.value = format_price2(price_deposit_value);
				price_deposit_post.value = format_price2(price_deposit_value);
				price_deposit_vn.innerHTML = format_price_vn(price_deposit_value*exchange_rate);
				surcharge_value_html.innerHTML =format_price(surcharge*national/100);
				surcharge_value_post.value =  format_price2(surcharge*national/100);
				price_remaining.innerHTML = format_price(national_surcharge-(price_deposit_value));
				price_remaining_post.value = format_price2(national_surcharge-(price_deposit_value));
				
			}else{
				price_total_amount.innerHTML =  format_price(national_surcharge);
				price_total_amount_post.value =  format_price2(national_surcharge);
				price_remaining.innerHTML =  format_price(national_surcharge);
				price_remaining_post.value =  format_price2(national_surcharge);
				surcharge_value_html.innerHTML =format_price(surcharge*national/100);
				surcharge_value_post.value =  format_price2(surcharge*national/100);

				price_deposit_vn.innerHTML = format_price_vn(national_surcharge*exchange_rate);
				
				price_paynow_post.value = format_price2(national_surcharge);
				price_paynow.innerHTML = format_price(national_surcharge);
			}
		}
		if($('#surcharge_value_post').val()==0){
			$('.extracharges').hide();
		}else{
			$('.extracharges').show();
		}
	}else{
	}
}
function addTraveller(){
	var x = 0;
	var y = 1;

	$('#customer_list').html('');
	for(i = 0;i < $('#national_visitor'+adult_type_id).val();i++){
		var submitFieldName = 'birthday_input_' + x;
		customer = new createCustomerInfo($('#customer_list'));
		customer.setStt(+ y);
		customer.setId('input_' + x);
		customer.setTouristAgeType(Adult);
		
		customer.birthday_input.dateDropdowns({
			submitFieldName: submitFieldName,
				minAge: 12,
				defaultDate: '1980-01-01'
			});
		x++;
		y++;
	}
	for(i = 0;i < $('#national_visitor'+child_type_id).val();i++){
		var submitFieldName = 'birthday_input_' + x;
		customer = new createCustomerInfo($('#customer_list'));
		customer.setId('input_' + x);
		customer.setStt(+ y);
		customer.setTouristAgeType(Children);
		customer.birthday_input.dateDropdowns({
			submitFieldName: submitFieldName,
				minAge: 5,
				maxAge: 11,
				defaultDate: '2010-01-01'
			});
		x++;
		y++;
	}
	for(i = 0;i < $('#national_visitor'+infant_type_id).val();i++){
		var submitFieldName = 'birthday_input_' + x;
		customer = new createCustomerInfo($('#customer_list'));
		customer.setId('input_' + x);
		customer.setStt(+ y);
		customer.setTouristAgeType(Infant);
		
		customer.birthday_input.dateDropdowns({
				submitFieldName: submitFieldName,
				maxAge: 4,
				defaultDate: '2018-01-01'
			});
		x++;
		y++;
	}
}
function createCustomerInfo(obj){
	var $ww = $(window).width();
	this.div = $('<div class="travellerItem"></div>');
	this.stt_input =  $('<input type = "text" class = "form-control form-booking_input"/>');
	this.stt_input.appendTo($('<span class="mb5"><b>'+ Traveller +'</b> </span>').appendTo(this.div));
	this.title_input = $('<select class = "form-control form-booking_input title none_appearance">' +
				'<option value="'+ Mr +'">'+ Mr +'</option>' +
				'<option value="'+ Mrs +'">'+ Mrs +'</option>' +
				'<option value="'+ Ms +'">'+ Ms +'</option>' +
				'<option value="'+ Mss +'">'+ Mss +'</option>' +
				'<option value="'+ Dr +'">'+ Dr +'</option>' +
			'</select></span>').appendTo($('<span class="mb20 title_optiona " style="width:88px"><label>'+ Title_optional +' <span style="color:red">*</span></label>').appendTo(this.div));
	this.name_input = $('<input type = "text" class = "form-control form-booking_input"/>');
	this.name_input.appendTo($('<span class="mb20 fullName" style="width:100%;max-width:351px"><label>'+ FullName +' <span style="color:red">*</span></label></span>').appendTo(this.div));
	
	this.birthday_input = $('<input type="hidden" class="example4">').appendTo($('<span class="mb20 DateofBirth" style="width:100%;max-width:320px"><label>'+ DateofBirth +' </label></span>').appendTo(this.div));
		
	obj.append(this.div);
	this.setId = function(id){
		this.name_input.attr('name','name_'+id);
		this.name_input.attr('id','name_'+id);
		
		this.birthday_input.attr('id','birthday_'+id);
		
	};
	this.setStt= function(id){
		this.stt_input.attr('name',id);
		this.stt_input.attr('value',id);
	};
	this.setTouristAgeType = function(tourist_type){
	};
}
if(_LANG_ID=='vn'){
	function format_price(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
	function format_price0(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
	function format_price2(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "" + c : c;
		});
	}
	function format_price20(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "" + c : c;
		});
	}
	function format_price_value(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
		});
	}
	function format_price_vn(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
}else{
	
	function format_price(n) {
		return n.toFixed(2).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
	function format_price0(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
	function format_price2(n) {
		return n.toFixed(2).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "" + c : c;
		});
	}
	function format_price20(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "" + c : c;
		});
	}
	function format_price_value(n) {
		return n.toFixed(2).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
		});
	}
	function format_price_vn(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
}

function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	console.log(x);
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}