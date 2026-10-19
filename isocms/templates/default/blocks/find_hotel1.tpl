{if $mod eq 'home'}
<section class="search-hotels">
    <form id="FindHotel" method="post" action="{$extLang}" role="form">
    	<div class="form-group" style="display:none !important">
            <select class="selectbox" name="country_id"> 
                {$clsCountry->getSelectByCountry($country_id)}
            </select>
        </div>
       <div class="msghidden" style="display:none">Hãy chọn một thành phố</div>
      <div class="form-group col-sm-4 citySearch">
        <label>Thành phố</label>
        <select class="form-control" name="city_id" > 
            <option value="0"> -- {$core->get_Lang('Select city')} --</option>
        </select>
      </div>
	 <div class="form-group col-sm-4">
        <label>Khu vực</label>
        <select class="form-control" name="area_city_id"> 
            <option value="0"> -- {$core->get_Lang('Select area city')} --</option>
        </select>
      </div>
      <div class="form-group col-sm-4">
        <label>Khách sạn</label>
        <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
      </div>
      <div class="form-group col-sm-6"> 
        <label><abbr class="required" title="required">*</abbr>Ngày nhận phòng</label> 
        <input autocomplete="off" name="checkin" id="checkin" value="{$checkin_to}" class="form-control dateTxt hasIconPicker"> 
      </div>
      <div class="form-group col-sm-6"> 
        <label><abbr class="required" title="required">*</abbr>Ngày trả phòng</label> 
        <input autocomplete="off" name="checkout" id="checkout" value="{$checkout_to}" class="form-control dateTxt hasIconPicker"> 
      </div>
      <div class="form-group col-xs-4 h-xs0">
        <label for="exampleInputName2" class="h_label">Số phòng</label>
        <select class="choose" name="number_room" id="number_room">
          {$clsISO->getSelect(1,10)}
        </select>
      </div>
      <div class="form-group col-xs-4 h-xs1">
        <label for="exampleInputName2" class="h_label">Người lớn</label>
        <select class="choose" name="adult" id="adult">
          {$clsISO->getSelect(1,10)}
        </select>
      </div>
      <div class="form-group col-xs-4 h-xs2">
        <label for="exampleInputName2" class="h_label">Trẻ em</label>
        <select class="choose" name="children" id="children">
          {$clsISO->getSelect(0,10)}
        </select>
      </div>
      <input type="hidden" value="searchHotel" name="hid" />
      <button class="btn btn-submit submitHomeClick" type="button">{$core->get_Lang('Tìm kiếm')}</button>
      <button class="btn btn-submit submitHomeSubmit" type="submit" style="display:none">{$core->get_Lang('Tìm kiếm')}</button>
    </form>
</section>
{elseif $act eq 'place' and 1 eq 2}
{*<div class="findBox findhotel findHotelRow">
    <form class="form-inline" id="FindHotel" method="post" action="{$extLang}" role="form">
    	<div class="row">
            <div class="col-md-6 h_fix_colmd6_left">
                <div class="form-group" style="display:none !important">
                    <select class="selectbox" name="country_id"> 
                        {$clsCountry->getSelectByCountry($country_id)}
                    </select>
                </div>
                <div class="form-group " style="max-width:120px">
                    <label>Thành phố</label>
                    <select class="form-control" name="city_id"> 
                        <option value="0"> -- {$core->get_Lang('Select city')} --</option>
                    </select>
                </div>
								<div class="form-group " style="max-width:110px">
                    <label>Khu vực</label>
                    <select class="form-control" name="area_city_id"> 
                        <option value="0"> -- {$core->get_Lang('Select area city')} --</option>
                    </select>
                </div>
                <div class="form-group text pd006" style="max-width:150px">
                    <label>Khách sạn</label>
                    <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
                </div>
                <div class="form-group" style="max-width:140px">
                    <label>Ngày nhận phòng</label>
                     <input name="checkin" autocomplete="off" maxlength="10" id="checkin" value="{$checkin}" size="15" class="dateTxt required hasIconPicker" placeholder="" />
                </div>
            </div>
            <div class="col-md-6 h_fix_colmd6_right">
                <div class="form-group pdr06" style="width:140px">
                    <label>Ngày trả phòng</label>
                    <input name="checkout" autocomplete="off" maxlength="10" id="checkout" value="{$checkout}" size="15" class="dateTxt required hasIconPicker" placeholder="" />
                </div>
                <div class="form-group" style="width:85px">
                    <div class="number_room pdr0">
                        <label>Số phòng</label>
                        <select class="selectbox" name="number_room" id="number_room">
                            {$clsISO->getSelect(1,10)}
                        </select>
                    </div>
                </div>
                <div class="form-group" style="width:85px">
                    <div class="number_adult pd006">
                        <label>Người lớn</label>
                        <select class="selectbox" name="adult" id="adult" style="width:100%; padding:4px">
                            {$clsISO->getSelect(1,10,$adult)}
                        </select>
                    </div>
                </div>
                <div class="form-group pdr06" style="width:85px">
                    <div class="number_child pdl0">
                        <label>Trẻ em</label>
                        <select class="selectbox" name="children" id="children">
                            {$clsISO->getSelect(0,10,$children)}
                        </select>
                    </div>
                </div>
                <div class="form-group submit" style="width:125px">
                    <input type="hidden" value="searchHotel" name="hid" />
                    <button class="btn_submit btn-findhotel form-button" type="submit">{$core->get_Lang('Tìm kiếm')}</button>
                </div>
            </div>
        </div>
    </form>
</div>*}
<div class="findBox findhotel findHotelRow">
    <form class="form-inline" id="FindHotel" method="post" action="{$extLang}" role="form">
    	<div class="row">
            <div class="col-md-6">
							<div class="row">
                <div class="form-group" style="display:none !important">
                    <select class="selectbox" name="country_id"> 
                        {$clsCountry->getSelectByCountry($country_id)}
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Thành phố</label>
                    <select class="form-control" name="city_id"> 
                        <option value="0"> -- {$core->get_Lang('Select city')} --</option>
                    </select>
                </div>
				<div class="form-group col-md-3">
                    <label>Khu vực</label>
                    <select class="form-control" name="area_city_id"> 
                        <option value="0"> -- {$core->get_Lang('Select area city')} --</option>
                    </select>
                </div>
                <div class="form-group text col-md-3">
                    <label>Khách sạn</label>
                    <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
                </div>
                <div class="form-group col-md-3">
                    <label>Ngày nhận phòng</label>
                     <input name="checkin" autocomplete="off" maxlength="10" id="checkin" value="{$checkin}" size="15" class="dateTxt hasIconPicker" placeholder="" />
                </div>
							</div>
            </div>
            <div class="col-md-5">
                <div class="form-group col-md-3">
                    <label>Ngày trả phòng</label>
                    <input name="checkout" autocomplete="off" maxlength="10" id="checkout" value="{$checkout}" size="15" class="dateTxt hasIconPicker" placeholder="" />
                </div>
                <div class="form-group col-md-3">
                    <div class="number_room">
                        <label>Số phòng</label>
                        <select class="selectbox" name="number_room" id="number_room">
                            {$clsISO->getSelect(1,10,$number_room)}
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="number_adult">
                        <label>Người lớn</label>
                        <select class="selectbox" name="adult" id="adult" style="width:100%;">
                            {$clsISO->getSelect(1,10,$adult)}
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="number_child">
                        <label>Trẻ em</label>
                        <select class="selectbox" name="children" id="children">
                            {$clsISO->getSelect(0,10,$children)}
                        </select>
                    </div>
                </div>
            </div>
						<div class="form-group submit col-md-1">
								<label>&nbsp;</label>
								<input type="hidden" value="searchHotel" name="hid" />
								<button class="btn_submit btn-findhotel form-button" type="submit">{$core->get_Lang('Tìm kiếm')}</button>
						</div>
        </div>
    </form>
</div>
{elseif $mod eq 'hotelpro' && $act eq 'detail'}
<div class="findBox findhotel h_findHotelRow">
    <form class="form-inline" id="FindHotel" method="post" action="{$extLang}" role="form">
   		<div class="form-group" style="display:none">
            <select class="selectbox" name="country_id"> 
                {$clsCountry->getSelectByCountry($country_id)}
            </select>
        </div>
        <div class="form-group">
        	<label>Thành phố</label>
            <select class="form-control" name="city_id"> 
                <option value="0"> -- {$core->get_Lang('Select city')} --</option>
            </select>
        </div>
				<div class="form-group">
        	<label>Khu vực</label>
            <select class="form-control" name="area_city_id"> 
                <option value="0"> -- {$core->get_Lang('Select area city')} --</option>
            </select>
        </div>
        <div class="form-group text">
        	<label>Khách sạn</label>
            <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
        </div>
        
        <div class="form-group">
        	<label>Ngày nhận phòng</label>
             <input name="checkin" autocomplete="off" maxlength="10" id="checkin" value="{if $departure_in ne ''}{$clsISO->formatTimeDate($departure_in)}{else}{$checkin_to}{/if}" size="15" class="dateTxt hasIconPicker" placeholder="" />
        </div>
        <div class="form-group">
        	<label>Ngày trả phòng</label>
            <input name="checkout" autocomplete="off" maxlength="10" id="checkout" value="{if $departure_out ne ''}{$clsISO->formatTimeDate($departure_out)}{else}{$checkout_to}{/if}" size="15" class="dateTxt hasIconPicker" placeholder="" />
        </div>
        <div class="form-group">
        	<div class="row">
                <div class="number_room col-md-4">
                    <label>Số phòng</label>
                    <select class="selectbox" name="number_room" id="number_room">
                        {$clsISO->getSelect(1,10,$number_room)}
                    </select>
                </div>
                <div class="number_adult col-md-4">
                    <label>Người lớn</label>
                    <select class="selectbox" name="adult" id="adult" style="width:100%; padding:4px">
                        {$clsISO->getSelect(1,10,$adult)}
                    </select>
                </div>
                <div class="number_child col-md-4">
                    <label>Trẻ em</label>
                    <select class="selectbox" name="children" id="children">
                        {$clsISO->getSelect(0,10,$children)}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group submit">
            <input type="hidden" value="searchHotel" name="hid" />
            <button class="btn_submit btn-findhotel form-button" type="submit">{$core->get_Lang('Tìm kiếm')}</button>
        </div>
    </form>
</div>
{else}
<div class="findBox findhotel h_findHotelRow">
    <form class="form-inline" id="FindHotel" method="post" action="{$extLang}" role="form">
   		<div class="form-group" style="display:none">
            <select class="selectbox" name="country_id"> 
                {$clsCountry->getSelectByCountry($country_id)}
            </select>
        </div>
        <div class="form-group">
        	<label>Thành phố</label>
            <select class="form-control" name="city_id"> 
                <option value="0"> -- {$core->get_Lang('Select city')} --</option>
            </select>
        </div>
				<div class="form-group">
        	<label>Khu vực</label>
            <select class="form-control" name="area_city_id"> 
                <option value="0"> -- {$core->get_Lang('Select area city')} --</option>
            </select>
        </div>
        <div class="form-group text">
        	<label>Khách sạn</label>
            <input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Enter name of hotels')}" />
        </div>
        
        <div class="form-group">
        	<label>Ngày nhận phòng</label>
             <input name="checkin" autocomplete="off" maxlength="10" id="checkin" value="{if $departure_in ne ''}{$departure_in}{else}{$checkin_to}{/if}" size="15" class="dateTxt hasIconPicker" placeholder="" />
        </div>
        <div class="form-group">
        	<label>Ngày trả phòng</label>
            <input name="checkout" autocomplete="off" maxlength="10" id="checkout" value="{if $departure_out ne ''}{$departure_out}{else}{$checkout_to}{/if}" size="15" class="dateTxt hasIconPicker" placeholder="" />
        </div>
        <div class="form-group">
        	<div class="row">
                <div class="number_room col-md-4">
                    <label>Số phòng</label>
                    <select class="selectbox" name="number_room" id="number_room">
                        {$clsISO->getSelect(1,10,$number_room)}
                    </select>
                </div>
                <div class="number_adult col-md-4">
                    <label>Người lớn</label>
                    <select class="selectbox" name="adult" id="adult" style="width:100%; padding:4px">
                        {$clsISO->getSelect(1,10,$adult)}
                    </select>
                </div>
                <div class="number_child col-md-4">
                    <label>Trẻ em</label>
                    <select class="selectbox" name="children" id="children">
                        {$clsISO->getSelect(0,10,$children)}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group submit">
            <input type="hidden" value="searchHotel" name="hid" />
            <button class="btn_submit btn-findhotel form-button" type="submit">{$core->get_Lang('Tìm kiếm')}</button>
        </div>
    </form>
</div>
{/if}
<script type="text/javascript">
	var city_id="{$city_id}";
	var area_city_id="{$area_city_id}";
</script>
{literal}
<style>
.findform .isoTxt{width:160px;height:22px;padding:0 4px;border:1px solid #BABABA}
</style>
<script type="text/javascript">
$(function(){
	loadCity();
	loadAreaCity();
	$('.submitHomeClick').click(function() {
		$('.citySearch .selectric').css({'border-color':'#f00'});	
		$('.msghidden').show();
	});
	$('select[name=country_id]').change(function(){
		$('select[name=city_id]').html('<option value="">Loading...</option>').selectric({});
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=hotelpro&act=loadCity',
			'data' : {"country_id":$(this).val()},
			'dataType': 'html',
			'success':function(html){
				$('select[name=city_id]').html(html).selectric({});
				
			}
		});
	});
	$('select[name=city_id]').change(function(){
		$('.submitHomeClick').hide();
		$('.submitHomeSubmit').show();
		$('select[name=area_city_id]').html('<option value="">Loading...</option>').selectric({});
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=hotelpro&act=loadAreaCity',
			'data' : {"city_id":$(this).val()},
			'dataType': 'html',
			'success':function(html){
				$('select[name=area_city_id]').html(html).selectric({});
			}
		});
	});
});
function loadCity(){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=hotelpro&act=loadCity',
		'data' : {"country_id":$('select[name=country_id]').val(),'city_id':city_id},
		'dataType': 'html',
		'success':function(html){
			$('select[name=city_id]').html(html).selectric({});
		}
	});
}
function loadAreaCity(){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=hotelpro&act=loadAreaCity',
		'data' : {'city_id':city_id,'area_city_id':area_city_id},
		'dataType': 'html',
		'success':function(html){
			$('select[name=area_city_id]').html(html).selectric({});
		}
	});
}
</script>
{/literal}
{literal}
<script type="text/javascript">
$(document).ready(function(){
	$('#checkin').datepicker({
		closeText: "Đóng",
		prevText: "Trước",
		nextText: "Sau",
		currentText: "Hôm nay",
		monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
		monthNamesShort:["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
		dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
		dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
		dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
		weekHeader: "Tuần",
		dateFormat: "mm/dd/yy", 
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
			$('#checkout').datepicker('option', {minDate: date}).datepicker('setDate', date); 
		},
		onClose: function(dateText, inst) {
			$('#checkout').focus();
		}
	});
	$("#checkout").datepicker( { 
		closeText: "Đóng",
		prevText: "Trước",
		nextText: "Sau",
		currentText: "Hôm nay",
		monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
		monthNamesShort:["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
		dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
		dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
		dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
		weekHeader: "Tuần",
		dateFormat: "mm/dd/yy", 
		minDate: new Date(), maxDate: "+1Y",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true
	});	
	$('#FindHotel').validate();
});
</script>
{/literal}
