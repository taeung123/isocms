<div class="page_container" id="tour_page_container">
    <section id="booking" class="pd40_0 color_f9f9f9">
		<div class="container">
			<form action="" method="post" id="formBookingTour" class="formBookingTour">
				<h1 class="mb20 size35">{$core->get_Lang('Payment details')}</h1>
				<div class="row">
					<div class="col-lg-8">
						<div class="box_infor_book">
							<p class="note size16">{$core->get_Lang('Please do not ignore the information *')}</p>
							{if $cartSessionService or $cartSessionVoucher or $cartSessionCruise or $cartSessionHotel}
							<div class="boxMainInfor">
								{if $err_msg}
								<div class="box-message_book">
									{$err_msg}
								</div>
								{/if}
								<div class="box_contact_infor_book">
									
									<div class="box_infor_customer">
										<h3 class="size20 mb20">{$core->get_Lang('Please enter contact information')}</h3>
										<div class="group-1 dp-flex">
											<div class="form-group">
												<label>{$core->get_Lang('Title')} <span style="color: red">*</span></label>
												<select id="title" name="title" class="form-booking_input find_select">
													{$clsISO->makeSelectTitle($title)}
												</select>
											</div>
											<div class="form-group full_name">
												<label>{$core->get_Lang('Full Name')} <span style="color: red">*</span></label>
												<input id="fullname" name="fullname" placeholder="" type="text" class="form-booking_input" value="{if $fullname}{$fullname}{else}{$oneProfile.full_name}{/if}"/>
											</div>
											<div class="form-group birthday">
												<label>{$core->get_Lang('Date of Birth')}</label>
												<input type="hidden" id="birthday">
											</div>
											{literal}
											<script>
												document.addEventListener("DOMContentLoaded", function () {
													$(function(){
														$("#birthday").dateDropdowns({
															submitFieldName: 'birthday',
															minAge: 18,
															defaultDate: {/literal}'{$birthday}'{literal}
														});
													});
												});
											</script>
											{/literal}
										</div>
										<div class="group-2 dp-flex">
											<div class="form-group telephone">
												<label>{$core->get_Lang('Phone Number')} <span style="color: red">*</span></label>
												<input id="telephone" name="telephone" placeholder="" type="text" class="form-booking_input" value="{if $telephone}{$telephone}{else}{$oneProfile.phone}{/if}">
											</div>
											<div class="form-group email">
												<label>{$core->get_Lang('Email')} <span style="color: red">*</span></label>
												<input id="email" name="email" placeholder="" type="email" class="form-booking_input" value="{if $email}{$email}{else}{$oneProfile.email}{/if}"/>
											</div>
										</div>

										<label>{$core->get_Lang('Address')}</label>
										<div class="group-3 dp-flex">
											<div class="form-group list_city" style="display: none">
												<select name="country_id"  class="form-booking_input find_select">
													{$clsCountryBK->getSelectByCountry($country_id)}
												</select>
											</div>
											{*<div class="map_embed form-group address">
												<div class="map_search_box">
													<input class="text full fl form-booking_input" id="map-search-input" name="address" value="{$oneProfile.address}" type="text" placeholder="" />
												</div>
												<div id="map_canvas" style="width:100%; height:300px; overflow:hidden;display: none"></div>
											</div>*}
											<div class="form-group address">
												<input name="address" placeholder="{$core->get_Lang('Enter your detailed address')}" type="text" class="required form-booking_input" value="{if $address}{$address}{else}{$oneProfile.address}{/if}">
											</div>
										</div>
										<div class="form-group mb0">
											<label style="vertical-align:top">{$core->get_Lang('Messager')}</label>
											<textarea rows="7" class="form-control" cols="50" name="note" placeholder="{$core->get_Lang('Enter your wish, request...')}">{$note}</textarea>
										</div>
									</div>
								</div>
							</div>
							{foreach from=$cartSessionService item=item name=item}
							{assign var=tour_id_z value=$item.tour_id_z}
							{if $tour_id_z}
							{assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
							{assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
							{assign var=number_adult value=$item.number_adults_z}
							{assign var=number_child value=$item.number_child_z}
							{assign var=number_infant value=$item.number_infants_z}
							<div class="boxMainInfor">
								<div class="box_contact_infor_book">
									<div class="box_infor_customer">
										<div class="box_info_traveller">
											<h3 class="size20 mb20">{$core->get_Lang('Travelers information')}</h3>
											<div class="experience mb10">
											<span>{$core->get_Lang('Are you the one who experiences this tour?')}</span>
											<span class="radio_span">
												<input type="radio" class="ckh_experience" data-tour_id="{$tour_id_z}" name="experience_{$tour_id_z}" checked value="0">
												{$core->get_Lang('No')}
											</span>
											<span class="radio_span">
												<input type="radio" class="ckh_experience" data-tour_id="{$tour_id_z}" name="experience_{$tour_id_z}" value="1">
												{$core->get_Lang('Yes')}
											</span>
											</div>
											{section name=i loop=$number_adult}
											{assign var=idx value=$smarty.section.i.iteration}
											<div class="ItemAddit">
												<p class="text_bold">{$core->get_Lang('Customer')} {$idx}</p>
												<div class="group-1 dp-flex">
													<div class="form-group">
														<label>{$core->get_Lang('Title')}</label>
														<select id="title_adult_{$tour_id_z}_{$idx}" name="title_adult_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
															{$clsISO->makeSelectTitle($title)}
														</select>
													</div>
													<div class="form-group full_name">
														<label>{$core->get_Lang('Full Name')}</label>
														<input id="fullname_adult_{$tour_id_z}_{$idx}" name="fullname_adult_{$tour_id_z}_{$idx}" placeholder="" type="text" class="form-booking_input" value=""/>
													</div>
													<div class="form-group birthday birthday_2">
														<label>{$core->get_Lang('Date of Birth')}</label>
														<input type="hidden" class="birthday" id="birthday_adult_{$tour_id_z}_{$idx}">
													</div>
												</div>
											</div>
											{literal}
											<script>
												document.addEventListener("DOMContentLoaded", function () {
													$(function(){
														$("#birthday_adult_{/literal}{$tour_id_z}_{$idx}{literal}").dateDropdowns({
															submitFieldName: 'birthday_adult_{/literal}{$tour_id_z}_{$idx}{literal}',
															minAge: 16,
															defaultDate: '1980-01-01'
														});
													});
												});
											</script>
											{/literal}
											{/section}
											{if $number_child}
											{section name=i loop=$number_child}
											{assign var=idx value=$smarty.section.i.iteration}
											<div class="ItemAddit">
												<p class="text_bold">{$core->get_Lang('Children')} {$idx}</p>
												<div class="group-1 dp-flex">
													<div class="form-group">
														<label>{$core->get_Lang('Title')} <span style="color: red">*</span></label>
														<select id="title_child_{$tour_id_z}_{$idx}" name="title_child_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
															{$clsISO->makeSelectTitle($title)}
														</select>
													</div>
													<div class="form-group full_name">
														<label>{$core->get_Lang('Full Name')} <span style="color: red">*</span></label>
														<input id="fullname_child_{$tour_id_z}_{$idx}" name="fullname_child_{$tour_id_z}_{$idx}" placeholder="" type="text" class="form-booking_input" value="{$fullname}"/>
													</div>
													<div class="form-group birthday birthday_2">
														<label>{$core->get_Lang('Date of Birth')}</label>
														<input type="hidden" class="birthday" id="birthday_child_{$tour_id_z}_{$idx}">
													</div>
												</div>
											</div>
											{literal}
											<script>
												document.addEventListener("DOMContentLoaded", function () {
													$(function(){
														$("#birthday_child_{/literal}{$tour_id_z}_{$idx}{literal}").dateDropdowns({
															submitFieldName: 'birthday_child_{/literal}{$tour_id_z}_{$idx}{literal}',
															minAge: 6,
															maxAge: 15,
															defaultDate: '2010-01-01'
														});
													});
												});
											</script>
											{/literal}
											{/section}
											{/if}
											{if $number_infant}
											{section name=i loop=$number_infant}
											{assign var=idx value=$smarty.section.i.iteration}
											<div class="ItemAddit">
												<p class="text_bold">{$core->get_Lang('Infant')} {$idx}</p>
												<div class="group-1 dp-flex">
													<div class="form-group">
														<label>{$core->get_Lang('Title')} <span style="color: red">*</span></label>
														<select id="title_infant_{$tour_id_z}_{$idx}" name="title_infant_{$tour_id_z}_{$idx}" class="form-booking_input find_select">
															{$clsISO->makeSelectTitle($title)}
														</select>
													</div>
													<div class="form-group full_name">
														<label>{$core->get_Lang('Full Name')} <span style="color: red">*</span></label>
														<input id="fullname_infant_{$tour_id_z}_{$idx}" name="fullname_infant_{$tour_id_z}_{$idx}" placeholder="" type="text" class="form-booking_input" value="{$fullname}"/>
													</div>
													<div class="form-group birthday birthday_2">
														<label>{$core->get_Lang('Date of Birth')}</label>
														<input type="hidden" class="birthday" id="birthday_infant_{$tour_id_z}_{$idx}">
													</div>
												</div>
											</div>
											{literal}
											<script>
												document.addEventListener("DOMContentLoaded", function () {
													$(function(){
														$("#birthday_infant_{/literal}{$tour_id_z}_{$idx}{literal}").dateDropdowns({
															submitFieldName: 'birthday_infant_{/literal}{$tour_id_z}_{$idx}{literal}',
															maxAge: 4,
															defaultDate: '2019-01-01'
														});
													});
												});
											</script>
											{/literal}
											{/section}
											{/if}
										</div>
									</div>
								</div>
							</div>
							{/if}
							{/foreach}
							{/if}
						</div>
						<div class="billing_infomation mt20">
							{if $clsISO->getVar('PAYMENT_GLOBAL') eq '1'}
								{$core->getBlock('pay_gateway_new')}
							{/if}
						</div>
					</div>
					<div class="col-lg-4">
						<div class="col_right_fixed" id="sidebar">
							<div class="amount_due">
								<label class="size18">{$core->get_Lang('Amount due')}</label>
								<input type="hidden" name="price_total_book" id="price_total_book_post" value="{$totalGrand}" />
								{if $_LANG_ID eq 'vn'}
								<span class="right"><span id="price_total_book" class="size22 PriceFinal">{$clsISO->formatPrice($totalGrand)} {$clsISO->getShortRate()}</span></span>
								{else}
								<span class="right"><span id="price_total_book" class="size22 PriceFinal">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalGrand)}</span></span>
								{/if}
							</div>
							<div class="info_tour_book pd20_991">
							{$core->getBlock('cart_tour_pay_box')}
							{$core->getBlock('cart_voucher_pay_box')}
							{$core->getBlock('cart_cruise_pay_box')}
							{$core->getBlock('cart_hotel_pay_box')}
							</div>
							{$core->getBlock('cart_price_pay_box')}
							<div class="social_card">
								<p>{$core->get_Lang('We support via payment gateways')}:</p>
								<ul class="list_social_card">
									<li><img src="{$URL_IMAGES}/icon/payment.png" alt=""></li>
								</ul>
							</div>
							<div class="form-group clearfix col_right_bottom">
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
										<div id="error_recaptcha" class="error text_left"></div>
									{/if}
								</div> 
								<div class="btn-booking">
				                    <input type="hidden" name="totalFinal" class="totalFinal" value="{$totalPricePaymentNowFinal}">
                                    <input type="hidden" name="exchange_rate" id="exchange_rate" value="{$_EXCHANGE_RATE}" />
									<button class="btn-bookinggroup btn_main" type="submit">
										{$core->get_Lang('Payment')}
									</button>
									<input type="hidden" name="booking" value="booking">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
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
	var nd = '{$core->get_Lang("nd")}';
	var rd = '{$core->get_Lang("rd")}';
	var th = '{$core->get_Lang("th")}';
	var st = '{$core->get_Lang("st")}';
	var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
</script>
<script  src="{$URL_JS}/datepicker/jquery.date-dropdowns.js?v={$upd_version}" defer></script>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		function apply_promotion_code(_this){
			var promotion_code = $('#'+'promotion_code').val();
			var $_adata = {'promotion_code':promotion_code};
			$(_this).text('Loading...');
			$.post(path_ajax_script+'/index.php?mod=cart&act=get_promotion&lang='+LANG_ID, $_adata, function(html){
				$(_this).text('Áp dụng');
				var tmp = html.split('|||');
				if(html.indexOf('_success') >= 0){
					$('#discount__code-message').addClass('hidden');
					$('#discount__apply-result').removeClass('hidden').html(tmp[1]);
					$('.PriceFinal').html(tmp[2]);
					$('#price_total_book_post').val(tmp[3]);
					$('.totalFinal').val(tmp[3]);
				} else if(html.indexOf('_invalid') >= 0){
					$('#discount__code-message').removeClass('hidden').html(tmp[1]);
				} else if(html.indexOf('_empty') >= 0){
					$('#discount__code-message').removeClass('hidden').html(tmp[1]);
				}
			});
		}

		var $ww = $(window).width();
		$(document).ready(function(){
			var $heightFooter = $('.footer_2019').outerHeight();
			if($ww >992){
			$.lockfixed("#sidebar", {offset: {top: -170, bottom:84}});
			}
			$(".btn-bookinggroup").click(function(e){
				e.preventDefault();
				var $form_firstName = $("#fullname").val();
				var $form_lastName = $("#last_name").val();
				var $form_email = $("#email").val();
				var $form_phone = $("#telephone").val();
				if($("#fullname").val()==''){
					$("#fullname").focus();
					return false;
				}
				if($("#telephone").val()==''){
					$("#telephone").focus();
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
				if(grecaptcha.getResponse() == "") {
					$('#error_recaptcha').html(msg_recapcha).fadeIn().delay(3000).fadeOut();
					return false;
				}
				var allowSubmit = true;
				$('.ckh_contact_infor').each(function() {
					var $_this = $(this);
					var tour_id = $_this.data('tour_id');
					if($('input[name=contact_infor_'+tour_id+']:checked').val()==1){
						if($("#fullname_"+tour_id).val()==''){
							$("#fullname_"+tour_id).focus();
							e.preventDefault();
							return false;
						}
						if($("#telephone_"+tour_id).val()==''){
							$("#telephone_"+tour_id).focus();
							e.preventDefault();
							return false;
						}
						if($("#email_"+tour_id).val()==''){
							$("#email_"+tour_id).focus();
							e.preventDefault();
							return false;
						}
						if(checkValidEmail($("#email_"+tour_id).val())==false){
							$("#email").focus();
							return false;
						}
					}
				});

				// function ở vietiso.js
				checkSpamMail(".btn-bookinggroup");
				// return true;
			});
			$(document).on('click','.ckh_experience',function(){
				var $_this=$(this);
				var tour_id=$_this.data('tour_id');
				if($_this.val()==1){
					if($('input[name=contact_infor_'+tour_id+']:checked').val()==1){
						var title_name=$('#title_'+tour_id).val();
						var full_name=$('#fullname_'+tour_id).val();
						var birthday=$('#birthday_'+tour_id).val();
						var birthday_split = birthday.split('-');
					}else{
						var title_name=$('#title').val();
						var full_name=$('#fullname').val();
						var birthday=$('#birthday').val();
						var birthday_split = birthday.split('-');
					}
					$('#title_adult_'+tour_id+'_1').val(title_name);
					$('#fullname_adult_'+tour_id+'_1').val(full_name);
					$('#fullname_adult_'+tour_id+'_1').val(full_name);
					$('#birthday_adult_'+tour_id+'_1').val(birthday);
					$("select[name='birthday_adult_"+tour_id+"_1_[day]']").val(birthday_split[2]);
					$("select[name='birthday_adult_"+tour_id+"_1_[month]']").val(birthday_split[1]);
					$("select[name='birthday_adult_"+tour_id+"_1_[year]']").val(birthday_split[0]);
				}else{
					$('#title_adult_'+tour_id+'_1').val('Mr');
					$('#fullname_adult_'+tour_id+'_1').val('');
					$('#birthday_adult_'+tour_id+'_1').val('1980-01-01');
					$("select[name='birthday_adult_"+tour_id+"_1_[day]']").val('01');
					$("select[name='birthday_adult_"+tour_id+"_1_[month]']").val('01');
					$("select[name='birthday_adult_"+tour_id+"_1_[year]']").val('1980');
				}
			});
		});
		function loadTraveller(tour_id){
			var full_name=$('#fullname').val();
			var birthday=$('#birthday').val();
			var birthday_split = birthday.split('-');	
			$('#fullname_adult_'+tour_id+'_1').val(full_name);
			$('#birthday_adult_'+tour_id+'_1').val(birthday);
			$("select[name='birthday_adult_"+tour_id+"_1_[day]']").val(birthday_split[2]);
			$("select[name='birthday_adult_"+tour_id+"_1_[month]']").val(birthday_split[1]);
			$("select[name='birthday_adult_"+tour_id+"_1_[year]']").val(birthday_split[0]);
		}

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
	});
</script>
{/literal}
<script>
	var map_lo="";
	var map_la="";
	var map_zoom = '';
	var map_type = '';
</script>
{literal}
<style>
	.searchmap{ background:#E9EFF3; padding:10px; margin:10px 0 0;}
	.row-span .fieldlabel{width: 150px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
	.row-span .fieldarea{width: calc(100% - 150px);float:right;}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			initialize();
		});
		var geocoder=new google.maps.Geocoder();
		var map; 
		var marker;
		function $getID(id){
			return document.getElementById(id);
		}
		function geocode(position) {
			geocoder.geocode({
				latLng: position
			},function(responses) {
				$getID('map-search-input').value = responses[0].formatted_address;
				map.panTo(marker.getPosition());
			});
		}
		function initialize(){
			map_lo=map_lo!='' ? map_lo : '105.86727258378903'; 
			map_la=map_la!='' ? map_la : '20.988668210459167';
			if(map_zoom=='') map_zoom = 11;
			if(map_type=='') map_type = 'roadmap';
			var mapOptions = {
				center: new google.maps.LatLng(map_la,map_lo),
				zoom: parseInt(map_zoom),
				mapTypeId: map_type
			}; 
			map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions); 
			var input = document.getElementById('map-search-input'); 
			var autocomplete = new google.maps.places.Autocomplete(input); 
			autocomplete.bindTo('bounds', map); 
			var location = new google.maps.LatLng (map_la,map_lo); 
			marker = new google.maps.Marker({ position:location}); 
			marker.setMap(map); 
			marker.setDraggable(true); 
			google.maps.event.addListener(marker, "dragend", function(event){ 
				var point = marker.getPosition(); 
				map.panTo(point); 
				geocode(point);
			}); 
			/**/ 
			google.maps.event.addListener(autocomplete, 'place_changed', function(){
				var place = autocomplete.getPlace();
				if(place.geometry.viewport){ 
					map.fitBounds(place.geometry.viewport); 
				}else{
					map.setCenter(place.geometry.location); map.setZoom(11); 
				}
				geocode(place.geometry.location);
				marker.setPosition(place.geometry.location); 
			});

		}
		function findLocation(address){
			geocoder = new google.maps.Geocoder(); 
			geocoder.geocode({'address': address},function(results,status){
				if (status == google.maps.GeocoderStatus.OK) {
					marker.setPosition(results[0].geometry.location);
					geocode(results[0].geometry.location);
				} else {
					alert("Sorry but Google Maps could not find this location.");
				}
			});
		};
		$(function(){
			$(document).on('keydown', '#map-search-input', function(ev){
				var _this = $(this);
				var _code = ev.keyCode;
				if (_code === 13 && $.trim(_this.val()) != '') {
					findLocation(_this.val()); 
					return false;
				}
			});
			$('input[name=title]').click(function(){
				$('.tabchildcol a[href="#map"]').trigger('click');
			}).blur(function(){
				$('.tabchildcol.current').trigger('click');
				}).keydown(function(ev){
					var _this = $(this);
					var _code = ev.keyCode;
					if (_code === 13 && $.trim(_this.val()) != '') {
						findLocation(_this.val());
						return false;
					}
				});
				$(document).on('click','#map-search-input',function(){
					initialize();
				});
		});
	});
</script>
{/literal}