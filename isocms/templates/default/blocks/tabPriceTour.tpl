<script type="text/javascript" src="https://yolotravel.com.vn/templates/default/default/js/jquery.js"></script>
<script type="text/javascript" src="https://yolotravel.com.vn/templates/default/default/js/jquery-ui.1.11.4.min.js"></script>
<div id="wrapper">
<div id="page-maincontent">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div id="maincontent" style="background:#fff;">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12"> 
              <form action="https://yolotravel.com.vn/tour/addbook" method="post">
                <input type="hidden" id="name_tour" name="name_tour" value="Tour Du lịch Thái Lan dịp lễ 2-9 từ Hà Nội">
                <input type="hidden" id="code_tour" name="code_tour" value="THAI30">
                <input type="hidden" id="id" name="id" value="332">
                <div class="row" style="margin:5px 0px;">
                  <div class="form-group has-feedback">
                    <label class="control-label pull-left " for="start_date" style="padding-top: 7px;margin-left: 5px;">Chọn ngày khởi hành</label>
                    <div class="col-md-3">
                      <input type="text" id="start_date" name="start_date" class="form-control hasDatepicker" value="02/09/2016">
                      <span class="glyphicon glyphicon-calendar form-control-feedback" aria-hidden="true" style="color: #9DC436;top:0px;right: 10px;cursor: pointer;" onclick="$(&#39;#start_date&#39;).focus();"></span> </div>
                  </div>
                </div>
                <div style="padding:5px;"> <span class="head-book">Giá tour cơ bản</span> </div>
                <table class="table table-bordered">
                  <tbody>
                    <tr class="active">
                      <td>Loại Khách</td>
                      <td>Việt Nam</td>
                      <td>Việt Kiều</td>
                      <td>Người Nước ngoài</td>
                    </tr>
                    <tr>
                      <td>Người lớn (&gt;=12 tuổi)</td>
                      <td>7,590,000đ
                        <input type="number" name="national_people" id="national_people" value="1" style="width: 50px;float: right;"></td>
                      <td>7,590,000đ
                        <input type="number" name="overseas_people" id="overseas_people" value="0" style="width: 50px;float: right;"></td>
                      <td>7,590,000đ
                        <input type="number" name="foreigner_people" id="foreigner_people" value="0" style="width: 50px;float: right;"></td>
                    </tr>
                    <tr>
                      <td>Trẻ từ 5-11 tuổi</td>
                      <td>3,795,000đ
                        <input type="number" name="national_child" id="national_child" value="0" style="width: 50px;float: right;"></td>
                      <td>3,795,000đ
                        <input type="number" name="overseas_child" id="overseas_child" value="0" style="width: 50px;float: right;"></td>
                      <td>3,795,000đ
                        <input type="number" name="foreigner_child" id="foreigner_child" value="0" style="width: 50px;float: right;"></td>
                    </tr>
                    <tr>
                      <td>Trẻ dưới 5 tuổi</td>
                      <td>0đ
                        <input type="number" name="national_baby" id="national_baby" value="0" style="width: 50px;float: right;"></td>
                      <td>0đ
                        <input type="number" name="overseas_baby" id="overseas_baby" value="0" style="width: 50px;float: right;"></td>
                      <td>0đ
                        <input type="number" name="foreigner_baby" id="foreigner_baby" value="0" style="width: 50px;float: right;"></td>
                    </tr>
                    <tr>
                      <td>Phụ phí</td>
                      <td>0đ</td>
                      <td>0đ</td>
                      <td>0đ</td>
                    </tr>
                    <tr>
                      <td>Thành tiền</td>
                      <td><span id="national_total">22,770,000 đ</span></td>
                      <td><span id="overseas_total">7,590,000 đ</span></td>
                      <td><span id="foreigner_total">7,590,000 đ</span></td>
                    </tr>
                    <tr>
                      <td>Tổng tiền</td>
                      <td colspan="3"><span id="total">37,950,000 đ</span></td>
                    </tr>
                  </tbody>
                </table>
                <p></p>
                <div style="padding:5px;"> <span class="head-book">Thông tin liên lạc</span> </div>
                {literal}
                <script language="javascript">
                var people,kid,baby,total_tourist,people_price,child_price,baby_price;
                var start_time = [];
                $(document).ready(function(){
                    
                    switch($('#time_start_repeat').val()) {
                        case '1':
                            start_time = $('#time_start').val().split(",");
                            break;
                        case '2':
                            var tmp_array = $('#time_start').val().split(",");
                            
                            for(x in tmp_array){
                                var dt1   = parseInt(tmp_array[x].substring(8,10));
                                var mon1  = parseInt(tmp_array[x].substring(5,7));
                                var yr1   = parseInt(tmp_array[x].substring(0,4));
                
                                var date1 = new Date(yr1, mon1-1, dt1);
                
                                start_time.push(date1.getDay());
                            }
                            break;
                        case '3':
                            var tmp_array = $('#time_start').val().split(",");
                            for(x in tmp_array){
                                var tmp = tmp_array[x].split('-');
                                start_time.push(tmp[2]);
                            }
                            break;
                        default:
                            return [true, ""];
                    }
                    /*$( "#start_date" ).datepicker({
                        dateFormat: "dd/mm/yy",
                        beforeShowDay: DisableSpecificDates
                    });*/
                    national_people = $('#national_people');
                    national_child = $('#national_child');
                    national_baby = $('#national_baby');
                    
                    overseas_people = $('#overseas_people');
                    overseas_child = $('#overseas_child');
                    overseas_baby = $('#overseas_baby');
                    
                    foreigner_people = $('#foreigner_people');
                    foreigner_child = $('#foreigner_child');
                    foreigner_baby = $('#foreigner_baby');
                    
                    total_tourist = $('#result');
                
                    people_price = parseInt($('#people_price').val());
                    child_price = parseInt($('#kid_price').val());
                    baby_price = parseInt($('#baby_price').val());
                    
                    tinhtoan();
                
                    national_people.change(function(){
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
                    national_child.change(function(){
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
                    national_baby.change(function(){
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
                    overseas_people.change(function(){
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
                    overseas_child.change(function(){
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
                    overseas_baby.change(function(){
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
                    
                    foreigner_people.change(function(){
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
                    foreigner_child.change(function(){
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
                    foreigner_baby.change(function(){
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
                
                //Hàm tính kết quả
                </script>
                {/literal}
                <table class="table" style="border: 1px solid #ddd; display:none">
                <tbody>
                  <tr>
                    <td style=" width: 100px;"> Họ &amp; Tên (<span class="price">*</span>) </td>
                    <td><input id="contact_name" name="contact_name" placeholder="Họ &amp; tên" required="required" type="text" value="" class="form-control"></td>
                    <td style=" width: 100px;padding-left:20px;"> Địa chỉ (<span class="price">*</span>) </td>
                    <td><input id="address" name="address" placeholder="Địa chỉ" required="required" type="text" value="" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Điện thoại</td>
                    <td><input id="telephone" name="telephone" onkeypress="return funCheckInt(event)" placeholder="Điện thoại" type="text" value="" class="form-control"></td>
                    <td style=" width: 100px;padding-left:20px;">Di động (<span class="price">*</span>)</td>
                    <td><input id="mobile" name="mobile" onkeypress="return funCheckInt(event)" placeholder="Di động" required="required" type="text" value="" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Email (<span class="price">*</span>)</td>
                    <td><input id="email" name="email" placeholder="Email" required="required" type="email" value="" class="form-control"></td>
                    <td style=" width: 100px;padding-left:20px;">Ghi chú</td>
                    <td><input id="note" name="note" placeholder="Ghi chú" type="text" value="" class="form-control"></td>
                  </tr>
                </tbody>
                </table>
                <div style="padding:5px 10px;"><b>Nhập Danh sách khách đi </b>(Bao gồm: Họ tên, Ngày sinh, Tuổi , Địa chỉ)</div>
                <table id="customer_list" class="table table-border">
                  <tbody>
                    <tr>
                      <td><input type="text" class="form-control input-sm" name="input_0.name" id="input_0.name"></td>
                      <td><input type="text" class="form-control input-sm hasDatepicker" name="input_0.birthday" id="input_0.birthday"></td>
                      <td><input type="text" class="form-control input-sm" name="input_0.address" id="input_0.address"></td>
                      <td><select class="form-control input-sm" name="input_0.gender" id="input_0.gender">
                          <option value="0">Nữ</option>
                          <option value="1">Nam</option>
                        </select></td>
                      <td><select class="form-control input-sm" name="input_0.tourist_type" id="input_0.tourist_type">
                          <option value="Việt Nam">Việt Nam</option>
                          <option value="Việt kiều">Việt kiều</option>
                          <option value="Nước ngoài">Nước ngoài</option>
                        </select></td>
                      <td><select class="form-control input-sm" name="input_0.tourist_age_type" id="input_0.tourist_age_type">
                          <option value="Người lớn">Người lớn</option>
                        </select></td>
                      <td><select class="form-control input-sm" name="input_0.room" id="input_0.room">
                          <option value="0">Không</option>
                          <option value="1">Có</option>
                        </select></td>
                    </tr>
                  </tbody>
                </table>
                <div style="padding:5px;"> <span class="head-book">Thông tin thanh toán</span> </div>
                <div class="booking_tab" style="border: 1px solid #ddd;padding: 10px;">
                  <div class="title"> <b>Xin Quý khách vui lòng chọn hình thức thanh toán</b> </div>
                  <div>
                    <label style="cursor:pointer;">
                      <input type="radio" class="chkPayment" name="paymentID" value="1" checked="checked">
                      Tiền mặt</label>
                    <br>
                    <label style="cursor:pointer;">
                      <input type="radio" class="chkPayment" name="paymentID" value="2">
                      Chuyển khoản</label>
                    <br>
                    <label style="cursor:pointer;">
                      <input type="radio" class="chkPayment ATMNone" name="paymentID" value="-1">
                      Thẻ ngân hàng nội địa - ATM / Internet Banking<br>
                    </label>
                    <div id="divATM" style="display: none; padding-left: 20px">
                      <label style="cursor:pointer;">
                        <input type="radio" class="chkPayment ATMDefault" name="paymentID" value="9">
                        Thanh toán đảm bảo qua cổng 123Pay<br>
                      </label>
                    </div>
                  </div>
                </div>
                <div style="width: auto; overflow: auto;">
                  <div id="conditionPayment">-&gt; Thanh toán tiền mặt: Quý khách vui lòng thanh toán tại bất kỳ đại lý của YOLOTravel trong và ngoài nước!</div>
                </div>
                <div style="padding:5px;"> <span class="head-book">Điều khoản</span> </div>
                <div style="height: 150px; width: 80%; width: auto; overflow: auto;border:1px solid#1e66f8;padding:20px;">
                  <title></title>
                </div>
              </form>
            </div>
          </div>
          <br>
          <input type="checkbox" checked="">
          Tôi đồng ý với các điều kiện trên <br>
          <input type="hidden" name="people_price" value="7590000" id="people_price">
          <input type="hidden" name="kid_price" value="3795000" id="kid_price">
          <input type="hidden" name="baby_price" value="0" id="baby_price">
          <input type="hidden" name="tien1" value="37,950,000" id="tien1">
          <input type="hidden" name="result" value="5" id="result">
          <input type="hidden" name="a" value="5" id="a">
          <input type="hidden" name="b" value="0" id="b">
          <input type="hidden" name="c" value="0" id="c">
          <input type="hidden" name="time_start" value="2016-09-02" id="time_start">
          <input type="hidden" name="time_start_repeat" value="1" id="time_start_repeat">
          <div>
            <input type="submit" class="btn btn-primary" name="form_click" value="ĐẶT TOUR" style="background: #f0990c;border-color: #f0990c;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
{literal}
<script type="text/javascript">
 Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function tinhtoan(){
	var national_people = document.getElementById("national_people");
	var national_child = document.getElementById("national_child");
	var national_baby = document.getElementById("national_baby");
	
	var overseas_people = document.getElementById("overseas_people");
	var overseas_child = document.getElementById("overseas_child");
	var overseas_baby = document.getElementById("overseas_baby");
	
	var foreigner_people = document.getElementById("foreigner_people");
	var foreigner_child = document.getElementById("foreigner_child");
	var foreigner_baby = document.getElementById("foreigner_baby");
	
	var result = document.getElementById("result");
	var tien1 = document.getElementById("tien1");
	
	var national_total = document.getElementById("national_total");
	var overseas_total = document.getElementById("overseas_total");
	var foreigner_total = document.getElementById("foreigner_total");
	var total = document.getElementById("total");
	
	var tong = parseInt(national_people.value) + 
		parseInt(national_child.value) + 
		parseInt(national_baby.value) +
		
		parseInt(overseas_people.value) +
		parseInt(overseas_child.value) +
		parseInt(overseas_baby.value) +
		
		parseInt(foreigner_people.value) +
		parseInt(foreigner_child.value) +
		parseInt(foreigner_baby.value)
		;
	
	var national = parseInt(national_people.value) * people_price
		+ parseInt(national_child.value) * child_price
		+ parseInt(national_baby.value) * baby_price;
	
	var overseas = parseInt(overseas_people.value) * people_price
		+ parseInt(overseas_child.value) * child_price
		+ parseInt(overseas_baby.value) * baby_price;
	
	var foreigner = parseInt(foreigner_people.value) * people_price
		+ parseInt(foreigner_child.value) * child_price
		+ parseInt(foreigner_baby.value) * baby_price;
		
	if (!isNaN(tong)){
		$('#a').val(parseInt(national_people.value) + parseInt(overseas_people.value) + parseInt(foreigner_people.value));
		$('#b').val(parseInt(national_child.value) + parseInt(overseas_child.value) + parseInt(foreigner_child.value));
		$('#c').val(parseInt(national_baby.value) + parseInt(overseas_baby.value) + parseInt(foreigner_baby.value));
		result.value = tong;

		national_total.innerHTML = national.format() + ' đ';
		overseas_total.innerHTML = overseas.format() + ' đ';
		foreigner_total.innerHTML = foreigner.format() + ' đ';
		
		total.innerHTML = (national + overseas + foreigner).format() + ' đ';
		tien1.value = (national + overseas + foreigner).format();
		
		var x = 0;

		$('#customer_list').html('');
		for(i = 0;i < $('#national_people').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national_child').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national_baby').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#overseas_people').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#overseas_child').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#overseas_baby').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#foreigner_people').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#foreigner_child').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#foreigner_baby').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
	}else{
		alert('Lỗi');
	}
}
function createCustomerInfo(obj){
	this.tr = $('<tr></tr>');
	
	this.name_input = $('<input type = "text" class = "form-control input-sm" />');
	this.name_input.appendTo($('<td></td>').appendTo(this.tr));
	
	this.birthday_input = $('<input type = "text" class = "form-control input-sm" />').appendTo($('<td></td>').appendTo(this.tr));
	
	this.address_input = $('<input type = "text" class = "form-control input-sm" />').appendTo($('<td></td>').appendTo(this.tr));
	
	this.gender_input = $('<select class = "form-control input-sm" >' +
				'<option value="0">Nữ</option>' +
				'<option value="1">Nam</option>' +
			'</select></td>').appendTo($('<td>').appendTo(this.tr));
	

	this.tourist_type_input = $('<select class = "form-control input-sm" >' +
			'<option value="Việt Nam">Việt Nam</option>' +
			'<option value="Việt kiều">Việt kiều</option>' +
			'<option value="Nước ngoài">Nước ngoài</option>' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));
	
	this.tourist_age_type_input = $('<select class = "form-control input-sm" >' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));
	
	this.room_input = $('<select class = "form-control input-sm" >' +
			'<option value="0">Không</option>' +
			'<option value="1">Có</option>' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));

	obj.append(this.tr);
	this.setId = function(id){
		this.name_input.attr('name',id + '.name');
		this.name_input.attr('id',id + '.name');
		
		this.birthday_input.attr('name',id + '.birthday');
		this.birthday_input.attr('id',id + '.birthday');

		this.address_input.attr('name',id + '.address');
		this.address_input.attr('id',id + '.address');

		this.gender_input.attr('name',id + '.gender');
		this.gender_input.attr('id',id + '.gender');

		this.tourist_type_input.attr('name',id + '.tourist_type');
		this.tourist_type_input.attr('id',id + '.tourist_type');

		this.tourist_age_type_input.attr('name',id + '.tourist_age_type');
		this.tourist_age_type_input.attr('id',id + '.tourist_age_type');
		
		this.room_input.attr('name',id + '.room');
		this.room_input.attr('id',id + '.room');
	};
	this.setTouristAgeType = function(tourist_type){
		this.tourist_age_type_input.append($('<option value = "' + tourist_type + '">' + tourist_type + '</option>'));
	};
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
</script>
{/literal}