$(function(){
		
});
var people,kid,baby,total_tourist,people_price,child_price,baby_price;
var start_time = [];
Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

$(document).on('change','input[name=departure_date]',function(){
	loadPriceTableDepartureGroup($(this).attr('data'),tour_id,$(this).val(),$("#tourclass").val(),$("#national_visitor16").val(),$("#national_visitor17").val(),$("#national_visitor18").val(),$("#people_price16").val(),$("#people_price17").val(),$("#people_price18").val());
});
$(document).on("change", "select[name=pay_deposit]", function(ev){
	var $_this=$(this);
	deposit = $_this.val();
	tinhtoan();
});
			
function GetTourPriceByNumberGroup(type,tour_id,number_person,tour_class_id,departure_date,tour_visitor_type_id){
	/*console.log(tour_visitor_type_id);*/
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
				makeSelectMaxChild(htm[2],number_person,child_type_id);
				makeSelectMaxInfant(htm[2],number_person,infant_type_id);
			} 
			tinhtoan();
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
function makeSelectMaxChild(group_size_id,number_adult,child_type_id){
	$("#national_visitor"+child_type_id).html('<option value="0">'+loading+'</option>');
	var $_adata = {
		'group_size_id':group_size_id,
		'number_adult':number_adult,
		'tour_id':tour_id,
		'type': 'Child',
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=tour&act=ajLoadSelectMaxPeople',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$("#national_visitor"+child_type_id).html(html);
		} 
	});
}
function makeSelectMaxInfant(group_size_id,number_adult,infant_type_id){
	$("#national_visitor"+infant_type_id).html('<option value="0">'+loading+'</option>');
	var $_adata = {
		'group_size_id':group_size_id,
		'number_adult':number_adult,
		'tour_id':tour_id,
		'type': 'Infant',
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=tour&act=ajLoadSelectMaxPeople',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$("#national_visitor"+infant_type_id).html(html);
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
	
	var depositBook = document.getElementById("deposit");
	var depositBooking = document.getElementById("depositBooking");
	
	var result = document.getElementById("result");
	var remainingPrice = document.getElementById("remainingPrice");
	
	var tien1 = document.getElementById("tien1");
	var national_total = document.getElementById("national_total");
	var total_remaining = document.getElementById("total_remaining");
	var service_total = document.getElementById("service_total");
	var national_total = document.getElementById("national_total");
	var total_service = document.getElementById("total_service");
	var total_traveler = document.getElementById("total_traveler");
	var traveler_total = document.getElementById("traveler_total");
	

	var national_promotion = document.getElementById("national_promotion");
	deposit = $('select[name=pay_deposit]').val();
	
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
	
	
	var national = national_traveler + parseInt(total_service.value);
	
	if (!isNaN(tong)){
		$('#adult').val(parseInt(national_adults));
		$('#child').val(parseInt(national_child));
		$('#baby').val(parseInt(national_infant));
		if(national>0){
			national=national
		}else{
		national=0;
		}
		traveler_total.innerHTML = national_traveler.format();
		national_total.innerHTML = format_price(national);
		tien1.value=national.format();
		total_traveler.value=national_traveler;
		if(promotion_check >0){
			pricePromotion.value = format_price((promotion/100*national));
			national_promotion.innerHTML = format_price((promotion/100*national));
			depositBook.innerHTML = format_price((deposit/100)*(national-(promotion/100*national)));
			depositBooking.value = format_price((deposit/100)*(national-(promotion/100*national)));
			total_remaining.innerHTML = format_price(national-((promotion/100*national))-((deposit/100)*(national-(promotion/100*national))));
			remainingPrice.value = format_price(national-((promotion/100*national))-((deposit/100)*(national-(promotion/100*national))));
			
		}else{
			depositBook.innerHTML = format_price((deposit/100)*national);
			depositBooking.value = format_price((deposit/100)*national);
			total_remaining.innerHTML = format_price(national-((deposit/100)*national));
			remainingPrice.value = format_price(national-((deposit/100)*national));
			
		}
		var x = 0;
		var y = 1;

		$('#customer_list').html('');
		for(i = 0;i < $('#national_visitor'+adult_type_id).val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setStt(+ y);
			customer.setId('input_' + x);
			customer.setTouristAgeType("Adult");
			
			customer.birthday_input.datepicker({
				altFormat: "mm-dd-yy",
				dateFormat: "mm-dd-yy",
				changeMonth: true,
				changeYear: true,
				yearRange: '1900:Y',
				defaultDate: '01-01-1999',
				minDate: new Date(1900, 10 - 1, 25),
			});
			x++;
			y++;
		}
		for(i = 0;i < $('#national_visitor'+child_type_id).val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setStt(+ y);
			customer.setTouristAgeType("Children");
			
			customer.birthday_input.datepicker({
				altFormat: "mm-dd-yy",
				dateFormat: "mm-dd-yy",
				changeMonth: true,
				changeYear: true,
				yearRange: '1900:Y',
				defaultDate: '01-01-1999',
				minDate: new Date(1900, 10 - 1, 25),
			});
			x++;
			y++;
		}
		for(i = 0;i < $('#national_visitor'+infant_type_id).val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setStt(+ y);
			customer.setTouristAgeType("Infant");
			
			customer.birthday_input.datepicker({
				altFormat: "mm-dd-yy",
				dateFormat: "mm-dd-yy",
				changeMonth: true,
				changeYear: true,
				yearRange: '1900:Y',
				defaultDate: '01-01-1999',
				minDate: new Date(1900, 10 - 1, 25),
			});
			x++;
			y++;
		}

	}else{
	}
}
function createCustomerInfo(obj){
	var $ww = $(window).width();
	this.div = $('<div></div>');
	this.stt_input =  $('<input type = "text" class = "form-control form-booking_input"/>');
	this.stt_input.appendTo($('<span class="mb10"><b class="block768" style="display:none">'+ Traveller +'</b> </span>').appendTo(this.div));
	
	this.name_input = $('<input type = "text" class = "form-control form-booking_input"/>');
	this.name_input.appendTo($('<span class="mb10"><label class="block768" style="display:none">'+ FullName +'</label></span>').appendTo(this.div));
	
	this.birthday_input = $('<input type = "text" class = "form-control form-booking_input datepicker inputDate" />').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+ DateofBirth +'</label></span>').appendTo(this.div));
	
	this.address_input = $('<input type = "text" class = "form-control form-booking_input" />').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+ Address +'</label></span>').appendTo(this.div));
	
	this.gender_input = $('<select class = "form-control form-booking_input" >' +
				'<option value="'+ Female +'">'+ Female +'</option>' +
				'<option value="'+ Male +'">'+ Male +'</option>' +
			'</select></span>').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+ Male +'</label>').appendTo(this.div));
	this.tourist_age_type_input = $('<select class = "form-control form-booking_input appearance_none" >' +

		'</select>').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+ Gender +'</label></span>').appendTo(this.div));
		
	obj.append(this.div);
	this.setId = function(id){
		this.name_input.attr('name',id + '.name');
		this.name_input.attr('id',id + '.name');
		
		this.birthday_input.attr('name',id + '.birthday');
		this.birthday_input.attr('id',id + '.birthday');

		this.address_input.attr('name',id + '.address');
		this.address_input.attr('id',id + '.address');

		this.gender_input.attr('name',id + '.gender');
		this.gender_input.attr('id',id + '.gender');
		
		this.tourist_age_type_input.attr('name',id + '.tourist_age_type');
		this.tourist_age_type_input.attr('id',id + '.tourist_age_type');
		
	};
	this.setStt= function(id){
		this.stt_input.attr('name',id);
		this.stt_input.attr('value',id);
	};
	this.setTouristAgeType = function(tourist_type){
		this.tourist_age_type_input.append($('<option value = "' + tourist_type + '">' + tourist_type + '</option>'));
	};
}

if(LANG_ID=='vn'){
	function format_price(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
	function format_price_value(n) {
		return n.toFixed(0).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
		});
	}
}else{
	function format_price(n) {
		return n.toFixed(2).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});
	}
	function format_price_value(n) {
		return n.toFixed(2).replace(/./g, function(c, i, a) {
			return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
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