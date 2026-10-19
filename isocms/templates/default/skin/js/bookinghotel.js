$(function(){
	$('.datepicker').datepicker({
	minDate : new Date(),
	DateFormat: "%m/%d/%Y"
	});
});
var people,kid,baby,total_tourist,people_price,child_price,baby_price;
var start_time = [];
$(document).ready(function(){
	number_extraroom = $('#number_extraroom');
	
	total_tourist = $('#result');

	number_extraroom_price = parseInt($('#price_extraroom').val());
	price_total_room = parseInt($('#price_totalbookingRoom').val());
	
	tinhtoan();

	number_extraroom.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});

});

Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function tinhtoan(){
	var number_extraroom = document.getElementById("number_extraroom");

	
	var result = document.getElementById("result");
	var totalPrice = document.getElementById("totalPrice");
	var totalpriceroom = document.getElementById("totalpriceroom");
	var tong = parseInt(number_extraroom.value);
	var number_extra_total_price = parseInt(number_extraroom.value) * number_extraroom_price;
	
	
	
	
	if (!isNaN(tong)){
		totalpriceroom.innerHTML = (price_total_room + number_extra_total_price).format() + ',000 đ';
		totalPrice.value = (price_total_room + number_extra_total_price).format() + ',000 đ';
	}else{
		totalpriceroom.innerHTML = (price_total_room).format() + ',000 đ';
		totalPrice.value = (price_total_room + number_extra_total_price).format() + ',000 đ';
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