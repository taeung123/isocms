{if $mod eq 'home'}
<div class="page-top">
	<a href="" data-toggle="modal" rel="nofollow" data-target="#quickBooking" class="book">Đặt phòng nhanh</a>
	<a href="javascript:void(0);" rel="nofollow" data-toggle="modal" data-target="#bookingGroup" class="book-people">Đặt phòng theo đoàn</a>
</div>
{else}
{/if}
<!-- Quick Booking -->
<div class="modal fade" id="quickBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ĐẶT PHÒNG NHANH</h4>
      </div>
      <form action="" method="post" class="quickbookingform">
      <div class="modal-body">
	  	<div class="findDealForCustomerHeading vspacingbottom15">
			Khi đặt phòng theo đoàn với VietNamHotel, bạn sẽ có được khách sạn phù hợp nhất với giá tốt nhất mà không phải tốn thời gian tìm kiếm.
		</div>
        <div class="form-group">
			<label class="control-label">Yêu cầu</label>
			<textarea class="form-control" name="introQuickBooking" id="intro_quickbooking" rows="5" placeholder="Xin vui lòng điền tóm tắt thông tin đặt phòng cho đoàn của bạn tại đây.Chúng tôi sẽ liên hệ bạn trong vòng 1 tiếng giờ hành chính."></textarea>
		</div>
        <div class="form-group">
			<label class="control-label">Họ tên</label>
			<input class="form-control" id="quickbooking_name" placeholder="Họ và tên" />
		</div>
		<div class="row">
			<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">Điện thoại</label>
					<input class="form-control" id="quickbooking_phone" placeholder="Số điện thoại" />
				</div>
			</div>
			<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">Email</label>
					<input class="form-control" id="quickbooking_email0" placeholder="Địa chỉ email" />
				</div>
			</div>
		</div>
        <div id="quickbooking_msg3" class="quickbooking_msg"></div>
      </div>
      <div class="modal-footer" align="center">
	  	<center>
        	<button type="button" id="quick_Booking" hotel_id="{$hotel_id}" class="btn btn-primary upper">Đặt phòng nhanh</button>
            <input type="hidden" value="Sign me up" name="Submit"/>
            <input type="hidden" value="{$hotel_room_id}" name="hotel_room_id" id="hotel_room_id_rqprice" />
            <input type="hidden" value="{$hotel_id}" name="hotel__id" id="hotel_id_rqprice" />
			<input type="hidden" value="{$number_bookroom}" name="number_bookroom" id="number_bookroom" />
            <input type="hidden" value="{$departure_in}" name="departure_in" id="departure_in" />
			<input type="hidden" value="{$departure_out}" name="departure_out" id="departure_out" />
		</center>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Booking Group -->
<div class="modal fade" id="bookingGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ĐẶT PHÒNG ĐOÀN</h4>
      </div>
      <form action="" method="post" class="quickbookingform">
          <div class="modal-body">
            <div class="findDealForCustomerHeading vspacingbottom15">
                Khi đặt phòng theo đoàn với vietnamhotel.com, bạn sẽ có được khách sạn phù hợp nhất với giá tốt nhất mà không phải tốn thời gian tìm kiếm.
            </div>
            <div class="form-group">
                <label class="control-label">Yêu cầu</label>
                <textarea class="form-control" rows="5" id="intro_bookinggroup" placeholder="Xin vui lòng điền tóm tắt thông tin đặt phòng cho đoàn của bạn tại đây.Chúng tôi sẽ liên hệ bạn trong vòng 1 tiếng giờ hành chính."></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label">Điện thoại</label>
                        <input class="form-control" id="bookinggroup_phone" placeholder="Số điện thoại" />
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" id="bookinggroup_email0" placeholder="Địa chỉ email" />
                    </div>
                </div>
            </div>
            <div id="bookinggroup_msg3" class="bookinggroup_msg3"></div>
          </div>
          <div class="modal-footer" align="center">
            <center>
                <button type="button" id="booking_Group" class="btn btn-primary upper">Đặt phòng đoàn</button>
                <input type="hidden" value="Sign me up" name="Submit"/>
            </center>
          </div>
    </form>
    </div>
  </div>
</div>
{*Click để lấy giá*}
<div class="modal fade" id="quickRequestPrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Lấy giá thành viên {$clsHotel->getTitle($hotel_id)}</h4>
      </div>
      <form action="" method="post" class="quickrequestpriceform">
      <div class="modal-body">
	  	<div class="findDealForCustomerHeading vspacingbottom15">
			Khi đặt phòng theo đoàn với VietNamHotel, bạn sẽ có được khách sạn phù hợp nhất với giá tốt nhất mà không phải tốn thời gian tìm kiếm.
		</div>
        <div class="form-group">
			<label class="control-label">Yêu cầu</label>
			<textarea class="form-control" name="introRequestPrice" id="intro_quickrequestprice" rows="5" placeholder="Xin vui lòng điền tóm tắt thông tin đặt phòng cho đoàn của bạn tại đây.Chúng tôi sẽ liên hệ bạn trong vòng 1 tiếng giờ hành chính."></textarea>
		</div>
        <div class="form-group">
			<label class="control-label">Họ tên</label>
			<input class="form-control" id="quickrequestprice_name" placeholder="Họ và tên" />
		</div>
		<div class="row">
			<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">Điện thoại</label>
					<input class="form-control" id="quickrequestprice_phone" placeholder="Số điện thoại" />
				</div>
			</div>
			<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">Email</label>
					<input class="form-control" id="quickrequestprice_email0" placeholder="Địa chỉ email" />
				</div>
			</div>
		</div>
        <div id="quickrequestprice_msg3" class="quickrequestprice_msg"></div>
      </div>
      <div class="modal-footer" align="center">
	  	<center>
        	<button type="button" id="quick_RequestPrice" hotel_id="{$hotel_id}" class="btn btn-primary upper">Lấy giá</button>
            <input type="hidden" value="Sign me up" name="Submit"/>
            <input type="hidden" value="{$hotel_room_id}" name="hotel_room_id" id="hotel_room_id_reqprice" />
            <input type="hidden" value="{$hotel_id}" name="hotel__id" id="hotel_id_rqprice" />
			<input type="hidden" value="{$number_bookroom}" name="number_bookroom" id="number_bookroom" />
            <input type="hidden" value="{$departure_in}" name="departure_in" id="departure_in" />
			<input type="hidden" value="{$departure_out}" name="departure_out" id="departure_out" />
		</center>
      </div>
      </form>
    </div>
  </div>
</div>


{*book room*}
<div class="modal fade in" id="bookingRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:700px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" style="text-transform: uppercase; line-height:1.7">Lấy giá thành viên {$clsHotel->getTitle($hotel_id)}</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12 visible-xs">
          <div class="vspacingtop15"></div>
        </div>
        <span style="line-height: 1.7">Giá ưu đãi đặc biệt chỉ có qua email và điện thoại.</span>
        <h4 style="">Ngày đặt phòng</h4>
        <br>
        <div class="filterPanel" id="getMemberPriceModalFilterPanel2">
          <div class="searchbox-wrap clearfix" id="menu-search-data2">
            <form action="" method="POST">
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                  <div class="form-group has-feedback inputPadding">
                    <label class="control-label" for="datepicker_chkin">Ngày nhận phòng</label>
                    <div class="datepickerDiv">
                    <input id="datepicker_chkin" name="datepicker_chkin" maxlength="18" value="{if $departure_in ne ''}{$clsISO->formatTimeDate($departure_in)}{else}{$clsISO->formatTimeDate($now)}{/if}" class="form-control dateTxt required hasIconPicker" placeholder="mm/dd/yyyy"/>
                     
					</div>
                  </div>
                </div>
                <div class=" col-xs-12 col-sm-6 col-md-3 col-lg-3">
                  <div class="form-group has-feedback inputPadding">
                    <label class="control-label" for="datepicker_chkout">Ngày trả phòng</label>
                    <div class="datepickerDiv">
                    <input id="datepicker_chkout" name="datepicker_chkout" maxlength="18" value="{$clsISO->formatTimeDate($departure_out)}" class="form-control dateTxt required hasIconPicker" placeholder="mm/dd/yyyy"/>
					</div>
                  </div>
                </div>
              </div>
              <div class="visible-xs visible-sm visible-md">
                <div class="col-xs-12 col-sm-12 col-md-12 vspacing"></div>
              </div>
            </form>
          </div>
        </div>
        <h4>Thông tin khách hàng</h4>
        <br>
        <div class="filterPanel">
          <div class="searchbox-wrap clearfix">
            <form action="" method="POST">
              <div class="row vspacingbottom15">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 spanLabel"><span><b>Họ tên:</b></span></div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                  <input maxlength="255" type="text" class="form-control input-sm" id="bookingroom_name">
                </div>
              </div>
              <div class="row vspacingbottom15">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 spanLabel"><span><b>Số di động:</b></span></div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                  <input type="text" class="form-control input-sm" id="bookingroom_phone">
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 spanLabel"><span><b>Email:</b></span></div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                  <input type="text" class="form-control input-sm" id="bookingroom_email">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="bookingroom_msg" class="quickbooking_msg"></div>
      <div class="modal-footer" align="center">
        <center>
            <button type="button" id="booking_Room" hotel_id="{$hotel_id}" class="btn btn-primary upper">Gửi yêu cầu</button>
            <input type="hidden" value="Sign me up" name="Submit" />
						<input type="hidden" value="{$hotel_room_id}" name="hotel_room_id" id="hotel_room_id_bookroom" />
						<input type="hidden" value="{$number_bookroom}" name="number_bookroom" id="number_bookroom" />
        </center>
      </div>
    </div>
  </div>
  {literal}
	<style type="text/css">
		#bookingroom_msg{padding-left:20px;}
    </style>
{/literal}
</div>
{* request price*}
<div class="modal fade in" id="requestPrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:700px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" style="text-transform: uppercase; line-height:1.7">Lấy giá thành viên {$clsHotel->getTitle($hotel_id)}</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12 visible-xs">
          <div class="vspacingtop15"></div>
        </div>
        <span style="line-height: 1.7">Giá ưu đãi đặc biệt chỉ có qua email và điện thoại.</span>
        <h4 style="">Ngày đặt phòng</h4>
        <br>
        <div class="filterPanel" id="getMemberPriceModalFilterPanel2">
          <div class="searchbox-wrap clearfix" id="menu-search-data2">
            <form action="" method="POST">
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                  <div class="form-group has-feedback inputPadding">
                    <label class="control-label" for="datepicker_chkin">Ngày nhận phòng</label>
                    <div class="datepickerDiv">
                    <input id="datepicker_chkin_rqprice" name="datepicker_chkin" maxlength="18" value="{if $departure_in ne ''}{$clsISO->formatTimeDate($departure_in)}{else}{$clsISO->formatTimeDate($now)}{/if}" class="form-control dateTxt required hasIconPicker" placeholder="mm/dd/yyyy"/>
                     
					</div>
                  </div>
                </div>
                <div class=" col-xs-12 col-sm-6 col-md-3 col-lg-3">
                  <div class="form-group has-feedback inputPadding">
                    <label class="control-label" for="datepicker_chkout">Ngày trả phòng</label>
                    <div class="datepickerDiv">
                    <input id="datepicker_chkout_rqprice" name="datepicker_chkout" maxlength="18" value="{$clsISO->formatTimeDate($departure_out)}" class="form-control dateTxt required hasIconPicker" placeholder="mm/dd/yyyy"/>
					</div>
                  </div>
                </div>
              </div>
              <div class="visible-xs visible-sm visible-md">
                <div class="col-xs-12 col-sm-12 col-md-12 vspacing"></div>
              </div>
            </form>
          </div>
        </div>
        <h4>Thông tin khách hàng</h4>
        <br>
        <div class="filterPanel">
          <div class="searchbox-wrap clearfix">
            <form action="" method="POST">
              <div class="row vspacingbottom15">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 spanLabel"><span><b>Họ tên:</b></span></div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                  <input maxlength="255" type="text" class="form-control input-sm" id="bookingroom_name_rqprice">
                </div>
              </div>
              <div class="row vspacingbottom15">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 spanLabel"><span><b>Số di động:</b></span></div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                  <input maxlength="100" type="text" class="form-control input-sm" id="bookingroom_phone_rqprice">
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 spanLabel"><span><b>Email:</b></span></div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                  <input maxlength="100" type="text" class="form-control input-sm" id="bookingroom_email_rqprice">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="requestPrice_msg" class="quickbooking_msg"></div>
      <div class="modal-footer" align="center">
        <center>
            <button type="button" id="request_Price" hotel_id="{$hotel_id}" class="btn btn-primary upper">Gửi yêu cầu</button>
            <input type="hidden" value="Sign me up" name="Submit" />
						<input type="hidden" value="{$hotel_room_id}" name="hotel_room_id" id="hotel_room_id_rqprice" />
        </center>
      </div>
    </div>
  </div>
  {literal}
	<style type="text/css">
		#requestPrice_msg{padding-left:20px;}
    </style>
{/literal}
</div>

<script type="text/javascript">
	var msg_intro_required = "{$core->get_Lang('Your request should not be empty ')}!";
	var path_ajax_script = '{$PCMS_URL}';    
	var msg_name_required = "{$core->get_Lang('Your name should not be empty ')}!";
    var msg_phone_required = "{$core->get_Lang('Your phone should not be empty ')}!";
    var msg_email_required = "{$core->get_Lang('Your email should not be empty ')}!";
	var msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
	var msg_success = "{$core->get_Lang('Sign up for email success')}!";
	var msg_exits = "{$core->get_Lang('Email address already exists')}!";
	var msg_exits2 = "{$core->get_Lang('Đăng ký không thành công')}!";
	var departure_in = "{if $departure_in ne ''}{$clsISO->formatTimeDate($departure_in)}{else}{$clsISO->formatTimeDate($now)}{/if}";
	var departure_out = "{$departure_out}";
</script>
{literal}
<style type="text/css">
</style>
<script type="text/javascript">
$(function() {
	if(!departure_in)
	{
	 $('#datepicker_chkin').datepicker({
		 beforeShow: function (input, inst) {
		setTimeout(function () {
			inst.dpDiv.css({
				top: 260,
			});
		}, 
		0);
			},
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
				$('#datepicker_chkout').datepicker('option', {minDate: date}).datepicker('setDate', date); 
			},
			onClose: function(dateText, inst){
				$('#datepicker_chkout').focus();
			}	
		});
		/*requestPrice*/
		 $('#datepicker_chkin_rqprice').datepicker({
		 beforeShow: function (input, inst) {
		setTimeout(function () {
			inst.dpDiv.css({
				top: 260,
			});
		}, 
		0);
			},
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
				$('#datepicker_chkout_rqprice').datepicker('option', {minDate: date}).datepicker('setDate', date); 
			},
			onClose: function(dateText, inst){
				$('#datepicker_chkout_rqprice').focus();
			}	
		});
	}
	if(!departure_out){
		$("#datepicker_chkout").datepicker( { 
			beforeShow: function (input, inst) {
				setTimeout(function () {
					inst.dpDiv.css({
						top: 260,
					});
				}, 
				0);
			},
			dateFormat: "mm/dd/yy", 
			minDate: new Date(), maxDate: "+1Y",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			showOtherMonths: true
		});	
		/*requestPrice*/
		$("#datepicker_chkout_rqprice").datepicker( { 
			beforeShow: function (input, inst) {
				setTimeout(function () {
					inst.dpDiv.css({
						top: 260,
					});
				}, 
				0);
			},
			dateFormat: "mm/dd/yy", 
			minDate: new Date(), maxDate: "+1Y",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			showOtherMonths: true
		});	
	}
});
</script>
<script type="text/javascript">
	$(function(){
		$("#quick_Booking").click(function(){
			var $hotel_id=$(this).attr('hotel_id');
			var $hotel__id=$("#hotel_id_rqprice").val();
			var $hotel_room_id=$("#hotel_room_id_rqprice").val();
			var $departure_in=$("#departure_in").val();
			var $departure_out=$("#departure_out").val();
			var $quickbooking_name = $("#quickbooking_name").val();
			var $quickbooking_intro = $("#intro_quickbooking").val();
			var $quickbooking_phone = $("#quickbooking_phone").val();
			var $quickbooking_email0 = $("#quickbooking_email0").val();
			
			if($("#intro_quickbooking").val()==''){
				 $('#quickbooking_msg3').html(msg_intro_required).fadeIn().delay(3000).fadeOut();
                 $("#intro_quickbooking").focus();
			     return false;
			}
			if($("#quickbooking_name").val()==''){
				 $('#quickbooking_msg3').html(msg_name_required).fadeIn().delay(3000).fadeOut();
                 $("#quickbooking_name").focus();
			     return false;
			}
			if($("#quickbooking_phone").val()==''){
				 $('#quickbooking_msg3').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
                 $("#quickbooking_phone").focus();
			     return false;
			}
			if($("#quickbooking_email0").val()==''){
				 $('#quickbooking_msg3').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                 $("#quickbooking_email0").focus();
			     return false;
			}
			if(checkValidEmail($quickbooking_email0)==false){
				 $('#quickbooking_msg3').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                 $("#quickbooking_email0").focus();
			     return false;
			}
			var adata = {
				'hotel_id':$hotel_id,
				'hotel__id':$hotel__id,
				'hotel_room_id':$hotel_room_id,
				'departure_in':$departure_in,
				'departure_out':$departure_out,
				'intro' : $quickbooking_intro,
				'name' : $quickbooking_name,
				'phone' : $quickbooking_phone,
				'email' : $quickbooking_email0,
				'type' : 'QUICKBOOKING',
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=home&act=ajQuickBooking',
				data : adata,
				dataType:'html',
				success:function(html){
				if(html.indexOf("_SUCCESS") >= 0) {
    					$('#quickbooking_msg3').html(msg_success).fadeIn().delay(3000).fadeOut();
    				} else {
    					$('#quickbooking_msg3').html(msg_exits2).fadeIn().delay(3000).fadeOut();
    				}
    			}
    		});
    		return false;
		});
	});
	$(function(){
		$("#quick_RequestPrice").click(function(){
			var $hotel_id=$(this).attr('hotel_id');
			var $hotel_room_id=$("#hotel_room_id_reqprice").val();
			var $departure_in=$("#departure_in").val();
			var $departure_out=$("#departure_out").val();
			var $quickrequestprice_name = $("#quickrequestprice_name").val();
			var $quickrequestprice_intro = $("#intro_quickrequestprice").val();
			var $quickrequestprice_phone = $("#quickrequestprice_phone").val();
			var $quickrequestprice_email0 = $("#quickrequestprice_email0").val();
			
			if($("#intro_quickrequestprice").val()==''){
				 $('#quickrequestprice_msg3').html(msg_intro_required).fadeIn().delay(3000).fadeOut();
                 $("#intro_quickrequestprice").focus();
			     return false;
			}
			if($("#quickrequestprice_name").val()==''){
				 $('#quickrequestprice_msg3').html(msg_name_required).fadeIn().delay(3000).fadeOut();
                 $("#quickrequestprice_name").focus();
			     return false;
			}
			if($("#quickrequestprice_phone").val()==''){
				 $('#quickrequestprice_msg3').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
                 $("#quickrequestprice_phone").focus();
			     return false;
			}
			if($("#quickrequestprice_email0").val()==''){
				 $('#quickrequestprice_msg3').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                 $("#quickrequestprice_email0").focus();
			     return false;
			}
			if(checkValidEmail($quickrequestprice_email0)==false){
				 $('#quickrequestprice_msg3').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                 $("#quickrequestprice_email0").focus();
			     return false;
			}
			var adata = {
				'hotel_id':$hotel_id,
				'hotel_room_id':$hotel_room_id,
				'departure_in':$departure_in,
				'departure_out':$departure_out,
				'intro' : $quickrequestprice_intro,
				'name' : $quickrequestprice_name,
				'phone' : $quickrequestprice_phone,
				'email' : $quickrequestprice_email0,
				'type' : 'REQUESTPRICE',
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=home&act=ajQuickRequestPrice',
				data : adata,
				dataType:'html',
				success:function(html){
				if(html.indexOf("_SUCCESS") >= 0) {
    					$('#quickrequestprice_msg3').html(msg_success).fadeIn().delay(3000).fadeOut();
    				} else {
    					$('#quickrequestprice_msg3').html(msg_exits2).fadeIn().delay(3000).fadeOut();
    				}
    			}
    		});
    		return false;
		});
	});
	$(function(){
		$("#booking_Group").click(function(){
			var $bookinggroup_intro = $("#intro_bookinggroup").val();
			var $bookinggroup_phone = $("#bookinggroup_phone").val();
			var $bookinggroup_email0 = $("#bookinggroup_email0").val();
			
			if($("#intro_bookinggroup").val()==''){
				 $('#bookinggroup_msg3').html(msg_intro_required).fadeIn().delay(3000).fadeOut();
                 $("#intro_bookinggroup").focus();
			     return false;
			}
			if($("#bookinggroup_phone").val()==''){
				 $('#bookinggroup_msg3').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
                 $("#bookinggroup_phone").focus();
			     return false;
			}
			if($("#bookinggroup_email0").val()==''){
				 $('#bookinggroup_msg3').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                 $("#bookinggroup_email0").focus();
			     return false;
			}
			if(checkValidEmail($bookinggroup_email0)==false){
				 $('#bookinggroup_msg3').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                 $("#bookinggroup_email0").focus();
			     return false;
			}
			var adata = {
				'intro' : $bookinggroup_intro,
				'phone' : $bookinggroup_phone,
				'email' : $bookinggroup_email0,
				'type' : 'GROUP',
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=home&act=ajQuickBooking',
				data : adata,
				dataType:'html',
				success:function(html){
				if(html.indexOf("_SUCCESS") >= 0) {
    					$('#bookinggroup_msg3').html(msg_success).fadeIn().delay(3000).fadeOut();
    				} else {
    					$('#bookinggroup_msg3').html(msg_exits).fadeIn().delay(3000).fadeOut();
    				}
    			}
    		});
    		return false;
		});
	});
	$(function(){
		$("#booking_Room").click(function(){
			var $hotel_id=$(this).attr('hotel_id');
			var $hotel_room_id=$("#hotel_room_id_bookroom").val();
			var $number_room=$("#number_bookroom").val();
			var $bookingroom_datecheck_in = $("#datepicker_chkin").val();
			var $bookingroom_datecheck_out = $("#datepicker_chkout").val();
			var $bookingroom_fullname = $("#bookingroom_name").val();
			var $bookingroom_phone = $("#bookingroom_phone").val();
			var $bookingroom_email = $("#bookingroom_email").val();
			if($("#datepicker_chkin").val()==''){
                 $("#datepicker_chkin").focus();
			     return false;
			}
			if($("#datepicker_chkout").val()==''){
                 $("#datepicker_chkout").focus();
			     return false;
			}
			if($("#bookingroom_name").val()==''){
				 $('#bookingroom_msg').html(msg_name_required).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_name").focus();
			     return false;
			}
			if($("#bookingroom_phone").val()==''){
				 $('#bookingroom_msg').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_phone").focus();
			     return false;
			}
			if($("#bookingroom_email").val()==''){
				 $('#bookingroom_msg').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_email").focus();
			     return false;
			}
			
			if(checkValidEmail($bookingroom_email)==false){
				 $('#bookingroom_msg').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_email").focus();
			     return false;
			}
			$('#bookingroom_msg').html('<p style="color:#00aaff">loading...</p>');
			var adata = {
				'hotel_id':$hotel_id,
				'hotel_room_id':$hotel_room_id,
				'number_room':$number_room,
				'check_indate' : $bookingroom_datecheck_in,
				'check_outdate' : $bookingroom_datecheck_out,
				'name' : $bookingroom_fullname,
				'phone' : $bookingroom_phone,
				'email' : $bookingroom_email,
				'type' : 'BOOKINGROOM',
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=hotelpro&act=bookroom',
				data : adata,
				dataType:'html',
				success:function(html){
				if(html.indexOf("_SUCCESS") >= 0) {
    					$('#bookingroom_msg').html('<p style="color:#3dd200">'+msg_success+'</p>').fadeIn().delay(3000).fadeOut();
    				} else {
    					$('#bookingroom_msg').html('<p style="color:#af2024">'+msg_exits+'</p>').fadeIn().delay(3000).fadeOut();
    				}
    			}
    		});
    		return false;
		});
	});
	$(function(){
		$("#request_Price").click(function(){
			var $hotel_id=$(this).attr('hotel_id');
			var $hotel_room_id=$("#hotel_room_id_rqprice").val();
			var $bookingroom_datecheck_in = $("#datepicker_chkin_rqprice").val();
			var $bookingroom_datecheck_out = $("#datepicker_chkout_rqprice").val();
			var $bookingroom_fullname = $("#bookingroom_name_rqprice").val();
			var $bookingroom_phone = $("#bookingroom_phone_rqprice").val();
			var $bookingroom_email = $("#bookingroom_email_rqprice").val();
			if($("#datepicker_chkin_rqprice").val()==''){
                 $("#datepicker_chkin_rqprice").focus();
			     return false;
			}
			if($("#datepicker_chkout_rqprice").val()==''){
                 $("#datepicker_chkout_rqprice").focus();
			     return false;
			}
			if($("#bookingroom_name_rqprice").val()==''){
				 $('#requestPrice_msg').html(msg_name_required).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_name_rqprice").focus();
			     return false;
			}
			if($("#bookingroom_phone_rqprice").val()==''){
				 $('#requestPrice_msg').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_phone_rqprice").focus();
			     return false;
			}
			if($("#bookingroom_email_rqprice").val()==''){
				 $('#requestPrice_msg').html(msg_email_required).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_email_rqprice").focus();
			     return false;
			}
			
			if(checkValidEmail($bookingroom_email)==false){
				 $('#requestPrice_msg').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
                 $("#bookingroom_email_rqprice").focus();
			     return false;
			}
			$('#requestPrice_msg').html('<p style="color:#00aaff">loading...</p>');
			var adata = {
				'hotel_id':$hotel_id,
				'hotel_room_id':$hotel_room_id,
				'check_indate' : $bookingroom_datecheck_in,
				'check_outdate' : $bookingroom_datecheck_out,
				'name' : $bookingroom_fullname,
				'phone' : $bookingroom_phone,
				'email' : $bookingroom_email,
				'type' : 'REQUESTPRICE',
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=hotelpro&act=requestprice',
				data : adata,
				dataType:'html',
				success:function(html){
				if(html.indexOf("_SUCCESS") >= 0) {
    					$('#requestPrice_msg').html('<p style="color:#3dd200">'+msg_success+'</p>').fadeIn().delay(3000).fadeOut();
    				} else {
    					$('#requestPrice_msg').html('<p style="color:#af2024">'+msg_exits+'</p>').fadeIn().delay(3000).fadeOut();
    				}
    			}
    		});
    		return false;
		});
	});
	
	function checkValidEmail(email){
		var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
</script>
{/literal}