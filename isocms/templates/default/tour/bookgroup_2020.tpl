{assign var=title_tour value=$clsTour->getTitle($tour_id)}
{assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($tour_id,$now_day)}
{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
{assign var=checkvoucher value=$clsTour->getCheckVoucher($tour_id)}
<div class="page_container" id="tour_page_container">
	<div class="booking_header_box">
		<div class="container">
			<div class="header-main">
				<div class="logo_booking"><a href="{$DOMAIN_NAME}{$extLang}"  title ="{$PAGE_NAME}">  <img class="full-width height-auto" alt="{$PAGE_NAME}" src="{$clsConfiguration->getImageValue('HeaderLogo')}" /></a></div>
				<div class="count_step_booking hidden-xs">
					<div class="row">
						<div class="col-sm-4 p-0">
							<p class="text_num_step">1</p>
							<p class="text_step color_1c1c1c text-bold">{$core->get_Lang('Giỏ hàng')}</p>
						</div>
						<div class="col-sm-4 p-0">
							<p class="text_num_step step-2 step-empty">2</p>
							<p class="text_step color_666">{$core->get_Lang('Chi tiết thanh toán')}</p>
						</div>
						<div class="col-sm-4 p-0">
							<p class="text_num_step step-3 step-empty">3</p>
							<p class="text_step color_666">{$core->get_Lang('Đã xác nhận thanh toán')}</p>
						</div>
					</div>
				</div>
				<div class="box_phone_booking">
					<a class="phone_booking" href="tel:{$clsConfiguration->getValue('CompanyPhone')}" title="{$core->get_Lang('Call')}"><i class="fa fa-phone" aria-hidden="true"></i>{$core->get_Lang('Question Call')}: {$clsConfiguration->getValue('CompanyPhone')}</a>
				</div>
			</div>
		</div>
	</div>	
    <section id="booking" class="pd40_0 color_f9f9f9">
		<div class="container">
			<form action="" method="post" class="formBookingTour">
				{*<h1 class="mb30 size35">{$title_tour}</h1>*}
				<h1 class="mb20 size30">{$core->get_Lang('Chi tiết thanh toán')}</h1>
				<div class="row">
					<div class="col-md-8">
					<p class="note size16">{$core->get_Lang('Vui lòng không bỏ qua những thông tin *')}</p>
						{foreach from=$cartSessionService item=item name=item}
						{assign var=tour_id_z value=$item.tour_id_z}
						{assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
						{assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
						{assign var=number_adult value=$item.number_adults_z}
						{assign var=number_child value=$item.number_child_z}
						{assign var=number_infant value=$item.number_infants_z}
						{if $smarty.foreach.item.first}
						<div class="boxMainInfor">
							{if $err_msg}
							<div class="box-message_book">
								{$err_msg}
							</div>
							{/if}
							<div class="boxSelectDate bg_fff pd20_991">
								<div class="infoCustome_2020 bg_fff pd20_991">
								<h3 class="size22 mb05 text-bold"><span class="number">{$smarty.foreach.item.iteration}</span> {$title_package}</h3>
								<div class="dration_tour mb20">
									<span class="color_333">({$clsTour->getLTripDuration($tour_id_z)})</span>
								</div>
								<h3 class="size20 mb20">{$core->get_Lang('Vui lòng nhập thông tin liên hệ')}</h3>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="first_name" name="first_name" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" id="birthday_{$tour_id_z}">
									</div>
									{literal}
									<script>
										document.addEventListener("DOMContentLoaded", function () {
											$(function(){
												$("#birthday_{/literal}{$tour_id_z}{literal}").dateDropdowns({
													submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}',
													minAge: 18,
													defaultDate: '1980-01-01'
												});
											});
										})
									</script>
									{/literal}
								</div>
								<div class="group-2 dp-flex">
									<div class="form-group telephone">
										<label>{$core->get_Lang('Phone Number')} <span style="color: red">*</span></label>
										<input id="telephone" name="telephone" placeholder="{$clsConfiguration->getValue('CompanyPhone')}" type="text" class="form-booking_input" value="{$phone}">
									</div>
									<div class="form-group email">
										<label>{$core->get_Lang('Email')} <span style="color: red">*</span></label>
										<input id="email" name="email" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" type="email" class="form-booking_input" value="{$email}"/>
									</div>
								</div>

								<label style="font-weight: 400">{$core->get_Lang('Địa chỉ')} <span style="color: red">*</span></label>
								<div class="group-3 dp-flex">
									<div class="form-group list_city">
										<select name="country_id"  class="form-booking_input find_select">
											{$clsCountryBK->getSelectByCountry($country_id)}
										</select>
									</div>
									<div class="form-group address">
										<input name="address" placeholder="{$core->get_Lang('Nhập địa chỉ chi tiết của bạn')}" type="text" class="required form-booking_input">
									</div>
								</div>
								
								<div class="form-group mb0">
									<label style="vertical-align:top">{$core->get_Lang('Lời nhắn')}</label>
									<textarea rows="7" class="form-control" cols="50" name="note" placeholder="{$core->get_Lang('Nhập điều bạn mong muốn, yêu cầu...')}."></textarea>
								</div>
							</div>
							</div>
							<h3 class="size20 mb20">{$core->get_Lang('Thông tin khách du lịch')}</h3>
							{section name=i loop=$number_adult}
							{assign var=idx value=$smarty.section.i.iteration}
							<div class="ItemAddit">
								<p><b>{$core->get_Lang('Khách hàng')} {$idx}</b></p>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title_adult_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="fullname" name="fullname_{$tour_id_z}_{$idx}" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday birthday_2">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" class="birthday" id="birthday_{$tour_id_z}_{$idx}">
									</div>
								</div>
							</div>
							{literal}
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									$(function(){
										$("#birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}").dateDropdowns({
											submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}',
											minAge: 12,
											defaultDate: '1980-01-01'
										});
									});
								})
							</script>
							{/literal}
							{/section}
							{if $number_child}
							{section name=i loop=$number_child}
							{assign var=idx value=$smarty.section.i.iteration}
							<div class="ItemAddit">
								<p><b>{$core->get_Lang('Children')} {$idx}</b></p>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title_child_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="fullname" name="fullname_{$tour_id_z}_{$idx}" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday birthday_2">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" class="birthday" id="birthday_{$tour_id_z}_{$idx}">
									</div>
								</div>
							</div>
							{literal}
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									$(function(){
										$("#birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}").dateDropdowns({
											submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}',
											minAge: 5,
											maxAge: 11,
											defaultDate: '2010-01-01'
										});
									});
								})
							</script>
							{/literal}
							{/section}
							{/if}
							{if $number_infant}
							{section name=i loop=$number_infant}
							{assign var=idx value=$smarty.section.i.iteration}
							<div class="ItemAddit">
								<p><b>{$core->get_Lang('Infant')} {$idx}</b></p>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title_infant_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="fullname" name="fullname_{$tour_id_z}_{$idx}" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday birthday_2">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" class="birthday" id="birthday_{$tour_id_z}_{$idx}">
									</div>
								</div>
							</div>
							{literal}
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									$(function(){
										$("#birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}").dateDropdowns({
											submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}',
											maxAge: 4,
											defaultDate: '2018-01-01'
										});
									});
								})
							</script>
							{/literal}
							{/section}
							{/if}
						</div>
						{else}
						<div class="boxMainInfor">
							<h3 class="size22 mb05 text-bold"><span class="number">{$smarty.foreach.item.iteration}</span> {$title_package}</h3>
							<div class="dration_tour">
								<span class="color_333">({$clsTour->getLTripDuration($tour_id_z)})</span>
							</div>
							<h3 class="size20 mb20">{$core->get_Lang('Vui lòng nhập thông tin liên hệ')}</h3>
							<div class="radio_infor">
								<label class="mb10" style="width: 100%;cursor: pointer">
									<input type="radio" class="chkInfor" name="radio_infor" id="radio_infor_1" checked value="1">
									{$core->get_Lang('Thông tin liên hệ như trên')}
								</label>
								<label class="mb20" style="width: 100%;cursor: pointer">
									<input type="radio" class="chkInfor" name="radio_infor" id="radio_infor_0" value="0">
									{$core->get_Lang('Thông tin khác')}
								</label>
							</div>
							<div class="form-group mb0">
								<label class="mb10" style="vertical-align:top;color: #666">{$core->get_Lang('Lời nhắn')}</label>
								<textarea rows="7" class="form-control" cols="50" name="note_infor" placeholder="{$core->get_Lang('Nhập điều bạn mong muốn, yêu cầu...')}."></textarea>
							</div>
							<h3 class="size20 mb20">{$core->get_Lang('Thông tin khách du lịch')}</h3>
							{section name=i loop=$number_adult}
							{assign var=idx value=$smarty.section.i.iteration}
							<div class="ItemAddit">
								<p><b>{$core->get_Lang('Khách hàng')} {$idx}</b></p>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title_adult_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="fullname" name="fullname_{$tour_id_z}_{$idx}" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday birthday_2">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" class="birthday" id="birthday_{$tour_id_z}_{$idx}">
									</div>
								</div>
							</div>
							{literal}
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									$(function(){
										$("#birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}").dateDropdowns({
											submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}',
											minAge: 12,
											defaultDate: '1980-01-01'
										});
									});
								})
							</script>
							{/literal}
							{/section}
							{if $number_child}
							{section name=i loop=$number_child}
							{assign var=idx value=$smarty.section.i.iteration}
							<div class="ItemAddit">
								<p><b>{$core->get_Lang('Children')} {$idx}</b></p>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title_child_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="fullname" name="fullname_{$tour_id_z}_{$idx}" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday birthday_2">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" class="birthday" id="birthday_{$tour_id_z}_{$idx}">
									</div>
								</div>
							</div>
							{literal}
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									$(function(){
										$("#birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}").dateDropdowns({
											submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}',
											minAge: 5,
											maxAge: 11,
											defaultDate: '2010-01-01'
										});
									});
								})
							</script>
							{/literal}
							{/section}
							{/if}
							{if $number_infant}
							{section name=i loop=$number_infant}
							{assign var=idx value=$smarty.section.i.iteration}
							<div class="ItemAddit">
								<p><b>{$core->get_Lang('Infant')} {$idx}</b></p>
								<div class="group-1 dp-flex">
									<div class="form-group">
										<label>{$core->get_Lang('Title (optional)')} <span style="color: red">*</span></label>
										<select id="title" name="title_infant_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
											{$clsISO->makeSelectTitle($title)}
										</select>
									</div>
									<div class="form-group full_name">
										<label>{$core->get_Lang('Họ và tên')} <span style="color: red">*</span></label>
										<input id="fullname" name="fullname_{$tour_id_z}_{$idx}" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="form-group birthday birthday_2">
										<label>{$core->get_Lang('Date of Birth')}</label>
										<input type="hidden" class="birthday" id="birthday_{$tour_id_z}_{$idx}">
									</div>
								</div>
							</div>
							{literal}
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									$(function(){
										$("#birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}").dateDropdowns({
											submitFieldName: 'birthday_{/literal}{$tour_id_z}{literal}_{/literal}{$idx}{literal}',
											maxAge: 4,
											defaultDate: '2018-01-01'
										});
									});
								})
							</script>
							{/literal}
							{/section}
							{/if}
						</div>
						{/if}
						{/foreach}
					</div>
					<div class="col-md-4">
						<div class="col_right_fixed" id="sidebar">
							<div class="amount_due">
								<label class="size18">{$core->get_Lang('Amount due')}</label>
								<input type="hidden" name="price_total_book" id="price_total_book_post" value="{$totalGrand}" />
								{if $_LANG_ID eq 'vn'}
								<span class="right"><span id="price_total_book" class="size22">{$clsISO->formatPrice($totalGrand)}</span>{$clsISO->getShortRate()}</span>
								{else}
								<span class="right">{$clsISO->getShortRate()}<span id="price_total_book" class="size22">{$clsISO->formatPrice($totalGrand)}</span></span>
								{/if}
							</div>
							<div class="info_tour pd20_991 bg_fff">
							{foreach from=$cartSessionService item=item name=item}
								{assign var=tour_id value=$item.tour_id_z}
								{assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
								{assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
								{assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
								{assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
								<div class="tour_item mb30">
								<div class="info_tour_item">
									<div class="info_tour">
										<h3 class="title mb10">{$smarty.foreach.item.iteration}. {$title_package}({$clsTour->getLTripDuration($tour_id)})</h3>
										<div class="row">
											<div class="col-md-6">
												<p class="departure_in4"><b>{$core->get_Lang('Khởi hành')}  </b></p>
												<p class="departure">{$clsTour->getListDeparturePoint($tour_id)}</p>
												<p class="start_date">{$clsISO->converTimeToText5($departure_date)}</p>
											</div>
											<div class="col-md-6">
												 <p> <b>{$core->get_Lang('Kết thúc')} </b> </p>
												 <p class="departure">{$clsTour->getEndCityAround($tour_id,1)}</p>
												 <span class="end_date">{$clsISO->converTimeToText5($end_date)}</span>
											</div>
										</div>
										 
									</div>
									{assign var=adult_visitor value=national_visitor$adult_type_id}
									{assign var=child_visitor value=national_visitor$child_type_id}
									{assign var=infant_visitor value=national_visitor$infant_type_id}
									{assign var=adult_price value=people_price$adult_type_id}
									{assign var=child_price value=people_price$child_type_id}
									{assign var=infant_price value=people_price$infant_type_id}

									{assign var=number_adult value=$item.number_adults_z}
									{assign var=number_child value=$item.number_child_z}
									{assign var=number_infant value=$item.number_infants_z}

									{assign var=price_adult value=$item.total_price_adults}
									{assign var=price_child value=$item.total_price_child}
									{assign var=price_infant value=$item.total_price_infants}
									{assign var=total_price_of_guests value=$price_adult+$price_child+$price_infant}
									{assign var=number_of_guests value=$number_adult+$number_child}
									<div class="info_price">
										<p><span class="lable">{$number_adult} {$core->get_Lang('Adults')}{if $number_child gt 0}, {$number_child} {$core->get_Lang('Child')}{/if}{if $number_infant gt 0}, {$number_infant} {$core->get_Lang('Infant')}{/if}</span> <span class="price">{$clsISO->formatPrice($total_price_of_guests)} <span class="text-underline">{$clsISO->getShortRate()}</span></span></p>
										{if $item.promotion_z >0}
										<p class="color_1fb69a"><span class="lable">{$core->get_Lang('Giảm giá')}</span>
										<span class="price">{$clsISO->formatPrice($item.price_promotion)} <span class="text-underline">{$clsISO->getShortRate()}</span></span>
										</p>
										{/if}
										{if $item.number_addon}
										<div class="price_service">
											{foreach from=$item.number_addon key=k item=v}
												{if $v gt 0}
												<div class="room_service_item">
													<p>
														<span class="lable">{$v} {$clsAddOnService->getTitle($k)}</span>
														{assign var=price_service value=$v*$clsAddOnService->getStrPrice($k)}
														<span class="price">
															{if $clsAddOnService->getExtra($k) eq '0'}
															{$core->get_Lang('Include')}
															{elseif $clsAddOnService->getExtra($k) eq '1'}
															{$clsAddOnService->getPrice($k)} <span class="text-underline">{$clsISO->getShortRate()}</span>
															{else}
															{$clsISO->formatPrice($price_service)} <span class="text-underline">{$clsISO->getShortRate()}</span>
															{/if}
														</span>
													</p>
												</div>
												{/if}
											{/foreach}
										</div>
										{/if}
									</div>
									</div>
									<div class="total_price">
										<span class="total">{$core->get_Lang('Total Price')}</span>
										<div class="total_price_right size22"><b>{$clsISO->formatPrice($item.total_price_z)}</b><span class="text-underline size16"> {$clsISO->getShortRate()}</span></div>
									</div>
								</div>
							{/foreach}
							</div>
							<div class="last_price_total">
								<div class="total_price">
									<p><span class="lable">{$core->get_Lang('Total Price')}</span>
										<span class="price">{$clsISO->formatPrice($totalGrand)}<span class="text-underline"> {$clsISO->getShortRate()}</span></span></p>
									<p><span class="lable">{$core->get_Lang('Deposits')}</span>
										<span class="price">{$clsISO->formatPrice($totalGrand)}<span class="text-underline"> {$clsISO->getShortRate()}</span></span></p>
									<p><span class="lable">{$core->get_Lang('Payment remaining')}</span>
										<span class="price">{$clsISO->formatPrice($totalGrand)}<span class="text-underline"> {$clsISO->getShortRate()}</span></span></p>
									<p><span class="lable">{$core->get_Lang('Total Payment')}</span>
										<span class="price">{$clsISO->formatPrice($totalGrand)}<span class="text-underline"> {$clsISO->getShortRate()}</span></span></p>
								</div>
							</div>
							<div class="social_card">
								<p>{$core->get_Lang('Chúng tôi hỗ trợ qua các cổng thanh toán')}:</p>
								<ul class="list_social_card">
									<li><img src="{$URL_IMAGES}/icon/payment.png" alt=""></li>
								</ul>
							</div>
							<div class="form-group clearfix">
								<div class="_captcha">
									{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
									<div class="col-md-2 col-sm-2 col-xs-4">
										<input type="text" maxlength="5" id="security_code" name="security_code" style="float:left; width:100%; margin-right:5px; height:43px" class="form-control required" placeholder="{$core->get_Lang('Security code')}" />
										<div id="error_security" class="error_security"></div>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-4 text-left">
										<img class="capcha_code" src="{$PCMS_URL}/captcha.php?sid={$sid}"  onclick="this.src='{$PCMS_URL}captcha.php?'+Math.random()+'&sid={$sid}';" width="80px" height="43px"  style="line-height:43px"/>
									</div>
									{else}
									<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
									{/if}
								</div>
								<div class="btn-booking">
									<button class="btn-bookinggroup" type="submit">
										{$core->get_Lang('Book tour')}
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="billing_infomation mt20">
							{if $clsISO->getVar('PAYMENT_GLOBAL') eq '1'}
								{$core->getBlock('pay_gateway_new')}
							{/if}
						</div>
					</div>
					<div class="col-md-4">
					</div>
				</div>
			</form>
		</div>
	</section>
	<div class="booking_footer_box main_footer">
		<div class="container">
		   <div class="footer_top">
				<ul class="quick-links">
					<li><a class="" href="" title="">{$core->get_Lang('Điều khoản &amp; Chính sách')}</a></li>
					<li><a class="" href="" title="">{$core->get_Lang('Chính sách thanh toán')}</a></li>
					<li><a class="" href="" title="">{$core->get_Lang('FAQs')}</a></li>
				</ul>
				<div class="social">
					<p>{$core->get_Lang('Theo dõi chúng tôi')}</p>
					<ul class="list_social box_col list_style_none">
					{if $clsConfiguration->getValue('Facebook_Link')}
						<li>
							<a class="facebook" href="http://www.facebook.com/{$clsConfiguration->getValue('SiteFacebookLink')}" target="_blank" title="{$core->get_Lang('Facebook')}">
								<i class="fa fa-facebook" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					{if $clsConfiguration->getValue('Twitter_Link')}
						<li>
							<a class="twitter" href="http://www.twitter.com/{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank" title="{$core->get_Lang('Twitter')}">
								<i class="fa fa-twitter" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					{if $clsConfiguration->getValue('Youtube_Link')}
						<li>
							<a class="youtube" href="http://www.youtube.com/{$clsConfiguration->getValue('SiteYoutubeLink')}" target="_blank" title="{$core->get_Lang('Youtube')}">
								<i class="fa fa-youtube-play" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					{if $clsConfiguration->getValue('Google_Plus_Link')}
						<li>
							<a class="google" href="http://plus.google.com/{$clsConfiguration->getValue('SiteGoogleLink')}" target="_blank" title="{$core->get_Lang('Google +')}">
								<i class="fa fa-google-plus" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					{if $clsConfiguration->getValue('Instagram_Link')}
						<li>
							<a class="instagram" href="https://www.instagram.com/{$clsConfiguration->getValue('SiteInstagramLink')}" target="_blank" title="{$core->get_Lang('Instagram')}">
								<i class="fa fa-instagram" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					{if $clsConfiguration->getValue('Printest_Link')}
						<li>
							<a class="pinterest" href="http://pinterest.com/{$clsConfiguration->getValue('SitePrintestLink')}" target="_blank" title="{$core->get_Lang('Printest')}">
								<i class="fa fa-pinterest-p" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					{if $clsConfiguration->getValue('LinkedIn_Link')}
						<li>
							<a class="linkedin" href="https://www.linkedin.com/{$clsConfiguration->getValue('SiteLinkInLink')}" target="_blank" title="{$core->get_Lang('LinkedIn')}">
								<i class="fa fa-linkedin" aria-hidden="true"></i>
							</a>
						</li>
					{/if}

					{if $clsConfiguration->getValue('TripAdvisor_Link')}
						<li>
							<a class="tripadvisor" href="http://www.tripadvisor.com/{$clsConfiguration->getValue('SiteTripAdvisorLink')}" target="_blank" title="{$core->get_Lang('TripAdvisor')}">
								<i class="fa fa fa-tripadvisor" aria-hidden="true"></i>
							</a>
						</li>
					{/if}
					</ul>
				</div>
			</div>
		</div>
		{assign var=Copyright value=Copyright_|cat:$_LANG_ID}
		{assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
		<div class="copy_right_cart text-center">
			<p class="copyRight mb0 size13">{$clsConfiguration->getValue($Copyright)} <span class="designWeb mb0 size13"><a title="{$core->get_Lang('Travel website design')}" href="https://www.vietiso.com/thiet-ke-website-du-lich.html" class="color_666">{$core->get_Lang('Travel website design')}</a>  {$core->get_Lang('by')} <a class="color_fff" href="https://www.vietiso.com" title="VIETISO">VIET<span class="color_f58220">ISO</span></a></span></p>
		</div>
	</div>
</div>
<script >
	var _LANG_ID = '{$_LANG_ID}';
	var adult_type_id = '{$adult_type_id}';
	var child_type_id = '{$child_type_id}';
	var infant_type_id = '{$infant_type_id}';
	var rate = '{$clsTour->getTripPriceOrgin($tour_id)}';
	var tour_id = '{$tour_id}';
	var price_adult = '';
	var price_child = '';
	var price_infant = '';
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
	var Select = '{$core->get_lang("Select")}';
	var Traveller = '{$core->get_lang("Traveller")}';
	var Title_optional = '{$core->get_lang("Title (optinal)")}';
	var optional = '{$core->get_lang("optional")}';
	var FullName = '{$core->get_lang("Full Name")}';
	var DateofBirth = '{$core->get_lang("Birthday")}';
	var Address = '{$core->get_lang("Address")}';
	var Female = '{$core->get_lang("Female")}';
	var Male = '{$core->get_lang("Male")}';
	var Gender = '{$core->get_lang("Gender")}';
	var Traveller_Type = '{$core->get_lang("Traveller Types")}'
	var adults = '{$core->get_lang("adults")}';
	var adult = '{$core->get_lang("adult")}';
	var Adult = '{$core->get_lang("Adult")}';
	var child = '{$core->get_lang("child")}';
	var Children = '{$core->get_lang("Children")}';
	var infant = '{$core->get_lang("infant")}';
	var Infant = '{$core->get_lang("Infant")}';
	var Mr = '{$core->get_lang("Mr")}';
	var Mrs = '{$core->get_lang("Mrs")}';
	var Ms = '{$core->get_lang("Ms")}';
	var Mss = '{$core->get_lang("Mss")}';
	var Dr = '{$core->get_lang("Dr")}';
	var Day = '{$core->get_lang("Day")}';
	var Month = '{$core->get_lang("Month")}';
	var Year = '{$core->get_lang("Year")}';
	var January = '{$core->get_lang("January")}'
	var February = '{$core->get_lang("February")}';
	var March = '{$core->get_lang("March")}';
	var April = '{$core->get_lang("April")}';
	var May = '{$core->get_lang("May")}';
	var June = '{$core->get_lang("June")}';
	var July = '{$core->get_lang("July")}';
	var August = '{$core->get_lang("August")}';
	var September = '{$core->get_lang("September")}';
	var October = '{$core->get_lang("October")}';
	var November = '{$core->get_lang("November")}';
	var December = '{$core->get_lang("December")}';
	var Jan = '{$core->get_lang("Jan")}'
	var Feb = '{$core->get_lang("Feb")}';
	var Mar = '{$core->get_lang("Mar")}';
	var Apr = '{$core->get_lang("Apr")}';
	var May = '{$core->get_lang("May")}';
	var Jun = '{$core->get_lang("Jun")}';
	var Jul = '{$core->get_lang("Jul")}';
	var Aug = '{$core->get_lang("Aug")}';
	var Sep = '{$core->get_lang("Sep")}';
	var Oct = '{$core->get_lang("Oct")}';
	var Nov = '{$core->get_lang("Nov")}';
	var Dec = '{$core->get_lang("Dec")}';
	var For = '{$core->get_lang("For")}';
	var loading = '{$core->get_lang("loading")}';
	var promotion_check = '{$promotion}';
	var ONEPAY_Surcharge = '{$clsConfiguration->getValue("ONEPAY_Surcharge")}';
	var ONEPAY_Visa_Surcharge = '{$clsConfiguration->getValue("ONEPAY_Visa_Surcharge")}';
	var ONEPAY_American_Express_Surcharge = '{$clsConfiguration->getValue("ONEPAY_American_Express_Surcharge")}';
	var Paypal_Surcharge = '{$clsConfiguration->getValue("Paypal_Surcharge")}';

</script>
<script defer src="{$URL_JS}/datepicker/jquery.date-dropdowns.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_CSS}/bookinggroup2020.css?v={$upd_version}">
{literal}
<script >
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){
			var $heightFooter = $('.footer_2019').outerHeight();
			$.lockfixed("#sidebar", {offset: {top: -170, bottom:620}});
			$(".btn-bookinggroup").click(function(){
				var $form_firstName = $("#first_name").val();
				var $form_lastName = $("#last_name").val();
				var $form_email = $("#email").val();
				var $form_phone = $("#telephone").val();
				if($("#first_name").val()==''){
					$("#first_name").focus();
					return false;
				}
				if($("#last_name").val()==''){
					$("#last_name").focus();
					return false;
				}
				if($("#email").val()==''){
					$("#email").focus();
					return false;
				}
				if(checkValidEmail($form_email)==false){
					$("#email").focus();
					return false;
				}
				if($("#telephone").val()==''){
					$("#telephone").focus();
					return false;
				}
				if(checkValidPhoneNumber($form_phone)==false){
					$("#telephone").focus();
					return false;
				}
				return true;
			});
		});


		function checkValidEmail(email){
			var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
		function checkValidPhoneNumber(phone)
		{
			var phoneno = /^\d{10,11}$/;
			if(phone.match(phoneno))
			return true;
			else
			return false;
		}
	})
</script>
{/literal}
<script defer src="{$URL_JS}/tipsy/tipsy.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/tipsy/tipsy.css?v={$upd_version}">