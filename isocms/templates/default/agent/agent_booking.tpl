<div class="page_container bg_fff">
	<div class="nav_agent">
		<div class="container">
			<ul class="nav_ul_agent">
				<li><a href="/dai-ly-du-lich/thong-tin-tai-khoan.html" title="{$core->get_Lang('Thông tin cá nhân')}">{$core->get_Lang('Thông tin cá nhân')}</a></li>
				<li><a class="current" href="{$curl}" title="{$core->get_Lang('Tour đã đặt')}">{$core->get_Lang('Tour đã đặt')}</a></li>
				<li><a href="/dai-ly-du-lich/danh-gia-va-anh.html" title="{$core->get_Lang('Đánh giá và ảnh')}">{$core->get_Lang('Đánh giá và ảnh')}</a></li>
			</ul>
		</div>
	</div>
    <div id="contentPage" class="pageAgent pageAgentRegister pdt0">
		<div class="container">
			<div class="wishlist-media">
				<h1 class="title24">{$core->get_Lang('My Booking')} <span>({$totlalBooking})</span></h1>
				{if $lstBookingHotel}
				<h3>{$core->get_Lang('List Hotels Booking')}</h3>
				{section name=i loop=$lstBookingHotel}
				<div class="bookingItem">
					<div class="bookingTop">
						<div class="row">
							<div class="col-md-8 col-sm-8">
								<div class="col-xs-4">
									<div class="pic_hotel">
										<img src="{$clsHotel->getImage($lstBookingHotel[i].target_id,193,129)}" class="static" width="90" height="60" alt="{$clsHotel->getTitle($lstBookingHotel[i].target_id)}" style="height: 60px; width: 90px;">
								</div>
								</div>
								<div class="col-xs-8">
									<p class="content_blue">
										<b>
											<a class="hotelLinks" href="{$clsHotel->getLink($lstBookingHotel[i].target_id)}" title="{$clsHotel->getTitle($lstBookingHotel[i].target_id)}">{$clsHotel->getTitle($lstBookingHotel[i].target_id)}</a>
										</b>
									</p>
									{if $clsHotel->getAddress($lstBookingHotel[i].target_id) ne ''}
										<p class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($lstBookingHotel[i].target_id)}</p>
									 {/if}
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="date_hotel_booking">
									<p>
										<span class="date_hotel_on">{$core->get_Lang('Booked on')}</span> 
										<span class="date_hotel">{$clsISO->converTimeToText($clsBooking->getOneField('reg_date',$lstBookingHotel[i].booking_id))}</span>
									</p>
								</div>
							</div>
						</div>
					</div>
					 <div class="clear"></div>
					<div class="allbox">
						{assign var=Store_Hotel value=$clsBooking->getBookingValue($lstBookingHotel[i].booking_id)}
						<div class="row">
							<div class="allbox_left col-sm-6 col-md-8">
								<p class="booking_left">
									{$core->get_Lang('Booking ID')}
								</p>
								<p class="booking_right">
									{$clsBooking->getOneField('booking_code',$lstBookingHotel[i].booking_id)}
								</p>
								<div class="clear"></div>
								<p class="booking_left">
									{$core->get_Lang('Check-in')}:
								</p>
								<p class="booking_right">
									
									<span>{$Store_Hotel.checkin}</span>
								</p>
								<div class="clear"></div>
								<p class="booking_left">
									{$core->get_Lang('Check-out')}:
								</p>
								<p class="booking_right">
									<span>{$Store_Hotel.checkout}</span>
								</p>
								<div class="clear"></div>
							</div>
							<div class="allbox_right col-sm-6 col-md-4">
								<p>
									<span class="money_hotel">{$clsHotel->getPrice($lstBookingHotel[i].target_id)}</span>
								</p>
								{*<div class="manage_booking">
									<div>
										<a href="{$DOMAIN_NAME}/account/my-booking-detail-bkHotel-{$lstBookingHotel[i].target_id}.html" target="blank">{$core->get_Lang('Manage booking')}</a>
										<span class="sprite_arrow pic_arrow1" style="*margin-bottom: 2px !important;"></span>
									</div>
								</div>
								<div class="book_again"><a href="{$clsHotel->getLinkBook($lstBookingHotel[i].target_id)}" target="blank">{$core->get_Lang('Book again')}</a><span class="icon_book_again"></span></div>*}
							</div>
						</div>
					</div>
				</div>
				{/section}
				{/if}
				{if $lstBookingTour}
				<div class="cleafix mb30"></div>
				<h3>{$core->get_Lang('List Tour Booking')}</h3>
				{section name=i loop=$lstBookingTour}
				<div class="bookingItem">
					<div class="bookingTop">
						<div class="row">
							<div class="col-md-8 col-sm-8">
								<div class="row">
									<div class="col-sm-3 col-xs-4">
										<div class="pic_hotel">
											<img src="{$clsTour->getImage($lstBookingTour[i].target_id,100,65)}" class="static" width="100%" height="auto" alt="{$clsTour->getTitle($lstBookingTour[i].target_id)}">
										</div>
									</div>
									<div class="col-sm-9 col-xs-8">
										<div class="detail_hotel_booking">
											<p class="content_blue">
												<b>
													<a class="hotelLinks" href="{$clsTour->getLink($lstBookingTour[i].target_id)}" title="{$clsTour->getTitle($lstBookingTour[i].target_id)}">{$clsTour->getTitle($lstBookingTour[i].target_id)}</a>
												</b>
											</p>
											{if $clsTour->getCityAround($lstBookingTour[i].target_id) ne ''}
												<p class="address"><i class="fa fa-map-marker"></i> {$clsTour->getCityAround($lstBookingTour[i].target_id)}</p>
											 {/if}
											<div class="clear">&nbsp;</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="date_hotel_booking">
									<p>
										<span class="date_hotel_on">{$core->get_Lang('Booked on')}</span> 
										<span class="date_hotel">{$clsISO->converTimeToTextShort($clsBooking->getOneField('reg_date',$lstBookingTour[i].booking_id))}</span>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="allbox">
						{assign var=Store_Tour value=$clsBooking->getBookingValue($lstBookingTour[i].booking_id)}
						<div class="row">
							<div class="allbox_left col-md-8">
								<p class="booking_left">
									{$core->get_Lang('Booking ID')}
								</p>
								<p class="booking_right">
									{$clsBooking->getOneField('booking_code',$lstBookingTour[i].booking_id)}
								</p>
								<div class="clear"></div>
								<p class="booking_left">
									{$core->get_Lang('Check-in')}:
								</p>
								<p class="booking_right">
									
									<span>{$Store_Tour.departure_date}</span>
								</p>
								<div class="clear"></div>
								<p class="booking_left">
									{$core->get_Lang('Check-out')}:
								</p>
								<p class="booking_right">
									<span>{if $Store_Tour.end_date ne ''}{$Store_Tour.end_date}{else}{$clsBooking->getOneField('check_out',$lstBookingTour[i].booking_id)}&nbsp;{/if}</span>
								</p>
								<div class="clear"></div>
							</div>
							<div class="allbox_right col-md-4">
								<p>
									<span class="money_hotel">{$clsISO->getRate()} {$clsISO->formatPrice($Store_Tour.price_total_amount)}</span>
								</p>
								{*<div class="manage_booking">
									<div>
										<a href="{$DOMAIN_NAME}/account/my-booking-detail-bkTour-{$lstBookingTour[i].target_id}.html" target="blank">{$core->get_Lang('Manage booking')}</a>
										<span class="sprite_arrow pic_arrow1" style="*margin-bottom: 2px !important;"></span>
									</div>
								</div>
								<div class="book_again"><a href="{$clsTour->getLinkBook($lstBookingTour[i].target_id)}" target="blank">{$core->get_Lang('Book again')}</a><span class="icon_book_again"></span></div>*}
							</div>
						</div>
					</div>
				</div>
				{/section}
				{/if}
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var msg_fullname_required = "{$core->get_Lang('Your full name should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_phone_required = "{$core->get_Lang('Your telephone should not be empty')}!";
	var msg_company_name_required = "{$core->get_Lang('Your company name should not be empty')}!";
	var msg_position_required = "{$core->get_Lang('Your position should not be empty')}!";
	var msg_tax_code_required = "{$core->get_Lang('Your tax code should not be empty')}!";
	
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your confirm password should not be empty')}!";
	var msg_confirmpassword_not_valid = "{$core->get_Lang('Please enter the same value again password')}!";
	var msg_success = "{$core->get_Lang('Update profile for agent success')}!";
	var msg_error = "{$core->get_Lang('Update profile for agent not success')}!";
</script>
{literal}
<script type="text/javascript">
	$(function(){
		$("#btn_register").click(function(){
			var $fullname = $("#full_name").val();
			var $email = $("#email").val();
			var $phone = $("#phone").val();
			var $company_name = $("#company_name").val();
			var $position = $("#position").val();
			var $tax_code = $("#tax_code").val();
			
			if($("#full_name").val()==''){
				$('#error_full_name').html(msg_fullname_required).fadeIn().delay(3000).fadeOut();
				$("#full_name").focus();
				return false;
			}
			if($("#email").val()==''){
				$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if(checkValidEmail($email)==false){
				$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if($("#phone").val()==''){
				$('#error_phone').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
				$("#phone").focus();
				return false;
			}
			if($("#company_name").val()==''){
				$('#error_company_name').html(msg_company_name_required).fadeIn().delay(3000).fadeOut();
				$("#company_name").focus();
				return false;
			}
			if($("#position").val()==''){
				$('#error_position').html(msg_position_required).fadeIn().delay(3000).fadeOut();
				$("#position").focus();
				return false;
			}
			if($("#tax_code").val()==''){
				$('#error_tax_code').html(msg_tax_code_required).fadeIn().delay(3000).fadeOut();
				$("#tax_code").focus();
				return false;
			}
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=agent&act=update_profile_agent&lang='+LANG_ID,
				data : $('#agent_register_form').serialize(),
				dataType:'html',
				success:function(html){
					if(html.indexOf("_ERRORUPDATE") >= 0) {
						$('#agent_update_error_msg').html(msg_error).fadeIn().delay(3000).fadeOut();
					}else if(html.indexOf("_SUCCESSUPDATE") >= 0){
						$('#agent_update_success_msg').html(msg_success).fadeIn().delay(3000).fadeOut();
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